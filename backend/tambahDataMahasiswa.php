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

    $query = "INSERT INTO Mahasiswa (NIM, Nama, Alamat, No_Tlp, ID_Kelas, Profil, Username, Pw) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $params = array($NIM, $Nama, $Alamat, $No_Tlp, $ID_Kelas, $Profil, $Username, $Pw);

    $stmt = sqlsrv_prepare($conn, $query, $params);

    if (!$stmt) {
        die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
    }

    if (!sqlsrv_execute($stmt)) {
        die("Query Execute Error: " . print_r(sqlsrv_errors(), true));
    } else {
        echo '<script type="text/javascript">';
        echo '</script>';
        header("Location: ../src/Admin/DataMahasiswa.php");
    }
?>