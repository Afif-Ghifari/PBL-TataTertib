    <?php
    include_once 'database.php';
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            // Pastikan koneksi $conn valid
            if (!$conn || !($conn instanceof PDO)) {
                throw new Exception("Koneksi database tidak valid.");
            }

            // Mulai transaksi
            $conn->beginTransaction();

            // Ambil data dari form
            $namaTerlapor = trim($_POST['NamaTerlapor']);
            $tanggal = trim($_POST['Tanggal']);
            $jenisPelanggaran = trim($_POST['JenisPelanggaran']);
            $idPelapor = $_SESSION['ID']; // ID pelapor diambil dari session
            $fileName = null;

            // Validasi data kosong
            if (empty($namaTerlapor) || empty($tanggal) || empty($jenisPelanggaran)) {
                throw new Exception("Semua kolom wajib diisi.");
            }

            // Validasi nama terlapor di database
            $sqlTerlapor = "SELECT ID_Dilapor FROM Mahasiswa WHERE Nama = ?";
            $stmtTerlapor = $conn->prepare($sqlTerlapor);
            $stmtTerlapor->execute([$namaTerlapor]);
            $terlaporData = $stmtTerlapor->fetch(PDO::FETCH_ASSOC);

            if (!$terlaporData) {
                throw new Exception("Nama terlapor tidak ditemukan di database.");
            }
            $idDilapor = $terlaporData['ID_Dilapor'];

            // Proses file bukti jika ada
            if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] === UPLOAD_ERR_OK) {
                $fileName = $_FILES['bukti']['name'];
                $fileTmpName = $_FILES['bukti']['tmp_name'];
                $uploadDir = './uploads/';
                $uploadPath = $uploadDir . basename($fileName);

                // Pindahkan file yang diunggah
                if (!move_uploaded_file($fileTmpName, $uploadPath)) {
                    throw new Exception("Gagal mengunggah file bukti.");
                }
            }

            // Simpan laporan ke tabel Laporan
            $sqlLaporan = "INSERT INTO Laporan (ID_Pelapor, ID_Dilapor, Tanggal, JenisPelanggaran, Foto_Bukti)
                        VALUES (?, ?, ?, ?, ?)";
            $stmtLaporan = $conn->prepare($sqlLaporan);
            $stmtLaporan->execute([$idPelapor, $idDilapor, $tanggal, $jenisPelanggaran, $fileName]);

            // Commit transaksi
            $conn->commit();

            // Redirect dengan notifikasi sukses
            header("Location: ../src/Admin/Dosen/Dashboard.php?success=1");
            exit;
        } catch (Exception $e) {
            if ($conn && $conn instanceof PDO) {
                $conn->rollBack();
            }
            die("Gagal menyimpan laporan: " . $e->getMessage());
        }
    } else {
        die("Metode request tidak valid.");
    }
    ?>
