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
    <h2>Banding Laporan</h2>
    <div class="grid grid-cols-3 justify-between gap-4 my-12" id="gridListTunggu">
        <?php
        include "../../backend/database.php";

        $query_banding = "SELECT b.ID_Banding, b.Keterangan, l.ID_Laporan, l.ID_Dilapor, p.ID_Pelanggaran, d.NIP, d.Nama, p.Nama_Pelanggaran, p.Tingkat, l.Status 
                    FROM Banding b
                    JOIN Laporan l ON b.ID_Laporan = l.ID_Laporan
                    JOIN Pelanggaran p ON l.ID_Pelanggaran = p.ID_Pelanggaran
                    JOIN Dosen d ON l.ID_Pelapor = d.NIP
                    WHERE l.ID_Dilapor = ?";
        $params_banding = [$_SESSION['NIM']];
        $stmt_banding = sqlsrv_query($conn, $query_banding, $params_banding);

        if (!$stmt_banding) {
            die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
        }

        if (!sqlsrv_has_rows($stmt_banding)) {
            echo "<p>No data found.</p>";
        } else {

            while ($banding = sqlsrv_fetch_array($stmt_banding, SQLSRV_FETCH_ASSOC)) {
        ?>
                <div class="flex flex-col gap-2 mx-auto justify-between w-80 h-fit px-8 py-6 rounded-xl shadow-xl border"
                    id="cardPelanggaran">
                    <div class="flex items-center justify-center w-14 h-14 bg-blue-600 rounded-full text-white text-3xl"><?= htmlspecialchars($banding['Tingkat']) ?>
                    </div>
                    <p class="text-sm text-amber-600 my-1">Laporan terhadap anda dikonfirmasi</p>
                    <h3 class="text-xl"><?= htmlspecialchars($banding['Nama_Pelanggaran']) ?></h3>
                    <span class="flex gap-3 items-center">
                        <!-- <div class="w-8 h-8 rounded-full bg-slate-300"></div> -->
                        <p><b>Pelapor: </b><?= htmlspecialchars($banding['Nama']) ?></p>
                    </span>
                    <h6>Keterangan Banding: </h6>
                    <p><?= htmlspecialchars($banding['Keterangan']) ?></p>
                    <a href="" class="btn btn-primary w-24 my-2" style="font-family: 'product Sans Bold';">Detail</a>
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
            const maxLength = 60;

            shortDescElements.forEach(shortDesc => {
                const text = shortDesc.textContent;

                if (text.length > maxLength) {
                    shortDesc.textContent = text.substring(0, maxLength) + '...';
                }
            });
        });
</script>
</html>