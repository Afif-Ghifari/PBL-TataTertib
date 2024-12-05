<?php
    try {
    $serverName = "DESKTOP-5O8DG63"; // Nama server SQL Server
    $database = "PelanggaranTataTertib"; // Nama database
    $username = "sa"; // Username SQL Server
    $password = "123"; // Password SQL Server

    // Koneksi menggunakan PDO dengan driver sqlsrv
    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);

    // Mengatur mode error agar menampilkan exception jika terjadi kesalahan
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Koneksi berhasil.";
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>
