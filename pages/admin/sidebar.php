<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="../../dist/img/home.png" alt="AdminLTE Logo" class="brand-image  elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Rumah Sewaku</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?=  $_SESSION['nama']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item ">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Home</p>
                </a>
              </li>
            </ul>
          </li>
         
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Data Master
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="kategori_kos.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kategori Kos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="kamar_kos.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kamar Kos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="akun.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Akun</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pelanggan.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pelanggan</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Data Transaksi
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="kas.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kas</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="setoran.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Setoran</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="transaksi_kos.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transaksi Kos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="transaksi_pembayaran.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transaksi Pembayaran</p>
                </a>
              </li>
       
              <li class="nav-item">
                <a href="transaksi_pengeluaran.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transaksi Pengeluaran</p>
                </a>
              </li>

            </ul>
            </li>
            <li class="nav-item" style="margin-left: 5px;">
            <a class="nav-link collapsed" href="#" data-toggle="modal" data-target="#logoutModal"  aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2  "></i>
             <span>Logout</span>
           </a>
            </li>
        </ul>
 
        
        
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  
  
  <!-- Logout Modal-->
  <?php
      include 'logoutmodal.php';
  ?>
  <!-- End Logout Modal -->