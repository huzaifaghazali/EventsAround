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



<!---------------------Page Content Start-------------------->

<div class="container-fluid" id="Events">
<h1>Chat List (Organizers)</h1>
 

<?php if(checkLogin() == false ){
  header("location:Login/login.php");
  exit();
} 

if($_SESSION['onlineUserType'] == "U"){
  $userID = $_SESSION['onlineUserID'];
}
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css">
<style type="text/css">
  .row{
    width: 100% !important;
  }
</style>
<div class="clearfix"></div>

        <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Chat Tables
                        </div>
                        <div class="panel-body">
                               <table  id="example" class="table table-striped custab">
                                    <thead>
                                        <tr>
                                            <th>Sr.NO</th>
                                            <th>Organizer Name</th>
                                            <th>Chat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $sql = "SELECT DISTINCT (`senderID`) as organizerID FROM `tbl_chat` WHERE `receiverID` = '$userID' ORDER BY `id` DESC";
                                      $result = mysqli_query($con,$sql);
                                        if($result){
                                          $srNo = 1;
                                          while ($row = mysqli_fetch_array($result)) {
                                              ?>
                                           <tr>
                                              <td class="align-middle"><?php echo $srNo; ?></td>
                                              <td>
                                                <?php echo getUserName($row['organizerID']); ?>
                                              </td>
                                             
                                             <td><a class='btn btn-danger btn-xs' href="group/groupWebPage/groupWebPage.php?groupID=<?php echo getOrganizerGroupID($row['organizerID']); ?>"><span class="fa fa-comments-o"></span> Chat <?php if (getChatNotifications($row['organizerID'],$userID) > 0 ) { ?>
                                             <span class="badge badge-light"><?php echo getChatNotifications($row['organizerID'],$userID); ?>
                                             </span> 
                                             <?php } ?></a></td>
                                         
                                      </tbody>
                                  <?php
                                        $srNo++;
                                    }
                                  }
                                 ?>

                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
</div>
<!--------------------Page Content End------------------------->

<!--Footer Start-->
<?php include("footer.php"); ?>
<!--Footer End-->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>

</body>
</html>


