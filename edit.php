<?php
require_once("auth.php");
ob_start();
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
$job=$job1;
$cos=explode(",",$row['cost']);

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
  <title>Edit Cost</title>
  <!--Bootstrap-->
  <link rel="stylesheet" href="dist/bootstrap/dist/css/bootstrap.min.css">
  <!--Fontawesome-->
  <link rel="stylesheet" href="dist/font-awesome/css/font-awesome.min.css">
  <!--Styles-->
  <link rel="stylesheet" href="dist/css/styles.css">
  <link rel="stylesheet" href="dist/css/navbar.css">
</head>
<body>
<div class="container co-co">
<div class="row rh">
  <div class="col-12">
  <div id='cssmenu'>
<ul>
   <li><a href='worker.php' onclick="return confirm('Anda ingin menambah data baru?')">Hungarian</a></li>
   <li class='active'><a href='datas.php'>Data</a></li>
   <li><a href='akun.php'>Akun</a></li>
   <li><a href='logout.php' onclick="return confirm('Anda ingin keluar dari akun <?php echo $_SESSION['username'] ?>?')">Logout</a></li>
</ul>
</div>
    </div>
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
<tr  align="right">
<?php 
    echo '<th></th>';
    foreach($job as $key => $val){
        echo '<th><input name="job[]" type="text" value="'.$job[$key].'" style="color:#764db1;" required/><a href="buang.php?id='.$id.'&&di='.$key.'&&m=2" type="submit" name="btnBuang" class="btn btn-link btn-sm bth" title="buang" style="color:#c6c6c6"><i class="fa fa-times-circle-o"></i></a></th>';
    }
?>
</tr>
<?php
$kost=array_chunk($cos,$jumlah_job);
foreach($worker as $key => $val){
    echo '<tr align="right"><th><input name=worker[] type="text" value="'.$worker[$key].'" style="color:#764db1;" required/><a href="buang.php?id='.$id.'&&di='.$key.'&&m=1" type="submit" name="btnBuang" class="btn btn-link btn-sm bth" title="buang" style="color:#c6c6c6"><i class="fa fa-times-circle-o"></i></a></th>';
    for($i=1; $i<=$jumlah_job; $i++){
        //Membuat input cost secara otomatis sesuai worker x job
        echo'<td><input type="number" id="coss" name=cost[] required></td>';
        //Button Save and Solve Clicked
        if(isset($_POST['btnOk'])){
              // menyimpan ke database
            $cost = implode(",",$_POST['cost']);
            $jobN = implode(",",$_POST['job']);
            $workerN = implode(",",$_POST['worker']); 
            $udi = $_SESSION['id'];
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
</form>
<table>
    <tr>
        <td width=50%>
            <div class="btnWork">
            <button type="submit" class="add_form_fieldW btn btn-sm btn-secondary btn-block" title="tambah worker" >Tambah Worker</button>
            </div>
        </td>
        <td width=50%>
            <div class="btnJob">
            <button type="submit" class="add_form_fieldJ btn btn-sm btn-secondary btn-block" title="tambah job" >Tambah Job</button>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <form action="t.php" method="POST">
                <div class="containerW">
                    <input name="nId" type="text" class="in" value="<?php echo $_GET['id'];?>" style="display:none;"/>
                    <input name="tp" type="text" class="in" value="1" style="display:none;"/><br>
                    <div class="smpW">
                        <button type="submit" class="btn btn-sm btn-block btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </td>
        <td>
            <form action="t.php" method="POST">
                <div class="containerJ">
                    <input name="nId" type="text" class="in" value="<?php echo $_GET['id'];?>" style="display:none;"/>
                    <input name="tp" type="text" class="in" value="2" style="display:none;"/><br>
                    <div class="smpJ">
                        <button type="submit" class="btn btn-sm btn-block btn-success">tes</button>
                    </div>
                </div>
            </form>            
        </td>
    </tr>
</table>
<!--Modal Tambah Worker-->
<div class="modal fade" id="tmbW" tabindex="-1" role="dialog" aria-labelledby="simpan" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="simpan">Tambah Worker</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <form action="t.php" method="POST">
                        <div class="container11">
                        <input name="nId" type="text" class="in" value="<?php echo $_GET['id'];?>" style="display:none;"/>
                        <input name="tp" type="text" class="in" value="1" style="display:none;"/>
                        <div><input name="mytext[]" type="text" class="in" required/><button class="add_form_field btn btn-sm btn-default" title="tambah" style="position:absolute;top:15px;margin-left:-30px;"><i class="fa fa-plus"></i></button></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-success" name="btnData" value="Simpan"></form>
                    </div>
                </div>
            </div>
        </div>
<!--/Modal Tambah Worker-->
<!--Modal Tambah Job-->
<div class="modal fade" id="tmbJ" tabindex="-1" role="dialog" aria-labelledby="simpan" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="simpan">Tambah Job</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <form action="t.php" method="POST">
                        <div class="container11">
                        <input name="nId" type="text" class="in" value="<?php echo $_GET['id'];?>" style="display:none;"/>
                        <input name="tp" type="text" class="in" value="2" style="display:none;"/>
                        <div><input name="mytext[]" type="text" class="in" required/><button class="add_form_field btn btn-sm btn-default" title="tambah" style="position:absolute;top:15px;margin-left:-30px;"><i class="fa fa-plus"></i></button></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-success" name="btnData" value="Simpan"></form>
                    </div>
                </div>
            </div>
        </div>
<!--/Modal Tambah Job-->
<div>
    <hr>
    <b>Keterangan : </b>
    <p>1. Isi kolom / baris <u><i>Dummy</i></u> dengan nilai <b>0</b> jika ada <br>2. Metode secara default adalah MINIMASI<br>3. Pilih metode MAKSIMASI dengan mencentang pilihan</p>
</div>
</div>
</div>
</div>
<script src="dist/js/jquery.min.js"></script>
<script src="dist/bootstrap/dist/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function(){
        $('.smpW').hide();
        $('.smpJ').hide();
        var max_field = 10;
        var wrapperW = $(".containerW")
        var wrapperJ = $(".containerJ")
        var add_buttonW = $(".add_form_fieldW");
        var add_buttonJ = $(".add_form_fieldJ");
        var xw=0;
        var xj=0;
        $(add_buttonW).click(function(e){
            e.preventDefault();
            if(xw<max_field){
                xw++;
                $(wrapperW).prepend('<div><input class="in" type="text" name="mytext[]"><a href="#" class="btn btn-sm btn-default delete" style="position:absolute;margin-left:-30px;"><i class="fa fa-times"></i></a></div>');
                $('.smpW').show();
                $('.btnJob').hide("slow");
            }else{
                alert('limited');
            }
        });
        $(add_buttonJ).click(function(e){
            e.preventDefault();
            if(xj<max_field){
                xj++;
                $(wrapperJ).prepend('<div><input class="in" type="text" name="mytext[]"><a href="#" class="btn btn-sm btn-default delete" style="position:absolute;margin-left:-30px;"><i class="fa fa-times"></i></a></div>');
                $('.smpJ').show();
                $('.btnWork').hide("slow");
            }else{
                alert('limited');
            }
        });
        $(wrapperW).on("click",".delete",function(e){
            e.preventDefault();$(this).parent('div').remove();xw--;
            if(xw===0){
                $('.smpW').hide();
                $('.btnJob').show("slow");
            }
        })
        $(wrapperJ).on("click",".delete",function(e){
            e.preventDefault();$(this).parent('div').remove();xj--;
            if(xj===0){
                $('.smpJ').hide();
                $('.btnWork').show("slow");
            }
        })
    });
</script>
<script>
        const cos = <?php echo json_encode($cos);?>;
        var jml = <?php echo count($cos);?>;
        var tst= cos[2];
        const cost= $("[name='cost[]']");
        for(let i=0; i<cost.length;i++){
            $(cost[i]).val(cos[i]);
        }   
</script>
</body>
</html>
<?php
ob_end_flush();
?>
