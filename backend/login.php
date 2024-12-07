<?php
include_once 'database.php'; // Pastikan file koneksi database benar
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Validasi input kosong
    if (empty($user) || empty($pass)) {
        echo "Username dan Password tidak boleh kosong.";
        exit;
    }

    // Query pertama: Mahasiswa
    $sql = "SELECT * FROM Mahasiswa WHERE Username = ?";
    $params = array($user); // Parameter untuk prepared statement

    // Mempersiapkan dan menjalankan statement
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true)); // Debugging jika persiapan gagal
    }

    if (sqlsrv_execute($stmt)) {
        $userData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        if ($userData) {
            if ($pass === $userData['Pw']) {
                // Simpan data user di session
                $_SESSION['NIM'] = $userData['NIM'];
                $_SESSION['Nama'] = $userData['Nama'];
                $_SESSION['Username'] = $userData['Username'];
                header("Location: ../src/Mahasiswa/Dashboard.php");
                exit;
            } else {
                echo "Password salah.";
                exit;
            }
        }
    } else {
        die("Gagal mengeksekusi query: " . print_r(sqlsrv_errors(), true));
    }

    // Query kedua: Dosen (jika username tidak ditemukan di Mahasiswa)
    $sql = "SELECT * FROM Dosen WHERE Username = ?";
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true)); // Debugging jika persiapan gagal
    }

    if (sqlsrv_execute($stmt)) {
        $userData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        if ($userData) {
            if ($pass === $userData['Pw']) {
                // Simpan data user di session
                $_SESSION['NIP'] = $userData['NIP'];
                $_SESSION['Nama'] = $userData['Nama'];
                $_SESSION['Username'] = $userData['Username'];
                header("Location: ../src/Dosen/Dashboard.php");
                exit;
            } else {
                echo "Password salah.";
                exit;
            }
        } else {
            echo "Username tidak ditemukan.";
            exit;
        }
    } else {
        die("Gagal mengeksekusi query: " . print_r(sqlsrv_errors(), true));
    }
}
?>
