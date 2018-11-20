<!DOCTYPE html>
<html lang="en">
<?php
@session_start();
?>
<head>
	<meta charset="UTF-8">
	<title>Index</title>
</head>
<body>
	<?php
		include_once("dbconnect.php");
	?>
	<?php
	if(isset($_GET["khoatrang"])){
		$khoatrang=$_GET["khoatrang"];
	}else{
		$khoatrang="";
	}
	if(isset($_SESSION['login']) == 1){
		// echo "<script>window.location='trangchu.php'</script>";
		$khoatrang="trangchu";
	}else{
		
		echo "<script>window.location='login.php'</script>";
	}

	

	switch($khoatrang){
		case "trangchu":
			echo "<script>window.location='trangchu.php'</script>";
			break;
		default:

	}

	?>
</body>
</html>