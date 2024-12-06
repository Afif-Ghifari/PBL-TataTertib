<?php
include_once 'database.php'; // Pastikan file koneksi database benar
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Mulai transaksi
        $conn->beginTransaction();

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
        $sqlTerlapor = "SELECT NIM FROM Mahasiswa WHERE Nama = ?";
        $stmtTerlapor = $conn->prepare($sqlTerlapor);
        $stmtTerlapor->execute([$namaTerlapor]);
        $terlaporData = $stmtTerlapor->fetch(PDO::FETCH_ASSOC);

        if (!$terlaporData) {
            throw new Exception("Nama terlapor tidak ditemukan di database.");
        }
        $idDilapor = $terlaporData['ID_Dilapor'];

        // Validasi nama admin di database
        $sqlAdmin = "SELECT ID_Admin FROM Admin WHERE Nama = ?";
        $stmtAdmin = $conn->prepare($sqlAdmin);
        $stmtAdmin->execute([$admin]);
        $adminData = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

        if (!$adminData) {
            throw new Exception("Nama admin tidak ditemukan di database.");
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
            $uploadDir = './uploads/'; // Sesuaikan direktori penyimpanan file
            $uploadPath = $uploadDir . basename($fileName);

            // Pindahkan file yang diunggah
            if (!move_uploaded_file($fileTmpName, $uploadPath)) {
                throw new Exception("Gagal mengunggah file bukti.");
            }

            // Simpan informasi file di database
            $sqlBukti = "INSERT INTO Bukti_Pengerjaan (Foto, Deskripsi) VALUES (?, ?)";
            $stmtBukti = $conn->prepare($sqlBukti);
            $stmtBukti->execute([$fileName, $deskripsi]);

            $idBukti = $conn->lastInsertId();
        }

        // Simpan laporan ke tabel Laporan
        $sqlLaporan = "INSERT INTO Laporan (ID_Pelapor, ID_Dilapor, ID_Admin, ID_Pelanggaran, Status, Sanksi, TanggalDibuat, ID_Bukti, Foto_Bukti)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtLaporan = $conn->prepare($sqlLaporan);

        $status = 'Pending';
        $sanksi = null;

        $stmtLaporan->execute([
            $idPelapor,
            $idDilapor,
            $idAdmin,
            $jenisPelanggaran,
            $status,
            $sanksi,
            $tanggal,
            $idBukti,
            $fileName
        ]);

        // Commit transaksi
        $conn->commit();

        // Redirect dengan notifikasi sukses
        header("Location: ../src/Admin/Dosen/Dashboard.php?success=1");
        exit;
    } catch (Exception $e) {
        $conn->rollBack();
        die("Gagal menyimpan laporan: " . $e->getMessage());
    }
} else {
    die("Metode request tidak valid.");
}
?>
