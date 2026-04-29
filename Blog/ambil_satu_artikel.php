<?php
include 'koneksi.php';

$id = $_GET['id'] ?? 0;

$stmt = mysqli_prepare($koneksi, "SELECT * FROM artikel WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

header('Content-Type: application/json');
echo json_encode($data);