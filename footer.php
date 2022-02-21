<section id="footer">
		<div class="container">
      <div class="row Upper-footer">
        <div class ="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <br>
        <h1 style="font-family: 'Dancing Script', cursive;">Events Around</h1>
		<p style="font-family: 'Pacifico', cursive;">Exclusive Events, Priceless memories</p>

        <!-- <button id="footerbtn"><a href="http://localhost/events_org_R/group/createGroup/createGroup.php" >Get Started</a></button></p> -->
    
        </div>
        
      </div>
      <hr class="footer-line">

      <br>

			<div class="row text-center text-xs-center text-sm-left text-md-left">
				<div class="col-xs-12 col-sm-4 col-md-4">
					<h5>Your Accounts</h5>
					<ul class="list-unstyled quick-links">
						<li><a href="http://localhost/events_org_R/Signup/Signup.php">Sign in</a></li>
						<li><a href="http://localhost/events_org_R/Login/Login.php" >Log in</a></li>
					</ul>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
					<h5>Discover</h5>
					<ul class="list-unstyled quick-links">
						<li><a href="http://localhost/events_org_R/group/group.php" >Group</a></li>
						<li><a href="http://localhost/events_org_R/CreateEvents/creatEvents.php">Create Events</a></li>
						
			
					</ul>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4">
					<h5>Quick links</h5>
					<ul class="list-unstyled quick-links">
						<li><a href="http://localhost/events_org_R/Contact/Contact.php" >Contact us</a></li>
						<li><a href="http://localhost/events_org_R/Blog/Blog.php" >Blog</a></li>
						
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
						<li class="list-inline-item"><a href="" ><i class="fa fa-envelope"></i></a></li>
					</ul>
				</div>
				<hr>
			</div>	
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center text-white">
					<p class="h6">© All right Reversed.<a class="text-green ml-2" href="Home/Home.php" ><b>Events Around</b></a></p>
				</div>
				<hr>
			</div>	
		</div>
	</section>

	<script type="text/javascript">
	$(document).ready(function() {
	<?php if (checkLogin() == true) { ?>	
	window.setInterval(function(){
  	//getCustomerChat
  		//$("#counterLi").load("getChatCounter.php"); 
  		$(".counterInbox").load("getChatCounter.php");
  // 		$('#msgBox').animate({
		// 	   scrollTop: $('#msgBox').get(0).scrollHeight
		// }, 100);	
		
	}, 5000);
	<?php } ?>
	});
</script>

