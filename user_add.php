<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // เข้ารหัส
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $role);

    if ($stmt->execute()) {
        header("Location: user_manage.php");
        exit;
    } else {
        echo "เกิดข้อผิดพลาด: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>เพิ่มสมาชิก</title>
  <link rel="stylesheet" href="assets/style_back_office.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <?php include 'nav.php'; ?>
  <h3>เพิ่มสมาชิก</h3>
  <form method="post">
    <div class="mb-3">
      <label>ชื่อผู้ใช้</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>รหัสผ่าน</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>สิทธิ์การใช้งาน</label>
      <select name="role" class="form-control">
        <option value="user">ผู้ใช้งาน</option>
        <option value="admin">ผู้ดูแลระบบ</option>
      </select>
    </div>
    <button type="submit" class="btn btn-success">บันทึก</button>
    <a href="user_manage.php" class="btn btn-secondary">กลับ</a>
  </form>
</body>
</html>
