<?php require("../../connection.php"); ?>
<?php require("../../functions.php"); 
$groupID = "";
$reviewMessage= "";



if(isset($_GET['groupID'])){
    $groupID = $_GET['groupID'];
    $whereClause = " WHERE `tbl_groups`.`group_id` = '$groupID' ";
    $sql = "SELECT `tbl_groups`.`group_id` , `tbl_groups`.`group_name`, `tbl_groups`.`group_location`, `tbl_groups`.`group_image`, `tbl_groups`.`group_description`,`tbl_groups`.`group_organizerID`,`tbl_groups`.`group_status`,`tbl_users`.`user_name`,`tbl_users`.`user_image`  FROM `tbl_groups` INNER JOIN `tbl_users` ON `tbl_groups`.`group_organizerID` = `tbl_users`.`user_id` ".$whereClause." ORDER BY `tbl_groups`.`group_id` DESC" ;
    $result = mysqli_query($con,$sql);
    if ($result) {
      if (mysqli_num_rows($result) == 1) {
        if ($row = mysqli_fetch_assoc($result)) {
          $groupName = $row['group_name'];
          $groupLocation = $row['group_location'];
          $groupDescription = $row['group_description'];
          $groupOrganizer = $row['user_name'];
          $groupOrganizerImage = "../../".$row['user_image'];
          $groupImage = "../../".$row['group_image'];
          $groupStatus = $row['group_status'];
          $groupOrganizerID = $row['group_organizerID'];
          
        }
      }
    }
}else{
  header("location:../../index.php");
  exit();
}

if(checkLogin() == true &&  $_SESSION['onlineUserType'] == "U" ){
  $uid = $_SESSION['onlineUserID'];
  $sql = "SELECT * From `tbl_group_members` WHERE `userID` = '$uid' AND `groupID` = '$groupID' AND `group_member_status` = 'B'";
  $res = mysqli_query($con,$sql);
  if($res){
    if(mysqli_num_rows($res)==1){
      $_SESSION['groupErrMsg'] = "You are blocked";
      header("location:../user_groups.php");
      exit();
    }
  }
 $receiverID = $groupOrganizerID;
 $senderID = $_SESSION['onlineUserID'];
}

if(isset($_GET['groupID']) && isset($_GET['groupJoin'])){
  if($_GET['groupJoin'] == 1){
    $groupID = $_GET['groupID'];
    $userID = $_SESSION['onlineUserID'];
    if(checkLogin() == true){
      if($_SESSION['onlineUserType'] == "U"){
        $createdBy = $_SESSION['onlineUserID'];
        $createdDate = date("Y-m-d h:i:s");
        $status = "A";
        $sql = "INSERT INTO `tbl_group_members` (`userID`,`groupID`,`group_member_status`,`createdDate`,`createdBy`) VALUES ('$userID','$groupID','$status','$createdDate','$createdBy')";
        $result = mysqli_query($con,$sql);
        if($result){
           $_SESSION['groupCreatedSuccessfullyMsg'] = "Group Joined Successfully";
            header("location:groupWebPage.php?groupID=".$groupID);
            exit();

        }

      }else{
        $_SESSION['groupJoinError'] = "Access Denied";
        header("location:groupWebPage.php?groupID=".$groupID);
        exit();

      }
    }
  }else{
    header("location:groupWebPage.php?groupID=".$groupID);
    exit();
  }
}




if(isset($_GET['groupID']) && isset($_GET['removeMe'])){
  if($_GET['removeMe'] == 1){
    $groupID = $_GET['groupID'];
    $userID = $_SESSION['onlineUserID'];
    if(checkLogin() == true){
      if($_SESSION['onlineUserType'] == "U"){
        $sql = "DELETE FROM `tbl_group_members` WHERE `userID` = '$userID' AND `groupID` = '$groupID'";
        $result = mysqli_query($con,$sql);
        if($result){
           $_SESSION['groupCreatedSuccessfullyMsg'] = "Successfully Removed";
            header("location:groupWebPage.php?groupID=".$groupID);
            exit();

        }

      }else{
        $_SESSION['groupJoinError'] = "Access Denied";
        header("location:groupWebPage.php?groupID=".$groupID);
        exit();

      }
    }
  }else{
    $_SESSION['groupJoinError'] = "Access Denied";
    header("location:groupWebPage.php?groupID=".$groupID);
    exit();
  }
}


if(isset($_GET['groupID']) && isset($_GET['userID']) && isset($_GET['status'])  ){
  $groupID = $_GET['groupID'];
  $userID = $_GET['userID'];
  $status = $_GET['status'];

  $sql = "UPDATE `tbl_group_members` SET `group_member_status` = '$status' WHERE `userID` = '$userID' AND `groupID` = '$groupID'";
  $result = mysqli_query($con,$sql);
  if($result){
     $_SESSION['groupCreatedSuccessfullyMsg'] = "Successfully Status Updated";
      header("location:groupWebPage.php?groupID=".$groupID);
      exit();

  }
  
}
if (isset($_GET['deleteReview']) && isset($_GET['groupID'])) {
    $groupID = $_GET['groupID'];
    $deleteReview = $_GET['deleteReview'];
    if($deleteReview == "1"){
        $reviewCustomerID = $_SESSION['onlineUserID'];
        $sql = "DELETE FROM `tbl_reviews` WHERE `review_userID` = '$reviewCustomerID' AND `review_groupID` = '$groupID'";
        $result = mysqli_query($con,$sql);
        if ($result) {
            $_SESSION['reviewMessageSuccess'] = "Review Deleted Successfully";
        header("location:groupWebPage.php?groupID=".$groupID);
        exit();
        }
    }
}

if(isset($_POST['reviewBtn'])){
  if (empty($_POST['reviewMessage'])) {
   $_SESSION['errorReview'] = "Review Message is Required.";
  }else{
    $reviewMessage = mysqli_real_escape_string($con,$_POST['reviewMessage']);
    $_SESSION['reviewMessage'] = $reviewMessage;
  }

  if(!isset($_SESSION['errorReview']) || $_SESSION['errorReview']){
    $reviewDate = date("Y-m-d h:i:s");
    $reviewUserID = $_SESSION['onlineUserID'];
    if($_POST['updateReview'] == "0"){
       $sql = "INSERT INTO `tbl_reviews` (`review_groupID`,`review_userID`,`review_message`,`review_date`) VALUES ('$groupID','$reviewUserID','$reviewMessage','$reviewDate')";
       $_SESSION['reviewMessageSuccess'] = "Review Added Successfully";
      
   
    }else if($_POST['updateReview'] == "1"){
        $sql = "UPDATE `tbl_reviews` SET `review_message` = '$reviewMessage' WHERE `review_userID` = '$reviewUserID' AND `review_groupID` = '$groupID'";
         $_SESSION['reviewMessageSuccess'] = "Review Updated Successfully";
       
    }
  
    $result = mysqli_query($con,$sql);
    if ($result) {
      unset($_SESSION['reviewMessage']);
      header("location:groupWebPage.php?groupID=".$groupID);
      exit();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Information</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  
  

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>  -->

    <link rel="stylesheet" href="groupWebPage.css">
    <style>
.organizerMessage
{
border: 2px solid #dedede;
/*background-color: #f1f1f1;*/
background: #5a1212;
border-radius: 5px;
padding: 5px;
width: 200px;
padding-bottom: 0;
margin-top: 10px;
margin-bottom: 10px;
}

.usermessage
{
  border: 2px solid #dedede;
  border-color: #ccc;
  /*background-color: #ddd;*/
  background: #db3f3c;
  border-radius: 5px;
  padding: 3px;
  width: 210px;
  float: right;
  padding-bottom: 0;
  margin-bottom: 10px;
  margin-top: 10px;
  margin-right:3px;
}

.usermessage p,.organizerMessage p{
  color: #ffffff;
  /*padding: 10px;*/
}
.time-right{
  /*float: right;*/
  /*margin-right: 5px;*/
  padding: 10px;
  color: yellow;
}
</style>
<!-- DataTables -->
<link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.css">

</head>
<body>
    <!-- =========================CONTENT OF THE PAGE======================== -->
    <div class="container-fluid">
      <?php 
      if (isset($_SESSION['groupCreatedSuccessfullyMsg'] )) {
          ?>
          <div class="alert alert-success">
            <?php echo $_SESSION['groupCreatedSuccessfullyMsg'] ; unset($_SESSION['groupCreatedSuccessfullyMsg'] ); ?>
          </div>
          <?php
        } ?>

        <?php if(isset($_SESSION['groupJoinError'])){
          ?>
          <div class="alert alert-danger">
            <?php echo $_SESSION['groupJoinError']; unset($_SESSION['groupJoinError']); ?>
          </div>
          <?php
        } ?>
      <div class="row group-description">
        <div class="col image-div">
          <?php 

          if($groupImage !="../../" && file_exists($groupImage)){
            ?>

          <img src="<?php echo $groupImage; ?>" alt="">
            <?php

          }else{
            ?>

          <img src="https://images.pexels.com/photos/169573/pexels-photo-169573.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" alt="">
            <?php
          } ?>
        </div>
        
        <div class=" col description-div">
            <h1> <?php echo $groupName; ?> 
            <?php if(isset($_SESSION['onlineUserID'])){
              if($groupOrganizerID == $_SESSION['onlineUserID']){
                ?>
                <a href="../createGroup/createGroup.php?groupID=<?php echo $groupID; ?>" class="float-right btn btn-sm btn-success">Edit Group Infomation</a>
                <?php
              }
            }

            if (isset($_SESSION['reviewMessageSuccess'])) {
                ?>
                <div class="alert alert-success">
                  <?php 
                    echo $_SESSION['reviewMessageSuccess'];
                    unset($_SESSION['reviewMessageSuccess']); 
                  ?>
                </div>
                <?php
              }

               if(isset($_SESSION['errorReview'])){
                ?>
                <div class="alert alert-danger">
                  <?php echo $_SESSION['errorReview']; unset($_SESSION['errorReview']); ?>
                </div>
                <?php
              }

             ?>
            
          </h1>
            <p> <i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $groupLocation; ?></p>
            <p> 
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
              <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
              <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
              <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
            </svg>
            Group member : <b><?php echo countGroupMembers($groupID); ?></b> 
             <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
              <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
            </svg> -->
          </p>
            <p> 
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
              <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
            </svg>
            Organized By : <?php echo $groupOrganizer; ?>
          </p>

            <div class="row share-div">
              <p>Share  
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
              </svg>
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
              </svg>
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
              </svg>
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
              </svg>
            </p>
            </div>
          </div>
        
        
      </div>

      <div class="group-controls">
          <div class="stripe">
        <ul>
          <li><a href="#about">About</a></li>
          <li><a href="../../CreateEvents/events.php?groupID=<?php echo $groupID; ?>">Event</a></li>
          <?php  
          if(isset($_SESSION['onlineUserType'])){
          if($_SESSION['onlineUserType'] == "O"){  

           ?>
          <li><a href="#membersTbl">Members</a></li>
        <?php } }
         ?>
          <!-- <li><a href="#discussions">Discussions</a></li> -->
          
        </ul>
         
      </div>
       <?php if(checkLogin() == true){ 
        if($_SESSION['onlineUserType'] == "U"){ 
      ?>
        <div class="button-div">
          <div  class="stripe">
            <?php if(checkAlreadyMember($_SESSION['onlineUserID'],$groupID) == 1){
              ?>
              <a href="groupWebPage.php?groupID=<?php echo $groupID; ?>&removeMe=1" id="removeJoinGroup"><span>Remove Me From this Group</span></a>
              <?php
            }else{
              ?>
              <a id="joinGroup" href="groupWebPage.php?groupID=<?php echo $groupID; ?>&groupJoin=1"><span>Join This Group</span></a>
              <?php
            } ?>
            
          </div>
        </div>
      <?php } 
      } ?>
    </div>
 
    

    <div class="container">
     <div class="event-member">
       <div class="event-column">
         <!-- <h1>hello</h1>
         <h1>hello</h1>
         <h1>hello</h1> -->
        <section class="intro-section" id="about">
          <h2 class="bg-dark p-2 text-white">What we are about</h2>
          <p><?php echo $groupDescription; ?></p>
          <!-- <button>read more</button> -->
        </section>
        <section>
          <h3 class="bg-dark p-2 text-white">Upcoming events
          <?php echo $groupName; ?> 
            <?php if(isset($_SESSION['onlineUserID'])){
              if($groupOrganizerID == $_SESSION['onlineUserID']){
                ?>
                <a href="../../CreateEvents/creatEvents.php?groupID=<?php echo $groupID; ?>" class="float-right btn btn-sm btn-success">Add New Event</a>
                <?php
              }
            } ?>
            <a href="../../CreateEvents/events.php?groupID=<?php echo $groupID; ?>" class="float-right btn btn-sm btn-info  mr-2">View All Event</a></h3>

            <?php
            $currentDate = date("Y-m-d");

            $sql = "SELECT * FROM `tbl_events` WHERE `event_groupID` = '$groupID' AND `event_status` = 'A' AND DATE(`event_startDate`) >= '$currentDate' ORDER BY `event_id` DESC LIMIT 5"; 
            $result = mysqli_query($con,$sql);
            if ($result) {
              if (mysqli_num_rows($result)>0) {
                while($row = mysqli_fetch_array($result)){
                  $eventImage = "../../".$row['event_image'];
                  $path = 'https://images.unsplash.com/photo-1483443487168-a49ed320d532?ixlib=rb-0.3.5&q=85&fm=jpg&crop=entropy&cs=srgb&s=25a13b3cccc5f22a2d4cb32c4171e3c4';
                  if($eventImage != '../../' && file_exists($eventImage)){
                    $path = $eventImage;
                  }
                  ?>
                  <div class="event_container">
                    <div class="event_bg" style="background-image: url('<?php echo $path; ?>')"></div>
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
                          <p><?php echo date("d F Y ",strtotime($row['event_startDate'])); ?></p>
                        </div>
                        <div class="event_more">
                          <a href="../../CreateEvents/SingleEventDetail.php?eventID=<?php echo $row['event_id']; ?>" class="btn_more">
                            learn more
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                }
              }else{
                ?>
                <div class="alert alert-info">No Group Event(s) Found</div>
                <?php
              }
            }

            ?>

          
        </section>

         
        <section>
          <h3 class="bg-dark p-2 text-white"> Reviews of <?php echo $groupName; ?>  </h3>
            
          <div style="height: 300px; overflow-y:scroll;">
            <?php 
            $sqlReview = "SELECT `tbl_reviews`.*,`tbl_users`.`user_id`,`tbl_users`.`user_name`,`tbl_users`.`user_image` FROM `tbl_reviews` INNER JOIN `tbl_users` ON `tbl_reviews`.`review_userID` = `tbl_users`.`user_id` WHERE `review_groupID` = '$groupID' ORDER BY `tbl_reviews`.`review_id`";
            $resultReview = mysqli_query($con,$sqlReview);
            if ($resultReview) {
              if (mysqli_num_rows($resultReview)>0) {
                while($reviewRow = mysqli_fetch_array($resultReview)){
                  $userImagePath = "../../".$reviewRow['user_image'];
                  ?>

                  <h4>
                      <?php if($userImagePath != "../../" && file_exists($userImagePath)){ ?><img src="<?php echo  $userImagePath; ?>"  style="width:50px; height: 50px; border-radius: 100px;">
                      <?php }else{
                        ?>
                        <img src="../../users.png" style="width:50px; height: 50px; border-radius: 100px;">
                        <?php
                      } ?>
                      <?php echo $reviewRow['user_name']; ?> <small><?php echo date("d-m-Y",strtotime($reviewRow['review_date'])); ?></small></h4>
                  
                  <p class="p-4 text-justify">
                    
                    <?php echo $reviewRow['review_message']; ?>
                  </p>
                  <?php
                }
              }else{
                ?>
                <div class="alert alert-info">No Review(s) Found</div>
                <?php
              }
            }
            ?>
          </div>
          <?php 
         if(checkLogin() == true){ 
            if($_SESSION['onlineUserType'] == "U"){  

             
              
          ?>
          <div>
            <?php if(checkAlreadyMember($_SESSION['onlineUserID'],$groupID) == 1){ 
              $myID = $_SESSION['onlineUserID'];
              $reviewMessage = "";
              $sqlMyReview = "SELECT * FROM `tbl_reviews`  WHERE `review_groupID` = '$groupID' AND `review_userID` = '$myID'";
            $resultMyReview = mysqli_query($con,$sqlMyReview);
            if ($resultMyReview) {
              if (mysqli_num_rows($resultMyReview)== 1) {
                if($rowMyReview = mysqli_fetch_array($resultMyReview)){
                  $reviewMessage = $rowMyReview['review_message'];
                }
              }
            }
              //if(checkUserReviweExistAgainstGroup($_SESSION['onlineUserID'],$groupID) == 0){ ?>
                <br>
              <form action="groupWebPage.php?groupID=<?php echo $groupID; ?>" method="POST">
                <div class="form-group">
                  <?php if($reviewMessage != ""){
                        $updateReview = 1;
                    }else{
                        $updateReview = 0;
                    }
                    ?>
                    <input type="hidden" name="updateReview" value="<?php echo $updateReview; ?>">
                  <label>Review Message&nbsp; <?php if($reviewMessage != ""){ ?><a class="btn btn-sm btn-danger " style="float: right;" href="groupWebPage.php?groupID=<?php echo $groupID; ?>&deleteReview=1">Delete My Review</a><?php } ?></label>
                  <textarea required class="form-control" placeholder="Enter your Review Member" id="reviewMessage" name="reviewMessage" rows="5"><?php echo $reviewMessage; ?></textarea>
                </div>
                <div class="form-group">
                  <input type="submit" name="reviewBtn" class="btn btn-success btn-sm float-right" value="Submit Review">
                </div>
                <br><br>
              </form>
            <?php  //}else{
              ?>
             <!--  <div class="alert alert-info">You Already Submitted Your Review Against This group.</div> -->
              <?php
            //}
          } ?>
          </div>
     <?php } } ?>
        </section>
       
        <?php if(isset($_SESSION['onlineUserID'])){
                    if($groupOrganizerID == $_SESSION['onlineUserID']){
                    
          if(checkLogin() == true){ 
        if($_SESSION['onlineUserType'] == "O"){ 
     
        $sqlMemebers = "SELECT `tbl_group_members`.`groupID`,`tbl_group_members`.`group_member_status`,`tbl_group_members`.`userID`,`tbl_users`.`user_name`,`tbl_users`.`user_image`,`tbl_users`.`user_id`  FROM `tbl_group_members` 
        INNER JOIN `tbl_users` ON `tbl_group_members`.`userID` = `tbl_users`.`user_id` WHERE `tbl_group_members`.`groupID` = '$groupID' ";
          $resultMembers = mysqli_query($con,$sqlMemebers);
          if($resultMembers){
            if(mysqli_num_rows($resultMembers)>0){
              ?>

        <section id="members">
          <h2>Group Members</h2>
          <table id="membersTbl" class="table table-hover table-striped table-bordered">
            <thead>
              <th>SrNo</th>
              <th>Member Image</th>
              <th>Member Name</th>
              <th>Status</th>
              <?php if(isset($_SESSION['onlineUserID'])){
              if($groupOrganizerID == $_SESSION['onlineUserID']){
                ?>
              <th>Action</th>
              <?php }
              } ?>

            </thead>
            <tbody>
              <?php 
              $srNo = 1;
              while($row =  mysqli_fetch_array($resultMembers)){
                $userImagPath = "../../".$row['user_image'];
                ?>
                <tr>
                    <td><?php echo $srNo; ?></td>
                    <td>
                      <?php if($userImagPath != "../../" && file_exists($userImagPath)){ ?>
                        <img src="<?php echo $userImagPath; ?>"  title="<?php echo $userName; ?>" alt="" class="members">
                  
                      <?php }else{ ?>
                          <img src="../../uploads/users.png" title="<?php echo $userName; ?>" alt="" class="members">
              
                      <?php } ?>

                    </td>
                    <td><?php echo $row['user_name']; ?></td>
                    <td><?php echo getStatusTitle($row['group_member_status']); ?></td>
                    <?php if(isset($_SESSION['onlineUserID'])){
                    if($groupOrganizerID == $_SESSION['onlineUserID']){
                      ?>
                    <td>
                      <?php if($row['group_member_status'] == "B"){
                        ?>
                        <a href="groupWebPage.php?groupID=<?php echo $groupID; ?>&userID=<?php echo $row['user_id']; ?>&status=A" class="btn btn-success btn-sm">Active</a>
                        <?php
                      }else if($row['group_member_status'] == "A"){
                        ?>
                        <a href="groupWebPage.php?groupID=<?php echo $groupID; ?>&userID=<?php echo $row['user_id']; ?>&status=B" class="btn btn-danger btn-sm">Block</a>
                        <?php
                      } ?>
                      
                    </td>
                      <?php }
                      } ?>

                  </tr>
                <?php
                $srNo++;
              } ?>
              
            </tbody>
          </table>
        </section>
        <?php
            }else{
              ?>
              <div class="alert alert-info">No Member(s) Found</div>
              <?php
            }
          }
        }
      }
        ?>
        
       </div>
       <div class="member-column">
        <h2>Organizer</h2>
        <div class="team-member">
          <?php if($groupOrganizerImage != "../../" && file_exists($groupOrganizerImage)){
            ?>

          <img src="<?php echo $groupOrganizerImage; ?>" title="<?php echo $groupOrganizer; ?>" alt="<?php echo $groupOrganizer; ?>" class="members">
            <?php
          }else{
            ?>

          <img title="<?php echo $groupOrganizer; ?>" alt="<?php echo $groupOrganizer; ?>" src="https://images.unsplash.com/flagged/photo-1574282893982-ff1675ba4900?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1000&q=80" alt="" class="members">
            <?php
          } ?>
         </div>
          <h2>Group memebers</h2>
         <div class="team-member">
          <?php 
          $sqlMemebers = "SELECT `tbl_group_members`.`groupID`,`tbl_group_members`.`userID`,`tbl_users`.`user_name`,`tbl_users`.`user_image`  FROM `tbl_group_members` INNER JOIN `tbl_users` ON `tbl_group_members`.`userID` = `tbl_users`.`user_id` WHERE `tbl_group_members`.`groupID` = '$groupID' LIMIT 10";
          $resultMembers = mysqli_query($con,$sqlMemebers);
          if($resultMembers){
            if(mysqli_num_rows($resultMembers)>0){
              while($row = mysqli_fetch_array($resultMembers)){
                $userImagPath = "../../".$row['user_image'];
                $userName = $row['user_name'];

                if($userImagPath != "../../" && file_exists($userImagPath)){
                  ?>
                  <img src="<?php echo $userImagPath; ?>"  title="<?php echo $userName; ?>" alt="" class="members">
                  
                  <?php
                }else{
                  ?>
                  <img src="../../uploads/users.png" title="<?php echo $userName; ?>" alt="" class="members">
          
                  <?php
                }

              }

            }else{
              echo "<b>No Member(s) Found</b>";
            }
          }
        }
      }
          ?>
          
         </div>
         <hr>
        <?php if (checkLogin() == true && $_SESSION['onlineUserType'] == "U") { ?>
          <?php 

                   
                        $user_ID = $_SESSION['onlineUserID']; 
                        $organizerID = $groupOrganizerID;

                         $sql2 = "UPDATE `tbl_chat` SET `receverReadNoti` = '1' WHERE `receiverID` = '$user_ID' AND `senderID` = '$organizerID' AND `receverReadNoti` = '0'";
                         $result2 = mysqli_query($con,$sql2);
                       
                    $senderID = $receiverID = "";
                    if(isset($_SESSION['onlineUserID'])) {
                        $senderID = $_SESSION['onlineUserID'];
                    }   
                    $receiverID = $groupOrganizerID;
                    

                     ?>

         <div class="team-member">
           <div class="col-md-12 col-sm-12">                                 
              <h2 class="submit-step"> 
                <i style="color:#db3636;" class="fa fa-comments-o" aria-hidden="true"></i>
                Chat with <small style="color:#db3636;">Organizer</small></h2>
                <hr>
               <div style="padding-top:0;padding-left: 20px;" class="submit-step">
             
                <div id="chatDiv" style="height:230px; overflow:scroll; overflow-x: hidden;">
                <?php 
                 $sql = "SELECT * FROM `tbl_chat`  WHERE 
                  (`senderID` ='$senderID' and `receiverID` = '$receiverID')
                  OR
                  (`receiverID` = '$senderID' and `senderID` = '$receiverID')";
                  $result=mysqli_query($con,$sql);
                  $n=1;

                       while($row=mysqli_fetch_assoc($result))
                                { 

                                    if($row['senderID'] == $senderID){
                                        $class = "usermessage";
                                        $userName = $_SESSION['onlineUserFullName'];
                                        $userImage = "../../".getUserProfileImage($senderID);
                                        if($userImage == "../../" OR !file_exists($userImage)){
                                          $userImage = "../../uploads/users.png";
                                        }
                                        
                                    }

                                    if($row['receiverID'] == $senderID){
                                        $class = "organizerMessage";
                                        $userImage = "../../".getUserProfileImage($receiverID);
                                        if($userImage == "../../" OR !file_exists($userImage)){
                                          $userImage = "../../uploads/users.png";
                                        }
                                        $userName = getUserName($receiverID);
                                        echo "<div class='clearfix'></div>";
                                    }
                              ?>
                                 <div  class= "<?php echo $class; ?>">
                                  <p style="margin: 10px 0 10px 0;"> <img style="width: 35px; height: 35px; margin-right: 10px; padding: 5px" class="img-circle" src="<?php echo $userImage; ?>" /><?php echo $userName; ?> </p>
                                   <p style="padding-left: 10px;"><?php echo $row['message']; ?></p>

                                  <?php 
                                    $chatDateTime=strtotime($row['createdTime']);
                                    $cDate =  date("d-m-Y", $chatDateTime); 
                                    $cTime =  date("h:i A", $chatDateTime);
                                ?>
                                  <span class="time-right"><?php echo  $cDate ." - ". $cTime;  ?></span>
                                  <br><br>
                                </div>

                                <div class="clearfix"></div>
                                 <?php
                              }

                              ?>
                           

                 
                  <!-- <div class="usermessage">
                    <p style="margin: 10px 0 10px 0;"> <img style="width: 35px; height: 35px; margin-right: 10px; padding: 5px" class="img-circle" src="https://images.unsplash.com/photo-1541647376583-8934aaf3448a?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=934&q=80">Aimen Raja </p>
                    <p style="padding-left: 10px;">hi, how are you?</p>
                    <span class="time-right">24-05-2021 - 02:24 AM</span>
                    <br><br>
                </div>
                <div class="clearfix"></div>
                  <div class="clearfix"></div>   
                    <div class="organizerMessage">
                      <p style="margin: 10px 0 10px 0;"> <img style="width: 35px; height: 35px; margin-right: 10px; padding: 5px" class="img-circle" src="https://images.unsplash.com/photo-1541647376583-8934aaf3448a?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=934&q=80">Mustafa Khan </p>
                      <p style="padding-left: 10px;">hi, how are you?</p>
                       <span class="time-right">24-05-2021 - 02:24 AM</span>
                       <br><br>
                    </div>
                    <div class="clearfix"></div> -->
                  </div>



                <form action="javascript:;" role="form" id="form-contact-agent" method="post" class="clearfix">

                    <div class="panel-footer">
                      <div class="input-group">
                        <input id="msg" type="text" class="form-control input-sm chat_input" placeholder="Write your message here...">
                        <span class="input-group-btn">
                          <input type="hidden" id="senderID_input" value="<?php echo $senderID; ?>">
                          <input type="hidden" id="receiverID_input" value="<?php echo $receiverID; ?>">


                        <button type="button" onclick="sendMsg(<?php echo $senderID; ?>,<?php echo $receiverID; ?>);" class="btn btn-primary btn-sm" id="btn-chat">Send</button>
                        </span>
                    </div>
                  </div>                        
                </form>
            
       
              </div>
            </div>
         </div>
       <?php } ?>
       </div>
     </div>
    </div>
  </div>
  <section id="footer" class="footer-section">
    <div class="container">
      <div class="row Upper-footer">
        <div class ="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <br>
        <p><b>Create your own Event group</b>
        <button id="footerbtn"><a href="createGroup/createGroup.php">Get Started</a></button></p>
    
        </div>
        
      </div>
      <hr class="footer-line">
  
      <br>
  
      <div class="row text-center text-xs-center text-sm-left text-md-left">
        <div class="col-xs-12 col-sm-4 col-md-4">
          <h5>Your Accounts</h5>
          <ul class="list-unstyled quick-links">
            <li><a href="../../Signup/Signup.php" target="_blank">Sign in</a></li>
            <li><a href="../../Login/Login.php" target="_blank">Log in</a></li>
          </ul>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
          <h5>Discover</h5>
          <ul class="list-unstyled quick-links">
            <li><a href="../../group/group.html" target="_blank">Group</a></li>
            <li><a href="../../CreateEvents/creatEvents.html" target="_blank">Create Events</a></li>
            <li><a href="">Calender</a></li>
      
          </ul>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
          <h5>Quick links</h5>
          <ul class="list-unstyled quick-links">
            <li><a href="http://localhost/events_org_R/Contact/Contact.php" target="_blank">Contact us</a></li>
            <li><a href="http://localhost/events_org_R/blog/blog.php" target="_blank">Blog</a></li>
            
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-5">
          <ul class="list-unstyled list-inline social text-center">
            <li class="list-inline-item"><a href=""><i class="fa fa-facebook"></i></a></li>
            <li class="list-inline-item"><a href=""><i class="fa fa-twitter"></i></a></li>
            <li class="list-inline-item"><a href=""><i class="fa fa-instagram"></i></a></li>
            <li class="list-inline-item"><a href=""><i class="fa fa-google-plus"></i></a></li>
            <li class="list-inline-item"><a href="" target="_blank"><i class="fa fa-envelope"></i></a></li>
          </ul>
        </div>
        <hr>
      </div>	
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center text-white">
          <p class="h6">© All right Reversed.<a class="text-green ml-2" href="" target="_blank">Events Around</a></p>
        </div>
        <hr>
      </div>	
    </div>
  </section>
  <script type="text/javascript">
$("#msg").on('keypress',function(e) {
    if(e.which == 13) {
        if (e.key === 'Enter' || e.keyCode === 13) {
      var sid = $("#senderID_input").val();
      var rid = $("#receiverID_input").val();

        sendMsg(sid,rid);
      }
    }
});
   function sendMsg(sid,rid){
  
  /*--create date and time of msg-Start--*/

      var now = new Date(Date.now());
      var currentDate = now.toLocaleDateString();
      var hours = now.getHours();
      var minutes = now.getMinutes();
      var ampm = hours >= 12 ? 'PM' : 'AM';
      hours = hours % 12;
      hours = hours ? hours : 12; // the hour '0' should be '12'
      minutes = minutes < 10 ? '0'+minutes : minutes;
      var formatted = currentDate +" - "+hours + ':' + minutes + ' ' + ampm;
      var chatClass = "";
  /*--create date and time of msg-End--*/

  var msg = $("#msg").val(); // get member message form input
  if(msg == "" || msg == undefined){ //check msg field is empty or not
    alert("Please Write Your Message First than press send button"); //show error message
  }else{
   
    /*--get member name from php session variable-Start--*/
    <?php if(isset($_SESSION['onlineUserFullName'])){ ?>
            var memberName = "<?php echo $_SESSION['onlineUserFullName'];  ?>";
    <?php }else{ ?>
        var memberName = "User";
    <?php } ?>

    <?php if (isset($_SESSION['onlineUserType']) == 'O') { ?>
      var chatClass= 'organizerMessage';
    <?php } ?>


    <?php if (isset($_SESSION['onlineUserType']) == 'U') { ?>
      var chatClass= 'usermessage';
    <?php } ?>
    /*--get member name from php session variable-End--*/
    <?php if (isset($_SESSION['onlineUserID'])) { 
      $id = $_SESSION['onlineUserID'];
     ?> 
      var userImage = '<?php "../../".getUserProfileImage($id); ?>';
      <?php 

      if( !file_exists("../../".getUserProfileImage($id))){ ?>
        var userImage  = "../../uploads/users.png";
      <?php }  
       } ?>
    //   var userImage  = "https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&auto=format&fit=crop&w=998&q=80";
    /*--get member name from php session variable-End--*/
    /*--create sender message div for appending in chat box-start--*/
    var appendDiv = '<div  class= "'+chatClass+'"><p style="margin: 10px 0 10px 0;"> <img style="width: 35px; height: 35px; margin-right: 10px; padding: 5px" class="img-circle" src="'+userImage+'" />'+memberName+'</p><p style="padding-left: 10px;">'+msg+'</p><span class="time-right">'+formatted+'</span><br><br></div><div class="clearfix"></div>';
    /*--create sender message div for appending in chat box-End--*/

    $.ajax({
        url:"sendMessage.php",
        type:"POST",
        data:{
          senderID:sid,
          receiverID:rid,
          message: msg
         },
        success:function(response) {
            if(response == 1){
                $("#chatDiv").append(appendDiv); //append msg
                $("#msg").val(''); //empty message text field
                 $('#chatDiv').animate({
                    scrollTop: $('#chatDiv').get(0).scrollHeight
                }, 100);
            }else{
                alert("Something going worng please try later");
            }
       
        
       },
       error:function(){
        alert("error");
       }

      });
  
  }
   
    
   }
</script>
<script type="text/javascript">
  $(document).ready(function() {
  <?php if (checkLogin() == true && $_SESSION['onlineUserType'] == "U") { ?>
  var groupOrganizerID = <?php echo $groupOrganizerID; ?>;  
  window.setInterval(function(){
   $("#chatDiv").load("clientChatBox.php?groupOrganizerID="+groupOrganizerID); 
     $('#chatDiv').animate({
        scrollTop: $('#chatDiv').get(0).scrollHeight
    }, 100);
    
  }, 5000);
  <?php } ?>
  });
</script>

<script type="text/javascript">
    $(document).ready(function() {
    $('#chatDiv').animate({
        scrollTop: $('#chatDiv').get(0).scrollHeight
    }, 100);
});
</script>
<script src="../../plugins/datatables/jquery.dataTables.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

<script>
  $(function () {
    $("#membersTbl").DataTable();
  });
</script>



</body>
</html>