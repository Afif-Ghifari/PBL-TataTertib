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
    <h2>Laporan Baru</h2>
    <div class="grid grid-cols-3 justify-between gap-4 my-12" id="gridListKonfirmasi">
        <?php
        include "../../backend/database.php";

        $query4 = "SELECT l.ID_Laporan, l.ID_Dilapor, p.ID_Pelanggaran, d.NIP, d.Nama, p.Nama_Pelanggaran, p.Tingkat, l.Status 
                    FROM Laporan l
                    JOIN Pelanggaran p ON l.ID_Pelanggaran = p.ID_Pelanggaran
                    JOIN Dosen d ON l.ID_Pelapor = d.NIP
                    WHERE l.Status = 'Pending' AND l.ID_Dilapor = ?";
        $params4 = [$_SESSION['NIM']];
        $stmt4 = sqlsrv_query($conn, $query4, $params4);

        if (!$stmt4) {
            die("Query Execution Error: " . print_r(sqlsrv_errors(), true));
        }

        if (!sqlsrv_has_rows($stmt4)) {
            echo "<p>No data found.</p>";
        } else {

            while ($laporan4 = sqlsrv_fetch_array($stmt4, SQLSRV_FETCH_ASSOC)) {
        ?>
                <div class="flex flex-col mx-auto gap-2 justify-between w-80 h-fit px-8 py-6 rounded-xl shadow-xl border"
                    id="cardPelanggaran">
                    <div class="flex items-center justify-center w-14 h-14 bg-blue-600 rounded-full text-white text-3xl"><?= htmlspecialchars($laporan4['Tingkat']) ?>
                    </div>
                    <p class="text-sm text-amber-600">Laporan menunggu konfirmasi</p>
                    <h3 class="text-xl"><?= htmlspecialchars($laporan4['Nama_Pelanggaran']) ?></h3>
                    <span class="flex gap-3 items-center">
                        <!-- <div class="w-8 h-8 rounded-full bg-slate-300"></div> -->
                        <p> <b>Pelapor: </b><?= htmlspecialchars($laporan4['Nama']) ?></p>
                    </span>
                    <a href="../Mahasiswa/DetailPelanggaran.php?ID_Laporan=<?= $laporan4['ID_Laporan'] ?>" class="btn btn-primary w-24 my-2" style="font-family: 'product Sans Bold';">Detail</a>
                </div>
        <?php
            }
        }
        ?>
    </div>

    <h2>Laporan Dikonfirmasi</h2>
    <div class="grid grid-cols-3 justify-between gap-4 my-12" id="gridListTunggu">
        <?php
        include "../../backend/database.php";

        $query1 = "SELECT l.ID_Laporan, l.ID_Dilapor, p.ID_Pelanggaran, d.NIP, d.Nama, p.Nama_Pelanggaran, p.Tingkat, l.Status 
                    FROM Laporan l
                    JOIN Pelanggaran p ON l.ID_Pelanggaran = p.ID_Pelanggaran
                    JOIN Dosen d ON l.ID_Pelapor = d.NIP
                    WHERE l.Status = 'Dikonfirmasi' AND l.ID_Dilapor = ?";
        $params1 = [$_SESSION['NIM']];
        $stmt1 = sqlsrv_query($conn, $query1, $params1);

        if (!$stmt1) {
            die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
        }

        if (!sqlsrv_has_rows($stmt1)) {
            echo "<p>No data found.</p>";
        } else {

            while ($laporan1 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)) {
        ?>
                <div class="flex flex-col mx-auto gap-2 justify-between w-80 h-fit px-8 py-6 rounded-xl shadow-xl border"
                    id="cardPelanggaran">
                    <div class="flex items-center justify-center w-14 h-14 bg-blue-600 rounded-full text-white text-3xl"><?= htmlspecialchars($laporan1['Tingkat']) ?>
                    </div>
                    <p class="text-sm text-amber-600">Laporan terhadap anda dikonfirmasi</p>
                    <h3 class="text-xl"><?= htmlspecialchars($laporan1['Nama_Pelanggaran']) ?></h3>
                    <span class="flex gap-3 items-center">
                        <!-- <div class="w-8 h-8 rounded-full bg-slate-300"></div> -->
                        <p><b>Pelapor: </b><?= htmlspecialchars($laporan1['Nama']) ?></p>
                    </span>
                    <a href="../Mahasiswa/DetailPelanggaran.php?ID_Laporan=<?= $laporan1['ID_Laporan'] ?>" class="btn btn-primary w-24 my-2" style="font-family: 'product Sans Bold';">Detail</a>
                </div>
        <?php
            }
        }
        ?>
    </div>
    <h2>Laporan Selesai Dikerjakan</h2>
    <div class="grid grid-cols-3 justify-between gap-4 my-12" id="gridListKonfirmasi">
        <?php
        include "../../backend/database.php";

        $query3 = "SELECT l.ID_Laporan, l.ID_Dilapor, p.ID_Pelanggaran, d.NIP, d.Nama, p.Nama_Pelanggaran, p.Tingkat, l.Status 
                    FROM Laporan l
                    JOIN Pelanggaran p ON l.ID_Pelanggaran = p.ID_Pelanggaran
                    JOIN Dosen d ON l.ID_Pelapor = d.NIP
                    WHERE l.Status = 'Selesai' AND l.ID_Dilapor = ?";
        $params2 = [$_SESSION['NIM']];
        $stmt2 = sqlsrv_query($conn, $query3, $params2);

        if (!$stmt2) {
            die("Query Execution Error: " . print_r(sqlsrv_errors(), true));
        }

        if (!sqlsrv_has_rows($stmt2)) {
            echo "<p>No data found.</p>";
        } else {

            while ($laporan2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC)) {
        ?>
                <div class="flex flex-col mx-auto gap-2 justify-between w-80 h-fit px-8 py-6 rounded-xl shadow-xl border"
                    id="cardPelanggaran">
                    <div class="flex items-center justify-center w-14 h-14 bg-blue-600 rounded-full text-white text-3xl"><?= htmlspecialchars($laporan2['Tingkat']) ?>
                    </div>
                    <p class="text-sm text-green-600">Pengerjaan laporan telah selesai</p>
                    <h3 class="text-xl"><?= htmlspecialchars($laporan2['Nama_Pelanggaran']) ?></h3>
                    <span class="flex gap-3 items-center">
                        <!-- <div class="w-8 h-8 rounded-full bg-slate-300"></div> -->
                        <p><b>Pelapor: </b><?= htmlspecialchars($laporan2['Nama']) ?></p>
                    </span>
                    <a href="../Mahasiswa/DetailPelanggaran.php?ID_Laporan=<?= $laporan2['ID_Laporan'] ?>" class="btn btn-primary w-24 my-2" style="font-family: 'product Sans Bold';">Detail</a>
                </div>
        <?php
            }
        }
        ?>
    </div>


    <h2>Laporan Ditolak</h2>
    <div class="grid grid-cols-3 justify-between gap-4 my-12" id="gridListKonfirmasi">
        <?php
        include "../../backend/database.php";

        $query4 = "SELECT l.ID_Laporan, l.ID_Dilapor, p.ID_Pelanggaran, d.NIP, d.Nama, p.Nama_Pelanggaran, p.Tingkat, l.Status 
                    FROM Laporan l
                    JOIN Pelanggaran p ON l.ID_Pelanggaran = p.ID_Pelanggaran
                    JOIN Dosen d ON l.ID_Pelapor = d.NIP
                    WHERE l.Status = 'Ditolak' AND l.ID_Dilapor = ?";
        $params4 = [$_SESSION['NIM']];
        $stmt4 = sqlsrv_query($conn, $query4, $params4);

        if (!$stmt4) {
            die("Query Execution Error: " . print_r(sqlsrv_errors(), true));
        }

        if (!sqlsrv_has_rows($stmt4)) {
            echo "<p>No data found.</p>";
        } else {

            while ($laporan4 = sqlsrv_fetch_array($stmt4, SQLSRV_FETCH_ASSOC)) {
        ?>
                <div class="flex flex-col mx-auto gap-2 justify-between w-80 h-fit px-8 py-6 rounded-xl shadow-xl border"
                    id="cardPelanggaran">
                    <div class="flex items-center justify-center w-14 h-14 bg-blue-600 rounded-full text-white text-3xl"><?= htmlspecialchars($laporan4['Tingkat']) ?>
                    </div>
                    <p class="text-sm text-slate-600">Laporan ditolak admin</p>
                    <h3 class="text-xl"><?= htmlspecialchars($laporan4['Nama_Pelanggaran']) ?></h3>
                    <span class="flex gap-3 items-center">
                        <!-- <div class="w-8 h-8 rounded-full bg-slate-300"></div> -->
                        <p> <b>Pelapor: </b><?= htmlspecialchars($laporan4['Nama']) ?></p>
                    </span>
                    <a href="../Mahasiswa/DetailPelanggaran.php?ID_Laporan=<?= $laporan4['ID_Laporan'] ?>" class="btn btn-primary w-24 my-2" style="font-family: 'product Sans Bold';">Detail</a>
                </div>
        <?php
            }
        }
        ?>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', () => {
            const shortDescElements = document.querySelectorAll('.text-xl');
            const maxLength = 50;

            shortDescElements.forEach(shortDesc => {
                const text = shortDesc.textContent;

                if (text.length > maxLength) {
                    shortDesc.textContent = text.substring(0, maxLength) + '...';
                }
            });
        });
</script>
</html>