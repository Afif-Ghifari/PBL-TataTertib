<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/HistoriPelanggaran.css">
    <link rel="icon" href="../../assets/img/LOGO BREN.pdf.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Detail Pelanggaran</title>
</head>

<body>
    <nav class="w-full px-28 py-6">
        <a href="../Mahasiswa/HistoriPelanggaran.php" id="backButton" class="text-xl btn btn-transparent font-bold">
            <i class="bi bi-chevron-left"></i> Kembali
        </a>
    </nav>
    <script>
        document.getElementById("backButton").addEventListener("click", () => {
            const previousPage = sessionStorage.getItem("previousPage");
            if (previousPage) {
                window.location.href = previousPage;
            } else {
                history.back();
            }
        });
    </script>
    
    
    <main class="mx-28 mb-32 mt-8 flex">
        <section class="w-2/3 h-fit">
            <img src="../../assets/img/sample_pelanggaran.png" class="max-w-2xl rounded-2xl mb-10" alt="">
            <div class="pr-24">
                <h2 class="text-xl">Ketahuan merokok ditempat yang dilarang</h2>
                <h4 class="text-sm text-slate-600">Pelanggaran Tingkat III</h4>
                <span class="flex items-center gap-3 my-7">
                    <div class="size-10 rounded-full border overflow-hidden">
                        <img src="../../assets/img/pp_sample.jpg" class="w-full h-full object-cover" alt="">
                    </div>
                    <h6>Dwi Setiawan Spd, Mpd</h6>
                </span>
                <h5 class="my-2 text-lg">Deskripsi Pelaporan</h5>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugiat aperiam necessitatibus cumque labore
                    iusto
                    sint veniam, accusamus aliquam officiis. Facilis error eos itaque quasi neque obcaecati eum placeat
                    aliquam,
                    qui, soluta esse labore maiores accusantium odio distinctio culpa, aperiam vel? Fugiat quos corrupti
                    praesentium modi. Provident ad placeat alias officia inventore ut cupiditate harum impedit et. Odio
                    e
                    xcepturi, harum eius natus distinctio nesciunt illum veniam? Magnam rem tenetur perferendis hic
                    alias ipsa
                    adipisci suscipit ipsum repellat!</p>
            </div>
        </section>
        <aside class="w-1/3">
            <div class="w-full border shadow-lg rounded-lg px-12 py-8">
                <h3>Lihat Pedoman tatib</h3>
                <a href="../PDF/BukuPedoman.pdf" download="Pedoman Tata Tertib" class="flex flex-row w-full justify-between items-center text-black no-underline h-fit border border-black px-4 py-2 rounded-xl">
                    <i class="bi bi-file-earmark-pdf-fill text-blue-600 text-2xl"></i>
                    <span class="text-start">
                        <h6 class="text-sm my-0">Pedoman Tata Tertib.pdf</h6>
                        <p   class="text-sm my-0">4.3 MB</p>
                    </span>
                    <i class="bi bi-download text-2xl"></i>
                </a>
                <div class="w-full px-8 py-3 my-8 bg-gradient-to-r from-blue-900 to-black rounded-lg text-white">
                    <h4>Tempat Kejadian</h4>
                    <p class="text-slate-300">Di sana</p>
                </div>
                <div class="w-full px-8 py-3 mt-8 mb-6 bg-gradient-to-r from-blue-900 to-black rounded-lg text-white">
                    <h4>Tempat Kejadian</h4>
                    <p class="text-slate-300">Di sana</p>
                </div>
                <p class="text-red-600">
                    Apakah itu anda? kalau itu benar anda silakan konfirmasi!!
                </p>
                <div class="flex flex-col gap-3 my-6">
                    <a href="EditPelaksanaanSanksi.php" class="btn btn-primary w-full">Konfirmasi</a>
                    <a href="FormBanding.php" class="btn btn-light w-full border border-black">Ajukan banding</a>
                </div>
            </div>
        </aside>
    </main>

    <?php include '../Footer.php' ?>
</body>

</html>