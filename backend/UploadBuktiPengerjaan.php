<?php
include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi input dari form
    if (isset($_POST['Deskripsi']) && isset($_FILES['bukti'])) {
        $Deskripsi = htmlspecialchars($_POST['Deskripsi']);
        $bukti = $_FILES['bukti'];

        // Tentukan direktori penyimpanan file bukti
        $uploadDir = "UploadBuktiPengerjaan/";
        $fileName = time() . "_" . basename($bukti["name"]);
        $uploadFilePath = $uploadDir . $fileName;

        // Validasi file upload (opsional)
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "Format file tidak didukung. Hanya jpg, jpeg, png, dan pdf yang diizinkan.";
            exit;
        }

        // Pastikan direktori upload ada
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Buat direktori jika belum ada
        }

        // Pindahkan file ke direktori tujuan
        if (move_uploaded_file($bukti["tmp_name"], $uploadFilePath)) {
            // Simpan data ke database
            $insertQuery = "
                INSERT INTO Bukti_Pengerjaan 
                (Foto, Deskripsi) 
                VALUES (?, ?)";

            $params = [$uploadFilePath, $Deskripsi];
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
