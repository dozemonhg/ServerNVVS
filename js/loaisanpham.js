$(document).ready(function(){

	// Thêm loại sản phẩm
	$("body").delegate("#btn-themlsp", "click", function(){
		var tenlsp = $("#id_lsp_new").val();
		var ma_lsp_cha = $("#id_lsp_cha").val();
		$.ajax({
			url: "../server/functions.php",
			type: "POST",
			data: {
				action: "ThemLoaiSanPham",
				tenloaisanpham: tenlsp,
				maloaicha: ma_lsp_cha
			},
			success: function(data){
				
				$("#id_lsp_new").val("");
				var obj = JSON.parse(data);
				if(obj.type == "success"){
				 	$("table.table tbody").empty();
				 	var str = "";
				 	for (var i = 0; i< obj.data.length; i++) {
				 		str += "<tr class=\"test\">";
				        str += "<td>" + obj.data[i]["TENLOAISP"] + "</td>";
				        str += "<td>" + ((obj.data[i]["TENLOAISANPHAMCHA"] == undefined)?"":obj.data[i]["TENLOAISANPHAMCHA"]) + "</td>";
				        str += "<td class='capnhat'><a id="+ obj.data[i]["MALOAISP"] +" rev=" + obj.data[i]["TENLOAISP"] + "><img src=\"images/edit.svg\"/></a></td>";
				        str += "<td class='xoa'><a id=" + obj.data[i]["MALOAISP"] + "><img src=\"images/delete.svg\"/></a></td>";
				        str += "</tr>";
				 	}

				    $("table.table tbody").append(str);
				    
				 }
				
				toast(obj.type, obj.msg);
			}
		});
	});

	// xóa loại sản phẩm
	$("body").delegate("tr.test td.xoa > a", "click", function(){
		if(confirm("Bạn có chắc chắn muốn xóa!")){
				//alert($(this).attr('id'));
				$.ajax({
					url: "../server/functions.php",
					cache:false,
					type: "POST",
					data: {
						action: "XoaLoaisanpham",
						maloaisanpham: $(this).attr('id')
					},
					success: function(data){
						
						 var obj = JSON.parse(data);
						 if(obj.type == "success"){
						 	$("table.table tbody").empty();
						 	var str = "";
						 	for (var i = 0; i< obj.data.length; i++) {
						 		str += "<tr class=\"test\">";
						        str += "<td>" + obj.data[i]["TENLOAISP"] + "</td>";
						        str += "<td>" + ((obj.data[i]["TENLOAISANPHAMCHA"] == undefined)?"":obj.data[i]["TENLOAISANPHAMCHA"]) + "</td>";
						        str += "<td class='capnhat'><a id="+ obj.data[i]["MALOAISP"] +" rev=" + obj.data[i]["TENLOAISP"] + "><img src=\"images/edit.svg\"/></a></td>";
						        str += "<td class='xoa'><a id=" + obj.data[i]["MALOAISP"] + "><img src=\"images/delete.svg\"/></a></td>";
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




	// Cập nhật loại sản phẩm
	$("body").delegate("#Update_lsp", "click", function(){
		$.ajax({
				url: "../server/functions.php",
				type: "POST",
				data: {
					action: "CapnhatLoaiSanPham",
					maloaisanpham: $('#lbl_idlsp').val(),
					tenloaisanpham: $('#lsp_old').val()
				},
				success: function(data){
					
					 var obj = JSON.parse(data);
					 if(obj.type == "success"){
					 	$("table.table tbody").empty();
					 	var str = "";
					 	for (var i = 0; i< obj.data.length; i++) {
					 		str += "<tr class=\"test\">";
					        str += "<td>" + obj.data[i]["TENLOAISP"] + "</td>";
					        str += "<td>" + ((obj.data[i]["TENLOAISANPHAMCHA"] == undefined)?"":obj.data[i]["TENLOAISANPHAMCHA"]) + "</td>";
					        str += "<td class='capnhat'><a id="+ obj.data[i]["MALOAISP"] +" rev='" + obj.data[i]["TENLOAISP"] + "'><img src=\"images/edit.svg\"/></a></td>";
					        str += "<td class='xoa'><a id=" + obj.data[i]["MALOAISP"] + "><img src=\"images/delete.svg\"/></a></td>";
					        str += "</tr>";
					 	}

					 	
					    $("table.table tbody").append(str);
					    //$('#lsp_old').find('rev').val($("tr.test td.capnhat > a").attr('rev'));// xóa dữ liệu input(ẩn) cũ
					 }
					 $('#modal-wrapper').hide();
					 
					 toast(obj.type, obj.msg);
				}
			});
	});


	// Show giao diện Cập nhật loại sản phẩm
	$("body").delegate("tr.test td.capnhat > a", "click", function(){
		$('#modal-wrapper').show();// hiển thị popup
		$('#lsp_old').val($(this).attr('rev'));
		$('#lbl_idlsp').val($(this).attr('id'));
	});
	


	function toast(type, msg){
		toastr[type](msg, '')
		toastr.options.timeOut = 2500;
	}


});


