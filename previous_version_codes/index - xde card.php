<?php
session_start(); // Start the session.
$page_title = "Help'em";
include('includes/header.php');
?>

</br>
<div class="container-fluid">
  <div align="middle">
    <main class="page_background_colour container-fluid">
      <!-- Carousel wrapper -->
      <div id="carouselMaterialStyle" class="carousel slide carousel-fade" style="width: 100%;" data-mdb-ride="carousel">
        <!-- Indicators -->
        <div class="carousel-indicators">
          <button type="button" data-mdb-target="#carouselMaterialStyle" data-mdb-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-mdb-target="#carouselMaterialStyle" data-mdb-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-mdb-target="#carouselMaterialStyle" data-mdb-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <!-- Inner -->
        <div class="carousel-inner rounded-5 shadow-4-strong" style="height: 100%;">
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
      </br></br>
      <!-- Recent Work -->
      <section>
      <?php
      require('../mysqli_connect_fyp.php');

      echo' <img src="images/recent_work.png" class="p-3 mb-2" height="160" alt="Help\'em Logo" loading="lazy" style="margin-top: -1px />';
                    
                    // Set the number of records to display per page
                    $records_per_page = 8;

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
                        <div class="card-deck row">';

                        // Fetch and print all the records:
                        while ($row = mysqli_fetch_assoc($result)) {
                          // Fetch the image data
                          $image = $row['image'];
                          $imageData = base64_encode($image);

                          echo '
                          <div class="col-md-3 w-25 p-3">
                            <div class="card border rounded-4 shadow mb-4" style="background-color: #EEEEEE; width: 20rem;">
                              <div class="card-body" style="height: 400px; overflow: auto;">
                                <img src="data:image/jpeg;base64,' . $imageData . '" class="card-img-top" alt="Image" style="width: 100%; height: auto;">
                              </div>
                              <div class="card-footer p-3 text-center">
                                <a style="background-color: #89C4E1;" class="btn btn-secondary" href="read_more_voluntary_work_details_volunteer.php?id=' . $row['id'] . '"><i class="far fa-eye"></i> Read More</a>
                              </div>
                            </div>
                          </div>';
                        }

                      }
                    else { // If no records are found, display alert message.
                      echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                        <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_s0fkqiqh.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px; margin-top:-15px"  loop  autoplay></lottie-player>';
                      echo '<p class="error">No results found.</p></center>';
                    }
                  echo' </div>
                      </div>';
                  ?>
      </section>
      <!-- Recent Work -->

  </div>
</div>
</div>
<?php
include('includes/footer.php');
?>