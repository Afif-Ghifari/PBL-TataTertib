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
    <title>Pelanggaran</title>
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

    <main class="w-full h-fullbg-slate-200 ml-72">
        <?php include "Navbar.php"; ?>

        <section class="flex flex-col w-full px-14 py-12 gap-10">
            <button onclick="history.back()" id="backButton" class="text-xl w-fit btn btn-transparent font-bold">
                <i class="bi bi-chevron-left"></i> Kembali
            </button>
            <h1 class="text-3xl">Laporan Pelanggaran Baru</h1>

            <div class="grid grid-cols-3 gap-4">
                <?php
                include "../../backend/database.php";

                $qry_pelanggaran = "SELECT l.ID_Laporan, p.ID_Pelanggaran, p.Nama_Pelanggaran, l.TanggalDibuat, l.Foto_Bukti, d.NIP, d.Nama
                                        FROM laporan l
                                        JOIN pelanggaran p ON l.ID_Pelanggaran = p.ID_Pelanggaran
                                        JOIN dosen d ON l.ID_Pelapor = d.NIP
                                        WHERE l.Status = 'Pending'";

                $stmt = sqlsrv_query($conn, $qry_pelanggaran);

                if (!$stmt) {
                    die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
                }

                if (!sqlsrv_has_rows($stmt)) {
                    echo "<p>No data found.</p>";
                } else {

                    while ($pelanggaran = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                ?>
                        <div class="w-72 bg-white rounded-xl mx-auto px-6 py-3">
                            <img src="../../backend/<?= htmlspecialchars($pelanggaran['Foto_Bukti']) ?>" class="w-56 mx-auto my-3" alt="">
                            <h3 class="text-lg my-2"><?= htmlspecialchars($pelanggaran['Nama_Pelanggaran']) ?></h3>
                            <h4 class="text-blue-600 text-base"><?= htmlspecialchars($pelanggaran['Nama']) ?></h4>
                            <p class="text-slate-400 text-sm my-2">
                                <?= htmlspecialchars(
                                    $pelanggaran['TanggalDibuat'] instanceof DateTime
                                        ? $pelanggaran['TanggalDibuat']->format('Y-m-d')
                                        : $pelanggaran['TanggalDibuat']
                                ) ?>
                            </p>
                            <a href="TerimaPelanggaran.php?ID_Laporan=<?= $pelanggaran['ID_Laporan'] ?>" class="btn btn-primary w-24 my-2">Detail</a>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </section>
    </main>
</body>

</html>