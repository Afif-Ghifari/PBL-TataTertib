<?php
    // Informasi koneksi
    $serverName = "DESKTOP-5O8DG63"; // Nama server SQL Server
    $database = "PelanggaranTataTertib"; // Nama database
    $username = "sa"; // Username SQL Server
    $password = "123"; // Password SQL Server

    // Array informasi koneksi
    $connInfo = array(
        "Database" => $database,
        "UID" => $username,
        "PWD" => $password
    );

    // Membuat koneksi ke SQL Server
    $conn = sqlsrv_connect($serverName, $connInfo);

    // Cek koneksi
    if ($conn) {
        echo "Koneksi berhasil.<br />";
    } else {
        echo "Koneksi gagal.<br />";
        die(print_r(sqlsrv_errors(), true));
    }
?>
