<?php
require("../connection.php");
include("../functions.php");
// if(session_id() == '' || !isset($_SESSION)){
//     session_start();
// }


if (checkLogin() == true) {
	header("location:../index.php");
	exit();
}

if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {
  $_SESSION['errors'] =  array();
}
if(isset($_GET['fpKey'])){
  $fpKey = $_GET['fpKey'];
  $sql = "SELECT * FROM `tbl_users` WHERE `user_fpKey` = '$fpKey'";
  $result = mysqli_query($con,$sql);
  if ($result) {
    if(mysqli_num_rows($result)!=1){
      array_push($_SESSION['errors'], "Access Denied..!");
    header("location:login.php");
    exit();
    }
  }
}else{
  array_push($_SESSION['errors'], "Access Denied..!");
  header("location:login.php");
  exit();
}

if(isset($_POST['resetPasswordBtn'])){
    
    /*if(empty($_POST['oldPassword'])){
       array_push($_SESSION['errors'], "Old Password is Required");
    }else{
      $oldPassword = md5(md5($_POST['oldPassword']));

      $sqlOldPass = "SELECT * FROM `tbl_users` WHERE `user_password` = '$oldPassword' AND `user_fpKey` = '$fpKey'";
      $resultOldPass = mysqli_query($con,$sqlOldPass);
      if($resultOldPass){
        if (mysqli_num_rows($resultOldPass) != 1) {
          array_push($_SESSION['errors'], "Old Password Not Matched");
        }
      }
    }*/

    if(empty($_POST['newPassword'])){
       array_push($_SESSION['errors'], "New Password is Required.");
    }else{
      $newPassword = $_POST['newPassword'];
    }

    if(empty($_POST['confPassword'])){
       array_push($_SESSION['errors'], "Confirm Password is Required.");
    }else{
      $confPassword = $_POST['confPassword'];
    }


    if($newPassword != $confPassword){
       array_push($_SESSION['errors'], "Password Not Matched.");
    }else{
      $newPassword = md5(md5($newPassword));
    }




    if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {
     $sql = "UPDATE  `tbl_users` SET `user_password` = '$newPassword', `user_fpKey` = ''  WHERE `user_fpKey` = '$fpKey'";
     
      $result = mysqli_query($con,$sql);
      if($result){
        $_SESSION['userAddedSuccessfullyMsg'] = "Your Password has been updated Successfully";
        header("location:login.php");
        exit();
      }else{
          array_push($_SESSION['errors'], "Something Going Worng, Please try later.");
        }
      }

    }
  
  
?>


<html>
<head>
<title>Reset Password/EventsAround</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width , initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
	</script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="Login.css"> 
</head>


<body>
<!-----------------Head Start------------------->
	<br>
	<a style="text-align:center" href="#">
		<img src="Logo/logo.jpg" class="logo-image" alt="Event Around">
	  </a>
	   <h2 style="text-align:center"><b>Events Around</b></h2>
<h3 style="text-align:center"><b>Reset Password</b></h3>
<br>
<!-------------------Head End--------------------->

<!-----------Login Form-------------->
<form id="login" action="resetPassword.php?fpKey=<?php echo $fpKey; ?>" method="POST" >
<?php if(isset($_SESSION['userAddedSuccessfullyMsg'])){
	?>
	<div class="alert alert-success">
		<?php echo $_SESSION['userAddedSuccessfullyMsg']; unset($_SESSION['userAddedSuccessfullyMsg']); ?>
	</div>
	<?php
} ?>
<?php if (isset($_SESSION['errors'])) { 
      $errors = $_SESSION['errors'];
      foreach ($errors as $error) {
        
      ?>
       <div class="alert alert-danger">
          <?php echo $error; ?>
      </div>
    <?php }
     unset($_SESSION['errors']);
      } 
    ?>
  <!--<div class="row">
    <div class="form-group">
		<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-key"> </i></span>
			<input type="password" class="form-control" name="oldPassword" placeholder="Old Password">
	    </div>
    </div>
  </div>-->
  <div class="row">
    <div class="form-group">
    <div class="input-group">
    <span class="input-group-addon"><i class="fa fa-key"> </i></span>
      <input type="password" class="form-control" name="newPassword" placeholder="Enter New Password">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="form-group">
    <div class="input-group">
    <span class="input-group-addon"><i class="fa fa-key"> </i></span>
      <input type="password" class="form-control" name="confPassword" placeholder="Confirm New Password">
      </div>
    </div>
  </div>
  <button style="width:100% !important;" type="submit" name="resetPasswordBtn">Reset Password</button>
  <br><br>
                 
</form>


</body>
</html>