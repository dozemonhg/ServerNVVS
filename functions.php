<?php
	include_once("dbconnect.php");
	
	$ham = $_POST["action"];

	switch ($ham) {
		case 'ThemLoaiSanPham':
			$ham();
			break;
		case 'XoaLoaisanpham':
			$ham();
			break;
		case 'CapnhatLoaiSanPham':
			$ham();
			break;
		case 'Themthuonghieu':
			$ham();
			break;
		case 'XoaThuongHieu':
			$ham();
			break;
		case 'CapnhatThuongHieu':
			$ham();
			break;
		case 'ThemSanPham':
			$ham();
			break;
		case 'SelectSanphamDetail':
			$ham();
			break;
		case 'CapNhatSanPham':
			$ham();
			break;
		case 'XoaSanPham':
			$ham();
			break;
		case 'Themnguoidung':
			$ham();
			break;
		case 'SelectNguoidungDetail':
			$ham();
			break;
		case 'Capnhatguoidung':
			$ham();
			break;
		case 'XoaTaikhoan':
			$ham();
			break;
		case 'ThoatSession':
			$ham();
			break;
		default:
			# code...
			break;
	}
	//warning
	function ThemLoaiSanPham(){
			global $conn;
			$tenloaisanpham = $_POST["tenloaisanpham"];
			$maloaicha = $_POST["maloaicha"];
			

			if($tenloaisanpham == "")
			{
				$arrayName = array(
				'type' => 'error',
				'msg' => 'Trường dữ liệu không được rỗng!.'
				);
				
			}
			else{

				$kq = mysqli_query($conn, "insert into loaisanpham(tenloaisp, maloai_cha) values('".$tenloaisanpham."', ".$maloaicha.")");
				if($kq){
						$sql = "SELECT b.MALOAISP,b.TENLOAISP,b.MALOAI_CHA, (select TENLOAISP FROM loaisanpham a WHERE a.MALOAISP = b.MALOAI_CHA) as TENLOAISANPHAMCHA FROM loaisanpham b";
					    $ketqua = mysqli_query($conn, $sql);
					    $mang = array();
					    while ($dong = mysqli_fetch_array($ketqua)) {
					    	array_push($mang, $dong);
					    }

					    $arrayName = array(
							'type' => 'success',
							'msg' => 'Đã thêm loại sản phẩm',
							'data' => $mang
						);

				}else{
						$arrayName = array(
							'type' => 'error',
							'msg' => 'Lỗi, không thể insert data'
						);
				}
				
				
			}
			echo json_encode($arrayName);
			
	}

	function XoaLoaisanpham(){
		global $conn;
		$maloaisanpham = $_POST['maloaisanpham'];
		/*
		1. kiểm tra mã có lsp con không. nếu có báo lỗi
			Nếu không có lsp con. Tiếp tục kiểm tra sản phẩm
				Nếu có báo lỗi, ngược lại xóa lsp đó
		*/
		$result = mysqli_query($conn, "SELECT * FROM LOAISANPHAM WHERE MALOAI_CHA=".$maloaisanpham);

		if(mysqli_num_rows($result) > 0){
			$arrayName = array(
				'type' => 'error',
				'msg' => 'Tồn tại loại sản phẩm con. Không thể xóa'
				);
		}else{
			$result2 = mysqli_query($conn, "SELECT * FROM sanpham where MALOAISP = ".$maloaisanpham);
			if(mysqli_num_rows($result2) > 0)
			{
				$arrayName = array(
					'type' => 'error',
					'msg' => 'Tồn tại sản phẩm thuộc loại sản phẩm này. Không thể xóa'
				);
			}else{
				mysqli_query($conn, "DELETE FROM LOAISANPHAM WHERE MALOAISP=".$maloaisanpham);
				$sql = "SELECT b.MALOAISP,b.TENLOAISP,b.MALOAI_CHA, (select TENLOAISP FROM loaisanpham a WHERE a.MALOAISP = b.MALOAI_CHA) as TENLOAISANPHAMCHA FROM loaisanpham b";
				    $ketqua = mysqli_query($conn, $sql);
				    $mang = array();
				    while ($dong = mysqli_fetch_array($ketqua)) {
				    	array_push($mang, $dong);
				    }

				    $arrayName = array(
						'type' => 'success',
						'msg' => 'Đã xóa loại sản phẩm',
						'data' => $mang
					);
				    
			}
		}
		
		echo json_encode($arrayName);
	}

	function CapnhatLoaiSanPham(){
		global $conn;
		$maloaisanpham = $_POST["maloaisanpham"];
		$tenloaisanpham = $_POST["tenloaisanpham"];

		if($tenloaisanpham != ""){
			mysqli_query($conn, "UPDATE LOAISANPHAM SET TENLOAISP='".$tenloaisanpham."' WHERE MALOAISP=".$maloaisanpham);
			$sql = "SELECT b.MALOAISP,b.TENLOAISP,b.MALOAI_CHA, (select TENLOAISP FROM loaisanpham a WHERE a.MALOAISP = b.MALOAI_CHA) as TENLOAISANPHAMCHA FROM loaisanpham b";
		    $ketqua = mysqli_query($conn, $sql);
		    $mang = array();
		    while ($dong = mysqli_fetch_array($ketqua)) {
		    	array_push($mang, $dong);
		    }

		    $arrayName = array(
				'type' => 'success',
				'msg' => 'Đã cập nhật loại sản phẩm',
				'data' => $mang
			);
		}else{
			$arrayName = array(
					'type' => 'error',
					'msg' => 'Tên loại sản phẩm rỗng'
				);
		}

		

		echo json_encode($arrayName);

	}

	function Themthuonghieu(){
		global $conn;
		$tenthuonghieu = $_POST["tenthuonghieu"];
		$hinhthuonghieu = $_POST["hinhthuonghieu"];

		$kq = mysqli_query($conn, "insert into thuonghieu(TENTHUONGHIEU, LUOTMUA, HINHTHUONGHIEU) values('".$tenthuonghieu."',0, '".$hinhthuonghieu."')");
		if($kq){
			$sql = "SELECT * FROM thuonghieu";
			$ketqua = mysqli_query($conn, $sql);
			$mang = array();
		    while ($dong = mysqli_fetch_array($ketqua)) {
		    	array_push($mang, $dong);
		    }

		    $arrayName = array(
				'type' => 'success',
				'msg' => 'Đã thêm thương hiệu',
				'data' => $mang
			);
		}else{
				$arrayName = array(
					'type' => 'error',
					'msg' => 'Lỗi, không thể insert data'
				);
		}

		echo json_encode($arrayName);

	}

	function XoaThuongHieu(){
		global $conn;
		$mathuonghieu = $_POST["mathuonghieu"];
		$tenthuonghieu = $_POST["tenthuonghieu"];
		$result2 = mysqli_query($conn, "SELECT * FROM sanpham WHERE mathuonghieu=".$mathuonghieu);
		if(mysqli_num_rows($result2) > 0)
		{
			$arrayName = array(
				'type' => 'error',
				'msg' => 'Tồn tại sản phẩm thuộc thương hiệu này. Không thể xóa'
			);
		}else{
			mysqli_query($conn, "DELETE FROM thuonghieu WHERE mathuonghieu=".$mathuonghieu);
			
		    $ketqua = mysqli_query($conn, "SELECT * FROM thuonghieu");
		    $mang = array();
		    while ($dong = mysqli_fetch_array($ketqua)) {
		    	array_push($mang, $dong);
		    }

		    $arrayName = array(
				'type' => 'success',
				'msg' => 'Đã xóa thương hiệu',
				'data' => $mang
			);
			    
		}
		echo json_encode($arrayName);

	}

	function CapnhatThuongHieu()
	{
		global $conn;
		$tenthuonghieu = $_POST["tenthuonghieu"];
		$tenhinh = $_POST["tenhinh"];
		$mathuonghieu = $_POST["mathuonghieu"];
		mysqli_query($conn, "UPDATE thuonghieu SET TENTHUONGHIEU='".$tenthuonghieu."',HINHTHUONGHIEU='".$tenhinh."'  WHERE MATHUONGHIEU=".$mathuonghieu);
		$ketqua = mysqli_query($conn, "SELECT * FROM thuonghieu");
	    $mang = array();
	    while ($dong = mysqli_fetch_array($ketqua)) {
	    	array_push($mang, $dong);
	    }

	    $arrayName = array(
			'type' => 'success',
			'msg' => 'Đã cập nhật thương hiệu',
			'data' => $mang
		);

		echo json_encode($arrayName);

	}

	function ThemSanPham(){
		global $conn;
		$tensanpham = $_POST["tensanpham"];
		$giasanpham = $_POST["giasanpham"];
		$anhLon = $_POST["anhLon"];
		$anhNho = $_POST["anhNho"];
		$maloaisanpham = $_POST["maloaisanpham"];
		$mathuonghieu = $_POST["mathuonghieu"];
		$thongtin = $_POST["thongtin"]; 

		$kq = mysqli_query($conn, "INSERT INTO sanpham(MALOAISP, MATHUONGHIEU, TENSP, GIA, ANHLON, ANHNHO, THONGTIN, SOLUONG, LUOTMUA) VALUES (".$maloaisanpham.", ".$mathuonghieu.", '".$tensanpham."', ".$giasanpham.", '".$anhLon."', '".$anhNho."','".$thongtin."', 0,0)");
		if($kq){
			$ketqua = mysqli_query($conn, "SELECT * FROM sanpham");
					    $mang = array();
					    while ($dong = mysqli_fetch_array($ketqua)) {
					    	array_push($mang, $dong);
					    }

					    $arrayName = array(
							'type' => 'success',
							'msg' => 'Đã thêm sản phẩm',
							'data' => $mang
						);
		}else{
			$arrayName = array(
							'type' => 'error',
							'msg' => 'Lỗi, không thể insert data'
						);
		}

		echo json_encode($arrayName);

	}

	function SelectSanphamDetail()
	{
		global $conn;
		$masanpham = $_POST["masanpham"];
		$ketqua = mysqli_query($conn, "SELECT * FROM sanpham WHERE MASP=".$masanpham);
		$kq2 = mysqli_query($conn, "SELECT * FROM loaisanpham");
		$kq3 = mysqli_query($conn, "SELECT * FROM thuonghieu");

		$mang = array();
		$dslsp = array();
		$dsth = array();

	    while ($dong = mysqli_fetch_array($ketqua)) {
	    	array_push($mang, $dong);
	    }
	    while ($dong = mysqli_fetch_array($kq2)) {
	    	array_push($dslsp, $dong);
	    }
	    while ($dong = mysqli_fetch_array($kq3)) {
	    	array_push($dsth, $dong);
	    }

	    $arrayName = array(
			'type' => 'success',
			'msg' => 'select sản phẩm',
			'data' => $mang,
			'dsloaisanpham' => $dslsp,
			'dsthuonghieu' => $dsth
		);
	    echo json_encode($arrayName);

	}

	function CapNhatSanPham(){
		global $conn;
		$tensanpham = $_POST["tensanpham"];
		$giasanpham = $_POST["giasanpham"];
		$anhLon = $_POST["anhLon"];
		$anhNho = $_POST["anhNho"];
		$maloaisanpham = $_POST["maloaisanpham"];
		$mathuonghieu = $_POST["mathuonghieu"];
		$thongtin = $_POST["thongtin"];
		$masanpham = $_POST["masanpham"];

		$kq = mysqli_query($conn, "UPDATE sanpham SET MALOAISP=".$maloaisanpham.",MATHUONGHIEU=".$mathuonghieu.",TENSP='".$tensanpham."',GIA=".$giasanpham.",ANHLON='".$anhLon."',ANHNHO='".$anhNho."',THONGTIN='".$thongtin."' WHERE MASP = ".$masanpham);

		if($kq){
			$ketqua = mysqli_query($conn, "SELECT * FROM sanpham");
					    $mang = array();
					    while ($dong = mysqli_fetch_array($ketqua)) {
					    	array_push($mang, $dong);
					    }

					    $arrayName = array(
							'type' => 'success',
							'msg' => 'Đã cập nhật sản phẩm',
							'data' => $mang
						);
		}else{
			$arrayName = array(
							'type' => 'error',
							'msg' => 'Lỗi, không thể insert data'
						);
		}

		echo json_encode($arrayName);
	}

	function XoaSanPham(){
		global $conn;
		$masanpham = $_POST["masanpham"];
		$kq1 = mysqli_query($conn, "SELECT DISTINCT(MASP) FROM chitietphieunhap WHERE MASP=".$masanpham);
		$kq2 = mysqli_query($conn, "SELECT DISTINCT(MASP) FROM chitiethoadon WHERE MASP=".$masanpham);
		$xoa = 0;
		if(mysqli_num_rows($kq1) > 0) $xoa++;
		if(mysqli_num_rows($kq2) > 0) $xoa++;
		if($xoa > 0){
			$arrayName = array(
							'type' => 'error',
							'msg' => 'Không thể xóa sản phẩm. Bị ràng buộc hóa đơn'
						);
		}else{
			mysqli_query($conn, "DELETE FROM SANPHAM WHERE MASP=".$masanpham);
			$ketqua = mysqli_query($conn, "SELECT * FROM SANPHAM");

		    $mang = array();
		    while ($dong = mysqli_fetch_array($ketqua)) {
		    	array_push($mang, $dong);
		    }

		    $arrayName = array(
				'type' => 'success',
				'msg' => 'Đã xóa sản phẩm',
				'data' => $mang
			);
		}

		echo json_encode($arrayName);

	}

	function Themnguoidung(){
		global $conn;
		$tennhanvien = $_POST["tennhanvien"];
		$maloainhanvien = $_POST["maloainhanvien"];
		$tendangnhap = $_POST["tendangnhap"];
		$matkhau = $_POST["matkhau"];
		$diachi = $_POST["diachi"];
		$ngaysinh = $_POST["ngaysinh"];
		$sodienthoai = $_POST["sodienthoai"];
		$gioitinh = $_POST["gioitinh"];
		$kq1 = mysqli_query($conn, "SELECT * FROM user WHERE TENDANGNHAP LIKE'".$tendangnhap."'");
		if(mysqli_num_rows($kq1) > 0){
			$arrayName = array(
							'type' => 'error',
							'msg' => 'Tên đăng nhập bị trùng'
						);
		}else{
			$kq2 = mysqli_query($conn, "INSERT INTO user(MALOAINV, TENNV, TENDANGNHAP, MATKHAU, DIACHI, NGAYSINH, SODT, GIOITINH) VALUES (".$maloainhanvien.",'".$tennhanvien."','".$tendangnhap."','".$matkhau."','".$diachi."','".$ngaysinh."','".$sodienthoai."',".$gioitinh.")");
			if($kq2)
			{
				$ketqua = mysqli_query($conn, "SELECT * FROM user");
				$mang = array();
			    while ($dong = mysqli_fetch_array($ketqua)) {
			    	array_push($mang, $dong);
			    }

			    $arrayName = array(
					'type' => 'success',
					'msg' => 'Đã thêm tài khoản',
					'data' => $mang
				);
			}else{
				$arrayName = array(
							'type' => 'error',
							'msg' => 'Lỗi, không thể insert data'
						);
			}
		}

		echo json_encode($arrayName);
	}


	function SelectNguoidungDetail()
	{
		global $conn;
		$manhanvien = $_POST["manhanvien"];

		$ketqua = mysqli_query($conn, "SELECT * FROM user WHERE MANV=".$manhanvien);


		$mang = array();
	    while ($dong = mysqli_fetch_array($ketqua)) {
	    	array_push($mang, $dong);
	    }

	    $arrayName = array(
			'type' => 'success',
			'msg' => 'select',
			'data' => $mang
		);

		echo json_encode($arrayName);


	}

	function Capnhatguoidung()
	{
		global $conn;
		$tennhanvien = $_POST["tennhanvien"];
		$maloainhanvien = $_POST["maloainhanvien"];
		$tendangnhap = $_POST["tendangnhap"];
		$matkhau = $_POST["matkhau"];
		$diachi = $_POST["diachi"];
		$ngaysinh = $_POST["ngaysinh"];
		$sodienthoai = $_POST["sodienthoai"];
		$gioitinh = $_POST["gioitinh"];
		$manhanvien = $_POST["manhanvien"];
		$kq1 = mysqli_query($conn, "SELECT * FROM user WHERE TENDANGNHAP LIKE'".$tendangnhap."' and MANV NOT IN(".$manhanvien.")");
		if(mysqli_num_rows($kq1) > 0){
			$arrayName = array(
							'type' => 'error',
							'msg' => 'Tên đăng nhập bị trùng'
						);
		}else{
			$sql = "UPDATE user SET MALOAINV=".$maloainhanvien.",TENNV='".$tennhanvien."',TENDANGNHAP='".$tendangnhap."',MATKHAU='".$matkhau."',DIACHI='".$diachi."',NGAYSINH='".$ngaysinh."',SODT='".$sodienthoai."',GIOITINH=".$gioitinh." WHERE MANV='".$manhanvien."'";
			$kq2 = mysqli_query($conn, $sql);
			if($kq2)
			{
				$ketqua = mysqli_query($conn, "SELECT * FROM user");
				$mang = array();
			    while ($dong = mysqli_fetch_array($ketqua)) {
			    	array_push($mang, $dong);
			    }

			    $arrayName = array(
					'type' => 'success',
					'msg' => 'Đã cập nhật tài khoản',
					'data' => $mang
				);
			}else{
				$arrayName = array(
							'type' => 'error',
							'msg' => $sql
						);
			}
		}

		echo json_encode($arrayName);
	}

	function XoaTaikhoan()
	{
		global $conn;
		$manhanvien = $_POST["manhanvien"];

		$kq1 = mysqli_query($conn, "SELECT DISTINCT(MANV) FROM chitietbinhluan WHERE MANV=".$manhanvien);
		$kq2 = mysqli_query($conn, "SELECT DISTINCT(MANV) FROM hoadon WHERE MANV=".$manhanvien);
		$xoa = 0;
		if(mysqli_num_rows($kq1) > 0) $xoa++;
		if(mysqli_num_rows($kq2) > 0) $xoa++;

		if($xoa > 0){
			$arrayName = array(
							'type' => 'error',
							'msg' => 'Không thể xóa user. Bị ràng buộc hóa đơn'
						);
		}else{
			mysqli_query($conn, "DELETE FROM user WHERE MANV=".$manhanvien);
			$ketqua = mysqli_query($conn, "SELECT * FROM user");

		    $mang = array();
		    while ($dong = mysqli_fetch_array($ketqua)) {
		    	array_push($mang, $dong);
		    }

		    $arrayName = array(
				'type' => 'success',
				'msg' => 'Đã xóa user',
				'data' => $mang
			);
		}

		echo json_encode($arrayName);
	}

	function ThoatSession(){
		@session_start();
		$helper = array_keys($_SESSION);
	    foreach ($helper as $key){
	        unset($_SESSION[$key]);
	    }

	    $arrayName = array(
				'type' => 'success',
				'msg' => 'Đã thoát'
			);
	    echo json_encode($arrayName);
	}

?>