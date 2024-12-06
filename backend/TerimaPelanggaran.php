<?php
include 'database.php'; 

$Nama_Terlapor = $_POST['NamaTerlapor'];
$NIM_Terlapor = $_POST['NIM'];
$Nama_Pelapor = $_POST['NamaPelapor'];
$NIP_Pelapor = $_POST['NIP'];
$Tempat_Kejadian = $_POST['Tempat'];
$Tanggal_Kejadian = $_POST['Tanggal'];
$Jenis_Pelanggaran = $_POST['JenisPelanggaran'];
$Tingkat_Pelanggaran = $_POST['TingkatPelanggaran'];
$Deskripsi = $_POST['Deskripsi'];

$query = "INSERT INTO Pelanggaran (Nama_Terlapor, NIM_Terlapor, Nama_Pelapor, NIP_Pelapor, Tempat_Kejadian, Tanggal_Kejadian, Jenis_Pelanggaran, Tingkat_Pelanggaran, Deskripsi) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$params = array($Nama_Terlapor, $NIM_Terlapor, $Nama_Pelapor, $NIP_Pelapor, $Tempat_Kejadian, $Tanggal_Kejadian, $Jenis_Pelanggaran, $Tingkat_Pelanggaran, $Deskripsi);

$stmt = sqlsrv_prepare($conn, $query, $params);
if (!$stmt) {
    die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
}

if (!sqlsrv_execute($stmt)) {
    echo "<script>alert('Gagal menerima pelanggaran');location.href='../src/Admin/DataPelanggaran.php';</script>";
} else {
    echo "<script>alert('Pelanggaran berhasil diterima');location.href='../src/Admin/DataPelanggaran.php';</script>";
}
?>
