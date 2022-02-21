<?php include("includes/head.php"); ?>
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<style type="text/css">
    #categories_length,#categories_filter,#categories_paginate,#categories_info{
        padding: 10px !important;
    }
</style>
<?php  
$heading = "Event Details";
$groupID = $eventID = "";
if(isset($_GET['groupID']) && isset($_GET['eventID'])){
    $groupID = $_GET['groupID'];
    $eventID = $_GET['eventID'];

}else{
    header("location:index.php");
    exit();
}


if(isset($_GET['groupID']) && isset($_GET['status']) && isset($_GET['eventID'])){
    $eventID = $_GET['eventID'];
    $groupID = $_GET['groupID'];
    $status = $_GET['status'];
    $updatedBy = $_SESSION['userID'];
    $updatedDate = date("Y-m-d h:i:s");
    $sqlUpdateStatus = "UPDATE `tbl_events` SET `event_status` = '$status', `updatedBy` = '$updatedBy', `updatedDate` = '$updatedDate' WHERE `event_id` = '$eventID'";
    $resultUpdate = mysqli_query($con,$sqlUpdateStatus);
    if($resultUpdate){
        
        $_SESSION['updateStatusSuccess'] = "Event status has been updated successfully";
        header("location:viewSingleEventDetails.php?groupID=".$groupID."&eventID=".$eventID);
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
                                <h4 class="title"><?php echo $heading; ?></h4>
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
                                    $sql = "SELECT * FROM `tbl_events` WHERE `event_id` = '$eventID' ORDER BY `event_id` DESC";
                                    $result = mysqli_query($con,$sql);
                                    if($result){
                                        if(mysqli_num_rows($result)== 1){
                                            ?>
                                                <tbody>
                                                    <?php 
                                                    $srNo = 1; 
                                                    if ($row = mysqli_fetch_array($result)) {
                                                        $path = "../".$row['event_image'];
                                                        ?>
                                                        
                                                         <tr>
                                                            <th>Event Image</th>
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
                                                            <th>Event Name</th>
                                                            <td><?php echo $row['event_name']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Event Location</th>
                                                            <td><?php echo $row['event_location']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Event Date & Time</th>
                                                            <td><?php echo date("d F Y ",strtotime($row['event_startDate'])); ?> & <?php echo date("d H:i A ",strtotime($row['event_startTime'])); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Event Duration</th>
                                                            <td><?php echo $row['event_duration']." hour(s)"; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <th>Event Contact</th>
                                                            <td><?php echo $row['event_contact']; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <th>Event Type</th>
                                                            <td><?php if($row['event_type'] == "P"){
                                                                echo "Paid";
                                                            }else if($row['event_type'] == "F"){
                                                                echo "Free";
                                                            } ?></td>
                                                        </tr>

                                                        <tr>
                                                            <th>Event Price</th>
                                                            <td><?php echo $row['event_ticketPrice']." PKR"; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <th>Event Total Seats (Tickets)</th>
                                                            <td><?php echo $row['event_totalTickets']; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <th>Event Remaing Seats (Tickets)</th>
                                                            <td><?php echo $row['event_remainingTickets']; ?></td>
                                                        </tr>


                                                        <tr>
                                                            <th>Event Tickets Sale Start & End Date</th>
                                                            <td><?php echo date("d F Y ",strtotime($row['event_ticketSaleStartDate'])); ?>  to  <?php echo date("d F Y ",strtotime($row['event_ticketSaleEndDate'])); ?> </td>
                                                        </tr>
                                                        


                                                        <tr>
                                                            <th>Event Description</th>
                                                            <td><?php echo $row['event_description']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Group Status</th>
                                                             <td><?php echo getStatusTitle($row['event_status']); ?>

                                                                <?php if($row['event_status'] == "A"){ ?>
                                                                  <a href="viewSingleEventDetails.php?eventID=<?php echo $eventID; ?>&groupID=<?php echo $groupID; ?>&status=B" class="float-right btn btn-sm btn-danger">Block</a>
                                                                <?php }else if($row['event_status'] == "B"){
                                                                    ?>

                                                                  <a href="viewSingleEventDetails.php?eventID=<?php echo $eventID; ?>&groupID=<?php echo $groupID; ?>&status=A" class="float-right btn btn-sm btn-success">Active</a>
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