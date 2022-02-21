<?php require("../connection.php"); ?>
<?php require("../functions.php"); ?>
<?php if(checkLogin() == false){
    header("location:../../index.php");
    exit();
} 
 $groupID = "";
$eventID  ="";
if (!isset($_SESSION['onlineUserType']) || $_SESSION['onlineUserType'] != "O") {
    header("location:../../index.php");
    exit();
}
if (isset($_GET['groupID'])) {
    $groupID = $_GET['groupID'];
if(getOrganizerGroupID($_SESSION['onlineUserID']) != $groupID){
   $_SESSION['groupErrMsg'] = "Add Evevt Request Denied, Your are not organizer of this group";
        header("location:../group/group.php");
        exit(); 
  }
}
$heading = "Create a new Event";
$actionURL = "creatEvents.php?groupID=".$groupID;
$eventTitle = $eventDate = $eventTime = $eventDuration = $eventCateID= $eventLocation = $eventContact = $eventType = $eventTicketQty =  $ticketPrice = $eventTicketSaleStartDate = $eventTicketSaleEndDate = $eventDescription = $eventImage = "";
$organizerID = $_SESSION['onlineUserID'];
function unsetSessions(){
  unset($_SESSION['eventTitle']);
  unset($_SESSION['eventDate']);
  unset($_SESSION['eventTime']);
  unset($_SESSION['eventDuration']);
  unset($_SESSION['eventCateID']);
  unset($_SESSION['eventLocation']);
  unset($_SESSION['eventContact']);
  unset($_SESSION['eventType']);
  unset($_SESSION['eventTicketQty']);
  unset($_SESSION['ticketPrice']);
  unset($_SESSION['eventTicketSaleStartDate']);
  unset($_SESSION['eventTicketSaleEndDate']);
  unset($_SESSION['eventStatus']);
  unset($_SESSION['eventDescription']);

}

if (isset($_GET['eventID'])) {
    $eventID = $_GET['eventID'];
    $heading = "Edit Event";
$actionURL = "creatEvents.php?groupID=".$groupID."&eventID=".$eventID;

  if(getOrganizerGroupID($_SESSION['onlineUserID']) != $groupID){
   $_SESSION['eventErrMsg'] = "Event Edit Request Denied, Your are not organizer of this group event";
        header("location:../events.php");
        exit(); 
  }
      $sqlEvent = "SELECT * FROM `tbl_events` WHERE `event_id` = '$eventID'";
      $resultEvent = mysqli_query($con,$sqlEvent);
      if ($resultEvent) {
        if (mysqli_num_rows($resultEvent) == 1) {
          if($rowEvent = mysqli_fetch_array($resultEvent)){
            $eventImage = "../".$rowEvent['event_image'];
            $eventTitle = $rowEvent['event_name'];
            $eventLocation = $rowEvent['event_location'];
            $eventDate = $rowEvent['event_startDate'];
            $eventTime = $rowEvent['event_startTime'];
            $eventDuration =  $rowEvent['event_duration'];
            $eventContact = $rowEvent['event_contact'];
            $eventType = $rowEvent['event_type'];
            $ticketPrice = $rowEvent['event_ticketPrice'];
            $eventTicketQty = $rowEvent['event_totalTickets'];
            $eventRemaningSeats = $rowEvent['event_remainingTickets'];
            $eventTicketSaleStartDate = $rowEvent['event_ticketSaleStartDate']; 
            $eventTicketSaleEndDate =  $rowEvent['event_ticketSaleEndDate'];
            $eventDescription = $rowEvent['event_description'];
            $eventStatus = getStatusTitle($rowEvent['event_status']);
            $eventOrganizerID = $rowEvent['event_organizerID'];
            $eventGroupID = $rowEvent['event_groupID'];
            $eventCateID = $rowEvent['event_cateID'];

            
          }
        }
      }
}



if(!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0){
  $_SESSION['errors'] = array();
}

if (isset($_POST['eventAddedBtn'])) {
  if (empty($_POST['eventTitle'])) {
    array_push($_SESSION['errors'], " Name is Required");
  }else{
    $eventTitle = mysqli_real_escape_string($con,$_POST['eventTitle']);
    $_SESSION['eventTitle'] = $eventTitle;    
  }

  if (empty($_POST['eventDate'])) {
    array_push($_SESSION['errors'], " Event Date is Required");
  }else{
    $eventDate = $_POST['eventDate'];
$cdate = date("Y-m-d");
    $curdate=strtotime($cdate);
$mydate=strtotime($eventDate);

if($mydate < $curdate)
{
  array_push($_SESSION['errors'], " Event Date can't be less than current date");
 
}
    // if(strtotime($eventDate) < strtotime(date("mm-dd-yyyy"))){
    //   array_push($_SESSION['errors'], " Event Date can't be less than current date");

    // }
    $_SESSION['eventDate'] = $eventDate;    
  }
  

  if (empty($_POST['eventTime'])) {
    array_push($_SESSION['errors'], " Event Time is Required");
  }else{
    $eventTime = mysqli_real_escape_string($con,$_POST['eventTime']);
    $_SESSION['eventTime'] = $eventTime;    
  }


  if (empty($_POST['eventDuration'])) {
    array_push($_SESSION['errors'], " Event Duration is Required");
  }else{
    $eventDuration = mysqli_real_escape_string($con,$_POST['eventDuration']);
    if(!is_numeric($eventDuration)){
      array_push($_SESSION['errors'], "Please Enter Valid Event Duration e.g : 48");

    }
    $_SESSION['eventDuration'] = $eventDuration;    
  }
  if (empty($_POST['eventCateID'])) {
    array_push($_SESSION['errors'], " Event Category is Required");
  }else{
    $eventCateID = mysqli_real_escape_string($con,$_POST['eventCateID']);
    $_SESSION['eventCateID'] = $eventCateID;    
  }

  if (empty($_POST['eventLocation'])) {
    array_push($_SESSION['errors'], " Event location is Required");
  }else{
    $eventLocation = mysqli_real_escape_string($con,$_POST['eventLocation']);
    $_SESSION['eventLocation'] = $eventLocation;    
  }
  if (empty($_POST['eventDescription'])) {
    array_push($_SESSION['errors'], " Event Description is Required");
  }else{
    $eventDescription = mysqli_real_escape_string($con,$_POST['eventDescription']);
    $_SESSION['eventDescription'] = $eventDescription;    
  }
  

  if (empty($_POST['eventContact'])) {
    array_push($_SESSION['errors'], " Event Contact is Required");
  }else{
    $eventContact = mysqli_real_escape_string($con,$_POST['eventContact']);
    $_SESSION['eventContact'] = $eventContact;    
  }

  if (empty($_POST['eventType'])) {
    array_push($_SESSION['errors'], " Event Type is Required");
  }else{
    $eventType = mysqli_real_escape_string($con,$_POST['eventType']);
    $_SESSION['eventType'] = $eventType;    
  }

  if (empty($_POST['eventTicketQty'])) {
    array_push($_SESSION['errors'], " Event Ticket Qunatity is Required");
  }else{
    $eventTicketQty = mysqli_real_escape_string($con,$_POST['eventTicketQty']);

    if(!is_numeric($eventTicketQty) || $eventTicketQty == 0 || $eventTicketQty < 0){
      array_push($_SESSION['errors'], " Please Enter Valid Event Ticket Qunatity");

    }
    $_SESSION['eventTicketQty'] = $eventTicketQty;    
  }

  if($eventType == "P"){
    if (empty($_POST['ticketPrice'])) {
    array_push($_SESSION['errors'], " Event Ticket Price is Required");
  }else{
    $ticketPrice = mysqli_real_escape_string($con,$_POST['ticketPrice']);
    if ($ticketPrice == 0 || $ticketPrice < 0 || !is_numeric($ticketPrice)) {
          array_push($_SESSION['errors'], "Please Enter Valid Event Ticket Price");

    }
    $_SESSION['ticketPrice'] = $ticketPrice;    
  }
}else{
  $ticketPrice = 0;
}
  


  if (empty($_POST['eventTicketSaleStartDate'])) {
    array_push($_SESSION['errors'], " Event Ticket Sale Date is Required");
  }else{
    $eventTicketSaleStartDate = $_POST['eventTicketSaleStartDate'];
    $cdate1 = date("Y-m-d");
        $curdate1=strtotime($cdate);
    $mydate1=strtotime($eventTicketSaleStartDate);
    
    if($mydate1 < $curdate1)
    {
      array_push($_SESSION['errors'], " Event Ticket Sale Date can't be less than current date");
     
    }
    // if(strtotime($eventTicketSaleStartDate) < strtotime(date("m-d-Y"))){
    //   array_push($_SESSION['errors'], " Event Ticket Sale Date can't be less than current date");
    // }
    $_SESSION['eventTicketSaleStartDate'] = $eventTicketSaleStartDate;    
  }

  if (empty($_POST['eventTicketSaleEndDate'])) {
    array_push($_SESSION['errors'], " Event Ticket End Date is Required");
  }else{
    $eventTicketSaleEndDate = $_POST['eventTicketSaleEndDate'];
    // if(strtotime($eventTicketSaleEndDate) < strtotime(date("m-d-Y"))){
    //   array_push($_SESSION['errors'], " Event Ticket End Date can't be less than current date");
    // }
    
    $cdate2 = date("Y-m-d");
        $curdate2=strtotime($cdate);
    $mydate2=strtotime($eventTicketSaleEndDate);
    
    if($mydate2 < $curdate2)
    {
      array_push($_SESSION['errors'], " Event Ticket End Date can't be less than current date");
     
    }else if (strtotime($eventTicketSaleEndDate) < strtotime($eventTicketSaleStartDate)) {
      array_push($_SESSION['errors'], " Event Ticket End Date can't be less than Sale Start date");

    }
    $_SESSION['eventTicketSaleEndDate'] = $eventTicketSaleEndDate;    
  }

  //===================================
  if (empty($_POST['eventDate'])) {
    array_push($_SESSION['errors'], " Event Date is Required");
  } else {
    $eventDate = $_POST['eventDate'];
    $eventTicketSaleStartDate = $_POST['eventTicketSaleStartDate'];
    $eventTicketSaleEndDate = $_POST['eventTicketSaleEndDate'];

    $eventD = strtotime($eventDate);
    $eventTSSD = strtotime($eventTicketSaleStartDate);
    $evenTSED = strtotime($eventTicketSaleEndDate);

    if($eventD < $eventTSSD || $eventD < $evenTSED)
    {
      array_push($_SESSION['errors'], " Event data can't be less than Event Ticket Sale Date");
     
    }
  }

  if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {
    $createdBy = $_SESSION['onlineUserID'];
    $createdDate = date("Y-m-d h:i:s");
    if($eventID != ""){


      if (empty($_POST['eventStatus'])) {
    array_push($_SESSION['errors'], " Event Status Required");
  }else{
    $eventStatus = mysqli_real_escape_string($con,$_POST['eventStatus']);
   
    $_SESSION['eventStatus'] = $eventStatus;    
  }

    if( basename($_FILES["eventImage"]["name"] != "")){

            $target_dir = "../uploads/";
            $timestamp = time();
             $target_file = $target_dir . $timestamp.'-'.basename($_FILES["eventImage"]["name"]);
            $db_target_file = "uploads/". $timestamp.'-'.basename($_FILES["eventImage"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["eventImage"]["tmp_name"]);
            if($check !== false) {
                
              if (file_exists($target_file)) {
                  array_push($_SESSION['errors'], "Sorry, file already exists");
              }

              //Check file size
              if ($_FILES["eventImage"]["size"] > 500000) {
                  array_push($_SESSION['errors'], "File is too large");
              }


             if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                  array_push($_SESSION['errors'], "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
              }
              
              if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {

                  if (move_uploaded_file($_FILES["eventImage"]["tmp_name"], $target_file)) {
                      //your query with file path

                      if(file_exists($eventImage) ){
                        unlink($eventImage);
                      }
                       $sql = "UPDATE `tbl_events` SET `event_name` = '$eventTitle', `event_startDate` ='$eventDate', `event_startTime` = '$eventTime', `event_duration` = '$eventDuration',`event_image` = '$db_target_file', `event_cateID` = '$eventCateID', `event_location` = '$eventLocation',`event_contact` = '$eventContact', `event_type` = '$eventType',`event_ticketPrice` = '$ticketPrice',`event_totalTickets` =  '$eventTicketQty', `event_remainingTickets` = '$eventTicketQty',`event_ticketSaleStartDate` = '$eventTicketSaleStartDate', `event_ticketSaleEndDate` = '$eventTicketSaleEndDate', `event_organizerID` = '$organizerID', `event_groupID` = '$groupID',`event_status` = '$eventStatus', `event_description` = '$eventDescription', `updatedBy` = '$createdBy', `updatedDate` = '$createdDate' WHERE `event_id` = '$eventID'";
                    
                       $result = mysqli_query($con,$sql);
                        if ($result) {
                          unsetSessions();

                          $_SESSION['eventCreatedSuccessfullyMsg'] = "Group Event Updated Successfully";
                          header("location:SingleEventDetail.php?eventID=".$eventID);
                          exit();
                        }
                  } else {
                    array_push($_SESSION['errors'], "Sorry, there was an error uploading your file.");
                  }
              

              }

                    
              } else {
                array_push($_SESSION['errors'], "Please Upload Image File Only");
                 
              }
            
          }else{
                $sql = "UPDATE `tbl_events` SET `event_name` = '$eventTitle', `event_startDate` ='$eventDate', `event_startTime` = '$eventTime', `event_duration` = '$eventDuration', `event_cateID` = '$eventCateID', `event_location` = '$eventLocation',`event_contact` = '$eventContact', `event_type` = '$eventType',`event_ticketPrice` = '$ticketPrice',`event_totalTickets` =  '$eventTicketQty', `event_remainingTickets` = '$eventTicketQty',`event_ticketSaleStartDate` = '$eventTicketSaleStartDate', `event_ticketSaleEndDate` = '$eventTicketSaleEndDate', `event_organizerID` = '$organizerID', `event_groupID` = '$groupID',`event_status` = '$eventStatus', `event_description` = '$eventDescription', `updatedBy` = '$createdBy', `updatedDate` = '$createdDate' WHERE `event_id` = '$eventID'";
                    
                       $result = mysqli_query($con,$sql);
                        if ($result) {
                          unsetSessions();

                          $_SESSION['eventCreatedSuccessfullyMsg'] = "Group Event Updated Successfully";
                          header("location:SingleEventDetail.php?eventID=".$eventID);
                          exit();
                        }
          }

    }else{
      $eventStatus = "A";
    if( basename($_FILES["eventImage"]["name"] != "")){

            $target_dir = "../uploads/";
            $timestamp = time();
             $target_file = $target_dir . $timestamp.'-'.basename($_FILES["eventImage"]["name"]);
            $db_target_file = "uploads/". $timestamp.'-'.basename($_FILES["eventImage"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["eventImage"]["tmp_name"]);
            if($check !== false) {
                
              if (file_exists($target_file)) {
                  array_push($_SESSION['errors'], "Sorry, file already exists");
              }

              //Check file size
              if ($_FILES["eventImage"]["size"] > 500000) {
                  array_push($_SESSION['errors'], "File is too large");
              }


             if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                  array_push($_SESSION['errors'], "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
              }
              
              if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {

                  if (move_uploaded_file($_FILES["eventImage"]["tmp_name"], $target_file)) {
                      //your query with file path

                       $sql = "INSERT INTO `tbl_events` (`event_name`,`event_startDate`,`event_startTime`,`event_duration`,`event_image`,`event_cateID`,`event_location`,`event_contact`,`event_type`,`event_ticketPrice`,`event_totalTickets`,`event_remainingTickets`,`event_ticketSaleStartDate`,`event_ticketSaleEndDate`,`event_organizerID`,`event_groupID`,`event_status`,`createdBy`,`createdDate`,`event_description`) VALUES ('$eventTitle','$eventDate','$eventTime','$eventDuration','$db_target_file','$eventCateID','$eventLocation','$eventContact','$eventType','$ticketPrice','$eventTicketQty','$eventTicketQty','$eventTicketSaleStartDate','$eventTicketSaleEndDate','$organizerID','$groupID','$eventStatus','$createdBy','$createdDate','$eventDescription')";
                    
                       $result = mysqli_query($con,$sql);
                        if ($result) {
                          $eventID = mysqli_insert_id($con);
                          unsetSessions();
                          include("function/sub_email_sent.php");
                           $_SESSION['eventCreatedSuccessfullyMsg'] = "Group Event Updated Successfully";
                          header("location:SingleEventDetail.php?eventID=".$eventID);
                          exit();
                        }
                  } else {
                    array_push($_SESSION['errors'], "Sorry, there was an error uploading your file.");
                  }
              

              }

                    
              } else {
                array_push($_SESSION['errors'], "Please Upload Image File Only");
                 
              }
            
          }else{
                array_push($_SESSION['errors'], "Please Upload Image File");
             
          }  
    }
    

        
        
  }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title><?php echo $heading; ?></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />




    <link rel="stylesheet" href="creatEvents.css">
</head>

<body>

    <!----------------HEADER START-------------------------------->
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
      <div class="container">
        <a class="navbar-brand" href="../index.php">
          <img src="images/logo.png" class="logo-image" alt="Event Around">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto header-nav-link">
    <li class="nav-item active">
              <a class="nav-link" href="../index.pho">Home</a>
            </li>
   
    <li class="nav-item">
              <a class="nav-link" href="../Contact/Contact.php">Contact</a>
            </li>
    </ul>
    </div>
    </div>
    </nav>
      
      <!-- Page Content -->
      



    <!------------------------------------------HEADER FINISHED--------------------->

    <!-- ================CONTENT OF THE PAGE===================== -->

    <!-- ----------------Create Event-------------------- -->

    <div class="container" id="create-Event-form">
      <h1 class="text-center"><?php echo $heading; ?></h1>
        <h2 class="mt-4">1. Event Detail</h2>
         <form action="<?php echo $actionURL; ?>" method="POST" class="event-form" enctype="multipart/form-data">
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

            if(isset($_SESSION['eventTitle'])){
              $eventTitle = $_SESSION['eventTitle'];
            } 
            if(isset($_SESSION['eventDate'])){
              $eventDate = $_SESSION['eventDate'];
            } 
            if(isset($_SESSION['eventTime'])){
              $eventTime = $_SESSION['eventTime'];
            } 

            if(isset($_SESSION['eventDuration'])){
              $eventDuration = $_SESSION['eventDuration'];
            } 
            if(isset($_SESSION['eventCateID'])){
              $eventCateID = $_SESSION['eventCateID'];
            } 
            if(isset($_SESSION['eventLocation'])){
              $eventLocation = $_SESSION['eventLocation'];
            } 
            if(isset($_SESSION['eventContact'])){
              $eventContact = $_SESSION['eventContact'];
            } 
            if(isset($_SESSION['eventType'])){
              $eventType = $_SESSION['eventType'];
            } 
            if(isset($_SESSION['ticketPrice'])){
              $ticketPrice = $_SESSION['ticketPrice'];
            } 
            if(isset($_SESSION['eventTicketQty'])){
              $eventTicketQty = $_SESSION['eventTicketQty'];
            } 
            if(isset($_SESSION['eventTicketSaleStartDate'])){
              $eventTicketSaleStartDate = $_SESSION['eventTicketSaleStartDate'];
            } 

            if(isset($_SESSION['eventTicketSaleEndDate'])){
              $eventTicketSaleEndDate = $_SESSION['eventTicketSaleEndDate'];
            } 

            if(isset($_SESSION['eventDescription'])){
              $eventDescription = $_SESSION['eventDescription'];
            } 

          ?>
             <label for="">Title</label>
             <br>
             <input name="eventTitle" type="text" value="<?php echo $eventTitle; ?>" required>
             <br>
            <label for="date">Date and Start Time
              
            </label>
            <br>
            <input name="eventDate" type="date" value="<?php echo $eventDate; ?>" required>
            <input name="eventTime" type="time" value="<?php echo $eventTime; ?>" required>
            <br>
            <label for="">Duration</label>
            <br>
            <input name="eventDuration" type="text" value="<?php echo $eventDuration; ?>" required>
            <br>
            <label for="">Add Image</label><br>
            <input type="file" id="img" name="eventImage" accept="image/*">
            <?php if($eventImage != "../" && file_exists($eventImage)){
              ?>
              <br>
              <div style="width: 100px; height: 100px; border:1px solid #000000; border-radius:10px;">
                <img src="<?php echo $eventImage; ?>" style="width: 90px; height:90px; display: block; margin:auto; border-radius:10px; margin-top: 3px;">
              </div>
              <?php
            } ?>
        
            <br>


            <div class="ticket-form-controls">
              <span>Event Category</span>
              <br>
              <select name="eventCateID" id="" required> 
                <option value="" disabled selected hidden>Select the Category</option>
                 <?php $sqlCateData = "SELECT * FROM `tbl_categories` WHERE `status` = 'A' ORDER BY `id` DESC";
                      $resultCateData = mysqli_query($con,$sqlCateData);
                      if($resultCateData){
                          if(mysqli_num_rows($resultCateData)>0){
                             while ($rowCateData = mysqli_fetch_array($resultCateData)) {
                ?>
                              <option <?php if($eventCateID == $rowCateData['id']){echo "selected";} ?> value="<?php echo $rowCateData['id']; ?>"><?php echo $rowCateData['title']; ?></option>
                
                <?php }
              }
                } ?>
                          <option value="0">Others</option>
                
              </select>
            </div>
            <label for="">Location</label>
            <br>

            <input name="eventLocation" value="<?php echo $eventLocation; ?>" type="text" required> 
            <br>
           

            <label for="">Description</label>
            <br>
            <textarea name="eventDescription" rows="5"><?php echo $eventDescription; ?></textarea> 
            <br>
           
             <label for="">How to Contact us</label>
            <br>
            <input name="eventContact" type="text" value="<?php echo $eventContact; ?>" required><br>
            <!-- <label for="">Organizer Name</label><br>
            <input type="text" name="" id="" required><br>
            <label for="">Organizaer Description</label><br>
            <textarea name="comment" id="" cols="50" rows="5"></textarea> -->
            
              <!-- ------------------- Create Ticket---------------------------- -->
              <h2 class="mt-4">2. Tickets Details</h2>
              <div class="wrapper">
                <input <?php if($eventType == "P"){echo "checked";}  ?> type="radio" name="eventType" id="option-1" value="P" required>
                <input  <?php if($eventType == "F"){echo "checked";}  ?> type="radio" name="eventType" id="option-2" value="F" required>
               
                  <label for="option-1" class="option option-1">
                    <div class="dot"></div>
                     <span>Paid</span>
                     </label>
                  <label for="option-2" class="option option-2">
                    <div class="dot"></div>
                     <span>Free</span>
                  </label>
                  
               </div>

              <!--  <div class="ticket-form-controls">
                 <label for="ticket-name" id="ticket-name-label">Name</label>
                 <br>
                 <input type="text" name="" id="ticket-name" required>
               </div>
 -->

               <div class="ticket-form-controls">
                <label for="ticket-quantity">Available Quantity</label>
                <br>
                <input type="text" name="eventTicketQty" value="<?php echo $eventTicketQty; ?>" id="ticket-quantity" required>
              </div>

              <div class="ticket-form-controls">
                <label for="ticket-price">Price</label>
                <br>
                <input type="text" name="ticketPrice" value="<?php echo $ticketPrice; ?>" id="ticket-price" required>
              </div>



              
<br>
              <div class="ticket-form-controls">
                <div class="ticket-startDate-div">
                  <label for="ticket-startDate">Start Date</label><br>
                  <input type="date" name="eventTicketSaleStartDate" value="<?php echo $eventTicketSaleStartDate; ?>" id="ticket-startDate">
                </div>
                
              </div>

              <div class="ticket-form-controls">
                <div class="ticket-endDate-div">
                  <label for="ticket-endDate">End Date</label><br>
                  <input type="date" name="eventTicketSaleEndDate" value="<?php echo $eventTicketSaleEndDate; ?>" id="ticket-endDate">
                </div>
               
              </div>
               <?php if($eventID != ""){
                ?>

                <div class="clearfix"></div>
                <br><br>
                <div class="form-group">
                <label class="">Event Status</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="eventStatus" class="select2_group form-control">
                    
                      <option <?php if ($eventStatus == "A") { echo "selected"; } ?> value="A">Active</option>
                      <option <?php if ($eventStatus == "B") { echo "selected"; } ?> value="B">Block</option>
                    
                    
                    
                  </select>
                </div>
              </div>
                <?php
            } ?>
<br>
         <div class="ticket-form-controls submit-button-div">
               <input name="eventAddedBtn" type="submit">
             </div>
         </form>
      
       
         <!-- <h2 class="mt-4">3. Additional Details</h2> -->
      </div>

    

      <br>
      <!--==================== FOOTER OF THE PAGE =========================-->
     <?php include("../footer.php"); ?>
  
</body>

</html>