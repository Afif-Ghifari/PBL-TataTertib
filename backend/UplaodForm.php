<?php
// Koneksi ke database
include "database.php";

// Proses penyimpanan data form laporan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaTerlapor = htmlspecialchars($_POST['NamaTerlapor']);
    $tanggal = htmlspecialchars($_POST['Tanggal']);
    $jenisPelanggaran = htmlspecialchars($_POST['JenisPelanggaran']);
    $bukti = $_FILES['bukti'];

    // Dapatkan ID_Terlapor berdasarkan NamaTerlapor
    $idTerlaporQuery = "
        SELECT NIM
        FROM [PelanggaranTataTertib].[dbo].[Mahasiswa]
        WHERE Nama = ?
    ";
    $stmtTerlapor = sqlsrv_query($conn, $idTerlaporQuery, array($namaTerlapor));

    if ($stmtTerlapor === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Ambil ID_Terlapor
    $idTerlapor = null;
    if ($row = sqlsrv_fetch_array($stmtTerlapor, SQLSRV_FETCH_ASSOC)) {
        $idTerlapor = $row['NIM'];
    } else {
        echo "Nama Terlapor tidak ditemukan!";
        exit;
    }

    // Simpan file bukti
    $uploadDir = "../../uploads/";
    $fileName = time() . "_" . basename($bukti["name"]);
    $uploadFilePath = $uploadDir . $fileName;

    if (move_uploaded_file($bukti["tmp_name"], $uploadFilePath)) {
        // Masukkan data ke tabel laporan
        $insertQuery = "
            INSERT INTO [PelanggaranTataTertib].[dbo].[Laporan] 
            (ID_Dilapor, ID_Pelanggaran, TanggalDibuat, Foto_Bukti, Status) 
            VALUES (?, ?, GETDATE(), ?, 'Pending')
        ";
        $params = [$idTerlapor, $jenisPelanggaran, $uploadFilePath];
        $stmt = sqlsrv_query($conn, $insertQuery, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        echo "Laporan berhasil ditambahkan!";
    } else {
        echo "Gagal mengunggah file bukti.";
    }
}

// Sintaks join untuk mendapatkan data tambahan (termasuk ID Mahasiswa)
$joinQuery = "
    SELECT 
        L.ID_Laporan,
        L.ID_Dilapor AS ID_Terlapor,
        M.Nama AS Nama_Terlapor,
        L.ID_Pelanggaran,
        PL.Nama_Pelanggaran
    FROM 
        [PelanggaranTataTertib].[dbo].[Laporan] L
    LEFT JOIN [PelanggaranTataTertib].[dbo].[Mahasiswa] M ON L.ID_Dilapor = M.NIM
    LEFT JOIN [PelanggaranTataTertib].[dbo].[Pelanggaran] PL ON L.ID_Pelanggaran = PL.ID_Pelanggaran

";

$stmtJoin = sqlsrv_query($conn, $joinQuery);

if ($stmtJoin === false) {
    die(print_r(sqlsrv_errors(), true));
}

header("Location: ../src/Dosen/Dashboard.php");

// Tutup koneksi
sqlsrv_close($conn);
?>
