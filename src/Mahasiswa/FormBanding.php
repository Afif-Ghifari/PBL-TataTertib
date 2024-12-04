<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banding</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../assets/font.css">
    <link rel="icon" href="../../assets/img/LOGO BREN.pdf.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="flex w-full">
    <section class="px-14 py-6 w-full">
        <a class="text-xl btn btn-transparent font-bold my-3" href="../Mahasiswa/Dashboard.php"><i
                class="bi bi-chevron-left"></i> Kembali</a>
        <h2 class="text-3xl my-3">Banding jika merasa laporan ini tidak sesuai!!</h2>
        <p>Silakan ajukan banding apabila Anda merasa bahwa bukti pelaporan yang tertera tidak sepenuhnya akurat atau
            terdapat ketidaksesuaian dengan fakta yang sebenarnya.</p>
        <img src="../../assets/img/FormBandingImg.png" alt="">
    </section>
    <form class="w-full flex flex-col justify-evenly bg-blue-700 rounded-l-3xl text-white px-14 py-6" action="" method="post">
        <h2 class="text-3xl my-3">Proses Banding</h2>
        <p>Silakan isi form yang sudah kami sediakan, isi dengan lengkap kalau benar benar anda tidak melakukan nya</p>

        <label for="" class="flex flex-col gap-2 my-6">ID Laporan
            <input type="text" class="border py-2 px-4 rounded-xl bg-slate-300  focus:outline-none w-full" value="" placeholder="ID Laporan" name="ID_Laporan" disabled>
        </label>
        <label for="" class="flex flex-col gap-2 my-6">NIM
            <input type="text" class="border py-2 px-4 rounded-xl bg-white w-full" value="" placeholder="NIM" name="NIM">
        </label>
        <label for="" class="flex flex-col gap-2 my-6">Keterangan
            <textarea type="text" class="border py-2 px-4 rounded-xl bg-white w-full" name="Keterangan"></textarea>
        </label>

        <input type="submit" value="Submit" class="btn btn-primary w-1/2 mx-auto my-8">

    </form>
</body>

</html>