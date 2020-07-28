<?php
require_once("auth.php");
require 'Hungarian.php';
include "connect.php";
$id=$_GET['id'];
$sql = "SELECT * FROM optimasi WHERE id=".$id;
$result =mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($result);
$job1 = explode(",",$row['job']);
$worker1 = explode(",",$row['worker']); 
$job=$job1;
$worker=$worker1;
$cost1= explode(",",$row['cost']);
$cost= $cost1;
$jumlah_job = count($job);
//Pecah array menjadi n baris
$cost2 = array_chunk($cost,$jumlah_job);

//==========Fungsi maksimasi============
$max = $cost[0];
for($i=1;$i<count($cost);$i++){
    if($cost[$i]> $max){
        $max = $cost[$i];
    }
}
$neg = [];
for($i=0;$i<count($cost);$i++){
    array_push($neg, $cost[$i]*-1);
}
$pos = [];
for($i=0;$i<count($neg);$i++){
    array_push($pos, $neg[$i] + $max);
}
$cpos= array_chunk($pos,$jumlah_job);
//=====================================

//var_dump($cost2);
$hungarian  = new \RPFK\Hungarian\Hungarian($cpos);
$result = $hungarian->solve();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Optimasi || Maksimasi</title>
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
    <div class="rn"><i class="fa fa-money"></i><span class="nn">Cost</span></div>
    <div class="rn active"><i class="fa fa-table"></i><span class="nn">Tabel Optimasi</span></div>
</div>

<div class="row rj">
<div class="col-6 d-flex align-items-center">
    <b>Tabel Optimasi &nbsp;</b>| Maksimasi 
</div>
</div>
<div class="row ri">
<div class="col-12 justify-content-center" style="overflow-x:auto; padding-top:1rem; padding-bottom:1rem">
    <table id="countit" class="table table-sm tcost">
    <tr>
        <td style="display:none;">ID Data : </td>
        <td style="display:none;"><?php echo $id ?></td>
    </tr>
    <tr>
        <th>No</th>
        <th>Nama Pengemban</th>
        <th>Tugas Yang Dikerjakan</th>
        <th>Keuntungan</th>
    </tr>
    <?php
    foreach($result as $key => $value){
        $i = $key+1;
        echo'<tr>';  
        echo'<td>'.$i.'</td>';
        echo'<td>'.$worker[$key].'</td>';
        echo'<td>'.$job[$value].'</td>';
        echo'<td class="count-me">'.$cost2[$key][$value].'</td>';
        echo'</tr>';
    }
    ?>
</table>
<br>
<div class="row">
<div class="col-6"></div>
<div class="col-6">
    <input type="submit" class="btn btn-success" value="Simpan" title="simpan data" data-toggle="modal" data-target="#simpan">
        <!--Modal simpan-->
        <div class="modal fade" id="simpan" tabindex="-1" role="dialog" aria-labelledby="simpan" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="simpan">Nama data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <form action="data.php" method="POST">
                        <input name="nId" type="text" class="in" value="<?php echo $_GET['id'];?>" style="display:none;"/>
                        <input name="nData" type="text" class="in" placeholder="masukkan nama data"  required/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-success" name="btnData" value="Simpan"></form>
                    </div>
                </div>
            </div>
        </div>
        <!--/Modal simpan-->
    <button id="print" class="btn btn-primary" title="download data ke komputer"><i class="fa fa-print"></i></button>
    </div>
</div>
</div>
</div>
</div>

<script src="dist/js/jquery.min.js"></script>
<script src="dist/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Script Menghitung Total Kolom Biaya -->  
<script>
		var tds = document.getElementById('countit').getElementsByTagName('td');
            var sum = 0;
            for(var i = 0; i < tds.length; i ++) {
                if(tds[i].className == 'count-me') {
                    sum += isNaN(tds[i].innerHTML) ? 0 : parseInt(tds[i].innerHTML);
                }
            }
            document.getElementById('countit').innerHTML += '<tr><td></td><td></td><th>Total Keuntungan</th><th>' + sum + '</th></th>';
</script>
<script>
    $(document).ready(function() {
        $("#print").click(function(e) {
            e.preventDefault();

            //getting data from table
            var data_type = 'data:application/vnd.ms-excel';
            var table_div = document.getElementById('countit');
            var table_html = table_div.outerHTML.replace(/ /g, '%20');

            var a = document.createElement('a');
            a.href = data_type + ', ' + table_html;
            a.download = 'tabel_optimasi_' + Math.floor(Math.random() * 9999999) + 100000 + '.xls';
            a.click();
            var r = confirm("Data anda sudah tersimpan.\nApakah Anda ingin membuat data baru ?");
            if (r == true){
                window.location.href="worker.php";
            }else{
                 
            }
        });
    });
</script>
</body>
</html>