<?php
require_once("auth.php");
include "connect.php";
if(!isset($_GET['id'])){
    echo '<script>window.alert("pilih data yang akan diubah");window.location.href="datas.php";</script>';
  }else{
    $id = $_GET['id'];
  }
//$id = $_GET['id'];
$sql = "SELECT * FROM optimasi WHERE id =".$id;
$result =mysqli_query($con,$sql);

$row = mysqli_fetch_assoc($result);
$job1 = explode(",",$row['job']);
$worker = explode(",",$row['worker']);
$t=$_GET['m'];
echo '<pre>';
if($t==1){
    print_r($worker);
    unset($worker[$_GET['di']]);
    print_r($worker);
    $workerN = implode(",",$worker);
    $sql = "UPDATE optimasi SET worker='".$workerN."' WHERE optimasi.id=".$id."";
    mysqli_query($con,$sql);
    header('Location:edit.php?id='.$id);
}else{
    print_r($job1);
    unset($job1[$_GET['di']]);
    print_r($job1);
    $jobN = implode(",",$job1);
    $sql = "UPDATE optimasi SET job='".$jobN."' WHERE optimasi.id=".$id."";
    mysqli_query($con,$sql);
    header('Location:edit.php?id='.$id);
}
?>