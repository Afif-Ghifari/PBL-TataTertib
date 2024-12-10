<?php
session_start();
if (!isset($_SESSION['ID_Admin'])) {
    header("Location: ../Login.php");
}
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
        <?php include "Navbar.php"; ?>
        
        <section class="flex flex-col w-full px-14 py-12 gap-10">
            <form class="w-full px-20 py-12 rounded-xl shadow-lg" action="../../backend/TerimaPelanggaran.php" method="post">
                
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
                            l.Foto_Bukti,
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
                <img src="../../backend/<?= htmlspecialchars($row['Foto_Bukti']) ?>" class="w-96 mx-auto my-3" alt="">
                <input type="text" value="<?= htmlspecialchars($row['ID_Laporan']) ?>" class="hidden" name="ID_Laporan">
                <div class="flex justify-between gap-24 w-full my-8">
                    <span class="w-full">
                        <label for="">
                            Nama Terlapor
                        </label>
                        <select name="ID_Dilapor" class="form-control" id="JenisPelanggaran" name="ID_Dilapor">
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
                            <option value="Pending">Pending</option>
                            <option value="Dikonfirmasi">Dikonfirmasi</option>
                            <option value="Ditolak">Ditolak</option>
                            <option value="Selesai">Selesai</option>
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
                                <img src="../../backend/<?= htmlspecialchars($row['Foto']) ?>" class="w-96 mx-auto my-3" alt="Foto Bukti Pengerjaan">
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