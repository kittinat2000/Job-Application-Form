<?php
// ดึงสาขาทั้งหมดมาใช้ใน dropdown
$branches = $conn->query("SELECT id, branch_name FROM branches ORDER BY branch_name ASC");

// ประเภทที่มีให้เลือก
$action_types = ["ลงทะเบียน", "เปลี่ยนนายจ้าง", "moni"];

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
          <?= htmlspecialchars($b['branch_name']) ?>
        </option>
      <?php endwhile; ?>
    </select>
  </div>

  <div class="col-md-3">
    <select name="action_type" class="form-select">
      <option value="">-- เลือกประเภท --</option>
      <?php foreach ($action_types as $type): ?>
        <option value="<?= $type ?>" 
          <?= ($selected_type == $type) ? 'selected' : '' ?>>
          <?= $type ?>
        </option>
      <?php endforeach; ?>
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
