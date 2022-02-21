<?php 
require("../connection.php"); 
include("../functions.php");
$name = $email = $password = $conf_password = $userType = "";
function unsetSessions(){
  unset($_SESSION['name']);
  unset($_SESSION['email']);
  unset($_SESSION['userType']);

}

if(!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0){
  $_SESSION['errors'] = array();
}
if (isset($_POST['submitBtn'])) {
	if (empty($_POST['name'])) {
    array_push($_SESSION['errors'], " Name is Required");
  }else{
    $name = mysqli_real_escape_string($con,$_POST['name']);
    $_SESSION['name'] = $name;
    if (ctype_alpha(str_replace(' ', '', $name)) === false) {
      array_push($_SESSION['errors'], " Name must contain letters and spaces only.");
    }
    
  }
  if (empty($_POST['email'])) {
    array_push($_SESSION['errors'], " Email is Required");
  }else{
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $_SESSION['email'] = $email;
    if (checkUserEmailExist($email)>0) {
      array_push($_SESSION['errors'], " Email already Exist, Please enter new one.");
    }
    
  }
  if (empty($_POST['password'])) {
    array_push($_SESSION['errors'], " Password is Required");
  }else{
    $password = mysqli_real_escape_string($con,$_POST['password']);
   
  }

  if (empty($_POST['conf_password'])) {
    array_push($_SESSION['errors'], "Confirm Password is Required");
  }else{
    $conf_password = mysqli_real_escape_string($con,$_POST['conf_password']);
   
  }

  if ($password != $conf_password) {
    array_push($_SESSION['errors'], "Password Not Matched, Please enter correct password");
  }else{
  	$password = md5(md5($password));
  }

   if (empty($_POST['userType'])) {
    array_push($_SESSION['errors'], " User Type is Required");
  }else{
    $userType = mysqli_real_escape_string($con,$_POST['userType']);
    $_SESSION['userType'] = $userType;
   
  }
  if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {
    $createdBy = 0;
    $createdDate = date("Y-m-d h:i:s");
    $userStatus = "A";
    if( basename($_FILES["userImage"]["name"] != "")){

        $target_dir = "../uploads/";
        $timestamp = time();
         $target_file = $target_dir . $timestamp.'-'.basename($_FILES["userImage"]["name"]);
        $db_target_file = "uploads/". $timestamp.'-'.basename($_FILES["userImage"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["userImage"]["tmp_name"]);
        if($check !== false) {
            
          if (file_exists($target_file)) {
              array_push($_SESSION['errors'], "Sorry, file already exists");
          }

          //Check file size
          if ($_FILES["userImage"]["size"] > 500000) {
              array_push($_SESSION['errors'], "File is too large");
          }


         if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
              array_push($_SESSION['errors'], "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
          }
          
          if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {

              if (move_uploaded_file($_FILES["userImage"]["tmp_name"], $target_file)) {
                  //your query with file path

               
                  $sql = "INSERT INTO `tbl_users` (`user_name`,`user_email`,`user_password`,`user_type`,`user_status`,`createdBy`,`createdDate`,`user_image`) VALUES ('$name','$email','$password','$userType','$userStatus','$createdBy','$createdDate','$db_target_file')";
              } else {
                array_push($_SESSION['errors'], "Sorry, there was an error uploading your file.");
              }
          

          }

                
          } else {
            array_push($_SESSION['errors'], "Please Upload Image File Only");
             
          }
        
      }else{
         $sql = "INSERT INTO `tbl_users` (`user_name`,`user_email`,`user_password`,`user_type`,`user_status`,`createdBy`,`createdDate`) VALUES ('$name','$email','$password','$userType','$userStatus','$createdBy','$createdDate')";
      }

     if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {
     		$result = mysqli_query($con,$sql);
		    if ($result) {
		      unsetSessions();
		      $_SESSION['userAddedSuccessfullyMsg'] = "User Added Successfully";
		      header("location:../Login/Login.php");
		      exit();
		    }
     }
    
    
  }
}
?>
<html>
<head>
	<title>Events Around-Signup</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width , initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
	</script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.11/vue.min.js"></script> -->
	<link rel="stylesheet" type="text/css" href="Signup.css">
</head>


<body>
	<!----------------Head Start------------------>
	<br>
	<a style="text-align:center" href="#">
		<img src="Logo/logo.jpg" class="logo-image" alt="Event Around">
	</a>

  <h1 style="text-align:center; font-family: 'Dancing Script', cursive;"><b>Events Around</b></h1>
	<h2 style="text-align:center"><b>Sign up</b></h2>
	<br>

	<!---------------------Head End------------------>

	<!-----------------Form Start-------------------->
	<form action="Signup.php" method="POST" enctype="multipart/form-data">
		<?php 
            if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
              $errArr = $_SESSION['errors'];
              foreach ($errArr as $errors) {
              ?>
              <div class="alert alert-danger">
                  <?php echo $errors; ?>
              </div>
              <?php 
              }
              unset($_SESSION['errors']);
            }

            if(isset($_SESSION['name'])){
              $name = $_SESSION['name'];
            } 
            if(isset($_SESSION['email'])){
              $email = $_SESSION['email'];
            } 
            if(isset($_SESSION['userType'])){
              $userType = $_SESSION['userType'];
            } 

              ?>
		<div class="row">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-user"> </i></span>
					<input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo $name; ?>">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-envelope"> </i></span>
					<input type="email" class="form-control" name="email" placeholder="Email Address" value="<?php echo $email; ?>">
				</div>
			</div>
		</div>
		<div class="row">
		<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-user"> </i></span>
					<input type="file" class="form-control" style="padding: 5px;" name="userImage">
				</div>
			</div>
		</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-key"> </i></span>
					<input type="password" class="form-control" name="password" placeholder="Password">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-key"> </i></span>
					<input type="password" class="form-control" name="conf_password" placeholder="Confirm Password">
				</div>
			</div>
		</div>
		<div class="row">
			
			<div class="input-group">
				<!-- <span class="input-group-addon"><i class="fa fa-user"> </i></span>
		<select name="" id=""> 
			<option value="" disabled selected hidden>Select the your type</option>
			<option value="Organizer">Organizer</option>
			<option value="User">User</option>
		  </select> -->
		 

			<div class="radio-div">
				<label for="user-option" class="l-radio">
					<input  <?php if($userType == "U"){echo "checked";} ?> type="radio" id="user-option" name="userType" tabindex="1" value="U">
					<span>User</span>
				</label>
				<label for="organizer-option" class="l-radio">
					<input <?php if($userType == "O"){echo "checked";} ?> type="radio" id="organizer-option" name="userType" tabindex="2" value="O">
					<span>Organizer</span>
				</label>
			</div>
		</div>

		</div>

		<button type="reset">Cancel</button>
		<button type="submit" name="submitBtn">Sign up</button>

		<br><br>
		<a id="link" href="../Login/Login.php">Already have an account?<b>Login here.</b></a>


	</form>
</body>

</html>