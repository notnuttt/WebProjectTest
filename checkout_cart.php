<?php
session_start();
include("conn.php");

$username = $_SESSION['username'];
$shopping_cart_name = $username."_shopping_cart"; 

if(isset($_COOKIE[$shopping_cart_name])){
    setcookie($shopping_cart_name, "", time() - 3600);
}
header("Location: index.php");
?>