<!DOCTYPE html>
<html lang="en">
<?php
@session_start();
if(isset($_SESSION["tendangnhap"]) && $_SESSION["tendangnhap"] != ""){
 // echo "<script>window.location='index.php?khoatrang=trangchu'</script>";
}
?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Đăng nhập</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/iconfonts/puse-icons-feather/feather.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
<?php
    include_once("dbconnect.php");
    global $conn;

    if(isset($_POST["txttendangnhap"])){
      $ten=$_POST["txttendangnhap"];
      $pass=$_POST["txtpass"];
      
      $loi="";
      if(trim($ten)==""){
        $loi.="<li class='loi'>Tên đăng nhập rỗng</li>";
      }else if(strlen($ten)>30){
        $loi.="<li class='loi'>Mật khẩu lớn hơn 30</li>";
      }
      if(trim($pass)==""){
          $loi.="<li class='loi'>Mật khẩu rỗng</li>";
      }else if(strlen($pass)<5){
        $loi.="<li class='loi'>Mật khẩu lớn hơn 5</li>";
      }
      if($loi!=""){
        echo $loi;
      }else
      {
        $sql = "select a.* from user as a, loaiuser as b where a.MALOAINV = b.MALOAINV and a.tendangnhap='".$ten."' and a.matkhau='".$pass."'";

        $dong=mysqli_query($conn, $sql) or die(mysql_error());
        
        if(mysqli_num_rows($dong)==0)
        {
          echo "<li class='loi'>Đăng nhập thất bại</li>";
        }
        else
        {
          $row=mysqli_fetch_array($dong);
          $_SESSION["tendangnhap"]=$ten;
          $_SESSION["hoten"] = $row["TENNV"];
          $_SESSION["loaiuser"] = $row["MALOAINV"];
          echo "<script>alert('Đăng nhập thành công.')</script>";
          echo "<script>window.location='trangchu.php'</script>";
          //echo "<script>window.location='index.php?khoatrang=trangchu'</script>";
        }
      }
  }
?>



  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
      <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auto-form-wrapper">
              <form name="frm" method="post">
                <div class="form-group">
                  <label class="label">Tên đăng nhập</label>
                  <div class="input-group">
                    <input type="text" name="txttendangnhap" id="txttendangnhap" class="form-control" AUTOCOMPLETE="off" placeholder="Nhập tên đăng nhập">
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-check-circle-outline"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="label">Mật khẩu</label>
                  <div class="input-group">
                    <input type="password" name="txtpass" id="txtpass" AUTOCOMPLETE="off" class="form-control" placeholder="*********">
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-check-circle-outline"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <button type="submit" id="btndangnhap" class="btn btn-primary submit-btn btn-block">Đăng nhập</button>
                </div>
                <div class="form-group d-flex justify-content-between">
                  <div class="form-check form-check-flat mt-0">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" checked> Lưu mật khẩu
                    </label>
                  </div>
                  <a href="#" class="text-small forgot-password text-black">Quên mật khẩu</a>
                </div>
                <div class="form-group">
                  <button class="btn btn-block g-login">
                    <img class="mr-3" src="images/file-icons/icon-google.svg" alt=""></button>
                </div>
                <div class="text-block text-center my-3">
                  <!-- <span class="text-small font-weight-semibold">Not a member ?</span>
                  <a href="register.html" class="text-black text-small">Create new account</a> -->
                </div>
              </form>
            </div>
            <ul class="auth-footer">
              <li>
                <a href="#"></a>
              </li>
              <li>
                <a href="#"></a>
              </li>
              <li>
                <a href="#"></a>
              </li>
            </ul>
            <p class="footer-text text-center">copyright © 2018 NguyenVuStore - Tran Thi To Quyen. All rights reserved.</p>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/misc.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>