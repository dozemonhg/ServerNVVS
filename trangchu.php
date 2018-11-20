<!DOCTYPE html>
<html lang="en">
<?php
@session_start();
if($_SESSION["tendangnhap"] == ""){

  //echo "<script>window.location='login.php'</script>";
}


?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Nguyễn Vũ Store</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/iconfonts/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  
  <!-- <link rel="stylesheet" href="vendors/iconfonts/font-awesome/css/font-awesome.min.css" />
  <link rel="stylesheet" href="vendors/icheck/skins/all.css"> -->
  <!-- <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
   -->
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/custom.css">
  <link rel="stylesheet" href="css/style.css">
  
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />


  <!-- css toast -->
  <link rel="stylesheet" href="css/toastr.css">

  <!-- <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet" /> -->
  <link rel="stylesheet" href="css/style_toast.css">
  <link href="css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>

  
</head>


<body>

  <?php
    include_once("dbconnect.php");
  ?>

  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="#">
          <img src="images/logo.svg" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="index.html">
          <img src="images/logo-mini.svg" alt="logo" />
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
          <li class="nav-item">
            <a href="#" class="nav-link">Schedule
              <span class="badge badge-primary ml-1">New</span>
            </a>
          </li>
          <li class="nav-item active">
            <a href="#" class="nav-link">
              <i class="mdi mdi-elevation-rise"></i>Thống Kê doanh thu</a>
          </li>
          
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          
          
          <li class="nav-item dropdown d-none d-xl-inline-block">
            <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <span class="profile-text"><?=$_SESSION["hoten"]?></span>
              <img class="img-xs rounded-circle" src="images/faces/face1.jpg" alt="Profile image">
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
              <a class="dropdown-item p-0">
                <div class="d-flex border-bottom">
                  <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                    <i class="mdi mdi-bookmark-plus-outline mr-0 text-gray"></i>
                  </div>
                  <div class="py-3 px-4 d-flex align-items-center justify-content-center border-left border-right">
                    <i class="mdi mdi-account-outline mr-0 text-gray"></i>
                  </div>
                  <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                    <i class="mdi mdi-alarm-check mr-0 text-gray"></i>
                  </div>
                </div>
              </a>
              
              <a class="dropdown-item">
                Thay đổi mật khẩu
              </a>
              
              <a class="dropdown-item" id="txtThoat">
                Thoát
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../../partials/_sidebar.html -->
      
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <div class="nav-link">
              <div class="user-wrapper">
                <div class="profile-image">
                  <img src="images/faces/face1.jpg" alt="profile image">
                </div>
                <div class="text-wrapper">
                  <p class="profile-name"><?= $_SESSION["hoten"] ?></p>
                  <div>
                    <small class="designation text-muted">
                    <?php
                    if($_SESSION["loaiuser"] == 1){
                      echo "Nhân viên";
                    }else{
                      echo "Quản lý";
                    }
                    ?>
                    </small>
                    <span class="status-indicator online"></span>
                  </div>
                </div>
              </div>
              <button class="btn btn-success btn-block">Tạo đơn hàng
                <i class="mdi mdi-plus"></i>
              </button>
            </div>
          </li>
          <?php
            if($_SESSION["loaiuser"] == 2){

            
          ?>
          <li class="nav-item">
            <a class="nav-link" href="?khoatrang=quanly_loaisanpham">
              <i class="menu-icon mdi mdi-television"></i>
              <span class="menu-title">Quản lý Loại Sản Phẩm</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="?khoatrang=quanly_sanpham">
              <i class="menu-icon mdi mdi-table"></i>
              <span class="menu-title">Quản lý sản phẩm</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?khoatrang=quanly_thuonghieu">
              <i class="menu-icon mdi mdi-sticker"></i>
              <span class="menu-title">Quản lý thương hiệu</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?khoatrang=quanly_thuonghieu">
              <i class="menu-icon mdi mdi-anchor"></i>
              <span class="menu-title">Quản lý Nhà cung cấp</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?khoatrang=quanly_taikhoan">
              <i class="menu-icon mdi mdi-snowflake"></i>
              <span class="menu-title">Quản lý tài khoản</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?khoatrang=quanly_hoadonNhap">
              <i class="menu-icon mdi mdi-atom"></i>
              <span class="menu-title">Quản lý Hóa đơn Nhập</span>
            </a>
          </li>
          <?php
        }
          ?>
          <li class="nav-item">
            <a class="nav-link" href="?khoatrang=quanly_hoadonNhap">
              <i class="menu-icon mdi mdi-atom"></i>
              <span class="menu-title">Quản lý Hóa đơn Bán</span>
            </a>
          </li>
          
        </ul>
      </nav>
      
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">

          
        <?php
          if(isset($_GET["khoatrang"])){
            $khoatrang=$_GET["khoatrang"];
          }else{
            $khoatrang="";
          }
          switch($khoatrang){
              
            case "quanly_loaisanpham":
              include_once("quanly_loaisanpham.php");
              break;
            case "quanly_thuonghieu":
              include_once("quanly_thuonghieu.php");
              break;
            case 'quanly_sanpham':
              include_once('quanly_sanpham.php');
              break;
            case 'quanly_taikhoan':
              include_once('quanly_taikhoan.php');
              break;
            default:
          }   
        ?>






        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018
              <a href="http://www.bootstrapdash.com/" target="_blank">Bootstrapdash</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with
              <i class="mdi mdi-heart text-danger"></i>
            </span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <script src="js/trangchu.js"></script>
  
  <!-- <script src="js/loaisanpham.js"></script> -->
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->

  <!-- toast -->
  
  <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <script src="js/script_toast.js"></script>
  <script src="js/jquery-3.3.1.js"></script>
  <script src="js/fileinput.js" type="text/javascript"></script>
  
  


</body>

</html>
