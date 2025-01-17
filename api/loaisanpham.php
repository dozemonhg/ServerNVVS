<?php
	include_once("config.php");

	date_default_timezone_set('Asia/Ho_Chi_Minh');
	
	$ham = $_POST["ham"];
	
	switch ($ham) {
		
		case 'LayDanhSachMenu':
			$ham();
			break;
		
			case 'DangKyThanhVien':
			$ham();
			break;
		
			case 'LayDanhSachCacThuongHieuLon':
			$ham();
			break;
			
			case 'LayDanhSachTopChuotVaBanPhim':
			$ham();
			break;
			
			case 'LayDanhSachTopPhuKien':
			$ham(); 
			break;

			case 'LayDanhSachPhuKien':
			$ham(); 
			break;

			case 'LayDanhSachTienIch':
			$ham(); 
			break;

			case 'LayTopTienIch':
			$ham(); 
			break;


			case 'LayLogoThuongHieuLon':
			$ham(); 
			break;

			case 'LayDanhSachSanPhamMoi':
			$ham();
			break;

			case 'LayDanhSachSanPhamTheoMaThuongHieu':
			$ham(); 
			break;

			case 'LayDanhSachSanPhamTheoMaLoaiDanhMuc':
			$ham(); 
			break;

			case 'LaySanPhamVsChitietTheoMaSP':
			$ham(); 
			break;

			case 'ThemDanhGia':
			$ham(); 
			break;	

			case 'ThemHoaDon':
			$ham(); 
			break;
			
			case 'LayDanhSachDanhGiaTheoMaSP':
			$ham(); 
			break;

			case 'LayDanhSachKhuyenMai':
			$ham(); 
			break;

			case 'TimKiemSanPhamTheoTenSP':
			$ham(); 
			break;

			case 'LaySanPhamVsChitiet':
				$ham();
				break;
	
		
		case 'KiemTraDangNhap':
			$ham();
			break;
		
		
	}


	function TimKiemSanPhamTheoTenSP(){
			global $conn;
			$chuoijson = array();

			if(isset($_POST["tensp"]) || isset($_POST["limit"])  ){
				$tensp = $_POST["tensp"];
				$limit = $_POST["limit"];
			}

			$ngayhientai = date("Y/m/d");
			$truyvan = " SELECT *  FROM sanpham sp WHERE sp.TENSP like '%".$tensp."%' ORDER BY sp.MASP LIMIT ".$limit.",10";
			$ketqua = mysqli_query($conn,$truyvan);

			

			echo "{";
			echo "\"DANHSACHSANPHAM\":";

			if($ketqua){
				while ($dong = mysqli_fetch_array($ketqua)) {
						$truyvankhuyenmai = "SELECT * , DATEDIFF(km.NGAYKETTHUC,'".$ngayhientai."') as THOIGIANKM FROM khuyenmai km, chitietkhuyenmai ctkm WHERE km.MAKM = ctkm.MAKM AND ctkm.MASP='".$dong["MASP"]."'";
						$ketquakhuyenmai = mysqli_query($conn,$truyvankhuyenmai);

						$phantramkm = 0;
						if($ketquakhuyenmai){
							while ($dongkhuyenmai = mysqli_fetch_array($ketquakhuyenmai)) {
								$thoigiankm = $dongkhuyenmai["THOIGIANKM"];

								if($thoigiankm > 0){
									$phantramkm = $dongkhuyenmai["PHANTRAMKM"];
								}
							}
						}

						array_push($chuoijson, array("MASP"=>$dong["MASP"], "TENSP"=>$dong["TENSP"], "GIATIEN"=>$dong["GIA"]
							,"HINHSANPHAM"=>$dong["ANHLON"],"HINHSANPHAMNHO"=>$dong["ANHNHO"], "PHANTRAMKM"=>$phantramkm,"MANV"=>$dong["MANV"]));

					}	
			}

			echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
			echo "}";
		}

	function LayDanhSachKhuyenMai(){
			global $conn;
			$chuoijson = array();

			$ngayhientai = date("Y/m/d");
			$truyvan = "SELECT * FROM khuyenmai km, loaisanpham lsp WHERE DATEDIFF(km.NGAYKETTHUC,'".$ngayhientai."') >=0 AND lsp.MALOAISP = lsp.MALOAISP LIMIT 0 , 20";
			$ketqua = mysqli_query($conn,$truyvan);

			echo "{";
			echo "\"DANHSACHKHUYENMAI\":";

			if($ketqua){
				while ($dong = mysqli_fetch_array($ketqua)) {
					
					/*$truyvanchitietkhuyemai = "SELECT * FROM chitietkhuyenmai ctkm, sanpham sp WHERE ctkm.MAKM = '".$dong["MAKM"]."' AND ctkm.MASP = sp.MASP";*/
					$truyvanchitietkhuyemai = "SELECT * FROM chitietkhuyenmai ctkm, sanpham sp WHERE ctkm.MAKM = ctkm.MAKM AND ctkm.MASP = sp.MASP";
					$ketquakhuyenmai = mysqli_query($conn,$truyvanchitietkhuyemai);

					$chuoijsondanhsachsanpham = array();

					if($ketquakhuyenmai){
						while ( $dongkhuyenmai = mysqli_fetch_array($ketquakhuyenmai) ) {
							$chuoijsondanhsachsanpham[] = $dongkhuyenmai;
						}
					}

					array_push($chuoijson, array("MAKM"=>$dong["MAKM"],"TENSP"=>$dong["TENLOAISP"],"TENKM"=>$dong["TENKM"],"HINHKHUYENMAI"=>"http://".$_SERVER['SERVER_NAME']."/svnv/".$dong["HINHKHUYENMAI"],"DANHSACHSANPHAM"=>$chuoijsondanhsachsanpham));

				}
			}

			echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);

			echo "}";
		}



	function LayDanhSachDanhGiaTheoMaSP(){
			global $conn;
			$chuoijson = array();

			if(isset($_POST["masp"]) || isset($_POST["limit"]) ){
				$masp = $_POST["masp"];
				$limit = $_POST["limit"];
			}

			$truyvan = "SELECT * FROM danhgia WHERE MASP = ".$masp." ORDER BY NGAYDANHGIA LIMIT ".$limit." ,10";
			$ketqua = mysqli_query($conn,$truyvan);

			echo "{";
			echo "\"DANHSACHDANHGIA\":";

			if($ketqua){
				while ($dong = mysqli_fetch_array($ketqua)) {
					$chuoijson[] = $dong;
				}
			}

			echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);

			echo "}";

		}

	function ThemDanhGia(){
		global $conn;

		if(isset($_POST["madg"]) || isset($_POST["masp"]) || isset($_POST["tenthietbi"]) || isset($_POST["tieude"]) || isset($_POST["noidung"]) || isset($_POST["sosao"]) ){
			$madg = $_POST["madg"];
			$masp = $_POST["masp"];
			//$manv = $_POST["manv"];
			$tenthietbi = $_POST["tenthietbi"];
			$tieude = $_POST["tieude"];
			$noidung = $_POST["noidung"];
			$sosao = $_POST["sosao"];
		}

		$ngaydang = date("Y/m/d");

		$truyvan = "INSERT INTO danhgia (MADG,MASP,MANV,TENTHIETBI,TIEUDE,NOIDUNG,SOSAO,NGAYDANHGIA) VALUES ('".$madg."', '".$masp."', '".$tenthietbi."', '".$tieude."', '".$noidung."', '".$sosao."', '".$ngaydang."' )";
		$ketqua = mysqli_query($conn,$truyvan);

		if($ketqua){
			echo "{ketqua:true}";
		}else{
			echo "{ketqua:false}";	
		}

	}

	function ThemHoaDon(){
			global $conn;

			if(isset($_POST["danhsachsanpham"]) || isset($_POST["tennguoinhan"]) || isset($_POST["sodt"]) || isset($_POST["diachi"]) || isset($_POST["chuyenkhoan"]) ){
				$danhsachsanpham = $_POST["danhsachsanpham"];
				$tennguoinhan = $_POST["tennguoinhan"];
				$sodt = $_POST["sodt"];
				$diachi = $_POST["diachi"];
				$chuyenkhoan = $_POST["chuyenkhoan"];
			
			}

			$ngayhientai = date("Y/m/d");
			$ngaygiao = date_create($ngayhientai);
			$ngaygiao = date_modify($ngaygiao,"+3 days");
			$ngaygiao = date_format($ngaygiao,"Y/m/d") ;
			
			$trangthai = "chờ kiểm duyệt";

			$truyvan = "INSERT INTO hoadon (NGAYMUA,NGAYGIAO,TRANGTHAI,TENNGUOINHAN,SODT,DIACHI,CHUYENKHOAN) VALUES ('".$ngayhientai."', '".$ngaygiao."', '".$trangthai."', '".$tennguoinhan."', '".$sodt."', '".$diachi."', '".$chuyenkhoan."')";
			$ketqua = mysqli_query($conn,$truyvan);

			if($ketqua){
				
				$mahd = mysqli_insert_id($conn);
				$chuoijsonandroid = json_decode($danhsachsanpham);
				$arrayDanhSachSanPham = $chuoijsonandroid->DANHSACHSANPHAM;
				$dem = count($arrayDanhSachSanPham);

				for($i=0; $i<$dem; $i++){
					$jsonObect = $arrayDanhSachSanPham[$i];

					$masp = $jsonObect->masp;
					$soluong = $jsonObect->soluong;

					$truyvan = "INSERT INTO chitiethoadon (MAHD,MASP,SOLUONG) VALUES ('".$mahd."', '".$masp."', '".$soluong."')";
					$ketqua1 = mysqli_query($conn,$truyvan);


				}

				echo "{ketqua:true}" ;

			}else{
				echo "{ketqua:false}";	
			}

		}

	function LaySanPhamVsChitiet(){
		global $conn;
		$chuoijson = array();
		$chuoijsonchitiet = array();
		if(isset($_POST["masp"])){
			$masp = $_POST["masp"];
				
		}

		$truyvan = "SELECT *  FROM sanpham WHERE MASP=".$masp;
		$ketqua = mysqli_query($conn,$truyvan);

		echo "{";
		echo "\"CHITIETSANPHAM\":";

		$truyvanchitiet = "SELECT * FROM chitietsanpham WHERE MASP=".$masp;
		$ketquachitiet = mysqli_query($conn,$truyvanchitiet);

		if($ketquachitiet){
			while ($dongchitiet = mysqli_fetch_array($ketquachitiet)) {

				array_push($chuoijsonchitiet, array($dongchitiet["TENCHITIET"]=>$dongchitiet["GIATRI"]));
				
			}
		}


		if($ketqua){
			while ($dong = mysqli_fetch_array($ketqua)) {
					
				array_push($chuoijson,array("MASP"=>$dong["MASP"], "TENSP"=>$dong["TENSP"], "GIATIEN"=>$dong["GIA"], "SOLUONG"=>$dong["SOLUONG"]
						,"ANHNHO"=>$dong["ANHNHO"], "THONGTIN"=>$dong["THONGTIN"], "MALOAISP"=>$dong["MALOAISP"], "MATHUONGHIEU"=>$dong["MATHUONGHIEU"]
						, "LUOTMUA"=>$dong["LUOTMUA"],"THONGSOKYTHUAT"=>$chuoijsonchitiet));
			}
		}

		echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
		echo "}";
	}

	function LaySanPhamVsChitietTheoMaSP(){
		global $conn;
		$chuoijson = array();
		$chuoijsonchitiet = array();
		if(isset($_POST["masp"])){
			$masp = $_POST["masp"];
				
		}

		$ngayhientai = date("Y/m/d");

		$truyvan = "SELECT *  FROM sanpham sp , user nv  WHERE sp.MASP=".$masp." AND sp.MANV = nv.MANV ";
		$ketqua = mysqli_query($conn,$truyvan);

		$truyvankhuyenmai = "SELECT * , DATEDIFF(km.NGAYKETTHUC,'".$ngayhientai."') as THOIGIANKM FROM khuyenmai km, chitietkhuyenmai ctkm WHERE km.MAKM = ctkm.MAKM AND ctkm.MASP='".$masp."'";
		$ketquakhuyenmai = mysqli_query($conn,$truyvankhuyenmai);

		$phantramkm = 0;
		if($ketquakhuyenmai){
			while ($dongkhuyenmai = mysqli_fetch_array($ketquakhuyenmai)) {
				$thoigiankm = $dongkhuyenmai["THOIGIANKM"];

				if($thoigiankm > 0){
					$phantramkm = $dongkhuyenmai["PHANTRAMKM"];
				}
			}
		}

		echo "{";
		echo "\"CHITIETSANPHAM\":";

		$truyvanchitiet = "SELECT * FROM chitietsanpham WHERE MASP=".$masp;
		$ketquachitiet = mysqli_query($conn,$truyvanchitiet);

		if($ketquachitiet){
			while ($dongchitiet = mysqli_fetch_array($ketquachitiet)) {

				array_push($chuoijsonchitiet, array($dongchitiet["TENCHITIET"]=>$dongchitiet["GIATRI"]));
				
			}
		}


		if($ketqua){
			while ($dong = mysqli_fetch_array($ketqua)) {
					
				array_push($chuoijson,array("MASP"=>$dong["MASP"], "TENSP"=>$dong["TENSP"], "GIATIEN"=>$dong["GIA"], "SOLUONG"=>$dong["SOLUONG"]
						,"ANHNHO"=>$dong["ANHNHO"], "THONGTIN"=>$dong["THONGTIN"], "MALOAISP"=>$dong["MALOAISP"], "MATHUONGHIEU"=>$dong["MATHUONGHIEU"]
						,"MANV"=>$dong["MANV"],"PHANTRAMKM"=>$phantramkm,"TENNV"=>$dong["TENNV"], "LUOTMUA"=>$dong["LUOTMUA"],"THONGSOKYTHUAT"=>$chuoijsonchitiet));
			}
		}

		echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
		echo "}";
	}

	function LayDanhSachSanPhamTheoMaThuongHieu(){
		global $conn;
		$chuoijson = array();
		if(isset($_POST["maloaisp"]) || isset($_POST["limit"])){
			$maloai = $_POST["maloaisp"];
			$limit = $_POST["limit"];
		}
			
		echo "{";
		echo "\"DANHSACHSANPHAM\":";

		$chuoijson = LayDanhSachSanPhamTheoMaLoaiThuongHieu($conn,$maloai,$chuoijson,$limit);

		echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
		echo "}";

	}

	function LayDanhSachSanPhamTheoMaLoaiDanhMuc(){
		global $conn;
		$chuoijson = array();

		if(isset($_POST["maloaisp"]) || isset($_POST["limit"])){
			$maloai = $_POST["maloaisp"];
			$limit = $_POST["limit"];
		}
			
		$chuoijson = LayDanhSachSanPhamDanhMucTheoMaLoai($conn,$maloai,$chuoijson,$limit);

		echo "{";
		echo "\"DANHSACHSANPHAM\":";
				
		echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);

		echo "}";
	}

	function LayDanhSachSanPhamMoi(){
		global $conn;

			//lấy danh sách phụ kiện cha
		$truyvan = "SELECT *  FROM sanpham ORDER BY MASP DESC LIMIT 20" ;
		$ketquacon = mysqli_query($conn,$truyvan);	
		$chuoijson = array();

		echo "{";
		echo "\"DANHSACHSANPHAMMOIVE\":";
		if($ketquacon){
			while ($dongtienich = mysqli_fetch_array($ketquacon)) {
				array_push($chuoijson, array("MASP"=>$dongtienich["MASP"],'GIATIEN'=> $dongtienich["GIA"],'TENSP' => $dongtienich["TENSP"],'HINHSANPHAM'=>"http://".$_SERVER['SERVER_NAME']."/svnv/".$dongtienich["ANHLON"]));
					
			}
		}

		echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
		echo "}";
	}

	function LayLogoThuongHieuLon(){
		global $conn;

			//lấy danh sách phụ kiện cha
		$truyvan = "SELECT *  FROM thuonghieu" ;
		$ketquacon = mysqli_query($conn,$truyvan);	
		$chuoijson = array();

		echo "{";
		echo "\"DANHSACHTHUONGHIEU\":";
		if($ketquacon){
			while ($dongtienich = mysqli_fetch_array($ketquacon)) {
				array_push($chuoijson, array("MASP"=>$dongtienich["MATHUONGHIEU"],'TENSP' => $dongtienich["TENTHUONGHIEU"],'HINHSANPHAM'=>"http://".$_SERVER['SERVER_NAME']."/svnv/".$dongtienich["HINHTHUONGHIEU"]));
					
			}
		}

		echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
		echo "}";
	}


	function LayTopTienIch(){
		global $conn;

			//lấy danh sách phụ kiện cha
		$ketqua = LayDanhLoaiSanPhamTheoMaLoai($conn,82);
		$chuoijson = array();

		echo "{";
		echo "\"TOPTIENICH\":";
		if($ketqua){
			while ($dong = mysqli_fetch_array($ketqua)) {
					
				$ketquacon = LayDanhLoaiSanPhamTheoMaLoai($conn,$dong["MALOAISP"]);

				if($ketquacon){
					while ($dongcon = mysqli_fetch_array($ketquacon)) {
							$chuoijson = LayDanhSachSanPhamTheoMaLoai($conn,$dongcon["MALOAISP"],$chuoijson,10);
						}
					}
				}

			}

		echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
		echo "}";
	}


	function LayDanhSachTienIch(){
			global $conn;

			//lấy danh sách phụ kiện cha
			$ketqua = LayDanhLoaiSanPhamTheoMaLoai($conn,82);
			$chuoijson = array();

			echo "{";
			echo "\"DANHSACHTIENICH\":";
			if($ketqua){
				while ($dong = mysqli_fetch_array($ketqua)) {
					
					$ketquacon = LayDanhLoaiSanPhamTheoMaLoai($conn,$dong["MALOAISP"]);

					if($ketquacon){
						while ($dongcon = mysqli_fetch_array($ketquacon)) {
								$chuoijson = LayDanhSachSanPhamTheoMaLoai($conn,$dongcon["MALOAISP"],$chuoijson,1);
							}
						}
					}

			}
		echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
		echo "}";
	}

	function LayDanhLoaiSanPhamTheoMaLoai($conn,$maloaisp){
			$truyvancha = "SELECT *  FROM loaisanpham lsp WHERE lsp.MALOAI_CHA = ".$maloaisp;
			$ketqua = mysqli_query($conn,$truyvancha);
			
			
			return $ketqua;
			
	}
	
	function LayDanhSachSanPhamDanhMucTheoMaLoai($conn,$maloaisp,$chuoijson,$limit){
			
		$truyvantienich = "SELECT *  FROM loaisanpham lsp, sanpham sp WHERE lsp.MALOAISP = ".$maloaisp." AND lsp.MALOAISP = sp.MALOAISP ORDER BY sp.LUOTMUA DESC LIMIT ".$limit.",20";
			
		$ketquacon = mysqli_query($conn,$truyvantienich);	
					
		if($ketquacon){
			while ($dongtienich = mysqli_fetch_array($ketquacon)) {
				array_push($chuoijson, array("MASP"=>$dongtienich["MASP"],'TENSP' => $dongtienich["TENSP"],'GIATIEN'=>$dongtienich["GIA"],'HINHSANPHAM'=>"http://".$_SERVER['SERVER_NAME']."/svnv/".$dongtienich["ANHLON"],'HINHSANPHAMNHO'=>"http://".$_SERVER['SERVER_NAME']."/svnv/".$dongtienich["ANHNHO"]));
					
				}
			}

		return $chuoijson;

	}	
	
	function LayDanhSachSanPhamTheoMaLoaiThuongHieu($conn,$maloaith,$chuoijson,$limit){
			
			$truyvantienich = "SELECT *  FROM thuonghieu th, sanpham sp WHERE th.MATHUONGHIEU = ".$maloaith." AND th.MATHUONGHIEU = sp.MATHUONGHIEU ORDER BY sp.LUOTMUA DESC LIMIT ".$limit.",20";
			
			$ketquacon = mysqli_query($conn,$truyvantienich);	
					
			if($ketquacon){
				while ($dongtienich = mysqli_fetch_array($ketquacon)) {
					array_push($chuoijson, array("MASP"=>$dongtienich["MASP"],'TENSP' => $dongtienich["TENSP"],'GIATIEN'=>$dongtienich["GIA"],'HINHSANPHAM'=>"http://".$_SERVER['SERVER_NAME']."/svnv/".$dongtienich["ANHLON"],'HINHSANPHAMNHO'=>"http://".$_SERVER['SERVER_NAME']."/svnv/".$dongtienich["ANHNHO"]));
					
				}
			}

		return $chuoijson;

	}

	function LayDanhSachSanPhamTheoMaLoai($conn,$maloaisp,$chuoijson,$limit){
			
			$truyvantienich = "SELECT *  FROM loaisanpham lsp, sanpham sp WHERE lsp.MALOAISP = ".$maloaisp." AND lsp.MALOAISP = sp.MALOAISP ORDER BY sp.LUOTMUA DESC LIMIT ".$limit;
			
			$ketquacon = mysqli_query($conn,$truyvantienich);	
					
			if($ketquacon){
				while ($dongtienich = mysqli_fetch_array($ketquacon)) {
					array_push($chuoijson, array("MASP"=>$dongtienich["MASP"],'TENSP' => $dongtienich["TENLOAISP"],'GIATIEN'=>$dongtienich["GIA"],'HINHSANPHAM'=>"http://".$_SERVER['SERVER_NAME']."/svnv/".$dongtienich["ANHLON"],'HINHSANPHAMNHO'=>"http://".$_SERVER['SERVER_NAME']."/svnv/".$dongtienich["ANHNHO"]));
					
				}
			}

		return $chuoijson;

	}	
	
	function LayDanhSachPhuKien(){
		global $conn;

			//lấy danh sách phụ kiện cha
		$truyvancha = "SELECT *  FROM loaisanpham lsp WHERE lsp.TENLOAISP LIKE 'phụ kiện%'";
		$ketqua = mysqli_query($conn,$truyvancha);
		$chuoijson = array();

		echo "{";
		echo "\"DANHSACHPHUKIEN\":";
		if($ketqua){
			while ($dong=mysqli_fetch_array($ketqua)) {
					
					//Lấy danh sách phụ kiện con
				$truyvanphukiencon = "SELECT *  FROM loaisanpham lsp, sanpham sp WHERE lsp.MALOAI_CHA = ".$dong["MALOAISP"]." AND lsp.MALOAISP = sp.MALOAISP ORDER BY sp.LUOTMUA DESC LIMIT 10";
			
				$ketquacon = mysqli_query($conn,$truyvanphukiencon);	
					
				if($ketquacon){
					while ($dongphukiencon = mysqli_fetch_array($ketquacon)) {
						array_push($chuoijson, array("MASP"=>$dongphukiencon["MALOAISP"],'TENSP' => $dongphukiencon["TENLOAISP"],'GIATIEN'=>$dongphukiencon["GIA"],'HINHSANPHAM'=>"http://".$_SERVER['SERVER_NAME']."/svnv/".$dongphukiencon["ANHLON"]));
					
					}
				}
					
			}
		
		}

		echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
		echo "}";
	}
	
	function LayDanhSachTopPhuKien(){
		global $conn;
		
		$truyvancha = "SELECT *  FROM loaisanpham lsp WHERE lsp.TENLOAISP LIKE 'Phụ kiện%'";
		$ketqua = mysqli_query($conn, $truyvancha);
		$chuoijson = array();
		
		echo "{";
		echo "\"TOPPHUKIEN\":";
		if($ketqua) {
			while ($dong=mysqli_fetch_array($ketqua)) {
					
					//Lấy danh sách phụ kiện con
				$truyvanphukiencon = "SELECT *  FROM loaisanpham lsp, sanpham sp WHERE lsp.MALOAI_CHA = ".$dong["MALOAISP"]." AND lsp.MALOAISP = sp.MALOAISP ORDER BY sp.LUOTMUA DESC LIMIT 10";
			
				$ketquacon = mysqli_query($conn,$truyvanphukiencon);	
					
				if($ketquacon){
					while ($dongphukiencon = mysqli_fetch_array($ketquacon)) {
						array_push($chuoijson, array("MASP"=>$dongphukiencon["MASP"],'TENSP' => $dongphukiencon["TENSP"],'GIATIEN'=>$dongphukiencon["GIA"],'HINHSANPHAM'=>"http://".$_SERVER['SERVER_NAME']."/svnv/".$dongphukiencon["ANHLON"]));
					
					}
				}
			}
		
		}
		
		echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
			echo "}";
		
	}
	
	function LayDanhSachTopChuotVaBanPhim() {
		global $conn;
		
		$truyvancha = "SELECT * FROM loaisanpham lsp, sanpham sp WHERE lsp.TENLOAISP LIKE 'chuột%' AND lsp.MALOAISP = sp.MALOAISP ORDER BY sp.LUOTMUA DESC LIMIT 10";
		$ketqua = mysqli_query($conn, $truyvancha);
		$chuoijson = array();
		
		echo "{";
		echo "\"TOPCHUOTVABANPHIM\":";
		if ($ketqua) {
			while ($dong = mysqli_fetch_array($ketqua)) {
			
			array_push($chuoijson, array("MASP" => $dong["MASP"], 'TENSP' => $dong["TENSP"], 'GIATIEN' => $dong["GIA"], 
			'HINHSANPHAM' =>"http://".$_SERVER['SERVER_NAME']."/svnv/".$dong["ANHLON"]));
			}
		//	echo json_encode();
		}
		
		$truyvancha = "SELECT * FROM loaisanpham lsp, sanpham sp WHERE lsp.TENLOAISP LIKE 'Bàn phím cơ%' AND lsp.MALOAISP = sp.MALOAISP ORDER BY sp.LUOTMUA DESC LIMIT 10";
		$ketquabp = mysqli_query($conn, $truyvancha);
		
		if($ketquabp) {
			while ($dongbp = mysqli_fetch_array($ketquabp)) {
				array_push($chuoijson, array("MASP" => $dongbp["MASP"], 'TENSP' => $dongbp["TENSP"], 'GIATIEN' => $dongbp["GIA"], 'HINHSANPHAM' => "http://".$_SERVER['SERVER_NAME']."/svnv/".$dong["ANHLON"]));
			}
		}
		echo json_encode($chuoijson, JSON_UNESCAPED_UNICODE);
		echo "}";
		
	}
	
	function LayDanhSachCacThuongHieuLon() {
		global $conn;
		
		$truyvancha = "SELECT * FROM thuonghieu th, chitietthuonghieu cth WHERE th.MATHUONGHIEU = cth.MATHUONGHIEU";
		$ketqua = mysqli_query($conn, $truyvancha);
		$chuoijson = array();
		
		echo "{";
		echo "\"DANHSACHTHUONGHIEU\":";
		if ($ketqua) {
			while ($dong = mysqli_fetch_array($ketqua)) {
				array_push($chuoijson, array("MASP"=>$dong["MATHUONGHIEU"], 'TENSP'=>$dong["TENTHUONGHIEU"], 'HINHSANPHAM'=>"http://".$_SERVER['SERVER_NAME']."/svnv/".$dong["HINHLOAISPTH"]));



				//array_push($chuoijson, array("MATHUONGHIEU"=>$dong["MATHUONGHIEU"],'TENTHUONGHIEU' => $dong["TENTHUONGHIEU"],
				//'HINHTHUONGHIEU' =>"http://".$_SERVER['SERVER_NAME']."/svnv/".$dong["HINHLOAISPTH"]));
			}
			
			echo json_encode($chuoijson, JSON_UNESCAPED_UNICODE);
		echo "}";
		
		}
		
	}
	
	function KiemTraDangNhap() {
		global $conn;
		if(isset($_POST["tendangnhap"]) || isset($_POST["matkhau"])) {
			$tendangnhap = $_POST["tendangnhap"];
			$matkhau = $_POST["matkhau"];	
		}
		
		$truyvan = "SELECT * FROM user WHERE TENDANGNHAP = '".$tendangnhap."' AND MATKHAU= '".$matkhau."'";
		$ketqua = mysqli_query($conn, $truyvan);
		$demdong = mysqli_num_rows($ketqua);
		if($demdong >=1) {
			$tennv = "";
			while ($dong = mysqli_fetch_array($ketqua)) {
				$tennv = $dong["TENNV"];
			}
			echo "{ketqua : true, tennv : \"".$tennv."\" }";
		}else {
			echo "{ketqua : false }";
		}
	}
	function DangKyThanhVien() {
		global $conn;
		if(isset($_POST["tennv"]) || isset($_POST["tendangnhap"]) 
			|| isset($_POST["matkhau"]) || isset($_POST["maloainv"]) || isset($_POST["emaildocquyen"])){
			$tennv = $_POST["tennv"];
			$tendangnhap = $_POST["tendangnhap"];
			$matkhau = $_POST["matkhau"];
			$maloainv = $_POST["maloainv"];
			$emaildocquyen = $_POST["emaildocquyen"];
		}
		
		$truyvan = "INSERT INTO user (TENNV, TENDANGNHAP, MATKHAU, MALOAINV, EMAILDOCQUYEN) 
		VAlUES('".$tennv."','".$tendangnhap."','".$matkhau."','".$maloainv."','".$emaildocquyen."')";
		if(mysqli_query($conn, $truyvan)) {
			echo "{ketqua : true }";
			
		}else {
			echo "{ketqua : false }".mysqli_error($conn);
		}
		mysqli_close($conn);
	}
	
	function LayDanhSachMenu() {
		global $conn;
		if(isset($_POST["maloaicha"]))
	
			$maloaicha = $_POST["maloaicha"];
		
		$truyvancha = "SELECT * FROM loaisanpham WHERE MALOAI_CHA = ".$maloaicha;
		$ketqua = mysqli_query($conn, $truyvancha);
		$chuoijson = array();
		echo "{";
		echo "\"LOAISANPHAM\":";
		if ($ketqua) {
			while ($dong = mysqli_fetch_array($ketqua)) {
				$chuoijson[] = $dong;
				//array_push($chuoijson, array("TENLOAISP" => $dong["TENLOAISP"], 'MALOAISP' => $dong["MALOAISP"]));
			}
			
			echo json_encode($chuoijson, JSON_UNESCAPED_UNICODE);
		}
		
		echo "}";
		mysqli_close($conn);
	}
?>