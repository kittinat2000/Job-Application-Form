<?php
require "config.php";

$nationality = $_GET['nationality'];

$sql = "SELECT * FROM branches ORDER BY branch_order ASC";
$result = $conn->query($sql);

$conn->close();
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <title>ฟอร์มเก็บประวัติพนักงาน</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/style_back_office.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

  <div class="container py-4">
    <div class="card shadow-lg">
      <div class="card-header bg-primary text-white text-center">
        <h5 class="mb-0">📋 ฟอร์มเก็บประวัติพนักงาน (ต่างชาติ)</h5>
      </div>
      <div class="card-body">
        <form action="function/save_employee.php" method="POST" enctype="multipart/form-data">

          <!-- สำหรับทดสอบ - สัญชาติ -->
          <div class="mb-3" style="display: none; color:red;">
            <label class="form-label">สำหรับทดสอบ - สัญชาติ</label>
            <input value="<?php echo $nationality; ?>" type="text" name="nationality" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">สาขา</label>
            <select name="branch_id" class="form-select" required>
              <option value="">-- เลือกสาขา --</option>
              <?php
              if ($result->num_rows > 0) {
                // วนลูปเพื่อแสดงผลแต่ละสาขา
                while ($row = $result->fetch_assoc()) {
                  echo "<option value='" . htmlspecialchars($row["id"]) . "'>" . htmlspecialchars($row["branch_type"]) . " สาขาที่ " . htmlspecialchars($row["branch_order"]) . " " . htmlspecialchars($row["branch_name"]) . "</option>";
                }
              }
              ?>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">ประเภทการทำรายการ</label>
            <select name="action_type" class="form-select" required>
              <option value="">-- เลือก --</option>
              <option value="ลงทะเบียน">ลงทะเบียน</option>
              <option value="เปลี่ยนนายจ้าง">เปลี่ยนนายจ้าง</option>
              <option value="MOU">MOU</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">รหัสพนักงาน</label>
            <input type="text" name="emp_code" class="form-control" required>
          </div>

          <div class="row">
            <div class="col-12 col-md-6 mb-3">
              <label class="form-label">ชื่อ</label>
              <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label class="form-label">นามสกุล</label>
              <input type="text" name="last_name" class="form-control" required>
            </div>
          </div>

          <h6 class="mt-4">📂 เอกสารประกอบ</h6>
          <div class="row">
            <div class="col-12 col-md-6 mb-3">
              <label class="form-label">รูปถ่าย</label>
              <input type="file" name="photo_path" class="form-control">
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label class="form-label">ใบอนุญาตทำงาน</label>
              <input type="file" name="work_permit_path" class="form-control">
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label class="form-label">พาสปอร์ต</label>
              <input type="file" name="passport_path" class="form-control">
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label class="form-label">ใบเสร็จ</label>
              <input type="file" name="receipt_path" class="form-control">
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label class="form-label">สมุดใบอนุญาตทำงาน</label>
              <input type="file" name="wp_book_path" class="form-control">
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label class="form-label">เอกสารรับเข้าทำงาน</label>
              <input type="file" name="work_accept_path" class="form-control">
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label class="form-label">แจ้งเข้าทำงาน (55)</label>
              <input type="file" name="notice_file_path55" class="form-control">
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label class="form-label">แจ้งเข้าทำงาน (52)</label>
              <input type="file" name="notice_file_path52" class="form-control">
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label class="form-label">บัตรชมพู - ด้านหน้า</label>
              <input type="file" name="pink_card_front_path" class="form-control">
            </div>
            <div class="col-12 col-md-6 mb-3">
              <label class="form-label">บัตรชมพู - ด้านหลัง</label>
              <input type="file" name="pink_card_back_path" class="form-control">
            </div>
          </div>

          <div class="mt-3 text-center">
            <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
          </div>

          <div class="mt-3 text-end">
            <a class="btn btn-danger" href="form_main.php">กลับ</a>
          </div>

        </form>
      </div>
    </div>
  </div>
  <?php include "loading.php";  ?>

</body>

</html>