$(document).ready(function(){
	function toast(type, msg){
		toastr[type](msg, '')
		toastr.options.timeOut = 3500;
	}

	$("body").delegate("#txtThoat", "click", function(){
		$.ajax({
				url: "../server/functions.php",
				cache:false,
				type: "POST",
				data: {
					action: "ThoatSession",

				},
				success: function(data){
					
					 var obj = JSON.parse(data);
					 if(obj.type == "success"){
					 	
					 	window.location='login.php';
					 	
					}
					 toast(obj.type, obj.msg);
					 
				}
			});
	});
});