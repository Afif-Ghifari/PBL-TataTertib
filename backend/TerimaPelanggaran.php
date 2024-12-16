<?php
include 'database.php'; 

// Update
$IDLaporan = $_POST['ID_Laporan'];
$IDPelapor = $_POST['ID_Pelapor'];
$IDDilapor = $_POST['ID_Dilapor'];
$IDAdmin = $_POST['ID_Admin'];
$IDPelanggaran = $_POST['ID_Pelanggaran'];
$Status = $_POST['Status'];
$Sanksi = $_POST['Sanksi'];
// $IDBukti = $_POST['ID_Bukti'];
$TanggalDibuat = $_POST['TanggalDibuat'];

$query = "UPDATE Laporan 
  SET ID_Pelapor = ?, 
      ID_Dilapor = ?, 
      ID_Admin = ?, 
      ID_Pelanggaran = ?, 
      Status = ?, 
      Sanksi = ?, 
      -- ID_Bukti = ?, 
      TanggalDibuat = ?,
      TanggalDiupdate = GETDATE() 
  WHERE ID_Laporan = ?";
$params = array($IDPelapor, $IDDilapor, $IDAdmin, $IDPelanggaran, $Status, $Sanksi, $TanggalDibuat, $IDLaporan); // $IDBukti,


$stmt = sqlsrv_prepare($conn, $query, $params);
if (!$stmt) {
die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
}

if (!sqlsrv_execute($stmt)) {
echo "<script>alert('Operasi gagal');window.history.back();</script>";
} else {
echo "<script>alert('Operasi berhasil');window.history.back();</script>";
}
?>
