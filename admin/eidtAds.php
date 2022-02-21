<?php include("includes/head.php"); ?>
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<style type="text/css">
    #categories_length,#categories_filter,#categories_paginate,#categories_info{
        padding: 10px !important;
    }
</style>
<?php  
$adTitle = $adDescription = ""; 
$adID = "";
// this will be active when we will click on the ID
if(isset($_GET['adID'])){
    $adID = $_GET['adID'];
    $sql = "SELECT * FROM `tbl_ads` WHERE `ad_id` = '$adID'";
    $result = mysqli_query($con,$sql);
    if($result){
      if(mysqli_num_rows($result) == 1){
        if($row = mysqli_fetch_array($result)){
            $adTitle = $row['ad_title'];
            $status = $row['ad_status'];
            $adDescription = $row['ad_description'];
            $adImage = $row['ad_img_path'];
        }
      }
    }
}else{
    header("location:addAds.php");
    exit();
}



// if there is no error_session or number of array is 0 then create an _SESSION['error'] array
if(!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0){
    $_SESSION['errors'] = array();
}

// Destroy the session
function unsetSessions(){
  unset($_SESSION['adTitle']);
  unset($_SESSION['adDescription']);
  unset($_SESSION['status']);

}

// check if ADD AD button is pressed 
if (isset($_POST['submitBtn'])) {

    // if the ad title is empty push the message into session_error array
    if(empty($_POST['adTitle'])){
    array_push($_SESSION['errors'],"Ad Title is Required");
      
    }else{
       $adTitle = mysqli_real_escape_string($con, $_POST['adTitle']); // this will remove the speical charachers like $,% etc in the ad title sql query
       $_SESSION['adTitle'] = $_POST['adTitle'];
    }

    // if description is empty push the message into session_error array
    if(empty($_POST['adDescription'])){
    array_push($_SESSION['errors'],"Ad Description is Required");
      
    }else{
       $adDescription = mysqli_real_escape_string($con, $_POST['adDescription']);
       $_SESSION['adDescription'] = $_POST['adDescription'];
    }
    

    if(empty($_POST['status'])){
    array_push($_SESSION['errors'],"Ad status is Required");
      
    }else{
       $status = mysqli_real_escape_string($con, $_POST['status']);
       $_SESSION['status'] = $_POST['status'];
    }
     
    $updatedBy = $_SESSION['userID']; // This  session['userID] is created when admin is loged in
    $updatedDate = date('Y-m-d h:i:s');
    
   
    if(!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0){

      // The basename() function returns the filename from a path.
    if( basename($_FILES["adImage"]["name"] != "")){

        $target_dir = "blogsImages/";
        $timestamp = time();
        $target_file = $target_dir . $timestamp.'-'.basename($_FILES["adImage"]["name"]);  // name is the original name of the file which is store on the local machine.
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); // pathinfo return information about file and then convert it into the lowerscase

        $check = getimagesize($_FILES["adImage"]["tmp_name"]);  // is the temporary name of the uploaded file which is generated automatically by php, and stored on the temporary folder on the server.
        if($check !== false) {
            
          if (file_exists($target_file)) {
              array_push($_SESSION['errors'], "Sorry, file already exists");
          }

          //Check file size
          if ($_FILES["adImage"]["size"] > 500000) {
              array_push($_SESSION['errors'], "File is too large");
          }


         if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
              array_push($_SESSION['errors'], "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
          }
          
          if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {

              if (move_uploaded_file($_FILES["adImage"]["tmp_name"], $target_file)) {
                  //your query with file path
                    if(file_exists($adImage)){
                        unlink($adImage);
                    }

                 
                  $sql = "UPDATE `tbl_ads` SET `ad_title` = '$adTitle',`ad_description` = '$adDescription',`ad_status` = '$status', `updatedBy` = '$updatedBy',`updatedDate` = '$updatedDate',`ad_img_path` = '$target_file' WHERE `ad_id` = '$adID'";
                  $result = mysqli_query($con,$sql);
                  if($result){
                    unsetSessions();
                    $_SESSION['adAddedSuccessfullyMsg'] = "Ad Updated Successfully";
                    header("location:addAds.php");
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
          $sql = "UPDATE `tbl_ads` SET `ad_title` = '$adTitle',`ad_description` = '$adDescription',`ad_status` = '$status', `updatedBy` = '$updatedBy',`updatedDate` = '$updatedDate' WHERE `ad_id` = '$adID'";
          $result = mysqli_query($con,$sql);
          if($result){
            unsetSessions();
            $_SESSION['adAddedSuccessfullyMsg'] = "Ad Updated Successfully";
            header("location:addAds.php");
            exit();
          }
      }
     

      
    }
  
   

  }

?>

<body class="dark-edition">
  <div class="wrapper ">
    <?php include("includes/sidebar.php"); ?>
    <div class="main-panel">
      <!-- Navbar -->
      <?php include("includes/topnav.php"); ?>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
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
            if(isset($_SESSION['adTitle'])){
                $adTitle = $_SESSION['adTitle'];
            }

            if(isset($_SESSION['adDescription'])){
                $adDescription = $_SESSION['adDescription'];
            } 
            
            if(isset($_SESSION['status'])){
                $status = $_SESSION['status'];
            }  
            ?>
             <div class="row">
                    <div class="col-md-12">
                        <div class="card p-3">
                            <div class="header">
                                <h4 class="title">Update Ad</h4>
                            </div>
                            <div class="content">
                            
                                <form action="eidtAds.php?adID=<?php echo $adID; ?>" method="POST" enctype="multipart/form-data">

                                   <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">

                                                <input type="text" class="form-control" placeholder="Enter Category Title" name="adTitle" value="<?php echo $adTitle; ?>">
                                            </div>
                                        </div>
                                        <?php if($adImage != "" && file_exists($adImage)){
                                            $colClass = "col-md-5" 
                                            ?>
                                            <div class="col-md-1">
                                                <!-- <img src="blogsImages/1624867272-marc.jpg"> -->
                            
                                                <img src="<?php echo $adImage; ?>" style="width: 50px; height:50px;">
                                            </div>
                                            <?php
                                        }else{
                                            $colClass = "col-md-6";
                                        } ?>
                                        <div class="<?php echo $colClass; ?>">
                                            <div class="form-group">

                                                <input type="file" class="form-control" style="opacity:1 !important; position:initial !important;"  name="adImage">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">

                                                
                                                <textarea class="form-control" placeholder="Enter Ad Description" rows="5" name="adDescription"><?php echo $adDescription ?></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select name="status" id="status" class="form-control">
                                                    <option value="0">Please select</option>
                                                    <option <?php if($status == "A"){echo "selected";} ?> value="A">Active</option>
                                                    <option <?php if($status == "B"){echo "selected";} ?> value="B">Block</option>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <button type="submit" name="submitBtn" class="btn btn-info btn-fill pull-right">Update Ad</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                   
                </div>

        </div>
      </div>
      <?php include ("includes/footer.php"); ?>
    </div>
  </div>
  <!--   Core JS Files   -->
  <?php include("includes/jsScripts.php"); ?>
  <!-- DataTables -->
     <script type="text/javascript">
        function confDel(id){
            var conf = confirm("Are you sure to delete this Category?");
            if(conf){
            window.location.href="deleteCategory.php?id="+id;
            }
        }
</script>
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

<script>
  $(function () {
    $("#categories").DataTable();
  });
</script>
</body>

</html>