<?php 
include("../connection.php");
include("../functions.php");
$eventID = "";
$totCount = 0;
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
        $eventStartTime = date("d H:i A ",strtotime($rowEvent['event_startTime']));
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

 header("location:events.php");
 exit();
}

if (isset($_GET['eventID']) && isset($_GET['status']) && isset($_GET['ticketID']) && isset($_GET['totTickets'])) {
 $eventID = $_GET['eventID'];
 $status = $_GET['status'];
 $ticketID = $_GET['ticketID'];
$totTickets = $_GET['totTickets'];
$remaningSeats = $eventRemaningSeats - $totTickets;

$sql = "UPDATE `tbl_events` SET `event_remainingTickets` = '$remaningSeats' WHERE `event_id` = '$eventID'";
if(mysqli_query($con,$sql)){
   $sql = "UPDATE `tbl_event_tickets` SET `event_ticket_status` = '$status' WHERE `event_ticket_id` = '$ticketID'";
 $result = mysqli_query($con,$sql);
 if ($result) {
   $_SESSION['eventCreatedSuccessfullyMsg'] = 'Ticket Resrvation status has been changed';
   header("location:SingleEventDetail.php?eventID=".$eventID);
   exit();
 }
}


}
?>
<html lang="en">
<head>
  <title>Home/EventsAround</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  
  

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  

  <link rel="stylesheet" href="SingleEventDetail.css">
</head>

<style>

</style>
<body>

<!--Header Start--->
<nav class="navbar  navbar-expand-md  navbar-dark" id="header">
  <a class="navbar-brand logo-link" href="../index.php">
    <img src="../Home/images/logo.jpg" class="logo-image" alt="Event Around">
  </a>
  <h4 id="NavWebName"><b>Events Around</b></h4>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar"style="margin-left:50%;"  >
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" id="NavLink" href="../index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="NavLink" href="../group/group.php" >Groups</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="NavLink" href="../Blog/Blog.php" >Blog</a>
      </li>  
      <li class="nav-item">
        <a class="nav-link" id="NavLink" href="../Contact/Contact.php">Contact Us</a>
      </li> 
      
   </ul>
	  <ul class="nav navbar-nav navbar-right">
      <?php if(checkLogin() == false){ ?>
        <li><a href="../Signup/Signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
        <li><a href="../Login/Login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      <?php }else{ ?>
        <div class="dropdown" style="position:relative; right: 20px; top: 10px;">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                  <?php if($_SESSION['onlineUserType'] == "O"){ ?>
                      Welcome Organizer -
                  <?php }else if($_SESSION['onlineUserType'] == "U"){ ?> 
                      Welcome User -

                  <?php } ?>
                  <?php echo  $_SESSION['onlineUserFullName']; ?>
                  <?php if(getTotCountTicketPurchase()>0){
                    $totCount = getTotCountTicketPurchase();
                    ?>
                    <span class="badge bg-green"><?php echo $totCount; ?></span>
                    <?php
                  } ?>
                </button>
                <div class="dropdown-menu">
                  <?php 
                    if($_SESSION['onlineUserType'] == "O"){ 
                      if(checkGroupExistAgainstOrganizerID($_SESSION['onlineUserID']) == 0){
                  ?>

                  <a class="dropdown-item" href="../group/createGroup/createGroup.php">Create Group</a>

                  <?php  }else{
                    $groupID = getOrganizerGroupID($_SESSION['onlineUserID']);
                    ?>

                  <a class="dropdown-item" href="../group/groupWebPage/groupWebPage.php?groupID=<?php echo $groupID; ?>">My Group</a>
                   <a class="dropdown-item" href="CreateEvents/events.php?groupID=<?php echo $groupID; ?>">My Event <?php if($totCount > 0){ ?> <span class="badge bg-green"><?php echo $totCount; ?></span> <?php } ?></a>

                    <?php
                  } 
                  } ?>
                  <a class="dropdown-item" href="../logout.php">Logout</a>
                  
                </div>
              </div>
      <?php } ?>
      
    </ul>
   
  </div>  
</nav>
<!--Header End-->

<!--Content Container start-->
<div class="container" id="ContentContainer">
<?php if(isset($_SESSION['eventCreatedSuccessfullyMsg'])){
        ?>
        <div class="alert alert-success">
          <?php echo $_SESSION['eventCreatedSuccessfullyMsg']; unset($_SESSION['eventCreatedSuccessfullyMsg']); ?>
        </div>
        <?php
      } ?>
  
 <div class="event_container" >
  <?php if($eventImage != "../" && file_exists($eventImage)){
    $bgImage = $eventImage;
  }else{
    $bgImage = "https://images.unsplash.com/photo-1483443487168-a49ed320d532?ixlib=rb-0.3.5&q=85&fm=jpg&crop=entropy&cs=srgb&s=25a13b3cccc5f22a2d4cb32c4171e3c4";
  } ?>
    <div class="event_bg" style="background-image: url('<?php echo $bgImage; ?>')">
    </div>
    <div class="event_info">
      
      <div class="event_title">
        <h4 style="width: 100%;">Event Title : <?php echo $eventName; ?>
          <?php if(isset($_SESSION['onlineUserID'])){
              if($eventOrganizerID == $_SESSION['onlineUserID']){
                ?>
          <a href="../CreateEvents/creatEvents.php?groupID=<?php echo $eventGroupID; ?>&eventID=<?php echo $eventID; ?>" class="btn btn-sm btn-success float-right">Edit Event</a>
        <?php } } ?>
        </h4>
      </div>
      <div class="">
        <div>Event Location : <a href="#" style="color: rgb(116, 116, 218); margin-left:10px;"><?php echo $eventLocation; ?></a></div> 
         <div>Event Duraion : <a href="#" style="color: rgb(116, 116, 218); margin-left: 10px;"><?php echo $eventDuration; ?></a></div>
        <div>Event Type : <a href="#" style="color: rgb(116, 116, 218); margin-left: 10px;"><?php if($eventType == "P"){echo "Paid"; }else if($eventType == "F"){echo "Free";} ?></a></div> 
         <div>Event Fee : <a href="#" style="color: rgb(116, 116, 218); margin-left: 10px;"><?php echo $eventTicketPrice; ?></a></div>

         <div>Event Total Seats : <a href="#" style="color: rgb(116, 116, 218); margin-left: 10px;"><?php echo $eventTotalSeats; ?></a></div>

         <div>Event Remaining Seats : <a href="#" style="color: rgb(116, 116, 218); margin-left: 10px;"><?php echo $eventRemaningSeats; ?></a></div>

          <div>Event Ticket Sale Start Date : <a href="#" style="color: rgb(116, 116, 218); margin-left: 10px;"><?php echo $eventTicketSaleStartDate; ?></a></div>

           <div>Event Ticket Sale End Date : <a href="#" style="color: rgb(116, 116, 218); margin-left: 10px;"><?php echo $eventTicketSaleEndDate; ?></a></div>
         
        
      </div>

      <div class="event_footer">
        <div class="event_date">
          <p>Event Date and Time : <?php echo $eventStartDate." & ".$eventStartTime; ?></p>
        </div>
        <div class="event_more">
            <?php if($eventRemaningSeats > 0){
              ?>
              <a href="../TicketPurchasing/TicketPurchasing.php?eventID=<?php echo $eventID; ?>" class="button" id="PurchaseTicketbtn" ><span>Purchase Ticket</span> </a>  
              <?php
            }else{
              ?>
              <button style="background:red !important; color:#ffffff;" class="button" id="PurchaseTicketbtn" type="submit" ><span>All Tickets Sold</span> </button>
              <?php
            }  ?>
            
        </div>
      </div>
    </div>
 </div>
 
 <h3><b>About this Event</b></h3>
 <div id="AboutEvent" class="container">
<p id="AboutEvent">
  <?php echo $eventDescription; ?>
</p>     
</div>


<div>
  <h3>Tickets Requests</h3>
  <table class="table table-hover table-striped table-bordered">
    <thead>
      <tr>
        <th>Srno</th>
        <th>Name</th>
        <th>Email</th>
        <th>Address</th>
        <th>City</th>
        <th>No of Tickets</th>
        <th>How to Recevice Ticket</th>
        <th>Payment Method</th>
        <th>Status</th>
        <?php 

        if (isset($_SESSION['onlineUserType'] )) {
              
         if($_SESSION['onlineUserType'] == "O"){  ?>
        <th>Action</th>
        <?php } } ?>

      </tr>
    </thead>
    <?php 
    $sql = "SELECT * FROM `tbl_event_tickets` WHERE `event_ticket_eventID` = '$eventID'"; 
    $result = mysqli_query($con,$sql);
    if ($result) {
      if(mysqli_num_rows($result)>0){
         if (isset($_SESSION['onlineUserType'] )) {
              
         if($_SESSION['onlineUserType'] == "O"){  
        $sqlUpdate = "UPDATE `tbl_event_tickets` SET `event_ticket_groupOnwerNoti` = '1' WHERE `event_ticket_eventID` = '$eventID' AND `event_ticket_groupOnwerNoti` = '0' ";
        mysqli_query($con,$sqlUpdate);
      }
    }

        $srNo =1;
        while($row = mysqli_fetch_assoc($result)){
          ?>
          <tr>
            <td><?php echo $srNo; ?></td>
            <td><?php echo $row['event_ticket_userName']; ?></td>
            <td><?php echo $row['event_ticket_email']; ?></td>
            <td><?php echo $row['event_ticket_address']; ?></td>
            <td><?php echo $row['event_ticket_city']; ?></td>
            <td><?php echo $row['event_ticket_totalTickets']; ?></td>
            <td><?php echo getTicketHowToGetTitle($row['event_ticket_howToGet']); ?></td>
            <td><?php echo getTicketReservationPaymentTitle($row['event_ticket_paymentMethod']); ?></td>
            <td><?php echo getStatusTicketReservationTitle($row['event_ticket_status']); ?></td>
            <?php  
            if (isset($_SESSION['onlineUserType'] )) {
              
            if($_SESSION['onlineUserType'] == "O"){  ?>
            <td>
              <?php if($row['event_ticket_status'] == "P"){
                ?>
                <a href="SingleEventDetail.php?eventID=<?php echo $eventID; ?>&status=A&ticketID=<?php  echo $row['event_ticket_id'];?>&totTickets=<?php echo $row['event_ticket_totalTickets']; ?>" class="btn btn-success">Confirm</a>  
                <?php
              } 
            }?>
              
            </td>
            <?php } ?>
            
          </tr>
          <?php
          $srNo++;
        }
      }else{
        echo "No Record Found";
      }
    }
    ?>

  </table>
</div>

</div>

<!--Content Container End-->

<!--Footer Start-->
<?php include("../footer.php"); ?>
<!--Footer End-->