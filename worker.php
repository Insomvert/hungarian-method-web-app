<?php
require_once("auth.php");
ob_start();
include "connect.php";
$sql = "SELECT * FROM optimasi";
$result =mysqli_query($con,$sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Worker</title>
  <!--Bootstrap-->
  <link rel="stylesheet" href="dist/bootstrap/dist/css/bootstrap.min.css">
  <!--Fontawesome-->
  <link rel="stylesheet" href="dist/font-awesome/css/font-awesome.min.css">
  <!--Styles-->
  <link rel="stylesheet" href="dist/css/styless.css">
  <link rel="stylesheet" href="dist/css/navbar.css">
</head>
<body>
<div class="container">
<div class="row rh">
<div class="col-12">
<div id='cssmenu'>
<ul>
   <li class='active'><a href='#'>Hungarian</a></li>
   <li><a href='datas.php'>Data</a></li>
   <li><a href='akun.php'>Akun</a></li>
   <li><a href='logout.php' onclick="return confirm('Anda ingin keluar dari akun <?php echo $_SESSION['username'] ?>?')">Logout</a></li>
</ul>
</div>
</div>
</div>
<div class="row tabb d-flex justify-content-between">
    <div class="rn active"><i class="fa fa-user"></i><span class="nn">Worker</span></div>
    <div class="rn"><i class="fa fa-briefcase"></i><span class="nn">Job</span></div>
    <div class="rn"><i class="fa fa-money"></i><span class="nn">Cost</span></div>
    <div class="rn"><i class="fa fa-table"></i><span class="nn">Tabel Optimasi</span></div>
</div>

<div class="row rj">
<div class="col-12">
<form method="get" name="frm" action="">
    <label for="jumlahJ" class="ij">Masukkan Jumlah Pengemban : </label>
    <input name="jumlahJ" type="number" class="input-jum"/>
    <input type="submit" name="btnJumlah" value="Ok" class="btn  btn-primary btn-sm"/>
</form>
</div>
</div>
<div class="row ri">
  <div class="col-12 justify-content-center">
<form method="post" name="frmpost" action="">
  <table cellpadding="0" cellspacing="0" class="table table-sm tcost">
    <tr>
      <td width="2px"></td>
      <td valign="top" class="jt">Nama Pengemban</td>
    </tr>
<?php
if(isset($_GET['jumlahJ']) && $_GET['jumlahJ']>0){
$jumlah_form = $_GET['jumlahJ'];
}
else{
$jumlah_form = 1;
}
for($i=1; $i<=$jumlah_form; $i++){
?>
    <tr>
      <td><?php echo $i ?></td><td><input name="job[]" type="text" class="in" placeholder="Type Something"  required/></td>
    </tr>
<?php
}
?>
    <tr>
      <td height="23" colspan="4"><input class="btn btn-success" type="submit" name="btnOk" value="Next" /></td>
    </tr>
  </table>
</form>
</div>
</div>
</div>

<script src="dist/js/jquery.min.js"></script>
<script src="dist/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
<?php
if(isset($_POST['btnOk'])){
    $job = $_POST['job'];
    print_r($job);
    $job2 = implode(",",$job);
    $uid = $_SESSION['id'];
    $sql = "INSERT INTO optimasi(user_id,worker) VALUES('".$uid."','".$job2."')";
    mysqli_query($con,$sql);
    header('Location:job.php?id='.mysqli_insert_id($con));
}
ob_end_flush();
?> 