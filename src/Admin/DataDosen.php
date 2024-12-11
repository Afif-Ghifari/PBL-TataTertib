<?php
session_start();
if (!isset($_SESSION['ID_Admin'])) {
    header("Location: ../Login.html");
}
?>
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
    <?php include "Navbar.php"; ?>

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
                            <a href="EditDataDosen.php?NIP=<?= $dosen['NIP']?>" class="btn btn-success"><i class="bi bi-pencil-square"></i></a>
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