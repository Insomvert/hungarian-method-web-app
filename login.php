<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <!--Bootstrap-->
  <link rel="stylesheet" href="dist/bootstrap/dist/css/bootstrap.min.css">
  <!--Fontawesome-->
  <link rel="stylesheet" href="dist/font-awesome/css/font-awesome.min.css">
  <!--Styles-->
  <link rel="stylesheet" href="dist/css/styless.css">
</head>
<body>
<div class="container">
<div class="row rh">
  
</div>
<div class="row tabb d-flex justify-content-between">
    <div class="rn active"><i class="fa fa-user"></i><span class="nn">Login</span></div>
</div>

<div class="row ri">
  <div class="col-12 justify-content-center">
    <form method="post" name="frmpost" action="logining.php">
  <table align="center" class="table table-sm tcost">
    <tr>
      <td></td>
      <td valign="top" class="jt" align="center"></td>
    </tr>
    <tr>
      <td class="jt" align="center">Username</td><td><input name="username" type="text" class="in" placeholder="Username or Email"  required/></td>
    </tr>
    <tr>
      <td class="jt" align="center">Password</td><td><input name="password" type="password" class="in" placeholder="Type Something"  required/></td>
    </tr>
    <tr>
      <td height="23" colspan="4"><input class="btn btn-success" type="submit" name="btnOk" value="Login" /></td>
    </tr>
  </table>
  <p>Belum punya akun? <a href="register.php">registrasi disini</a></p>
</form>
</div>
</div>
</div>

<script src="dist/js/jquery.min.js"></script>
<script src="dist/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>