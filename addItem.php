<?php
include("conn.php");
$name = $_POST['itemName'];
$price = $_POST['price'];
$des = $_POST['itemDes'];
$filename = $_FILES['imgage']['name'];
if ($_FILES['imgage']['name'] != "" ) {
    if(!move_uploaded_file($_FILES["imgage"]["tmp_name"], "./food/".$_FILES["imgage"]["name"]))
      die( "Upload error with code ".$_FILES["imgage"]["error"]);
}else die("You did not specify an input file or file excedd form");

$insert_query_string = "INSERT INTO `menu`(`name`, `price`, `des`, `img`) VALUES ('".$name."', ".$price.", '".$des."', '/OnlineStore/food/".$filename."');";
$query_insert = mysqli_query($conn, $insert_query_string);
if (!$query_insert) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}else{
    header("Location: index.php"); /* Redirect browser */
    exit();
}

?>