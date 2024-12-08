<?php
include_once 'database.php'; // Pastikan file koneksi database benar
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validasi session (Pastikan Dosen yang login)
        if (!isset($_SESSION['ID']) || !isset($_SESSION['Role']) || $_SESSION['Role'] !== 'Dosen') {
            throw new Exception("Error: Anda harus login sebagai Dosen terlebih dahulu.");
        }
        
        // ID Pelapor adalah Dosen yang login
        $idPelapor = $_SESSION['ID'];

        // Validasi koneksi database
        if (!$conn || !is_resource($conn)) {
            throw new Exception("Koneksi database tidak valid.");
        }

        // Ambil data dari form
        $namaTerlapor = trim($_POST['NamaTerlapor']);
        $tanggal = trim($_POST['Tanggal']);
        $jenisPelanggaran = trim($_POST['JenisPelanggaran']);
        $fileName = null;

        // Validasi data kosong
        if (empty($namaTerlapor) || empty($tanggal) || empty($jenisPelanggaran)) {
            throw new Exception("Semua kolom wajib diisi.");
        }

        // Validasi nama terlapor (Mahasiswa) di database
        $sqlTerlapor = "SELECT NIM AS ID FROM Mahasiswa WHERE Nama = ?";
        $stmtTerlapor = sqlsrv_prepare($conn, $sqlTerlapor, [$namaTerlapor]);

        if (!$stmtTerlapor) {
            throw new Exception("Gagal mempersiapkan query: " . print_r(sqlsrv_errors(), true));
        }

        if (!sqlsrv_execute($stmtTerlapor)) {
            throw new Exception("Gagal mengeksekusi query: " . print_r(sqlsrv_errors(), true));
        }

        $terlaporData = sqlsrv_fetch_array($stmtTerlapor, SQLSRV_FETCH_ASSOC);
        if (!$terlaporData) {
            throw new Exception("Nama terlapor tidak ditemukan di database.");
        }
        $idDilapor = $terlaporData['ID'];

        // Proses file bukti jika ada
        if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] === UPLOAD_ERR_OK) {
            $fileName = $_FILES['bukti']['name'];
            $fileTmpName = $_FILES['bukti']['tmp_name'];

            // Validasi ekstensi file
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (!in_array($fileExtension, $allowedExtensions)) {
                throw new Exception("Ekstensi file tidak diizinkan. Hanya file JPG, JPEG, PNG, dan PDF yang diperbolehkan.");
            }

            // Path upload directory
            $uploadDir = __DIR__ . '/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Buat direktori jika belum ada
            }

            $uploadPath = $uploadDir . basename($fileName);

            // Pindahkan file yang diunggah
            if (!move_uploaded_file($fileTmpName, $uploadPath)) {
                throw new Exception("Gagal mengunggah file bukti.");
            }
        }

        // Simpan laporan ke tabel Laporan
        $sqlLaporan = "INSERT INTO Laporan (ID_Pelapor, ID_Dilapor, TanggalDibuat, ID_Pelanggaran, Foto_Bukti)
                        VALUES (?, ?, ?, ?, ?)";
        $params = [$idPelapor, $idDilapor, $tanggal, $jenisPelanggaran, $fileName];
        $stmtLaporan = sqlsrv_prepare($conn, $sqlLaporan, $params);

        if (!$stmtLaporan || !sqlsrv_execute($stmtLaporan)) {
            throw new Exception("Gagal menyimpan laporan: " . print_r(sqlsrv_errors(), true));
        }

        // Redirect dengan notifikasi sukses
        header("Location: ../src/Admin/Dosen/Dashboard.php?success=1");
        exit;
    } catch (Exception $e) {
        die("Gagal menyimpan laporan: " . $e->getMessage());
    }
} else {
    die("Metode request tidak valid.");
}
?>
