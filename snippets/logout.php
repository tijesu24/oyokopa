<?php
session_start();
include('connection.php');
if(isset($_GET['type'])){
$type=$_GET['type'];
if($type=="admin"){
$logpart=md5($host_addr);
$_SESSION['logcheck'.$logpart.'']="on";
header('location:../admin/?l=true');
}elseif($type=="viewer"){

}


}else{
	header('location:../index.php');
}
?>