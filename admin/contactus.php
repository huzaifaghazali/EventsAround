<?php include("includes/head.php"); ?>
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<style type="text/css">
    #categories_length,#categories_filter,#categories_paginate,#categories_info{
        padding: 10px !important;
    }
</style>
<?php  
$sql = "UPDATE `tbl_contact_us` SET `adminNoti` =  '1' WHERE `adminNoti` = '0'";
$result = mysqli_query($con,$sql);
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
                                <h4 class="title">All Messages</h4>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table id="adsTbl" class="table table-hover table-striped">
                                    <thead>
                                        <th>SrNo</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                    </thead>
                                    <?php
                                    $sqlContactUsData = "SELECT * FROM `tbl_contact_us` ORDER BY `contactus_id` DESC";
                                    $resultContactUsData = mysqli_query($con,$sqlContactUsData);
                                    if($resultContactUsData){
                                        if(mysqli_num_rows($resultContactUsData)>0){
                                            ?>
                                                <tbody>
                                                    <?php 
                                                    $srNo = 1; 
                                                    while ($rowContactUsData = mysqli_fetch_array($resultContactUsData)) {
                                                        ?>

                                                        <tr>
                                                            <td><?php echo $srNo; ?></td>
                                                            
                                                            <td>
                                                            <?php echo $rowContactUsData['contactus_name'] ?>
                                                            </td>
                                                            <td><?php echo $rowContactUsData['contactus_email']; ?></td>
                                                            <td><?php echo $rowContactUsData['contactus_msg']; ?></td>
                                                            <td>
                                                                <?php echo date("d-m-Y",strtotime($rowContactUsData['contactus_data'])); ?>
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