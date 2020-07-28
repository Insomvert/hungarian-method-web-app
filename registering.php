<?php
include("connect.php");
error_reporting(E_ALL^(E_NOTICE|E_WARNING));
$username=$_POST['username'];
error_reporting(E_ALL^(E_NOTICE|E_WARNING));
$email=$_POST['email'];
error_reporting(E_ALL^(E_NOTICE|E_WARNING));
$password=$_POST['password'];
error_reporting(E_ALL^(E_NOTICE|E_WARNING));

$simpan="INSERT INTO users set username='$username',email='$email',password='$password'";
$query=mysqli_query($con,$simpan);

if($query){
    echo '<script>window.alert("Sukses membuat akun");window.location.href="login.php";</script>';
}else{
    echo '<script>window.alert("Gagal membuat akun")</script>';     
}
?>