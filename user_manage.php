<?php
include 'config.php'; // ไฟล์เชื่อมต่อฐานข้อมูล

// ดึงข้อมูลสมาชิกทั้งหมด
$sql = "SELECT * FROM users ORDER BY id ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>จัดการสมาชิก</title>
  <link rel="stylesheet" href="assets/style_back_office.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <?php include 'nav.php'; ?>

  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3>จัดการสมาชิก</h3>
      <a href="user_add.php" class="btn btn-success">➕ เพิ่มสมาชิก</a>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>ชื่อผู้ใช้</th>
            <th>สิทธิ์การใช้งาน</th>
            <th>วันที่สร้าง</th>
            <th>จัดการ</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td>
                  <?= $row['role'] == 'admin' ? 'ผู้ดูแลระบบ' : 'ผู้ใช้งาน' ?>
                </td>
                <td><?= $row['created_at'] ?></td>
                <td>
                  <a href="user_edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">แก้ไข</a>
                  <a href="function/delete_user.php?id=<?= $row['id'] ?>" 
                     class="btn btn-danger btn-sm"
                     onclick="return confirm('ยืนยันการลบ?')">ลบ</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="text-center">ไม่มีข้อมูลสมาชิก</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
