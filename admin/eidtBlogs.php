<?php include("includes/head.php"); ?>
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<style type="text/css">
    #categories_length,#categories_filter,#categories_paginate,#categories_info{
        padding: 10px !important;
    }
</style>
<?php  
$blogTitle = $blogDescription = ""; 
$blogID = "";

// this will be active when we will click on the ID
if(isset($_GET['blogID'])){
    $blogID = $_GET['blogID'];
    $sql = "SELECT * FROM `tbl_blogs` WHERE `blog_id` = '$blogID'";
    $result = mysqli_query($con,$sql);
    if($result){
      if(mysqli_num_rows($result) == 1){
        if($row = mysqli_fetch_array($result)){
            $blogTitle = $row['blog_title'];
            $status = $row['blog_status'];
            $blogDescription = $row['blog_description'];
            $blogImage = $row['blog_image'];

        }
      }
    }
}else{
    header("location:addBlogs.php");
    exit();
}



// if there is no error_session or number of array is 0 then create an _SESSION['error'] array
if(!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0){
    $_SESSION['errors'] = array();
  }

    // destroy the session variable
function unsetSessions(){
  unset($_SESSION['blogTitle']);
  unset($_SESSION['blogDescription']);
  unset($_SESSION['status']);

}

// if ADD BLOG button is pressed
if (isset($_POST['submitBtn'])) {

  // if the blog title field is empty then push the error message into the SESSION['error'] array
    if(empty($_POST['blogTitle'])){
    array_push($_SESSION['errors'],"Blog Title is Required");
      
    }else{
       $blogTitle = mysqli_real_escape_string($con, $_POST['blogTitle']);
       $_SESSION['blogTitle'] = $_POST['blogTitle'];
    }

     // if the blog description field is empty then push the error message into the SESSION['error'] array
    if(empty($_POST['blogDescription'])){
    array_push($_SESSION['errors'],"Blog Description is Required");
      
    }else{
       $blogDescription = mysqli_real_escape_string($con, $_POST['blogDescription']); // t
       $_SESSION['blogDescription'] = $_POST['blogDescription'];
    }
    

    if(empty($_POST['status'])){
    array_push($_SESSION['errors'],"Blog status is Required");
      
    }else{
       $status = mysqli_real_escape_string($con, $_POST['status']);
       $_SESSION['status'] = $_POST['status'];
    }
    
    $updatedBy = $_SESSION['userID']; // This  session['userID] is created when admin is loged in
    $updatedDate = date('Y-m-d h:i:s');
    
   
    if(!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0){


      // The basename() function returns the filename from a path.
        // This if condition will basically move the image to the blogsImages folder
    if( basename($_FILES["blogImage"]["name"] != "")){

        $target_dir = "blogsImages/";
        $timestamp = time();
        $target_file = $target_dir . $timestamp.'-'.basename($_FILES["blogImage"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["blogImage"]["tmp_name"]);
        if($check !== false) {
            
          if (file_exists($target_file)) {
              array_push($_SESSION['errors'], "Sorry, file already exists");
          }

          //Check file size
          if ($_FILES["blogImage"]["size"] > 500000) {
              array_push($_SESSION['errors'], "File is too large");
          }


         if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
              array_push($_SESSION['errors'], "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
          }
          
          if (isset($_SESSION['errors']) && count($_SESSION['errors']) == 0) {

              if (move_uploaded_file($_FILES["blogImage"]["tmp_name"], $target_file)) {
                  //your query with file path
                    if(file_exists($blogImage)){
                        unlink($blogImage);
                    }

                 
                  $sql = "INSERT INTO `tbl_blogs` (`blog_title`,`blog_status`,`updatedBy`,`updatedDate`,`blog_image`,`blog_description`)VALUES('$blogTitle','$status','$updatedBy','$updatedDate','$target_file','$blogDescription')";

                  $sql = "UPDATE `tbl_blogs` SET `blog_title` = '$blogTitle',`blog_description` = '$blogDescription',`blog_status` = '$status', `updatedBy` = '$updatedBy',`updatedDate` = '$updatedDate',`blog_image` = '$target_file' WHERE `blog_id` = '$blogID'";
                  $result = mysqli_query($con,$sql);
                  if($result){
                    unsetSessions();
                    $_SESSION['blogAddedSuccessfullyMsg'] = "Blog Updated Successfully";
                    header("location:addBlogs.php");
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
          $sql = "UPDATE `tbl_blogs` SET `blog_title` = '$blogTitle',`blog_description` = '$blogDescription',`blog_status` = '$status', `updatedBy` = '$updatedBy',`updatedDate` = '$updatedDate' WHERE `blog_id` = '$blogID'";
          $result = mysqli_query($con,$sql);
          if($result){
            unsetSessions();
            $_SESSION['blogAddedSuccessfullyMsg'] = "Blog Updated Successfully";
            header("location:addBlogs.php");
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
            if(isset($_SESSION['blogTitle'])){
                $blogTitle = $_SESSION['blogTitle'];
            }

            if(isset($_SESSION['blogDescription'])){
                $blogDescription = $_SESSION['blogDescription'];
            } 
            
            if(isset($_SESSION['status'])){
                $status = $_SESSION['status'];
            }  
            ?>
             <div class="row">
                    <div class="col-md-12">
                        <div class="card p-3">
                            <div class="header">
                                <h4 class="title">Update Blog</h4>
                            </div>
                            <div class="content">
                                <form action="eidtBlogs.php?blogID=<?php echo $blogID; ?>" method="POST" enctype="multipart/form-data">
                                   <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">

                                                <input type="text" class="form-control" placeholder="Enter Category Title" name="blogTitle" value="<?php echo $blogTitle; ?>">
                                            </div>
                                        </div>
                                        <?php if($blogImage != "" && file_exists($blogImage)){
                                            $colClass = "col-md-5" 
                                            ?>
                                            <div class="col-md-1">
                                                <img src="<?php echo $blogImage; ?>" style="width: 50px; height:50px;">
                                            </div>
                                            <?php
                                        }else{
                                            $colClass = "col-md-6";
                                        } ?>
                                        <div class="<?php echo $colClass; ?>">
                                            <div class="form-group">

                                                <input type="file" class="form-control" style="opacity:1 !important; position:initial !important;"  name="blogImage">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">

                                                
                                                <textarea class="form-control" placeholder="Enter Blog Description" rows="5" name="blogDescription"><?php echo $blogDescription ?></textarea>
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

                                    <button type="submit" name="submitBtn" class="btn btn-info btn-fill pull-right">Update Blog</button>
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