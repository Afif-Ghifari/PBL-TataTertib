<?php
include 'database.php';

$NIP = $_POST['NIP'];
$Nama = $_POST['Nama'];
$Alamat = $_POST['Alamat'];
$No_Tlp = $_POST['No_Tlp'];
$Profil = $_POST['Profil'];
$Username = $_POST['Username'];
$Pw = $_POST['Pw'];

$query = "UPDATE Dosen SET Nama = ?, Alamat = ?, No_Tlp = ?, Profil = ?, Username = ?, Pw = ? WHERE NIP = ?";
$params = array($Nama, $Alamat, $No_Tlp, $Profil, $Username, $Pw, $NIP);

$stmt = sqlsrv_prepare($conn, $query, $params);

if (!$stmt) {
    die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
}

if (!sqlsrv_execute($stmt)) {
    die("Query Execute Error: " . print_r(sqlsrv_errors(), true));
} else {
    echo"<script>alert('Berhasil mengubah data Dosen');window.history.back();</script>";
    
}
