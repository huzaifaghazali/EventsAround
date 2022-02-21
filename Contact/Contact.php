<?php 
require '../connection.php'; 
include "../functions.php";
if(!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0){
    $_SESSION['errors'] = array();
}
$name = $email = $message = "";
function unsetSessions(){
  unset($_SESSION['name']);
  unset($_SESSION['email']);
  unset($_SESSION['message']);

}
if (isset($_POST['contactBtn'])) {
  if(empty($_POST['name'])){
    array_push($_SESSION['errors'],"Name is Required");
      
    }else{
       $name = mysqli_real_escape_string($con, $_POST['name']);
       $_SESSION['name'] = $_POST['name'];
    }

    if(empty($_POST['email'])){
    array_push($_SESSION['errors'],"Email is Required");
      
    }else{
       $email = mysqli_real_escape_string($con, $_POST['email']);
       $_SESSION['email'] = $_POST['email'];
    }

    if(empty($_POST['message'])){
    array_push($_SESSION['errors'],"Message is Required");
      
    }else{
       $message = mysqli_real_escape_string($con, $_POST['message']);
       $_SESSION['message'] = $_POST['message'];
    }
    $createdTime = date('Y-m-d h:i:s');
    if(!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0){
      $sql = "INSERT INTO `tbl_contact_us` (`contactus_name`,`contactus_email`,`contactus_msg`,`contactus_data`)VALUES('$name','$email','$message','$createdTime')";
      $result = mysqli_query($con,$sql);
      if($result){
        unsetSessions();
        $_SESSION['messageSuccess'] = "Your Message has been send to admin Successfully";
        header("location:Contact.php");
        exit();
      }
    }

}
?>
<html lang="en">
<title>Events Around-Contact</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="Contact.css">

<body>
<!-- The Contact Section -->
  <div class="container-fluid" id="contact">
    <h2 class="w3-wide w3-center"><b>CONTACT</b></h2>
    <p class="w3-opacity w3-center"><i>Drop a Message to EventsAround</i></p>
    <div class="w3-row w3-padding-32">
      <div class="w3-col m6 w3-large w3-margin-bottom">
        <i class="fa fa-map-marker" style="width:30px"></i> Rawalpindi,Pakistan<br>
        <i class="fa fa-phone" style="width:30px"></i> Phone: 051 151515<br>
        <i class="fa fa-envelope" style="width:30px"> </i> Email: eventaround@gmail.com<br>
      </div>
      <div class="w3-col m6">
        <?php if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) {
                      foreach ($_SESSION['errors'] as $error) {
                      ?>
                        <div class="alert alert-danger">
                          <strong>Error: </strong>
                          <?php echo $error; ?>
                        </div>
                        
                      <?php
                      }
                      unset($_SESSION['errors']);
            } ?>  
          
            
            <?php 
            if(isset($_SESSION['name'])){
                $name = $_SESSION['name'];
            }

            if(isset($_SESSION['email'])){
                $email = $_SESSION['email'];
            }

            if(isset($_SESSION['message'])){
                $message = $_SESSION['message'];
            } 
            
            if(isset($_SESSION['messageSuccess'])){
              ?>
              <div class="alert alert-success">
                <?php echo $_SESSION['messageSuccess'];
                unset($_SESSION['messageSuccess']); ?>
              </div>
              <?php
            }  
            ?>
        <form action="Contact.php" method="POST">
          <div class="w3-row-padding" style="margin:0 -16px 8px -16px">
            <div class="w3-half">
              <input class="w3-input w3-border" type="text" placeholder="Name" required name="name">
            </div>
            <div class="w3-half">
              <input class="w3-input w3-border" type="text" placeholder="Email" required name="email">
            </div>
          </div>
          <input class="w3-input w3-border" type="text" placeholder="Message" required name="message">
          <button class="w3-button w3-black w3-section w3-right" name="contactBtn" type="submit">SEND</button>
        </form>
      </div>
    </div>
  

<!-- End Page Content -->

</div>
<?php include("../footer.php"); ?>
</body>
</html>