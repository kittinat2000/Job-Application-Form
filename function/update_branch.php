<?php
require "../config.php";

$id           = $_POST['id'];
$branch_order = $_POST['branch_order'];
$branch_name  = $_POST['branch_name'];
$phonenumber  = $_POST['phonenumber'];
$branch_type  = $_POST['branch_type'];

$sql = "UPDATE branches 
        SET branch_order = ?, branch_name = ?, phonenumber = ?, branch_type = ?
        WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssi", $branch_order, $branch_name, $phonenumber, $branch_type, $id);

if ($stmt->execute()) {
    header("Location: ../branches.php?msg=updated");
    exit;
} else {
    echo "❌ เกิดข้อผิดพลาด: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
