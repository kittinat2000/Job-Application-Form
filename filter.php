<?php
// ดึงสาขาทั้งหมดมาใช้ใน dropdown
$branches = $conn->query("SELECT * FROM branches ORDER BY branch_order ASC");

// ดึงประเภทการทำรายการ (action_type) จากตาราง employees แบบไม่ซ้ำ
$action_type_rs = $conn->query("
    SELECT DISTINCT action_type 
    FROM employees 
    WHERE action_type IS NOT NULL AND action_type <> ''
    ORDER BY action_type ASC
");

// ค่าที่ถูกเลือกปัจจุบัน (สำหรับให้ select จำค่า)
$selected_branch = isset($_GET['branch_id']) ? $_GET['branch_id'] : '';
$selected_type   = isset($_GET['action_type']) ? $_GET['action_type'] : '';
$search          = isset($_GET['search']) ? trim($_GET['search']) : '';
?>

<form method="GET" class="row g-2 mb-3">
<div class="col-md-3">
  <select name="branch_id" class="form-select">
    <option value="">-- เลือกสาขา --</option>
    <?php while ($b = $branches->fetch_assoc()): ?>
      <option value="<?= htmlspecialchars($b['id']) ?>" 
        <?= ($selected_branch == $b['id']) ? 'selected' : '' ?>>
        สาขาที่
        <?= htmlspecialchars($b['branch_order']) ?>
        <?= htmlspecialchars($b['branch_type']) ?>
        <?= htmlspecialchars($b['branch_name']) ?>
      </option>
    <?php endwhile; ?>
  </select>
</div>


<div class="col-md-3">
  <select name="action_type" class="form-select">
    <option value="">-- เลือกประเภท --</option>
    <?php if ($action_type_rs && $action_type_rs->num_rows > 0): ?>
      <?php while ($r = $action_type_rs->fetch_assoc()): 
            $type = $r['action_type']; ?>
        <option value="<?= htmlspecialchars($type) ?>"
          <?= ($selected_type === $type) ? 'selected' : '' ?>>
          <?= htmlspecialchars($type) ?>
        </option>
      <?php endwhile; ?>
    <?php endif; ?>
  </select>
</div>


  <div class="col-md-3">
    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="ค้นหา (ชื่อ หรือ รหัส)">
  </div>

  <div class="col-md-3">
    <button type="submit" class="btn btn-primary">ค้นหา</button>
    <a href="?" class="btn btn-secondary">ล้าง</a>
  </div>
</form>
