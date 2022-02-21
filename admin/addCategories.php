<?php include("includes/head.php"); ?>
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<style type="text/css">
    #categories_length,#categories_filter,#categories_paginate,#categories_info{
        padding: 10px !important;
    }
</style>
<?php  
$cateTitle = ""; 
$errorFlag = 0;

// Fucntion to destroy the session
function unsetSessions(){
  unset($_SESSION['cateTitle']);
}

// Check if the ADD CATEGORY button is pressed
if (isset($_POST['submitBtn'])) {

    // if Category title is empty give error
    if(empty($_POST['cateTitle'])){
      $_SESSION['cateTitleError'] = 'Category Title is Required';
      $errorFlag = 1;
      $cateTitle = "";

    }else{
       $cateTitle = mysqli_real_escape_string($con, $_POST['cateTitle']) // mysqli_real_escape_string function escapes special characters in a string for use in an SQL query
       ;
       $_SESSION['cateTitle'] = $_POST['cateTitle']; // assign the value of category title to the session
    }
    
    $status = 'A';
    $createdBy = $_SESSION['userID']; // session is created when user is loged in
    $createdTime = date('Y-m-d h:i:s');
    
   
    // Give error when the category is alreay present
    // function is called from function.php
     if(checkCategoryTitleExist($cateTitle)>0){
      $_SESSION['error'] = "This Title :'".$cateTitle."' already Exists, please enter the new Category Title";
      header("location:addCategories.php");
      exit();
    }
    
    // If there is no error insert it into the database
    if($errorFlag == 0){
      $sql = "INSERT INTO `tbl_categories` (`title`,`status`,`createdBy`,`createdDate`)VALUES('$cateTitle','$status','$createdBy','$createdTime')";
      $result = mysqli_query($con,$sql);
      if($result){
        unsetSessions();
        $_SESSION['cateAddedSuccessfullyMsg'] = "Category Added Successfully";
        header("location:addCategories.php");
        exit();
      }
    }else{
      $_SESSION['cateError'] = "Category is not added Successfully";
        header("location:addCategories.php");
        exit();
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
          <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger">
                    <?php 
                    // if the category already exsits give error
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <?php if (isset($_SESSION['cateTitleError'])) { ?>
                <div class="alert alert-danger">
                    <?php 
                    // give the error if it is empty
                    echo $_SESSION['cateTitleError']; 
                    unset($_SESSION['cateTitleError']);
                    ?>
                </div>
            <?php } ?>
            <?php if (isset($_SESSION['cateError'])) { ?>
                <div class="alert alert-danger">
                    <?php 
                    // if it can not insert givee error
                    echo $_SESSION['cateError']; 
                    unset($_SESSION['cateError']);
                    ?>
                </div>
            <?php } ?>
            <?php 
                if(isset($_SESSION['cateTitle'])){
                $cateTitle = $_SESSION['cateTitle'];
            } 
              
            ?>
             <div class="row">
                    <div class="col-md-12">
                        <div class="card p-3">
                            <div class="header">
                                <h4 class="title">Add New Category</h4>
                            </div>
                            <div class="content">
                                <form action="addCategories.php" method="POST">
                                   <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">

                                                <input type="text" class="form-control" placeholder="Enter Category Title" name="cateTitle" value="<?php echo $cateTitle; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" name="submitBtn" class="btn btn-info btn-fill pull-right">Add Category</button>
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
                                <h4 class="title">All Categories</h4>
                            </div>
                            <div style="padding: 10px;">
                            <?php if (isset($_SESSION['cateAddedSuccessfullyMsg'])) {
                               ?>
                               <div class="alert alert-success">
                                   <?php 
                                    echo $_SESSION['cateAddedSuccessfullyMsg'];
                                    unset($_SESSION['cateAddedSuccessfullyMsg']);
                                   ?>
                               </div>
                               <?php
                            } ?>
                            <?php if (isset($_SESSION['cateDeletedSuccessfullyMsg'])) {
                                ?>
                                <div class="alert alert-success">
                                    <?php 
                                        echo $_SESSION['cateDeletedSuccessfullyMsg']; 
                                        unset($_SESSION['cateDeletedSuccessfullyMsg']);
                                    ?>
                                </div>
                                <?php
                            } ?>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table id="categories" class="table table-hover table-striped">
                                    <thead>
                                        <th>SrNo</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </thead>
                                    <?php
                                    $sqlCateData = "SELECT * FROM `tbl_categories` ORDER BY `id` DESC";
                                    $resultCateData = mysqli_query($con,$sqlCateData);
                                    if($resultCateData){
                                        if(mysqli_num_rows($resultCateData)>0){
                                            ?>
                                                <tbody>
                                                    <?php 
                                                    $srNo = 1; 
                                                    while ($rowCateData = mysqli_fetch_array($resultCateData)) {
                                                        ?>

                                                        <tr>
                                                            <td><?php echo $srNo; ?></td>
                                                            <td><?php echo $rowCateData['title']; ?></td>
                                                            <td><?php echo getStatusTitle($rowCateData['status']); ?></td>
                                                            <td>
                                                                <a href="editCategory.php?cateID=<?php echo $rowCateData['id']; ?>" class="btn btn-sm btn-success">Edit</a>&nbsp;
                                                                <a href="javascript:;" onclick="confDel(<?php echo $rowCateData['id']; ?>);" class="btn btn-sm btn-danger">Delete</a>
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
      // This will show 10 enteries per page
    $("#categories").DataTable();
  });
</script>
</body>

</html>