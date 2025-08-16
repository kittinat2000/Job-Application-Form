<?php
session_start();
require 'config.php'; // ใช้ $conn ที่คุณสร้างไว้

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // ใช้ prepared statement เพื่อป้องกัน SQL Injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            // เก็บข้อมูลผู้ใช้ใน session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            header("Location: dashboard.php");
            exit();
        } else {
            $error = "❌ รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        $error = "❌ ไม่พบบัญชีผู้ใช้นี้";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>เข้าสู่ระบบ</title>
<style>
    body { font-family: Tahoma, sans-serif; padding: 20px; }
    form { max-width: 300px; margin: auto; }
    input { width: 100%; padding: 8px; margin-bottom: 10px; }
    button { padding: 8px; width: 100%; background: #007BFF; color: white; border: none; cursor: pointer; }
    button:hover { background: #0056b3; }
    .error { color: red; margin-bottom: 10px; }
</style>
</head>
<body>

<h2>เข้าสู่ระบบ</h2>
<?php if ($error) echo "<div class='error'>$error</div>"; ?>

<form method="post">
    <input type="text" name="username" placeholder="ชื่อผู้ใช้" required>
    <input type="password" name="password" placeholder="รหัสผ่าน" required>
    <button type="submit">เข้าสู่ระบบ</button>
</form>

</body>
</html>
