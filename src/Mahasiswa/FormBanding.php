<?php
session_start();

class FormBanding
{
    private $nim;
    private $idLaporan;

    public function __construct()
    {
        $this->checkSession();
        $this->nim = $_SESSION['NIM'];
        $this->idLaporan = htmlspecialchars($_GET['ID_Laporan'] ?? '');
    }

    private function checkSession()
    {
        if (!isset($_SESSION['NIM'])) {
            header("Location: ../Login.html");
            exit();
        }
    }

    public function render()
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Banding</title>
            <script src="https://cdn.tailwindcss.com"></script>
            <link rel="stylesheet" href="../../assets/font.css">
            <link rel="icon" href="../../assets/img/LOGO BREN.pdf.png">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
                  rel="stylesheet" 
                  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
                  crossorigin="anonymous">
        </head>

        <body class="flex w-full">
            <section class="px-14 py-6 w-full">
                <a class="text-xl btn btn-transparent font-bold my-3" href="../Mahasiswa/Dashboard.php">
                    <i class="bi bi-chevron-left"></i> Kembali
                </a>
                <h2 class="text-3xl my-3">Banding jika merasa laporan ini tidak sesuai!!</h2>
                <p>
                    Silakan ajukan banding apabila Anda merasa bahwa bukti pelaporan yang tertera tidak sepenuhnya akurat atau 
                    terdapat ketidaksesuaian dengan fakta yang sebenarnya.
                </p>
                <img src="../../assets/img/FormBandingImg.png" alt="Illustration">
            </section>

            <form 
                class="w-full flex flex-col justify-evenly bg-blue-700 rounded-l-3xl text-white px-14 py-6" 
                action="../../backend/Banding.php" 
                method="post">

                <h2 class="text-3xl my-3">Proses Banding</h2>
                <p>
                    Silakan isi form yang sudah kami sediakan, isi dengan lengkap kalau benar-benar Anda tidak melakukannya.
                </p>

                <div class="flex flex-col gap-2 my-6">
                    <label for="idLaporan">ID Laporan</label>
                    <input 
                        type="text" 
                        id="idLaporan" 
                        name="ID_Laporan" 
                        class="border py-2 px-4 text-black rounded-xl bg-white w-full" 
                        value="<?= $this->idLaporan ?>" 
                        readonly>
                </div>

                <div class="flex flex-col gap-2 my-6">
                    <label for="nim">NIM</label>
                    <input 
                        type="text" 
                        id="nim" 
                        name="NIM" 
                        class="border py-2 px-4 text-black rounded-xl bg-white w-full" 
                        value="<?= htmlspecialchars($this->nim) ?>" 
                        readonly>
                </div>

                <div class="flex flex-col gap-2 my-6">
                    <label for="keterangan">Keterangan</label>
                    <textarea 
                        id="keterangan" 
                        name="Keterangan" 
                        placeholder="Masukkan keterangan" 
                        class="border py-2 px-4 text-black rounded-xl bg-white w-full"></textarea>
                </div>

                <input type="submit" value="Submit" class="btn btn-primary w-1/2 mx-auto my-8">

            </form>
        </body>

        </html>
        <?php
    }
}

$formBanding = new FormBanding();
$formBanding->render();
