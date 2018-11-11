<?php
session_start();
include("conn.php");

$username = $_SESSION['username'];
$shopping_cart_name = $username."_shopping_cart"; 

if(isset($_COOKIE[$shopping_cart_name])){

    $cookie_data = stripslashes($_COOKIE[$shopping_cart_name]);
    $cart_data = json_decode($cookie_data, true);

    $item_id_list = array_column($cart_data, 'item_id');

    foreach($item_id_list as $id){
        $query_string = "SELECT amount FROM menu WHERE id = ".$id ;
        $before_amount = mysqli_fetch_array(mysqli_query($conn, $query_string));
        $left = $before_amount['amount']-1;
        $update_sql = "UPDATE menu SET amount = ".$left." WHERE id = ".$id;
        mysqli_query($conn, $update_sql);
    }

    setcookie($shopping_cart_name, "", time() - 3600);

}

header("Location: index.php");
?>