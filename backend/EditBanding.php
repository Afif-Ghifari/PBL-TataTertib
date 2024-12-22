<?php
session_start();
if (!isset($_SESSION['ID_Admin'])) {
    header("Location: ../Login.html");
    exit();
}

include "../../backend/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idBanding = $_POST['ID_Banding'];
    $status = $_POST['Status'];

    if (empty($idBanding) || empty($status)) {
        echo "<script>alert('ID Banding dan Status tidak boleh kosong!'); history.back();</script>";
        exit();
    }

    // Query untuk update status banding
    $qry_update = "UPDATE banding SET Status = ? WHERE ID_Banding = ?";
    $params = [$status, $idBanding];

    $stmt = sqlsrv_prepare($conn, $qry_update, $params);
    if (!$stmt) {
        die("Query Prepare Error: " . print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_execute($stmt)) {
        echo "<script>alert('Status berhasil diupdate!'); window.location.href = 'DataBanding.php';</script>";
    } else {
        die("Query Execute Error: " . print_r(sqlsrv_errors(), true));
    }
} else {
    header("Location: detailBanding.php");
    exit();
}
?>
