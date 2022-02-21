<?php  
if(session_id() == '' || !isset($_SESSION)){
    session_start();
}
  
 
  
include("db_connection.php");  
  
if(isset($_POST['login']))  
{  
    $Email=$_POST['email'];  
    $Password=$_POST['password'];  
  
    $check_user="select * from users WHERE Email='$Email'AND Password='$Password'";  
  
    $run=mysqli_query($dbcon,$check_user);  
  
    if(mysqli_num_rows($run))  
    {  
        echo "<script>window.open('welcome.php','_self')</script>";  
  
        $_SESSION['email']=$Email;//here session is used and value of $user_email store in $_SESSION.  
  
    }  
    else  
    {  
      echo "<script>alert('Email or password is incorrect!')</script>";  
    }  
}  
?>  


