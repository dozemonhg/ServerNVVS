<?php
	$file_id = "";
	if(isset($_FILES['ip_anhthuonghieu'])){
		$file_id = $_FILES["ip_anhthuonghieu"];
		$file_dir = "./img/hinhthuonghieu/";

	}elseif(isset($_FILES['ip_anhthuonghieu_modal'])){
		$file_id = $_FILES["ip_anhthuonghieu_modal"];
		$file_dir = "./img/hinhthuonghieu/";
	}elseif(isset($_FILES['ip_anhSanphamLon'])){
		$file_id = $_FILES["ip_anhSanphamLon"];
		$file_dir = "./img/sanpham/";
	}elseif(isset($_FILES['ip_anhSanphamNho'])){
		$file_id = $_FILES["ip_anhSanphamNho"];
		$file_dir = "./img/sanpham/";
	}elseif(isset($_FILES['ip_anhsanphamLon_modal'])){
		$file_id = $_FILES["ip_anhsanphamLon_modal"];
		$file_dir = "./img/sanpham/";
	}elseif(isset($_FILES['ip_anhsanphamNho_modal'])){
		$file_id = $_FILES["ip_anhsanphamNho_modal"];
		$file_dir = "./img/sanpham/";
	}


	if($file_id != "")
	{
		
		$filename = $file_id["name"];
		$file_tmp = $file_id["tmp_name"];
		if(move_uploaded_file($file_tmp, $file_dir.$filename))
		{
			$output = array("Upload thành công");
		}else{
			$output = array("Upload thất bại");
		}

		echo json_encode($output);
	}
?>