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
    <div class="grid grid-cols-3 justify-between gap-4 my-12" id="gridSanksi">
        <?php
        include "../../backend/database.php";

        $query = "SELECT l.ID_Laporan, l.ID_Dilapor, l.Sanksi, b.ID_Bukti, b.Foto, b.Deskripsi, p.ID_Pelanggaran, p.Nama_Pelanggaran
                    FROM Laporan l
                    JOIN Bukti_Pengerjaan b ON l.ID_Bukti = b.ID_Bukti
                    JOIN Pelanggaran p ON l.ID_Pelanggaran = p.ID_Pelanggaran
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
                <div class="flex flex-col mx-auto justify-between w-80 h-fit px-8 py-6 rounded-xl shadow-xl border" id="cardSanksi">
                    <h2 class="text-black text-xl"><?= htmlspecialchars($laporan['Sanksi']) ?></h2>
                    <img src="../../backend/<?= htmlspecialchars($laporan['Foto']) ?>" class="mx-auto rounded-xl w-full" alt="">
                    <p class="text-black text-base my-4"><?= htmlspecialchars($laporan['Nama_Pelanggaran']) ?></p>
                    <a href="../Mahasiswa/EditPelaksanaanSanksi.php?ID_Laporan=<?= $laporan['ID_Laporan'] ?>" class="btn btn-primary w-24"
                        style="font-family: 'product Sans Bold';">Edit</a>
                </div>
        <?php
            }
        }
        ?>
    </div>
</body>
<script>
document.addEventListener('DOMContentLoaded', () => {
            const shortDescElements = document.querySelectorAll('.text-black.text-base.my-4');
            const maxLength = 70;

            shortDescElements.forEach(shortDesc => {
                const text = shortDesc.textContent;

                if (text.length > maxLength) {
                    shortDesc.textContent = text.substring(0, maxLength) + '...';
                }
            });
        });
</script>
</html>