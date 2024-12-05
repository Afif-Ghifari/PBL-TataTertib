<?php
    include 'database.php';

    $NIM = [$_GET['NIM']];

    $query = "DELETE FROM Mahasiswa WHERE NIM = ?";
    $params = $NIM;

    $stmt = sqlsrv_prepare($conn, $query, $params);

    if (!$stmt) {
        die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
    }

    if (!sqlsrv_execute($stmt)) {
        echo"<script>alert('Gagal hapus Mahasiswa');location.href='../src/Admin/DataMahasiswa.php';</script>";
    } else {
        echo"<script>alert('Berhasil hapus Mahasiswa');location.href='../src/Admin/DataMahasiswa.php';</script>";
    }
?>