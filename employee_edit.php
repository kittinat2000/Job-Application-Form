<?php
require "function/check_user.php";
require "config.php";

$id = intval($_GET['id']);

// ดึงข้อมูลเก่า
$sql_branch = "SELECT id, branch_name FROM branches ORDER BY branch_name ASC";
$sql_emp = "SELECT * FROM employees WHERE id=?";
$stmt = $conn->prepare($sql_emp);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$emp = $result->fetch_assoc();
$query_branch = $conn->query($sql_branch);


if (!$emp) {
  echo "ไม่พบข้อมูล";
  exit;
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>แก้ไขพนักงาน</title>
  <link rel="stylesheet" href="assets/style_back_office.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <?php include "nav.php"; ?>

  <div class="container py-4">
    <h4>แก้ไขพนักงาน</h4>
    <form action="function/update_employee.php?id=<?php echo $emp['id']; ?>" method="POST" enctype="multipart/form-data">

      <div class="mb-3">
        <label class="form-label">สาขา</label>
        <select name="branch_id" class="form-select" required>
          <?php
          // แสดง option ของสาขาปัจจุบันของพนักงานก่อน
          if ($emp['branch_id']) {
            $stmtCurrent = $conn->prepare("SELECT branch_name FROM branches WHERE id=?");
            $stmtCurrent->bind_param("i", $emp['branch_id']);
            $stmtCurrent->execute();
            $resCurrent = $stmtCurrent->get_result();
            $currentBranch = $resCurrent->fetch_assoc();
            echo "<option value='" . $emp['branch_id'] . "' selected>" . htmlspecialchars($currentBranch['branch_name']) . "</option>";
          } else {
            echo "<option value='' selected>-- เลือกสาขา --</option>";
          }

          // แสดง branch อื่น ๆ
          if ($query_branch->num_rows > 0) {
            while ($row = $query_branch->fetch_assoc()) {
              // ข้ามสาขาปัจจุบัน
              if ($row['id'] == $emp['branch_id']) continue;
              echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['branch_name']) . "</option>";
            }
          }
          ?>
        </select>
      </div>

      <div class="mb-3">
        <label>ประเภทการทำรายการ</label>
        <select name="action_type" class="form-select">
          <?php
          // แสดงค่าปัจจุบันเป็น option แรก
          if ($emp['action_type']) {
            echo '<option value="' . htmlspecialchars($emp['action_type']) . '" selected>' . htmlspecialchars($emp['action_type']) . '</option>';
          } else {
            echo '<option value="" selected>-- เลือกประเภท --</option>';
          }

          // ตัวเลือกอื่น ๆ
          $types = ["ลงทะเบียน", "เปลี่ยนนายจ้าง", "moni"];
          foreach ($types as $type) {
            // ข้ามค่าปัจจุบันแล้วแสดงตัวเลือกอื่น
            if ($type == $emp['action_type']) continue;
            echo '<option value="' . $type . '">' . $type . '</option>';
          }
          ?>
        </select>
      </div>


      <div class="mb-3">
        <label>รหัสพนักงาน</label>
        <input type="text" name="emp_code" class="form-control" value="<?= htmlspecialchars($emp['emp_code']) ?>">
      </div>

      <div class="mb-3">
        <label>ชื่อ</label>
        <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($emp['first_name']) ?>">
      </div>

      <div class="mb-3">
        <label>นามสกุล</label>
        <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($emp['last_name']) ?>">
      </div>

      <?php
      $files = [
        "photo_path" => "รูปถ่าย",
        "work_permit_path" => "ใบอนุญาตทำงาน",
        "passport_path" => "พาสปอร์ต",
        "receipt_path" => "ใบเสร็จ",
        "wp_book_path" => "สมุดใบอนุญาตทำงาน",
        "work_accept_path" => "เอกสารรับเข้าทำงาน",
        "notice_file_path55" => "แจ้งเข้าทำงาน 55",
        "notice_file_path52" => "แจ้งเข้าทำงาน 52",
        "pink_card_front_path" => "บัตรชมพู - ด้านหน้า",
        "pink_card_back_path" => "บัตรชมพู - ด้านหลัง"
      ];
      ?>
      <?php $i = 1; ?>
      <?php foreach ($files as $field => $label): ?>
        <div class="mb-3">
          <label class="form-label"><?= $label ?></label>
          <?php if (!empty($emp[$field])): ?>
            <button class="btn btn-sm btn-primary mb-2"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#img<?= $i ?>"
              aria-expanded="false"
              aria-controls="img<?= $i ?>">
              ดู/ซ่อน รูป
            </button>
            <div class="collapse mb-2" id="img<?= $i ?>">
              <img src="uploads/<?= $emp[$field] ?>" alt="<?= $label ?>" class="img-fluid rounded shadow">
            </div>
          <?php endif; ?>
          <input type="file" name="<?= $field ?>" class="form-control">
        </div>
      <?php $i++;
      endforeach; ?>

      <!-- Modal -->
      <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content bg-dark">
            <div class="modal-body text-center">
              <img id="modalImage" src="" class="img-fluid rounded" style="max-height:80vh;">
            </div>
          </div>
        </div>
      </div>

      <!-- ปุ่มลอยด้านล่าง -->
      <div class="fixed-bottom bg-light p-2 border-top">
        <div class="container d-flex gap-2">
          <button type="submit" class="btn btn-success btn-lg w-50">บันทึก</button>
          <a href="dashboard.php" class="btn btn-danger btn-lg w-50">ยกเลิก</a>
        </div>
      </div>


      <script>
        function showImage(src) {
          document.getElementById('modalImage').src = src;
        }
      </script>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>