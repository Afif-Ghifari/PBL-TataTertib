<?php
include_once 'database.php'; // Pastikan koneksi database sudah benar
session_start();

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $namaTerlapor = $_POST['NamaTerlapor'];
    $tempat = $_POST['Tempat'];
    $tanggal = $_POST['Tanggal'];
    $jenisPelanggaran = $_POST['JenisPelanggaran'];
    $deskripsi = $_POST['Deskripsi'];

    // Ambil ID pelapor dari session
    $idPelapor = $_SESSION['ID']; // Pastikan ID diset saat login

    // Direktori tujuan untuk menyimpan file bukti
    $uploadDir = 'D:/kuliah/smt3/Desain_pemograman_web/laragon/www/PBL/PBL-TataTertib/backend/UploadButkiPelanggaran/'; // Ganti dengan path absolut

    // Cek jika direktori tidak ada, buat direktori
    if (!file_exists($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {  // Membuat direktori jika belum ada
            die("Gagal membuat direktori untuk mengunggah file.");
        }
    }

    // Nama file yang diunggah
    $fileName = basename($_FILES['bukti']['name']);
    $uploadPath = $uploadDir . $fileName;

    // Pindahkan file yang diunggah ke direktori tujuan
    if (move_uploaded_file($_FILES['bukti']['tmp_name'], $uploadPath)) {
        echo "File berhasil diunggah.";

        // Masukkan data laporan ke database
        $sql = "INSERT INTO Laporan (ID_Pelapor, Nama_Terlapor, Tempat, Tanggal, Jenis_Pelanggaran, Deskripsi, Bukti) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $params = [
            $idPelapor, 
            $namaTerlapor, 
            $tempat, 
            $tanggal, 
            $jenisPelanggaran, 
            $deskripsi, 
            $fileName // Hanya menyimpan nama file, path absolut tidak perlu disimpan
        ];

        // Menyiapkan dan mengeksekusi query
        $stmt = sqlsrv_prepare($conn, $sql, $params);
        if (!$stmt) {
            die("Query preparation failed: " . print_r(sqlsrv_errors(), true));
        }
        if (sqlsrv_execute($stmt)) {
            echo "Laporan berhasil disimpan.";
        } else {
            echo "Gagal menyimpan laporan: " . print_r(sqlsrv_errors(), true);
        }
    } else {
        echo "Gagal mengunggah file bukti.";
    }
}
?>
