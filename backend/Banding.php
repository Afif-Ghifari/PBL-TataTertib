<?php
// Koneksi ke database
include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitasi input
    $keterangan = htmlspecialchars($_POST['Keterangan']);
    $id_laporan = htmlspecialchars($_POST['ID_Laporan']); // Ambil ID_Laporan dari input form
    $nim = htmlspecialchars($_POST['NIM']); // Ambil NIM dari input form

    // Validasi input
    if (empty($keterangan) || empty($id_laporan) || empty($nim)) {
        echo "Keterangan, ID Laporan, dan NIM tidak boleh kosong.";
        exit;
    }

    // Generate ID_Banding (misalnya menggunakan timestamp sebagai ID unik)
    $id_banding = time();

    // Masukkan data ke tabel Banding
    $insertQuery = "
        INSERT INTO Banding 
        (ID_Banding, ID_Laporan, NIM, Keterangan) 
        VALUES (?, ?, ?, ?)
    ";
    $params = [$id_banding, $id_laporan, $nim, $keterangan];

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $insertQuery, $params);

    if ($stmt === false) {
        // Tampilkan error SQL Server jika terjadi kegagalan
        die(print_r(sqlsrv_errors(), true));
    }

    // Jika berhasil
    echo "Banding telah diunggah.";
    header("Location: ../src/Mahasiswa/Dashboard.php");
    exit;
} else {
    echo "Metode permintaan tidak valid.";
}
?>
