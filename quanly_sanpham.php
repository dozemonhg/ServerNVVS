<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	
	<link rel="stylesheet" href="vendors/iconfonts/font-awesome/css/font-awesome.min.css" />
  	<link rel="stylesheet" type="text/css" href="css/custom.css">
	
  	<!-- css upload file -->
  	
	<title>Quản lý sản phẩm</title>
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
      <span onclick="document.getElementById('modal-wrapper').style.display='none';hienthi_Browse();" class="close" title="Close PopUp">&times;</span>
      
      <h1 style="text-align:center">Cập Nhật Sản Phẩm</h1>
    </div>

    <div class="container">
      <div class="form-group">
        <label>Tên Sản phẩm</label>
        <input type="hidden" id="lblTenSanPham" name="" value="">
        <input type="hidden" id="lblMaSanPham_modal" name="" value="">
        <input type="text" class="form-control form-control-lg" id="txtTenSanPham" placeholder="Nhập tên sản phẩm">
      </div>

      <div class="form-group">
        <label>Giá bán:</label>
        <input type="text" class="form-control form-control-lg" id="txtGiasp" placeholder="Nhập giá sản phẩm">
      </div>

      <div class="form-group" id="khunganhlon_modal">
          <label>Ảnh Lớn:</label>
	        <div class="file-loading">
	            <input id="ip_anhsanphamLon_modal" name="ip_anhsanphamLon_modal" data-preview-file-type="any" type="file" class="file" data-overwrite-initial="true" data-upload-url="uploadhinh.php">
	        </div>
	    </div>

      <div class="form-group" id="khunganhnho_modal">
          <label>Ảnh nhỏ:</label>
          <div class="file-loading">
              <input id="ip_anhsanphamNho_modal" name="ip_anhsanphamNho_modal" multiple data-preview-file-type="any" type="file" class="file" data-overwrite-initial="true" data-upload-url="uploadhinh.php">
          </div>
      </div>

      <div class="form-group">
        <label for="exampleFormControlSelect2">Loại sản phẩm</label>
        <select class="form-control" id="slLoaisanpham_modal">
          <option value="0">Chọn loại sản phẩm</option>
          <?php
            DSLoaiSanPham();
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="exampleFormControlSelect2">Thương hiệu</label>
        <select class="form-control" id="slThuonghieu_modal">
          <option value="0">Chọn thương hiệu</option>
          <?php
            DSThuongHieu();
          ?>
        </select>
      </div>
      <div class="form-group">
          <label for="exampleFormControlSelect2">Thông tin sản phẩm</label>
          <textarea id="areaThongtin_modal" name="areaThongtin_modal"></textarea>
      </div>

      <div class="pull-right">
        <span id="btnCapnhatSanpham" class="btn btn-success mr-2">Cập nhật</span>
        <span onclick="document.getElementById('modal-wrapper').style.display='none';hienthi_Browse();" class="btn btn-light">Đóng</span>
      </div>
      
    </div>
    
  </form>
  
</div>










<div>
	<div class="row">
		<div class="col-lg-4 grid-margin stretch-card">
               <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Sản Phẩm</h4>
                  <p class="card-description">
                    Quản lý nội dung liên quan đến sản phẩm
                  </p>
                  <div class="form-group">
                    <label>Tên sản phẩm</label>
                    <input type="text" class="form-control form-control-lg" id="nameTensanpham"  placeholder="Nhập tên sản phẩm">
                  </div>

                  <div class="form-group">
                    <label>Giá bán:</label>
                    <input type="text" class="form-control form-control-lg" id="nameGiasanpham"  placeholder="Nhập giá bán">
                  </div>

                  <div class="form-group">
                    <label>Chọn ảnh lớn</label>

                    <div class="form-group" id="khunganhlon" style="display: block;">
  			            <div class="file-loading">
      			                <input id="ip_anhSanphamLon" name="ip_anhSanphamLon" type="file" class="file" data-overwrite-initial="false" data-upload-url="uploadhinh.php">
      			            </div>
      			        </div>
                  </div>

                  <div class="form-group">
                    <label>Chọn ảnh nhỏ</label>

                    <div class="form-group" id="khunganhnho" style="display: block;">
                    <div class="file-loading">
                            <input id="ip_anhSanphamNho" name="ip_anhSanphamNho" type="file" class="file" multiple data-overwrite-initial="false" data-upload-url="uploadhinh.php" data-min-file-count="2">
                    </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="exampleFormControlSelect2">Loại sản phẩm</label>
                    <select class="form-control" id="slLoaisanpham">
                      <option value="0">Chọn loại sản phẩm</option>
                      <?php
                        DSLoaiSanPham();
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlSelect2">Thương hiệu</label>
                    <select class="form-control" id="slThuonghieu">
                      <option value="0">Chọn thương hiệu</option>
                      <?php
                        DSThuongHieu();
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                      <label for="exampleFormControlSelect2">Thông tin sản phẩm</label>
                      <textarea id="areaThongtin" name="areaThongtin"></textarea>
                  </div>
                  
                  <div class="template-demo">
				       <button type="button" id="btn-themsanpham" class="btn btn-success btn-fw">Thêm</button>
				    </div>
                </div>
              </div>
        </div>








        <div class="col-lg-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Danh Sách Sản Phẩm</h4>
                  
                   <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Hình</th>
                        <th>Cập nhật</th>
                        <th>Xóa</th>
                      </tr>
                    </thead>

                    <tbody>

                      <?php
                          DanhSachSanPhamPhanTrang();
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
<script src="js/sanpham.js"></script>
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

function DanhSachSanPhamPhanTrang(){
    global $conn;
    $sql = "SELECT * FROM sanpham";
    $ketqua = mysqli_query($conn, $sql);
    if($ketqua){
      
      while ($dong = mysqli_fetch_array($ketqua)) {
        echo "<tr class='sanpham'>";
        echo '<td>'.$dong["TENSP"].'</td>';
        echo '<td>'.$dong["GIA"].'</td>';
        echo '<td>'.$dong["SOLUONG"].'</td>';
        echo '<td><img class="img-hinh" src="img/sanpham/'.$dong["ANHLON"].'" /></td>';
        echo '<td class="capnhat"><a data-anhlon="'.$dong["ANHLON"].'" rev="'.$dong["TENSP"].'" id='.$dong["MASP"].'><img src="images/edit.svg"/></a></td>';
        echo '<td class="xoa"><a rev="'.$dong["TENSP"].'" id='.$dong["MASP"].'><img src="images/delete.svg"/></a></td>';
        echo '</tr>';
      }
      
    }
}

function DSLoaiSanPham(){
  global $conn;
  $ketqua = mysqli_query($conn, "SELECT * FROM loaisanpham");
  if($ketqua){
    while ($dong = mysqli_fetch_array($ketqua)) {
      echo "<option value='".$dong["MALOAISP"]."'>&nbsp; &nbsp;".$dong["TENLOAISP"]."</option>";
    }
  }
}

function DSThuongHieu(){
  global $conn;
  $ketqua = mysqli_query($conn, "SELECT * FROM thuonghieu");
  if($ketqua){
    while ($dong = mysqli_fetch_array($ketqua)) {
      echo "<option value='".$dong["MATHUONGHIEU"]."'>&nbsp; &nbsp;".$dong["TENTHUONGHIEU"]."</option>";
    }
  }
}

?>

<script type="text/javascript">
	function hienthi_Browse(){
		$('#khunganhlon').css('display', 'block');
    $('#khunganhnho').css('display', 'block');
		$('.fileinput-remove').trigger('click');
		$("#nameTensanpham").val('');
    //$("#nameGiasanpham").val('');
    tinymce.get('areaThongtin').setContent("");
	}
</script>
</html>