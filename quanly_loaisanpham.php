<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<!-- <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css"> -->
	<link rel="stylesheet" href="vendors/iconfonts/font-awesome/css/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="css/custom.css">
	<title>Quản lý loại sản phẩm</title>
	
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
      <span onclick="document.getElementById('modal-wrapper').style.display='none'" class="close" title="Close PopUp">&times;</span>
      
      <h1 style="text-align:center">Cập Nhật Loại Sản Phẩm</h1>
    </div>

    <div class="container">
      <div class="form-group">
        <label>Tên loại sản phẩm</label>
        <input type="hidden" id="lbl_idlsp" name="" value="">
        <input type="text" class="form-control form-control-lg" id="lsp_old" placeholder="Nhập tên loại sản phẩm">
      </div>

      <div class="pull-right">
        <span id="Update_lsp" class="btn btn-success mr-2">Cập nhật</span>
        <span onclick="document.getElementById('modal-wrapper').style.display='none'" class="btn btn-light">Đóng</span>
      </div>
      
    </div>
    
  </form>
  
</div>

<div>
	<div class="row">
		<div class="col-lg-5 grid-margin stretch-card">
               <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Loại Sản Phẩm</h4>
                  <p class="card-description">
                    Quản lý nội dung liên quan đến loại sản phẩm
                  </p>
                  <div class="form-group">
                    <label>Tên loại sản phẩm</label>
                    <input type="text" class="form-control form-control-lg" id="id_lsp_new" placeholder="Nhập tên loại sản phẩm" aria-label="Nhập tên loại sản phẩm">
                  </div>
                  
                  <h4 class="card-title"></h4>
                  <div class="form-group">
                    <label for="exampleFormControlSelect1">Loại cha</label>
                    <select class="form-control form-control-lg" id="id_lsp_cha">
                      <option value="0">Không có loại sản phẩm cha</option>
                      <?php
                        HienThiDanhMucLoaiSanPham();
                      ?>
                    </select>
                  </div>
                
                
                	<div class="template-demo">
					       <button type="button" id="btn-themlsp" class="btn btn-success btn-fw">Thêm</button>
					       </div>
                </div>
              </div>
        </div>
        <div class="col-lg-7 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Danh Sách Loại Sản Phẩm</h4>
                  
                   <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Tên loại sản phẩm</th>
                        <th>Loại cha</th>
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
<script src="js/loaisanpham.js"></script>
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
    $sql = "SELECT b.MALOAISP,b.TENLOAISP,b.MALOAI_CHA, (select TENLOAISP FROM loaisanpham a WHERE a.MALOAISP = b.MALOAI_CHA ) as TENLOAISANPHAMCHA FROM loaisanpham b";
    $ketqua = mysqli_query($conn, $sql);
    if($ketqua){
      
      while ($dong = mysqli_fetch_array($ketqua)) {
        echo "<tr class='test'>";
        echo '<td>'.$dong["TENLOAISP"].'</td>';
        echo '<td>'.$dong["TENLOAISANPHAMCHA"].'</td>';
        echo '<td class="capnhat"><a rev="'.$dong["TENLOAISP"].'" id='.$dong["MALOAISP"].'><img src="images/edit.svg"/></a></td>';
        echo '<td class="xoa"><a id='.$dong["MALOAISP"].'><img src="images/delete.svg"/></a></td>';
        echo '</tr>';
      }
      
    }
}

function HienThiDanhMucLoaiSanPham(){
    global $conn;
    $sql = "SELECT * FROM LOAISANPHAM WHERE MALOAI_CHA=0";
    $ketqua = mysqli_query($conn, $sql);
    if($ketqua){
      while ($dong = mysqli_fetch_array($ketqua)) {
        echo "<option style='font-weight: bold;' value='".$dong["MALOAISP"]."'>".$dong["TENLOAISP"]."</option>";
        $truyvancon = "SELECT * FROM LOAISANPHAM WHERE maloai_cha=".$dong["MALOAISP"];
        $ketquacon = mysqli_query($conn, $truyvancon);
        if($ketquacon)
        {
           while ($dongcon = mysqli_fetch_array($ketquacon))
           {
             echo "<option value='".$dongcon["MALOAISP"]."'>&nbsp; &nbsp;".$dongcon["TENLOAISP"]."</option>";
           }
        }
      }
    }
}

?>
</html>