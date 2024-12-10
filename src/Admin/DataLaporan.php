<?php
session_start();
if (!isset($_SESSION['ID_Admin'])) {
    header("Location: ../Login.php");
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
        <nav class="flex top-0 gap-10 items-center justify-end px-28 py-6 bg-white">
            <button class="relative inline-flex items-center" id="NotifBtn">
                <i class="bi bi-bell text-3xl text-slate-300"></i>
                <div class="absolute inline-flex items-center justify-center w-3 h-3 bg-red-500 rounded-full -top-1 -end-1 dark:border-gray-900"></div>
            </button>
            <a href="../Dosen/Profile.php" class="size-10 rounded-full border overflow-hidden">
                <img src="../../assets/img/pp_sample.jpg" class="w-full h-full object-cover" alt="">
            </a>
        </nav>
        <section class="flex flex-col w-full h-full bg-slate-100 px-14 py-12 gap-10">
            <h1 class="text-3xl">Manajemen Data Laporan</h1>
            <!-- <a href="TambahDataDosen.php" class="btn btn-primary w-fit"><i class="bi bi-plus"></i> Tambah Data</a> -->
            
            <table class="w-full table-fixed bg-white max-w-5xl mx-auto border-separate border border-slate-500">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-3 py-2">Pelapor</th>
                        <th class="px-3 py-2">Dilapor</th>
                        <th class="px-3 py-2">Pelanggaran</th>
                        <th class="px-3 py-2">Sanksi</th>
                        <th class="px-3 py-2">Status</th>
                        <th class="px-3 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    include "../../backend/database.php";
              
                    $qry_mahasiswa = "SELECT l.ID_Laporan,
                                            l.ID_Pelanggaran, 
                                            d.NIP, 
                                            d.Nama as NamaDosen,
                                            m.NIM,
                                            m.Nama as NamaMahasiswa,
                                            p.ID_Pelanggaran,
                                            p.Nama_Pelanggaran,
                                            l.Sanksi,
                                            l.Status 
                                            FROM Laporan l
                                            JOIN Pelanggaran p ON l.ID_Pelanggaran = p.ID_Pelanggaran
                                            JOIN Dosen d ON l.ID_Pelapor = d.NIP
                                            JOIN Mahasiswa m ON l.ID_Dilapor = m.NIM
                                            WHERE l.Status != 'pending'";

                    $stmt = sqlsrv_query($conn, $qry_mahasiswa);

                    if (!$stmt) {
                        die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
                    }

                    if (!sqlsrv_has_rows($stmt)) {
                        echo "<p>No data found.</p>";
                    } else {

                        while ($laporan = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        
                    ?>
                    <tr>
                        <td class="border border-slate-700 px-3"><?= htmlspecialchars($laporan['NamaDosen'])?></td>
                        <td class="border border-slate-700 px-3"><?= htmlspecialchars($laporan['NamaMahasiswa'])?></td>
                        <td class="border border-slate-700 px-3" id="Shortened"><?= htmlspecialchars($laporan['Nama_Pelanggaran'])?></td>
                        <td class="border border-slate-700 px-3"><?= htmlspecialchars($laporan['Sanksi'] ?? 'Sanksi belum ditentukan') ?></td>
                        <td class="border border-slate-700 px-3"><?= htmlspecialchars($laporan['Status'])?></td>
                        <td class="border border-slate-700 px-3">
                            <a href="EditDataLaporan.php?ID_Laporan=<?= $laporan['ID_Laporan']?>" class="btn btn-success mx-auto"><i class="bi bi-pencil-square"></i></a>
                            <!-- <a href="../../backend/hapusDataDosen.php?NIP=<?= $laporan['NIP']?>" class="btn btn-danger"><i class="bi bi-trash"></i></a> -->
                        </td>
                    </tr>
                <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const shortened = document.querySelectorAll('.border.border-slate-700.px-3');

    shortened.forEach(element => {
        const maxLength = 30;
        const text = element.textContent.trim();

        if (text.length > maxLength) {
            element.textContent = text.substring(0, maxLength) + '...';
        }
    });
});
</script>
</html>