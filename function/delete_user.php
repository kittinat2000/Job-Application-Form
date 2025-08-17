<?php
include '../config.php';

$id = $_GET['id'] ?? 0;
$sql = "DELETE FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: ../user_manage.php");
    exit;
} else {
    echo "เกิดข้อผิดพลาด: " . $conn->error;
}
