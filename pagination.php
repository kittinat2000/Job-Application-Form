  <!-- แสดงตัวแบ่งหน้า -->
  <nav>
    <ul class="pagination justify-content-center">
      <!-- ปุ่มหน้าแรก -->
      <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
        <a class="page-link" href="?page=1">หน้าแรก</a>
      </li>

      <!-- ปุ่มก่อนหน้า -->
      <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
        <a class="page-link" href="?page=<?= $page - 1 ?>">ก่อนหน้า</a>
      </li>

      <!-- หน้าก่อนหน้า -->
      <?php if ($page - 1 > 0): ?>
        <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>"><?= $page - 1 ?></a></li>
      <?php endif; ?>

      <!-- หน้าปัจจุบัน -->
      <li class="page-item active"><span class="page-link"><?= $page ?></span></li>

      <!-- หน้าถัดไป -->
      <?php if ($page + 1 <= $total_pages): ?>
        <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>"><?= $page + 1 ?></a></li>
      <?php endif; ?>

      <!-- ปุ่มถัดไป -->
      <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
        <a class="page-link" href="?page=<?= $page + 1 ?>">ถัดไป</a>
      </li>

      <!-- ปุ่มหน้าสุดท้าย -->
      <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
        <a class="page-link" href="?page=<?= $total_pages ?>">หน้าสุดท้าย</a>
      </li>
    </ul>

    <!-- แสดงจำนวนหน้าทั้งหมด -->
    <div class="text-center mt-2">
      <small>หน้าที่ <?= $page ?> จากทั้งหมด <?= $total_pages ?> หน้า</small>
    </div>
  </nav>