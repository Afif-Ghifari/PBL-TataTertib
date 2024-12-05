<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
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

    <main class="w-full h-screen bg-slate-200 ml-72">
        <nav class="flex top-0 gap-10 items-center justify-end px-28 py-6 bg-white">
            <button class="relative inline-flex items-center" id="NotifBtn">
                <i class="bi bi-bell text-3xl text-slate-300"></i>
                <div class="absolute inline-flex items-center justify-center w-3 h-3 bg-red-500 rounded-full -top-1 -end-1 dark:border-gray-900"></div>
            </button>
            <a href="../Dosen/Profile.php" class="size-10 rounded-full border overflow-hidden">
                <img src="../../assets/img/pp_sample.jpg" class="w-full h-full object-cover" alt="">
            </a>
        </nav>
        <section class="flex flex-col w-full h-full bg-slate-100 px-14 py-12 gap-10">
            <h1 class="text-3xl">Manajemen Data Dosen</h1>
            <a href="TambahDataDosen.php" class="btn btn-primary w-fit"><i class="bi bi-plus"></i> Tambah Data</a>
            
            <table class="w-full table-fixed bg-white max-w-4xl mx-auto">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class=" px-3 py-2">NIP</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No. Telp</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    include "../../backend/database.php";
              
                    $qry_mahasiswa = "SELECT * FROM dosen";

                    $stmt = sqlsrv_query($conn, $qry_mahasiswa);

                    if (!$stmt) {
                        die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
                    }

                    if (!sqlsrv_has_rows($stmt)) {
                        echo "<p>No data found.</p>";
                    } else {

                        while ($dosen = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        
                    ?>
                    <tr>
                        <td class=" p-3"><?= htmlspecialchars($dosen['NIP'])?></td>
                        <td><?= htmlspecialchars($dosen['Nama'])?></td>
                        <td><?= htmlspecialchars($dosen['Alamat'])?></td>
                        <td><?= htmlspecialchars($dosen['No_Tlp'])?></td>
                        <td>
                            <a href="EditDataDosen.php?NIP=<?= $dosen['NIP']?>" class="btn btn-success"><i class="bi bi-clipboard"></i></a>
                            <a href="../../backend/hapusDataDosen.php?NIP=<?= $dosen['NIP']?>" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>