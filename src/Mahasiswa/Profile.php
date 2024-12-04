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
    <title>Profil User</title>
</head>
<body>
    <?php
        include "../../backend/database.php";
        session_start();

        $qry_profil = "SELECT * FROM Mahasiswa WHERE NIM = ?";
        $params = [$_SESSION['NIM']];
        $stmt = sqlsrv_prepare($conn, $qry_profil, $params);

        if (!$stmt) {
            die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
        }
    
        if (!sqlsrv_execute($stmt)) {
            die("Query Execute Error: " . print_r(sqlsrv_errors(), true));
        }
    
        // Fetch the result
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        if (!$row) {
            die("No data found.");
        }
    ?>
    <nav class="w-full px-28 py-10">
        <a class="text-xl btn btn-transparent font-bold" href="../Mahasiswa/Dashboard.html"><i class="bi bi-chevron-left"></i> Kembali</a>
    </nav>
    <header class="flex flex-col justify-between items-center w-full px-28 h-80">
        <div class="w-full h-1/2 bg-slate-600 rounded-t-xl"></div>
        <span class="flex flex-col items-center">    
            <div class="mx-auto w-32 h-32 rounded-full border -mt-56 mb-3 overflow-hidden">
                <img src="../../assets/img/pp_sample.jpg" class="w-full h-full object-cover" alt="">
            </div>
            <h4 class="text-2xl text-center" id="Nama"><?= htmlspecialchars($row['Nama'])?></h4>
            <h4 class="text-xl text-slate-500 text-center" id="NIM"><?= htmlspecialchars($row['NIM'])?></h4>
        </span>
    </header>

    <main class="mx-28 mb-32 mt-12 px-24 py-20 border h-fit">
        <h3 class="text-3xl">About Me</h3>
        <p><?= htmlspecialchars($row['Profil'])?></p>
        <form action="" class="flex flex-col justify-between">
            <div class="flex justify-between my-6">
                <label for="" class="flex flex-col gap-2">Alamat
                    <input type="text" class="border py-2 px-4 rounded-xl bg-slate-200 focus:outline-none w-96" value="<?= htmlspecialchars($row['Alamat'])?>" placeholder="Alamat">
                </label>
                <label for="" class="flex flex-col gap-2">Nomor Telepon
                    <input type="text" class="border py-2 px-4 rounded-xl bg-slate-200 focus:outline-none w-96" value="<?= htmlspecialchars($row['No_Tlp'])?>" placeholder="NoTelp">
                </label>
            </div>
            
            <div class="flex justify-between my-6">
                <label for="" class="flex flex-col gap-2">Username
                    <input type="text" class="border py-2 px-4 rounded-xl bg-slate-200 focus:outline-none w-96" value="<?= htmlspecialchars($row['Username'])?>" placeholder="Username">
                </label>
                <label for="" class="flex flex-col gap-2">Password
                    <input type="password" class="border py-2 px-4 rounded-xl bg-slate-200 focus:outline-none w-96" value="<?= htmlspecialchars($row['Pw'])?>" placeholder="Password">
                </label>
            </div>
        </form>
    </main>
    
    <footer class="w-full h-32 flex items-center justify-between text-white text-xl px-12">
        <h5>TatibHub By Politeknik Negeri Malang</h5>
        <h5>© 2024 Alleviate. All rights reserved.</h5>
    </footer>
</body>
</html>