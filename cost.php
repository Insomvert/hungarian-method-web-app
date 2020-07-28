<?php
require_once("auth.php");
include "connect.php";
if(!isset($_GET['id'])){
    echo '<script>window.alert("Mohon isi data worker terlebih dahulu");window.location.href="worker.php";</script>';
  }else{
    $id = $_GET['id'];
  }
//$id = $_GET['id'];
$sql = "SELECT * FROM optimasi WHERE id =".$id;
$result =mysqli_query($con,$sql);

$row = mysqli_fetch_assoc($result);
$job1 = explode(",",$row['job']);
$worker = explode(",",$row['worker']); 
$job=$job1;

//Hitung jumlah data array
$jumlah_row = count($job);
$jumlah_col = count($worker);

//Menambahkan data dummy untuk kasus tidak seimbang
if($jumlah_col>$jumlah_row){
    $jml_add = $jumlah_col - $jumlah_row;
    for($i=1;$i<=$jml_add;$i++){
        array_push($job,"Dummy".$i);
    }
}
if($jumlah_row>$jumlah_col){
    $jml_add = $jumlah_row - $jumlah_col;
    for($i=1;$i<=$jml_add;$i++){
        array_push($worker,"dummy".$i);
    }
}
$jumlah_job = count($job);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cost</title>
  <!--Bootstrap-->
  <link rel="stylesheet" href="dist/bootstrap/dist/css/bootstrap.min.css">
  <!--Fontawesome-->
  <link rel="stylesheet" href="dist/font-awesome/css/font-awesome.min.css">
  <!--Styles-->
  <link rel="stylesheet" href="dist/css/styless.css">
  <link rel="stylesheet" href="dist/css/navbar.css">
</head>
<body>
<div class="container co-co">
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
    <div class="rn"><i class="fa fa-user"></i><span class="nn">Worker</span></div>
    <div class="rn"><i class="fa fa-briefcase"></i><span class="nn">Job</span></div>
    <div class="rn active"><i class="fa fa-money"></i><span class="nn">Cost</span></div>
    <div class="rn"><i class="fa fa-table"></i><span class="nn">Tabel Optimasi</span></div>
</div>

<form method="post" name="frmpost" action="">
<div class="row rj">
<div class="col-12 d-flex justify-content-end">
    <div class="d-flex align-items-center">
        <input type="submit" name="btnOk" value="Proses & Simpan" class="btn btn-success"/>
    </div>
    <div class="d-flex check">
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="checkbox" name="metode" value="maksimasi"/>
                </div>
            </div>
        </div>
        <label for="metode" class="align-self-center">Maksimasi</label>
    </div>

</div>
</div>
<div class="row ri">
<div class="col-12 justify-content-center" style="overflow-x:auto; padding-top:1rem;">

<table class="table table-sm tcost">
<tr  align="center">
<?php 
    echo '<th>Worker/Job</th>';
    foreach($job as $key => $val){
        echo '<th>'.$job[$key].'</th>';
    }
?>
</tr>
<?php
foreach($worker as $key => $val){
    echo '<tr align="center"><th>'.$worker[$key].'</th>';
    for($i=1; $i<=$jumlah_job; $i++){
        //Membuat input cost secara otomatis sesuai worker x job
        echo'<td><input name=cost[] type="number" required></td>';
        
        //Button Save and Solve Clicked
        if(isset($_POST['btnOk'])){
            $cost= $_POST['cost'];
              // menyimpan ke database
            $cost = implode(",",$cost);
            $jobN = implode(",",$job);
            $workerN = implode(",",$worker); 
            $sql = "UPDATE optimasi SET worker='".$workerN."', job='".$jobN."', cost='".$cost."' WHERE optimasi.id=".$id."";
            //$sql = "INSERT INTO optimasi(cost) VALUES('".$cost."')";
            mysqli_query($con,$sql);
            if(isset($_POST['metode'])){
                header('Location:maximasi.php?id='.$id);
            }else{
                header('Location:optimasi.php?id='.$id);
            }
        }
    }
}?>
</table>
<div>
    <hr>
    <b>Keterangan : </b>
    <p>1. Isi kolom / baris <u><i>Dummy</i></u> dengan nilai <b>0</b> jika ada <br>2. Metode secara default adalah MINIMASI<br>3. Pilih metode MAKSIMASI dengan mencentang pilihan</p>
</div>
</div>
</div>
</form>
</div>
<script src="dist/js/jquery.min.js"></script>
<script src="dist/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>