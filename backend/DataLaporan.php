<?php
include 'database.php';

$action = $_GET['action'] ?? 'read';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create and Update
    if ($action === 'create') {
        $NamaTerlapor = $_POST['NamaTerlapor'];
        $NIMTerlapor = $_POST['NIMTerlapor'];
        $NamaPelapor = $_POST['NamaPelapor'];
        $NIPPelapor = $_POST['NIPPelapor'];
        $Tempat = $_POST['Tempat'];
        $Tanggal = $_POST['Tanggal'];
        $JenisPelanggaran = $_POST['JenisPelanggaran'];
        $TingkatPelanggaran = $_POST['TingkatPelanggaran'];
        $Deskripsi = $_POST['Deskripsi'];

        $query = "INSERT INTO Laporan (Nama_Terlapor, NIM_Terlapor, Nama_Pelapor, NIP_Pelapor, Tempat_Kejadian, Tanggal_Kejadian, Jenis_Pelanggaran, Tingkat_Pelanggaran, Deskripsi) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = array($NamaTerlapor, $NIMTerlapor, $NamaPelapor, $NIPPelapor, $Tempat, $Tanggal, $JenisPelanggaran, $TingkatPelanggaran, $Deskripsi);
    } elseif ($action === 'update') {
        $IDPelanggaran = $_POST['IDPelanggaran'];
        $Status = $_POST['Status'];

        $query = "UPDATE Laporan SET Status = ? WHERE ID_Pelanggaran = ?";
        $params = array($Status, $IDPelanggaran);
    }

    $stmt = sqlsrv_prepare($conn, $query, $params);
    if (!$stmt) {
        die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
    }

    if (!sqlsrv_execute($stmt)) {
        echo "<script>alert('Operasi gagal');location.href='../src/Admin/DataPelanggaran.php';</script>";
    } else {
        echo "<script>alert('Operasi berhasil');location.href='../src/Admin/DataPelanggaran.php';</script>";
    }
} elseif ($action === 'delete' && isset($_GET['ID'])) {
    // Delete
    $IDPelanggaran = $_GET['ID'];

    $query = "DELETE FROM Laporan WHERE ID_Pelanggaran = ?";
    $params = array($IDPelanggaran);

    $stmt = sqlsrv_prepare($conn, $query, $params);
    if (!$stmt) {
        die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
    }

    if (!sqlsrv_execute($stmt)) {
        echo "<script>alert('Gagal menghapus laporan');location.href='../src/Admin/DataPelanggaran.php';</script>";
    } else {
        echo "<script>alert('Laporan berhasil dihapus');location.href='../src/Admin/DataPelanggaran.php';</script>";
    }
} else {
    // Read
    $qry_mahasiswa = "SELECT l.ID_Pelanggaran, 
                            d.NIP, 
                            d.Nama as NamaDosen,
                            m.NIM,
                            m.Nama as NamaMahasiswa,
                            p.ID_Pelanggaran,
                            p.Nama_Pelanggaran,
                            l.Sanksi,
                            l.Status 
                      FROM Laporan l
                      JOIN Pelanggaran p ON l.ID_Pelanggaran = p.ID_Pelanggaran
                      JOIN Dosen d ON l.ID_Pelapor = d.NIP
                      JOIN Mahasiswa m ON l.ID_Dilapor = m.NIM";

    $stmt = sqlsrv_query($conn, $qry_mahasiswa);

    if (!$stmt) {
        die("Query Execute Error: " . print_r(sqlsrv_errors(), true));
    }
}
?>