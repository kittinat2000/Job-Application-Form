<?php
// add_branch.php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
  header('Location: login.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <title>เพิ่มสาขา</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/style_back_office.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="..." crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .bottom-bar {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      background: #fff;
      border-top: 1px solid #ccc;
      padding: 10px;
      display: flex;
      justify-content: center;
      gap: 10px;
      z-index: 999;
    }
  </style>
</head>

<body>
  <?php include "nav.php"; ?>

  <div class="container mt-4">
    <h4>เพิ่มสาขา</h4>
    <form action="function/save_branch.php" method="POST">
      <div class="mb-3">
        <label class="form-label">ประเภทสาขา</label>
        <select name="branch_type" class="form-control" required>
          <option value="">-- เลือกประเภท --</option>
          <option value="Suki">Suki</option>
          <option value="BBQ">BBQ</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">ลำดับสาขา</label>
        <input type="number" name="branch_order" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">ชื่อสาขา</label>
        <input type="text" name="branch_name" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">เบอร์โทรศัพท์</label>
        <input type="text" name="phonenumber" class="form-control" required>
      </div>
      <div class="bottom-bar">
        <button type="submit" class="btn btn-success">บันทึก</button>
        <a href="branches.php" class="btn btn-secondary">ยกเลิก</a>
      </div>
    </form>
  </div>

</body>

</html>