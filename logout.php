Logout.php
<?php
   session_start();
   if(isset($_SESSION["sess_user"])){
       session_destroy();
       header('location: Login.php');
   }
   else{
       header('location: index.php');
   }
?>
