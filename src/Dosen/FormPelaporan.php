<?php
session_start();

if (!isset($_SESSION['NIP'])) {
    header("Location: ../Login.html");
    exit;
}

class FormPelaporan
{
    private $sessionNIP;
    private $dbConnection;

    public function __construct($sessionNIP, $dbConnection)
    {
        $this->sessionNIP = $sessionNIP;
        $this->dbConnection = $dbConnection;
    }

    public function renderHeader()
    {
        echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pelaporan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../assets/HistoriPelanggaran.css">
    <link rel="icon" href="../../assets/img/LOGO BREN.pdf.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
HTML;
        include 'Navbar.php';
    }

    public function renderForm()
    {
        $pelanggaranOptions = $this->getPelanggaranOptions();
        $MahasiswaOptions = $this->getNamaMhs();
        echo <<<HTML
<main class="px-28 my-36">
    <h2 class="text-3xl text-center my-2">Form Pelaporan</h2>
    <p class="text-center">Silakan lengkapi form pelaporan ini dengan informasi yang sesuai dan jelas. Pastikan semua data yang dimasukkan valid agar laporan dapat diproses dengan baik.</p>

    <form class="w-full px-20 py-12 rounded-xl shadow-lg my-20" action="../../backend/UplaodForm.php" method="post" enctype="multipart/form-data">
        <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">Upload file</label>
        <input class="form-control" id="file_input" type="file" name="bukti" required>

        <div class="flex justify-between gap-24 w-full my-8">
            <!-- <span class="w-1/4">
                <label for="">NIM Terlapor</label>
                <input type="text" class="form-control" id="NamaTerlapor" name="NIM" required>
            </span> -->
            <span class="w-full">
                <label for="">Nama Terlapor</label>
                <select class="form-control" id="NamaTerlapor" name="NamaTerlapor" required>
                    <option value="" class="hidden">Pilih Nama Terlapor</option>
                    $MahasiswaOptions
                </select>
                
            </span>
            
            <span class="w-full hidden">
                <label for="">Admin Yang Akan Menangani</label>
                <input type="text" class="form-control" id="Admin" name="ID_Admin" value="1">
                <input type="text" class="form-control hidden" id="Admin" name="NIP" value="{$this->sessionNIP}">
            </span>
        </div>

        <div class="flex justify-between gap-24 w-full my-8">
            <span class="w-full hidden">
                <label for="">Tempat Kejadian</label>
                <input type="text" class="form-control" id="Tempat" name="Tempat">
            </span>
            <span class="w-full">
                <label for="">Tanggal Kejadian</label>
                <input type="date" class="form-control" id="Tanggal" name="Tanggal" required>
            </span>
        </div>

        <label for="">Jenis Pelanggaran</label>
        <select name="JenisPelanggaran" class="form-control mb-8" id="JenisPelanggaran" required>
            <option value="" class="hidden">Pilih Jenis Pelanggaran</option>
            $pelanggaranOptions
        </select>

        <input type="submit" value="Submit" class="btn btn-primary rounded-xl w-full mx-auto my-6 py-2">
    </form>
</main>
HTML;
    }

    private function getNamaMhs()
    {
        $options_mhs = "";
        $query_mhs = "SELECT * FROM mahasiswa ORDER BY Nama ASC";
        $stmt_mhs = sqlsrv_query($this->dbConnection, $query_mhs);

        if ($stmt_mhs === false) {
            die("Query Error: " . print_r(sqlsrv_errors(), true));
        }

        while ($mhs = sqlsrv_fetch_array($stmt_mhs, SQLSRV_FETCH_ASSOC)) {
            $id = htmlspecialchars($mhs['NIM']);
            $name = htmlspecialchars($mhs['Nama']);
            $options_mhs .= "<option class=\"w-96\" value=\"$name\">$id - $name </option>";
        }

        return $options_mhs;
    }

    private function getPelanggaranOptions()
    {
        $options = "";
        $query = "SELECT * FROM pelanggaran";
        $stmt = sqlsrv_query($this->dbConnection, $query);

        if ($stmt === false) {
            die("Query Error: " . print_r(sqlsrv_errors(), true));
        }

        while ($pelanggaran = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $id = htmlspecialchars($pelanggaran['ID_Pelanggaran']);
            $name = htmlspecialchars($pelanggaran['Nama_Pelanggaran']);
            $options .= "<option class=\"w-96\" value=\"$id\">$name</option>";
        }

        return $options;
    }

    public function renderFooter()
    {
        include '../Footer.php';
        echo <<<HTML
</body>

</html>
HTML;
    }
}

// Inisialisasi database connection dan render form
include "../../backend/database.php";
$formPelaporan = new FormPelaporan($_SESSION['NIP'], $conn);
$formPelaporan->renderHeader();
$formPelaporan->renderForm();
$formPelaporan->renderFooter();
