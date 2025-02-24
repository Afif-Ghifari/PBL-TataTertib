<?php
class PelaksanaanSanksi
{
    private $session;
    private $laporanId;

    public function __construct()
    {
        session_start();
        $this->session = $_SESSION;
        $this->authenticate();
        $this->laporanId = $this->getLaporanId();
    }

    private function authenticate()
    {
        if (!isset($this->session['NIM'])) {
            header("Location: ../Login.html");
            exit;
        }
    }

    private function getLaporanId()
    {
        return htmlspecialchars($_GET['ID_Laporan'] ?? '');
    }

    private function includeFile($filePath)
    {
        if (file_exists($filePath)) {
            include $filePath;
        }
    }

    public function renderPage()
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Pelaksanaan Sanksi</title>
            <script src="https://cdn.tailwindcss.com"></script>
            <link rel="stylesheet" href="../../assets/HistoriPelanggaran.css">
            <link rel="icon" href="../../assets/img/LOGO BREN.pdf.png" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        </head>

        <body>
            <?php $this->includeFile('Navbar.php'); ?>
            <main class="px-28 my-36">
                <h2 class="text-3xl text-center my-2">Pelaksanaan Sanksi</h2>
                <p class="text-center">
                    Silakan anda mengerjakan tanggung jawab anda untuk mengerjakan tugas yang diberikan admin untuk
                    membersikan Auditorium lantai 8 dan untuk bukti silakan upload foto dokumentasi dalam pelaksanaan
                    pembersian auditorium.
                </p>

                <!-- Form untuk upload -->
                <form 
                    class="w-full px-20 py-12 rounded-xl shadow-lg my-20" action="../../backend/UploadBuktiPengerjaan.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="ID_Laporan" value="<?= $this->laporanId ?>"> 
                    <!-- Input File -->
                    <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">Upload Bukti</label>
                    <input class="form-control mb-5" id="file_input" type="file" name="bukti" required>

                    <!-- Textarea Deskripsi -->
                    <label for="Deskripsi">Deskripsi</label>
                    <textarea class="form-control mb-5" id="Deskripsi" name="Deskripsi" rows="4" required></textarea>

                    <!-- Tombol Submit -->
                    <input type="submit" value="Submit" class="btn btn-primary rounded-xl w-full mx-auto mt-8 py-2">
                </form>
            </main>
            <?php $this->includeFile('../Footer.php'); ?>
        </body>

        </html>
        <?php
    }
}

$page = new PelaksanaanSanksi();
$page->renderPage();
