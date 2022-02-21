<?php include("includes/head.php");

$cateTitle = $cateStatus =  "";
$errorFlag = 0;
// Fucntion to destroy the session
function unsetSessions(){
  unset($_SESSION['cateTitle']);
  unset($_SESSION['cateStatus']);
}


//  this will be active when we will click on the ID
if(isset($_GET['cateID'])){
    $cateID = $_GET['cateID'];
    $sql = "SELECT * FROM `tbl_categories` WHERE `id` = '$cateID'";
    $result = mysqli_query($con,$sql);
    if($result){
      if(mysqli_num_rows($result) == 1){
        if($row = mysqli_fetch_array($result)){
            $cateTitle = $row['title'];
            $cateStatus = $row['status'];
            
        }
      }
    }
}

//  Check if the  button is pressed
if (isset($_POST['submitBtn'])) {

  // if Category title is empty give error
    if(empty($_POST['cateTitle'])){
      $_SESSION['cateTitleError'] = 'Category Title is Required';
      $errorFlag = 1;
      $cateTitle = "";

    }else{
       $cateTitle = mysqli_real_escape_string($con, $_POST['cateTitle'])    // this will remove the special character in the title
       ;
       $_SESSION['cateTitle'] = $_POST['cateTitle'];  // assign the value of category title to the session
    }
    
   if(empty($_POST['cateStatus'])){
        $_SESSION['cateStatusError'] = 'Category Status is Required';
        $errorFlag = 1;
        $cateStatus = "";
  
      }else{
         $cateStatus = mysqli_real_escape_string($con, $_POST['cateStatus']) 
         ;
         $_SESSION['cateStatus'] = $_POST['cateStatus'];
      }

    
    $updatedBy = $_SESSION['userID'];  // session is created when user is loged in
    $updatedTime = date('Y-m-d h:i:s');
    
   
   // Give error when the category is alreay present
    // function is called from function.php
     if(checkCategoryTitleExist($cateTitle,$cateID)>0){
      $_SESSION['error'] = "This Title :'".$cateTitle."' already Exists, please enter the new Category Title";
      header("location:editCategory.php?cateID=".$cateID);
      exit();
    }
  
    // if there is error then update the database
    if($errorFlag == 0){
        $sql = "UPDATE `tbl_categories` 
                    SET
                `title` = '$cateTitle',
                `status` = '$cateStatus',
                `updatedBy` = '$updatedBy',
                `updatedDate` = '$updatedTime'
                    WHERE `id` = '$cateID'";
    
        // if query is executed successfully then result will be true
        $result = mysqli_query($con,$sql);
        if($result){
            unsetSessions();
            $_SESSION['cateAddedSuccessfullyMsg'] = "Category Updated Successfully";
            header("location:addCategories.php");
            exit();
        }
    }else{
      $_SESSION['cateError'] = "Category is not added Successfully";
      header("location:editCategory.php?cateID=".$cateID);
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
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <?php if (isset($_SESSION['cateTitleError'])) { ?>
                <div class="alert alert-danger">
                    <?php 
                    echo $_SESSION['cateTitleError']; 
                    unset($_SESSION['cateTitleError']);
                    ?>
                </div>
            <?php } ?>
            <?php if (isset($_SESSION['cateError'])) { ?>
                <div class="alert alert-danger">
                    <?php 
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
                                <h4 class="title">Update Category</h4>
                            </div>
                            <div class="content">
                                <form action="editCategory.php?cateID=<?php echo $cateID; ?>" method="POST">
                                   <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">

                                                <input type="text" class="form-control" placeholder="Enter Category Title" name="cateTitle" value="<?php echo $cateTitle; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                             <div class="form-group">
                                                
                                                    <select name="cateStatus" id="cateStatus" class="form-control">
                                                        <option value="0">Please select</option>
                                                        <option <?php if($cateStatus == "A"){echo "selected";} ?> value="A">Active</option>
                                                        <option <?php if($cateStatus == "B"){echo "selected";} ?> value="B">Block</option>
                                                        
                                                    </select>
                                                
                                                </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="submitBtn" class="btn btn-info btn-fill pull-right">Update Category</button>
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
  
</body>

</html>