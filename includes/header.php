<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>
    <?php echo $page_title; ?>
  </title>
  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/0c264a8bd6.js" crossorigin="anonymous"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="includes/css.css" rel="stylesheet" />
  <!-- MDB -->
  <link href="includes/mdb.min.css" rel="stylesheet" />
  <!-- MDB -->
  <script type="text/javascript" src="includes/mdb.min.js"></script>
  <link rel="stylesheet" href="css/mdb.min.css" />
  <!-- Custom styles -->
  <link rel="stylesheet" href="css/admin.css" />
  <!-- Bootstrap Font Icon CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

  <style>
    .navbar {
      background-color: #f8f9fa;
      padding: 10px;
    }

    .nav-item {
      display: inline-block;
      position: relative;
    }

    .nav-link {
      color: #333;
      display: block;
      padding: 10px;
      text-decoration: none;
    }

    .dropdown-menu {
      display: none;
      position: absolute;
      background-color: #fff;
      padding: 10px;
      min-width: 200px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
    }

    .nav-item:hover .dropdown-menu {
      display: block;
    }

    .dropdown-item {
      display: block;
      padding: 5px;
      color: #333;
      text-decoration: none;
    }
  </style>
</head>

<body style="background-color: #7ea5c4;">
  <!-- Navbar -->
  <nav id="main-navbar" class="navbar navbar-expand-lg navbar-lg bg-white">
    <!-- Container wrapper -->
    <div class="container-fluid">
      <!-- Toggle button -->
      <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarButtonsExample"
        aria-controls="navbarButtonsExample" aria-expanded="true" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>
      <?php // Create a login/logout link:
        if (isset($_SESSION['admin_id'])) { //successfully login as Admin
          echo '
          <div class="collapse navbar-collapse justify-content-end" id="navbarButtonsExample" style="margin-top: 6px; margin-bottom: 6px;">
            <!-- Right links -->
              <div class="d-flex align-items-center">
                <a href="profile_admin.php" class="me-4 nav-link"><i class="fas fa-user-circle fa-lg" style="color: #8fbfe7;" data-mdb-toggle="tooltip" title="Profile"></i></a>
                <a style="background-color: #8fbfe7;" class="btn btn-primary me-3" href="logout_admin.php" role="button" data-mdb-toggle="tooltip" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
              </div>
          </div>';
        } 

        if (isset($_SESSION['volunteer_id'])) { //successfully login as Volunteer
          echo '
          <!-- Navbar brand -->
      <a class="navbar-brand mx-2" href="index.php">
        <img src="logo.png" height="60" alt="Help\'em Logo" loading="lazy" style="margin-top: -1px;" />
      </a>
          <div class="collapse navbar-collapse" id="navbarButtonsExample">
            <!-- Left links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="browse_voluntary_work_volunteer.php" data-mdb-toggle="tooltip" title="Browse Available Voluntary Work">Browse</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="view_applications_volunteer.php" data-mdb-toggle="tooltip" title="View Your Application Status">Applications</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="view_work_progress_volunteer.php" data-mdb-toggle="tooltip" title="View Your Work Progress">Work Progress</a>
              </li>
            </ul>
              <div class="d-flex align-items-center">
                <a href="view_past_work_volunteer.php" class="me-2 nav-link"><i class="fa-solid fa-clock-rotate-left" style="color: #8fbfe7;" data-mdb-toggle="tooltip" title="View Past Work"></i></a>
                <a href="profile_volunteer.php" class="me-4 nav-link"><i class="fas fa-user-circle fa-lg" style="color: #8fbfe7;" data-mdb-toggle="tooltip" title="Profile"></i></a>
                <a style="background-color: #8fbfe7;" class="btn btn-primary me-3" href="logout_volunteer.php" role="button" data-mdb-toggle="tooltip" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
                  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">';
        }

        if (isset($_SESSION['organization_id'])) { //successfully login as Organization
          echo '
          <div class="collapse navbar-collapse" id="navbarButtonsExample" style="margin-top: 6px; margin-left: 250px; margin-bottom: 6px;">
            <!-- Left links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <!-- 
                <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  style="color: #518cbb;" 
                  href="#"
                  id="navbarDropdownMenuLink"
                  role="button"
                  data-mdb-toggle="dropdown"
                  aria-expanded="false"
                >
                  NOT SET YET
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <li>
                    <a class="dropdown-item" href="#">NOT SET YET</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">NOT SET YET</a>
                  </li>
                </ul>
              </li>
               -->
            </ul>

            <div class="collapse navbar-collapse" id="navbarButtonsExample">
            <!-- Left links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <!-- 
              <li class="nav-item">
                <a class="nav-link" href="#">Add Voluntary Work</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Profile</a>
              </li>
              -->
            </ul>
              <div class="d-flex align-items-center">
                <a href="profile_organization.php" class="me-4 nav-link"><i class="fas fa-user-circle fa-lg" style="color: #8fbfe7;" data-mdb-toggle="tooltip" title="Profile"></i></a>
                <a style="background-color: #8fbfe7;" class="btn btn-primary me-3" href="logout_organization.php" role="button" data-mdb-toggle="tooltip" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
                  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">';
        }

        if (isset($_SESSION['institution_id'])) { //successfully login as Institution
          echo '
          <div class="collapse navbar-collapse" id="navbarButtonsExample" style="margin-top: 6px; margin-left: 250px; margin-bottom: 6px;">
            <!-- Left links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <!-- 
                <li class="nav-item dropdown">
                <a
                  class="nav-link dropdown-toggle"
                  style="color: #518cbb;" 
                  href="#"
                  id="navbarDropdownMenuLink"
                  role="button"
                  data-mdb-toggle="dropdown"
                  aria-expanded="false"
                >
                  NOT SET YET
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <li>
                    <a class="dropdown-item" href="#">NOT SET YET</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">NOT SET YET</a>
                  </li>
                </ul>
              </li>
               -->
            </ul>

            <div class="collapse navbar-collapse" id="navbarButtonsExample">
            <!-- Left links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0"> 
                <!--
                  <li class="nav-item">
                <a class="nav-link" href="add_voluntary_work_institution.php">Add Voluntary Work</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="profile_institution.php">Profile</a>
              </li>
               -->
            </ul>
              <div class="d-flex align-items-center">
                <a href="profile_institution.php" class="me-4 nav-link"><i class="fas fa-user-circle fa-lg" style="color: #8fbfe7;" data-mdb-toggle="tooltip" title="Profile"></i></a>
                <a style="background-color: #8fbfe7;" class="btn btn-primary me-3" href="logout_institution.php" role="button" data-mdb-toggle="tooltip" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
                  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">';
        }

        if (empty($_SESSION["admin_id"]) && empty($_SESSION["volunteer_id"]) && empty($_SESSION["organization_id"]) && empty($_SESSION["institution_id"]) ) {
          
          echo '
          <!-- Navbar brand -->
      <a class="navbar-brand ms-3 me-2" href="index.php">
        <img src="logo.png" height="60" alt="Help\'em Logo" loading="lazy" style="margin-top: -1px;" />
      </a>
      
      <!-- Collapsible wrapper -->
      <div class="collapse navbar-collapse" id="navbarButtonsExample">
        <!-- Left links -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="browse_voluntary_work_volunteer.php" data-mdb-toggle="tooltip" title="Browse Available Voluntary Work">Browse</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About Us</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="who_we_are.php">Who We Are</a></li>
                <li><a class="dropdown-item" href="how_we_works.php">How We Works</a></li>
                <li><a class="dropdown-item" href="vision_mission_values.php">Vision, Mission & Values</a></li>
                <li><a class="dropdown-item" href="our_management_team.php">Our Management Team</a></li>
                <li><a class="dropdown-item" href="our_policies.php">Our Policies</a></li>
              </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact_us.php">Contact Us</a>
          </li>
        </ul>
        <!-- Left links -->

      <div class="d-flex align-items-center">
          <!-- Button trigger modal -->
          <button style="background-color: #8fbfe7;" type="button" class="btn btn-primary me-3" data-mdb-toggle="modal" data-mdb-target="#Login">
            <i class="fas fa-sign-in-alt"></i>&nbsp LOGIN
          </button>
          <!-- Button trigger modal -->
          <!-- Modal -->
          <div
          class="modal fade"
          id="Login"
          data-mdb-backdrop="static"
          data-mdb-keyboard="false"
          tabindex="-1"
          aria-labelledby="staticBackdropLabel"
          aria-hidden="true"
          >
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">LOGIN AS?</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row row-cols-1 row-cols-md-2 g-4">
                  <div class="col ripple">
                    <div class="card h-100">
                      <a href="login_volunteer.php">
                      <img src="images/volunteer.jpg" class="card-img-top h-100" alt="Volunteer"/>
                      </a>
                      <div class="card-footer">
                        <center><a style="background-color: #8fbfe7;" class="btn btn-primary me-3" href="login_volunteer.php" role="button">VOLUNTEER</a></center>
                      </div>
                    </div>
                  </div>
                  <div class="col ripple">
                    <div class="card h-100">
                      <a href="login_organization.php">
                      <img src="images/ngo.jpg" class="card-img-top h-100" alt="Organization"/>
                      </a>
                      <div class="card-footer">
                        <center><a style="background-color: #8fbfe7;" class="btn btn-primary me-3" href="login_organization.php" role="button">NGO\'S (ORGANIZATION)</a></center>
                      </div>
                    </div>
                  </div>
                  <div class="col ripple">
                    <div class="card h-100">
                      <a href="login_institution.php">
                        <img src="images/institution.jpg" class="card-img-top h-100" alt="Institution"/>
                        </a>
                      <div class="card-footer">
                        <center><a style="background-color: #8fbfe7;" class="btn btn-primary me-3" href="login_institution.php" role="button">INSTITUTION</a></center>
                      </div>
                    </div>
                  </div>
                  <div class="col ripple">
                    <div class="card h-100">
                      <a href="login_admin.php">
                        <img src="images/admin.jpg" class="card-img-top h-100" alt="Admin"/>
                      </a>
                      <div class="card-footer">
                        <center><a style="background-color: #8fbfe7;" class="btn btn-primary me-3" href="login_admin.php" role="button">ADMIN</a></center>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </div>
          
          <!-- Button trigger modal -->
          <button style="background-color: #518cbb;" type="button" class="btn btn-primary me-3" data-mdb-toggle="modal" data-mdb-target="#SignUp">
            <i class="far fa-file-alt"></i>&nbsp Register
            </button>
            <!-- Button trigger modal -->
            <!-- Modal -->
            <div
            class="modal fade"
            id="SignUp"
            data-mdb-backdrop="static"
            data-mdb-keyboard="false"
            tabindex="-1"
            aria-labelledby="staticBackdropLabel"
            aria-hidden="true"
            >
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">REGISTER AS?</h5>
                  <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row row-cols-1 row-cols-md-2 g-4">
                    <div class="col ripple">
                      <div class="card h-100">
                        <a href="register_volunteer.php">
                         <img src="images/volunteer.jpg" class="card-img-top h-100" alt="Volunteer"/>
                        </a>
                        <div class="card-footer">
                          <center><a style="background-color: #518cbb;" class="btn btn-primary me-3" href="register_volunteer.php" role="button">VOLUNTEER</a></center>
                        </div>
                      </div>
                    </div>
                    <div class="col ripple">
                      <div class="card h-100">
                        <a href="register_organization.php">
                        <img src="images/ngo.jpg" class="card-img-top h-100" alt="Organization"/>
                        </a>
                        <div class="card-footer">
                          <center><a style="background-color: #518cbb;" class="btn btn-primary me-3" href="register_organization.php" role="button">NGO\'S (ORGANIZATION)</a></center>
                        </div>
                      </div>
                    </div>
                    <div class="col ripple">
                      <div class="card h-100">
                        <a href="register_institution.php">
                        <img src="images/institution.jpg" class="card-img-top h-100" alt="Institution"/>
                        </a>
                        <div class="card-footer">
                          <center><a style="background-color: #518cbb;" class="btn btn-primary me-3" href="register_institution.php" role="button">INSTITUTION</a></center>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">';
          }
        ?>
    </div>
    </div>
    </div>
    <!-- Collapsible wrapper -->
    </div>
    <!-- Container wrapper -->
  </nav>
  <!-- Navbar -->