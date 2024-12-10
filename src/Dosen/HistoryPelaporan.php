<?php
    session_start();
    if (!isset($_SESSION['NIP'])) {
        header("Location: ../Login.php");
    }
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histori Pelanggaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/HistoriPelanggaran.css">
    <link rel="icon" href="../../assets/img/LOGO BREN.pdf.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include 'Navbar.php'; ?>

    <main class="flex flex-col px-28 my-36">
        <header class="flex flex-col gap-4 justify-start text-start w-1/2">
            <h1 class="text-4xl font-bold">Histori Pelanggaran</h1>
            <p class="text-xl">History Pelanggaran adalah fitur untuk melihat riwayat pelanggaran mahasiswa, mencakup detail seperti
                jenis pelanggaran, tanggal, dan status penyelesaiannya.</p>
        </header>

        <section class="flex flex-col my-36" id="listPelanggaran">
            <div class="flex px-6 py-2 justify-between gap-3 bg-slate-300 rounded-full" style="font-family: 'product Sans Bold';" id="filterList">
                <button class="w-full px-12 py-2 bg-blue-600 text-white rounded-3xl">Semua</button>
                <button class="w-full px-12 py-2 hover:bg-slate-400 text-black rounded-3xl">Proses</button>
            </div>

            <div class="grid grid-cols-3 justify-between gap-4 my-12" id="gridList">
                <?php
                // Include database connection
                include "../../backend/database.php";

                // SQL query to fetch data
                $qry_laporan = "
                    SELECT 
                        l.ID_Laporan, 
                        l.ID_Pelanggaran,
                        l.ID_Pelapor,
                        l.ID_Dilapor,
                        m.Nama,
                        p.Nama_Pelanggaran, 
                        p.Tingkat 
                    FROM 
                        laporan l 
                    JOIN 
                        pelanggaran p 
                    ON 
                        l.ID_Pelanggaran = p.ID_Pelanggaran
                    JOIN 
                        mahasiswa m 
                    ON 
                        l.ID_Dilapor = m.NIM 
                    WHERE 
                        l.ID_Pelapor = ?";

                // Prepare the statement
                $params = [$_SESSION['NIP']];
                $stmt = sqlsrv_prepare($conn, $qry_laporan, $params);

                // Execute the statement
                if (!$stmt) {
                    die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
                }

                if (!sqlsrv_execute($stmt)) {
                    die("Query Execute Error: " . print_r(sqlsrv_errors(), true));
                }

                if (!sqlsrv_has_rows($stmt)) {
                    echo "<p>No data found.</p>";
                } else {


                    // Loop through the records
                    while ($data_laporan = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                ?>
                        <div class="flex flex-col mx-auto justify-between w-80 h-96 px-8 py-6 rounded-xl shadow-xl border" id="cardPelanggaran">
                            <div class="flex items-center justify-center w-14 h-14 bg-blue-600 rounded-full text-white text-3xl">
                                <?= htmlspecialchars($data_laporan['Tingkat']) ?>
                            </div>
                            <h3 class="text-xl"><?= htmlspecialchars($data_laporan['Nama_Pelanggaran']) ?></h3>

                            <h4>Terlapor: <?= htmlspecialchars($data_laporan['Nama']) ?></h4>
                            <!-- <span class="flex gap-3 items-center">
                                <a href="../Mahasiswa/DetailPelanggaran.html" class="btn btn-primary w-24" style="font-family: 'product Sans Bold';">
                                    Detail
                                </a>
                            </span> -->
                        </div>
                <?php
                    } // End of while loop
                }
                ?>
            </div>
        </section>

    </main>
    <?php include '../Footer.php' ?>

</body>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const faqItems = document.querySelectorAll(".faq-item");

        faqItems.forEach(item => {
            const header = item.querySelector(".faq-header");
            const content = item.querySelector(".faq-content");
            const icon = header.querySelector(".icon");

            header.addEventListener("click", () => {
                faqItems.forEach(i => {
                    const otherContent = i.querySelector(".faq-content");
                    const otherIcon = i.querySelector(".icon");
                    if (otherContent !== content && otherContent.classList.contains("show")) {
                        otherContent.classList.remove("show");
                        otherContent.style.maxHeight = null;
                        otherIcon.classList.remove("rotate");
                    }
                });

                if (content.classList.contains("show")) {
                    content.classList.remove("show");
                    content.style.maxHeight = null;
                    icon.classList.remove("rotate");
                } else {
                    content.classList.add("show");
                    content.style.maxHeight = content.scrollHeight + "px";
                    icon.classList.add("rotate");
                }
            });
        });
    });
</script>

</html>