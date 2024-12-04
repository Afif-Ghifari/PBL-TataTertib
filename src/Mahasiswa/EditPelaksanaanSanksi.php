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
    <?php include 'Navbar.php'; ?>
    <main class="px-28 my-36">
        <h2 class="text-3xl text-center my-2">Pelaksanaan Sanksi</h2>
        <p class="text-center">Silakan anda mengerjakan tanggung jawab anda untuk mengerjakan tugas yang diberikan admin
            untuk membersikan Auditorium lantai 8 dan untuk bukti silakan upload foto dokumentasi dalam pelaksanaan
            pembersian auditorium</p>


        <form class="w-full px-20 py-12 rounded-xl shadow-lg my-20" action="" method="post">
            <label class="block mb-2 text-sm font-medium text-gray-900 " for="file_input">Upload
                file</label>
            <input class="form-control mb-5" id="file_input" type="file">

            <label for="">Deskripsi</label>
            <textarea class="form-control" name="" id="Deskripsi">

            </textarea>
            <input type="submit" value="Submit" class="btn btn-primary rounded-xl w-full mx-auto mt-8 py-2">
        </form>
    </main>
    <?php include '../Footer.php' ?>

</body>

</html>