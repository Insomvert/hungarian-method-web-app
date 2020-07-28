<?php
require_once("auth.php");
include "connect.php";
$iddata = $_POST['iddata'];
$uid = $_SESSION['id'];
$sql = "DELETE FROM optimasi WHERE optimasi.user_id=".$uid." AND optimasi.id=".$iddata."";
mysqli_query($con,$sql);
header('Location:datas.php')
?>