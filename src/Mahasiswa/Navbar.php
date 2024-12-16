<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/HistoriPelanggaran.css">
    <link rel="icon" href="../../assets/img/LOGO BREN.pdf.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <nav
        class="absolute top-0 flex justify-between items-center w-full py-8 px-12 md:px-28 bg-transparent text-slate-100">
        <a href="#" class="w-1/3 flex items-center gap-4 text-xl no-underline" id="NavBrand"><img src="../../assets/img/LOGO BREN.pdf.png"
                class="w-14 rounded-lg" alt="" />TertibHub</a>
        <div class="flex justify-evenly gap-2 w-1/3">
            <a href="Dashboard.php" class="border-2 pb-1 border-transparent hover:border-b-2 hover:border-b-white no-underline">Home</a>
            <a href="HistoriPelanggaran.php" class="border-2 pb-1 border-transparent hover:border-b-2 hover:border-b-white no-underline">Histori
                Pelanggaran</a>
            <!-- <a href="GuideBook.php"
                class="border-2 pb-1 border-transparent hover:border-b-2 hover:border-b-white no-underline">Guide Book</a> -->
        </div>
        <div class="relative w-1/3 flex justify-end items-center gap-8" id="LoginBtn">
            <button class="relative inline-flex items-center" id="NotifBtn">
                <i class="bi bi-bell text-3xl text-slate-300"></i>
                <div class="absolute inline-flex items-center justify-center w-3 h-3 bg-red-500 rounded-full -top-1 -end-1 dark:border-gray-900"></div>
            </button>
            <a href="../../backend/logout.php" class="relative inline-flex items-center" id="LogoutBtn">
                <i class="bi bi-box-arrow-in-right text-3xl text-slate-300"></i>
            </a>
            <div class="absolute flex flex-col min-h-96 w-96 bg-white rounded-xl top-10 left-2 px-8 py-6 border" id="NotifList">
                <div class="w-full flex justify-between text-black text-xl">
                    <h4>Notifikasi</h4>
                    <button id="closeNotif">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="flex flex-col gap-4 mt-4 overflow-auto max-h-80">

                    <?php
                    include "../../backend/database.php";
                    // $nim = $_SESSION['NIM'];
                    $query_notif = "SELECT 
                                    l.ID_Laporan,
                                    m.NIM, 
                                    m.Nama as NamaMahasiswa,
                                    l.Status,
                                    l.TanggalDibuat,
                                    p.ID_Pelanggaran,
                                    p.Nama_Pelanggaran
                                    FROM laporan l
                                    JOIN Mahasiswa m ON l.ID_Dilapor = m.NIM
                                    JOIN Pelanggaran p ON l.ID_Pelanggaran = p.ID_Pelanggaran
                                    WHERE l.ID_Dilapor = ?";
                    $params = [$_SESSION['NIM']];
                    $stmt = sqlsrv_query($conn, $query_notif, $params);

                    if (!$stmt) {
                        die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
                    }

                    if (!sqlsrv_has_rows($stmt)) {
                        echo "<p class='text-black'>Tidak ada notifikasi.</p>";
                    } else {
                        while ($notif = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    ?>

                            <div class="flex flex-col gap-2 text-black border-b-2 pb-3">
                                <span class="flex justify-between items-center gap-3">
                                    <h5><?= htmlspecialchars($notif['NamaMahasiswa']) ?></h5>
                                    <?php
                                    if ($notif['Status'] == 'Pending') {
                                        echo '<p class="text-sm text-red-600">Laporan Baru</p>';
                                    } else if ($notif['Status'] == 'Dikonfirmasi') {
                                        echo '<p class="text-sm text-amber-600">Dikonfirmasi</p>';
                                    } else if ($notif['Status'] == 'Ditolak') {
                                        echo '<p class="text-sm text-slate-600">Ditolak</p>';
                                    } else if ($notif['Status'] == 'Selesai') {
                                        echo '<p class="text-sm text-green-600">Selesai</p>';
                                    }
                                    ?>
                                </span>
                                <p class="ShortDesc"><?= htmlspecialchars($notif['Nama_Pelanggaran']) ?></p>
                                <span class="flex items-center justify-between text-sm text-slate-500">
                                    <p><?= htmlspecialchars(
                                            $notif['TanggalDibuat'] instanceof DateTime
                                                ? $notif['TanggalDibuat']->format('Y-m-d')
                                                : $notif['TanggalDibuat']
                                        ) ?></p>
                                    <!-- <p>2 Jam yang lalu</p> -->
                                </span>
                                <a href="../Mahasiswa/DetailPelanggaran.php?ID_Laporan=<?= $notif['ID_Laporan'] ?>" class="btn btn-primary">Detail</a>
                            </div>

                    <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <a href="../Mahasiswa/Profile.php" class="size-10 rounded-full border overflow-hidden">
                <img src="../../assets/img/pp_sample.jpg" class="w-full h-full object-cover" alt="">
            </a>
        </div>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const shortDescElements = document.querySelectorAll('.ShortDesc');
            const maxLength = 40;

            shortDescElements.forEach(shortDesc => {
                const text = shortDesc.textContent;

                if (text.length > maxLength) {
                    shortDesc.textContent = text.substring(0, maxLength) + '...';
                }
            });
        });

        document.addEventListener("DOMContentLoaded", () => {
            const closeNotifButton = document.getElementById("closeNotif");
            const notifList = document.getElementById("NotifList");
            const notifBtn = document.getElementById("NotifBtn");

            function saveNotifStatus(isHidden) {
                localStorage.setItem("notifStatus", isHidden ? "hidden" : "visible");
            }

            const savedStatus = localStorage.getItem("notifStatus");
            if (savedStatus === "hidden") {
                notifList.classList.add("hidden");
            }

            closeNotifButton.addEventListener("click", () => {
                notifList.classList.add("hidden");
                saveNotifStatus(true);
            });

            notifBtn.addEventListener("click", () => {
                notifList.classList.toggle("hidden");
                saveNotifStatus(notifList.classList.contains("hidden"));
            });
        });
    </script>
</body>

</html>