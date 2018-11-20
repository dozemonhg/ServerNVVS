<?php
 include_once("dbconnect.php");

 include_once("ResponseData.php");


//url: http://dia_chi_ip_may_tinh/server/api/api_dangnhap.php
 if(isset($_POST['chucnang']) && $_POST['chucnang'] == "danhsachuser"){
 	
 	try {
 		global $conn;
 	
 		$resultArr = array();
 		$data = array();

 		$sql = "select * from user";
 		$res = mysqli_query($conn,$sql);

 		while ($row = mysqli_fetch_assoc($res)) {
 			array_push($data, $row);
 		}


 		echo ResponseData::ResponseSuccess('đây là thông báo', $data);
 	}catch(Exception $e) {
 		// xuat chuoi json 
  		echo ResponseData::ResponseFail($e);
	}
 }


//http://dia_chi_ip_may_tinh/server/api/api_dangnhap.php

if(isset($_GET['chucnang']) && $_GET['chucnang'] == "login"){
 	$username = trim($_GET['username']);
 	$password = trim($_GET['password']);
 	if($username != "" && $password != "")
 	{
 		$resultArr = array();
 		$data = array();
 		$sql = "select * from user where TENDANGNHAP = '".$username."' and MATKHAU = '".$password."'";
 		$res = mysqli_query($conn,$sql);

 		while ($row = mysqli_fetch_assoc($res)) {
 			array_push($data, $row);
 		}


 		echo ResponseData::ResponseSuccess('đây là thông báo', $data);
 	}else{
 		echo ResponseData::ResponseFail("Thiếu dữ liệu. Vui lòng kiểm tra");
 	}
 }


?>