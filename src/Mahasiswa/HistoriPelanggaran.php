<?php
    session_start();
    if (!isset($_SESSION['NIM'])) {
        header("Location: ../Login.html");
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

    <script>
        document.addEventListener("DOMoaded", () => {
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
    <main class="flex flex-col px-28 my-36">
        <header class="flex flex-col gap-4 justify-start text-start w-1/2">
            <h1 class="text-4xl font-bold">Histori Pelanggaran</h1>
            <p class="text-lg">History Pelanggaran adalah fitur untuk melihat riwayat pelanggaran mahasiswa, mencakup detail seperti
                jenis pelanggaran, tanggal, dan status penyelesaiannya.</p>
        </header>

        <section class="flex flex-col my-36" id="listPelanggaran">
            <div class="flex px-6 py-2 justify-between gap-3 bg-slate-300 rounded-full" style="font-family: 'product Sans Bold';" id="filterList">
                <button id="BtnSemua" class="w-full px-12 py-2 bg-blue-600 text-white rounded-3xl">Semua</button>
                <button id="BtnStatus" class="w-full px-12 py-2 text-black rounded-3xl">Status Sanksi</button>
                <button id="BtnBanding" class="w-full px-12 py-2 text-black rounded-3xl">Banding</button>
                <button id="BtnProses" class="w-full px-12 py-2 text-black rounded-3xl">Pengerjaan Sanksi</button>
            </div>

            <div class="gap-4 my-12" id="gridList">

                <div id="listSemua" class="inline w-full">
                    <?php include 'SemuaPelanggaran.php' ?>
                </div>
                <div id="listStatus" class="hidden">
                    <?php include 'ListStatus.php' ?>
                </div>
                <div id="listBanding" class="hidden">
                    <?php include 'Banding.php' ?>
                </div>
                <div id="listProses" class="hidden">
                    <?php include 'Sanksi.php' ?>
                </div>
            </div>
        </section>

    </main>
    <?php include '../Footer.php' ?>
</body>

<script>
    const BtnSemua = document.getElementById("BtnSemua");
    const BtnStatus = document.getElementById("BtnStatus");
    const BtnBanding = document.getElementById("BtnBanding");
    const BtnProses = document.getElementById("BtnProses");

    const listSemua = document.getElementById("listSemua");
    const listStatus = document.getElementById("listStatus");
    const listBanding = document.getElementById("listBanding");
    const listProses = document.getElementById("listProses");

    BtnSemua.addEventListener("click", () => {
        BtnSemua.classList.add("bg-blue-600", "text-white");
        BtnStatus.classList.remove("bg-blue-600", "text-white");
        BtnBanding.classList.remove("bg-blue-600", "text-white");
        BtnProses.classList.remove("bg-blue-600", "text-white");

        listSemua.classList.remove("hidden");
        listSemua.classList.add("inline");
        listStatus.classList.add("hidden");
        listBanding.classList.add("hidden");
        listProses.classList.add("hidden");
    })

    BtnStatus.addEventListener("click", () => {
        BtnSemua.classList.remove("bg-blue-600", "text-white");
        BtnStatus.classList.add("bg-blue-600", "text-white");
        BtnBanding.classList.remove("bg-blue-600", "text-white");
        BtnProses.classList.remove("bg-blue-600", "text-white");

        listSemua.classList.add("hidden");
        listStatus.classList.remove("hidden");
        listStatus.classList.add("inline");
        listBanding.classList.add("hidden");
        listProses.classList.add("hidden");
    })

    BtnBanding.addEventListener("click", () => {
        BtnSemua.classList.remove("bg-blue-600", "text-white");
        BtnStatus.classList.remove("bg-blue-600", "text-white");
        BtnBanding.classList.add("bg-blue-600", "text-white");
        BtnProses.classList.remove("bg-blue-600", "text-white");

        listSemua.classList.add("hidden");
        listStatus.classList.add("hidden");
        listBanding.classList.remove("hidden");
        listBanding.classList.add("inline");
        listProses.classList.add("hidden");
    })

    BtnProses.addEventListener("click", () => {
        BtnSemua.classList.remove("bg-blue-600", "text-white");
        BtnStatus.classList.remove("bg-blue-600", "text-white");
        BtnBanding.classList.remove("bg-blue-600", "text-white");
        BtnProses.classList.add("bg-blue-600", "text-white");

        listSemua.classList.add("hidden");
        listStatus.classList.add("hidden");
        listBanding.classList.add("hidden");
        listProses.classList.remove("hidden");
        listProses.classList.add("inline");
    })
</script>
<!-- <script>
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
</script> -->

</html>