<?php
session_start();
include("conn.php");

$username = $_SESSION['username'];
$shopping_cart_name = $username."_shopping_cart"; 

if(isset($_COOKIE[$shopping_cart_name])){

    $cookie_data = stripslashes($_COOKIE[$shopping_cart_name]);
    $cart_data = json_decode($cookie_data, true);

    foreach($cart_data as $keys => $values){
        $id = $cart_data[$keys]["item_id"];
        $query_string = "SELECT amount FROM menu WHERE id = ".$id ;
        $before_amount = mysqli_fetch_array(mysqli_query($conn, $query_string));
        $left = $before_amount['amount'] - $cart_data[$keys]['item_quantity'];
        $update_sql = "UPDATE menu SET amount = ".$left." WHERE id = ".$id;
        mysqli_query($conn, $update_sql);
    }

    setcookie($shopping_cart_name, "", time() - 3600);

}

header("Location: index.php");
?>