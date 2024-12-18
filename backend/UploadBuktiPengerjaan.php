<?php
class UploadBuktiPengerjaan
{
    private $conn;
    private $uploadDir = "UploadBuktiPengerjaan/";

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
        $this->ensureUploadDirectoryExists();
    }

    private function ensureUploadDirectoryExists()
    {
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    private function validateInput($data, $files)
    {
        return isset($data['Deskripsi'], $files['bukti'], $data['ID_Laporan']);
    }

    private function moveUploadedFile($file)
    {
        $fileName = time() . "_" . basename($file["name"]);
        $uploadFilePath = $this->uploadDir . $fileName;

        if (move_uploaded_file($file["tmp_name"], $uploadFilePath)) {
            return $uploadFilePath;
        }

        throw new Exception("Gagal mengunggah file bukti. Periksa izin direktori atau coba lagi.");
    }

    private function insertBuktiPengerjaan($idBukti, $uploadFilePath, $deskripsi)
    {
        $query = "INSERT INTO Bukti_Pengerjaan (ID_Bukti, Foto, Deskripsi) VALUES (?, ?, ?)";
        $params = [$idBukti, $uploadFilePath, $deskripsi];
        $stmt = sqlsrv_query($this->conn, $query, $params);

        if ($stmt === false) {
            throw new Exception("Gagal menyimpan bukti pengerjaan ke database: " . print_r(sqlsrv_errors(), true));
        }
    }

    private function updateLaporan($idBukti, $idLaporan)
    {
        $query = "UPDATE Laporan SET ID_Bukti = ? WHERE ID_Laporan = ?";
        $params = [$idBukti, $idLaporan];
        $stmt = sqlsrv_query($this->conn, $query, $params);

        if ($stmt === false) {
            throw new Exception("Gagal memperbarui ID_Bukti pada tabel Laporan: " . print_r(sqlsrv_errors(), true));
        }
    }

    public function handleUpload($data, $files)
    {
        if (!$this->validateInput($data, $files)) {
            throw new Exception("Deskripsi, file bukti, atau ID Laporan tidak ditemukan. Silakan coba lagi.");
        }

        $deskripsi = htmlspecialchars($data['Deskripsi']);
        $idLaporan = htmlspecialchars($data['ID_Laporan']);
        $idBukti = time();

        $uploadFilePath = $this->moveUploadedFile($files['bukti']);

        $this->insertBuktiPengerjaan($idBukti, $uploadFilePath, $deskripsi);
        $this->updateLaporan($idBukti, $idLaporan);

        header("Location: ../src/Mahasiswa/HistoriPelanggaran.php");
        exit;
    }
}

// Inisialisasi dan penggunaan class
include "database.php";

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $uploader = new UploadBuktiPengerjaan($conn);
        $uploader->handleUpload($_POST, $_FILES);
        echo "Laporan pengerjaan berhasil diunggah!";
    } else {
        echo "Metode HTTP tidak valid. Gunakan metode POST.";
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
