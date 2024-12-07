<?php
include_once 'database.php'; // Pastikan file koneksi database benar
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    // Validasi input kosong
    if (empty($user) || empty($pass)) {
        die("Username dan Password tidak boleh kosong.");
    }

    // Fungsi untuk memeriksa pengguna di tabel tertentu
    function checkUser($conn, $table, $user, $pass) {
        $sql = "SELECT * FROM $table WHERE Username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $user);

        if ($stmt->execute()) {
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($userData && isset($userData['Pw']) && $userData['Pw'] === $pass) {
                return $userData;
            }
        }
        return false; // Jika user tidak ditemukan atau password salah
    }

    try {
        // Cek di tabel Mahasiswa
        $userData = checkUser($conn, 'Mahasiswa', $user, $pass);
        if ($userData) {
            $_SESSION['NIM'] = $userData['NIM'];
            $_SESSION['Nama'] = $userData['Nama'];
            $_SESSION['Username'] = $userData['Username'];
            $_SESSION['Role'] = 'Mahasiswa';
            header("Location: ../src/Mahasiswa/Dashboard.php");
            exit;
        }

        // Cek di tabel Dosen
        $userData = checkUser($conn, 'Dosen', $user, $pass);
        if ($userData) {
            $_SESSION['NIP'] = $userData['NIP'];
            $_SESSION['Nama'] = $userData['Nama'];
            $_SESSION['Username'] = $userData['Username'];
            $_SESSION['Role'] = 'Dosen';
            header("Location: ../src/Dosen/Dashboard.php");
            exit;
        }

        // Jika tidak ditemukan di kedua tabel
        die("Username atau Password salah.");
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
