<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:void(0)">Dashboard</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <!-- <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)">
                  <i class="material-icons">notifications</i>
                  <p class="d-lg-none d-md-block">
                    Notifications
                  </p>
                </a>
              </li>

            </ul> -->
            <ul class="nav navbar-nav">
              <div class="dropdown" style="position:relative; right: -10px;">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                  <?php echo  $_SESSION['userFullName']; ?>
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="logout.php">Logout</a>
                  
                </div>
              </div>

              
            </ul>
          </div>
        </div>
      </nav>