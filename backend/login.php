<?php
include_once 'database.php'; // Pastikan file koneksi database benar
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Validasi input kosong
    if (empty($user) || empty($pass)) {
        echo "Username dan Password tidak boleh kosong.";
    } else {
        try {
            // Query untuk mencari pengguna berdasarkan username di tabel Mahasiswa
            $sql = "SELECT * FROM Mahasiswa WHERE Username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $user);
            $stmt->execute();

            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userData) {
                // Verifikasi password
                if ($pass === $userData['Pw']) {
                    // Simpan data user di session
                    $_SESSION['NIM'] = $userData['NIM'];
                    $_SESSION['Nama'] = $userData['Nama'];
                    $_SESSION['Username'] = $userData['Username'];
                    header("Location: ../src/Mahasiswa/Dashboard.php"); // Redirect ke halaman dashboard
                    exit;
                } else {
                    echo "Password salah.";
                }
            } else {
                echo "Username tidak ditemukan.";
            }

            // Jika username tidak ditemukan di tabel Mahasiswa, cek tabel Dosen
            $sql = "SELECT * FROM Dosen WHERE Username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $user);
            $stmt->execute();

            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userData) {
                // Verifikasi password
                if ($pass === $userData['Pw']) {
                    // Simpan data user di session
                    $_SESSION['NIP'] = $userData['NIP'];
                    $_SESSION['Nama'] = $userData['Nama'];
                    $_SESSION['Username'] = $userData['Username'];
                    header("Location: ../src/Dosen/Dashboard.php"); // Redirect ke halaman dashboard
                    exit;
                } else {
                    echo "Password salah.";
                }
            } else {
                echo "Username tidak ditemukan.";
            }
        } catch (PDOException $e) {
            echo "Koneksi atau query gagal: " . $e->getMessage();
        }
    }
}
?>
