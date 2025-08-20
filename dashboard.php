<?php
require "function/check_user.php";
require "config.php";

// รับค่าจากฟอร์มกรอง
$selected_branch = $_GET['branch_id'] ?? '';
$selected_type   = $_GET['action_type'] ?? '';
$search          = $_GET['search'] ?? '';

// ตั้งค่า pagination
$limit = 10;
$page  = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// สร้างเงื่อนไข
$where = [];
$params = [];
$types = "";

// --- ฟิลเตอร์ ---
if (!empty($selected_branch)) {
  $where[] = "branch_id = ?";
  $params[] = $selected_branch;
  $types .= "i";
}

if (!empty($selected_type)) {
  $where[] = "action_type = ?";
  $params[] = $selected_type;
  $types .= "s";
}

if (!empty($search)) {
  $where[] = "(first_name LIKE ? OR last_name LIKE ? OR emp_code LIKE ?)";
  $like = "%" . $search . "%";
  $params[] = $like;
  $params[] = $like;
  $params[] = $like;
  $types .= "sss";
}

// --- Pagination ---
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// --- นับจำนวนทั้งหมด (ตาม filter) ---
$sql_count = "SELECT COUNT(*) AS total FROM employees";
if (!empty($where)) {
  $sql_count .= " WHERE " . implode(" AND ", $where);
}
$stmt_count = $conn->prepare($sql_count);
if (!empty($params)) {
  $stmt_count->bind_param($types, ...$params);
}
$stmt_count->execute();
$total_result = $stmt_count->get_result();
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// --- ดึงข้อมูลตาม filter + limit ---
// --- ดึงข้อมูลตาม filter + limit ---
$sql_data = "SELECT e.*, b.branch_name, b.branch_type, b.branch_order
             FROM employees e 
             LEFT JOIN branches b ON e.branch_id = b.id";
if (!empty($where)) {
  $sql_data .= " WHERE " . implode(" AND ", $where);
}
$sql_data .= " ORDER BY e.id DESC LIMIT ? OFFSET ?";

$stmt_data = $conn->prepare($sql_data);

// รวม params เดิมกับ limit, offset
$params_with_limit = array_merge($params, [$limit, $offset]);
$types_with_limit = $types . "ii";

$stmt_data->bind_param($types_with_limit, ...$params_with_limit);
$stmt_data->execute();
$result = $stmt_data->get_result();
?>

<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>จัดการพนักงาน</title>
  <link rel="stylesheet" href="assets/style_back_office.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="..." crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <?php include "nav.php"; ?>

  <div class="container py-4">
    <h4 class="mb-3">รายการพนักงาน</h4>
    <?php include "filter.php"; ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle text-start">
        <thead class="table-primary">
          <tr>
            <th>สาขา</th>
            <th>รหัส</th>
            <th>ชื่อ-นามสกุล</th>
            <th class="text-center">ประเภท</th>
            <th class="text-center">จัดการ</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td>
                สาขาที่ <?php echo htmlspecialchars($row['branch_order']); ?>
                <?php echo htmlspecialchars($row['branch_type']); ?> -
                <?php echo htmlspecialchars($row['branch_name']); ?>
              </td>
              <td><?php echo htmlspecialchars($row['emp_code']); ?></td>
              <td><?php echo htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?></td>
              <td class="text-center"><?php echo htmlspecialchars($row['action_type']); ?></td>
              <td>
                <div class="d-flex gap-1 justify-content-center">
                  <a href="employee_view.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">ดู</a>
                  <?php if (
                    $row['action_type'] == "MOU"
                    || $row['action_type'] == "เปลี่ยนนายจ้าง"
                    || $row['action_type'] == ""
                  ): ?>
                    <form method="POST" action="function/export_pdf_foreign.php" target="_blank">
                      <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                      <button type="submit" class="btn btn-danger btn-sm">📄PDF-f</button>
                    </form>
                  <?php else: ?>
                    <form method="POST" action="function/export_pdf_thai.php" target="_blank">
                      <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                      <button type="submit" class="btn btn-danger btn-sm">📄PDF</button>
                    </form>
                  <?php endif; ?>

                  <a href="employee_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">แก้ไข</a>
                  <a href="employee_delete.php?id=<?php echo $row['id']; ?>"
                    onclick="return confirm('คุณแน่ใจว่าต้องการลบ?')"
                    class="btn btn-danger btn-sm">ลบ</a>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
    <!-- แสดงตัวแบ่งหน้า -->
    <?php include "pagination.php"; ?>
  </div>
  <!-- หน้าโหลดระหว่างรอกรอกข้อมูล -->
  <?php include "loading.php"; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>