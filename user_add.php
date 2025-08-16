<?php
// add_user.php
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
<title>เพิ่มผู้ใช้</title>
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

<?php include 'nav.php'; ?>

<div class="container mt-4">
    <h4>เพิ่มผู้ใช้</h4>
    <form action="save_user.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select" required>
                <option value="">-- เลือก Role --</option>
                <option value="admin">Admin</option>
                <option value="it">IT</option>
                <option value="mt">MT</option>
            </select>
        </div>
        <!-- ปุ่มจะอยู่ข้างล่าง -->
        <div class="bottom-bar">
            <button type="submit" class="btn btn-success">บันทึก</button>
            <a href="manage_users.php" class="btn btn-secondary">ยกเลิก</a>
        </div>
    </form>
</div>

</body>
</html>
