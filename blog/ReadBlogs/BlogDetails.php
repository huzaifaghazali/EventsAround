<?php 
include("../../connection.php");
 include("../../functions.php"); 

$blogID = "";
if (isset($_GET['blogID'])) {
  $blogID = $_GET['blogID'];
  $sql = "SELECT * FROM `tbl_blogs` WHERE `blog_id` = '$blogID'";
  $result = mysqli_query($con,$sql);
  if ($result) {
    if (mysqli_num_rows($result) == 1) {
      if ($row = mysqli_fetch_array($result)) {
        $blogTitle = $row['blog_title'];
        $blogDescription = $row['blog_description'];
        $blogImage = "../../admin/".$row['blog_image'];
        $blogDate = date("d F Y ",strtotime($row['createdDate']));


      }
    }
  }
}else{
 header("location:../blog.php");
 exit();
}
?>
<!DOCTYPE html>
<html>
<title>Fashion Blog</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open Sans">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 
<link rel="stylesheet" href="Blog1.css">

<body class="w3-light-grey">

<!-- Navigation bar with social media icons -->
<div class="w3-bar w3-black w3-hide-small">
  <a href="#" class="w3-bar-item w3-button"><i class="fa fa-facebook-official"></i></a>
  <a href="#" class="w3-bar-item w3-button"><i class="fa fa-instagram"></i></a>
  <a href="#" class="w3-bar-item w3-button"><i class="fa fa-snapchat"></i></a>
  <a href="#" class="w3-bar-item w3-button"><i class="fa fa-flickr"></i></a>
  <a href="#" class="w3-bar-item w3-button"><i class="fa fa-twitter"></i></a>
  <a href="#" class="w3-bar-item w3-button"><i class="fa fa-linkedin"></i></a>
  <a href="#" class="w3-bar-item w3-button w3-right"><i class="fa fa-search"></i></a>
</div>
  
<!-- w3-content defines a container for fixed size centered content, 
and is wrapped around the whole page content, except for the footer in this example -->
<div class="w3-content" style="max-width:1600px">

  <!-- Header -->
  <header class="w3-container w3-center w3-padding-48 w3-white">
    <h1 class="w3-xxxlarge"><b>Event Around</b></h1>
    <h6>Welcome to the blog of <span class="w3-tag">Event Around </span></h6>
  </header>

  <!-- Image header -->
 <!--  <header class="w3-display-container w3-wide" id="home">
    <img class="w3-image" src="Images/jane.jpg" alt="Fashion Blog" width="1600" height="1060">
    <div class="w3-display-left w3-padding-large">
      <h1 class="w3-text-white">Ghazali's</h1>
      <h1 class="w3-jumbo w3-text-white w3-hide-small"><b>FASHION BLOG</b></h1>
      <h6><button class="w3-button w3-white w3-padding-large w3-large w3-opacity w3-hover-opacity-off" onclick="document.getElementById('subscribe').style.display='block'">SUBSCRIBE</button></h6>
    </div>
  </header> -->

  <!-- Grid -->
  <div class="w3-row w3-padding w3-border">
<?php ?>
    <!-- Blog entries -->
    <div class="w3-col l8 s12">
    
      <!-- Blog entry -->
      <div class="w3-container w3-white w3-margin w3-padding-large">
        <div class="w3-center">
          <h3><?php echo $blogTitle; ?></h3>
          <h5>Publish Date <span class="w3-opacity"><?php echo $blogDate; ?></span></h5>
        </div>

        <div class="w3-justify">
          <?php if($blogImage != "../../admin" && file_exists($blogImage)){ ?>
            <img src="<?php echo $blogImage; ?>" alt="Girl Hat" style="width:100%" class="w3-padding-16">
          <?php }else{ ?>
            <img src="Images/girl_hat.jpg" alt="Girl Hat" style="width:100%" class="w3-padding-16">
          
          <?php } ?>
          <p><strong>More Hats!</strong> <?php echo $blogDescription; ?> </p>
          <?php if(isset($_SESSION['onlineUserID'])){
            $userID = $_SESSION['onlineUserID'];

          ?>
          <p class="w3-left"><button class="w3-button w3-white w3-border" onclick="likeFunction(this,'<?php echo $blogID; ?>','<?php echo $userID; ?>')">
            <?php if(checkBlogPostAreadyLikedByUser($blogID,$userID) == 0){ ?>
              <b><i class="fa fa-thumbs-up"></i> Like</b>  
            <?php }else{
              echo "✓ Liked";
            } ?>
            
          </button></p>
          <?php } ?>
          <?php 

          $sqlBlogCommnets = "SELECT * FROM `tbl_blogs_comments` WHERE `blogID` = '$blogID' ORDER BY `blog_comment_id` DESC";
            $resultBlogComment = mysqli_query($con,$sqlBlogCommnets);

            $totComments = mysqli_num_rows($resultBlogComment);
          ?>
          
          <p class="w3-right"><button class="w3-button w3-black" onclick="myFunction('demo1')" id="myBtn"><b>Replies  </b> <span class="w3-tag w3-white"><?php echo $totComments; ?></span></button></p>
          <p class="w3-clear"></p>
           <?php if(isset($_SESSION['onlineUserID'])){
            $userID = $_SESSION['onlineUserID'];

          ?>
          <div class="w3-row w3-margin-bottom" id="demo1" style="display:none">
            <?php
             
            if ($resultBlogComment) {
              if(mysqli_num_rows($resultBlogComment)>0){
                while($rowComments = mysqli_fetch_array($resultBlogComment)){
                  $userName = getUserName($rowComments['userID']);
                  $userImage = "../../".getUserImg($rowComments['userID']);
                  $comment = $rowComments['blog_comment'];
                  $createdDate = date("F d, Y",strtotime($rowComments['createdDate']));
                  ?>

            <hr>
              <div class="w3-col l2 m3">
                <?php if($userImage !="../../" && file_exists($userImage)){
                  ?>
                  <img src="<?php echo $userImage; ?>" style="width:90px;">  
                  <?php
                }else{
                  ?>
                  <img src="../../uploads/users.png" style="width:90px;">
                  <?php
                } ?>
                
              </div>
              <div class="w3-col l10 m9">
                <h4><?php echo $userName; ?> <span class="w3-opacity w3-medium"><?php echo $createdDate; ?></span></h4>
                <p><?php echo $comment; ?></p>
              </div>
              <?php
                }
              }
            }
            ?>
          </div>
          <div class="w3-row w3-margin-bottom" >
            <input type="hidden" name="blogID" id="blogID" value="<?php echo $blogID; ?>">
            <input type="hidden" name="userID" id="userID" value="<?php echo $userID; ?>">
            
            <textarea style="width: 100%;" rows="5" id="msg"></textarea>
          </div>
        <?php } ?>
        </div>
      </div>
      <hr>

      <!-- Blog entry -->
    
      <!-- Blog entry -->
     
      
    <!-- END BLOG ENTRIES -->
    </div>

    <!-- About/Information menu -->
    <div class="w3-col l4">
      <!-- About Card -->

      <!-- Posts -->
      <div class="w3-white w3-margin">
        <div class="w3-container w3-padding w3-black">
          <h4>Latest Posts</h4>
        </div>
        <ul class="w3-ul w3-hoverable w3-white">
          <?php 
          $sql = "SELECT * FROM `tbl_blogs` WHERE `blog_id` != '$blogID' ORDER BY `blog_id` LIMIT 5";
          $result = mysqli_query($con,$sql);
          if ($result) {
            if(mysqli_num_rows($result) > 0){
              while($row = mysqli_fetch_array($result)){
                 $latest_blogTitle = $row['blog_title'];
                  $latest_blogDescription = $row['blog_description'];
                  $latest_blogImage = "../../".$row['blog_image'];
                  $latest_blogDate = date("d F Y ",strtotime($row['createdDate']));

                ?>
                <li class="w3-padding-16">
                  <?php if($latest_blogImage != "../../" && file_exists($latest_blogImage)){
                    ?>

                  <img src="<?php echo $latest_blogImage; ?>" alt="Image" class="w3-left w3-margin-right" style="width:50px">
                    <?php
                  }else{
                    ?>

                  <img src="../../uploads/users.png" alt="Image" class="w3-left w3-margin-right" style="width:50px">
                    <?php
                  } ?>
                  <span class="w3-large"><a href="BlogDetails.php?blogID=<?php echo $row['blog_id']; ?>"><?php echo $latest_blogTitle; ?></a></span>
                  <br>
                  <span><small>Publish Date : <?php echo $latest_blogDate; ?></small></span>
                </li>
                      
                <?php
              }
            }else{
              echo "<br><b>No Post(s) Found</b>";
            }
          }
          ?>
          
        </ul>
      </div>
      <hr>

      
     
      <div class="w3-white w3-margin">
        <div class="w3-container w3-padding w3-black">
          <h4>Follow Me</h4>
        </div>
        <div class="w3-container w3-xlarge w3-padding">
          <i class="fa fa-facebook-official w3-hover-opacity"></i>
          <i class="fa fa-instagram w3-hover-opacity"></i>
          <i class="fa fa-snapchat w3-hover-opacity"></i>
          <i class="fa fa-pinterest-p w3-hover-opacity"></i>
          <i class="fa fa-twitter w3-hover-opacity"></i>
          <i class="fa fa-linkedin w3-hover-opacity"></i>
        </div>
      </div>
      <hr>
      
      <!-- Subscribe -->
      <div class="w3-white w3-margin">
        <div class="w3-container w3-padding w3-black">
          <h4>Subscribe</h4>
        </div>
        <div class="w3-container w3-white">
          <p>Enter your e-mail below and get notified on the latest blog posts.</p>
          <p><input class="w3-input w3-border" type="text" placeholder="Enter e-mail" style="width:100%"></p>
          <p><button type="button" onclick="document.getElementById('subscribe').style.display='block'" class="w3-button w3-block w3-red">Subscribe</button></p>
        </div>
      </div>

    <!-- END About/Intro Menu -->
    </div>

  <!-- END GRID -->
  </div>

<!-- END w3-content -->
</div>

<!-- Subscribe Modal -->
<div id="subscribe" class="w3-modal w3-animate-opacity">
  <div class="w3-modal-content" style="padding:32px">
    <div class="w3-container w3-white">
      <i onclick="document.getElementById('subscribe').style.display='none'" class="fa fa-remove w3-transparent w3-button w3-xlarge w3-right"></i>
      <h2 class="w3-wide">SUBSCRIBE</h2>
      <p>Join my mailing list to receive updates on the latest blog posts and other things.</p>
      <p><input class="w3-input w3-border" type="text" placeholder="Enter e-mail"></p>
      <button type="button" class="w3-button w3-block w3-padding-large w3-red w3-margin-bottom" onclick="document.getElementById('subscribe').style.display='none'">Subscribe</button>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="w3-container w3-dark-grey" style="padding:32px">
  <a href="#" class="w3-button w3-black w3-padding-large w3-margin-bottom"><i class="fa fa-arrow-up w3-margin-right"></i>To the top</a>
  <p>Powered by <a href="" target="_blank">Events Around</a></p>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
// Toggle between hiding and showing blog replies/comments
document.getElementById("myBtn").click();
function myFunction(id) {
  var x = document.getElementById(id);
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}
$("#msg").on('keypress',function(e) {
    if(e.which == 13) {
        if (e.key === 'Enter' || e.keyCode === 13) {
       var uid = $("#userID").val();
       var bid = $("#blogID").val();
       var now = new Date(Date.now());
      var currentDate = now.toLocaleDateString();
      var hours = now.getHours();
      var minutes = now.getMinutes();
      var ampm = hours >= 12 ? 'PM' : 'AM';
      hours = hours % 12;
      hours = hours ? hours : 12; // the hour '0' should be '12'
      minutes = minutes < 10 ? '0'+minutes : minutes;
      var formatted = currentDate +" - "+hours + ':' + minutes + ' ' + ampm;

    var comment = $("#msg").val(); 
    if(comment != ""){
    //   alert(uid+"="+bid+" "+comment)
    $.ajax({
        url:"blogComment.php",
        type:"POST",
        data:{
          userID:uid,
          blogID:bid,
          blogComment : comment
        },
        success:function(response) {
            if(response == 1){
              <?php if(isset($_SESSION['onlineUserID'])){
                if(getUserImg($_SESSION['onlineUserID']) != ""){
                  
                  ?>
                  var path = "<?php getUserImg($_SESSION['onlineUserID']); ?>";
                   var userImage  = "../../"+path;
                   if(userImage == "../../"){
                    var userImage  = "../../uploads/users.png"; 
                   }
                  <?php
                }else{
                  ?>
                   var userImage  = "../../uploads/users.png";
                  <?php
                }
              } ?>

              <?php if(isset($_SESSION['onlineUserFullName'])){ ?>
                var username = "<?php echo $_SESSION['onlineUserFullName']; ?>";
              <?php }else{
                ?>
               var username = "User Name";
             <?php } ?>
               
                var appendDiv = ' <hr><div style="clear:both;"></div><br><div class="w3-col l2 m3"><img src="'+userImage+'" style="width:90px;"></div><div class="w3-col l10 m9"><h4>'+username+' <span class="w3-opacity w3-medium">'+formatted+'</span></h4><p>'+comment+'</p></div>';
                $("#demo1").append(appendDiv); //append msg
              $("#msg").val("");  
    
            }else{
                alert("Something going worng please try later");
            }
       
        
       },
       error:function(){
        alert("error");
       }

      });
  
    }
     
      }
    }
});
function likeFunction(x,bid,uid) {


  $.ajax({
        url:"blogLike.php",
        type:"POST",
        data:{
          userID:uid,
          blogID:bid,
        },
        success:function(response) {
            if(response == 1){
                x.style.fontWeight = "bold";
                x.innerHTML = "✓ Liked";
            }else if(response == 2){
                x.innerHTML = '<b><i class="fa fa-thumbs-up"></i> Like</b>';
            }else{
                alert("Something going worng please try later");
            }
       
        
       },
       error:function(){
        alert("error");
       }

      });
  
}
</script>

</body>
</html>
