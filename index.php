<?php
session_start(); // Start the session.
$page_title = "Help'em";
include('includes/header.php');
?>

<style>
    .img-fluid {
      width: 100%;
      height: auto;
    }

    .container-fluid {
      position: relative;
      padding: 0;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5); /* Adjust the opacity/fade as needed */
    }

    .overlay-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      color: #fff;
    }

    .overlay-content p {
      margin-bottom: 20px;
    }

    .overlay-content a {
      display: inline-block;
      padding: 10px 20px;
      font-size: 18px;
      font-weight: bold;
      background-color: #475053;
      color: #ffffff;
      text-decoration: none;
    }

    body {
    overflow-x: hidden;
  }
  </style>

<div class="container-fluid">
  <div align="middle">
    <main class="page_background_colour container-fluid">
      <!-- Carousel wrapper -->
      <div id="carouselMaterialStyle" class="carousel slide carousel-fade p-0" style="width: 100%;" data-mdb-ride="carousel">
        <!-- Indicators -->
        <div class="carousel-indicators">
          <button type="button" data-mdb-target="#carouselMaterialStyle" data-mdb-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-mdb-target="#carouselMaterialStyle" data-mdb-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-mdb-target="#carouselMaterialStyle" data-mdb-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <!-- Inner -->
        <div class="carousel-inner shadow-4-strong" style="height: 100%;">
          <!-- Single item -->
          <div class="carousel-item active">
            <img src="https://cdn.tatlerasia.com/asiatatler/i/sg/2020/06/08185746-marek-okon-twwcqimiumg-unsplash_cover_2000x1125.jpg" class="d-block" style="width: 100%; height: 100%;" alt="Marine Life Conservation" />
            <div class="mask" style="background-color: rgba(0, 0, 0, 0.4)"></div>
            <div class="carousel-caption d-none d-md-block">
              <h5>Marine Life Conservation</h5>
              <p>Protecting marine life habitats</p>
            </div>
          </div>

          <!-- Single item -->
          <div class="carousel-item">
            <img src="https://www.nursinghomeabusecenter.com/wp-content/uploads/2019/11/happy-seniors-nursing-home.png" class="d-block" style="width: 100%; height: 100%;" alt="Nursing and Old Folk's Home" />
            <div class="mask" style="background-color: rgba(0, 0, 0, 0.4)"></div>
            <div class="carousel-caption d-none d-md-block" >
              <h5>Nursing and Old Folk's Home</h5>
              <p>Spending time with them</p>
            </div>
          </div>

          <!-- Single item -->
          <div class="carousel-item">
            <img src="https://assets.nst.com.my/images/articles/floods020922_NSTfield_image_socialmedia.var_1662104392.jpg" class="d-block" style="width: 100%; height: 100%;" alt="Natural Disaster" />
            <div class="mask" style="background-color: rgba(0, 0, 0, 0.4)"></div>
            <div class="carousel-caption d-none d-md-block" >
              <h5>Natural Disasters</h5>
              <p>Helping the flood victims</p>
            </div>
          </div>
        </div>
        <!-- Inner -->

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-mdb-target="#carouselMaterialStyle" data-mdb-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-mdb-target="#carouselMaterialStyle" data-mdb-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
      <!-- Carousel wrapper -->

      <br><br>

      <!-- Recent Work -->
      <section>
      <?php
        require('../mysqli_connect_fyp.php');

        echo' 
        <img src="images/recent_work.png" class="p-3" height="160" alt="Help\'em Logo" loading="lazy" style="margin-top: -1px; margin-bottom: -10px;" />';

        // Set the number of records to display per page
        $records_per_page = 5;

        // Calculate the total number of pages
        $sql = "SELECT COUNT(DISTINCT voluntary_work_institution.id) + COUNT(DISTINCT voluntary_work_organization.id) AS total
        FROM voluntary_work_institution
        JOIN voluntary_work_organization ON voluntary_work_institution.status = 'FINISHED' AND voluntary_work_organization.status = 'FINISHED'";
        $result = mysqli_query($dbc, $sql);
        $row = mysqli_fetch_assoc($result);
        $total_pages = ceil($row['total'] / $records_per_page);

        // Calculate the current page number
        if (!isset($_GET['page']) || $_GET['page'] < 1 || $_GET['page'] > $total_pages) {
          $current_page = 1;
        } else {
          $current_page = intval($_GET['page']);
        }

        // Calculate the OFFSET value for the query
        $offset = ($current_page - 1) * $records_per_page;

        // Retrieve the records from the database
        $sql = "SELECT id, institution_id, name, task, status, image, date
        FROM (
            SELECT id, institution_id, name, task, status, image, date FROM voluntary_work_institution WHERE status = 'FINISHED'
            UNION
            SELECT id, organization_id, name, task, status, image, date FROM voluntary_work_organization WHERE status = 'FINISHED'
        ) AS combined_result
        ORDER BY date DESC LIMIT $offset, $records_per_page";

        $result = mysqli_query($dbc, $sql);

        // Display the records
        if (mysqli_num_rows($result) > 0) {
          // Output the results as cards
          echo '
          <div class="container-fluid">
          <div class="card-deck p-3 row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-5">'; // Added row-cols classes

          // Fetch and print all the records:
          while ($row = mysqli_fetch_assoc($result)) {
            // Fetch the image data
            $image = $row['image'];
            $imageData = base64_encode($image);

            echo '
            <div class="col mb-4">
              <div class="card border rounded-4 shadow mb-4" style="background-color: #EEEEEE; width: 100%;">
                <div class="card-body" style="height: 380px;; overflow: auto;">
                  <img src="data:image/jpeg;base64,' . $imageData . '" class="card-img-top" alt="Image" style="width: 100%; height: auto;">
                </div>
                <div class="card-footer py-3 text-center">
                  <a style="background-color: #89C4E1; width: 150px;" class="btn btn-secondary" href="read_more_voluntary_work_details_volunteer.php?id=' . $row['id'] . '"><i class="far fa-eye"></i> Read More</a>
                </div>
              </div>
            </div>';
          }

          echo '</div></div>'; // Closing div tags

        } else { // If no records are found, display alert message.
          echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
            <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_s0fkqiqh.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px; margin-top:-15px"  loop  autoplay></lottie-player>';
          echo '<p class="error">No results found.</p></center>';
        }
        
      ?>
      </section>
      <!-- Recent Work -->

      </br>

      <!-- Ongoing Work -->
      <section>
      <?php

        echo' 
        <center><img src="images/on-going.png" class="p-3" height="160" alt="Help\'em Logo" loading="lazy" style="margin-top: -1px; margin-bottom: -10px;" /></center>';

        // Set the number of records to display per page
        $records_per_page = 5;

        // Calculate the total number of pages
        $sql = "SELECT COUNT(DISTINCT voluntary_work_institution.id) + COUNT(DISTINCT voluntary_work_organization.id) AS total
        FROM voluntary_work_institution
        JOIN voluntary_work_organization ON voluntary_work_institution.status = 'OPEN FOR REGISTRATION' AND voluntary_work_organization.status = 'OPEN FOR REGISTRATION'";
        $result = mysqli_query($dbc, $sql);
        $row = mysqli_fetch_assoc($result);
        $total_pages = ceil($row['total'] / $records_per_page);

        // Calculate the current page number
        if (!isset($_GET['page']) || $_GET['page'] < 1 || $_GET['page'] > $total_pages) {
          $current_page = 1;
        } else {
          $current_page = intval($_GET['page']);
        }

        // Calculate the OFFSET value for the query
        $offset = ($current_page - 1) * $records_per_page;

        // Retrieve the records from the database
        $sql = "SELECT id, institution_id, name, task, status, image, date
        FROM (
            SELECT id, institution_id, name, task, status, image, date FROM voluntary_work_institution WHERE status = 'OPEN FOR REGISTRATION'
            UNION
            SELECT id, organization_id, name, task, status, image, date FROM voluntary_work_organization WHERE status = 'OPEN FOR REGISTRATION'
        ) AS combined_result
        ORDER BY date ASC LIMIT $offset, $records_per_page";

        $result = mysqli_query($dbc, $sql);

        // Display the records
        if (mysqli_num_rows($result) > 0) {
          // Output the results as cards
          echo '
          <div class="container-fluid">
            <div class="card-deck p-3 row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-5">'; // Added row-cols classes

          // Fetch and print all the records:
          while ($row = mysqli_fetch_assoc($result)) {
            // Fetch the image data
            $image = $row['image'];
            $imageData = base64_encode($image);

            echo '
            <div class="col mb-4">
              <div class="card border rounded-4 shadow" style="background-color: #EEEEEE;">
                <div class="card-body" style="height: 350px; overflow: auto;">
                  <img src="data:image/jpeg;base64,' . $imageData . '" class="card-img-top" alt="Image" style="width: 100%; height: auto;">
                </div>
                <div class="card-footer p-3 text-center">
                  <a style="background-color: #89C4E1; width: 75%;" class="btn btn-secondary" href="read_more_voluntary_work_details_volunteer.php?id=' . $row['id'] . '"><i class="far fa-eye"></i> Read More</a>
                </div>
              </div>
            </div>';
          }

          echo '</div></div>'; // Closing div tags

        } else { // If no records are found, display alert message.
          echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
            <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_s0fkqiqh.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px; margin-top:-15px"  loop  autoplay></lottie-player>';
          echo '<p class="error">No results found.</p></center>';
        }

        echo' <center><a style="background-color: #475053; width: 300px;" class="btn btn-secondary btn-lg" href="browse_voluntary_work_volunteer.php">See more</a></center>';
        
      ?>
      </section>
      <!-- Ongoing Work -->

      </br></br>

      <!-- Volunteer Now -->
        <section>
          <div style="position: relative;">
            <div class="row">
              <div class="col">
                <div class="position-relative">
                  <img src="images/bgr6.jpg" class="img-fluid" alt="Background Image" />
                  <div class="overlay"></div>
                  <div class="overlay-content">
                    <h4>Register now as a volunteer on our website and find meaningful opportunities to make a difference in your community!"</h4>
                    <p>Join our community of compassionate volunteers and make a difference in the lives of others! Register now on our 
                      website to discover a wide range of meaningful and rewarding volunteer opportunities available near you. By becoming 
                      a volunteer, you'll have the chance to contribute your skills, time, and passion to causes that matter, while creating 
                      a positive impact on your community. Start your volunteering journey today and be part of a movement that fosters 
                      unity, empathy, and positive change. Together, we can make the world a better place!"</p>
                    <a href="register_volunteer.php" style="background-color: #4592AF;" class="btn btn-lg btn-primary">BE A VOLUNTEER</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="position-relative">
                  <img src="images/bgr5.png" class="img-fluid" alt="Background Image" />
                  <div class="overlay"></div>
                  <div class="overlay-content">
                    <h4>Unlock the Potential of Volunteer Engagement: Register Your NGO or Institution Today!</h4>
                    <p>Revolutionize the way you engage volunteers and supercharge your organization's impact by registering with our dedicated platform. 
                      Gain access to a vast community of passionate individuals eager to contribute their time and skills to meaningful causes. Promote your 
                      programs, connect with eligible volunteers, and efficiently manage your volunteer workforce all in one centralized platform. Join us 
                      today and experience a new level of efficiency, effectiveness, and success in your volunteer recruitment and management efforts.</p>
                    <a href="register_institution.php" style="background-color: #4592AF;" class="btn btn-primary me-4">REGISTER AS INSTITUTION</a>
                    <a href="register_organization.php" style="background-color: #4592AF;" class="btn btn-primary">REGISTER AS ORGANIZATION</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      <!-- Volunteer Now -->

      </br>

      <!-- Our Impact -->
      <section>
      <?php
      echo '<div class="container-fluid px-4">
              <div class="row">
                <div class="py-4 col-xl-15">
                  <div class="card text-center bg-light text-dark bg-opacity-100 w-100">
                    <div class="card-header border-0">
                      <img src="images/our_impact.png" class="p-3 mb-2" height="160" alt="Help\'em Logo" loading="lazy" style="margin-top: -1px;" />
                    </div>
                    <div class="card-body text-start">
                      <div class="col-xl-15">
                        <div class="mapouter">
                          <div class="gmap_canvas">
                            <iframe width="100%" height="600" id="gmap_canvas" src="https://maps.google.com/maps?q=malaysia&t=&z=6&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                            <a href="https://embedgooglemap.net/124/"></a><br>
                            <style>.mapouter{position:relative;text-align:right;height:600px;width:100%;}</style>
                            <a href="https://www.embedgooglemap.net"></a>
                            <style>.gmap_canvas {overflow:hidden;background:none!important;height:600px;width:100%;}</style>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>';
      ?>
      </section>
      <!-- Our Impact -->

      <br>
    </main>  

  </div>
</div>
</div>
<?php
include('includes/footer.php');
?>