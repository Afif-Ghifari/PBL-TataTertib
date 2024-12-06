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

    // Fungsi untuk memeriksa pengguna di database
    function checkUser($conn, $query, $params) {
        $stmt = sqlsrv_prepare($conn, $query, $params);
        if (!$stmt) {
            die("Query preparation failed: " . print_r(sqlsrv_errors(), true));
        }
        if (!sqlsrv_execute($stmt)) {
            die("Query execution failed: " . print_r(sqlsrv_errors(), true));
        }
        return sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    }

    // Periksa di tabel Mahasiswa
    $sqlMahasiswa = "SELECT * FROM Mahasiswa WHERE Username = ?";
    $userData = checkUser($conn, $sqlMahasiswa, [$user]);

    if ($userData) {
        if ($pass === $userData['Pw']) {
            $_SESSION['ID'] = $userData['NIM'];
            $_SESSION['Nama'] = $userData['Nama'];
            $_SESSION['Role'] = 'Mahasiswa';
            header("Location: ../src/Mahasiswa/Dashboard.php");
            exit;
        } else {
            die("Password salah.");
        }
    }

    // Periksa di tabel Dosen
    $sqlDosen = "SELECT * FROM Dosen WHERE Username = ?";
    $userData = checkUser($conn, $sqlDosen, [$user]);

    if ($userData) {
        if ($pass === $userData['Pw']) {
            $_SESSION['ID'] = $userData['NIP'];
            $_SESSION['Nama'] = $userData['Nama'];
            $_SESSION['Role'] = 'Dosen';
            header("Location: ../src/Dosen/Dashboard.php");
            exit;
        } else {
            die("Password salah.");
        }
    }

    // Jika tidak ditemukan di kedua tabel
    die("Username tidak ditemukan.");
}
?>
