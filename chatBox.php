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
<style type="text/css">
.receiverMsg{
border: 2px solid #dedede;
/*background-color: #db363669;*/
background: #5a1212;

border-radius: 30px;
padding: 5px;
width: 50%;
padding-bottom: 0;
margin-top: 10px;
margin-bottom: 10px;
padding-left: 30px;
padding-right: 30px;
}

 .senderMsg{
  border: 2px solid #dedede;
  border-color: #ccc;
  /*background-color: #f5f5f5;*/
  background: #db3f3c;
  
  /*text-align: right;*/
  border-radius: 30px;
  padding: 3px;
  width: 50%;
  float: right;
  padding-bottom: 0;
  padding-left: 30px;
padding-right: 30px;
  margin-bottom: 10px;
  margin-top: 10px;
}


.senderMsg p,.receiverMsg p{
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
<?php 
$senderID = $receiverID = "";
if($_SESSION['onlineUserType'] == 'O' && isset($_GET['userID'])){
     $organizerID = $_SESSION['onlineUserID'];
      $senderID = $_SESSION['onlineUserID'];
       $receiverID = $_GET['userID'];

     $sql2 = "UPDATE `tbl_chat` SET `receverReadNoti` = '1' WHERE `receiverID` = '$organizerID' AND `senderID` = '$receiverID' AND `receverReadNoti` = '0'";
     $result2 = mysqli_query($con,$sql2);
   
}

 ?>
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
<h1>Chat List (Users)</h1>
 

<?php if(checkLogin() == false ){
  header("location:Login/login.php");
  exit();
} 

if($_SESSION['onlineUserType'] == "O"){
  $organizerID = $_SESSION['onlineUserID'];
}
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css">
<!-- <style type="text/css">
  .row{
    width: 100% !important;
  }
</style>
 -->
 <div class="clearfix"></div>
 
             <h1 style="text-align: center; color: #db3636;" class="title1">Inbox</h1>
              <div  style="padding-top:0px;padding-left: 20px; background-image: url(uploads/back1.jpg);" class="container">
                <div class="">
                        <div id="chatDiv" style="height:380px; overflow:scroll; overflow-x: hidden;">
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
                                    $class = "senderMsg";
                                   $userName = $_SESSION['onlineUserFullName'];
                                    $userImage = "".getUserProfileImage($senderID);
                                    if($userImage == "" OR !file_exists($userImage)){
                                      $userImage = "uploads/users.png";
                                    }
                                     
                                }

                                if($row['receiverID'] == $senderID){
                                    $class = "receiverMsg";
                                    $userName = getUserName($receiverID);
                                    $userImage = "".getUserProfileImage($receiverID);
                                    if($userImage == "" OR !file_exists($userImage)){
                                      $userImage = "uploads/users.png";
                                    }
                                    
                                }
                            ?>
                          <div  class= "<?php echo $class; ?>">
                              <p style="margin: 10px 0 10px 0;"> <img style="width: 35px; height: 35px; margin-right: 10px; padding: 5px" class="img-circle" src="<?php echo $userImage; ?>" /><?php echo $userName; ?> </p>
                               <p style="padding-left: 10px; text-align: justify;"><?php echo $row['message'] ; ?></p>
                                <?php 
                                $chatDateTime=strtotime($row['createdTime']);
                                $cDate =  date("d-m-Y", $chatDateTime); 
                                $cTime =  date("h:i A", $chatDateTime);
                            ?>
                              <span class="time-right"><?php echo  $cDate ." - ". $cTime;  ?></span>
                              <br><br>
                             
                            </div>
                            <div class='clearfix'></div>

                          <?php   }
                        ?>
                        </div>
                      </div>

                      <form action="javascript:;" role="form" id="form-contact-agent" method="post"  class="clearfix">

                        <div class="panel-footer">
                        <div class="input-group">
                        <input autocomplete="off" id="msg" style="height: 60px;"  type="text" class="form-control input-sm chat_input" placeholder="Write your message here..." />
                        <span class="input-group-btn">
                           <input type="hidden" id="senderID_input" value="<?php echo $senderID; ?>">
                          <input type="hidden" id="receiverID_input" value="<?php echo $receiverID; ?>">

                        <button style="height: 58px;"  type="button" onclick="sendMsg(<?php echo $senderID; ?>,<?php echo $receiverID; ?>);" class="btn btn-primary btn-sm" id="btn-chat">Send</button>
                        </span>
                    </div>
                </div>                        
                        </form>
                            
                        </div>
                    
                    <!--End Advanced Tables -->
</div>
<!--------------------Page Content End------------------------->

<!--Footer Start-->
<?php include("footer.php"); ?>
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
    //alert(sid+"-"+rid);
  
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
        var memberName = "Organizer";
    <?php } ?>

      var chatClass= 'senderMsg';
    
    <?php if (isset($_SESSION['onlineUserID'])) { 
      $id = $_SESSION['onlineUserID'];
     ?> 
      var userImage = '<?php echo "".getUserProfileImage($id); ?>';
      <?php 

      if( !file_exists("".getUserProfileImage($id))){ ?>
        var userImage  = "uploads/users.png";
      <?php }  
       } ?>

        if (userImage == "") {
        var userImage  = "uploads/users.png";
       }
    /*--get member name from php session variable-End--*/
    /*--create sender message div for appending in chat box-start--*/
    var appendDiv = '<div  class= "'+chatClass+'"><p style="margin: 10px 0 10px 0;"> <img style="width: 35px; height: 35px; margin-right: 10px; padding: 5px" class="img-circle" src="'+userImage+'" />'+memberName+'</p><p style="padding-left: 10px;text-align: justify;">'+msg+'</p><span class="time-right">'+formatted+'</span><br><br></div><div class="clearfix"></div>';
    /*--create sender message div for appending in chat box-End--*/

    $.ajax({
        url:"group/groupWebPage/sendMessage.php",
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
  <?php if (checkLogin() == true && $_SESSION['onlineUserType'] == "O") { ?>
  var clientID = $("#receiverID_input").val();  
  window.setInterval(function(){
     $("#chatDiv").load("organizerChatbox.php?userID="+clientID); 
    //  $('#chatDiv').animate({
    //     scrollTop: $('#chatDiv').get(0).scrollHeight
    // }, 100);
    
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


</body>
</html>


