<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	
	<link rel="stylesheet" href="vendors/iconfonts/font-awesome/css/font-awesome.min.css" />
  	<link rel="stylesheet" type="text/css" href="css/custom.css">
	
  	<!-- css upload file -->
  	
	<title>Quản lý Tài Khoản</title>
	<script src="js/tinymce/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'textarea', height: 250 });</script>
</head>
<body>
	<script>
// If user clicks anywhere outside of the modal, Modal will close

  var modal = document.getElementById('modal-wrapper');
  window.onclick = function(event) {
      if (event.target == modal) {
          modal.style.display = "none";
          
      }
  }


</script>
	<?php
    	include_once("dbconnect.php");
  	?>

<div id="modal-wrapper" class="modal">
  <form class="modal-content animate">
    <div class="imgcontainer">
      <span onclick="document.getElementById('modal-wrapper').style.display='none';" class="close" title="Close PopUp">&times;</span>
      
      <h1 style="text-align:center">Cập Nhật Tài Khoản</h1>
    </div>

    <div class="container">
      <div class="form-group">
        <label>Tên người dùng</label>
        <input type="hidden" id="lblMaNhanvien_modal" name="" value="">
        <input type="text" class="form-control form-control-lg" id="txtTennguoidung_modal" autocomplete="off"  placeholder="Nhập tên người dùng">
      </div>
      <div class="form-group">
        <label>Tên đăng nhập</label>
        <input type="text" class="form-control form-control-lg" id="txtTenDangNhap_modal"  placeholder="Nhập tên đăng nhập">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Mật khẩu</label>
        <input type="password" class="form-control" id="txtPassword_modal" placeholder="Password" >
      </div>
      <div class="form-group">
        <label>Số điện thoại</label>
        <input type="text" class="form-control" id="txtSodienthoai_modal" autocomplete="off"  placeholder="Nhập số điện thoại">
      </div>
      <div class="form-group">
        <label>Ngày sinh</label>
        <input class="form-control" id="txtNgaysinh_modal" placeholder="dd/mm/yyyy" />
      </div>
      <div class="form-group">
        <label>Giới tính</label>
        <select class="form-control" id="slGioitinh_modal">
          <option value="1">Nam</option>
          <option value="0">Nữ</option>
        </select>
      </div>
      <div class="form-group">
        <label>Loại quyền</label>
        <select class="form-control" id="slLoaiquyen_modal">
          <option value="0">Chọn loại quyền hạn</option>
          <?php
          DanhsachLoaiUser();
          ?>
        </select>
      </div>
      <div class="form-group">
          <label for="">Địa chỉ</label>
          <textarea id="areaThongtin_modal" name="areaThongtin_modal"></textarea>
      </div>

      

      <div class="pull-right">
        <span id="btnCapnhatTaiKhoan" class="btn btn-success mr-2">Cập nhật</span>
        <span onclick="document.getElementById('modal-wrapper').style.display='none';" class="btn btn-light">Đóng</span>
      </div>
      
    </div>
    
  </form>
  
</div>







<div>
	<div class="row" AUTOCOMPLETE="off">
		<div class="col-lg-5 grid-margin stretch-card">
               <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Tài Khoản</h4>
                  <p class="card-description">
                    Quản lý nội dung liên quan đến tài khoản
                  </p>
                  <div class="form-group">
                    <label>Tên người dùng</label>
                    <input type="text" class="form-control form-control-lg" id="txtTennguoidung" autocomplete="off"  placeholder="Nhập tên người dùng">
                  </div>
                  <div class="form-group">
                    <label>Tên đăng nhập</label>
                    <input type="text" class="form-control form-control-lg" id="txtTenDangNhap"  placeholder="Nhập tên đăng nhập">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Mật khẩu</label>
                    <input type="password" class="form-control" id="txtPassword" placeholder="Password" >
                  </div>
                  <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="text" class="form-control" id="txtSodienthoai" autocomplete="off"  placeholder="Nhập số điện thoại">
                  </div>
                  <div class="form-group">
                    <label>Ngày sinh</label>
                    <input class="form-control" id="txtNgaysinh" placeholder="dd/mm/yyyy" />
                  </div>
                  <div class="form-group">
                    <label>Giới tính</label>
                    <select class="form-control" id="slGioitinh">
                      <option value="1">Nam</option>
                      <option value="0">Nữ</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Loại quyền</label>
                    <select class="form-control" id="slLoaiquyen">
                      <option value="0">Chọn loại quyền hạn</option>
                      <?php
                      DanhsachLoaiUser();
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                      <label for="">Địa chỉ</label>
                      <textarea id="areaThongtin" name="areaThongtin"></textarea>
                  </div>

                  
                  
                
                
                	<div class="template-demo">
      				       <button type="button" id="btn-themtaikhoan" class="btn btn-success btn-fw">Thêm</button>
      				    </div>
                </div>
              </div>
        </div>
        <div class="col-lg-7 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Danh Sách Tài Khoản</h4>
                  
                   <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Tên</th>
                        <th>Loại tài khoản</th>
                        <th>Cập nhật</th>
                        <th>Xóa</th>
                      </tr>
                    </thead>

                    <tbody>

                      <?php
                          DanhSachTaiKhoanPhanTrang();
                      ?>
                      
                    </tbody>
                  </table>
                </div>
              </div>
        </div>
	</div>
</div>
	

</body>
<script src="js/jquery-3.3.1.js"></script>
<script src="js/taikhoan.js"></script>
<script src="assets/js/popper.min.js"></script>



<script src="assets/js/lib/data-table/datatables.min.js"></script>
<script src="assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
<script src="assets/js/lib/data-table/dataTables.buttons.min.js"></script>
<script src="assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
<script src="assets/js/lib/data-table/jszip.min.js"></script>
<script src="assets/js/lib/data-table/pdfmake.min.js"></script>
<script src="assets/js/lib/data-table/vfs_fonts.js"></script>
<script src="assets/js/lib/data-table/buttons.html5.min.js"></script>
<script src="assets/js/lib/data-table/buttons.print.min.js"></script>
<script src="assets/js/lib/data-table/buttons.colVis.min.js"></script>
<script src="assets/js/lib/data-table/datatables-init.js"></script>



<?php

function DanhSachTaiKhoanPhanTrang(){
    global $conn;
    $sql = "SELECT * FROM user";
    $ketqua = mysqli_query($conn, $sql);
    if($ketqua){
      while ($dong = mysqli_fetch_array($ketqua)) {
        echo "<tr class='user'>";
        echo '<td>'.$dong["TENNV"].'</td>';
        echo '<td>'.(($dong["MALOAINV"] == 1)?"Nhân viên":"Quản trị").'</td>';
        echo '<td class="capnhat"><a rev="'.$dong["TENDANGNHAP"].'" id='.$dong["MANV"].'><img src="images/edit.svg"/></a></td>';
        echo '<td class="xoa"><a rev="'.$dong["TENDANGNHAP"].'" id='.$dong["MANV"].'><img src="images/delete.svg"/></a></td>';
        echo '</tr>';
      }
      
    }
}

function DanhsachLoaiUser(){
  global $conn;
  $ketqua = mysqli_query($conn, "SELECT * FROM loaiuser");
    if($ketqua){
      while ($dong = mysqli_fetch_array($ketqua)) {
        echo "<option value='".$dong["MALOAINV"]."'>".$dong["TENLOAINV"]."</option>";
      }
      
    }
}

?>

</html>