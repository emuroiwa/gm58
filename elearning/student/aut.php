<?php 
session_start();
if(!isset($_SESSION['reg'])){
header("location:../index.php");
}
?>