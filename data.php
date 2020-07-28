<?php
require_once("auth.php");
include "connect.php";
$nData = $_POST['nData'];
$ket = $_POST['keterangan'];
$id = $_POST['nId'];
$sql = "UPDATE optimasi SET data='".$nData."',keterangan='".$ket."' WHERE optimasi.id=".$id."";
mysqli_query($con,$sql);
echo '<script>window.alert("Data Tersimpan");window.location.href="datas.php";</script>';
?>