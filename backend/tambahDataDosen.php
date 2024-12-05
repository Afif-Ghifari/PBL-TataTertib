<?php
    include 'database.php';

    $NIP = $_POST['NIP'];
    $Nama = $_POST['Nama'];
    $Alamat = $_POST['Alamat'];
    $No_Tlp = $_POST['No_Tlp'];
    $Profil = $_POST['Profil'];
    $Username = $_POST['Username'];
    $Pw = $_POST['Pw'];

    $query = "INSERT INTO Dosen (NIP, Nama, Alamat, No_Tlp, Profil, Username, Pw) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $params = array($NIP, $Nama, $Alamat, $No_Tlp, $Profil, $Username, $Pw);

    $stmt = sqlsrv_prepare($conn, $query, $params);

    if (!$stmt) {
        die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
    }

    if (!sqlsrv_execute($stmt)) {
        die("Query Execute Error: " . print_r(sqlsrv_errors(), true));
        echo"<script>alert('Gagal Menambahkan Dosen');location.href='../src/Admin/DataDosen.php';</script>";
    } else {
        echo"<script>alert('Berhasil Menambahkan Dosen');location.href='../src/Admin/DataDosen.php';</script>";
    }
?>