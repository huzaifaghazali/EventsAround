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
$errorFlag = 0;
// if there is no error_session or number of array is 0 then create an _SESSION['error'] array
if(!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0){
    $_SESSION['errors'] = array();
  }

// Destroy the session   
function unsetSessions(){
  unset($_SESSION['adTitle']);
  unset($_SESSION['adDescription']);

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
    
    $status = 'A';
    $createdBy = $_SESSION['userID']; // This  session['userID] is created when admin is loged in
    $createdTime = date('Y-m-d h:i:s');
    
   
    if(!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0){

    // The basename() function returns the filename from a path.
    if( basename($_FILES["adImage"]["name"] != "")){

        $target_dir = "adImages/";
        $timestamp = time();
        $target_file = $target_dir . $timestamp.'_'.basename($_FILES["adImage"]["name"]); // name is the original name of the file which is store on the local machine.
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); // pathinfo return information about file and then convert it into the lowerscase

        $check = getimagesize($_FILES["adImage"]["tmp_name"]); // is the temporary name of the uploaded file which is generated automatically by php, and stored on the temporary folder on the server.
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

                 
                  $sql = "INSERT INTO `tbl_ads` (`ad_title`,`ad_status`,`createdBy`,`createdDate`,`ad_img_path`,`ad_description`)VALUES('$adTitle','$status','$createdBy','$createdTime','$target_file','$adDescription')";
                  $result = mysqli_query($con,$sql);
                  if($result){
                    unsetSessions();
                    $_SESSION['adAddedSuccessfullyMsg'] = "Ad Added Successfully";
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
            array_push($_SESSION['errors'], "Ad Image is Required");
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
              
            ?>
             <div class="row">
                    <div class="col-md-12">
                        <div class="card p-3">
                            <div class="header">
                                <h4 class="title">Add New Ad</h4>
                            </div>
                            <div class="content">
                                <form action="addAds.php" method="POST" enctype="multipart/form-data">
                                   <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Enter Ad Title" name="adTitle" value="<?php echo $adTitle; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">

                                                <input type="file" class="form-control" style="opacity:1 !important; position:initial !important;"  name="adImage">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">

                                                
                                                <textarea class="form-control" placeholder="Enter Ad Description" rows="5" name="adDescription"><?php echo $adDescription ?></textarea>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <button type="submit" name="submitBtn" class="btn btn-info btn-fill pull-right">Add Ad</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                   
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card p-3">
                            <div class="header">
                                <h4 class="title">All Ads</h4>
                            </div>
                            <div style="padding: 10px;">
                            <?php if (isset($_SESSION['adAddedSuccessfullyMsg'])) {
                               ?>
                               <div class="alert alert-success">
                                   <?php 
                                    echo $_SESSION['adAddedSuccessfullyMsg'];
                                    unset($_SESSION['adAddedSuccessfullyMsg']);
                                   ?>
                               </div>
                               <?php
                            } ?>
                            <?php if (isset($_SESSION['adDeletedSuccessfullyMsg'])) {
                                ?>
                                <div class="alert alert-success">
                                    <?php 
                                        echo $_SESSION['adDeletedSuccessfullyMsg']; 
                                        unset($_SESSION['adDeletedSuccessfullyMsg']);
                                    ?>
                                </div>
                                <?php
                            } ?>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table id="adsTbl" class="table table-hover table-striped">
                                    <thead>
                                        <th>SrNo</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </thead>
                                    <?php
                                    $sqlAdData = "SELECT * FROM `tbl_ads` ORDER BY `ad_id` DESC";
                                    $resultAdData = mysqli_query($con,$sqlAdData);
                                    if($resultAdData){
                                        if(mysqli_num_rows($resultAdData)>0){
                                            ?>
                                                <tbody>
                                                    <?php 
                                                    // get all the rows of AD table and show it on the table
                                                    $srNo = 1; 
                                                    while ($rowAdData = mysqli_fetch_array($resultAdData)) {
                                                        ?>

                                                        <tr>
                                                            <td><?php echo $srNo; ?></td>
                                                            
                                                            <td>
                                                            <?php if($rowAdData['ad_img_path'] != "" && file_exists($rowAdData['ad_img_path'])){ ?>
                                                                <img src="<?php echo $rowAdData['ad_img_path']; ?>" style="width: 100px; height: 100px;">
                                                                <?php } ?>
                                                            </td>
                                                            <td><?php echo $rowAdData['ad_title']; ?></td>
                                                            <td><?php echo getStatusTitle($rowAdData['ad_status']); ?></td>
                                                            <td>
                                                                <a href="eidtAds.php?adID=<?php echo $rowAdData['ad_id']; ?>" class="btn btn-sm btn-success">Edit</a>&nbsp;
                                                                <a href="javascript:;" onclick="confDel(<?php echo $rowAdData['ad_id']; ?>);" class="btn btn-sm btn-danger">Delete</a>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    $srNo++; 
                                                        } ?>
                                                </tbody>
                                            <?php
                                        }
                                    }
                                    ?>
                                    
                                </table>

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
            var conf = confirm("Are you sure to delete this Ad?");
            if(conf){
            window.location.href="deleteAd.php?id="+id;
            }
        }
</script>
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

<script>
  $(function () {
    $("#adsTbl").DataTable();
  });
</script>
</body>

</html>