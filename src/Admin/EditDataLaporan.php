<?php
session_start();
$IdAdmin = $_SESSION['ID_Admin'];
?>

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

                <?php
                include "../../backend/database.php";
                $qry_terimaPelanggaran = "SELECT 
                            l.ID_Laporan,
                            m.NIM, 
                            m.Nama as NamaMahasiswa, 
                            d.NIP, 
                            d.Nama as NamaDosen,
                            l.ID_Admin,
                            l.Status,
                            l.TanggalDibuat,
                            l.Sanksi,
                            p.ID_Pelanggaran, 
                            p.Nama_Pelanggaran, 
                            p.Tingkat,
                            bk.ID_Bukti,
                            bk.Foto,
                            bk.Deskripsi
                            FROM Laporan l 
                            JOIN Pelanggaran p ON l.ID_Pelanggaran = p.ID_Pelanggaran
                            JOIN Mahasiswa m ON l.ID_Dilapor = m.NIM
                            JOIN Dosen d ON l.ID_Pelapor = d.NIP
                            LEFT JOIN Bukti_Pengerjaan bk ON l.ID_Bukti = bk.ID_Bukti
                            WHERE ID_Laporan = ?";
                $params = [$_GET['ID_Laporan']];
                $stmt = sqlsrv_prepare($conn, $qry_terimaPelanggaran, $params);

                if (!$stmt) {
                    die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
                }

                if (!sqlsrv_execute($stmt)) {
                    die("Query Execute Error: " . print_r(sqlsrv_errors(), true));
                }

                $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

                ?>

                <label class="block mb-2 text-sm font-medium text-gray-900 " for="file_input">Foto Bukti</label>
                <img src="../../assets/img/sample_pelanggaran.png" class="w-96 mx-auto my-3" alt="">

                <div class="flex justify-between gap-24 w-full my-8">
                    <span class="w-full">
                        <label for="">
                            Nama Terlapor
                        </label>
                        <select name="ID_Terlapor" class="form-control" id="JenisPelanggaran" name=>
                            <?php
                            $qry_mahasiswa = "SELECT * FROM Mahasiswa";
                            $stmt = sqlsrv_query($conn, $qry_mahasiswa);

                            if (!$stmt) {
                                die("Query Error: " . print_r(sqlsrv_errors(), true));
                            }

                            while ($mahasiswa = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                $selected = $mahasiswa['NIM'] === $row['NIM'] ? 'selected' : '';
                                echo "<option value=\"" . htmlspecialchars($mahasiswa['NIM']) . "\" $selected>" . htmlspecialchars($mahasiswa['Nama']) . "</option>";
                            }
                            ?>
                        </select>
                    </span>
                </div>
                <div class="flex justify-between gap-24 w-full my-8">
                    <span class="w-full">
                        <label for="">
                            Nama Pelapor
                        </label>
                        <select name="ID_Pelapor" class="form-control" id="JenisPelanggaran">
                            <?php
                            $qry_dosen = "SELECT * FROM dosen";
                            $stmt = sqlsrv_query($conn, $qry_dosen);

                            if (!$stmt) {
                                die("Query Error: " . print_r(sqlsrv_errors(), true));
                            }

                            while ($dosen = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                $selected = $dosen['NIP'] === $row['NIP'] ? 'selected' : '';
                                echo "<option value=\"" . htmlspecialchars($dosen['NIP']) . "\" $selected>" . htmlspecialchars($dosen['Nama']) . "</option>";
                            }
                            ?>
                        </select>
                    </span>
                </div>
                <input type="text" class="form-control" name="ID_Admin" value="<?= htmlspecialchars(isset($row['ID_Admin']) ? $row['ID_Admin'] : $IdAdmin) ?>" id="Tempat" hidden>
                <div class="flex justify-between gap-24 w-full my-8">
                    <span class="w-full">
                        <label for="">
                            Tanggal Kejadian
                        </label>

                        <input
                            type="date"
                            class="form-control"
                            id="Tanggal"
                            name="TanggalDibuat"
                            value="<?= isset($row['TanggalDibuat'])
                                        ? htmlspecialchars(
                                            $row['TanggalDibuat'] instanceof DateTime
                                                ? $row['TanggalDibuat']->format('Y-m-d')
                                                : (new DateTime($row['TanggalDibuat']))->format('Y-m-d')
                                        )
                                        : ''
                                    ?>">
                    </span>
                    <span class="w-full">
                        <label for="">
                            Status
                        </label>
                        <select name="Status" class="form-control" id="JenisPelanggaran">
                            <option value="<?= htmlspecialchars($row['Status']) ?>" selected><?= htmlspecialchars($row['Status']) ?></option>
                            <option value="">Pelanggaran 2</option>
                            <option value="">Pelanggaran 3</option>
                            <option value="">Pelanggaran 4</option>
                            <option value="">Pelanggaran 5</option>
                        </select>
                    </span>
                </div>
                <div class="flex justify-between gap-24 w-full my-8">
                    <span class="w-full">
                        <label for="">
                            Jenis Pelanggaran
                        </label>
                        <select name="ID_Pelanggaran" class="form-control" id="JenisPelanggaran">
                            <?php
                            $qry_pelanggaran = "SELECT * FROM pelanggaran";
                            $stmt = sqlsrv_query($conn, $qry_pelanggaran);

                            if (!$stmt) {
                                die("Query Error: " . print_r(sqlsrv_errors(), true));
                            }

                            while ($pelanggaran = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                $selected = $pelanggaran['ID_Pelanggaran'] === $row['ID_Pelanggaran'] ? 'selected' : '';
                                echo "<option value=\"" . htmlspecialchars($pelanggaran['ID_Pelanggaran']) . "\" $selected>" . htmlspecialchars($pelanggaran['Nama_Pelanggaran']) . "</option>";
                            }
                            ?>
                        </select>
                    </span>
                </div>

                <label for="">Sanksi</label>
                <textarea class="form-control" name="Sanksi" id="Deskripsi" placeholder="Isi Sanksi"><?= htmlspecialchars(isset($row['Sanksi']) ? $row['Sanksi'] : '') ?></textarea>

                <div class="my-8">
                    <h4>Bukti Pengerjaan</h4>
                    <?php
                    if (isset($row) && is_array($row) && array_key_exists('ID_Bukti', $row) && is_null($row['ID_Bukti'])) { // Jika tidak ada bukti pengerjaan
                        echo "<h6>Belum mengumpulkan bukti</h6>";
                    } elseif (isset($row) && is_array($row)) {
                    ?>
                        <div class="flex justify-between gap-24 w-full">
                            <span class="w-full">
                                <label class="block mb-2 text-sm font-medium text-gray-900" for="file_input">Foto Bukti Pengerjaan</label>
                                <img src="../../backend/<?= htmlspecialchars($row['Bukti_Pengerjaan']) ?>" class="w-96 mx-auto my-3" alt="Foto Bukti Pengerjaan">
                            </span>
                        </div>
                        <span class="w-1/3">
                            <label for="Deskripsi">
                                Deskripsi
                            </label>
                            <textarea class="form-control" id="Deskripsi" readonly><?= htmlspecialchars($row['Deskripsi']) ?></textarea>
                        </span>
                </div>
            <?php
                    } else {
                        echo "<h6>Data tidak ditemukan.</h6>";
                    }
            ?>
            <input type="submit" value="Update" class="btn btn-primary rounded-xl w-full mx-auto my-3 py-2">
            </form>
        </section>
    </main>
</body>

</html>