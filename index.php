<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include("conn.php");

$sql_query_food = 'SELECT * FROM menu WHERE 1';
$query_food = mysqli_query($conn, $sql_query_food);
$query_food2 = mysqli_query($conn, $sql_query_food);

$username = $_SESSION['username'];
$shopping_cart_name = $username."_shopping_cart";

$total = 0;
$amountItems = 0;
if(isset($_COOKIE[$shopping_cart_name])){
  
  $cookie_data = stripslashes($_COOKIE[$shopping_cart_name]);
  $cart_data = json_decode($cookie_data, true);

  foreach($cart_data as $keys => $values){
    $total += $values["item_quantity"] * $values["item_price"];
    $amountItems++;
  }
}
echo $total;


?>
<!DOCTYPE html>

<html>
<title>N&N Café</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
.w3-sidebar a {font-family: "Roboto", sans-serif}
body,h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif;}
</style>
<body class="w3-content" style="max-width:1200px">

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-bar-block w3-white w3-collapse w3-top" style="z-index:3;width:250px" id="mySidebar">
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-display-topright"></i>
    <h3 class="w3-wide" ><a href="index.php" style="text-decoration: none"><b>NJ Network Devices</b></a></h3>
  </div>
  <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
    <a href="#" class="w3-bar-item w3-button">Menu</a>
  </div>
 
  
</nav>

<!-- Top menu on small screens -->
<header class="w3-bar w3-top w3-hide-large w3-black w3-xlarge">
  <div class="w3-bar-item w3-padding-24 w3-wide">LOGO</div>
  <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-24 w3-right" onclick="w3_open()"><i class="fa fa-bars"></i></a>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:250px">

  <!-- Push down content on small screens -->
  <div class="w3-hide-large" style="margin-top:83px"></div>
  
  <!-- Top header -->
  <header class="w3-container w3-xlarge">
    <p class="w3-right">
      <?php
        if($_SESSION['status'] == 'admin'){?>
         <i class="fa fa-plus w3-margin-right w3-button" onclick="document.getElementById('addItem').style.display='block'"></i>          
   <?php     }else if($_SESSION['status'] == 'user'){ ?>
            <i class="fa fa-shopping-cart w3-margin-right w3-button" onclick="document.getElementById('thecart').style.display='block'"><b style="color:red;"><?php echo "   ".$amountItems; ?></b></i>
        <?php } ?>
       <i class="fa fa-search w3-button"  onclick="document.getElementById('search').style.display='block'"></i> 

        <?php
    if($_SESSION['status'] == NULL){ ?>
      <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding" onclick="document.getElementById('login').style.display='block'">Login</a>
<?php }else{ ?>
    <a class="w3-bar-item w3-button w3-padding" style="color: grey;">Hello! <?php echo $_SESSION['username']; ?> </a>
      <a class="w3-bar-item w3-button w3-padding" href="logout.php"> Logout </a>
<?php }
  ?>
    </p>
  </header>



  <!-- Product grid -->
  <div class="w3-row-padding">
  
  <?php
    while($array_food = mysqli_fetch_array($query_food)){
      $id = $array_food['id']; ?>
      <div class="w3-third w3-container">
      <div class="w3-display-container">
        <img src="<?php echo $array_food['img']; ?>" style="width:100%; heigh:100%">
        <?php if($_SESSION['status'] == 'admin'){ ?>
        <div class="w3-display-middle w3-display-hover">
            <button class="w3-button w3-black" onclick="document.getElementById('<?php echo $id; ?>').style.display='block'">Edit</button>
            <form method="POST" action="remove.php">
              <input type="hidden" value="<?php echo $id; ?>" name="id">
             <input type="submit" value="Remove" class="w3-button w3-black">
            </form>
        </div>
        <?php }else if($_SESSION['status'] == 'user'){ ?>
          <div class="w3-display-middle w3-display-hover">
            <form method="POST" action="addCart.php">
              <input type="hidden" value="<?php echo $id; ?>" name="id">
              <input type="hidden" value="<?php echo $array_food['name']; ?>" name="name">
              <input type="hidden" value="<?php echo $array_food['price']; ?>" name="price">
              <input type="hidden" value="<?php echo $array_food['img']; ?>" name="image">
              <input type="hidden" value="1" name="quantity">
             <input type="submit" value="Add to cart" class="w3-button w3-black">
            </form>
        </div>

        <?php } ?>  </div>
        <p><a href="product_detail.php/?idq=<?php echo $id; ?>" style="text-decoration: none"><?php echo $array_food['name']; ?></a><br><b><?php echo $array_food['price']; ?> Baht.</b><br><?php echo $array_food['amount']; ?> available.</p>
      </div>
<?php    }
  ?>
  </div>
    

  
  <div class="w3-black w3-center w3-padding-24"> Welcome to NJ Network Device</div>

  <!-- End page content -->
</div>


<?php if($_SESSION['status'] == NULL){ ?>
<!-- Login Modal -->
<div id="login" class="w3-modal">
  <div class="w3-modal-content w3-animate-zoom" style="padding:32px">
    <div class="w3-container w3-white w3-center">
      <i onclick="document.getElementById('login').style.display='none'" class="fa fa-remove w3-right w3-button w3-transparent w3-xxlarge"></i>
      <h2 class="w3-wide" >LOGIN</h2>
      <p style="align:center">Please login to continue.</p>
      <form method="POST" action="login.php">
        <p><input class="w3-input w3-border" type="text" placeholder="Enter Username" name="username"></p>
        <p><input class="w3-input w3-border" type="password" placeholder="Enter Password" name="password"></p>
        <input type="submit" class="w3-button w3-padding-large w3-red w3-margin-bottom" onclick="document.getElementById('login').style.display='none'" value="Login">

      </form>
      
    </div>
  </div>
</div>
<?php } ?>

<!-- Search Modal -->
<div id="search" class="w3-modal">
  <div class="w3-modal-content w3-animate-zoom" style="padding:32px">
    <div class="w3-container w3-white w3-center">
      <i onclick="document.getElementById('search').style.display='none'" class="fa fa-remove w3-right w3-button w3-transparent w3-xxlarge"></i>
      <h2 class="w3-wide" >WANNA SEARCH SOMETHING?</h2>
      <form method="GET" action="search.php">
        <p><input class="w3-input w3-border" type="text" placeholder="Search" name="keyword"></p>
        <input type="submit" class="w3-button w3-padding-large w3-red w3-margin-bottom" onclick="document.getElementById('search').style.display='none'" value="Search">

      </form>
      
    </div>
  </div>
</div>

<?php if($_SESSION['status'] == 'admin'){ ?>
<!-- AddItem Modal -->
<div id="addItem" class="w3-modal">
  <div class="w3-modal-content w3-animate-zoom" style="padding:32px">
    <div class="w3-container w3-white w3-center">
      <i onclick="document.getElementById('addItem').style.display='none'" class="fa fa-remove w3-right w3-button w3-transparent w3-xxlarge"></i>
      <h2 class="w3-wide" >Add New ITEM</h2>
      <p style="align:center">Please fill the item details.</p>
      <form method="POST" action="addItem.php" enctype="multipart/form-data">
        <p><input class="w3-input w3-border" type="text" placeholder="Enter Name" name="itemName"></p>
        <p><input class="w3-input w3-border" type="text" placeholder="Price" name="price"></p>
        <p><input class="w3-input w3-border" type="text" placeholder="Amount" name="amount"></p>
        <p><input class="w3-input w3-border" type="text" placeholder="Enter Desciption (If any)" name="itemDes"></p>
        <p><input class="w3-input w3-border" type="file" placeholder="Enter Image path" name="imgage"></p>
        <input type="submit" class="w3-button w3-padding-large w3-red w3-margin-bottom" onclick="document.getElementById('addItem').style.display='none'" value="Add Item">

      </form>
      
    </div>
  </div>
</div>
<?php } ?>

<!-- Update Item Modal -->
<?php
      while($array_food = mysqli_fetch_array($query_food2)){
        $id = $array_food['id']; ?>
       <div id="<?php echo $id; ?>" class="w3-modal">
          <div class="w3-modal-content w3-animate-zoom" style="padding:32px">
            <div class="w3-container w3-white w3-center">
              <i onclick="document.getElementById('<?php echo $id; ?>').style.display='none'" class="fa fa-remove w3-right w3-button w3-transparent w3-xxlarge"></i>
              <h2 class="w3-wide" >Update <?php echo $array_food['name']; ?></h2>
              <p style="align:center">Please fill the item details.</p>
              <form method="POST" action="update.php" enctype="multipart/form-data">
              <input type ="hidden" name="id" value="<?php echo $id; ?>">
                <p><input class="w3-input w3-border" type="text" placeholder="Enter Name" name="itemName" value="<?php echo $array_food['name']; ?>"></p>
                <p><input class="w3-input w3-border" type="number" placeholder="Price" name="price" value="<?php echo $array_food['price']; ?>"></p>
                <p><input class="w3-input w3-border" type="number" placeholder="Amount" name="amount" value="<?php echo $array_food['amount']; ?>"></p>
                <p><input class="w3-input w3-border" type="text" placeholder="Enter Desciption (If any)" name="itemDes" value="<?php echo $array_food['des']; ?>"></p>
                <input type="submit" class="w3-button w3-padding-large w3-red w3-margin-bottom" onclick="document.getElementById('<?php echo $id; ?>').style.display='none'" value="Update">
                </form>
              </div>
            </div>
          </div>
   <?php   }

?>


<!-- Add to cart -->
<?php
if(isset($_COOKIE[$shopping_cart_name])){
  $cookie_data = stripslashes($_COOKIE[$shopping_cart_name]);
  $cart_data = json_decode($cookie_data, true); ?>
    <div id="thecart" class="w3-modal">
          <div class="w3-modal-content w3-animate-zoom" style="padding:32px">
            <div class="w3-container w3-white w3-center">
              <i onclick="document.getElementById('thecart').style.display='none'" class="fa fa-remove w3-right w3-button w3-transparent w3-xxlarge"></i>
              <h2 class="w3-wide" >Items in cart</h2>
              <p style="align:center">Please checkout.</p>
              <table align="center">
              <tr>
    <th>Img</th>
    <th>Name</th>
    <th>Amount</th>
    <th>Price</th>
  </tr>
  <tr>
<?php
  foreach($cart_data as $keys => $values){ ?>
  <th><img src="<?php echo $values["item_img"];; ?>" style="width: 30px; height: 30px;"></th>
  <td><a href="product_detail.php?idq=<?php echo $values["item_id"]; ?>"><?php echo $values["item_name"]; ?></a></td>
  <td><?php echo $values["item_quantity"]; ?></td>
  <td align="right"> <?php echo $values["item_price"]; ?></td>
    
                
                <!-- <td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?></td> -->
                <!-- <td><a href="index.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td> -->
              </tr>
              
<?php
    } ?>
    </table>
    <p align="right">Total: <b><?php echo $total; ?></b> Baht.</p>
<form method="POST" action="checkout_cart.php" enctype="multipart/form-data">
                <input type="submit" class="w3-button w3-padding-large w3-red w3-margin-bottom" onclick="document.getElementById('thecart').style.display='none'" value="Checkout">
                </form>
              </div>
            </div>
          </div>

<?php }else{ ?>
  <div id="thecart" class="w3-modal">
          <div class="w3-modal-content w3-animate-zoom" style="padding:32px">
            <div class="w3-container w3-white w3-center">
              <i onclick="document.getElementById('thecart').style.display='none'" class="fa fa-remove w3-right w3-button w3-transparent w3-xxlarge"></i>
              <h2 class="w3-wide" >Items in cart</h2>
              <p style="align:center">Empty Cart</p>
              </div>
            </div>
          </div>
<?php
}

?>


<script>
// Accordion 
function myAccFunc() {
    var x = document.getElementById("demoAcc");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}

// Click on the "Jeans" link on page load to open the accordion for demo purposes
document.getElementById("myBtn").click();
// Script to open and close sidebar
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
}
</script>

</body>
</html>