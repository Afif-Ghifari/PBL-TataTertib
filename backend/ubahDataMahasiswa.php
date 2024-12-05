<?php
include 'database.php';

$NIM = $_POST['NIM'];
$Nama = $_POST['Nama'];
$Alamat = $_POST['Alamat'];
$No_Tlp = $_POST['No_Tlp'];
$ID_Kelas = $_POST['ID_Kelas'];
$Profil = $_POST['Profil'];
$Username = $_POST['Username'];
$Pw = $_POST['Pw'];

$query = "UPDATE Mahasiswa SET Nama = ?, Alamat = ?, No_Tlp = ?, ID_Kelas = ?, Profil = ?, Username = ?, Pw = ? WHERE NIM = ?";
$params = array($Nama, $Alamat, $No_Tlp, $ID_Kelas, $Profil, $Username, $Pw, $NIM);

$stmt = sqlsrv_prepare($conn, $query, $params);

if (!$stmt) {
    die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
}

if (!sqlsrv_execute($stmt)) {
    die("Query Execute Error: " . print_r(sqlsrv_errors(), true));
} else {
    echo '<script type="text/javascript">';
    echo 'alert("Terjadi kesalahan");';
    echo '</script>';
    header("Location: ../src/Mahasiswa/Profile.php");
}
