<?php
include 'database.php'; 

// Update
$IDLaporan = $_POST['ID_Laporan'];
$IDPelapor = $_POST['ID_Pelapor'];
$IDAdmin = $_POST['ID_Admin'];
$IDPelanggaran = $_POST['ID_Pelanggaran'];
$Status = $_POST['Status'];
$Sanksi = $_POST['Sanksi'];
$IDBukti = $_POST['ID_Bukti'];
$TanggalDibuat = date('Y-m-d H:i:s');

$query = "UPDATE Laporan 
  SET ID_Pelapor = ?, 
      ID_Admin = ?, 
      ID_Pelanggaran = ?, 
      Status = ?, 
      Sanksi = ?, 
      ID_Bukti = ?, 
      TanggalDibuat = ?,
      TanggalDiupdate = GETDATE() 
  WHERE ID_Laporan = ?";
$params = array($IDPelapor, $IDAdmin, $IDPelanggaran, $Status, $Sanksi, $IDBukti, $TanggalDibuat, $IDLaporan);


$stmt = sqlsrv_prepare($conn, $query, $params);
if (!$stmt) {
die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
}

if (!sqlsrv_execute($stmt)) {
echo "<script>alert('Operasi gagal');location.href='../src/Admin/DataLaporan.php';</script>";
} else {
echo "<script>alert('Operasi berhasil');location.href='../src/Admin/DataLaporan.php';</script>";
}
?>
