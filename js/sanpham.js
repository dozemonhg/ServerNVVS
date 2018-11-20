$(document).ready(function(){
	function toast(type, msg){
		toastr[type](msg, '')
		toastr.options.timeOut = 2500;
	}

	$("body").delegate("#ip_anhSanphamNho","click", function(){
		allowedFileExtensions: ['jpg', 'png', 'gif']
	});
	$("body").delegate("#ip_anhSanphamLon","click", function(){
		allowedFileExtensions: ['jpg', 'png', 'gif']
	});


	//Thêm sản Phẩm

	$("body").delegate("#btn-themsanpham", "click", function(){
		var loi = 0;
		var strLoi = "";
		var thongtin = tinyMCE.get('areaThongtin').getContent();
		var hinh = $("#khunganhlon").find('.file-footer-caption').attr("title");
		var tensanpham = $("#nameTensanpham").val();
		var giasanpham = $("#nameGiasanpham").val();
		var maloaisanpham = $("#slLoaisanpham").val();
		var mathuonghieu = $("#slThuonghieu").val();

		var arrAnhNho = [];
		var uniqueNames = [];
		$("#khunganhnho").find('.file-footer-caption').each(function(){
			arrAnhNho.push($(this).attr('title'))
		});

		$.each(arrAnhNho, function(i, el){
		    if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
		});


		
		if(hinh == undefined){
			strLoi +="<li>Chưa chọn ảnh lớn</li>";
			loi++;
		}else if($('#khunganhlon').find('div.progress-bar').attr('aria-valuenow') == 0)
		{
			strLoi +="<li>Chưa upload ảnh</li>";
			loi++;
		}

		if(uniqueNames.toString() == ""){
			
			strLoi +="<li>Chưa chọn ảnh nhỏ</li>";
			loi++;
		}else if($('#khunganhnho').find('div.progress-bar').attr('aria-valuenow') == 0)
		{
			strLoi +="<li>Chưa upload ảnh nhỏ</li>";
			loi++;
		}

		if(tensanpham == "")
		{
			strLoi +="<li>Chưa có tên sản phẩm</li>";
			loi++;
		}
			
		if(giasanpham == ""){
			strLoi +="<li>Chưa nhập giá sản phẩm</li>";
			loi++;
		}else if(!isNumber(giasanpham))
		{
			strLoi +="<li>Giá phải là số</li>";
			loi++;
		}

		if(maloaisanpham == 0)
		{
			strLoi +="<li>Vui lòng chọn Loại Sản Phẩm</li>";
			loi++;
		}

		if(mathuonghieu == 0)
		{
			strLoi +="<li>Vui lòng chọn Thương Hiệu</li>";
			loi++;
		}

		if(loi> 0){
			toast("error", strLoi);
		}else{
			
			$.ajax({
					url: "../server/functions.php",
					cache:false,
					type: "POST",
					data: {
						action: "ThemSanPham",
						tensanpham: tensanpham,
						giasanpham: giasanpham,
						anhLon: hinh,
						anhNho: uniqueNames.toString(),
						maloaisanpham: maloaisanpham,
						mathuonghieu: mathuonghieu,
						thongtin: thongtin

					},
					success: function(data){
						
						 var obj = JSON.parse(data);
						 if(obj.type == "success"){
						 	$('.fileinput-remove').trigger('click');
							$("#nameTensanpham").val('');
				    		$("#nameGiasanpham").val('');
				    		tinymce.get('areaThongtin').setContent("");

						 	$("table.table tbody").empty();
						 	var str = "";
						 	for (var i = 0; i< obj.data.length; i++) {
						 		str += "<tr class=\"sanpham\">";
						        str += "<td>" + obj.data[i]["TENSP"] + "</td>";
						        str += "<td>"+ obj.data[i]["GIA"] +"</td>";
						        str += "<td>" + obj.data[i]["SOLUONG"] + "</td>";
						        str += "<td><img class='img-hinh' src='img/sanpham/" + ((obj.data[i]["ANHLON"] == undefined)?"":obj.data[i]["ANHLON"]) + "'/> </td>";
						        str += "<td class='capnhat'><a data-anhlon="+ obj.data[i]["ANHLON"] +" id="+ obj.data[i]["MASP"] +" rev='" + obj.data[i]["TENSP"] + "'><img src=\"images/edit.svg\"/></a></td>";
						        str += "<td class='xoa'><a id=" + obj.data[i]["MASP"] + " rev='" + obj.data[i]["TENSP"] + "'><img src=\"images/delete.svg\"/></a></td>";
						        str += "</tr>";
						 	}

						    $("table.table tbody").append(str);
						}
						 
						 toast(obj.type, obj.msg);
					}
				});
		}
	});

	// Show giao diện Cập nhật sản phẩm
	$("body").delegate("tr.sanpham td.capnhat > a", "click", function(){
		$('#khunganhlon').css('display', 'none');
		$('#khunganhnho').css('display', 'none');
		$('#modal-wrapper').show();// hiển thị popup



		//set giá trị cũ
		$("#lblMaSanPham_modal").val($(this).attr('id'));
		$.ajax({
				url: "../server/functions.php",
				cache:false,
				type: "POST",
				data: {
					action: "SelectSanphamDetail",
					masanpham: $(this).attr('id')
				},
				success: function(data){
					
					 var obj = JSON.parse(data);
					 if(obj.type == "success")
					 {
					 	$mathuonghieu = 0;
					 	$maloaisanpham = 0;

					 	for (var i = 0; i< obj.data.length; i++) 
					 	{
					 		$maloaisanpham = obj.data[i]["MALOAISP"];
					 		$mathuonghieu = obj.data[i]["MATHUONGHIEU"];
					 		$("#txtTenSanPham").val(obj.data[i]["TENSP"]);
					 		$("#txtGiasp").val(obj.data[i]["GIA"]);
					 		tinymce.get('areaThongtin_modal').setContent(obj.data[i]["THONGTIN"]);

					 		htmlAnhLon = '<div class="file-loading"><input data-preview-file-type="any" id="ip_anhsanphamLon_modal" name="ip_anhsanphamLon_modal" type="file" class="file-loading" data-overwrite-initial="true" data-upload-url="uploadhinh.php"></div>';
					 		hinhLon = obj.data[i]["ANHLON"];
					 		$("#khunganhlon_modal").empty();
	     					$("#khunganhlon_modal").append(htmlAnhLon);

	     					$("#ip_anhsanphamLon_modal").fileinput({
						 		uploadAsync: false,
						        overwriteInitial: true,
						        initialPreview: [
						            "img/sanpham/" + hinhLon
						            
						        ],
						        initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
						        initialPreviewFileType: 'image', // image is the default and can be overridden in config below
						        initialPreviewConfig: [
						            {caption: hinhLon}
						            
						        ],
						        
						    });



						    htmlAnhNho = '<div class="file-loading"><input multiple id="ip_anhsanphamNho_modal" name="ip_anhsanphamNho_modal" type="file" class="file-loading" data-overwrite-initial="true" data-upload-url="uploadhinh.php"></div>';
					 		hinhNho = obj.data[i]["ANHNHO"].split(",");
					 		arrHinhNho = [];
					 		arrTenanhNho = [];
					 		str = '';
					 		for (var i = 0; i< hinhNho.length; i++) {
					 			arrHinhNho.push("img/sanpham/" + hinhNho[i]);
					 			arrTenanhNho.push({caption: hinhNho[i]});
					 		}
					 		$("#khunganhnho_modal").empty();
	     					$("#khunganhnho_modal").append(htmlAnhNho);

	     					$("#ip_anhsanphamNho_modal").fileinput({
						 		uploadAsync: false,
						        overwriteInitial: true,
						        initialPreview: arrHinhNho,
						        initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
						        initialPreviewFileType: 'image', // image is the default and can be overridden in config below
						        initialPreviewConfig: arrTenanhNho,
						        
						    });
					 	}

					 	strlsp = "";
					 	for(var i = 0; i< obj.dsloaisanpham.length;i++)
					 	{
					 		//alert(obj.dsloaisanpham[i]["TENLOAISP"]);
					 		if($maloaisanpham == obj.dsloaisanpham[i]["MALOAISP"])
					 		{
					 			strlsp += "<option selected='selected' value='"+ obj.dsloaisanpham[i]["MALOAISP"] +"'>"+ obj.dsloaisanpham[i]["TENLOAISP"] +"</option>"
					 		}else{
					 			strlsp += "<option value='"+ obj.dsloaisanpham[i]["MALOAISP"] +"'>"+ obj.dsloaisanpham[i]["TENLOAISP"] +"</option>"
					 		}
					 	}
					 	$("#slLoaisanpham_modal").empty();
					 	$("#slLoaisanpham_modal").append(strlsp);


					 	strth = "";
					 	for(var i = 0; i< obj.dsthuonghieu.length;i++)
					 	{
					 		//alert(obj.dsloaisanpham[i]["TENLOAISP"]);
					 		if($mathuonghieu == obj.dsthuonghieu[i]["MATHUONGHIEU"])
					 		{
					 			strth += "<option selected='selected' value='"+ obj.dsthuonghieu[i]["MATHUONGHIEU"] +"'>"+ obj.dsthuonghieu[i]["TENTHUONGHIEU"] +"</option>"
					 		}else{
					 			strth += "<option value='"+ obj.dsthuonghieu[i]["MATHUONGHIEU"] +"'>"+ obj.dsthuonghieu[i]["TENTHUONGHIEU"] +"</option>"
					 		}
					 	}
					 	$("#slThuonghieu_modal").empty();
					 	$("#slThuonghieu_modal").append(strth);



					 }
					 
				}
			});

	});

	$("body").delegate("#btnCapnhatSanpham", "click", function(){
		var loi = 0;
		var strLoi = "";
		var thongtin = tinyMCE.get('areaThongtin_modal').getContent();
		var hinh = $("#khunganhlon_modal").find('.file-caption-info').html();
		var tensanpham = $("#txtTenSanPham").val();
		var giasanpham = $("#txtGiasp").val();
		var maloaisanpham = $("#slLoaisanpham_modal").val();
		var mathuonghieu = $("#slThuonghieu_modal").val();

		var arrAnhNho = [];
		var uniqueNames = [];
		$("#khunganhnho_modal").find('.file-footer-caption').each(function(){
			arrAnhNho.push($(this).attr('title'))
		});

		$.each(arrAnhNho, function(i, el){
		    if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
		});


		
		if(hinh == undefined){
			strLoi +="<li>Chưa chọn ảnh lớn</li>";
			loi++;
		}

		if(uniqueNames.toString() == ""){
			
			strLoi +="<li>Chưa chọn ảnh nhỏ</li>";
			loi++;
		}

		if(tensanpham == "")
		{
			strLoi +="<li>Chưa có tên sản phẩm</li>";
			loi++;
		}
			
		if(giasanpham == ""){
			strLoi +="<li>Chưa nhập giá sản phẩm</li>";
			loi++;
		}else if(!isNumber(giasanpham))
		{
			strLoi +="<li>Giá phải là số</li>";
			loi++;
		}

		if(maloaisanpham == 0)
		{
			strLoi +="<li>Vui lòng chọn Loại Sản Phẩm</li>";
			loi++;
		}

		if(mathuonghieu == 0)
		{
			strLoi +="<li>Vui lòng chọn Thương Hiệu</li>";
			loi++;
		}

		if(loi> 0){
			toast("error", strLoi);
		}else{
			
			
			$.ajax({
					url: "../server/functions.php",
					cache:false,
					type: "POST",
					data: {
						action: "CapNhatSanPham",
						tensanpham: tensanpham,
						giasanpham: giasanpham,
						anhLon: hinh,
						anhNho: uniqueNames.toString(),
						maloaisanpham: maloaisanpham,
						mathuonghieu: mathuonghieu,
						thongtin: thongtin,
						masanpham: $("#lblMaSanPham_modal").val()

					},
					success: function(data){
						
						 var obj = JSON.parse(data);
						 if(obj.type == "success"){
						 	

						 	$("table.table tbody").empty();
						 	var str = "";
						 	for (var i = 0; i< obj.data.length; i++) {
						 		str += "<tr class=\"sanpham\">";
						        str += "<td>" + obj.data[i]["TENSP"] + "</td>";
						        str += "<td>"+ obj.data[i]["GIA"] +"</td>";
						        str += "<td>" + obj.data[i]["SOLUONG"] + "</td>";
						        str += "<td><img class='img-hinh' src='img/sanpham/" + ((obj.data[i]["ANHLON"] == undefined)?"":obj.data[i]["ANHLON"]) + "'/> </td>";
						        str += "<td class='capnhat'><a data-anhlon="+ obj.data[i]["ANHLON"] +" id="+ obj.data[i]["MASP"] +" rev='" + obj.data[i]["TENSP"] + "'><img src=\"images/edit.svg\"/></a></td>";
						        str += "<td class='xoa'><a id=" + obj.data[i]["MASP"] + " rev='" + obj.data[i]["TENSP"] + "'><img src=\"images/delete.svg\"/></a></td>";
						        str += "</tr>";
						 	}

						    $("table.table tbody").append(str);
						}
						 
						 toast(obj.type, obj.msg);
						 document.getElementById('modal-wrapper').style.display='none';
						 $('#khunganhlon').css('display', 'block');
						 $('#khunganhnho').css('display', 'block');
						 $('.fileinput-remove').trigger('click');
					}
				});
		}
	});

	//Xóa sản phẩm
	$("body").delegate("tr.sanpham td.xoa > a", "click", function(){
		$.ajax({
					url: "../server/functions.php",
					cache:false,
					type: "POST",
					data: {
						action: "XoaSanPham",
						masanpham: $(this).attr('id')

					},
					success: function(data){
						
						 var obj = JSON.parse(data);
						 if(obj.type == "success"){
						 	

						 	$("table.table tbody").empty();
						 	var str = "";
						 	for (var i = 0; i< obj.data.length; i++) {
						 		str += "<tr class=\"sanpham\">";
						        str += "<td>" + obj.data[i]["TENSP"] + "</td>";
						        str += "<td>"+ obj.data[i]["GIA"] +"</td>";
						        str += "<td>" + obj.data[i]["SOLUONG"] + "</td>";
						        str += "<td><img class='img-hinh' src='img/sanpham/" + ((obj.data[i]["ANHLON"] == undefined)?"":obj.data[i]["ANHLON"]) + "'/> </td>";
						        str += "<td class='capnhat'><a data-anhlon="+ obj.data[i]["ANHLON"] +" id="+ obj.data[i]["MASP"] +" rev='" + obj.data[i]["TENSP"] + "'><img src=\"images/edit.svg\"/></a></td>";
						        str += "<td class='xoa'><a id=" + obj.data[i]["MASP"] + " rev='" + obj.data[i]["TENSP"] + "'><img src=\"images/delete.svg\"/></a></td>";
						        str += "</tr>";
						 	}

						    $("table.table tbody").append(str);
						}
						 
						 toast(obj.type, obj.msg);
						 
					}
				});

	});


	function isNumber(str) {
	  if (typeof str != "string") return false // we only process strings!
	  // could also coerce to string: str = ""+str
	  return !isNaN(str) && !isNaN(parseFloat(str))
	}
});