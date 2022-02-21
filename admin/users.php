<?php include("includes/head.php"); ?>
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<style type="text/css">
    #categories_length,#categories_filter,#categories_paginate,#categories_info{
        padding: 10px !important;
    }
</style>
<?php  
$userType = $heading = "" ;
if (isset($_GET['type'])) {
    $userType = $_GET['type'];
    if($userType == "O"){
        $heading = "Organizers";
    }else if($userType == "U"){
        $heading = "Users";
    }

}

if(isset($_GET['type']) && isset($_GET['userID']) && isset($_GET['status'])){
    $userType = $_GET['type'];
    $userID = $_GET['userID'];
    $status = $_GET['status'];
    $updatedBy = $_SESSION['userID'];
    $updatedDate = date("Y-m-d h:i:s");
    $sqlUpdateStatus = "UPDATE `tbl_users` SET `user_status` = '$status', `updatedBy` = '$updatedBy', `updatedDate` = '$updatedDate' WHERE `user_id` = '$userID'";
    $resultUpdate = mysqli_query($con,$sqlUpdateStatus);
    if($resultUpdate){
        if($userType == "O"){
            $msg = "Organizer status has been updated successfully";
        }else if($userType == "U"){
            $msg = "User status has been updated successfully";
        }
        $_SESSION['updateStatusSuccess'] = $msg;
        header("location:users.php?type=".$userType);
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
          

                <div class="row">
                    <div class="col-md-12">
                        <div class="card p-3">
                            <div class="header">
                                <h4 class="title">All <?php echo $heading; ?></h4>
                            </div>
                            <div style="padding: 10px;">
                            <?php if (isset($_SESSION['updateStatusSuccess'])) {
                               ?>
                               <div class="alert alert-success">
                                   <?php 
                                    echo $_SESSION['updateStatusSuccess'];
                                    unset($_SESSION['updateStatusSuccess']);
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
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Action</th>

                                        <th>Group</th>
                                    </thead>
                                    <?php
                                    $sql = "SELECT * FROM `tbl_users` WHERE `user_type` = '$userType' ORDER BY `user_id` DESC";
                                    $result = mysqli_query($con,$sql);
                                    if($result){
                                        if(mysqli_num_rows($result)>0){
                                            ?>
                                                <tbody>
                                                    <?php 
                                                    $srNo = 1; 
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $path = "../".$row['user_image'];
                                                        ?>

                                                        <tr>
                                                            <td><?php echo $srNo; ?></td>
                                                            <td>
                                                                <?php if($path !="../" && file_exists($path)){
                                                                    ?>
                                                                    <img  style="width:70px;height: 70px; border-radius: 100px;" src="<?php echo $path; ?>">
                                                                    <?php
                                                                }else{
                                                                    echo "N/A";
                                                                } ?>
                                                            </td>
                                                            <td><?php echo $row['user_name']; ?></td>
                                                            <td><?php echo $row['user_email']; ?></td>

                                                            <td><?php echo getStatusTitle($row['user_status']); ?></td>
                                                            <td>
                                                                <?php if($row['user_status'] == "B"){ ?>
                                                                <a href="users.php?userID=<?php echo $row['user_id']; ?>&type=<?php echo $userType; ?>&status=A" class="btn btn-sm btn-success">Active</a>&nbsp;
                                                                <?php }else if($row['user_status'] == "A"){ ?> 
                                                                     <a href="users.php?userID=<?php echo $row['user_id']; ?>&type=<?php echo $userType; ?>&status=B" class="btn btn-sm btn-danger">Block</a>&nbsp;
                                                                <?php } ?>
                                                            </td>
                                                            
                                                            <td>
                                                                <?php if($userType == "O"){ ?>
                                                                <a href="userGroups.php?organizerID=<?php echo $row['user_id']; ?>&type=<?php echo $userType; ?>" class="btn btn-sm btn-primary">Group</a>
                                                                <?php } ?>
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
    $("#categories").DataTable();
  });
</script>
</body>

</html>