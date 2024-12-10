<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/HistoriPelanggaran.css">
    <link rel="icon" href="../../assets/img/LOGO BREN.pdf.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Detail Pelanggaran</title>
</head>

<body>
    <nav class="w-full px-28 py-6">
        <a href="../Mahasiswa/HistoriPelanggaran.php" id="backButton" class="text-xl btn btn-transparent font-bold">
            <i class="bi bi-chevron-left"></i> Kembali
        </a>
    </nav>
    <script>
        document.getElementById("backButton").addEventListener("click", () => {
            const previousPage = sessionStorage.getItem("previousPage");
            if (previousPage) {
                window.location.href = previousPage;
            } else {
                history.back();
            }
        });
    </script>
    
    
    <main class="mx-28 mb-32 mt-8 flex">
    <?php
    include "../../backend/database.php";
    session_start();

    $qry_detail = "SELECT l.ID_Laporan, l.ID_Dilapor, p.ID_Pelanggaran, d.NIP, d.Nama, p.Nama_Pelanggaran, p.Tingkat, l.TanggalDibuat, l.Status
                    FROM Laporan l
                    JOIN Pelanggaran p ON l.ID_Pelanggaran = p.ID_Pelanggaran
                    JOIN Dosen d ON l.ID_Pelapor = d.NIP
                    WHERE l.ID_Dilapor = ?";
    $params = [$_SESSION['NIM']];
    $stmt = sqlsrv_prepare($conn, $qry_detail, $params);

    if (!$stmt) {
        die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
    }

    if (!sqlsrv_execute($stmt)) {
        die("Query Execute Error: " . print_r(sqlsrv_errors(), true));
    }

    // Fetch the result
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if (!$row) {
        die("No data found.");
    }
    ?>
        <section class="w-2/3 h-fit">
            <img src="../../assets/img/sample_pelanggaran.png" class="max-w-2xl rounded-2xl mb-10" alt="">
            <div class="pr-24">
                <h2 class="text-xl"><?= htmlspecialchars($row['Nama_Pelanggaran']) ?></h2>
                <h4 class="text-sm text-slate-600">Pelanggaran Tingkat <?= htmlspecialchars($row['Tingkat']) ?></h4>
                <span class="flex items-center gap-3 my-7">
                    <div class="size-10 rounded-full border overflow-hidden">
                        <img src="../../assets/img/pp_sample.jpg" class="w-full h-full object-cover" alt="">
                    </div>
                    <h6 class="my-0"><?= htmlspecialchars($row['Nama']) ?></h6>
                </span>
                
            </div>
        </section>
        <aside class="w-1/3">
            <div class="w-full border shadow-lg rounded-lg px-12 py-8">
                <h3>Lihat Pedoman tatib</h3>
                <a href="../PDF/BukuPedoman.pdf" download="Pedoman Tata Tertib" class="flex flex-row w-full justify-between items-center text-black no-underline h-fit border border-black px-4 py-2 rounded-xl">
                    <i class="bi bi-file-earmark-pdf-fill text-blue-600 text-2xl"></i>
                    <span class="text-start">
                        <h6 class="text-sm my-0">Pedoman Tata Tertib.pdf</h6>
                        <p   class="text-sm my-0">4.3 MB</p>
                    </span>
                    <i class="bi bi-download text-2xl"></i>
                </a>
                <div class="w-full px-8 py-3 my-8 bg-gradient-to-r from-blue-900 to-black rounded-lg text-white">
                    <h4>Status</h4>
                    <p class="text-slate-300"><?= htmlspecialchars($row['Status']) ?></p>
                </div>
                <div class="w-full px-8 py-3 mt-8 mb-6 bg-gradient-to-r from-blue-900 to-black rounded-lg text-white">
                    <h4>Tanggal Dilaporkan</h4>
                    <p class="text-slate-300"><?= htmlspecialchars(
                                    $row['TanggalDibuat'] instanceof DateTime
                                        ? $row['TanggalDibuat']->format('Y-m-d')
                                        : $row['TanggalDibuat']
                                ) ?></p>
                </div>
                <p class="text-red-600">
                    Apakah itu anda? kalau itu benar anda silakan konfirmasi!!
                </p>
                <div class="flex flex-col gap-3 my-6">
                    <a href="EditPelaksanaanSanksi.php?ID_Laporan=<?= $row['ID_Laporan'] ?>" class="btn btn-primary w-full">Konfirmasi</a>
                    <a href="FormBanding.php?ID_Laporan=<?= $row['ID_Laporan'] ?>" class="btn btn-light w-full border border-black">Ajukan banding</a>
                </div>
            </div>
        </aside>
    </main>

    <?php include '../Footer.php' ?>
</body>

</html>