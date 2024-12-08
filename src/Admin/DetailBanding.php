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
        <nav class="flex gap-10 w-full items-center justify-end px-28 py-6 bg-white">
            <button class="relative inline-flex items-center" id="NotifBtn">
                <i class="bi bi-bell text-3xl text-slate-300"></i>
                <div class="absolute inline-flex items-center justify-center w-3 h-3 bg-red-500 rounded-full -top-1 -end-1 dark:border-gray-900"></div>
            </button>
            <a href="../Dosen/Profile.php" class="size-10 rounded-full border overflow-hidden">
                <img src="../../assets/img/pp_sample.jpg" class="w-full h-full object-cover" alt="">
            </a>
        </nav>
        <section class="flex flex-col w-full px-14 py-12 gap-10">
            <?php
            include "../../backend/database.php";

            $qry_banding = "SELECT b.ID_Banding, l.ID_Laporan, l.TanggalDibuat, p.ID_Pelanggaran, p.Nama_Pelanggaran, m.NIM, m.Nama, k.id_Kelas, k.Nama_Kelas, b.Keterangan
                                FROM banding b
                                JOIN mahasiswa m
                                ON b.NIM = m.NIM
                                JOIN laporan l
                                ON b.ID_Laporan = l.ID_Laporan
                                JOIN pelanggaran p
                                ON l.ID_Pelanggaran = p.ID_Pelanggaran
                                JOIN Kelas k 
                                ON m.ID_Kelas = k.ID_Kelas
                                WHERE b.ID_Banding = ?";
            $params = [$_GET['ID_Banding']];
            
            $stmt = sqlsrv_prepare($conn, $qry_banding, $params);
            if (!$stmt) {
                die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
            }

            if (!sqlsrv_execute($stmt)) {
                die("Query Execute Error: " . print_r(sqlsrv_errors(), true));
            }

            $banding = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            ?>
            <h3>Pengajuan Banding</h3>
            <div class="flex flex-col w-full px-20 py-12 rounded-xl shadow-lg" action="" method="post">
                <label for="" class="flex w-1/2 justify-between">
                    <span>
                        <h5>Nama</h5>
                        <p><?= htmlspecialchars($banding['Nama']) ?></p>
                    </span>
                    <span>
                        <h5>NIM</h5>
                        <p><?= htmlspecialchars($banding['NIM']) ?></p>
                    </span>
                </label>

                <label for="">
                    <h5>Kelas</h5>
                    <p><?= htmlspecialchars($banding['Nama_Kelas']) ?></p>
                </label>

                <label for="">
                    <h5>Pelanggaran</h5>
                    <p><?= htmlspecialchars($banding['Nama_Pelanggaran']) ?></p>
                </label>

                <label for="">
                    <h5>Waktu Dilaporkan</h5>
                    <p><?= htmlspecialchars($banding['TanggalDibuat']) ?></p>
                </label>

                <label for="">
                    <h5>Alasan Banding</h5>
                    <p><?= htmlspecialchars($banding['Keterangan']) ?></p>
                </label>
                <a href="EditDataLaporan.php" class="btn btn-primary rounded-xl w-full mx-auto my-3 py-2">Tindak Lanjut</a>
                <a href="DataBanding.php" class="btn btn-warning rounded-xl w-full mx-auto my-3 py-2">Tutup</a>
            </div>
        </section>
    </main>
</body>

</html>