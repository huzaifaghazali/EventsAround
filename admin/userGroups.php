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
if (isset($_GET['type']) && isset($_GET['organizerID'])) {
    $userType = $_GET['type'];
    $organizerID = $_GET['organizerID'];
    
    if($userType == "O"){
        $heading = "Organizer's Group";
    }else if($userType == "U"){
        $heading = "Users";
    }

}

if(isset($_GET['type']) && isset($_GET['groupID']) && isset($_GET['status']) && isset($_GET['organizerID'])){
    $organizerID = $_GET['organizerID'];
    $userType = $_GET['type'];
    $groupID = $_GET['groupID'];
    $status = $_GET['status'];
    $updatedBy = $_SESSION['userID'];
    $updatedDate = date("Y-m-d h:i:s");
    $sqlUpdateStatus = "UPDATE `tbl_groups` SET `group_status` = '$status', `updatedBy` = '$updatedBy', `updatedDate` = '$updatedDate' WHERE `group_id` = '$groupID'";
    $resultUpdate = mysqli_query($con,$sqlUpdateStatus);
    if($resultUpdate){
        
        $_SESSION['updateStatusSuccess'] = "Group status has been updated successfully";
        header("location:userGroups.php?type=".$userType."&organizerID=".$organizerID);
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
                                <h4 class="title"><?php echo $heading; ?> Details</h4>
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
                                <table class="table table-hover table-striped">
                                   
                                    <?php
                                    $sql = "SELECT * FROM `tbl_groups` WHERE `group_organizerID` = '$organizerID' ORDER BY `group_id` DESC";
                                    $result = mysqli_query($con,$sql);
                                    if($result){
                                        if(mysqli_num_rows($result)== 1){
                                            ?>
                                                <tbody>
                                                    <?php 
                                                    $srNo = 1; 
                                                    if ($row = mysqli_fetch_array($result)) {
                                                        $path = "../".$row['group_image'];
                                                        ?>
                                                        <tr><th>Events</th><td> <a class="float-right mr-2 btn btn-sm btn-success" href="events.php?groupID=<?php echo $row['group_id']; ?>">Events</a></td></tr>
                                                         <tr>
                                                            <th>Group Image</th>
                                                            <td>
                                                                <?php if($path !="../" && file_exists($path)){ ?>
                                                                <img  style="width:70px;height: 70px; border-radius: 100px;" src="<?php echo $path; ?>">
                                                                <?php
                                                                }else{
                                                                    echo "N/A";
                                                                } ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Group Name</th>
                                                            <td><?php echo $row['group_name']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Group Location</th>
                                                            <td><?php echo $row['group_location']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Group Description</th>
                                                            <td><?php echo $row['group_description']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Group Status</th>
                                                             <td><?php echo getStatusTitle($row['group_status']); ?>

                                                                <?php if($row['group_status'] == "A"){ ?>
                                                                  <a href="userGroups.php?organizerID=<?php echo $organizerID; ?>&type=<?php echo $userType; ?>&groupID=<?php echo $row['group_id']; ?>&status=B" class="float-right btn btn-sm btn-danger">Block</a>
                                                                <?php }else if($row['group_status'] == "B" || $row['group_status'] == "D"){
                                                                    ?>

                                                                  <a href="userGroups.php?organizerID=<?php echo $organizerID; ?>&type=<?php echo $userType; ?>&groupID=<?php echo $row['group_id']; ?>&status=A" class="float-right btn btn-sm btn-success">Active</a>
                                                                    <?php
                                                                } ?>
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
     
</body>

</html>