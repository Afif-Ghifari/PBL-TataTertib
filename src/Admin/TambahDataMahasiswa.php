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

        <section class="flex flex-col h-fit bg-slate-100 w-full px-14 py-12 gap-10">
            <h1 class="text-3xl">Tambah Data Mahasiswa</h1>

            <form action="../../backend/tambahDataMahasiswa.php" method="POST" class="flex flex-col h-full justify-between">
                <label for="NIM" class="flex flex-col gap-2 my-2">
                    NIM
                    <input type="text" value="" class="border py-2 px-4 rounded-xl form-control" placeholder="Masukkan NIM" name="NIM">
                </label>
                <label for="Nama" class="flex flex-col gap-2 my-2">
                    Nama Mahasiswa
                    <input type="text" value="" class="border py-2 px-4 rounded-xl form-control" placeholder="Masukkan Nama" name="Nama" required>
                </label>
                <input type="text" value="" class="hidden" placeholder="Masukkan Nama" name="Profil">

                <label for="Kelas" class="flex flex-col gap-2 my-2">
                    Kelas
                    <select name="ID_Kelas" class="border py-2 px-4 rounded-xl form-control" required>
                        <option value="" selected required hidden>Pilih Kelas</option>
                        <?php
                        include "../../backend/database.php";

                        $qry_kelas = "SELECT * FROM Kelas";
                        $stmt = sqlsrv_query($conn, $qry_kelas);

                        if (!$stmt) {
                            die("Query Error: " . htmlspecialchars(print_r(sqlsrv_errors(), true)));
                        }

                        while ($kelas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            echo "<option value=\"" . htmlspecialchars($kelas['ID_Kelas']) . "\">" . htmlspecialchars($kelas['Nama_Kelas']) . "</option>";
                        }
                        
                        ?>
                    </select>
                </label>
                <div class="flex justify-between my-6 gap-6">
                    <label for="Alamat" class="flex flex-col w-full gap-2">
                        Alamat
                        <input type="text" class="border py-2 px-4 rounded-xl form-control" value="" placeholder="Masukkan Alamat" name="Alamat" required>
                    </label>
                    <label for="No_Tlp" class="flex flex-col w-full gap-2">
                        Nomor Telepon
                        <input type="text" class="border py-2 px-4 rounded-xl form-control" value="" placeholder="Masukkan Nomor Telepon" name="No_Tlp" required>
                    </label>
                </div>
                <div class="flex justify-between my-6 gap-6">
                    <label for="Username" class="flex flex-col w-full gap-2">
                        Username
                        <input type="text" class="border py-2 px-4 rounded-xl form-control" value="" placeholder="Masukkan Username" name="Username" required>
                    </label>
                    <label for="Pw" class="flex flex-col w-full gap-2">
                        Password
                        <input type="password" class="border py-2 px-4 rounded-xl form-control" value="" placeholder="Masukkan Password" name="Pw" required>
                    </label>
                </div>
                <input type="submit" value="Upload" class="btn btn-primary w-1/2 mx-auto my-8">
            </form>
        </section>
    </main>
</body>

</html>