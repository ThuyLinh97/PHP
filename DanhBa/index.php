<?php 
session_start();
include_once("model/user.php");
if(!isset($_SESSION["user"])){
    header("Location:login.php");
}?>
<?php include_once("danhba.php") ?>
<?php
//Mã php của trang chủ
    $user = unserialize($_SESSION["user"]);
   // echo "Xin chào bạn ". $user->fullName;
?>