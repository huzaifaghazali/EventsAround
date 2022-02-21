<?php
require("includes/connection.php"); 
include ("includes/functions.php"); 
if(checkLogin() == true){
    header("location:index.php");
    exit();
}

if(isset($_POST['loginBtn'])){
    
        $email = $_POST['email'];
        if(empty($_POST['password'])){
           $_SESSION['error'] = "Password is Required";
            header("location:login.php");
            exit();
        }
        $password = md5(md5($_POST['password']));
    
        if(empty($email)){
           $_SESSION['error'] = "Email/Username is Required";
            header("location:login.php");
            exit();
        }
        $sql = "SELECT * FROM `tbl_admin` WHERE `email` = '$email'  and `password` = '$password' ";
        
        $result = mysqli_query($con,$sql);
        if($result){
          if(mysqli_num_rows($result) == 1){
            if($row = mysqli_fetch_assoc($result)){
    
              if(generateErrorMsg($row['status']) == false){
                header("location:login.php");
                exit();
              }else{
                $_SESSION['userID'] =  $row['id'];
                $_SESSION['userFullName'] = $row['name'];
                $_SESSION['userEmail'] = $row['email'];
                $_SESSION['userType'] = "A";
                header("location:index.php");
                exit();
              }
    
              
            }
          }else{
            $_SESSION['error'] = "Email or Password is incorrect Please enter valid credentials";
            header("location:login.php");
            exit();
          }
        }
       
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- meta tags --> 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <title> Event Around | Login </title> 
  <!-- css -->
  <link rel="stylesheet" href="signup.css">
  <style>
      body {
    background-color: #4f5161;
    padding-top: 85px;
}


h3 {
    font-family: 'Poppins', sans-serif, 'arial';
    font-weight: 600;
    color: white;
    text-align: center;
    width: 100%;
}
h1 {
    font-family: 'Poppins', sans-serif, 'arial';
    font-weight: 600;
    font-size: 72px;
    color: white;
    text-align: center;
}

h4 {
    font-family: 'Roboto', sans-serif, 'arial';
    font-weight: 400;
    font-size: 20px;
    color: #9b9b9b;
    line-height: 1.5;
}

/* ///// inputs /////*/

input:focus ~ label, textarea:focus ~ label, input:valid ~ label, textarea:valid ~ label {
    font-size: 0.75em;
    color: rgb(18, 66, 13);
    top: -5px;
    -webkit-transition: all 0.225s ease;
    transition: all 0.225s ease;
}

.styled-input {
    float: left;
    width: 293px;
    margin: 1rem 0;
    position: relative;
    border-radius: 4px;
}

@media only screen and (max-width: 768px){
    .styled-input {
        width:100%;
    }
}

.styled-input label {
    color: rgb(24, 23, 23);
   
    padding: 1.3rem 30px 1rem 30px;
    position: absolute;
    top: 10px;
    left: 0;
    -webkit-transition: all 0.25s ease;
    transition: all 0.25s ease;
    pointer-events: none;
}

.styled-input.wide { 
    width: 650px;
    max-width: 100%;
}

input,
textarea {
    padding: 30px;
    border: 0;
    width: 100%;
    font-size: 1rem;
    background-color: #f7f2f2;
     color: black;
    border-radius: 4px;
}

input:focus,
textarea:focus { outline: 0; }

input:focus ~ span,
textarea:focus ~ span {
    width: 100%;
    -webkit-transition: all 0.075s ease;
    transition: all 0.075s ease;
}

textarea {
    width: 100%;
    min-height: 15em;
}

.input-container {
    width: 650px;
    max-width: 100%;
    margin: 20px auto 25px auto;
}

.submit-btn {
    float: right;
    padding: 7px 35px;
    border-radius: 60px;
    display: inline-block;
    background-color: #e8f0fe; ;
    color: #0a3969;
    font-size: 18px;
    cursor: pointer;
    box-shadow: 0 2px 5px 0 rgba(0,0,0,0.06),
              0 2px 10px 0 rgba(0,0,0,0.07);
    -webkit-transition: all 300ms ease;
    transition: all 300ms ease;
}

.submit-btn:hover {
    transform: translateY(1px);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,0.10),
              0 1px 1px 0 rgba(0,0,0,0.09);
}

@media (max-width: 768px) {
    .submit-btn {
        width:100%;
        float: none;
        text-align:center;
    }
}

input[type=checkbox] + label {
  color: #ccc;
  font-style: italic;
} 

input[type=checkbox]:checked + label {
  color: #f00;
  font-style: normal;
}
  </style>
           
</head>
<body>
<div class="container">
	<div class="row">
			<h3>Admin-Login</h3>
	</div>
    <?php if (isset($_SESSION['error'])) { ?>
                    <div class="alert alert-danger">
                        <?php 
                        echo $_SESSION['error']; 
                        unset($_SESSION['error']);
                        ?>
                    </div>
                <?php } ?>
	<div class="row">
			<h4 style="text-align:center">  </h4>
	</div>
	<div class="row input-container">
        <form action="login.php" method="POST">
			<div class="col-xs-12">
				<div class="styled-input wide">
					<input type="email" name="email" required />
					<label>Email</label> 
				</div>
			</div>
            <div class="col-xs-12">
                <div class="styled-input wide">
                    <input type="password" name="password" required />
                    <label>Password</label>
                </div>
            </div>
			
			<div class="col-xs-12">
				<button name="loginBtn" type="submit" class="btn-lrg submit-btn">Login</button>
			</div>
        </form>
	</div>
</div>
<script>
    
</script>
</body>
</html>