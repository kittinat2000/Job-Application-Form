<!-- Loading Overlay -->
<div id="loading-overlay" style="
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(255, 255, 255, 0.8);
  display: none; /* ซ่อนตอนโหลดหน้า */
  justify-content: center;
  align-items: center;
  z-index: 9999;">
  <div class="spinner-border text-primary" role="status">
    <span class="visually-hidden">กำลังโหลด...</span>
  </div>
</div>

<script>
  const form = document.querySelector("form");
  const loading = document.getElementById("loading-overlay");

  form.addEventListener("submit", function () {
    loading.style.display = "flex"; // แสดงหน้าโหลด
  });
</script>
