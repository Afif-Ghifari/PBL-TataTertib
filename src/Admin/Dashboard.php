<?php
session_start();
if (!isset($_SESSION['ID_Admin'])) {
    header("Location: ../Login.html");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/font.css">
    <link rel="icon" href="../../assets/img/LOGO BREN.pdf.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/faq-style.css">
</head>

<body class="flex">
    <?php include "Sidebar.php"; ?>

    <main class="w-full h-screen bg-slate-200 ml-72">
        <?php include "Navbar.php"; ?>

        <section class="flex flex-col w-full px-14 py-12 gap-10">
            <?php
            include "../../backend/database.php";

            // Inisialisasi variabel
            $total_pelanggaran = 0;
            $total_pelaporan = 0;
            $total_banding = 0;
            $total_semua = 0;

            // Query untuk menghitung jumlah laporan yang diverifikasi
            $qry_laporan_pelanggaran = "SELECT COUNT(*) as total_pelanggaran FROM laporan WHERE Status != 'Pending'";
            $qry_laporan = "SELECT COUNT(*) as total_pelaporan FROM laporan";
            $qry_banding = "SELECT COUNT(*) as total_banding FROM banding";

            // Eksekusi query dan ambil hasilnya
            $result_pelanggaran = sqlsrv_query($conn, $qry_laporan_pelanggaran);
            if ($result_pelanggaran && $row = sqlsrv_fetch_array($result_pelanggaran, SQLSRV_FETCH_ASSOC)) {
                $total_pelanggaran = $row['total_pelanggaran'];
            }

            $result_pelaporan = sqlsrv_query($conn, $qry_laporan);
            if ($result_pelaporan && $row = sqlsrv_fetch_array($result_pelaporan, SQLSRV_FETCH_ASSOC)) {
                $total_pelaporan = $row['total_pelaporan'];
            }

            $result_banding = sqlsrv_query($conn, $qry_banding);
            if ($result_banding && $row = sqlsrv_fetch_array($result_banding, SQLSRV_FETCH_ASSOC)) {
                $total_banding = $row['total_banding'];
            }

            // Hitung total semua
            $total_semua = $total_pelanggaran + $total_pelaporan + $total_banding;

            ?>
            <h1 class="text-3xl">Dashboard</h1>
            <div class="grid grid-cols-2 gap-4">
                <div class="w-96 bg-white rounded-xl mx-auto px-6 py-3">
                    <h3 class="text-2xl">Laporan Terverifikasi</h3>
                    <p class="text-slate-600 mb-2">Total laporan yang terbukti</p>
                    <h4 class="text-xl text-blue-600"><?= $total_pelanggaran ?></h4>
                </div>
                <div class="w-96 bg-white rounded-xl mx-auto px-6 py-3">
                    <h3 class="text-2xl">Total Laporan</h3>
                    <p class="text-slate-600 mb-2">Total semua laporan</p>
                    <h4 class="text-xl text-blue-600"><?= $total_pelaporan ?></h4>
                </div>
                <div class="w-96 bg-white rounded-xl mx-auto px-6 py-3">
                    <h3 class="text-2xl">Total Banding</h3>
                    <p class="text-slate-600 mb-2">Total banding dari Mahasiswa</p>
                    <h4 class="text-xl text-blue-600"><?= $total_banding ?></h4>
                </div>
                <div class="w-96 bg-white rounded-xl mx-auto px-6 py-3">
                    <h3 class="text-2xl">Total Keseluruhan</h3>
                    <p class="text-slate-600 mb-2">Total keseluruhan</p>
                    <h4 class="text-xl text-blue-600"><?= $total_semua ?></h4>
                </div>
            </div>
        </section>
    </main>
</body>

</html>