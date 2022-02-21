<?php require("../../connection.php"); ?>
<?php require("../../functions.php"); ?>
<?php if(checkLogin() == false){
    header("location:../../index.php");
    exit();
} 

if (!isset($_SESSION['onlineUserType']) || $_SESSION['onlineUserType'] != "O") {
    header("location:../../index.php");
    exit();
}

$heading = "Create a new Group";
$actionURL = "createGroup.php";
?>
<?php  $groupID = $groupName = $groupLocation = $groupDescription = $groupImage = $groupStatus = ""; // 
if (isset($_GET['groupID'])) {
    $groupID = $_GET['groupID'];

  if(getOrganizerGroupID($_SESSION['onlineUserID']) != $groupID){
   $_SESSION['groupErrMsg'] = "Group Edit Request Denied, Your are not organizer of this group";
        header("location:../group.php");
        exit(); 
  }
    $sql = "SELECT * FROM `tbl_groups` WHERE `group_id` = '$groupID'";
    $result = mysqli_query($con,$sql);
    if ($result) {
        if(mysqli_num_rows($result) == 1){
            if ($row = mysqli_fetch_array($result)) {
                $groupName = $row['group_name'];
                $groupLocation = $row['group_location'];
                $groupDescription = $row['group_description'];
                $groupImage = "../../".$row['group_image'];
                $groupStatus = $row['group_status'];
                $heading = "Edit Group Information";
                $actionURL = "createGroup.php?groupID=".$groupID;

            }
        }
    }
}else{

    if(checkGroupExistAgainstOrganizerID($_SESSION['onlineUserID'])>0){
        $_SESSION['groupErrMsg'] = "Group Exist Against Your ID";
        header("location:../group.php");
        exit();
    }
}
function unsetSessions(){
  unset($_SESSION['groupName']);
  unset($_SESSION['groupLocation']);
  unset($_SESSION['groupDescription']);
  unset($_SESSION['groupStatus']);
}

if(!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0){
  $_SESSION['errors'] = array();
}
if (isset($_POST['submitBtn'])) {
  if (empty($_POST['groupName'])) {
    array_push($_SESSION['errors'], " Name is Required");
  }else{
    $groupName = mysqli_real_escape_string($con,$_POST['groupName']);
    $_SESSION['groupName'] = $groupName;    
  }
  if (empty($_POST['groupLocation'])) {
    array_push($_SESSION['errors'], " Location is Required");
  }else{
    $groupLocation = mysqli_real_escape_string($con,$_POST['groupLocation']);
    $_SESSION['groupLocation'] = $groupLocation;
    
  }
  if (empty($_POST['groupDescription'])) {
    array_push($_SESSION['errors'], "Description is Required");
  }else{
    $groupDescription = mysqli_real_escape_string($con,$_POST['groupDescription']);
    $_SESSION['groupDescription'] = $groupDescription;
   
  }

  if($groupID != ""){

    if (empty($_POST['groupStatus'])) {
        array_push($_SESSION['errors'], "Status is Required");
      }else{
        $groupStatus = mysqli_real_escape_string($con,$_POST['groupStatus']);
        $_SESSION['groupStatus'] = $groupStatus;
       
      }
      if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {
        $updatedBy = $_SESSION['onlineUserID'];
        $updatedDate = date("Y-m-d h:i:s");
        if( basename($_FILES["groupImage"]["name"] != "")){

            $target_dir = "../../uploads/";
            $timestamp = time();
             $target_file = $target_dir . $timestamp.'-'.basename($_FILES["groupImage"]["name"]);
            $db_target_file = "uploads/". $timestamp.'-'.basename($_FILES["groupImage"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["groupImage"]["tmp_name"]);
            if($check !== false) {
                
              if (file_exists($target_file)) {
                  array_push($_SESSION['errors'], "Sorry, file already exists");
              }

              //Check file size
              if ($_FILES["groupImage"]["size"] > 500000) {
                  array_push($_SESSION['errors'], "File is too large");
              }


             if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                  array_push($_SESSION['errors'], "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
              }
              
              if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {

                  if (move_uploaded_file($_FILES["groupImage"]["tmp_name"], $target_file)) {
                      //your query with file path

                        if(file_exists($groupImage)){
                            unlink($groupImage);
                        }

                      $sql = "UPDATE `tbl_groups` SET `group_name` = '$groupName',`group_location` = '$groupLocation',`group_description` = '$groupDescription',`group_status` = '$groupStatus',`updatedBy` = '$updatedBy',`updatedDate` = '$updatedDate',`group_image` = '$db_target_file' WHERE `group_id` = '$groupID'";
                       
                  } else {
                    array_push($_SESSION['errors'], "Sorry, there was an error uploading your file.");
                  }
              

              }

                    
              } else {
                array_push($_SESSION['errors'], "Please Upload Image File Only");
                 
              }
            
          }else{

              $sql = "UPDATE `tbl_groups` SET `group_name` = '$groupName',`group_location` = '$groupLocation',`group_description` = '$groupDescription',`group_status` = '$groupStatus',`updatedBy` = '$updatedBy',`updatedDate` = '$updatedDate' WHERE `group_id` = '$groupID'";
          }
            if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {

                $result = mysqli_query($con,$sql);
                if ($result) {
                  unsetSessions();

                  $_SESSION['groupCreatedSuccessfullyMsg'] = "Group Information Updated Successfully";
                  header("location:../groupWebPage/groupWebPage.php?groupID=".$groupID);
                  exit();
                }
            }
      }

  }else{
    if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {
        $createdBy = $_SESSION['onlineUserID'];
        $createdDate = date("Y-m-d h:i:s");
        $groupStatus = "A";
        if( basename($_FILES["groupImage"]["name"] != "")){

            $target_dir = "../../uploads/";
            $timestamp = time();
             $target_file = $target_dir . $timestamp.'-'.basename($_FILES["groupImage"]["name"]);
            $db_target_file = "uploads/". $timestamp.'-'.basename($_FILES["groupImage"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["groupImage"]["tmp_name"]);
            if($check !== false) {
                
              if (file_exists($target_file)) {
                  array_push($_SESSION['errors'], "Sorry, file already exists");
              }

              //Check file size
              if ($_FILES["groupImage"]["size"] > 500000) {
                  array_push($_SESSION['errors'], "File is too large");
              }


             if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                  array_push($_SESSION['errors'], "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
              }
              
              if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {

                  if (move_uploaded_file($_FILES["groupImage"]["tmp_name"], $target_file)) {
                      //your query with file path

                   
                      $sql = "INSERT INTO `tbl_groups` (`group_name`,`group_location`,`group_description`,`group_organizerID`,`group_status`,`createdBy`,`createdDate`,`group_image`) VALUES ('$groupName','$groupLocation','$groupDescription','$createdBy','$groupStatus','$createdBy','$createdDate','$db_target_file')";
                       $result = mysqli_query($con,$sql);
                        if ($result) {
                          $groupID = mysqli_insert_id($con);
                          unsetSessions();

                          $_SESSION['groupCreatedSuccessfullyMsg'] = "Group Created Successfully";
                          header("location:../groupWebPage/groupWebPage.php?groupID=".$groupID);
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $heading; ?></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />



    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="createGroup.css">
</head>

<body>


    <div class="container">
        <header>
            <h1>Welcome to Events Around</h1>
            <h2 id="description"><?php echo $heading; ?></h2>
        </header>
        <form id='group-form' action="<?php echo $actionURL; ?>" method="POST" enctype="multipart/form-data">
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

            if(isset($_SESSION['groupName'])){
              $groupName = $_SESSION['groupName'];
            } 
            if(isset($_SESSION['groupLocation'])){
              $groupLocation = $_SESSION['groupLocation'];
            } 
            if(isset($_SESSION['groupLocation'])){
              $groupLocation = $_SESSION['groupLocation'];
            } 


            if(isset($_SESSION['groupStatus'])){
              $groupStatus = $_SESSION['groupStatus'];
            } 

              ?>
            <div class='form-input'>
                <label id='name-label'>Group Name</label>
                <input type='text' id='name' name="groupName" placeholder='Enter your Group name' class='form-input-size' required value="<?php echo $groupName; ?>" />
            </div>
            <div class='form-input'>
                <label id='location-label'>Location</label>
                <input type='text' id='location' name="groupLocation" placeholder='Enter your city Location' class='form-input-size'
                    required value="<?php echo $groupLocation; ?>" />
            </div>


            <div class='form-input'>
                <label id='number-label'>Select Image for your group</label>
                <p><input type="file" accept="image/*" name="groupImage" id="file" onchange="loadFile(event)" style="display: none;"></p>
                <p><label for="file" style="cursor: pointer;">Upload Image</label></p>
                <p><img id="output" width="200" /></p>
                <p><img id="groupImage" src="<?php echo $groupImage; ?>" width="200" /></p>
            </div>

            
            <div class='form-input'>
                <p>Discription of group</p>
                <textarea style="color: black;" type='text' placeholder='Enter your comment here...' name="groupDescription"><?php echo $groupDescription; ?></textarea>
            </div>

            <?php if($groupID != ""){
                ?>
                <div class="form-input">
                    <p>Group Status</p>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                        <input <?php if($groupStatus == "A"){echo "checked";} ?> type="radio" class="form-check-input" name="groupStatus" value="A">Active
                        </label>
                        </div>
                        <div class="form-check-inline">
                        <label class="form-check-label">
                        <input <?php if($groupStatus == "D"){echo "checked";} ?> type="radio" class="form-check-input" name="groupStatus" value="D">Deactivate
                        </label>
                        </div>
                        
                </div>
                <?php
            } ?>

            <div class='form-input'>
                <button type='submit' name="submitBtn" id='submit'>Create Group</button>
            </div>
        </form>
    </div>

    <section id="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center text-white">
                    <p class="h6">© All right Reversed.<a class="text-green ml-2" href="" target="_blank">Events
                            Around</a></p>
                </div>
                <hr>
            </div>
        </div>
    </section>



    <script>
        var loadFile = function(event) {
            var image = document.getElementById('output');
            $("#groupImage").hide();
            image.src = URL.createObjectURL(event.target.files[0]);
        };
        </script>
        
</body>

</html>