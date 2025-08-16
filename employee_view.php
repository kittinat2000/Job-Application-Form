<?php
require "function/check_user.php";

require "config.php";

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM employees WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$emp = $result->fetch_assoc();

if (!$emp) {
  echo "ไม่พบข้อมูลพนักงาน";
  exit;
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>รายละเอียดพนักงาน</title>
  <link rel="stylesheet" href="assets/style_back_office.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <?php include "nav.php"; ?>

  <div class="container py-4">
    <h4>รายละเอียดพนักงาน</h4>
    <!-- ตารางรายละเอียด -->
    <table class="table table-bordered">
      <tr>
        <th>รหัสพนักงาน</th>
        <td><?= $emp['emp_code'] ?></td>
      </tr>
      <tr>
        <th>ชื่อ</th>
        <td><?= $emp['first_name'] ?></td>
      </tr>
      <tr>
        <th>นามสกุล</th>
        <td><?= $emp['last_name'] ?></td>
      </tr>

      <?php
      $fileFields = [
        "photo_path" => "รูปพนักงาน",
        "work_permit_path" => "ใบอนุญาตทำงาน",
        "passport_path" => "พาสปอร์ต",
        "receipt_path" => "ใบเสร็จ",
        "wp_book_path" => "สมุดใบอนุญาตทำงาน",
        "work_accept_path" => "ใบรับเข้าทำงาน",
        "notice_file_path55" => "แจ้งเข้าทำงาน55",
        "notice_file_path52" => "แจ้งเข้าทำงาน52",
        "pink_card_front_path" => "บัตรชมพู ด้านหน้า",
        "pink_card_back_path" => "บัตรชมพู ด้านหลัง"
      ];

      $i = 1;
      foreach ($fileFields as $field => $label):
        if (!empty($emp[$field])):
      ?>
          <tr>
            <th><?= $label ?></th>
            <td>
              <button class="btn btn-sm btn-primary"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#img<?= $i ?>"
                aria-expanded="false"
                aria-controls="img<?= $i ?>">
                ดู/ซ่อน รูป
              </button>

              <div class="collapse mt-2" id="img<?= $i ?>">
                <img src="uploads/<?= $emp[$field] ?>"
                  alt="<?= $label ?>"
                  class="img-fluid rounded shadow">
              </div>
            </td>
          </tr>
      <?php
          $i++;
        endif;
      endforeach;
      ?>
    </table>

    <!-- Modal แสดงรูป -->
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
      <div class="container text-center">
        <a href="dashboard.php" class="btn btn-secondary btn-lg w-100">กลับ</a>
      </div>
    </div>


    <script>
      function showImage(src) {
        document.getElementById('modalImage').src = src;
      }
    </script>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>