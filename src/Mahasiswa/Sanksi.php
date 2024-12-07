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
    <div class="grid grid-cols-2 justify-between gap-4 my-12" id="gridSanksi">
        <?php
        include "../../backend/database.php";

        $query = "SELECT l.ID_Laporan, l.ID_Dilapor, p.ID_Pelanggaran, d.NIP, d.Nama, p.Nama_Pelanggaran, p.Tingkat 
                    FROM Laporan l
                    JOIN Pelanggaran p ON l.ID_Pelanggaran = p.ID_Pelanggaran
                    JOIN Dosen d ON l.ID_Pelapor = d.NIP
                    WHERE l.ID_Dilapor = ?";
        $params = [$_SESSION['NIM']];
        $stmt = sqlsrv_query($conn, $query, $params);

        if (!$stmt) {
            die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
        }

        if (!sqlsrv_has_rows($stmt)) {
            echo "<p>No data found.</p>";
        } else {

            while ($laporan = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        ?>
                <div class="flex flex-col mx-auto justify-between w-80 h-96 px-8 py-6 rounded-xl shadow-xl border" id="cardSanksi">
                    <h2 class="text-black">Nama Sanksi</h2>
                    <img src="../../assets/img/pp_sample.jpg" class="mx-auto rounded-xl max-w-52" alt="">
                    <p class="text-black">Deskripsi</p>
                    <a href="../Mahasiswa/EditPelaksanaanSanksi.php" class="btn btn-primary w-24"
                        style="font-family: 'product Sans Bold';">Detail</a>
                </div>
        <?php
            }
        }
        ?>
    </div>
</body>

</html>