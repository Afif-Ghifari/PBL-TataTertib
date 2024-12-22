<?php
// Koneksi ke database SQL Server
include '../../backend/database.php';
if (!$conn) {
    die(json_encode([]));
    exit;
}

// Ambil parameter query dari URL
$query = isset($_GET['q']) ? $_GET['q'] : '';
$query = htmlspecialchars($query, ENT_QUOTES, 'UTF-8');

// Query ke database
$sql = "SELECT Nama FROM Mahasiswa WHERE Nama LIKE ? ORDER BY Nama";
$params = ["%$query%"];
$stmt = sqlsrv_query($conn, $sql, $params);

$results = [];
if ($stmt) {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $results[] = htmlspecialchars($row['Nama'], ENT_QUOTES, 'UTF-8');
    }
}

// Kembalikan hasil dalam format JSON
header('Content-Type: application/json');
echo json_encode($results);

sqlsrv_close($conn);
