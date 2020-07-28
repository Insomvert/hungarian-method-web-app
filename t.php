<?php
require_once("auth.php");
include "connect.php";
$id = $_POST['nId'];
$t = $_POST['tp'];
$data = $_POST['mytext'];

$sql = "SELECT * FROM optimasi WHERE id =".$id;
$result =mysqli_query($con,$sql);

$row = mysqli_fetch_assoc($result);
$job1 = explode(",",$row['job']);
$worker = explode(",",$row['worker']); 
$job=$job1;
if($t==1){
    for($i=0;$i<count($data);$i++){
        array_push($worker,$data[$i]);
    }
    $workerN = implode(",",$worker);
    $sql = "UPDATE optimasi SET worker='".$workerN."' WHERE optimasi.id=".$id."";
    mysqli_query($con,$sql);
    header('Location:edit.php?id='.$id);
}else{
    for($i=0;$i<count($data);$i++){
        array_push($job,$data[$i]);
    }
    $jobN = implode(",",$job); 
    $sql = "UPDATE optimasi SET job='".$jobN."' WHERE optimasi.id=".$id."";
    mysqli_query($con,$sql);
    header('Location:edit.php?id='.$id);
}

?>