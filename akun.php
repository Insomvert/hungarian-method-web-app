<?php
require_once("auth.php");
include "connect.php";
$id=$_SESSION['id'];
$sql = "SELECT * FROM optimasi WHERE user_id=".$id;
$result =mysqli_query($con,$sql);
$n = mysqli_num_rows($result);
//$row = mysqli_fetch_assoc($result);
/**for ($i=1;$i<=$n; $i++) { 
    $row = mysqli_fetch_assoc($result);
    echo '<pre>';
    print_r ($row['tanggal']);
}**/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun | <?php echo $_SESSION['username']?></title>
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
   <li><a href='worker.php' onclick="return confirm('Anda ingin membuat data baru?')">Hungarian</a></li>
   <li><a href='datas.php'>Data</a></li>
   <li class='active'><a href='akun.php'>Akun</a></li>
   <li><a href='logout.php' onclick="return confirm('Anda ingin keluar dari akun <?php echo $_SESSION['username'] ?>?')">Logout</a></li>
</ul>
</div>
</div>
</div>

<div class="row rj">
<div class="col-12 d-flex">
    <img class="avatar" src="img/avatar.png" alt="profil">
    <span style="margin-left:1rem">
    User Id :&nbsp<b><?php echo $_SESSION['id']?></b><br>
    Nama    :&nbsp<b><?php echo $_SESSION['username']?></b><br>
    Email   :&nbsp<b><?php echo $_SESSION['email']?></b><br>
    <a href="logout.php" onclick="return confirm('Anda ingin logout?')" class="">Logout</a>
    </span>
</div>
</div>
<div class="row ri">
<div class="col-12 justify-content-center" style="overflow-x:auto; padding-top:1rem; padding-bottom:1rem">
    <table id="countit" class="table table-sm tcost">
    <tr>
        <th width="5">No</th>
        <th width="50">Nama Data</th>
        <th width="50">Keterangan</th>
        <th width="50">Tanggal/Waktu</th>
        <th width="50">Aksi</th>
    </tr>
    <?php
    for ($i=1;$i<=$n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $nd = $row['data'];
        $tg = $row['tanggal'];
        $kt = $row['keterangan'];
        $di = $row['id'];
        echo '<tr><td>'.$i.'</td><td>'.$nd.'</td><td>'.$kt.'</td><td>'.$tg.'</td><td style="padding:0; display:flex">';
        echo '<a href="optimasi.php?id='.$di.'" class="btn btn-link btn-sm" title="solve minimasi"  style="color:purple"><i class="fa fa-minus-square-o"></i></a>';
        echo '<a href="maximasi.php?id='.$di.'" class="btn btn-link btn-sm" title="solve maksimasi" style="color:purple"><i class="fa fa-plus-square-o"></i></a>';
        echo '<button name="" class="btn btn-link btn-sm" title="ubah data" ><i class="fa fa-edit"></i></button>';
        echo '<form method="post" action="deldata.php">';
        echo '<input name="iddata" type="text" value="'.$di.'" style="display:none">';
        $msg = "'anda yakin ingin menghapus data?'";
        echo '<button type="submit" name="btnDel" class="btn btn-link btn-sm" title="hapus data" style="color:red" onclick="return confirm('.$msg.')"><i class="fa fa-trash"></i></button></form>';
        echo '</td></tr>';
    }?>
</table>
<br>
<div class="row">
    <div class="col-6"></div>
    <div class="col-6">
    
    </div>
</div>
</div>
</div>
</div>

<script src="dist/js/jquery.min.js"></script>
<script src="dist/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>