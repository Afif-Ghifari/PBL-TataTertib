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
    <div class="grid grid-cols-3 justify-between gap-4 my-12" id="gridListTunggu">
        <?php
        include "../../backend/database.php";

        $query1 = "SELECT l.ID_Laporan, l.ID_Dilapor, p.ID_Pelanggaran, d.NIP, d.Nama, p.Nama_Pelanggaran, p.Tingkat, l.Status 
                    FROM Laporan l
                    JOIN Pelanggaran p ON l.ID_Pelanggaran = p.ID_Pelanggaran
                    JOIN Dosen d ON l.ID_Pelapor = d.NIP
                    WHERE l.Status = 'Baru' AND l.ID_Dilapor = ?";
        $params1 = [$_SESSION['NIM']];
        $stmt1 = sqlsrv_query($conn, $query1, $params1);

        if (!$stmt1) {
            die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
        }

        if (!sqlsrv_has_rows($stmt1)) {
            echo "<p>No data found.</p>";
        } else {

            while ($laporan = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        ?>
                <div class="flex flex-col mx-auto justify-between w-80 h-96 px-8 py-6 rounded-xl shadow-xl border"
                    id="cardPelanggaran">
                    <div class="flex items-center justify-center w-14 h-14 bg-blue-600 rounded-full text-white text-3xl"><?= htmlspecialchars($laporan['Tingkat']) ?>
                    </div>
                    <p class="text-sm text-amber-600">Mohon Tunggu Konformasi Admin</p>
                    <h3 class="text-xl"><?= htmlspecialchars($laporan['Nama_Pelanggaran']) ?></h3>
                    <p class="text-base text-slate-600">Anda di laporan oleh dosen karena melakukan merokok ditempat yang
                        dilarang oleh kampus </p>
                    <span class="flex gap-3 items-center">
                        <div class="w-8 h-8 rounded-full bg-slate-300"></div>
                        <p><?= htmlspecialchars($laporan['Nama']) ?></p>
                    </span>
                    <a href="../Mahasiswa/DetailPelanggaran.html" class="btn btn-primary w-24"
                        style="font-family: 'product Sans Bold';">Detail</a>
                </div>
        <?php
            }
        }
        ?>
    </div>
    <div class="grid grid-cols-3 justify-between gap-4 my-12" id="gridListKonfirmasi">
        <?php
        include "../../backend/database.php";

        $query2 = "SELECT l.ID_Laporan, l.ID_Dilapor, p.ID_Pelanggaran, d.NIP, d.Nama, p.Nama_Pelanggaran, p.Tingkat, l.Status 
                    FROM Laporan l
                    JOIN Pelanggaran p ON l.ID_Pelanggaran = p.ID_Pelanggaran
                    JOIN Dosen d ON l.ID_Pelapor = d.NIP
                    WHERE l.Status = 'Diverifikasi' AND l.ID_Dilapor = ?";
        $params2 = [$_SESSION['NIM']];
        $stmt2 = sqlsrv_query($conn, $query2, $params2);

        if (!$stmt2) {
            die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
        }

        if (!sqlsrv_has_rows($stmt2)) {
            echo "<p>No data found.</p>";
        } else {

            while ($laporan = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        ?>
                <div class="flex flex-col mx-auto justify-between w-80 h-96 px-8 py-6 rounded-xl shadow-xl border"
                    id="cardPelanggaran">
                    <div class="flex items-center justify-center w-14 h-14 bg-blue-600 rounded-full text-white text-3xl">II
                    </div>
                    <p class="text-sm text-green-600">Banding anda sudah diverifikasi admin</p>
                    <h3 class="text-xl">Ketahuan merokok ditempat yang dilarang</h3>
                    <p class="text-base text-slate-600">Anda di laporan oleh dosen karena melakukan merokok ditempat yang
                        dilarang oleh kampus </p>
                    <span class="flex gap-3 items-center">
                        <div class="w-8 h-8 rounded-full bg-slate-300"></div>
                        <p>Dosen</p>
                    </span>
                    <a href="../Mahasiswa/DetailPelanggaran.html" class="btn btn-primary w-24"
                        style="font-family: 'product Sans Bold';">Detail</a>
                </div>
        <?php
            }
        }
        ?>
    </div>
    <div class="grid grid-cols-3 justify-between gap-4 my-12" id="gridListTolak">

        <div class="flex flex-col mx-auto justify-between w-80 h-96 px-8 py-6 rounded-xl shadow-xl border"
            id="cardPelanggaran">
            <div class="flex items-center justify-center w-14 h-14 bg-blue-600 rounded-full text-white text-3xl">II
            </div>
            <p class="text-sm text-red-600">Banding anda ditolak admin </p>
            <h3 class="text-xl">Ketahuan merokok ditempat yang dilarang</h3>
            <p class="text-base text-slate-600">Anda di laporan oleh dosen karena melakukan merokok ditempat yang
                dilarang oleh kampus </p>
            <span class="flex gap-3 items-center">
                <div class="w-8 h-8 rounded-full bg-slate-300"></div>
                <p>Dosen</p>
            </span>
            <a href="../Mahasiswa/DetailPelanggaran.html" class="btn btn-primary w-24"
                style="font-family: 'product Sans Bold';">Detail</a>
        </div>

    </div>
</body>

</html>