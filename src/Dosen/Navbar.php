<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/font.css">
    <link rel="icon" href="../../assets/img/LOGO BREN.pdf.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<nav
    class="absolute top-0 flex justify-between items-center w-full py-8 px-12 md:px-28 bg-transparent text-slate-100">
    <a href="#" class="w-1/3 flex items-center gap-4 text-xl no-underline" id="NavBrand"><img src="../../assets/img/LOGO BREN.pdf.png"
            class="w-14 rounded-lg" alt="" />TertibHub</a>
    <div class="flex justify-evenly gap-2 w-1/3">
        <a href="../Dosen/Dashboard.php" class="border-2 pb-1 border-transparent hover:border-b-2 hover:border-b-white no-underline">Home</a>
        <a href="../Dosen/FormPelaporan.php" class="border-2 pb-1 border-transparent hover:border-b-2 hover:border-b-white no-underline">Form
            Pelaporan</a>
        <a href="../Dosen/HistoryPelaporan.php"
            class="border-2 pb-1 border-transparent hover:border-b-2 hover:border-b-white no-underline">History Pelaporan</a>
    </div>
    <div class="relative w-1/3 flex justify-end items-center gap-8" id="LoginBtn">
        <!-- <button class="relative inline-flex items-center" id="NotifBtn">
            <i class="bi bi-bell text-3xl text-slate-300"></i>
            <div class="absolute inline-flex items-center justify-center w-3 h-3 bg-red-500 rounded-full -top-1 -end-1 dark:border-gray-900"></div>
        </button> -->
        <a href="../../backend/logout.php" class="relative inline-flex items-center" id="LogoutBtn">
            <i class="bi bi-box-arrow-in-right text-3xl text-slate-300"></i>
        </a>
        <div class="absolute flex flex-col min-h-96 w-96 bg-white rounded-xl top-10 left-2 px-8 py-6" id="NotifList">
            <div class="w-full flex justify-between text-black text-xl">
                <h4>Notifikasi</h4>
                <button id="closeNotif">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="flex flex-col gap-4 mt-4 overflow-auto max-h-80">
                <div class="flex flex-col gap-2 text-black border-b-2 pb-3">
                    <span class="flex items-center gap-3">
                        <h3 class="text-lg">Aditya Nathanael</h3>
                        <p class="text-sm text-red-600">Peringatan!</p>
                    </span>
                    <span class="flex items-center justify-between text-sm text-slate-500">
                        <p>Jumat 12.30PM</p>
                        <p>2 Jam yang lalu</p>
                    </span>
                    <a href="../Dosen/DetailPelanggaran.html" class="btn btn-primary">Detail</a>
                </div>

            </div>
        </div>

        <a href="../Dosen/Profile.php" class="size-10 rounded-full border overflow-hidden">
            <img src="../../assets/img/pp_sample.jpg" class="w-full h-full object-cover" alt="">
        </a>
    </div>
</nav>
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
<script>
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

</html>