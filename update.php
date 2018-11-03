<?php
	include("conn.php");

	$id = $_REQUEST['id'];
	$name = $_REQUEST['itemName'];
	$price = $_REQUEST['price'];
	$des = $_REQUEST['itemDes'];

	// Update item
	$sql_update = 'UPDATE `menu` SET `name`= "'.$name.'",`price`= "'.$price.'",`des`= "'.des.'" WHERE ID = "'.$id.'";';
	$query = mysqli_query($conn, $sql_update);

	if(!$query){
		echo "fail";
	}else{
		//$pId = $conn->insert_id;
		echo '<script> alert("Uptate item successfully!");
		window.location.replace("index.php"); </script>';
	}
?>