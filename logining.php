<?php 
session_start();
include "connect.php";
$username=$_POST['username'];
$password=$_POST['password'];
$login=mysqli_query($con,"SELECT * FROM users where username='$username' or email='$username' and password='$password'");
$data=mysqli_num_rows($login);

$sql = "SELECT * FROM users where username='".$username."' or email='".$username."' and password='".$password."'";
$result =mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($result);
if($data){
    $_SESSION['username']=$username;
    $_SESSION['id']=$row['id'];
    $_SESSION['email']=$row['email'];
	header("location:worker.php");
}else{
	echo "<script>alert('Username dan Password Tidak Valid'); window.location = 'login.php'</script>";
}
?>