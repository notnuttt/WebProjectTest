<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
include("conn.php");

$username = $_SESSION['username'];
mysqli_set_charset($conn,"utf8");



?>
<!DOCTYPE html>

<html>
<title>For admin</title>
<meta charset="UTF-8">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
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
    <h3 class="w3-wide" ><a href="/WebProject/index.php" style="text-decoration: none"><b>NJ Network Devices</b></a></h3>
  </div>
  <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
    <a href="/WebProjectTest/index.php" class="w3-bar-item w3-button"> Home </a>
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
<?php } ?>
    </p>
  </header>

<?php
    $questionQuery = 'SELECT qs FROM question';
    $question = mysqli_query($conn, $questionQuery);
?>

    <table border="1">
    <tr>
        <th>Questions</th>
    </tr>
    <?php
    while($row = mysqli_fetch_array($question)){ ?>
        <tr>
            <td><button id="btn1" draggable="true" ondragstart="drag(event)" ><?php echo $row['qs']; ?></button></td>
        </tr>
    <?php } ?>
    
    </table>    

<br><br>

    

  
  <div class="w3-black w3-center w3-padding-24"> ยินดีต้อนรับสู่ NJ Network Devices </div>

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