<?php
// This script retrieves all the records from the application table.
$page_title = 'View Approved Applications';
session_start(); // Start the session.

// If no session value is present, redirect the user:
if (!isset($_SESSION['institution_id'])) {
  header("Location: login_institution.php");
}

?>
<!--Main Navigation-->
<header>
  <!-- Sidebar -->
	<?php
	include('includes/sidebar_for_institution.html');
	?>
	<!-- Sidebar -->
  
  <!-- Navbar -->
  <?php
  include('includes/header.php');
  ?>
  <!-- Navbar -->
</header>
<!--Main Navigation-->

<!--Main layout-->
<main>
  <div class="container pt-4" style="padding-right: 30px;">
      <!-- Section: Main chart -->
        <section class="mb-4">
          <div>
            <?php
            require('../mysqli_connect_fyp.php');

            $query_get_inst_id = (isset($_SESSION['institution_id']));
            $inst_id = $_SESSION['institution_id']; // Run the query.

            echo '
            <div class="container mx-auto" style="width: 75rem;">
              <div class="card text-center bg-light text-dark bg-opacity-100" style="width: 75rem;">
                  <div class="card-header">
                    <img src="images/aa.png" class="p-2 my-3" height="200" alt="Application Logo" loading="lazy" style="margin-top: -1px />
                  </div>
                  <div class="card-body text-start">';
                    
                    // Set the number of records to display per page
                    $records_per_page = 10;

                    // Calculate the total number of pages
                    $sql = "SELECT COUNT(*) AS total FROM application WHERE voluntary_work_institution_id IN 
                              (
                                SELECT id FROM voluntary_work_institution WHERE institution_id = $inst_id AND application.status != 'REJECTED' AND application.status != 'PENDING' 
                                AND application.status != 'ABSENT' AND application.status != 'PARTICIPATE' AND application.status != 'COMPLETED' AND application.status != 'DONE'
                              )";
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
                    <form id="search_box" class="m-3 d-flex justify-content-center" method="GET" action="view_applications_approved_institution.php">
                      <div class="input-group w-50">
                        <input type="text" name="search_query" placeholder="Search... (Voluntary Work Name or Volunteer Username)" class="form-control" maxlength="50" value="' . htmlspecialchars($search_query) . '">
                        <button style="background-color: #518cbb;" class="btn btn-danger" role="button" type="submit"><i class="bi bi-search"></i></button>
                        <button style="background-color: #bdbdbd;" class="btn btn-secondary clear-btn" role="button" type="button" onclick="clearSearchBox()"><i class="fa-solid fa-broom"></i></button>
                      </div>
                    </form></br>';

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
                      $sql = "SELECT id, status, volunteer_id, voluntary_work_id, voluntary_work_name, volunteer_username, volunteer_contact_number, organizer_of_voluntary_work_id, volunteer_email
                              FROM
                              (
                                  SELECT application.id, application.status, application.volunteer_id, voluntary_work_organization.id AS voluntary_work_id, 
                                    voluntary_work_organization.name AS voluntary_work_name, volunteer.username AS volunteer_username, volunteer.contact_number AS volunteer_contact_number, 
                                    voluntary_work_organization.organization_id AS organizer_of_voluntary_work_id, volunteer.email AS volunteer_email 		
                                  FROM application
                                  LEFT JOIN voluntary_work_institution ON application.voluntary_work_institution_id = voluntary_work_institution.id
                                  LEFT JOIN voluntary_work_organization ON application.voluntary_work_organization_id = voluntary_work_organization.id
                                  LEFT JOIN organization ON voluntary_work_organization.organization_id = organization.id
                                  LEFT JOIN volunteer ON application.volunteer_id = volunteer.id
                                  WHERE voluntary_work_institution.institution_id = $inst_id AND application.status != 'REJECTED' AND application.status != 'PENDING' 
                                  AND application.status != 'ABSENT' AND application.status != 'PARTICIPATE' AND application.status != 'COMPLETED' AND application.status != 'DONE'
                                  AND voluntary_work_organization.name LIKE '%$search_query%' OR volunteer.username LIKE '%$search_query%'
                                  
                                  UNION ALL
                                  
                                  SELECT application.id, application.status, application.volunteer_id, voluntary_work_institution.id AS voluntary_work_id, 
                                  voluntary_work_institution.name AS voluntary_work_name, volunteer.username AS volunteer_username, volunteer.contact_number AS volunteer_contact_number,
                                  voluntary_work_institution.institution_id AS organizer_of_voluntary_work_id, volunteer.email AS volunteer_email
                                  FROM application
                                  LEFT JOIN voluntary_work_institution ON application.voluntary_work_institution_id = voluntary_work_institution.id
                                  LEFT JOIN voluntary_work_organization ON application.voluntary_work_organization_id = voluntary_work_organization.id
                                  LEFT JOIN institution ON voluntary_work_institution.institution_id = institution.id
                                  LEFT JOIN volunteer ON application.volunteer_id = volunteer.id
                                  WHERE voluntary_work_institution.institution_id = $inst_id AND application.status != 'REJECTED' AND application.status != 'PENDING' 
                                  AND application.status != 'ABSENT' AND application.status != 'PARTICIPATE' AND application.status != 'COMPLETED' AND application.status != 'DONE'
                                  AND voluntary_work_institution.name LIKE '%$search_query%' OR volunteer.username LIKE '%$search_query%'
                              ) AS subquery

                                  WHERE voluntary_work_name IS NOT NULL AND organizer_of_voluntary_work_id = $inst_id AND status != 'PENDING' AND status !='REJECTED' 
                                  AND status != 'ABSENT' AND status != 'PARTICIPATE' AND status != 'COMPLETED' AND status != 'DONE'";

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
                                <td align="center"><b>Voluntary Work Name </b></td>
                                <td align="center"><b>Volunteer Username </b></td>
                                <td align="center"><b>Volunteer Contact Number </b></td>
                                <td align="center"><b>Volunteer Email </b></td>
                                <td align="center"><b>Status </b></td>
                                <td align="center"><b>Applicant\'s Details</b></td>
                              </tr>';

                              $row_num = ($current_page - 1) * $records_per_page + 1; // Calculate the initial row number for the current page
                              
                              // Fetch and print all the records:
                              while ($row = mysqli_fetch_assoc($result)) {

                                //Determining the colour of the status message
                                $status = $row['status'];
                                $backgroundColor = '';

                                if ($status == 'APPROVED') {
                                  $backgroundColor = '#FFD32D'; // Yellow color
                                } 

                                echo '
                                <tr>
                                  <td align="center">' . $row_num++ . '</td>
                                  <td align="center">' . $row['voluntary_work_name'] . '</td>
                                  <td align="center">' . $row['volunteer_username'] . '</td>
                                  <td align="center">' . $row['volunteer_contact_number'] . '</td>
                                  <td align="center">' . $row['volunteer_email'] . '</td>
                                  <td align="center">
                                    <button class="btn btn-secondary px-4" style="background-color: ' . $backgroundColor . ';">' . $status . '</button>
                                  </td>
                                  <td align="center">
                                    <div>';
                                    // Check if status is 'APPROVED' or 'REJECTED' to disable the button
                                    if ($status != 'REJECTED') { // If the status is 'PENDING'
                                      echo '<a style="background-color: #89C4E1;" class="btn btn-secondary" role="button" href="view_applicants_details_pending_institution.php?id=' . $row['volunteer_id'] . '">VIEW</a>';
                                    } else { // If the status is 'APPROVED' or 'REJECTED'
                                      echo '<button class="btn btn-danger" style="background-color: #89C4E1;" disabled>VIEW</button>';
                                    }
                                      
                                    echo'</div>
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
                        echo "<a href='view_applications_approved_institution.php?page=" . ($current_page - 1) . "'>Previous &nbsp</a> ";
                      }
                      if ($start_range > 1) {
                        echo "<a href='view_applications_approved_institution.php?page=1'>1 &nbsp</a> ";
                        if ($start_range > 2) {
                          echo "... ";
                        }
                      }
                      for ($i = $start_range; $i <= $end_range; $i++) {
                        if ($i == $current_page) {
                          echo "<b>$i &nbsp</b> ";
                        } else {
                          echo "<a href='view_applications_approved_institution.php?page=$i'>$i &nbsp</a> ";
                        }
                      }
                      if ($end_range < $total_pages) {
                        if ($end_range < $total_pages - 1) {
                          echo "... &nbsp";
                        }
                        echo "<a href='view_applications_approved_institution.php?page=$total_pages'>$total_pages &nbsp</a> ";
                      }
                      if ($current_page < $total_pages) {
                        echo "<a href='view_applications_approved_institution.php?page=" . ($current_page + 1) . "'>Next &nbsp</a> ";
                      };
              
                      } else {    // If it is not found..
                        echo '
                        <center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                        <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_s0fkqiqh.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px; margin-top:-40px"  loop  autoplay></lottie-player>
                        <p class="error">0 results found.</p></center>';
                      }

                    } else { // if the user does not attempt to search yet, display all data in the table
                    
                    // Retrieve the records from the database
                    $sql = "SELECT id, status, volunteer_id, voluntary_work_id, voluntary_work_name, volunteer_username, volunteer_contact_number, organizer_of_voluntary_work_id, volunteer_email
                    FROM
                    (
                        SELECT application.id, application.status, application.volunteer_id, voluntary_work_organization.id AS voluntary_work_id, 
                          voluntary_work_organization.name AS voluntary_work_name, volunteer.username AS volunteer_username, volunteer.contact_number AS volunteer_contact_number, 
                          voluntary_work_organization.organization_id AS organizer_of_voluntary_work_id, volunteer.email AS volunteer_email		
                        FROM application
                        LEFT JOIN voluntary_work_institution ON application.voluntary_work_institution_id = voluntary_work_institution.id
                        LEFT JOIN voluntary_work_organization ON application.voluntary_work_organization_id = voluntary_work_organization.id
                        LEFT JOIN organization ON voluntary_work_organization.organization_id = organization.id
                        LEFT JOIN volunteer ON application.volunteer_id = volunteer.id
                        WHERE voluntary_work_institution.institution_id = $inst_id AND application.status != 'REJECTED' AND application.status != 'PENDING' AND application.status != 'PARTICIPATE' 
                        AND application.status != 'ABSENT' AND application.status != 'COMPLETED' AND application.status != 'DONE'
                        UNION ALL
                        SELECT application.id, application.status, application.volunteer_id, voluntary_work_institution.id AS voluntary_work_id, 
                          voluntary_work_institution.name AS voluntary_work_name, volunteer.username AS volunteer_username, volunteer.contact_number AS volunteer_contact_number,
                          voluntary_work_institution.institution_id AS organizer_of_voluntary_work_id, volunteer.email AS volunteer_email                       
                        FROM application
                        LEFT JOIN voluntary_work_institution ON application.voluntary_work_institution_id = voluntary_work_institution.id
                        LEFT JOIN voluntary_work_organization ON application.voluntary_work_organization_id = voluntary_work_organization.id
                        LEFT JOIN institution ON voluntary_work_institution.institution_id = institution.id
                        LEFT JOIN volunteer ON application.volunteer_id = volunteer.id
                        WHERE voluntary_work_institution.institution_id = $inst_id AND application.status != 'REJECTED' AND application.status != 'PENDING' AND application.status != 'PARTICIPATE' 
                        AND application.status != 'ABSENT' AND application.status != 'COMPLETED' AND application.status != 'DONE'
                    ) AS subquery
                        WHERE organizer_of_voluntary_work_id IS NOT NULL
                        LIMIT $offset, $records_per_page";

                    $result = mysqli_query($dbc, $sql);

                    // Display the records
                    if (mysqli_num_rows($result) > 0) {

                      echo "<center><p>There are currently <b>{$row['total']}</b> approved applications</p><br></center>";

                      // Output the results in a table
                      // Table header:
                      echo '
                      <table class="mb-4" align="center" cellspacing="8" cellpadding="8" width="100%">
                          <tr>
                            <td align="center"><b>No. </b></td>
                            <td align="center"><b>Voluntary Work Name </b></td>
                            <td align="center"><b>Volunteer Username </b></td>
                            <td align="center"><b>Volunteer Contact Number </b></td>
                            <td align="center"><b>Volunteer Email </b></td>
                            <td align="center"><b>Status </b></td>
                            <td align="center"><b>Applicant\'s Details</b></td>
                          </tr>';

                            $row_num = ($current_page - 1) * $records_per_page + 1; // Calculate the initial row number for the current page
                            
                            // Fetch and print all the records:
                            while ($row = mysqli_fetch_assoc($result)) {

                              //Determining the colour of the status message
                              $status = $row['status'];
                              $backgroundColor = '';

                              if ($status == 'APPROVED') {
                                $backgroundColor = '#FFD32D'; // Yellow color
                              } 

                              echo '
                                <tr>
                                  <td align="center">' . $row_num++ . '</td>
                                  <td align="center">' . $row['voluntary_work_name'] . '</td>
                                  <td align="center">' . $row['volunteer_username'] . '</td>
                                  <td align="center">' . $row['volunteer_contact_number'] . '</td>
                                  <td align="center">' . $row['volunteer_email'] . '</td>
                                  <td align="center">
                                    <button class="btn btn-secondary px-4" style="background-color: ' . $backgroundColor . ';">' . $status . '</button>
                                  </td>
                                  <td align="center">
                                    <div>';
                                    // Check if status is 'APPROVED' or 'REJECTED' to disable the button
                                    if ($status != 'REJECTED') { // If the status is 'PENDING'
                                      echo '<a style="background-color: #89C4E1;" class="btn btn-secondary" role="button" href="view_applicants_details_approved_institution.php?id=' . $row['volunteer_id'] . '">VIEW</a>';
                                    } else { // If the status is 'APPROVED' or 'REJECTED'
                                      echo '<button class="btn btn-danger" style="background-color: #89C4E1;" disabled>VIEW</button>';
                                    }
                                    echo'</div>
                                  </td>
                                </tr>';
                            }     
                      echo '</table>

                      <div class="mb-2">';
              
                    // Determine the range of pages to display
                    $range = 2; // Number of links to show before and after the current page
                    $start_range = max(1, $current_page);
                    $end_range = min($total_pages, $current_page + $range);

                    // Render pagination links
                    if ($current_page > 1) {
                      echo "<a href='view_applications_approved_institution.php?page=" . ($current_page - 1) . "'>Previous &nbsp</a> ";
                    }
                    if ($start_range > 1) {
                      echo "<a href='view_applications_approved_institution.php?page=1'>1 &nbsp</a> ";
                      if ($start_range > 2) {
                        echo "... ";
                      }
                    }
                    for ($i = $start_range; $i <= $end_range; $i++) {
                      if ($i == $current_page) {
                        echo "<b>$i &nbsp</b> ";
                      } else {
                        echo "<a href='view_applications_approved_institution.php?page=$i'>$i &nbsp</a> ";
                      }
                    }
                    if ($end_range < $total_pages) {
                      if ($end_range < $total_pages - 1) {
                        echo "... &nbsp";
                      }
                      echo "<a href='view_applications_approved_institution.php?page=$total_pages'>$total_pages &nbsp</a> ";
                    }
                    if ($current_page < $total_pages) {
                      echo "<a href='view_applications_approved_institution.php?page=" . ($current_page + 1) . "'>Next &nbsp</a> ";
                    }

                      mysqli_free_result($result); // Free memory associated with $r	

                    } else { // If no records are found, display alert message.
                      echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                        <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_s0fkqiqh.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px; margin-top:-30px"  loop  autoplay></lottie-player>';
                      echo '<p class="error">There are currently no application that has been approved.</p><br></center>';
                    }

                  }
          
                    // Close the database connection
                    mysqli_close($dbc); // Close database connection

                    echo ' </div></div></div></div></div></div>';
                    include('includes/footer.php');

        ?>
        </div>
      </section>
    <!-- Section: Main chart -->
  </div>
</main>
<!--Main layout-->