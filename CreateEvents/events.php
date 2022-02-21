<?php require("../connection.php"); ?>
<?php require("../functions.php"); ?>
<?php

$keywords = $location = $eventType = "";
$groupID = $eventCateID = "";
$actionURL = "events.php";
$currentDate = date("Y-m-d");
$whereClause = " WHERE `event_status` = 'A' AND DATE(`event_startDate`) >= '$currentDate' ";

if (isset($_GET['groupID'])) {
  $groupID = $_GET['groupID'];
  $whereClause .= " AND `event_groupID` = '$groupID' ";
  $actionURL = "events.php?groupID=" . $groupID;
}

if (isset($_GET['eventCateID'])) {
  $eventCateID = $_GET['eventCateID'];
  $whereClause .= " AND `event_cateID` = '$eventCateID' ";
  $actionURL = "events.php?eventCateID=" . $eventCateID;
}
if (isset($_POST['searchEvents'])) {
  if (!empty($_POST['location'])) {
    $location = $_POST['location'];
    $whereClause .= " AND `event_location` LIKE '%$location%'";
  }
  if (!empty($_POST['keywords'])) {
    $keywords = $_POST['keywords'];
    $whereClause .= " AND `event_name` LIKE '%$keywords%'";
  }
  if (!empty($_POST['eventType'])) {
    $eventType = $_POST['eventType'];
    $whereClause .= " AND `event_type` = '$eventType'";
  }
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Events</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />


  <link rel="stylesheet" href="events.css" />
</head>

<body>
  <!----------------HEADER START-------------------------------->
  <div class="group-header">
    <nav class="navbar navbar-expand-md navbar-dark">
      <div class="d-flex flex-md-fill flex-shrink-1 mx-auto justify-content-center order-0">
        <a class="navbar-brand link-image" href="../index.php"><img class="logo-image" src="images/logo.png" alt="Events Around" /></a>
      </div>

      <button class="navbar-toggler collapse-btn" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="line"></span>
        <span class="line"></span>
        <span class="line"></span>
      </button>
      <form action="" method="POST" class="form-inline">
        <!-- <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"> -->
        <div class="" style="display: flex;">
          <input type="search" name="keywords" placeholder="Search for keywords" aria-label="Search for keywordds" class="fsearch-bar search-bars" value="<?php echo $keywords; ?>" />
          <input style="border-radius:0px !important;" class="flocation-search-bar search-bars" aria-autocomplete="both" aria-controls="" aria-expanded="false" aria-haspopup="listbox" aria-label="Search for location by city or zip code" role="combobox" autocomplete="off" placeholder="Enter the location" class="flocation-search-bar" data-reach-combobox-input="" value="<?php echo $location; ?>" name="location" />
          <select class="flocation-search-bar search-bars" name="eventType">
            <option value="">Select Type</option>
            <option <?php if ($eventType == "F") {
                      echo "selected";
                    } ?> value="F">Free</option>
            <option <?php if ($eventType == "P") {
                      echo "selected";
                    } ?> value="P">Paid</option>

          </select>
        </div>

        <button type="submit" name="searchEvents" class="search-button">
                    <svg height="18" width="18" viewBox="0 0 18 18" class="search-icon">
                        <path
                            d="M11.89 10.477L16.415 15 15 16.414l-4.523-4.523a6 6 0 111.414-1.414zM7 11a4 4 0 100-8 4 4 0 000 8z">
                        </path>
                    </svg>
                </button>

        <div class="d-flex flex-md-fill flex-shrink-1 d-md-none">
          <!-- <button type="submit" class="search-button">
            <svg height="18" width="18" viewBox="0 0 18 18" class="search-icon">
              <path
                d="M11.89 10.477L16.415 15 15 16.414l-4.523-4.523a6 6 0 111.414-1.414zM7 11a4 4 0 100-8 4 4 0 000 8z">
              </path>
            </svg>
          </button> -->
        </div>
      </form>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto">
          <?php if (isset($_SESSION['onlineUserType']) && $_SESSION['onlineUserType'] == "O") {
            if (checkGroupExistAgainstOrganizerID($_SESSION['onlineUserID']) == 0) {
          ?>
              <li class="nav-item active">
                <a class="nav-link" id="new-group" href="createGroup/createGroup.php" target="_blank">Start a new group +</a>
              </li>
            <?php } else {
              $groupID = getOrganizerGroupID($_SESSION['onlineUserID']);
            ?>
              <li class="nav-item active">
                <a class="nav-link" id="new-group" href="groupWebPage/groupWebPage.php?groupID=<?php echo $groupID; ?>" target="_blank">My Group</a>
              </li>
          <?php
            }
          } ?>

          <li class="nav-item">
            <a class="nav-link" href="../Contact/Contact.php" target="_blank">Contact</a>
          </li>
          <?php if (checkLogin() == false) { ?>
            <li class="nav-item">
              <a class="nav-link" href="../Login/Login.php" target="_blank">Log in</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../Signup/Signup.php" target="_blank">Sign up</a>
            </li>
          <?php } else { ?>
            <div class="dropdown-menu">
              <?php
              if ($_SESSION['onlineUserType'] == "O") {
                if (checkGroupExistAgainstOrganizerID($_SESSION['onlineUserID']) == 0) {
              ?>
                  <a class="dropdown-item" href="group/createGroup/createGroup.php">Create Group</a>

                <?php  } else {
                ?>
                  <a class="dropdown-item" href="logout.php">My Group</a>

              <?php
                }
              } ?>
              <a class="dropdown-item" href="logout.php">Logout</a>

            </div>
          <?php } ?>

        </ul>
      </div>
    </nav>
  </div>
  <!------------------------------------------HEADER FINISHED--------------------->

  <div class="container-fluid text-center">
    <hr>
    <div class="row content">
      <div class="col-sm-2 sidenav">
        <!-- <p><a href="#">Link</a></p>
        <p><a href="#">Link</a></p>
        <p><a href="#">Link</a></p> -->
      </div>
      <div class="col-sm-8 text-left">
        <?php if (isset($_SESSION['eventErrMsg'])) {
        ?>
          <div class="alert alert-danger">
            <?php echo $_SESSION['eventErrMsg'];
            unset($_SESSION['eventErrMsg']); ?>
          </div>
        <?php
        } ?>
        <?php
        $sqlEvent = "SELECT * FROM `tbl_events` " . $whereClause . " ORDER BY `event_id` DESC";
        $resultEvent = mysqli_query($con, $sqlEvent);
        if ($resultEvent) {
          if (mysqli_num_rows($resultEvent) > 0) {
            while ($rowEvent = mysqli_fetch_array($resultEvent)) {
              $imagePath = "../" . $rowEvent['event_image'];
        ?>
              <div class="groups">
                <a href="SingleEventDetail.php?eventID=<?php echo $rowEvent['event_id']; ?>">
                  <?php if ($imagePath != "../" && file_exists($imagePath)) {
                  ?>
                    <img class="group-img" src="<?php echo $imagePath; ?>" alt="Event Image" />
                  <?php
                  } else {
                  ?>
                    <img class="group-img" src="https://images.pexels.com/photos/169573/pexels-photo-169573.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" alt="Group Image" />
                  <?php
                  } ?>

                  <div class="group-txt">
                    <h2><?php echo $rowEvent['event_name']; ?>
                      <?php if (checkLogin() == true) {
                        if ($_SESSION['onlineUserType'] == "O") {
                          if (getTotCountTicketPurchase($rowEvent['event_id']) > 0) {
                            $totCount = getTotCountTicketPurchase($rowEvent['event_id']);

                      ?>
                            <span title="Total Ticket Purchase Requests" class="badge badge-primary"><?php echo $totCount; ?></span>
                    </h2>
              <?php }
                        }
                      } ?>
              <p><?php echo $rowEvent['event_location']; ?></p>
              <p><?php
                  if (strlen($rowEvent['event_description']) > 100) {
                    echo substr($rowEvent['event_description'], 0, 100) . "....";
                  } else {
                    echo $rowEvent['event_description'];
                  }
                  ?></p>
              <br />
              <!-- <p>Members visibilty</p> -->
                  </div>
                </a>
              </div>
              <hr>

            <?php
            }
          } else {
            ?>
            <div class="alert alert-info">
              No Event(s) Found
            </div>
        <?php
          }
        }
        ?>



      </div>

      <div class="col-sm-2 sidenav">
        <div class="well">
          <p>ADS</p>
        </div>
        <div class="well">
          <p>ADS</p>
        </div>
      </div>
    </div>
  </div>
</body>

<!-- FOOTER OF THE GROUP PAGE -->
<?php include("../footer.php"); ?>

</html>