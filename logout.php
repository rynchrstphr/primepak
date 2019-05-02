<?php 

session_start();
unset($_SESSION['memberid']);
header("Location: login.php");

?>