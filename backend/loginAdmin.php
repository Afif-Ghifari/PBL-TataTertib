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
        // Query untuk mencari pengguna berdasarkan username
        $sql = "SELECT * FROM Admin WHERE Username = ?";
        $params = array($user); // Parameter untuk prepared statement

        // Mempersiapkan dan menjalankan statement
        $stmt = sqlsrv_prepare($conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true)); // Debugging jika persiapan gagal
        }

        // Eksekusi query
        if (sqlsrv_execute($stmt)) {
            $userData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

            if ($userData) {
                // Pastikan kolom 'Pw' ada dalam tabel
                if (isset($userData['Pw'])) {
                    // Verifikasi password
                    if ($pass === $userData['Pw']) {
                        // Simpan data user di session
                        $_SESSION['NIM'] = $userData['NIM'];
                        $_SESSION['Nama'] = $userData['Nama'];
                        $_SESSION['Username'] = $userData['Username'];
                        header("Location: ../src/Dashboard.html"); // Redirect ke halaman dashboard
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
