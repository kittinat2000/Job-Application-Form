<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>จัดการสมาชิก</title>
  <link rel="stylesheet" href="assets/style_back_office.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="..." crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <!-- Navbar -->
  <?php include 'nav.php'; ?>

  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3>จัดการสมาชิก</h3>
      <a href="user_add.php" class="btn btn-success">➕ เพิ่มสมาชิก</a>
    </div>

    <!-- ตารางรายชื่อสมาชิก -->
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>ชื่อผู้ใช้</th>
            <th>สิทธิ์การใช้งาน</th>
            <th>จัดการ</th>
          </tr>
        </thead>
        <tbody>
          <!-- ตัวอย่างข้อมูล -->
          <tr>
            <td>1</td>
            <td>admin</td>
            <td>ผู้ดูแลระบบ</td>
            <td>
              <a href="edit_user.php?id=1" class="btn btn-warning btn-sm">แก้ไข</a>
              <a href="delete_user.php?id=1" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบ?')">ลบ</a>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>it_support</td>
            <td>ฝ่าย IT</td>
            <td>
              <a href="edit_user.php?id=2" class="btn btn-warning btn-sm">แก้ไข</a>
              <a href="delete_user.php?id=2" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบ?')">ลบ</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>