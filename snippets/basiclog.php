<?php
include('connection.php');
$logtype=$_POST['logtype'];
echo $logtype;
if($logtype=="adminlogin"){
$username=mysql_real_escape_string($_POST['username']);
$password=mysql_real_escape_string($_POST['password']);
$iniquery="SELECT * FROM admin WHERE username='$username' AND password='$password'";
$inirun=mysql_query($iniquery)or die(mysql_error());
$numrows=mysql_num_rows($inirun);
if($numrows>0){
session_start();
$logpart=md5($host_addr);
$_SESSION['logcheck'.$logpart.'']="off";
header('location:../admin/adminindex.php');
}else{
$_SESSION['adminerror']=$_SESSION['adminerror']+1;
//	echo $_SESSION['adminerror'];
header('location:../admin/index.php?error=true');
}
}elseif($logtype=="student"){
$username=mysql_real_escape_string($_POST['username']);
$password=mysql_real_escape_string($_POST['password']);
$iniquery="SELECT * FROM students WHERE email='$username' AND password='$password'";
$inirun=mysql_query($iniquery)or die(mysql_error());
$numrows=mysql_num_rows($inirun);
if($numrows>0){
$row=mysql_fetch_assoc($inirun);
$id=$row['id'];
session_start();
	$md5id=md5($id);
$_SESSION['s'.$md5id.'']=$id;
echo $id;
header('location:../student.php?id='.$id.'');
}else{
//	echo $_SESSION['adminerror'];
header('location:../login.php?error=true');
}
}elseif($logtype=="lecturer"){
$username=mysql_real_escape_string($_POST['username']);
$password=mysql_real_escape_string($_POST['password']);
$iniquery="SELECT * FROM lecturers WHERE email='$username' AND password='$password'";
$inirun=mysql_query($iniquery)or die(mysql_error());
$numrows=mysql_num_rows($inirun);
if($numrows>0){
	$row=mysql_fetch_assoc($inirun);
	$id=$row['id'];
	session_start();
	$md5id=md5($id);
$_SESSION['l'.$md5id.'']=$id;
header('location:../lecturer.php?id='.$id.'');
}else{
//	echo $_SESSION['adminerror'];
header('location:../login.php?error=true');
}
}
?>