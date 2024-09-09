<?php
// This script retrieves all the records from the voluntary_work_institution & voluntary_work_organization table.
$page_title = 'View List of Voluntary Work';
session_start(); // Start the session.

?>
<!--Main Navigation-->
<header>
  <!-- Navbar -->
  <?php
  include('includes/header.php');
  ?>
  <!-- Navbar -->
</header>
<!--Main Navigation-->

<!--Main layout-->
<?php
require('../mysqli_connect_fyp.php');

echo '
<div class="container-fluid">
  <div class="row">
    <div class="py-4 col-xl-15" style="padding-left: 12px;">
      <div class="card text-center bg-light text-dark bg-opacity-100 w-100">
        <div class="card-header">
            <img src="images/voluntary_work.png" class="p-3 mb-2" height="160" alt="Help\'em Logo" loading="lazy" style="margin-top: -1px />
        </div>
        <div class="card-body text-start">';

        //Search form
        $search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';
        echo '
        <form id="search_box" class="m-3 d-flex justify-content-center" method="GET" action="browse_voluntary_work_volunteer.php">
          <div class="input-group w-25">
            <input required type="text" name="search_query" placeholder="Search..." class="form-control" maxlength="50" value="' . htmlspecialchars($search_query) . '">
            <button style="background-color: #518cbb;" class="btn btn-danger" role="button" type="submit"><i class="bi bi-search"></i>&nbsp Search</button>
          </div>
        </form>';

        // Get the user's SEARCH query --> if the user attempts to search
        if (isset($_GET["search_query"])) {

          //Get input given by the user in the text box
          $search_query = $_GET["search_query"];

          // Prepare the SQL query
          $sql = "SELECT * FROM voluntary_work_institution WHERE voluntary_work_institution.status != 'FINISHED' AND voluntary_work_institution.name LIKE '%$search_query%' OR voluntary_work_institution.status LIKE '%$search_query%' OR voluntary_work_institution.task LIKE '%$search_query%' UNION ALL 
          SELECT * FROM voluntary_work_organization WHERE voluntary_work_organization.status != 'FINISHED' AND voluntary_work_organization.name LIKE '%$search_query%' OR voluntary_work_organization.status LIKE '%$search_query%' OR voluntary_work_organization.task LIKE '%$search_query%'";

          // Execute the query
          $r = @mysqli_query($dbc, $sql);

          // Count the number of returned rows:
          $num = mysqli_num_rows($r);

          // Check if any results are found
          if ($num > 0) {     //If it is found..
            
            // Print how many members there are:
            echo "<center><p><b>$num</b> results found.</p>\n</center>";

            // Output the results as cards
            echo '
            <div class="container-fluid">
              <div class="card-deck row">';

                // Fetch and print all the records:
                while ($row = $r->fetch_assoc()) {
                  
                  // Fetch the image data
                  $image = $row['image'];
                  $imageData = base64_encode($image);

                  echo '
                  <div class="col-md-3 w-25 p-3">
                    <div class="card border rounded-4 shadow mb-4" style="background-color: #EEEEEE; width: 20rem;">
                      <div class="card-body" style="height: 500px; overflow: auto;">
                        <h5 class="card-title">' . $row['name'] . '</h5>
                        <p class="card-text">' . $row['task'] . '</p>
                        <p class="card-text"><b>Status: </b>' . $row['status'] . '</p>
                        <img src="data:image/jpeg;base64,' . $imageData . '" class="card-img-top" alt="Image" style="width: 100%; height: auto;">
                      </div>
                      <div class="card-footer p-3 text-center">
                        <a style="background-color: #89C4E1;" class="btn btn-secondary" href="read_more_voluntary_work_details_volunteer.php?id=' . $row['id'] . '"><i class="far fa-eye"></i> Read More</a>
                      </div>
                    </div>
                  </div>';
                }
              
          } else {    // If it is not found..
              echo '
              <center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
              <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_s0fkqiqh.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px; margin-top:-15px"  loop  autoplay></lottie-player>
              <p class="error">0 results found.</p></center>';
          }
                echo '
              </div>
            </div>
        </div>';

          } else { // if the user does not attempt to search yet, display all data in the table
            
            // Set the number of records to display per page
            $records_per_page = 12;

            // Calculate the total number of pages
            $sql = "SELECT COUNT(DISTINCT voluntary_work_institution.id) + COUNT(DISTINCT voluntary_work_organization.id) AS total
            FROM voluntary_work_institution
            JOIN voluntary_work_organization ON voluntary_work_institution.status != 'FINISHED' AND voluntary_work_organization.status != 'FINISHED'";
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
            $sql = "SELECT id, institution_id, name, task, status, image FROM voluntary_work_institution WHERE status != 'FINISHED'
            UNION
            SELECT id, organization_id, name, task, status, image FROM voluntary_work_organization WHERE status != 'FINISHED'
            LIMIT $offset, $records_per_page";

            $result = mysqli_query($dbc, $sql);

            // Display the records
            if (mysqli_num_rows($result) > 0) {
              echo "<center><p><b>{$row['total']}</b> results found</p></center>";

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
                      <div class="card-body" style="height: 500px; overflow: auto;">
                        <h5 class="card-title">' . $row['name'] . '</h5>
                        <p class="card-text">' . $row['task'] . '</p>
                        <p class="card-text"><b>Status: </b>' . $row['status'] . '</p>
                        <img src="data:image/jpeg;base64,' . $imageData . '" class="card-img-top" alt="Image" style="width: 100%; height: auto;">
                      </div>
                      <div class="card-footer p-3 text-center">
                        <a style="background-color: #89C4E1;" class="btn btn-secondary" href="read_more_voluntary_work_details_volunteer.php?id=' . $row['id'] . '"><i class="far fa-eye"></i> Read More</a>
                      </div>
                    </div>
                  </div>';
                }

                  echo '
                  <center>
                  <div class="mb-2">';
              
                    // Determine the range of pages to display
                    $range = 2; // Number of links to show before and after the current page
                    $start_range = max(1, $current_page);
                    $end_range = min($total_pages, $current_page + $range);

                    // Render pagination links
                    if ($current_page > 1) {
                      echo "<a href='browse_voluntary_work_volunteer.php?page=" . ($current_page - 1) . "'>Previous &nbsp</a> ";
                    }
                    if ($start_range > 1) {
                      echo "<a href='browse_voluntary_work_volunteer.php?page=1'>1 &nbsp</a> ";
                      if ($start_range > 2) {
                        echo "... ";
                      }
                    }
                    for ($i = $start_range; $i <= $end_range; $i++) {
                      if ($i == $current_page) {
                        echo "<b>$i &nbsp</b> ";
                      } else {
                        echo "<a href='browse_voluntary_work_volunteer.php?page=$i'>$i &nbsp</a> ";
                      }
                    }
                    if ($end_range < $total_pages) {
                      if ($end_range < $total_pages - 1) {
                        echo "... &nbsp";
                      }
                      echo "<a href='browse_voluntary_work_volunteer.php?page=$total_pages'>$total_pages &nbsp</a> ";
                    }
                    if ($current_page < $total_pages) {
                      echo "<a href='browse_voluntary_work_volunteer.php?page=" . ($current_page + 1) . "'>Next &nbsp</a> ";
                    }

            mysqli_free_result($result); // Free memory associated with $r	

            } else { // If no records are found, display alert message.
              echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_s0fkqiqh.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px; margin-top:-15px"  loop  autoplay></lottie-player>';
              echo '<p class="error">No results found.</p></center>';
            }

        echo '    </div>
                  </center>
                </div>
            </div>
        </div>
      </div>
    </div>';

            echo ' 
                <div class="pb-3 col-l-5">
                  <div class="card text-center bg-light text-dark bg-opacity-100 w-100">
                  <div class="card-header">
                  </div>
                  <div class="card-body text-start">
                    haloooo
                  </div>
                  </div>
                </div>';
          }

          // Close the database connection
          mysqli_close($dbc); // Close database connection

          echo' </div></div>';

          include('includes/footer.php');

          ?>