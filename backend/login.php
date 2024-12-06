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
        // Query untuk mencari pengguna berdasarkan username pada Mahasiswa
        $sqlMahasiswa = "SELECT * FROM Mahasiswa WHERE Username = ?";
        $params = array($user); // Parameter untuk prepared statement

        // Mempersiapkan dan menjalankan statement
        $stmt = sqlsrv_prepare($conn, $sqlMahasiswa, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true)); // Debugging jika persiapan gagal
        }

        // Eksekusi query Mahasiswa
        if (sqlsrv_execute($stmt)) {
            $userData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

            if ($userData) {
                // Verifikasi password (disarankan menggunakan password_verify jika password disimpan menggunakan hash)
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
                echo "Username tidak ditemukan di Mahasiswa.";
            }
        } else {
            echo "Gagal mengeksekusi query Mahasiswa.";
            die(print_r(sqlsrv_errors(), true)); // Debugging jika eksekusi gagal
        }

        // Query untuk mencari pengguna berdasarkan username pada Dosen
        $sqlDosen = "SELECT * FROM Dosen WHERE Username = ?";
        $stmtDosen = sqlsrv_prepare($conn, $sqlDosen, $params);

        if ($stmtDosen === false) {
            die(print_r(sqlsrv_errors(), true)); // Debugging jika persiapan gagal
        }

        // Eksekusi query Dosen
        if (sqlsrv_execute($stmtDosen)) {
            $userData = sqlsrv_fetch_array($stmtDosen, SQLSRV_FETCH_ASSOC);

            if ($userData) {
                // Verifikasi password (disarankan menggunakan password_verify jika password disimpan menggunakan hash)
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
                echo "Username tidak ditemukan di Dosen.";
            }
        } else {
            echo "Gagal mengeksekusi query Dosen.";
            die(print_r(sqlsrv_errors(), true)); // Debugging jika eksekusi gagal
        }
    }
}
?>
