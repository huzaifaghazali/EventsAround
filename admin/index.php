<?php include("includes/head.php"); ?>

<body class="dark-edition">
  <div class="wrapper ">
    <?php include("includes/sidebar.php"); ?>
    <div class="main-panel">
      <!-- Navbar -->
      <?php include("includes/topnav.php"); ?>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-list-ul" aria-hidden="true"></i>
                    <!-- <i class="material-icons">content_copy</i> -->
                  </div>
                  <p class="card-category">Categories</p>
                  <h3 class="card-title"><?php echo getTotalStats('tbl_categories'); ?>
                    <small>Total</small>
                  </h3>
                </div>
                
              </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-list-ul" aria-hidden="true"></i>
                    
                    <!-- <i class="material-icons">store</i> -->
                  </div>
                  <p class="card-category">Categories</p>
                  <h3 class="card-title"><?php echo getTotalStats('tbl_categories','status','A'); ?> <small>Active</small></h3>
                </div>
                
              </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-list-ul" aria-hidden="true"></i>
                    
                    <!-- <i class="material-icons">info_outline</i> -->
                  </div>
                  <p class="card-category">Categories</p>
                  <h3 class="card-title"><?php echo getTotalStats('tbl_categories','status','B'); ?> <small>Blocked</small></h3>
                </div>
                
              </div>
            </div>
            <!-- <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-twitter"></i>
                  </div>
                  <p class="card-category">Followers</p>
                  <h3 class="card-title">+245</h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i> Just Updated
                  </div>
                </div>
              </div>
            </div> -->
          </div>


          <div class="row">
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-list-ul" aria-hidden="true"></i>
                    <!-- <i class="material-icons">content_copy</i> -->
                  </div>
                  <p class="card-category">Blogs</p>
                  <h3 class="card-title"><?php echo getTotalStats('tbl_blogs'); ?>
                    <small>Total</small>
                  </h3>
                </div>
                
              </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-list-ul" aria-hidden="true"></i>
                    
                    <!-- <i class="material-icons">store</i> -->
                  </div>
                  <p class="card-category">Blogs</p>
                  <h3 class="card-title"><?php echo getTotalStats('tbl_blogs','blog_status','A'); ?> <small>Active</small></h3>
                </div>
                
              </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-list-ul" aria-hidden="true"></i>
                    
                    <!-- <i class="material-icons">info_outline</i> -->
                  </div>
                  <p class="card-category">Blogs</p>
                  <h3 class="card-title"><?php echo getTotalStats('tbl_blogs','blog_status','B'); ?> <small>Blocked</small></h3>
                </div>
                
              </div>
            </div>
            
          </div>


          <div class="row">
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-user-secret" aria-hidden="true"></i>
                    <!-- <i class="material-icons">content_copy</i> -->
                  </div>
                  <p class="card-category">Organizers</p>
                  <h3 class="card-title"><?php echo getTotalStats('tbl_users','','','user_type','O'); ?>
                    <small>Total</small>
                  </h3>
                </div>
                
              </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-user-secret" aria-hidden="true"></i>
                    
                    <!-- <i class="material-icons">store</i> -->
                  </div>
                  <p class="card-category">Organizers</p>
                  <h3 class="card-title"><?php echo getTotalStats('tbl_users','user_status','A','user_type','O'); ?> <small>Active</small></h3>
                </div>
                
              </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-user-secret" aria-hidden="true"></i>
                    
                    <!-- <i class="material-icons">info_outline</i> -->
                  </div>
                  <p class="card-category">Organizers</p>
                  <h3 class="card-title"><?php echo getTotalStats('tbl_users','user_status','B','user_type','O'); ?> <small>Blocked</small></h3>
                </div>
                
              </div>
            </div>
            
          </div>


           <div class="row">
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <!-- <i class="material-icons">content_copy</i> -->
                  </div>
                  <p class="card-category">Users</p>
                  <h3 class="card-title"><?php echo getTotalStats('tbl_users','','','user_type','U'); ?>
                    <small>Total</small>
                  </h3>
                </div>
                
              </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    
                    <!-- <i class="material-icons">store</i> -->
                  </div>
                  <p class="card-category">Users</p>
                  <h3 class="card-title"><?php echo getTotalStats('tbl_users','user_status','A','user_type','U'); ?> <small>Active</small></h3>
                </div>
                
              </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    
                    <!-- <i class="material-icons">info_outline</i> -->
                  </div>
                  <p class="card-category">Users</p>
                  <h3 class="card-title"><?php echo getTotalStats('tbl_users','user_status','B','user_type','U'); ?> <small>Blocked</small></h3>
                </div>
                
              </div>
            </div>
            
          </div>



          <div class="row">
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-list-ul" aria-hidden="true"></i>
                    <!-- <i class="material-icons">content_copy</i> -->
                  </div>
                  <p class="card-category">Ads</p>
                  <h3 class="card-title"><?php echo getTotalStats('tbl_ads'); ?>
                    <small>Total</small>
                  </h3>
                </div>
                
              </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-list-ul" aria-hidden="true"></i>
                    
                    <!-- <i class="material-icons">store</i> -->
                  </div>
                  <p class="card-category">Ads</p>
                  <h3 class="card-title"><?php echo getTotalStats('tbl_ads','ad_status','A'); ?> <small>Active</small></h3>
                </div>
                
              </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-list-ul" aria-hidden="true"></i>
                    
                    <!-- <i class="material-icons">info_outline</i> -->
                  </div>
                  <p class="card-category">Ads</p>
                  <h3 class="card-title"><?php echo getTotalStats('tbl_ads','ad_status','B'); ?> <small>Blocked</small></h3>
                </div>
                
              </div>
            </div>
            
          </div>

          <div class="row">
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-list-ul" aria-hidden="true"></i>
                    <!-- <i class="material-icons">content_copy</i> -->
                  </div>
                  <p class="card-category">Events</p>
                  <h3 class="card-title"><?php echo getTotalStats('tbl_events'); ?>
                    <small>Total</small>
                  </h3>
                </div>
                
              </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-list-ul" aria-hidden="true"></i>
                    
                    <!-- <i class="material-icons">store</i> -->
                  </div>
                  <p class="card-category">Events</p>
                  <h3 class="card-title"><?php echo getTotalStats('tbl_events','event_status','A'); ?> <small>Active</small></h3>
                </div>
                
              </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-list-ul" aria-hidden="true"></i>
                    
                    <!-- <i class="material-icons">info_outline</i> -->
                  </div>
                  <p class="card-category">Events</p>
                  <h3 class="card-title"><?php echo getTotalStats('tbl_events','event_status','B'); ?> <small>Blocked</small></h3>
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