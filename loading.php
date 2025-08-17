<!-- Overlay ตอนโหลด -->
<div id="loadingOverlay">
  <div class="loader"></div>
  <p>กำลังอัพโหลดข้อมูล...</p>
</div>

<script>
document.getElementById('myForm').addEventListener('submit', function() {
  document.getElementById('loadingOverlay').style.display = 'flex';
});
</script>