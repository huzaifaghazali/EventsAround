<div class="sidebar" data-color="azure" data-background-color="black" data-image="./assets/img/sidebar-2.jpg">
      <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
      <div class="logo">
        <a href="index.php" class="simple-text logo-normal">
          Events Around
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item active  ">
            <a class="nav-link" href="index.php">
              <i class="material-icons">dashboard</i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item active  ">
              <a class="nav-link" href="addCategories.php">
                  <i class="fa fa-list-ul" aria-hidden="true"></i>
                  <p>Categories</p>
              </a>
          </li>
          <li class="nav-item active  ">
              <a class="nav-link" href="addBlogs.php">
                  <i class="fa fa-list-ul" aria-hidden="true"></i>
                  <p>Blogs</p>
              </a>
          </li>
          <li class="nav-item active  ">
              <a class="nav-link" href="users.php?type=O">
                  <i class="fa fa-user-secret" aria-hidden="true"></i>
                  <p>Organizers</p>
              </a>
          </li>
           <li class="nav-item active  ">
              <a class="nav-link" href="users.php?type=U">
                  <i class="fa fa-users" aria-hidden="true"></i>
                  <p>Users</p>
              </a>
          </li>

          <li class="nav-item active  ">
              <a class="nav-link" href="addAds.php">
                  <i class="fa fa-list-ul" aria-hidden="true"></i>
                  <p>ADs</p>
              </a>
          </li>

           <li class="nav-item active  ">
              <a class="nav-link" href="contactus.php">
                  <i class="fa fa-comments-o" aria-hidden="true"></i>
                  <p>Messages <?php if(getAdminNotiForContactUs()>0){ ?> <span class="badge badge-success"><?php echo getAdminNotiForContactUs(); ?></span> <?php } ?></p>
              </a>
          </li>
          <!-- your sidebar here -->
        </ul>
      </div>
    </div>