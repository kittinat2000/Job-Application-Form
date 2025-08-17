<?php

require "../config.php";

// รับค่าจากฟอร์ม
$branch_order = $_POST['branch_order'];
$branch_name  = $_POST['branch_name'];
$phonenumber  = $_POST['phonenumber'];
$branch_type  = $_POST['branch_type'];

$sql = "INSERT INTO branches (branch_order, branch_name, phonenumber, branch_type)
        VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $branch_order, $branch_name, $phonenumber, $branch_type);


if ($stmt->execute()) {
  echo "<script>alert('บันทึกข้อมูลสำเร็จ'); window.location='../branches.php';</script>";
  exit;
} else {
  echo "Error: " . $stmt->error;
}


$stmt->close();
$conn->close();
?>