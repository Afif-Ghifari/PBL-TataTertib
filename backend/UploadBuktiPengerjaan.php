<?php
include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi input dari form
    if (isset($_POST['Deskripsi']) && isset($_FILES['bukti'])) {
        $Deskripsi = htmlspecialchars($_POST['Deskripsi']);
        $bukti = $_FILES['bukti'];
        $ID_Bukti = time();
        $ID_Laporan = htmlspecialchars($_POST['ID_Laporan']);

        // Tentukan direktori penyimpanan file bukti
        $uploadDir = "UploadBuktiPengerjaan/";
        $fileName = time() . "_" . basename($bukti["name"]);
        $uploadFilePath = $uploadDir . $fileName;


        // Pastikan direktori upload ada
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Buat direktori jika belum ada
        }

        // Pindahkan file ke direktori tujuan
        if (move_uploaded_file($bukti["tmp_name"], $uploadFilePath)) {
            // Simpan data ke database
            $insertQuery = "
                INSERT INTO Bukti_Pengerjaan 
                (ID_Bukti, Foto, Deskripsi) 
                VALUES (?, ?, ?)";

            $params = [$ID_Bukti,$uploadFilePath, $Deskripsi];
            $stmt = sqlsrv_query($conn, $insertQuery, $params);

            if ($stmt === false) {
                die("Gagal menyimpan ke database: " . print_r(sqlsrv_errors(), true));
            }

            // Jika berhasil
            echo "Laporan Pengerjaan berhasil diunggah!";
            header("Location: ../src/Mahasiswa/Dashboard.php"); // Redirect setelah sukses
            exit;
        } else {
            echo "Gagal mengunggah file bukti. Periksa izin direktori atau coba lagi.";
        }
    } else {
        echo "Deskripsi atau file bukti tidak ditemukan. Silakan coba lagi.";
    }
} else {
    echo "Metode HTTP tidak valid. Gunakan metode POST.";
}
?>
