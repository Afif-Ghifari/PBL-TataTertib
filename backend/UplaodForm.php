<?php
include_once './database.php'; // Pastikan file koneksi database benar
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Periksa koneksi database
        if (!$conn) {
            throw new Exception("Koneksi database gagal: " . print_r(sqlsrv_errors(), true));
        }

        // Mulai transaksi
        if (!sqlsrv_begin_transaction($conn)) {
            throw new Exception("Gagal memulai transaksi: " . print_r(sqlsrv_errors(), true));
        }

        // Ambil data dari form
        $namaTerlapor = $_POST['NamaTerlapor'];
        $admin = $_POST['Admin'];
        $tempat = $_POST['Tempat'];
        $tanggal = $_POST['Tanggal'];
        $jenisPelanggaran = $_POST['JenisPelanggaran'];
        $deskripsi = $_POST['Deskripsi'];

        // Validasi data kosong
        if (empty($namaTerlapor) || empty($admin) || empty($tempat) || empty($tanggal) || empty($jenisPelanggaran) || empty($deskripsi)) {
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
            throw new Exception("Nama terlapor tidak ditemukan di database.");
        }
        $idDilapor = $terlaporData['ID_Dilapor'];

        // Validasi ID_Admin yang dipilih
        $sqlAdmin = "SELECT ID_Admin FROM Admin WHERE ID_Admin = ?";
        $stmtAdmin = sqlsrv_prepare($conn, $sqlAdmin, [$admin]);
        if (!$stmtAdmin || !sqlsrv_execute($stmtAdmin)) {
            throw new Exception("Gagal mengeksekusi query admin: " . print_r(sqlsrv_errors(), true));
        }
        $adminData = sqlsrv_fetch_array($stmtAdmin, SQLSRV_FETCH_ASSOC);

        if (!$adminData) {
            throw new Exception("Admin tidak ditemukan di database. Pastikan ID admin yang dipilih benar.");
        }
        $idAdmin = $adminData['ID_Admin'];

        // ID pelapor dari session
        $idPelapor = $_SESSION['ID'];

        // Proses file bukti jika ada
        $idBukti = null;
        $fileName = null;
        if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] == 0) {
            $fileName = $_FILES['bukti']['name'];
            $fileTmpName = $_FILES['bukti']['tmp_name'];
            $uploadDir = './uploads/';
            $uploadPath = $uploadDir . basename($fileName);

            // Pindahkan file yang diunggah
            if (!move_uploaded_file($fileTmpName, $uploadPath)) {
                throw new Exception("Gagal mengunggah file bukti.");
            }

            // Simpan informasi file di database
            $sqlBukti = "INSERT INTO Bukti_Pengerjaan (Foto, Deskripsi) VALUES (?, ?)";
            $paramsBukti = [$fileName, $deskripsi];
            $stmtBukti = sqlsrv_prepare($conn, $sqlBukti, $paramsBukti);
            if (!$stmtBukti || !sqlsrv_execute($stmtBukti)) {
                throw new Exception("Gagal menyimpan bukti: " . print_r(sqlsrv_errors(), true));
            }

            $idBuktiQuery = "SELECT SCOPE_IDENTITY() AS ID";
            $stmtBuktiID = sqlsrv_query($conn, $idBuktiQuery);
            $idBuktiResult = sqlsrv_fetch_array($stmtBuktiID, SQLSRV_FETCH_ASSOC);
            $idBukti = $idBuktiResult['ID'];
        }

        // Simpan laporan ke tabel Laporan
        $sqlLaporan = "INSERT INTO Laporan (ID_Pelapor, ID_Dilapor, ID_Admin, ID_Pelanggaran, Status, Sanksi, TanggalDibuat, ID_Bukti, Foto_Bukti)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $status = 'Pending';
        $sanksi = null;
        $paramsLaporan = [
            $idPelapor,
            $idDilapor,
            $idAdmin,
            $jenisPelanggaran,
            $status,
            $sanksi,
            $tanggal,
            $idBukti,
            $fileName
        ];
        $stmtLaporan = sqlsrv_prepare($conn, $sqlLaporan, $paramsLaporan);
        if (!$stmtLaporan || !sqlsrv_execute($stmtLaporan)) {
            throw new Exception("Gagal menyimpan laporan: " . print_r(sqlsrv_errors(), true));
        }

        // Commit transaksi
        if (!sqlsrv_commit($conn)) {
            throw new Exception("Gagal melakukan commit transaksi.");
        }

        // Redirect dengan notifikasi sukses
        header("Location: ../src/Admin/Dosen/Dashboard.php?success=1");
        exit;
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        sqlsrv_rollback($conn);
        die("Gagal menyimpan laporan: " . $e->getMessage());
    }
} else {
    die("Metode request tidak valid.");
}
?>
