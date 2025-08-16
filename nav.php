  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <!-- เมนูด้านซ้าย -->
      <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
        <img src="assets/img/miracleplanet-transparent-white.png" alt="logo" width="40" height="40" class="me-2">
        Job Application Management
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- เมนูหลัก -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">

          <li class="nav-item">
            <a class="nav-link" href="log.php">Log</a>
          </li>
        </ul>

        <!-- ปุ่มด้านขวา -->
        <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Setting
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <li><a class="dropdown-item" href="user_manage.php">User Manage</a></li>
              <li><a class="dropdown-item" href="branches.php">รายชื่อสาขา</a></li>
            </ul>
          </li>
        </ul>

        <!-- ปุ๋มล็อคเอ้า -->
        <div class="d-flex">
          <a href="logout.php" class="btn btn-outline-light btn-sm">ออกจากระบบ</a>
        </div>
      </div>
    </div>
  </nav>