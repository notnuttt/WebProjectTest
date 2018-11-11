<?php

session_start();
include("conn.php");

$username = $_SESSION['username'];
$shopping_cart_name = $username."_shopping_cart";

if(isset($_COOKIE[$shopping_cart_name])){

  $cookie_data = stripslashes($_COOKIE[$shopping_cart_name]);
  $cart_data = json_decode($cookie_data, true);

}else {
  $cart_data = array();
}

$item_id_list = array_column($cart_data, 'item_id');

if(in_array($_POST["id"], $item_id_list)){
  foreach($cart_data as $keys => $values){
   if($cart_data[$keys]["item_id"] == $_POST["id"]){
    $cart_data[$keys]["item_quantity"] = $cart_data[$keys]["item_quantity"] + $_POST["quantity"];
   }
  }
}else{
  $item_array = array(
    'item_id' => $_POST["id"],
    'item_img' => $_POST["image"],
    'item_name' => $_POST["name"],
    'item_price'  => $_POST["price"],
    'item_quantity'  => $_POST["quantity"]
   );
   $cart_data[] = $item_array;
}

$item_data = json_encode($cart_data);
setcookie($shopping_cart_name, $item_data, time() + (86400 * 30));
echo '<script> alert("Add to cart Success!");  </script>';
header("Location: index.php");
?>