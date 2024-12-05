<?php
    include 'database.php';

    $NIP = [$_GET['NIP']];

    $query = "DELETE FROM dosen WHERE NIP = ?";
    $params = $NIP;

    $stmt = sqlsrv_prepare($conn, $query, $params);

    if (!$stmt) {
        die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
    }

    if (!sqlsrv_execute($stmt)) {
        echo"<script>alert('Gagal hapus dosen');location.href='../src/Admin/Datadosen.php';</script>";
    } else {
        echo"<script>alert('Berhasil hapus dosen');location.href='../src/Admin/Datadosen.php';</script>";
    }
?>