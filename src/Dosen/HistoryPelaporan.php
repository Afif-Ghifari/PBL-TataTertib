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
    <nav
        class="absolute top-0 flex justify-between items-center w-full py-8 px-12 md:px-28 bg-transparent text-slate-100">
        <a href="" class="w-1/3 flex items-center gap-4 text-xl text-black" id="NavBrand"><img
                src="../../assets/img/LOGO BREN.pdf.png" class="w-14 rounded-lg" alt="" />TertibHub</a>
        <div class="flex justify-evenly gap-2 w-1/3 text-black">
            <a href="../Mahasiswa/Dashboard.html"
                class="border-2 pb-1 border-transparent hover:border-b-2 hover:border-b-white">Home</a>
            <a href="#" class="border-2 pb-1 border-transparent border-b-2 border-b-black">Histori
                Pelanggaran</a>
            <a href="" class="border-2 pb-1 border-transparent hover:border-b-2 hover:border-b-white">Guide Book</a>
        </div>
        <div class="relative w-1/3 flex justify-end items-center gap-8" id="LoginBtn">
            <button class="relative inline-flex items-center" id="NotifBtn">
                <i class="bi bi-bell text-3xl text-black"></i>
                <div
                    class="absolute inline-flex items-center justify-center w-3 h-3 bg-red-500 rounded-full -top-1 -end-1 dark:border-gray-900">
                </div>
            </button>
            <div class="absolute hidden flex-col min-h-96 w-96 bg-white rounded-xl top-10 left-2 px-8 py-6"
                id="NotifList">
                <div class="w-full flex justify-between text-black text-xl">
                    <h4>Notifikasi</h4>
                    <button id="closeNotif">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="flex flex-col gap-4 mt-4 overflow-auto">
                    <div class="">

                    </div>
                </div>
            </div>

            <a href="../Mahasiswa/Profile.html" class="size-10 rounded-full border overflow-hidden">
                <img src="../../assets/img/pp_sample.jpg" class="w-full h-full object-cover" alt="">
            </a>
        </div>
    </nav>
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
            <script>
                const filterButtons = document.querySelectorAll("#filterList button");
                const gridTunggu = document.getElementById("gridListTunggu");
                const gridKonfirmasi = document.getElementById("gridListKonfirmasi");
                const gridTolak = document.getElementById("gridListTolak");
            
                function resetGrids() {
                    gridTunggu.style.display = "none";
                    gridKonfirmasi.style.display = "none";
                    gridTolak.style.display = "none";
                }
            
                filterButtons.forEach((button, index) => {
                    button.addEventListener("click", () => {
                        resetGrids(); 
                        
                        switch (index) {
                            case 0:
                                gridTunggu.style.display = "grid";
                                gridKonfirmasi.style.display = "grid";
                                gridTolak.style.display = "grid";
                                break;
                            case 1:
                                gridTunggu.style.display = "grid"; 
                                break;
                            case 2:
                                gridKonfirmasi.style.display = "grid"; 
                                break;
                        }
            
                        filterButtons.forEach((btn) => btn.classList.remove("bg-blue-600", "text-white"));
                        button.classList.add("bg-blue-600", "text-white");
                    });
                });
            
                resetGrids();
                gridTunggu.style.display = "grid";
                gridKonfirmasi.style.display = "grid";
                gridTolak.style.display = "grid";
            </script>
            
            <div class="grid grid-cols-3 justify-between gap-4 my-12" id="gridList">
            <?php
                // Include database connection
                include "../../backend/database.php";

                // SQL query to fetch data
                $qry_laporan = "
                    SELECT 
                        l.laporan, 
                        p.Nama_Pelanggaran, 
                        p.Tingkat 
                    FROM 
                        laporan l 
                    JOIN 
                        pelanggaran p 
                    ON 
                        l.pelanggaran_id = p.id_pelanggaran 
                    WHERE 
                        l.id_dosen = ?";
                
                // Prepare the statement
                $params = [$_SESSION['id_dosen']];
                $stmt = sqlsrv_prepare($conn, $qry_laporan, $params);

                // Execute the statement
                if (!sqlsrv_execute($stmt)) {
                    die("Query Error: " . print_r(sqlsrv_errors(), true));
                }

                // Loop through the records
                while ($data_laporan = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            ?>
                <div class="flex flex-col mx-auto justify-between w-80 h-96 px-8 py-6 rounded-xl shadow-xl border" id="cardPelanggaran">
                    <div class="flex items-center justify-center w-14 h-14 bg-blue-600 rounded-full text-white text-3xl">
                        <?= htmlspecialchars($data_laporan['Tingkat']) ?>
                    </div>
                    <h3 class="text-xl"><?= htmlspecialchars($data_laporan['Nama_Pelanggaran']) ?></h3>
                    <span class="flex gap-3 items-center">
                        <a href="../Mahasiswa/DetailPelanggaran.html" class="btn btn-primary w-24" style="font-family: 'product Sans Bold';">
                            Detail
                        </a>
                    </span>
                </div>
            <?php
                } // End of while loop
            ?>
            </div>
        </section>
        
    </main>
    <footer class="w-full h-32 flex items-center justify-between text-white text-xl px-12">
        <h5>TatibHub By Politeknik Negeri Malang</h5>
        <h5>© 2024 Alleviate. All rights reserved.</h5>
    </footer>
</body>

</html>