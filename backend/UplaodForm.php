<?php
class UploadForm {
    private $conn;
    private $uploadDir = "UploadButkiPelanggaran/";

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function processForm($formData, $fileData) {
        $namaTerlapor = htmlspecialchars($formData['NamaTerlapor']);
        $tanggal = htmlspecialchars($formData['Tanggal']);
        $ID_Pelapor = $formData['NIP'];
        $jenisPelanggaran = htmlspecialchars($formData['JenisPelanggaran']);
        $bukti = $fileData['bukti'];

        $idTerlapor = $this->getIdTerlapor($namaTerlapor);
        if ($idTerlapor === null) {
            echo "Nama Terlapor tidak ditemukan!";
            exit;
        }

        $uploadFilePath = $this->saveBuktiFile($bukti);
        if ($uploadFilePath === false) {
            echo "Gagal mengunggah file bukti.";
            exit;
        }

        $this->insertLaporan($ID_Pelapor, $idTerlapor, $jenisPelanggaran, $uploadFilePath);
        echo "Laporan berhasil ditambahkan!";
        header("Location: ../src/Dosen/Dashboard.php");
    }

    private function getIdTerlapor($namaTerlapor) {
        $query = "SELECT NIM FROM [PelanggaranTataTertib].[dbo].[Mahasiswa] WHERE Nama LIKE ?";
        $stmt = sqlsrv_query($this->conn, $query, [$namaTerlapor]);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        return $row['NIM'] ?? null;
    }

    private function saveBuktiFile($bukti) {
        $fileName = time() . "_" . basename($bukti["name"]);
        $uploadFilePath = $this->uploadDir . $fileName;

        if (move_uploaded_file($bukti["tmp_name"], $uploadFilePath)) {
            return $uploadFilePath;
        }

        return false;
    }

    private function insertLaporan($ID_Pelapor, $idTerlapor, $jenisPelanggaran, $uploadFilePath) {
        $idLaporan = time();
        $query = "
            INSERT INTO Laporan 
            (ID_Laporan, ID_Pelapor, ID_Dilapor, ID_Pelanggaran, TanggalDibuat, Foto_Bukti, Status) 
            VALUES (?, ?, ?, ?, GETDATE(), ?, 'Pending')
        ";
        $params = [$idLaporan, $ID_Pelapor, $idTerlapor, $jenisPelanggaran, $uploadFilePath];
        $stmt = sqlsrv_query($this->conn, $query, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    }
}

// Pemanggilan class
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "database.php";
    $uploadForm = new UploadForm($conn);
    $uploadForm->processForm($_POST, $_FILES);
}
?>
