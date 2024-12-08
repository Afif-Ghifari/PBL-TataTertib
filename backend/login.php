<?php
include_once 'database.php'; // Pastikan file koneksi database benar
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi input kosong
    if (empty($username) || empty($password)) {
        echo "Username dan Password tidak boleh kosong.";
        exit;
    }

    // Gabungkan login Mahasiswa dan Dosen
    $sql = "SELECT 'Mahasiswa' AS Role, NIM AS ID, Nama, Username, Pw 
            FROM Mahasiswa WHERE Username = ? 
            UNION 
            SELECT 'Dosen' AS Role, NIP AS ID, Nama, Username, Pw 
            FROM Dosen WHERE Username = ?";

    $params = [$username, $username];
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true)); // Debugging jika persiapan gagal
    }

    if (sqlsrv_execute($stmt)) {
        $userData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        if ($userData) {
            // Periksa password dengan password_verify jika password di-hash
            if (password_verify($password, $userData['Pw'])) {
                // Simpan data user di session
                $_SESSION['ID'] = $userData['ID'];
                $_SESSION['Nama'] = $userData['Nama'];
                $_SESSION['Username'] = $userData['Username'];
                $_SESSION['Role'] = $userData['Role'];

                // Redirect ke dashboard sesuai role
                if ($userData['Role'] === 'Mahasiswa') {
                    header("Location: ../src/Mahasiswa/Dashboard.php");
                } else {
                    header("Location: ../src/Dosen/Dashboard.php");
                }
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
