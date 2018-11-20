$(document).ready(function(){

	function toast(type, msg){
		toastr[type](msg, '')
		toastr.options.timeOut = 2500;
	}

	$("body").delegate("#ip_anhthuonghieu","click", function(){
		allowedFileExtensions: ['jpg', 'png', 'gif']
	});


	// thêm thuong hieu
	$("body").delegate("#btn-themthuonghieu", "click", function(){
		var loi = 0;
		$ten = $("#nameTenthuonghieu").val();
		$hinh = $("#khunganhlon").find('.file-footer-caption').attr("title");
		if($hinh == undefined){
			toast("error", "Chưa chọn ảnh");
		}else{
			if($('#khunganhlon').find('div.progress-bar').attr('aria-valuenow') == 0)
			{
				toast("error", "Chưa upload ảnh");
				loi++;
			}if($('#nameTenthuonghieu').val() == ""){
				toast("error", "Chưa nhập tên thương hiệu.");
				loi++;
			}

			if(loi == 0){
				
				$.ajax({
					url: "../server/functions.php",
					cache:false,
					type: "POST",
					data: {
						action: "Themthuonghieu",
						tenthuonghieu: $ten,
						hinhthuonghieu: $hinh
					},
					success: function(data){
						
						 var obj = JSON.parse(data);
						 if(obj.type == "success"){
						 	$('.fileinput-remove').trigger('click');
						 	$('#nameTenthuonghieu').val('')

						 	$("table.table tbody").empty();
						 	var str = "";
						 	for (var i = 0; i< obj.data.length; i++) {
						 		str += "<tr class=\"thuonghieu\">";
						        str += "<td>" + obj.data[i]["TENTHUONGHIEU"] + "</td>";
						        str += "<td><img class='img-hinh' src='img/hinhthuonghieu/" + ((obj.data[i]["HINHTHUONGHIEU"] == undefined)?"":obj.data[i]["HINHTHUONGHIEU"]) + "'/> </td>";
						        str += "<td class='capnhat'><a data-anhlon="+ obj.data[i]["HINHTHUONGHIEU"] +" id="+ obj.data[i]["MATHUONGHIEU"] +" rev='" + obj.data[i]["TENTHUONGHIEU"] + "'><img src=\"images/edit.svg\"/></a></td>";
						        str += "<td class='xoa'><a id=" + obj.data[i]["MATHUONGHIEU"] + " rev='" + obj.data[i]["TENTHUONGHIEU"] + "'><img src=\"images/delete.svg\"/></a></td>";
						        str += "</tr>";
						 	}

						    $("table.table tbody").append(str);
						}
						 
						 toast(obj.type, obj.msg);
					}
				});
			}
		}
	});

	//Xóa thương hiệu
	$("body").delegate("tr.thuonghieu td.xoa > a", "click", function(){
		if(confirm("Bạn có chắc chắn muốn xóa!")){
				
				$.ajax({
					url: "../server/functions.php",
					cache:false,
					type: "POST",
					data: {
						action: "XoaThuongHieu",
						mathuonghieu: $(this).attr('id'),
						tenthuonghieu: $(this).attr('rev')
					},
					success: function(data){
						//alert(data);
						 var obj = JSON.parse(data);
						 if(obj.type == "success"){
						 	$("table.table tbody").empty();
						 	var str = "";
						 	for (var i = 0; i< obj.data.length; i++) {
						 		str += "<tr class=\"thuonghieu\">";
						        str += "<td>" + obj.data[i]["TENTHUONGHIEU"] + "</td>";
						        str += "<td><img class='img-hinh' src='img/hinhthuonghieu/" + ((obj.data[i]["HINHTHUONGHIEU"] == undefined)?"":obj.data[i]["HINHTHUONGHIEU"]) + "'/> </td>";
						        str += "<td class='capnhat'><a data-anhlon="+ obj.data[i]["HINHTHUONGHIEU"] +" id="+ obj.data[i]["MATHUONGHIEU"] +" rev='" + obj.data[i]["TENTHUONGHIEU"] + "'><img src=\"images/edit.svg\"/></a></td>";
						        str += "<td class='xoa'><a id=" + obj.data[i]["MATHUONGHIEU"] + " rev='" + obj.data[i]["HINHTHUONGHIEU"] + "'><img src=\"images/delete.svg\"/></a></td>";
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

	

	// Show giao diện Cập nhật thương hiệu
	$("body").delegate("tr.thuonghieu td.capnhat > a", "click", function(){
		$('#khunganhlon').css('display', 'none');
		$('#modal-wrapper').show();// hiển thị popup

		
		htmlAnh = '<div class="file-loading"><input data-preview-file-type="any" id="ip_anhthuonghieu_modal" name="ip_anhthuonghieu_modal" type="file" class="file-loading" data-overwrite-initial="true" data-upload-url="uploadhinh.php"></div>';
	     $("#khunganhlon_modal").empty();
	     $("#khunganhlon_modal").append(htmlAnh);

	     tenthuonghieu = $(this).attr('rev');
	     mathuonghieu = $(this).attr('id');
	     hinh = $(this).attr('data-anhlon');
	     $('#txtTenThuongHieu').attr("data-mathuonghieu", mathuonghieu);

		 $("#ip_anhthuonghieu_modal").fileinput({
		 		uploadAsync: false,
		        overwriteInitial: true,
		        initialPreview: [
		            "img/hinhthuonghieu/" + hinh
		            
		        ],
		        initialPreviewAsData: true, // identify if you are sending preview data only and not the raw markup
		        initialPreviewFileType: 'image', // image is the default and can be overridden in config below
		        initialPreviewConfig: [
		            {caption: hinh}
		            
		        ],
		        
		    });

		 $('#txtTenThuongHieu').val(tenthuonghieu);

	});

	// Cập nhật thương hiệu
	$('body').delegate('#btnCapnhatThuongHieu', 'click', function(){
		var tenthuonghieu = $('#txtTenThuongHieu').val();
		var tenhinh = $('#khunganhlon_modal').find('.file-caption-info').html();
		var mathuonghieu = $('#txtTenThuongHieu').attr("data-mathuonghieu");
		if(tenthuonghieu == ""){
			toast("error", "Chưa nhập tên thương hiệu");
		}else{
			$.ajax({
					url: "../server/functions.php",
					cache:false,
					type: "POST",
					data: {
						action: "CapnhatThuongHieu",
						tenthuonghieu: tenthuonghieu,
						tenhinh: tenhinh,
						mathuonghieu: mathuonghieu
					},
					success: function(data){
						//alert(data);
						 var obj = JSON.parse(data);
						 if(obj.type == "success"){
						 	$("table.table tbody").empty();
						 	var str = "";
						 	for (var i = 0; i< obj.data.length; i++) {
						 		str += "<tr class=\"thuonghieu\">";
						        str += "<td>" + obj.data[i]["TENTHUONGHIEU"] + "</td>";
						        str += "<td><img class='img-hinh' src='img/hinhthuonghieu/" + ((obj.data[i]["HINHTHUONGHIEU"] == undefined)?"":obj.data[i]["HINHTHUONGHIEU"]) + "'/> </td>";
						        str += "<td class='capnhat'><a data-anhlon="+ obj.data[i]["HINHTHUONGHIEU"] +" id="+ obj.data[i]["MATHUONGHIEU"] +" rev='" + obj.data[i]["TENTHUONGHIEU"] + "'><img src=\"images/edit.svg\"/></a></td>";
						        str += "<td class='xoa'><a id=" + obj.data[i]["MATHUONGHIEU"] + " rev='" + obj.data[i]["HINHTHUONGHIEU"] + "'><img src=\"images/delete.svg\"/></a></td>";
						        str += "</tr>";
						 	}

						    $("table.table tbody").append(str);
						    
						 }
						 
						 toast(obj.type, obj.msg);
						 document.getElementById('modal-wrapper').style.display='none';
						 $('#khunganhlon').css('display', 'block');
						 $('.fileinput-remove').trigger('click');
						 $('#txtTenThuongHieu').val();
					}
				});
		}
	});
	
});
