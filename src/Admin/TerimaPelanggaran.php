<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/font.css">
    <link rel="icon" href="../../assets/img/LOGO BREN.pdf.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/faq-style.css">
</head>

<body class="flex">
    <?php include "Sidebar.php"; ?>

    <main class="w-full h-fullbg-slate-200 ml-72">
        <nav class="flex gap-10 w-full items-center justify-end px-28 py-6 bg-white">
            <button class="relative inline-flex items-center" id="NotifBtn">
                <i class="bi bi-bell text-3xl text-slate-300"></i>
                <div class="absolute inline-flex items-center justify-center w-3 h-3 bg-red-500 rounded-full -top-1 -end-1 dark:border-gray-900"></div>
            </button>
            <a href="../Dosen/Profile.php" class="size-10 rounded-full border overflow-hidden">
                <img src="../../assets/img/pp_sample.jpg" class="w-full h-full object-cover" alt="">
            </a>
        </nav>
        <section class="flex flex-col w-full px-14 py-12 gap-10">
            <form class="w-full px-20 py-12 rounded-xl shadow-lg" action="" method="post">

                <label class="block mb-2 text-sm font-medium text-gray-900 " for="file_input">Foto Bukti</label>
                <img src="../../assets/img/sample_pelanggaran.png" class="w-96 mx-auto my-3" alt="">

                <div class="flex justify-between gap-24 w-full my-8">
                    <span class="w-full">
                        <label for="">
                            Nama Terlapor
                        </label>
                        <input type="text" class="form-control" id="NamaTerlapor">
                    </span>
                    <span class="w-full">
                        <label for="">
                            NIM
                        </label>
                        <input type="text" class="form-control" id="Admin">
                    </span>
                </div>
                <div class="flex justify-between gap-24 w-full my-8">
                    <span class="w-full">
                        <label for="">
                            Nama Pelapor
                        </label>
                        <input type="text" class="form-control" id="NamaTerlapor">
                    </span>
                    <span class="w-full">
                        <label for="">
                            NIP
                        </label>
                        <input type="text" class="form-control" id="Admin">
                    </span>
                </div>
                <div class="flex justify-between gap-24 w-full my-8">
                    <span class="w-full">
                        <label for="">
                            Tempat Kejadian
                        </label>
                        <input type="text" class="form-control" id="Tempat">
                    </span>
                    <span class="w-full">
                        <label for="">
                            Tanggal Kejadian
                        </label>
                        <input type="text" class="form-control" id="Tanggal">
                    </span>
                </div>
                <div class="flex justify-between gap-24 w-full my-8">
                    <span class="w-full">
                        <label for="">
                            Jenis Pelanggaran
                        </label>
                        <input type="text" class="form-control" id="Tempat">
                    </span>
                    <span class="w-full">
                        <label for="">
                            Tingkat Pelanggaran
                        </label>
                        <input type="text" class="form-control" id="Tanggal">
                    </span>
                </div>
                <!-- <label for="">Jenis Pelanggaran</label>
                <select name="" class="form-control mb-8" id="JenisPelanggaran">
                    <option value="" selected>Pilih Jenis Pelanggaran</option>
                    <option value="">Pelanggaran 1</option>
                    <option value="">Pelanggaran 2</option>
                    <option value="">Pelanggaran 3</option>
                    <option value="">Pelanggaran 4</option>
                    <option value="">Pelanggaran 5</option>
                </select> -->

                <label for="">Deskripsi</label>
                <textarea class="form-control" name="" id="Deskripsi"></textarea>

                <input type="submit" value="Terima" class="btn btn-primary rounded-xl w-full mx-auto my-3 py-2">
                <input type="submit" value="Tolak" class="btn btn-danger rounded-xl w-full mx-auto my-3 py-2">
        </section>
    </main>
</body>

</html>