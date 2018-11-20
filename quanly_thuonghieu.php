<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	
	<link rel="stylesheet" href="vendors/iconfonts/font-awesome/css/font-awesome.min.css" />
  	<link rel="stylesheet" type="text/css" href="css/custom.css">
	
  	<!-- css upload file -->
  	
	<title>Quản lý Thương Hiệu</title>
	
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
      
      <h1 style="text-align:center">Cập Nhật Thương Hiệu</h1>
    </div>

    <div class="container">
      <div class="form-group">
        <label>Tên thương hiệu</label>
        <input type="hidden" id="lblTenThuongHieu" name="" value="">
        <input type="text" class="form-control form-control-lg" id="txtTenThuongHieu" data-mathuonghieu="" placeholder="Nhập tên loại sản phẩm">
      </div>

      <div class="form-group" id="khunganhlon_modal">
	        <div class="file-loading">
	            <input id="ip_anhthuonghieu_modal" name="ip_anhthuonghieu_modal" data-preview-file-type="any" type="file" class="file" data-overwrite-initial="true" data-upload-url="uploadhinh.php">
	        </div>
	  </div>

      <div class="pull-right">
        <span id="btnCapnhatThuongHieu" class="btn btn-success mr-2">Cập nhật</span>
        <span onclick="document.getElementById('modal-wrapper').style.display='none';hienthi_Browse();" class="btn btn-light">Đóng</span>
      </div>
      
    </div>
    
  </form>
  
</div>







<div>
	<div class="row">
		<div class="col-lg-5 grid-margin stretch-card">
               <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Thương Hiệu</h4>
                  <p class="card-description">
                    Quản lý nội dung liên quan đến thương hiệu
                  </p>
                  <div class="form-group">
                    <label>Tên thương hiệu</label>
                    <input type="text" class="form-control form-control-lg" id="nameTenthuonghieu"  placeholder="Nhập tên thương hiệu">
                  </div>
                  <div class="form-group">
                    <label>Chọn ảnh</label>

                    <div class="form-group" id="khunganhlon" style="display: block;">
			            <div class="file-loading">
			                <input id="ip_anhthuonghieu" name="ip_anhthuonghieu" type="file" class="file" data-overwrite-initial="false" data-upload-url="uploadhinh.php">
			            </div>
			        </div>

                  </div>
                  
                  
                
                
                	<div class="template-demo">
				       <button type="button" id="btn-themthuonghieu" class="btn btn-success btn-fw">Thêm</button>
				    </div>
                </div>
              </div>
        </div>
        <div class="col-lg-7 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Danh Sách Thương Hiệu</h4>
                  
                   <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Tên</th>
                        <th>Hình</th>
                        <th>Cập nhật</th>
                        <th>Xóa</th>
                      </tr>
                    </thead>

                    <tbody>

                      <?php
                          DanhSachThuongHieuPhanTrang();
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
<script src="js/thuonghieu.js"></script>
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

function DanhSachThuongHieuPhanTrang(){
    global $conn;
    $sql = "SELECT * FROM thuonghieu";
    $ketqua = mysqli_query($conn, $sql);
    if($ketqua){
      //$dong["HINHTHUONGHIEU"]
      while ($dong = mysqli_fetch_array($ketqua)) {
        echo "<tr class='thuonghieu'>";
        echo '<td>'.$dong["TENTHUONGHIEU"].'</td>';
        echo '<td><img class="img-hinh" src="img/hinhthuonghieu/'.$dong["HINHTHUONGHIEU"].'" /></td>';
        echo '<td class="capnhat"><a data-anhlon="'.$dong["HINHTHUONGHIEU"].'" rev="'.$dong["TENTHUONGHIEU"].'" id='.$dong["MATHUONGHIEU"].'><img src="images/edit.svg"/></a></td>';
        echo '<td class="xoa"><a rev="'.$dong["TENTHUONGHIEU"].'" id='.$dong["MATHUONGHIEU"].'><img src="images/delete.svg"/></a></td>';
        echo '</tr>';
      }
      
    }
}

?>

<script type="text/javascript">
	function hienthi_Browse(){
		$('#khunganhlon').css('display', 'block');
		$('.fileinput-remove').trigger('click');
		$('#txtTenThuongHieu').val();
	}
</script>
</html>