<?php
require "config.php";

$id = $_GET['id'] ?? 0;

// ดึงข้อมูลเก่ามา
$sql = "SELECT * FROM branches WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$branch = $result->fetch_assoc();

if (!$branch) {
  die("❌ ไม่พบข้อมูลสาขาที่ต้องการแก้ไข");
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <title>แก้ไขสาขา</title>
  <link rel="stylesheet" href="assets/style_back_office.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <?php include "nav.php"; ?>
  <div class="container mt-5">
    <div class="card shadow-lg">
      <div class="card-header bg-warning text-dark">
        <h4 class="mb-0">✏️ แก้ไขข้อมูลสาขา</h4>
      </div>
      <div class="card-body">
        <form action="function/update_branch.php" method="post">
          <input type="hidden" name="id" value="<?php echo $branch['id']; ?>">
          <div class="mb-3">
            <label class="form-label">ประเภทสาขา</label>
            <select name="branch_type" class="form-control" required>
              <option value="">-- เลือกประเภท --</option>
              <option value="Suki" <?php if ($branch['branch_type'] == "Suki") echo "selected"; ?>>Suki</option>
              <option value="BBQ" <?php if ($branch['branch_type'] == "BBQ") echo "selected"; ?>>BBQ</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">ลำดับสาขา</label>
            <input type="number" name="branch_order" class="form-control"
              value="<?php echo htmlspecialchars($branch['branch_order']); ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">ชื่อสาขา</label>
            <input type="text" name="branch_name" class="form-control"
              value="<?php echo htmlspecialchars($branch['branch_name']); ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">เบอร์โทรศัพท์</label>
            <input type="text" name="phonenumber" class="form-control"
              value="<?php echo htmlspecialchars($branch['phonenumber']); ?>" required>
          </div>
          <button type="submit" class="btn btn-success">💾 บันทึกการแก้ไข</button>
          <a href="branches.php" class="btn btn-secondary">⬅️ กลับ</a>
        </form>
      </div>
    </div>
  </div>
</body>

</html>