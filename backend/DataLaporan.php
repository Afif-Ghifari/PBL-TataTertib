<?php
include 'database.php';

$action = $_GET['action'] ?? 'read';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'create') {
        // Create
        $IDPelapor = $_POST['IDPelapor'];
        $IDAdmin = $_POST['IDAdmin'];
        $IDPelanggaran = $_POST['IDPelanggaran'];
        $Status = $_POST['Status'];
        $Sanksi = $_POST['Sanksi'];
        $IDBukti = $_POST['IDBukti'];
        $TanggalDibuat = date('Y-m-d H:i:s'); 

        $query = "INSERT INTO Laporan (ID_Pelapor, ID_Admin, ID_Pelanggaran, Status, Sanksi, ID_Bukti, TanggalDibuat) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = array($IDPelapor, $IDAdmin, $IDPelanggaran, $Status, $Sanksi, $IDBukti, $TanggalDibuat);
    } elseif ($action === 'update') {
        // Update
        $ID_Laporan = $_POST['ID_Laporan'];
        $Status = $_POST['Status'];
        $Sanksi = $_POST['Sanksi'];
        $TanggalDiupdate = date('Y-m-d H:i:s'); 

        $query = "UPDATE Laporan SET Status = ?, Sanksi = ?, TanggalDiupdate = ? WHERE ID_Laporan = ?";
        $params = array($Status, $Sanksi, $TanggalDiupdate, $ID_Laporan);
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
} else {
    // Read
    $qry_laporan = "SELECT l.ID_Laporan, 
                           l.ID_Pelapor, 
                           l.ID_Admin, 
                           l.ID_Pelanggaran, 
                           l.Status, 
                           l.Sanksi, 
                           l.ID_Bukti, 
                           l.TanggalDibuat, 
                           l.TanggalDiupdate 
                    FROM Laporan l";

    $stmt = sqlsrv_query($conn, $qry_laporan);

    if (!$stmt) {
        die("Query Execute Error: " . print_r(sqlsrv_errors(), true));
    }

}
?>
