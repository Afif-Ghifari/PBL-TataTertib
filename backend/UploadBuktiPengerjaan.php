<?php
include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi input dari form
    if (isset($_POST['Deskripsi']) && isset($_FILES['bukti']) && isset($_POST['ID_Laporan'])) {
        $Deskripsi = htmlspecialchars($_POST['Deskripsi']);
        $bukti = $_FILES['bukti'];
        $ID_Bukti = time(); // Membuat ID_Bukti unik berdasarkan waktu
        $ID_Laporan = htmlspecialchars($_POST['ID_Laporan']);

        // Tentukan direktori penyimpanan file bukti
        $uploadDir = "UploadBuktiPengerjaan/";
        $fileName = time() . "_" . basename($bukti["name"]);
        $uploadFilePath = $uploadDir . $fileName;

        // Pastikan direktori upload ada
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Buat direktori jika belum ada
        }

        // Pindahkan file ke direktori tujuan
        if (move_uploaded_file($bukti["tmp_name"], $uploadFilePath)) {
            // Simpan data ke tabel Bukti_Pengerjaan
            $insertBuktiQuery = "
                INSERT INTO Bukti_Pengerjaan 
                (ID_Bukti, Foto, Deskripsi) 
                VALUES (?, ?, ?)";
            $buktiParams = [$ID_Bukti, $uploadFilePath, $Deskripsi];
            $buktiStmt = sqlsrv_query($conn, $insertBuktiQuery, $buktiParams);

            if ($buktiStmt === false) {
                die("Gagal menyimpan bukti pengerjaan ke database: " . print_r(sqlsrv_errors(), true));
            }

            // Perbarui tabel Laporan dengan ID_Bukti
            $updateLaporanQuery = "
                UPDATE Laporan
                SET ID_Bukti = ?
                WHERE ID_Laporan = ?";
            $laporanParams = [$ID_Bukti, $ID_Laporan];
            $laporanStmt = sqlsrv_query($conn, $updateLaporanQuery, $laporanParams);

            if ($laporanStmt === false) {
                die("Gagal memperbarui ID_Bukti pada tabel Laporan: " . print_r(sqlsrv_errors(), true));
            }

            // Jika semua berhasil
            echo "Laporan pengerjaan berhasil diunggah!";
            // exit;
            header("Location: ../src/Mahasiswa/HistoriPelanggaran.php"); // Redirect setelah sukses
        } else {
            echo "Gagal mengunggah file bukti. Periksa izin direktori atau coba lagi.";
        }
    } else {
        echo "Deskripsi, file bukti, atau ID Laporan tidak ditemukan. Silakan coba lagi.";
    }
} else {
    echo "Metode HTTP tidak valid. Gunakan metode POST.";
}
?>
