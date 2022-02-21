<?php
include("../connection.php");
include("../functions.php");
$eventID = "";
if (isset($_GET['eventID'])) {
  $eventID = $_GET['eventID'];

  $sqlEvent = "SELECT * FROM `tbl_events` WHERE `event_id` = '$eventID'";
  $resultEvent = mysqli_query($con,$sqlEvent);
  if ($resultEvent) {
    if (mysqli_num_rows($resultEvent) == 1) {
      if($rowEvent = mysqli_fetch_array($resultEvent)){
        $eventImage = "../".$rowEvent['event_image'];
        $eventName = $rowEvent['event_name'];
        $eventLocation = $rowEvent['event_location'];
        $eventStartDate = date("d F Y ",strtotime($rowEvent['event_startDate']));
        $eventStartTime = date("H:i A ",strtotime($rowEvent['event_startTime']));
        $eventDuration =  $rowEvent['event_duration']." hour(s)";;
        $eventContact = $rowEvent['event_contact'];
        $eventType = $rowEvent['event_type'];
        $eventTicketPrice = $rowEvent['event_ticketPrice']." PKR";
        $eventTotalSeats = $rowEvent['event_totalTickets'];
        $eventRemaningSeats = $rowEvent['event_remainingTickets'];
        $eventTicketSaleStartDate = date("d F Y ",strtotime($rowEvent['event_ticketSaleStartDate'])); 
        $eventTicketSaleEndDate =  date("d F Y ",strtotime($rowEvent['event_ticketSaleEndDate']));
        $eventDescription = $rowEvent['event_description'];
        $eventStatus = getStatusTitle($rowEvent['event_status']);
        $eventOrganizerID = $rowEvent['event_organizerID'];
        $eventGroupID = $rowEvent['event_groupID'];

        
      }
    }
  }
}else{

 header("location:../CreateEvents/SingleEventDetail.php?eventID".$eventID);
 exit();
}
function unsetSessions(){
  unset($_SESSION['userName']);
  unset($_SESSION['email']);
  unset($_SESSION['city']);
  unset($_SESSION['address']);
  unset($_SESSION['howToGetTicket']);
  unset($_SESSION['noOfTickets']);
  unset($_SESSION['paymentMethod']);
}

if(!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0){
  $_SESSION['errors'] = array();
}
$userName = $email = $city = $address = $howToGetTicket = $noOfTickets= $paymentMethod= "";
if(isset($_POST['submit'])){
    
    if (empty($_POST['name'])) {
        array_push($_SESSION['errors'], " Name is Required");
    }else{
        $userName = mysqli_real_escape_string($con,$_POST['name']);
        $_SESSION['userName'] = $userName;    
    }
    if (empty($_POST['email'])) {
        array_push($_SESSION['errors'], " Email is Required");
    }else{
        $email = mysqli_real_escape_string($con,$_POST['email']);
        $_SESSION['email'] = $email;    
    }
    if (empty($_POST['city'])) {
        array_push($_SESSION['errors'], " City is Required");
    }else{
        $city = mysqli_real_escape_string($con,$_POST['city']);
        $_SESSION['city'] = $city;    
    }
    if (empty($_POST['address'])) {
        array_push($_SESSION['errors'], " Address is Required");
    }else{
        $address = mysqli_real_escape_string($con,$_POST['address']);
        $_SESSION['address'] = $address;    
    }

    if (empty($_POST['howToGetTicket'])) {
        array_push($_SESSION['errors'], " How to get ticket is Required");
    }else{
        $howToGetTicket = mysqli_real_escape_string($con,$_POST['howToGetTicket']);
        $_SESSION['howToGetTicket'] = $howToGetTicket;    
    }
    if (empty($_POST['noOfTickets'])) {
        array_push($_SESSION['errors'], " No of ticket is Required");
    }else{
        $noOfTickets = mysqli_real_escape_string($con,$_POST['noOfTickets']);
        $_SESSION['noOfTickets'] = $noOfTickets;    
    }



    if($eventType == "P"){
        if (empty($_POST['paymentMethod'])) {
            array_push($_SESSION['errors'], " paymentMethod is Required");
        }else{
            $paymentMethod = mysqli_real_escape_string($con,$_POST['paymentMethod']);
            $_SESSION['paymentMethod'] = $paymentMethod;    
        }
    }



     if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {
        $createdBy = 0;
        $createdDate = date("Y-m-d h:i:s");
        $ticketStatus = "P";
        $ticketGroupOwnerNoti = 0;

        $sql = "INSERT INTO `tbl_event_tickets` (`event_ticket_eventID`,`event_ticket_userName`,`event_ticket_email`,`event_ticket_address`,`event_ticket_city`,`event_ticket_howToGet`,`event_ticket_totalTickets`,`event_ticket_paymentMethod`,`event_ticket_status`,`event_ticket_groupOnwerID`,`event_ticket_groupOnwerNoti`,`createdBy`,`createdDate`) VALUES ('$eventID','$userName','$email','$address','$city','$howToGetTicket','$noOfTickets','$paymentMethod','$ticketStatus','$eventOrganizerID','$ticketGroupOwnerNoti','$createdBy','$createdDate')";
        $result = mysqli_query($con,$sql);
        if ($result) {
            unsetSessions();
            $_SESSION['eventCreatedSuccessfullyMsg'] = "Ticket Purchase Request Sent Successfully";
            header("location:../CreateEvents/SingleEventDetail.php?eventID=".$eventID);
            exit();
        }

    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>TicketPurchase/EventsAround</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="TicketPurchasing.css">

</head>
<body>
<br>
<form action="TicketPurchasing.php?eventID=<?php echo $eventID; ?>" method="POST" id="Form">
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

            if(isset($_SESSION['userName'])){
              $userName = $_SESSION['userName'];
            }
            if(isset($_SESSION['address'])){
              $address = $_SESSION['address'];
            }  
            if(isset($_SESSION['city'])){
              $city = $_SESSION['city'];
            } 
            if(isset($_SESSION['email'])){
              $email = $_SESSION['email'];
            } 
            if(isset($_SESSION['howToGetTicket'])){
              $howToGetTicket = $_SESSION['howToGetTicket'];
            }

            if(isset($_SESSION['noOfTickets'])){
              $noOfTickets = $_SESSION['noOfTickets'];
            } 
            if(isset($_SESSION['paymentMethod'])){
              $paymentMethod = $_SESSION['paymentMethod'];
            } 

              ?>
    <div style="text-align: center;"><input id="FormTop" type="text" ><p><?php echo $eventName; ?>e</p></div>
<hr>
<div style="text-align:center;"><input id="FormTop" type="text" ><p>Details <br><?php echo "location : ". $eventLocation; ?> <br><?php echo "Event Date : ". $eventStartDate;  ?><br><?php echo "Event Time : ". $eventStartTime;  ?></p></div>

<hr>
    <br>

    <div class="row" >
        <div class="form-group">
            <div class="input-group" id="Name">
                <input id="Name" name="name" type="text" required class="form-control"  placeholder="Full Name*" value="<?php echo $userName; ?>">
            </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
           <div class="input-group">
             <input id="Email" type="email" required name="email" class="form-control" placeholder="Email*" value="<?php echo $email; ?>">
           </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
            <div class="input-group">
                <input id="Address" type="text" required name="address" class="form-control"  placeholder="Address*" value="<?php echo $address; ?>">
            </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
           <div class="input-group">
                <input id="City" type="text" required name="city" class="form-control" placeholder="City*" value="<?php echo $city; ?>">
            </div>
        </div>
      </div>
     <!--  <div class="row">
        <div class="form-group">
            <div class="input-group">
                <select id="Country" required >
                    <option>--Select Country--</option>
                    <option>Pakistan</option>
                    <option>India</option>
                </select>
            </div>
        </div>
      </div> -->
      <div class="row">
        <div class="form-group">
           <div class="input-group">
            <select name="howToGetTicket" id="HowToGetTickets" required >
                <option value="">How do you want to get your Tickets?*</option>
                <option <?php if($howToGetTicket == "A"){echo "selected";} ?> value="A">I will Pick them when I arrive at the Event</option>
                <option <?php if($howToGetTicket == "E"){echo "selected";} ?> value="E">Please Email them to my Address</option>
            </select>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
           <div class="input-group">
          <label id="QuantityLabel">Tickets Quantity </label> 
          <select name="noOfTickets" id="Select" required >
            <?php for ($i=1; $i <= $eventRemaningSeats ; $i++) { 
                ?>
                <option <?php if($noOfTickets == $i){echo "selected";} ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php
            } ?>
        </select>  
            </div>
        </div>
      </div>
      <?php if($eventType == "P"){
        ?>

      <div class="row">
        <div class="form-group">
           <div class="input-group">
            <label id="Total"> <b >Per Person Ticket Price Rs-/<?php echo $eventTicketPrice; ?> </b></label>  <!--   <input type="text" > Total will be show auto in this text box after calculation(style="border: none;")-->

            </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
           <div class="input-group">
             <p>Payment Meathod details with(Account numbers)</p>
            <label>Select Payment Method <b style="color: red;">*</b></label>
            <br>
            <i>Bank Transfer </i><input <?php if($paymentMethod == "BT"){echo "selected";} ?> value="BT" type="radio" name="paymentMethod">
            <br>
            <i>EasyPaisa </i><input <?php if($paymentMethod == "EP"){echo "selected";} ?> value="EP" type="radio" name="paymentMethod">
            <br>
            <i>Jazz Cash </i><input <?php if($paymentMethod == "JC"){echo "selected";} ?> value="JC" type="radio" name="paymentMethod">

            </div>
        </div>
      </div>

      <?php
      }else if($eventType == "F"){
        ?>
         <div class="form-group">
           <div class="input-group">
             <p>
                <b>This is Free of cost event</b>
             </p>
            </div>
        </div>
        <?php
      } ?>
<button class="button" id="PurchaseTicketbtn" name="submit" type="submit" ><span>Purchase Ticket</span> </button>

<br><br>
</form>


</body>
</html>