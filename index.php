<?php require("connection.php"); ?>
<?php require("functions.php"); ?>
<?php $groupID = ""; $totCount= 0;?>
<!DOCTYPE html>
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
  

  <link rel="stylesheet" href="Home/Home.css">
</head>

<style>

</style>
<body>

  <!--Header Start--->
<nav class="navbar  navbar-expand-md  navbar-dark" id="header">
  <a class="navbar-brand logo-link" href="index.php">
    <img src="Home/images/logo.jpg" class="logo-image" alt="Event Around">
  </a>
  <h4 id="NavWebName"><b>Events Around</b></h4>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar"style="margin-left:50%;"  >
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" id="NavLink" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="NavLink" href="group/group.php" >Groups</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="NavLink" href="Blog/Blog.php" >Blog</a>
      </li>  
      <li class="nav-item">
        <a class="nav-link" id="NavLink" href="Contact/Contact.php">Contact Us</a>
      </li> 
      
   </ul>
	  <ul class="nav navbar-nav navbar-right">
      <?php if(checkLogin() == false){ ?>
        <li><a href="Signup/Signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
        <li><a href="Login/Login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
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
                      $chatList = "chatList.php"; 
                      if(checkGroupExistAgainstOrganizerID($_SESSION['onlineUserID']) == 0){
                  ?>
                  <a class="dropdown-item" href="group/createGroup/createGroup.php">Create Group</a>

                  <?php  }else{
                    $groupID = getOrganizerGroupID($_SESSION['onlineUserID']);
                    ?>
                  <a class="dropdown-item" href="group/groupWebPage/groupWebPage.php?groupID=<?php echo $groupID; ?>">My Group</a>
                  <a class="dropdown-item" href="CreateEvents/events.php?groupID=<?php echo $groupID; ?>">My Event <?php if($totCount > 0){ ?> <span class="badge bg-green"><?php echo $totCount; ?></span> <?php } ?></a>

                    <?php
                  } 
                  }else if($_SESSION['onlineUserType'] == "U"){
                    $chatList = "chatListOrganizers.php";
                    ?>
                    <a class="dropdown-item" href="group/user_groups.php">My Groups</a>
                    <?php
                  } ?>
                  <a class="dropdown-item" href="<?php echo $chatList; ?>">Inbox  <span style="background: red; color: #ffffff;" class="badge counterInbox"></span></a>

                  <a class="dropdown-item" href="logout.php">Logout</a>
                  
                </div>
              </div>
      <?php } ?>
      
    </ul>
   
  </div>  
</nav>
<!--Header End-->

<!--Slider Start-->

<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
      <li data-target="#myCarousel" data-slide-to="4"></li>
  </ol>


  <!-- Wrapper for slides -->
  <div class="jumbotron">
  <div class="carousel-inner">


      <div class="item active">
          <img  src="Home/images/1.jpg"  style="width:100%; height:100%;">
          <div class="carousel-caption">
            <p id="SliderPara">Exclusive Events,Priceless Memories</p>
            
            <button id="Sliderbtn">Read More</button>
          </div>
      </div>

      <div class="item">
          <img  src="Home/images/2.jpg" style="width:100%; height:100%;">
          <div class="carousel-caption">
            <p id="SliderPara">Exclusive Events,Priceless Memories</p>
            
            <button id="Sliderbtn">Read More</button>
          </div>
      </div>

      <div class="item">
          <img  src="Home/images/3.jpg"  style="width:100%; height:100%;">
          <div class="carousel-caption">
            <p id="SliderPara">Exclusive Events,Priceless Memories</p>
            
            <button id="Sliderbtn">Read More</button>
          </div>
      </div>

      <div class="item">
          <img  src="Home/images/4.jpg"  style="width:100%; height:100%;">
          <div class="carousel-caption">
            <p id="SliderPara">Exclusive Events,Priceless Memories</p>
            
            <button id="Sliderbtn">Read More</button>
          </div>
      </div>

      <div class="item">
          <img  src="Home/images/5.jpg"  style="width:100%; height:100%;">
          <div class="carousel-caption">
            <p id="SliderPara">Exclusive Events,Priceless Memories</p>
            
            <button id="Sliderbtn">Read More</button>
          </div>
      </div>
      
    

  </div>

</div>
  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
  </a>
</div>
<!--Slider End-->


<!--BreadCrumb/Filter Events-->
<?php if ($groupID != "") {
  $actionURL = "CreateEvents/events.php?groupID=".$groupID;
}else{
  $actionURL = "CreateEvents/events.php";

} ?>
<form action="<?php echo $actionURL; ?>" method="POST">
<div class="breadcrumb" id="BreadCrumb">	
<h3>Filter Events</h3>
	<br>
	<div style="width:100%;">
    <div class="col-xs-8 col-sm-3 col-md-3 col-lg-3">
    <input type="text" class="form-control" id="SearchEvent" name="keywords" placeholder="Search Events" title="Search Event">
	</div>
  <div class="col-xs-8 col-sm-3 col-md-3 col-lg-3">
	<input type="text" class="form-control" id="Location" name="location" placeholder="Location">
</div>
 <div class="col-xs-8 col-sm-3 col-md-3 col-lg-3">
  <!-- <input type="text" class="form-control" id="Location" name="location" placeholder="Location"> -->
  <select name="eventType" style="position: relative;top: 15px;" class="form-control">
    <option value="">Select Event Type</option>
    <option value="F">Free</option>
    <option value="P">Paid</option>

  </select>
</div>

  <div class="col-xs-8 col-sm-3 col-md-3 col-lg-3">
  <input style="position: relative;top: 15px;" type="submit" class="form-control" name="searchEvents" placeholder="Location">
</div>
  </div>
</div>
<!--Breadcrumb End-->
</form>

<!---------------------Page Content Start-------------------->

<div class="container-fluid" id="Events">
<h1>Events</h1>
 
<?php 
$currentDate = date("Y-m-d");
$whereClause = " WHERE `event_status` = 'A' AND DATE(`event_startDate`) >= '$currentDate' "; 


$sql = "SELECT * FROM `tbl_events` ".$whereClause." ORDER BY `event_id` DESC LIMIT 5"; 
            $result = mysqli_query($con,$sql);
            if ($result) {
              if (mysqli_num_rows($result)>0) {
                while($row = mysqli_fetch_array($result)){ 


                  $eventImage = $row['event_image'];
                  $path = 'https://images.unsplash.com/photo-1483443487168-a49ed320d532?ixlib=rb-0.3.5&q=85&fm=jpg&crop=entropy&cs=srgb&s=25a13b3cccc5f22a2d4cb32c4171e3c4';
                  if($eventImage != '' && file_exists($eventImage)){
                    $path = $eventImage;
                  }


                  ?>
                  
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">                
<div class="event_container">
  <div class="event_bg" style="background-image: url('<?php echo $path; ?>')">
  </div>
  <div class="event_info">
    <div class="event_title">
      <h4><?php echo $row['event_name']; ?></h4>
    </div>
    <div class="event_desc">
      <p><?php if(strlen($row['event_description'])>100){
          echo substr($row['event_description'], 0,100)."....";
        }else{
          echo $row['event_description'];
        } ?></p>
    </div>
    <div class="event_footer">
      <div class="event_date">
        <p><?php echo date("d F Y ",strtotime($row['event_startDate'])); ?> & <?php echo date("d H:i A ",strtotime($row['event_startTime'])); ?></p>

      </div>
      <div class="event_more">
        <a href="CreateEvents/SingleEventDetail.php?eventID=<?php echo $row['event_id']; ?>" class="btn_more">
          learn more
        </a>
      </div>
    </div>
  </div>
</div>
</div>  
<?php }
}
} ?>
<!--Events Divs will be placed here-->


<div id="Categories">
  <div id='label-wrapper'>
  <h1>Categories</h1>
    <div id='Label1'>
      <?php $sqlCateData = "SELECT * FROM `tbl_categories` WHERE `status` = 'A' ORDER BY `id` DESC";
            $resultCateData = mysqli_query($con,$sqlCateData);
            if($resultCateData){
                if(mysqli_num_rows($resultCateData)>0){
                   while ($rowCateData = mysqli_fetch_array($resultCateData)) {
      ?>
                    <a href="CreateEvents/events.php?eventCateID=<?php echo $rowCateData['id']; ?>" class="category_botton text-center"><?php echo $rowCateData['title']; ?></a>
      
      <?php }
        }
      } ?>
       
    </div>

</div>
</div>
</div>
<!--------------------Page Content End------------------------->

<!--Footer Start-->
<?php include("footer.php"); ?>
<!--Footer End-->

</body>
</html>


