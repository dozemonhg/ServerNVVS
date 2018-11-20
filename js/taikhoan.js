$(document).ready(function(){
	function toast(type, msg){
		toastr[type](msg, '')
		toastr.options.timeOut = 3500;
	}

	$("body").delegate("#btn-themtaikhoan", 'click',function(){
		var loi = 0;
		var strloi = "";
		if($("#txtTennguoidung").val() == ""){
			loi++;
			strloi += "<li>Chưa nhập tên người dùng</li>";
		}
		if($("#txtTenDangNhap").val() == ""){
			loi++;
			strloi += "<li>Chưa nhập tên đăng nhập</li>";
		}
		if($("#txtPassword").val() == ""){
			loi++;
			strloi += "<li>Chưa có mật khẩu</li>";
		}
		if($("#slLoaiquyen").val() == 0){
			loi++;
			strloi += "<li>Chưa chọn loại người dùng</li>";
		}

		var pattern =/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/;
		if(!pattern.test($("#txtNgaysinh").val())){
			loi++;
			strloi += "<li>Năm sinh chưa đúng định dạng</li>";
		}else{
			var res = $("#txtNgaysinh").val().split("/");
			var d = new Date()
			if((d.getFullYear() - res[2]) < 18){
				loi++;
				strloi += "<li>Nhân viên phải >=18 tuổi</li>";
			}
		}

		var phoneno = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
		if(!phoneno.test($("#txtSodienthoai").val())){
			loi++;
			strloi += "<li>Số điện thoại chưa đúng định dạng</li>";
		}


		if(loi > 0){
			toast("error", strloi);
		}else{
			$.ajax({
					url: "../server/functions.php",
					cache:false,
					type: "POST",
					data: {
						action: "Themnguoidung",
						tennhanvien: $("#txtTennguoidung").val(),
						maloainhanvien: $("#slLoaiquyen").val(),
						tendangnhap: $("#txtTenDangNhap").val(),
						matkhau: $("#txtPassword").val(),
						diachi: tinyMCE.get('areaThongtin').getContent(),
						ngaysinh: $("#txtNgaysinh").val(),
						sodienthoai: $("#txtSodienthoai").val(),
						gioitinh: $("#slGioitinh").val()
					},
					success: function(data){
						
						 var obj = JSON.parse(data);
						 if(obj.type == "success"){
						 	

						 	$("table.table tbody").empty();
						 	var str = "";
						 	for (var i = 0; i< obj.data.length; i++) {
						 		str += "<tr class=\"user\">";
						        str += "<td>" + obj.data[i]["TENNV"] + "</td>";
						        str += "<td>" + ((obj.data[i]["MALOAINV"] == 1)?"Nhân viên":"Quản trị") + "</td>";
						        str += "<td class='capnhat'><a id="+ obj.data[i]["MANV"] +" rev='" + obj.data[i]["TENDANGNHAP"] + "'><img src=\"images/edit.svg\"/></a></td>";
						        str += "<td class='xoa'><a id=" + obj.data[i]["MANV"] + " rev='" + obj.data[i]["TENDANGNHAP"] + "'><img src=\"images/delete.svg\"/></a></td>";
						        str += "</tr>";
						 	}

						    $("table.table tbody").append(str);

						    $("#txtTennguoidung").val('');
						    $("#slLoaiquyen").val('');
						    $("#txtTenDangNhap").val('');
						    $("#txtPassword").val('');
						    $("#txtNgaysinh").val('');
						    $("#txtSodienthoai").val('');
						    tinymce.get('areaThongtin').setContent("");
						}
						 
						 toast(obj.type, obj.msg);
					}
				});
		}

	});

	// show popop cập nhật
	$("body").delegate("tr.user td.capnhat > a", "click", function(){
		$('#modal-wrapper').show();// hiển thị popup


		//set dữ liệu cũ
		$.ajax({
					url: "../server/functions.php",
					cache:false,
					type: "POST",
					data: {
						action: "SelectNguoidungDetail",
						manhanvien: $(this).attr('id'),
						
					},
					success: function(data){
						
						 var obj = JSON.parse(data);
						 $gioitinh = 0;
						 $maloainhanvien = 0;
						 if(obj.type == "success"){
						 	for (var i = 0; i< obj.data.length; i++) {
						 		$("#txtTennguoidung_modal").val(obj.data[i]["TENNV"]);
							    $("#txtTenDangNhap_modal").val(obj.data[i]["TENDANGNHAP"]);
							    $("#txtPassword_modal").val(obj.data[i]["MATKHAU"]);
							    $("#txtSodienthoai_modal").val(obj.data[i]["SODT"]);
							    $("#txtNgaysinh_modal").val(obj.data[i]["NGAYSINH"]);
							    tinymce.get('areaThongtin_modal').setContent(obj.data[i]["DIACHI"]);
							    $gioitinh = obj.data[i]["GIOITINH"];
							    $maloainhanvien = obj.data[i]["MALOAINV"];
							    $("#lblMaNhanvien_modal").val(obj.data[i]["MANV"]);

						    //$("#slLoaiquyen").val('');
						 	}

						 	var strgt = "";

						 	 for(var i = 0; i< 2;i++)
						 	 {
						 		if($gioitinh == i)
						 		{
						 			strgt += "<option selected='selected' value='"+ i +"'>"+ ((i==1)?"Nam":"Nữ") +"</option>"
						 		}else{
						 			strgt += "<option value='"+ i +"'>"+ ((i==1)?"Nam":"Nữ") +"</option>"
						 		}
						 	 }
						 	 $("#slGioitinh_modal").empty();
					 		 $("#slGioitinh_modal").append(strgt);


					 		 var strloainv = "";

						 	 for(var i = 1; i< 3;i++)
						 	 {
						 		if($maloainhanvien == i)
						 		{
						 			strloainv += "<option selected='selected' value='"+ i +"'>"+ ((i==1)?"Nhân viên":"Quản trị") +"</option>"
						 		}else{
						 			strloainv += "<option value='"+ i +"'>"+ ((i==1)?"Nhân viên":"Quản trị") +"</option>"
						 		}
						 	 }
						 	 $("#slLoaiquyen_modal").empty();
					 		 $("#slLoaiquyen_modal").append(strloainv);
						    
						}
						 
						 
					}
				});
	});


	// cập nhật
	$("body").delegate("#btnCapnhatTaiKhoan", "click", function(){
		//document.getElementById('modal-wrapper').style.display='none';
		
		var strloi = "";
		var loi = 0;
		if($("#txtTennguoidung_modal").val() == ""){
			loi++;
			strloi += "<li>Chưa nhập tên người dùng</li>";
		}
		if($("#txtTenDangNhap_modal").val() == ""){
			loi++;
			strloi += "<li>Chưa nhập tên đăng nhập</li>";
		}
		if($("#txtPassword_modal").val() == ""){
			loi++;
			strloi += "<li>Chưa có mật khẩu</li>";
		}
		if($("#slLoaiquyen_modal").val() == 0){
			loi++;
			strloi += "<li>Chưa chọn loại người dùng</li>";
		}

		var pattern =/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/;
		if(!pattern.test($("#txtNgaysinh_modal").val())){
			loi++;
			strloi += "<li>Năm sinh chưa đúng định dạng</li>";
		}else{
			var res = $("#txtNgaysinh_modal").val().split("/");
			var d = new Date()
			if((d.getFullYear() - res[2]) < 18){
				loi++;
				strloi += "<li>Nhân viên phải >=18 tuổi</li>";
			}
		}

		var phoneno = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
		if(!phoneno.test($("#txtSodienthoai_modal").val())){
			loi++;
			strloi += "<li>Số điện thoại chưa đúng định dạng</li>";
		}


		if(loi > 0){
			toast("error", strloi);
		}else{
			$.ajax({
					url: "../server/functions.php",
					cache:false,
					type: "POST",
					data: {
						action: "Capnhatguoidung",
						tennhanvien: $("#txtTennguoidung_modal").val(),
						maloainhanvien: $("#slLoaiquyen_modal").val(),
						tendangnhap: $("#txtTenDangNhap_modal").val(),
						matkhau: $("#txtPassword_modal").val(),
						diachi: tinyMCE.get('areaThongtin_modal').getContent(),
						ngaysinh: $("#txtNgaysinh_modal").val(),
						sodienthoai: $("#txtSodienthoai_modal").val(),
						gioitinh: $("#slGioitinh_modal").val(),
						manhanvien: $("#lblMaNhanvien_modal").val()
					},
					success: function(data){
						
						 var obj = JSON.parse(data);
						 if(obj.type == "success"){
						 	

						 	$("table.table tbody").empty();
						 	var str = "";
						 	for (var i = 0; i< obj.data.length; i++) {
						 		str += "<tr class=\"user\">";
						        str += "<td>" + obj.data[i]["TENNV"] + "</td>";
						        str += "<td>" + ((obj.data[i]["MALOAINV"] == 1)?"Nhân viên":"Quản trị") + "</td>";
						        str += "<td class='capnhat'><a id="+ obj.data[i]["MANV"] +" rev='" + obj.data[i]["TENDANGNHAP"] + "'><img src=\"images/edit.svg\"/></a></td>";
						        str += "<td class='xoa'><a id=" + obj.data[i]["MANV"] + " rev='" + obj.data[i]["TENDANGNHAP"] + "'><img src=\"images/delete.svg\"/></a></td>";
						        str += "</tr>";
						 	}

						    $("table.table tbody").append(str);
						}
						 
						 toast(obj.type, obj.msg);
						 document.getElementById('modal-wrapper').style.display='none';
					}
				});
		}
	});

	$("body").delegate("tr.user td.xoa > a", "click", function(){
		if(confirm("Bạn có chắc chắn muốn xóa!")){
			$.ajax({
					url: "../server/functions.php",
					cache:false,
					type: "POST",
					data: {
						action: "XoaTaikhoan",
						manhanvien: $(this).attr('id')

					},
					success: function(data){
						
						 var obj = JSON.parse(data);
						 if(obj.type == "success"){
						 	

						 	$("table.table tbody").empty();
						 	var str = "";
						 	for (var i = 0; i< obj.data.length; i++) {
						 		str += "<tr class=\"user\">";
						        str += "<td>" + obj.data[i]["TENNV"] + "</td>";
						        str += "<td>" + ((obj.data[i]["MALOAINV"] == 1)?"Nhân viên":"Quản trị") + "</td>";
						        str += "<td class='capnhat'><a id="+ obj.data[i]["MANV"] +" rev='" + obj.data[i]["TENDANGNHAP"] + "'><img src=\"images/edit.svg\"/></a></td>";
						        str += "<td class='xoa'><a id=" + obj.data[i]["MANV"] + " rev='" + obj.data[i]["TENDANGNHAP"] + "'><img src=\"images/delete.svg\"/></a></td>";
						        str += "</tr>";
						 	}

						    $("table.table tbody").append(str);
						}
						 
						 toast(obj.type, obj.msg);
						 
					}
				});
			return true;
		}else{
			return false;
		}
		

	});
});