<?php
include_once './database.php'; // Pastikan file koneksi database benar
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Pastikan user login
        if (!isset($_SESSION['ID'])) {
            die("Anda harus login terlebih dahulu.");
        }

        // Periksa koneksi database
        if (!$conn) {
            throw new Exception("Koneksi database gagal: " . print_r(sqlsrv_errors(), true));
        }

        // Ambil data dari form
        $idPelapor = $_SESSION['ID'];
        $namaTerlapor = trim($_POST['NamaTerlapor']);
        $tempat = trim($_POST['Tempat']);
        $tanggal = trim($_POST['Tanggal']);
        $jenisPelanggaran = trim($_POST['JenisPelanggaran']);
        $deskripsi = trim($_POST['Deskripsi']);

        // Validasi input
        if (empty($namaTerlapor) || empty($tempat) || empty($tanggal) || empty($jenisPelanggaran) || empty($deskripsi)) {
            throw new Exception("Semua kolom wajib diisi.");
        }

        // Validasi nama terlapor di database
        $sqlTerlapor = "SELECT NIM AS ID_Dilapor FROM Mahasiswa WHERE Nama = ?";
        $stmtTerlapor = sqlsrv_prepare($conn, $sqlTerlapor, [$namaTerlapor]);
        if (!$stmtTerlapor || !sqlsrv_execute($stmtTerlapor)) {
            throw new Exception("Gagal mengeksekusi query terlapor: " . print_r(sqlsrv_errors(), true));
        }
        $terlaporData = sqlsrv_fetch_array($stmtTerlapor, SQLSRV_FETCH_ASSOC);
        if (!$terlaporData) {
            throw new Exception("Nama terlapor tidak ditemukan.");
        }
        $idDilapor = $terlaporData['ID_Dilapor'];

        // Proses file bukti jika ada
        $fileName = null;
        if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] == 0) {
            $fileName = time() . "_" . basename($_FILES['bukti']['name']); // Tambahkan timestamp untuk unik
            $uploadDir = 'UploadBuktiPelanggaran';
            $uploadPath = $uploadDir . $fileName;

            // Buat folder jika belum ada
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            if (!move_uploaded_file($_FILES['bukti']['tmp_name'], $uploadPath)) {
                throw new Exception("Gagal mengunggah file bukti.");
            }
        }

        // Simpan laporan
        $sqlLaporan = "INSERT INTO Laporan (ID_Pelapor, ID_Dilapor, ID_Pelanggaran, Status, Sanksi, TanggalDibuat, Foto_Bukti)
                       VALUES (?, ?, ?, ?, ?, ?, ?)";
        $paramsLaporan = [$idPelapor, $idDilapor, $jenisPelanggaran, 'Pending', null, $tanggal, $fileName];
        $stmtLaporan = sqlsrv_prepare($conn, $sqlLaporan, $paramsLaporan);

        if (!$stmtLaporan || !sqlsrv_execute($stmtLaporan)) {
            throw new Exception("Gagal menyimpan laporan: " . print_r(sqlsrv_errors(), true));
        }

        // Redirect dengan notifikasi sukses
        header("Location: ../src/Admin/Dosen/Dashboard.php?success=1");
        exit;
    } catch (Exception $e) {
        die("Gagal menyimpan laporan: " . $e->getMessage());
    }
}
?>
