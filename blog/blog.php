<?php 
include("../connection.php"); 
include("../functions.php");
if(!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0){
    $_SESSION['errors'] = array();
  }
$subscribeEmail = $subscribeCateID = "";
if(isset($_POST['subscribe'])){
     if(empty($_POST['subscribeEmail'])){
    array_push($_SESSION['errors'],"Email is Required");
      
    }else{
       $subscribeEmail = mysqli_real_escape_string($con, $_POST['subscribeEmail']);
       if(checkSubscribeEmailExist($subscribeEmail)>0){
        array_push($_SESSION['errors'],"Email already exist in our database");
       }
       
    }

    if(empty($_POST['subscribeCateID'])){
    array_push($_SESSION['errors'],"subscribe Category ID is Required");
      
    }else{
       $subscribeCateID = mysqli_real_escape_string($con, $_POST['subscribeCateID']);
       
    }
    if(!isset($_SESSION['errors']) || count($_SESSION['errors']) == 0){
        $createdBy = 0;
        $createdTime = date('Y-m-d h:i:s');

        $sql = "INSERT INTO `tbl_subscribe` (`subscribe_email`,`subscribe_cateID`,`createdBy`,`createdDate`)VALUES('$subscribeEmail','$subscribeCateID','$createdBy','$createdTime')";
                  $result = mysqli_query($con,$sql);
                  if($result){
                    
                    $_SESSION['subscribeAddedSuccessfullyMsg'] = "Email Added Successfully";
                    header("location:blog.php");
                    exit();
        }

    }


}

?>
<!-- <!DOCTYPE html> -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="Blog.css">

</head>

<body>
    
    <!--Header Start-->
    <nav class="navbar  navbar-expand-md bg-dark navbar-dark" id="header">
        <a class="navbar-brand logo-link" href="../index.php">
          <img src="images/logo.jpg" class="logo-image" alt="Event Around">
        </a>
        <h4 id="NavWebName"><b>Events Around</b></h4>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar" >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
          <ul class="navbar-nav navbar-right">
            <li class="nav-item ">
              <a class="nav-link" id="NavLink" href="../index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="NavLink" href="../group/group.php">Groups</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="NavLink" href="../Blog/Blog.php">Blog</a>
            </li>  
            <li class="nav-item">
              <a class="nav-link"  id="NavLink" href="../Contact/Contact.php">Contact Us</a>
            </li> 
            
         </ul>
      </div>
      </nav>
    <!--Header End-->

<!--Page Content-->

<div class="container-fluid">
    <!-- LEFT BLOG SECTION -->
    <div id="BlogLeft">
        <?php 
            $sqlAds = "SELECT * FROM `tbl_ads` WHERE `ad_status`  = 'A'"; 
            $resultAds = mysqli_query($con,$sqlAds);
            if ($resultAds) {
                if (mysqli_num_rows($resultAds)>0) {
                    while($rowAds = mysqli_fetch_assoc($resultAds)){
                        $adImage = "../admin/".$rowAds['ad_img_path'];
                        ?>

                            <div id="NewsDiv1">
                                <?php if($adImage != "../admin/" && file_exists($adImage)){
                                    ?>
                                        <img src="<?php echo $adImage; ?>" height="100%" width="100%">

                                    <?php
                                }else{
                                    ?>
                                        <img src="Images/news.png" height="100%" width="100%">

                                    <?php
                                } ?>
                             
                            </div>

                            <hr>
                        <?php
                    }
                }
            }
        ?>
        
        <a>See More</a>
        <h2 id="heading"><b>Most Read</b></h2>
        <?php 
            $sqlMostLike = "SELECT DISTINCT(`blogID`) as bid, COUNT(blogID) as tot FROM `tbl_blogs_like` GROUP BY `blogID` ORDER BY tot DESC LIMIT 5";
            $resultMostLike = mysqli_query($con,$sqlMostLike); 
            if ($resultMostLike) {
                if(mysqli_num_rows($resultMostLike)>0){
                    while($rowMostLike = mysqli_fetch_assoc($resultMostLike)){
                        $blog_ID = $rowMostLike['bid'];
                        $sqlBlogLike = "SELECT `blog_title`,`blog_id` FROM `tbl_blogs` WHERE `blog_id` = '$blog_ID'";
                        $resultBlogLike = mysqli_query($con,$sqlBlogLike);
                        if ($resultBlogLike) {
                            if(mysqli_num_rows($resultBlogLike) == 1){
                                if($rowBlogLike = mysqli_fetch_array($resultBlogLike)){
                                    $blogName = $rowBlogLike['blog_title'];
                                    ?>
                                    <a href="../Blog/ReadBlogs/BlogDetails.php?blogID=<?php echo $blog_ID; ?>" target="_blank" id="MRLink1"><?php echo $blogName; ?></a><br>
        
                                    <?php
                                }
                            }
                        }
                    }
                }

            }
        ?>
        <!-- <a href="https://helloendless.com/blog/" id="MRLink1">EndLess Events</a><br>
        <a href="https://techsytalk.com/blog/" id="MRLink2">Techsytalk</a><br>
        <a href="https://www.bizbash.com/" id="MRLink3">BizBash</a><br> -->
        <!-- <a id="SeeMore">See More</a> -->
        
        <hr>

        <h2 id="heading">Email Address</h2>
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


        <?php if(isset($_SESSION['subscribeAddedSuccessfullyMsg'] )){
            ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['subscribeAddedSuccessfullyMsg'] ; unset($_SESSION['subscribeAddedSuccessfullyMsg'] ); ?>
            </div>
            <?php
        } ?>
          
        <form action="blog.php" method="POST">
        <input required id="EmailTxtbox" name="subscribeEmail" type="text" style="width:40%; margin-left:5px; color: black;">
        <select required name="subscribeCateID" style="width:40%;height: 31px;color: black;">
            <?php $sqlCateData = "SELECT * FROM `tbl_categories` WHERE `status` = 'A' ORDER BY `id` DESC";
            $resultCateData = mysqli_query($con,$sqlCateData);
            if($resultCateData){
                if(mysqli_num_rows($resultCateData)>0){
                           while ($rowCateData = mysqli_fetch_array($resultCateData)) {
              ?>
              <option value="<?php echo $rowCateData['id']; ?>"><?php echo $rowCateData['title']; ?></option>
              <?php }
              }
              } ?>
                </select>
                <br>

        <button type="submit" name="subscribe" id="EventUpdatesbtn" >Get Event Updates</button>
        </form>
        <br>
        <hr>

        <div class="SocialIcon">
        <h2 id="heading">Stay in Touch</h2><br>
        <a id="a_Social1" href="#" class="fa fa-twitter"></a>
        <a id="a_Social2" href="#" class="fa fa-facebook"></a>
        <a id="a_Social3" href="#" class="fa fa-google"></a>
        <a id="a_Social4" href="#" class="fa fa-instagram"></a>
</div>
        <br>
        
    </div>

    <!-- RIGHT BLOG SECTION -->
    <div id="BlogRight">

        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
                <li data-target="#myCarousel" data-slide-to="3"></li>
                <li data-target="#myCarousel" data-slide-to="4"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                
                <div class="item active">
                    <img  src="images/1.jpg"  style="width:100%; height:100%;">
                    <div class="carousel-caption">
                      <p id="SliderPara">Exclusive Events,Priceless Memories</p>
                      
                      <button id="Sliderbtn">Read More</button>
                    </div>
                </div>

                <div class="item">
                    <img  src="images/2.jpg" style="width:100%; height:100%;">
                    <div class="carousel-caption">
                      <p id="SliderPara">Exclusive Events,Priceless Memories</p>
                      
                      <button id="Sliderbtn">Read More</button>
                    </div>
                </div>

                <div class="item">
                    <img  src="images/3.jpg"  style="width:100%; height:100%;">
                    <div class="carousel-caption">
                      <p id="SliderPara">Exclusive Events,Priceless Memories</p>
                      
                      <button id="Sliderbtn">Read More</button>
                    </div>
                </div>

                <div class="item">
                    <img  src="images/4.jpg"  style="width:100%; height:100%;">
                    <div class="carousel-caption">
                      <p id="SliderPara">Exclusive Events,Priceless Memories</p>
                      
                      <button id="Sliderbtn">Read More</button>
                    </div>
                </div>

                <div class="item">
                    <img  src="images/5.jpg"  style="width:100%; height:100%;">
                    <div class="carousel-caption">
                      <p id="SliderPara">Exclusive Events,Priceless Memories</p>
                      
                      <button id="Sliderbtn">Read More</button>
                    </div>
                </div>

            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    
        <hr>
        <h1 style="text-align: center;"><b>Blogs</b></h1>
        <?php 
            $sql = "SELECT * FROM `tbl_blogs` WHERE `blog_status` = 'A' ORDER BY `blog_id`";
            $result = mysqli_query($con,$sql);
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)){
                        $path = "../admin/".$row['blog_image'];
                        ?>
                        <h3 style="margin-left: 10px;"><?php echo $row['blog_title']; ?></h3>
                        <div id="Blog1">
                       
                         <a href="../Blog/ReadBlogs/BlogDetails.php?blogID=<?php echo $row['blog_id']; ?>" target="_blank">
                            <?php if($path != "../admin/blogsImages/" && file_exists($path)){
                                ?>
                                 <img src="<?php echo $path; ?>" alt="Fashion Blog" width="100%" height="100%">
                                <?php
                            }else{ ?>
                            <img src="Images/fashion.jpg" alt="Fashion Blog" width="100%" height="100%">
                        <?php } ?>
                        </a> 
                        </div>
                        <hr>
                       
                        <?php
                    }
                }
            }
        ?>

        
        
        <!-- <a>See More</a> -->

        <br>
        <hr>
        <!-- <h2><b>Top Stories</b></h2>
        <div class="container">
            <div class="row">
              <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3" id="Story1">
                <a href="https://www.trtworld.com/magazine/oic-slammed-for-its-weak-response-to-israeli-violence-on-palestine-46733"><img src="data:image/jpeg;base64,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" width="100%" height="100%"></a>
              </div>
              <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3" id="Story2">
                               <a href="https://www.trtworld.com/magazine/oic-slammed-for-its-weak-response-to-israeli-violence-on-palestine-46733"><img src="data:image/jpeg;base64,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" width="100%" height="100%"></a>

              </div>
              <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3" id="Story3">
                              <a href="https://www.trtworld.com/magazine/oic-slammed-for-its-weak-response-to-israeli-violence-on-palestine-46733"><img src="data:image/jpeg;base64,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" width="100%" height="100%"></a>

              </div>
              <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3" id="Story4">
                                <a href="https://www.trtworld.com/magazine/oic-slammed-for-its-weak-response-to-israeli-violence-on-palestine-46733"><img src="data:image/jpeg;base64,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" width="100%" height="100%"></a>

              </div>
            </div>
            <a>See More</a>
         </div> -->
          
        <br>
        <hr>
        <h2><b>Event Categories</b></h2>
        <div id="EventCategories">
          <div id='label-wrapper'>
            <div id='Label1'>
                <?php $sqlCateData = "SELECT * FROM `tbl_categories` WHERE `status` = 'A' ORDER BY `id` DESC";
            $resultCateData = mysqli_query($con,$sqlCateData);
            if($resultCateData){
                if(mysqli_num_rows($resultCateData)>0){
                   while ($rowCateData = mysqli_fetch_array($resultCateData)) {
      ?>
                    <a href="../CreateEvents/events.php?eventCateID=<?php echo $rowCateData['id']; ?>" class="category_botton text-center"><?php echo $rowCateData['title']; ?></a>
      
      <?php }
    }
      } ?>
        
            </div>
    
        </div>
        </div>
    </div>

</div>
<!---------------Footer Start--------------->
<section id="footer">
	<div class="container">
  <div class="row Upper-footer">
	<div class ="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<br>
	<h1 style="font-family: 'Dancing Script', cursive;">Events Around</h1>
		<p style="font-family: 'Pacifico', cursive;">Exclusive Events, Priceless memories</p>

	</div>
	
  </div>
  <hr class="footer-line">

  <br>

		<div class="row text-center text-xs-center text-sm-left text-md-left">
			<div class="col-xs-12 col-sm-4 col-md-4">
				<h5>Your Accounts</h5>
				<ul class="list-unstyled quick-links">
					<li><a href="../Signup/Signup.php">Sign in</a></li>
					<li><a href="../Login/Login.php">Log in</a></li>
				</ul>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4">
				<h5>Discover</h5>
				<ul class="list-unstyled quick-links">
					<li><a href="../group/group.php">Group</a></li>
					<!-- <li><a href="../CreateEvents/creatEvents.html"target="_blank">Create Events</a></li> -->
					
		
				</ul>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4">
				<h5>Quick links</h5>
				<ul class="list-unstyled quick-links">
					<li><a href="../Contact/Contact.php" >Contact us</a></li>
					<li><a href="../Blog/Blog.php" >Blog</a></li>
					
				</ul>
			   
			</div>
		</div>
		
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-5">
			   
				<ul class="list-unstyled list-inline social text-center">
					<li class="list-inline-item"><a href=""><i class="fa fa-facebook"></i></a></li>
					<li class="list-inline-item"><a href=""><i class="fa fa-twitter"></i></a></li>
					<li class="list-inline-item"><a href=""><i class="fa fa-instagram"></i></a></li>
					<li class="list-inline-item"><a href=""><i class="fa fa-google-plus"></i></a></li>
					<li class="list-inline-item"><a href="" target="_blank"><i class="fa fa-envelope"></i></a></li>
				</ul>
			</div>
			<hr>
		</div>	
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center text-white">
				<p class="h6">© All right Reversed.<a class="text-green ml-2" href="../index.php"><b>Events Around</b></a></p>
			</div>
			<hr>
		</div>	
	</div>
</section>

<!----------Footer End---------->

    

</body>

</html>