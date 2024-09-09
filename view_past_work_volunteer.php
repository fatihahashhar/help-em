<?php
// This script retrieves all the records from the application table.
$page_title = 'View Past Work';
session_start(); // Start the session.

// If no session value is present, redirect the user:
if (!isset($_SESSION['volunteer_id'])) {
  header("Location: login_volunteer.php");
}

?>
<!--Main Navigation-->
<header>
  <!-- Navbar -->
  <?php
  include('includes/header.php');
  ?>
  <!-- Navbar -->

  <style>
	.container-fluid {
      position: relative;
      padding: 0;
    }

    body {
      overflow-x: hidden;
    }
</style>
</header>
<!--Main Navigation-->

<!--Main layout-->
<?php
require('../mysqli_connect_fyp.php');

$query_get_vol_id = (isset($_SESSION['volunteer_id']));
$vol_id = $_SESSION['volunteer_id']; // Run the query.

echo '
<div class="container-fluid" style="width: 90rem;>
  <div class="row">
    <div class="py-4 col-xl-15" style="padding-left: 12px;">
      <div class="card text-center bg-light text-dark bg-opacity-100 w-100">
        <div class="card-header">
            <img src="images/pw.png" class="p-3 mb-2" height="180" alt="Help\'em Logo" loading="lazy" style="margin-top: -1px />
        </div>
        <div class="card-body text-start">';

          // Set the number of records to display per page
          $records_per_page = 10;

          // Calculate the total number of pages
          $sql = "SELECT COUNT(*) AS total FROM application WHERE volunteer_id = $vol_id AND status !='REJECTED' AND status !='APPROVED' AND status !='PENDING' 
          AND application.status !='ABSENT' AND application.status !='PARTICIPATE' AND application.status !='COMPLETED'";
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

          //Search form
          $search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';
          echo '
          <form id="search_box" class="m-3 d-flex justify-content-center" method="GET" action="view_past_work_volunteer.php">
            <div class="input-group w-25">
              <input type="text" name="search_query" placeholder="Search..." class="form-control" maxlength="50" value="' . htmlspecialchars($search_query) . '">
              <button style="background-color: #518cbb;" class="btn btn-danger" role="button" type="submit"><i class="bi bi-search"></i></button>
						  <button style="background-color: #bdbdbd;" class="btn btn-secondary clear-btn" role="button" type="button" onclick="clearSearchBox()"><i class="fa-solid fa-broom"></i></button>
				</div>
				</form><br>';

				echo '
				<script>
				function clearSearchBox() {
					document.getElementsByName("search_query")[0].value = "";
					document.getElementsByName("status_filter")[0].selectedIndex = 0;
				}
				</script>';

          // Get the user's SEARCH query --> if the user attempts to search
          if (isset($_GET["search_query"])) {

            //Get input given by the user in the text box
            $search_query = $_GET["search_query"];

            // Prepare the SQL query
            $sql = "SELECT id, status, volunteer_id, organizer_name, organizer_contact_number, voluntary_work_name, voluntary_work_task, voluntary_work_date, voluntary_work_start_time, voluntary_work_end_time, voluntary_work_id
                    FROM
                    (
                        SELECT application.id, application.status, application.volunteer_id, organization.name AS organizer_name, organization.contact_number AS organizer_contact_number, voluntary_work_organization.name AS voluntary_work_name, 
                          voluntary_work_organization.task AS voluntary_work_task, voluntary_work_organization.date AS voluntary_work_date, voluntary_work_organization.start_time AS voluntary_work_start_time,
                          voluntary_work_organization.end_time AS voluntary_work_end_time, voluntary_work_organization.id AS voluntary_work_id
                        FROM application
                        LEFT JOIN voluntary_work_institution ON application.voluntary_work_institution_id = voluntary_work_institution.id
                        LEFT JOIN voluntary_work_organization ON application.voluntary_work_organization_id = voluntary_work_organization.id
                        LEFT JOIN organization ON voluntary_work_organization.organization_id = organization.id
                        WHERE volunteer_id = $vol_id AND application.status !='ABSENT' AND application.status !='PARTICIPATE' AND application.status !='REJECTED' AND application.status !='APPROVED' 
                        AND application.status !='PENDING' AND application.status !='COMPLETED' AND voluntary_work_organization.name LIKE '%$search_query%' OR voluntary_work_organization.task LIKE '%$search_query%' OR organization.name LIKE '%$search_query%'
                        OR voluntary_work_organization.date LIKE '%$search_query%' OR voluntary_work_organization.start_time LIKE '%$search_query%' OR voluntary_work_organization.end_time LIKE '%$search_query%'
                        
                        UNION ALL
                        
                        SELECT application.id, application.status, application.volunteer_id, institution.name AS organizer_name, institution.contact_number AS organizer_contact_number, voluntary_work_institution.name AS voluntary_work_name,
                          voluntary_work_institution.task AS voluntary_work_task, voluntary_work_institution.date AS voluntary_work_date, voluntary_work_institution.start_time AS voluntary_work_start_time,
                          voluntary_work_institution.end_time AS voluntary_work_end_time, voluntary_work_institution.id AS voluntary_work_id
                        FROM application
                        LEFT JOIN voluntary_work_institution ON application.voluntary_work_institution_id = voluntary_work_institution.id
                        LEFT JOIN voluntary_work_organization ON application.voluntary_work_organization_id = voluntary_work_organization.id
                        LEFT JOIN institution ON voluntary_work_institution.institution_id = institution.id
                        WHERE volunteer_id = $vol_id AND application.status !='ABSENT' AND application.status !='PARTICIPATE' AND application.status !='REJECTED' AND application.status !='APPROVED' 
                        AND application.status !='PENDING' AND application.status !='COMPLETED' AND voluntary_work_institution.name LIKE '%$search_query%' OR voluntary_work_institution.task LIKE '%$search_query%' OR institution.name LIKE '%$search_query%'
                        OR voluntary_work_institution.date LIKE '%$search_query%' OR voluntary_work_institution.start_time LIKE '%$search_query%' OR voluntary_work_institution.end_time LIKE '%$search_query%'
                    ) AS subquery

                        WHERE volunteer_id = $vol_id AND organizer_name IS NOT NULL AND status !='ABSENT' AND status !='PARTICIPATE' AND status !='REJECTED' AND status !='APPROVED' AND status !='PENDING' AND status !='COMPLETED'
                        ORDER BY voluntary_work_date ASC";

            // Execute the query
            $result = @mysqli_query($dbc, $sql);

            // Count the number of returned rows:
            $num = mysqli_num_rows($result);

            // Check if any results are found
            if ($num > 0) {     //If it is found..
                // Print how many results there are:
                echo "<p><b>$num</b> results found.</p>\n</center><br>";

                // Output the results in a table
                // Table header:
                echo '
                <table class="mb-4" align="center" cellspacing="8" cellpadding="8" width="100%">
                    <tr>
                      <td align="center"><b>No. </b></td>
                      <td align="center"><b>Name </b></td>
                      <td align="center"><b>Date </b></td>
                      <td align="center"><b>Organizer Name </b></td>
                      <td align="center"><b>Organizer Contact Number </b></td>
                      <td align="center"><b>Status </b></td>
                      <td align="center"><b>View Details </b></td>
                    </tr>';

                      $row_num = ($current_page - 1) * $records_per_page + 1; // Calculate the initial row number for the current page
                      
                      // Fetch and print all the records:
                      while ($row = mysqli_fetch_assoc($result)) {

                        //Determining the colour of the status message
                        $status = $row['status'];
                        $backgroundColor = '';

                        if ($status == 'DONE') {
                          $backgroundColor = '#367E18'; // Green color
                        } 

                        echo '
                          <tr>
                            <td align="center">' . $row_num++ . '</td>
                            <td align="center">' . $row['voluntary_work_name'] . '</td>
                            <td align="center">' . $row['voluntary_work_date'] . '</td>
                            <td align="center">' . $row['organizer_name'] . '</td>
                            <td align="center">' . $row['organizer_contact_number'] . '</td>
                            <td align="center">
                              <button class="btn btn-secondary px-4" style="background-color: ' . $backgroundColor . ';">' . $status . '</button>
                            </td>
                            <td align="center">
                              <div>
                                <a style="background-color: #518cbb;" class="btn btn-secondary" role="button" href="view_voluntary_work_details_volunteer.php?id=' . $row['voluntary_work_id'] . '"><i class="far fa-eye"></i></a>
                              </div>
                            </td>
                          </tr>';
                      }

            echo '</table>';

            echo' 
            <div class="mb-2">';
              // Determine the range of pages to display
              $range = 2; // Number of links to show before and after the current page
              $start_range = max(1, $current_page);
              $end_range = min($total_pages, $current_page + $range);

              // Render pagination links
              if ($current_page > 1) {
                echo "<a href='view_past_work_volunteer.php?page=" . ($current_page - 1) . "'>Previous &nbsp</a> ";
              }
              if ($start_range > 1) {
                echo "<a href='view_past_work_volunteer.php?page=1'>1 &nbsp</a> ";
                if ($start_range > 2) {
                  echo "... ";
                }
              }
              for ($i = $start_range; $i <= $end_range; $i++) {
                if ($i == $current_page) {
                  echo "<b>$i &nbsp</b> ";
                } else {
                  echo "<a href='view_past_work_volunteer.php?page=$i'>$i &nbsp</a> ";
                }
              }
              if ($end_range < $total_pages) {
                if ($end_range < $total_pages - 1) {
                  echo "... &nbsp";
                }
                echo "<a href='view_past_work_volunteer.php?page=$total_pages'>$total_pages &nbsp</a> ";
              }
              if ($current_page < $total_pages) {
                echo "<a href='view_past_work_volunteer.php?page=" . ($current_page + 1) . "'>Next &nbsp</a> ";
              };
        
            } else {    // If it is not found..
                echo '
                <center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_s0fkqiqh.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px; margin-top:-40px"  loop  autoplay></lottie-player>
                <p class="error">0 results found.</p></center>';
            }

          } else { // if the user does not attempt to search yet, display all data in the table
            
              // Retrieve the records from the database
              $sql = "SELECT id, status, volunteer_id, organizer_name, voluntary_work_name, voluntary_work_task, voluntary_work_date, voluntary_work_start_time, voluntary_work_end_time, voluntary_work_id
              FROM
              (
                  SELECT application.id, application.status, application.volunteer_id, organization.name AS organizer_name, voluntary_work_organization.name AS voluntary_work_name,
                    voluntary_work_organization.task AS voluntary_work_task, voluntary_work_organization.date AS voluntary_work_date, voluntary_work_organization.start_time AS voluntary_work_start_time,
                    voluntary_work_organization.end_time AS voluntary_work_end_time, voluntary_work_organization.id AS voluntary_work_id
                  FROM application
                  LEFT JOIN voluntary_work_institution ON application.voluntary_work_institution_id = voluntary_work_institution.id
                  LEFT JOIN voluntary_work_organization ON application.voluntary_work_organization_id = voluntary_work_organization.id
                  LEFT JOIN organization ON voluntary_work_organization.organization_id = organization.id
                  WHERE volunteer_id = $vol_id AND application.status !='ABSENT' AND application.status !='PARTICIPATE' AND application.status !='REJECTED' AND application.status !='APPROVED' AND application.status !='PENDING' AND application.status !='COMPLETED'
                  
                  UNION ALL
                  
                  SELECT application.id, application.status, application.volunteer_id, institution.name AS organizer_name, voluntary_work_institution.name AS voluntary_work_name,
                    voluntary_work_institution.task AS voluntary_work_task, voluntary_work_institution.date AS voluntary_work_date, voluntary_work_institution.start_time AS voluntary_work_start_time,
                    voluntary_work_institution.end_time AS voluntary_work_end_time, voluntary_work_institution.id AS voluntary_work_id
                  FROM application
                  LEFT JOIN voluntary_work_institution ON application.voluntary_work_institution_id = voluntary_work_institution.id
                  LEFT JOIN voluntary_work_organization ON application.voluntary_work_organization_id = voluntary_work_organization.id
                  LEFT JOIN institution ON voluntary_work_institution.institution_id = institution.id
                  WHERE volunteer_id = $vol_id AND application.status !='ABSENT' AND application.status !='PARTICIPATE' AND application.status !='REJECTED' AND application.status !='APPROVED' AND application.status !='PENDING' AND application.status !='COMPLETED'
              ) AS subquery

                  WHERE organizer_name IS NOT NULL AND volunteer_id = $vol_id
                  GROUP BY id, status, volunteer_id, organizer_name, voluntary_work_name, voluntary_work_task, voluntary_work_date, voluntary_work_start_time, voluntary_work_end_time, voluntary_work_id
                  ORDER BY voluntary_work_date ASC
                  LIMIT $offset, $records_per_page";

              $result = mysqli_query($dbc, $sql);

              // Display the records
              if (mysqli_num_rows($result) > 0) {

                echo "<center><p>There are <b>{$row['total']}</b> past works recorded</p><br></center>";

                // Output the results in a table
                // Table header:
                echo '<table class="mb-4" align="center" cellspacing="8" cellpadding="8" width="100%">
                    <tr>
                      <td align="center"><b>No. </b></td>
                      <td align="center"><b>Name </b></td>
                      <td align="center"><b>Task Done </b></td>
                      <td align="center"><b>Date </b></td>
                      <td align="center"><b>Start Time </b></td>
                      <td align="center"><b>End Time </b></td>
                      <td align="center"><b>Organizer Name </b></td>
                      <td align="center"><b>Status </b></td>
                      <td align="center"><b>View Details </b></td>
                    </tr>';

                $row_num = ($current_page - 1) * $records_per_page + 1; // Calculate the initial row number for the current page
                
                // Fetch and print all the records:
                while ($row = mysqli_fetch_assoc($result)) {

                  //Determining the colour of the status message
                  $status = $row['status'];
                  $backgroundColor = '';

                  if ($status == 'DONE') {
                    $backgroundColor = '#367E18'; // Green color
                  } 

                  echo '
                    <tr>
                      <td align="center">' . $row_num++ . '</td>
                      <td align="center">' . $row['voluntary_work_name'] . '</td>
                      <td align="center">' . $row['voluntary_work_task'] . '</td>
                      <td align="center">' . $row['voluntary_work_date'] . '</td>
                      <td align="center">' . $row['voluntary_work_start_time'] . '</td>
                      <td align="center">' . $row['voluntary_work_end_time'] . '</td>
                      <td align="center">' . $row['organizer_name'] . '</td>
                      <td align="center">
                        <button class="btn btn-secondary px-4" style="background-color: ' . $backgroundColor . ';">' . $status . '</button>
                      </td>
                      <td align="center">
                        <div>
                          <a style="background-color: #518cbb;" class="btn btn-secondary" role="button" href="view_voluntary_work_details_volunteer.php?id=' . $row['voluntary_work_id'] . '"><i class="far fa-eye"></i></a>
                        </div>
                      </td>
                    </tr>';
            }

            echo '</table>';

            echo' 
            <div class="mb-2">';
              // Determine the range of pages to display
              $range = 2; // Number of links to show before and after the current page
              $start_range = max(1, $current_page);
              $end_range = min($total_pages, $current_page + $range);

              // Render pagination links
              if ($current_page > 1) {
                echo "<a href='view_past_work_volunteer.php?page=" . ($current_page - 1) . "'>Previous &nbsp</a> ";
              }
              if ($start_range > 1) {
                echo "<a href='view_past_work_volunteer.php?page=1'>1 &nbsp</a> ";
                if ($start_range > 2) {
                  echo "... ";
                }
              }
              for ($i = $start_range; $i <= $end_range; $i++) {
                if ($i == $current_page) {
                  echo "<b>$i &nbsp</b> ";
                } else {
                  echo "<a href='view_past_work_volunteer.php?page=$i'>$i &nbsp</a> ";
                }
              }
              if ($end_range < $total_pages) {
                if ($end_range < $total_pages - 1) {
                  echo "... &nbsp";
                }
                echo "<a href='view_past_work_volunteer.php?page=$total_pages'>$total_pages &nbsp</a> ";
              }
              if ($current_page < $total_pages) {
                echo "<a href='view_past_work_volunteer.php?page=" . ($current_page + 1) . "'>Next &nbsp</a> ";
              };

            mysqli_free_result($result); // Free memory associated with $r	

              } else { // If no records are found, display alert message.
                echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                  <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_s0fkqiqh.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px; margin-top:-40px" loop  autoplay></lottie-player>';
                echo '<p class="error mb-4">You have not joined and completed any work yet</p></center>';
              }

          }
        
              // Close the database connection
              mysqli_close($dbc); // Close database connection

            echo ' </div></div></div></div></div>';
            include('includes/footer.php');

          ?>
        </div>
    <!--Main layout-->