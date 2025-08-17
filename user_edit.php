<?php
include 'config.php';
$id = $_GET['id'] ?? 0;

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    die("ไม่พบผู้ใช้");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $role = $_POST['role'];

    // ถ้ามีการเปลี่ยนรหัสผ่าน
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE users SET username=?, password=?, role=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $username, $password, $role, $id);
    } else {
        $sql = "UPDATE users SET username=?, role=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $username, $role, $id);
    }

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
  <title>แก้ไขสมาชิก</title>
  <link rel="stylesheet" href="assets/style_back_office.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
  <?php include "nav.php"; ?>
  <h3>แก้ไขสมาชิก</h3>
  <form method="post">
    <div class="mb-3">
      <label>ชื่อผู้ใช้</label>
      <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>รหัสผ่าน (เว้นว่างหากไม่เปลี่ยน)</label>
      <input type="password" name="password" class="form-control">
    </div>
    <div class="mb-3">
      <label>สิทธิ์การใช้งาน</label>
      <select name="role" class="form-control">
        <option value="user" <?= $user['role']=='user'?'selected':'' ?>>ผู้ใช้งาน</option>
        <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>ผู้ดูแลระบบ</option>
      </select>
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-primary">อัปเดต</button>
      <a href="user_manage.php" class="btn btn-secondary">กลับ</a>
    </div>
  </form>
</body>
</html>
