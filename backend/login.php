<?php
include_once 'database.php'; // Pastikan file koneksi database benar
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    // Validasi input kosong
    if (empty($user) || empty($pass)) {
<<<<<<< HEAD
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
=======
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
            $_SESSION['ID'] = $userData['NIM'];  // ID untuk mahasiswa adalah NIM
            $_SESSION['Nama'] = $userData['Nama'];
            $_SESSION['Role'] = 'Mahasiswa';
            header("Location: ../src/Mahasiswa/Dashboard.php");
            exit;
        } else {
            die("Password salah.");
>>>>>>> 4026daed6bfcbd062818353ff721e000f9bfff11
        }
    }

    // Periksa di tabel Dosen
    $sqlDosen = "SELECT * FROM Dosen WHERE Username = ?";
    $userData = checkUser($conn, $sqlDosen, [$user]);

    if ($userData) {
        if ($pass === $userData['Pw']) {
            $_SESSION['ID'] = $userData['NIP'];  // ID untuk dosen adalah NIP
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
