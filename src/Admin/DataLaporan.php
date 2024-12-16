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
                                            JOIN Mahasiswa m ON l.ID_Dilapor = m.NIM";

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
                        <td class="border border-slate-700 px-3">
                            <?php
                            if ($laporan['Status'] == 'Pending') {
                                echo '<span class="px-2 py-1 rounded-lg text-white bg-slate-600 ">Pending</span>';
                            } elseif ($laporan['Status'] == 'Dikonfirmasi') {
                                echo '<span class="px-2 py-1 rounded-lg text-black bg-amber-600">Dikonfirmasi</span>';
                            } elseif ($laporan['Status'] == 'Ditolak') {
                                echo '<span class="px-2 py-1 rounded-lg text-white bg-red-600">Ditolak</span>';
                            } elseif ($laporan['Status'] == 'Selesai') {
                                echo '<span class="px-2 py-1 rounded-lg text-white bg-green-600">Selesai</span>';
                            }
                            ?>
                            <!-- <?= htmlspecialchars($laporan['Status'])?> -->
                        </td>
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