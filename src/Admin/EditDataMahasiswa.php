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
            <h1 class="text-3xl">Edit Data Mahasiswa</h1>
            <?php
            include "../../backend/database.php";

            $qry_profil = "SELECT * FROM Mahasiswa WHERE NIM = ?";
            $params = [$_GET['NIM']];
            $stmt = sqlsrv_prepare($conn, $qry_profil, $params);

            if (!$stmt) {
                die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
            }

            if (!sqlsrv_execute($stmt)) {
                die("Query Execute Error: " . print_r(sqlsrv_errors(), true));
            }

            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            ?>
            <form action="../../backend/ubahDataMahasiswa.php" method="POST" class="flex flex-col justify-between">
                <label for="NIM" class="flex flex-col gap-2">
                    NIM
                    <input type="text" value="<?= htmlspecialchars($row['NIM']) ?>" class="border py-2 px-4 rounded-xl form-control" readonly name="NIM">
                </label>
                <label for="Nama" class="flex flex-col gap-2">
                    Nama Mahasiswa
                    <input type="text" value="<?= htmlspecialchars($row['Nama']) ?>" class="border py-2 px-4 rounded-xl form-control" name="Nama" required>
                </label>
                <input type="text" value="<?= htmlspecialchars($row['Profil']) ?>" class="hidden" name="Profil" required>
                <label for="Kelas" class="flex flex-col gap-2">
                    Kelas
                    <select name="ID_Kelas" class="border py-2 px-4 rounded-xl form-control">
                        <?php
                        $qry_kelas = "SELECT * FROM Kelas";
                        $stmt = sqlsrv_query($conn, $qry_kelas);

                        if (!$stmt) {
                            die("Query Error: " . print_r(sqlsrv_errors(), true));
                        }

                        while ($kelas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            $selected = $kelas['ID_Kelas'] === $row['ID_Kelas'] ? 'selected' : '';
                            echo "<option value=\"" . htmlspecialchars($kelas['ID_Kelas']) . "\" $selected>" . htmlspecialchars($kelas['Nama_Kelas']) . "</option>";
                        }
                        ?>
                    </select>
                </label>
                <div class="flex justify-between my-6 gap-6">
                    <label for="Alamat" class="flex flex-col w-full gap-2">
                        Alamat
                        <input type="text" class="border py-2 px-4 rounded-xl form-control" value="<?= htmlspecialchars($row['Alamat']) ?>" name="Alamat" required>
                    </label>
                    <label for="No_Tlp" class="flex flex-col w-full gap-2">
                        Nomor Telepon
                        <input type="text" class="border py-2 px-4 rounded-xl form-control" value="<?= htmlspecialchars($row['No_Tlp']) ?>" name="No_Tlp" required>
                    </label>
                </div>
                <div class="flex justify-between my-6 gap-6">
                    <label for="Username" class="flex flex-col w-full gap-2">
                        Username
                        <input type="text" class="border py-2 px-4 rounded-xl form-control" value="<?= htmlspecialchars($row['Username']) ?>" name="Username" readonly>
                    </label>
                    <label for="Pw" class="flex flex-col w-full gap-2">
                        Password
                        <input type="password" class="border py-2 px-4 rounded-xl form-control" value="<?= htmlspecialchars($row['Pw']) ?>" placeholder="Enter new password" name="Pw" readonly>
                    </label>
                </div>
                <input type="submit" value="Update" class="btn btn-primary w-1/2 mx-auto my-8">
            </form>
        </section>
    </main>
</body>

</html>