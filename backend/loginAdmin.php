<?php
include_once 'database.php'; 
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if (empty($user) || empty($pass)) {
        echo "Username dan Password tidak boleh kosong.";
    } else {
        $sql = "SELECT * FROM Admin WHERE Username = ?";
        $params = array($user); 

        $stmt = sqlsrv_prepare($conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        if (sqlsrv_execute($stmt)) {
            $userData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

            if ($userData) {
                if (isset($userData['Pw'])) {
                    if ($pass === $userData['Pw']) {
                        $_SESSION['ID_Admin'] = $userData['ID_Admin'];
                        header("Location: ../src/Admin/Dashboard.php"); // Redirect ke halaman dashboard
                        exit;
                    } else {
                        echo "Password salah.";
                    }
                } else {
                    echo "Kolom 'Pw' tidak ditemukan dalam tabel Mahasiswa.";
                }
            } else {
                echo "Username tidak ditemukan.";
            }
        } else {
            echo "Gagal mengeksekusi query.";
            die(print_r(sqlsrv_errors(), true)); // Debugging jika eksekusi gagal
        }
    }
}
?>
