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
$errorFlag = 0;

// if there is no error_session or number of array is 0 then create an _SESSION['error'] array
if(!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0){
    $_SESSION['errors'] = array();
  }

  // destroy the session variable
function unsetSessions(){
  unset($_SESSION['blogTitle']);
  unset($_SESSION['blogDescription']);

}
// if ADD BLOG button is pressed
if (isset($_POST['submitBtn'])) {

    if(empty($_POST['blogTitle'])){
    array_push($_SESSION['errors'],"Blog Title is Required");
      
    }else{
       $blogTitle = mysqli_real_escape_string($con, $_POST['blogTitle']);
       $_SESSION['blogTitle'] = $_POST['blogTitle'];
    }

    if(empty($_POST['blogDescription'])){
    array_push($_SESSION['errors'],"Blog Description is Required");
      
    }else{
       $blogDescription = mysqli_real_escape_string($con, $_POST['blogDescription']);
       $_SESSION['blogDescription'] = $_POST['blogDescription'];
    }
    
    $status = 'A';
    $createdBy = $_SESSION['userID']; // This  session['userID] is created when admin is loged in
    $createdTime = date('Y-m-d h:i:s');
    
   
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

                 
                  $sql = "INSERT INTO `tbl_blogs` (`blog_title`,`blog_status`,`createdBy`,`createdDate`,`blog_image`,`blog_description`)VALUES('$blogTitle','$status','$createdBy','$createdTime','$target_file','$blogDescription')";
                  $result = mysqli_query($con,$sql);
                  if($result){
                    unsetSessions();
                    $_SESSION['blogAddedSuccessfullyMsg'] = "Blog Added Successfully";
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
            array_push($_SESSION['errors'], "Blog Image is Required");
       
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
              
            ?>
             <div class="row">
                    <div class="col-md-12">
                        <div class="card p-3">
                            <div class="header">
                                <h4 class="title">Add New Blog</h4>
                            </div>
                            <div class="content">
                                <form action="addBlogs.php" method="POST" enctype="multipart/form-data">
                                   <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">

                                                <input type="text" class="form-control" placeholder="Enter Category Title" name="blogTitle" value="<?php echo $blogTitle; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">

                                                <input type="file" class="form-control" style="opacity:1 !important; position:initial !important;"  name="blogImage">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">

                                                
                                                <textarea class="form-control" placeholder="Enter Blog Description" rows="5" name="blogDescription"><?php echo $blogDescription ?></textarea>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <button type="submit" name="submitBtn" class="btn btn-info btn-fill pull-right">Add Blog</button>
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
                                <h4 class="title">All Blogs</h4>
                            </div>
                            <div style="padding: 10px;">
                            <?php if (isset($_SESSION['blogAddedSuccessfullyMsg'])) {
                               ?>
                               <div class="alert alert-success">
                                   <?php 
                                    echo $_SESSION['blogAddedSuccessfullyMsg'];
                                    unset($_SESSION['blogAddedSuccessfullyMsg']);
                                   ?>
                               </div>
                               <?php
                            } ?>
                            <?php if (isset($_SESSION['blogDeletedSuccessfullyMsg'])) {
                                ?>
                                <div class="alert alert-success">
                                    <?php 
                                        echo $_SESSION['blogDeletedSuccessfullyMsg']; 
                                        unset($_SESSION['blogDeletedSuccessfullyMsg']);
                                    ?>
                                </div>
                                <?php
                            } ?>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table id="categories" class="table table-hover table-striped">
                                    <thead>
                                        <th>SrNo</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Likes</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </thead>
                                    <?php
                                    $sqlCateData = "SELECT * FROM `tbl_blogs` ORDER BY `blog_id` DESC";
                                    $resultCateData = mysqli_query($con,$sqlCateData);
                                    if($resultCateData){
                                        if(mysqli_num_rows($resultCateData)>0){
                                            ?>
                                                <tbody>
                                                    <?php 
                                                    $srNo = 1; 
                                                    while ($rowBlogData = mysqli_fetch_array($resultCateData)) {
                                                        ?>

                                                        <tr>
                                                            <td><?php echo $srNo; ?></td>
                                                            
                                                            <td><?php if($rowBlogData['blog_image'] != "" && file_exists($rowBlogData['blog_image'])){
                                                                ?>
                                                                <img src="<?php echo $rowBlogData['blog_image']; ?>" style="width: 100px; height:100px; border-radius: 100px;">
                                                                <?php
                                                            }  ?></td>
                                                            <td><?php echo $rowBlogData['blog_title']; ?></td>
                                                             <td><?php echo getBlogLikes($rowBlogData['blog_id']); ?></td>
                                                            <td><?php echo getStatusTitle($rowBlogData['blog_status']); ?></td>
                                                            <td>
                                                                <a href="eidtBlogs.php?blogID=<?php echo $rowBlogData['blog_id']; ?>" class="btn btn-sm btn-success">Edit</a>&nbsp;
                                                                <a href="javascript:;" onclick="confDel(<?php echo $rowBlogData['blog_id']; ?>);" class="btn btn-sm btn-danger">Delete</a>
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
            var conf = confirm("Are you sure to delete this Blog?");
            if(conf){
            window.location.href="deleteBlog.php?id="+id;
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