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
if (isset($_POST['forgotPassBtn'])) {
  
    if(empty($_POST['forgotEmail'])){
       array_push($_SESSION['errors'], "Email is Required.");
    }else{
      $email = $_POST['forgotEmail'];  
    }

     if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {
      $sqlCheckEmail = "SELECT * FROM `tbl_users` WHERE `user_email` = '$email'";
      $resultCheckEmail = mysqli_query($con,$sqlCheckEmail);
      if($resultCheckEmail){
        if(mysqli_num_rows($resultCheckEmail) == 1){
          $key = generateKey(7);
          $sqlKey = "UPDATE `tbl_users` SET `user_fpKey` = '$key' WHERE `user_email` = '$email'";
          $resultKey = mysqli_query($con,$sqlKey);
          if ($resultKey) {
            
           include("function/sub_email_sent.php");
           $_SESSION['userAddedSuccessfullyMsg'] = "Check Your Email To Reset Your Password";
            header("location:login.php");
            exit();
          }
        }else{
          array_push($_SESSION['errors'], "Email Not Matched.");

        }
      }

     }
}
if(isset($_POST['loginBtn'])){
    
    if(empty($_POST['email'])){
       array_push($_SESSION['errors'], "Email is Required.");
    }else{
      $email = $_POST['email'];  
    }
    if(empty($_POST['password'])){
       array_push($_SESSION['errors'], "Password is Required.");
    }else{
      $password = md5(md5($_POST['password']));
    }

    if (!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0) {
     $sql = "SELECT * FROM `tbl_users` WHERE `user_email` = '$email' and `user_password` = '$password' ";
     
      $result = mysqli_query($con,$sql);
      if($result){
        if(mysqli_num_rows($result) == 1){
          if($row = mysqli_fetch_assoc($result)){ 
	          if(generateErrorMsg($row['user_status']) == true){
	          	 $_SESSION['onlineUserID'] =  $row['user_id'];
	              $_SESSION['onlineUserFullName'] = $row['user_name'];
	              $_SESSION['onlineUserType'] = $row['user_type'];
	              $_SESSION['onlineUserEmail'] = $email;
	              header("location:../index.php");
	              exit();
	          }   
             
          }
        }else{
          array_push($_SESSION['errors'], "Email or Password is incorrect Please enter valid credentials.");
        }
      }

    }
  
  }
?>


<html>
<head>
<title>Login/EventsAround</title>
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
	   <h1 style="text-align:center; font-family: 'Dancing Script', cursive;"><b>Events Around</b></h1>
<h3 style="text-align:center"><b>Login</b></h3>
<br>
<!-------------------Head End--------------------->

<!-----------Login Form-------------->
<form id="login" action="login.php" method="POST" >
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
  <div class="row">
    <div class="form-group">
    	<div class="input-group">
        <span class="input-group-addon" ><i class="fa fa-envelope"> </i></span>
				<input type="email" class="form-control" name="email" placeholder="Enter Your Email Address">
		</div>
	</div>
  </div>
  <div class="row">
    <div class="form-group">
		<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-key"> </i></span>
			<input type="password" class="form-control" name="password" placeholder="Enter Your Password">
	    </div>
    </div>
  </div>
  <button type="reset">Cancel</button>
  <button type="submit" name="loginBtn">Login</button>
  <br><br>
  <!-- <label>
             <input type="checkbox" checked="checked" id="remember"> Remember me
     	 </label>
     			<br> -->
           <br>
				 <a id="link" href="#myModal" data-toggle="modal" data-target="#myModal">Forget Password?</a>
                <br>
                 <a id="link" href="../Signup/Signup.php">Don't have and account?Signup here.</a>
                 
</form>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
<form action="login.php" method="POST" >
       
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Forgot Password</h4>
      </div>
      <div style="padding: 20px 40px 20px 40px; " class="modal-body">
        <div class="row">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon" ><i class="fa fa-envelope"> </i></span>
              <input type="email" class="form-control" name="forgotEmail" placeholder="Email Address">
          </div>
        </div>
        </div>
       
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" name="forgotPassBtn">Submit</button>
        
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
</form>

  </div>
</div>
</body>
</html>