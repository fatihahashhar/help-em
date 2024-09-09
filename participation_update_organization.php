<?php
// This script retrieves all the records from the application table.
$page_title = 'Participation Update of the Volunteer';
session_start(); // Start the session.

// If no session value is present, redirect the user:
if (!isset($_SESSION['organization_id'])) {
  header("Location: login_organization.php");
}

?>
<!--Main Navigation-->
<header>
  <!-- Sidebar -->
	<?php
	include('includes/sidebar_for_organization.html');
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

            $query_get_org_id = (isset($_SESSION['organization_id']));
            $org_id = $_SESSION['organization_id']; // Run the query.

            echo '
            <div class="container mx-auto" style="width: 75rem;">
              <div class="card text-center bg-light text-dark bg-opacity-100" style="width: 75rem;">
                  <div class="card-header">
                    <img src="images/pu.png" class="p-2 my-3" height="200" alt="Application Logo" loading="lazy" style="margin-top: -1px />
                  </div>
                  <div class="card-body text-start">';
                    
                    // Set the number of records to display per page
                    $records_per_page = 10;

                    // Calculate the total number of pages
                    $sql = "SELECT COUNT(*) AS total FROM application WHERE voluntary_work_organization_id IN 
                              (
                                SELECT id FROM voluntary_work_organization WHERE organization_id = $org_id AND application.status != 'REJECTED' AND application.status != 'PENDING' AND application.status != 'COMPLETED'
                                AND application.status != 'DONE'
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
                    $status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : '';

                    echo '
                    <form id="search_box" class="m-3 d-flex justify-content-center" method="GET" action="participation_update_organization.php">
                      <div class="input-group w-75">
                      <input type="text" name="search_query" placeholder="Search... (Work Name, Volunteer Username, Date, or Start Time)" class="form-control" style="height: 39px; width: 300px;" maxlength="50" value="' . htmlspecialchars($search_query) . '">
                      <select class="form-select" name="status_filter" style="width: 5px;">
                        <option value="">STATUS ?</option>
                        <option value="APPROVED"' . ($status_filter == 'APPROVED' ? ' selected' : '') . '>APPROVED</option>
                        <option value="ABSENT"' . ($status_filter == 'ABSENT' ? ' selected' : '') . '>ABSENT</option>
                        <option value="PARTICIPATE"' . ($status_filter == 'PARTICIPATE' ? ' selected' : '') . '>PARTICIPATE</option>
                      </select>
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
                      $sql = "SELECT id, app_status AS status, volunteer_id, voluntary_work_id, voluntary_work_name, volunteer_username, voluntary_work_date, voluntary_work_start_time, organizer_of_voluntary_work_id
                      FROM
                      (
                          SELECT application.id, application.status AS app_status, application.volunteer_id, voluntary_work_organization.id AS voluntary_work_id, 
                              voluntary_work_organization.name AS voluntary_work_name, volunteer.username AS volunteer_username, voluntary_work_organization.organization_id AS organizer_of_voluntary_work_id,
                              voluntary_work_organization.date as voluntary_work_date, voluntary_work_organization.start_time as voluntary_work_start_time 		
                          FROM application
                          LEFT JOIN voluntary_work_institution ON application.voluntary_work_institution_id = voluntary_work_institution.id
                          LEFT JOIN voluntary_work_organization ON application.voluntary_work_organization_id = voluntary_work_organization.id
                          LEFT JOIN organization ON voluntary_work_organization.organization_id = organization.id
                          LEFT JOIN volunteer ON application.volunteer_id = volunteer.id
                          WHERE voluntary_work_organization.organization_id = $org_id AND application.status != 'REJECTED' AND application.status != 'PENDING' AND application.status != 'COMPLETED' AND application.status != 'DONE'
                          AND (voluntary_work_organization.name LIKE '%$search_query%' OR volunteer.username LIKE '%$search_query%' OR voluntary_work_organization.date LIKE '%$search_query%'
                          OR voluntary_work_organization.start_time LIKE '%$search_query%')
                                                
                          UNION ALL
                                                
                          SELECT application.id, application.status AS app_status, application.volunteer_id, voluntary_work_institution.id AS voluntary_work_id, 
                              voluntary_work_institution.name AS voluntary_work_name, volunteer.username AS volunteer_username, voluntary_work_institution.institution_id AS organizer_of_voluntary_work_id,
                              voluntary_work_institution.date as voluntary_work_date, voluntary_work_institution.start_time as voluntary_work_start_time
                          FROM application
                          LEFT JOIN voluntary_work_institution ON application.voluntary_work_institution_id = voluntary_work_institution.id
                          LEFT JOIN voluntary_work_organization ON application.voluntary_work_organization_id = voluntary_work_organization.id
                          LEFT JOIN institution ON voluntary_work_institution.institution_id = institution.id
                          LEFT JOIN volunteer ON application.volunteer_id = volunteer.id
                          WHERE voluntary_work_organization.organization_id = $org_id AND application.status != 'REJECTED' AND application.status != 'PENDING' AND application.status != 'COMPLETED' AND application.status != 'DONE'
                          AND (voluntary_work_institution.name LIKE '%$search_query%' OR volunteer.username LIKE '%$search_query%' OR voluntary_work_institution.date LIKE '%$search_query%'
                          OR voluntary_work_institution.start_time LIKE '%$search_query%')
                      ) AS subquery
                      WHERE voluntary_work_name IS NOT NULL AND organizer_of_voluntary_work_id = $org_id AND app_status != 'PENDING' AND app_status != 'REJECTED' AND app_status != 'COMPLETED' AND app_status != 'DONE'";

                      if (!empty($status_filter)) {
                      $sql .= " AND app_status = '$status_filter'";
                      }

                      $sql .= " ORDER BY voluntary_work_date ASC";

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
                                <td align="center"><b>Date </b></td>
                                <td align="center"><b>Start Time </b></td>
                                <td align="center"><b>Volunteer Username </b></td>
                                <td align="center"><b>Status </b></td>
                                <td align="center"><b>Applicant\'s Details</b></td>
                                <td align="center"><b>Participate</b></td>
                                <td align="center"><b>Absent </b></td>
                                <td align="center"><b>Completed </b></td>
                              </tr>';

                              $row_num = ($current_page - 1) * $records_per_page + 1; // Calculate the initial row number for the current page
                              
                              // Fetch and print all the records:
                              while ($row = mysqli_fetch_assoc($result)) {

                                //Determining the colour of the status message
                                $status = $row['status'];
                                $backgroundColor = '';

                                if ($status == 'APPROVED') {
                                  $backgroundColor = '#FFD32D'; // Yellow color
                                } elseif ($status == 'PARTICIPATE') {
                                  $backgroundColor = '#38E54D'; // Light Green color
                                } elseif ($status == 'ABSENT') {
                                  $backgroundColor = '#850000'; // Dark Red color
                                }

                                echo '
                                <tr>
                                  <td align="center">' . $row_num++ . '</td>
                                  <td align="center">' . $row['voluntary_work_name'] . '</td>
                                  <td align="center">' . $row['voluntary_work_date'] . '</td>
                                  <td align="center">' . $row['voluntary_work_start_time'] . '</td>
                                  <td align="center">' . $row['volunteer_username'] . '</td>
                                  <td align="center">
                                    <button class="btn btn-secondary px-4" style="background-color: ' . $backgroundColor . ';">' . $status . '</button>
                                  </td>
                                  <td align="center">
                                    <div>';
                                    // Check if status is 'REJECTED' to disable the button
                                    if ($status != 'REJECTED') { // If the status is 'REJECTED'
                                      echo '<a style="background-color: #89C4E1;" class="btn btn-secondary" role="button" href="view_applicants_details_participation_update_organization.php?id=' . $row['volunteer_id'] . '">VIEW</a>';
                                    } else { // If the status is 'REJECTED'
                                      echo '<button class="btn btn-danger" style="background-color: #89C4E1;" disabled>VIEW</button>';
                                    }
                                      
                                    echo'</div>
                                  </td>
                                  <td align="center">
                                    <div>';
                                      // Check if status is 'PARTICIPATE' to disable the button
                                      if ($status != 'PARTICIPATE') { // If the status is 'PARTICIPATE'
                                        echo '<a style="background-color: #54B435;" class="btn btn-secondary" role="button" href="participation_update_participate_organization.php?id=' . $row['id'] . '"><i class="fa-solid fa-square-check"></i></a>';
                                      } else { // If the status is 'PARTICIPATE'
                                        echo '<button class="btn btn-danger" style="background-color: #54B435;" disabled><i class="fa-solid fa-square-check"></i></button>';
                                      }
                                    echo' </div>
                                  </td>
                                  <td align="center">
                                    <div>';
                                      // Check if status is 'ABSENT' to disable the button
                                      if ($status != 'ABSENT') { // If the status is 'ABSENT'
                                        echo '<a style="background-color: #DF2E38;" class="btn btn-danger" role="button" href="participation_update_absent_organization.php?id=' . $row['id'] . '"><i class="fa-solid fa-square-xmark"></i></a>';
                                      } else { // If the status is 'ABSENT'
                                        echo '<button class="btn btn-danger" style="background-color: #DF2E38;" disabled><i class="fa-solid fa-square-xmark"></i></button>';
                                      }
                                echo '</div>
                                  </td>
                                  <td align="center">
                                    <div>';
                                      // Check if status is other than 'ABSENT' or 'PARTICIPATE' to disable the button
                                      if ($status == 'PARTICIPATE') { // If the status is 'ABSENT' or 'PARTICIPATE'
                                        echo '<a style="background-color: #367E18;" class="btn btn-danger" role="button" href="participation_update_completed_organization.php?id=' . $row['id'] . '"><i class="fa-solid fa-thumbs-up"></i></a>';
                                      } else { // If the status is not 'ABSENT' or 'PARTICIPATE'
                                        echo '<button class="btn btn-danger" style="background-color: #367E18;" disabled><i class="fa-solid fa-thumbs-up"></i></button>';
                                      }
                                echo '</div>
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
                        echo "<a href='participation_update_organization.php?page=" . ($current_page - 1) . "'>Previous &nbsp</a> ";
                      }
                      if ($start_range > 1) {
                        echo "<a href='participation_update_organization.php?page=1'>1 &nbsp</a> ";
                        if ($start_range > 2) {
                          echo "... ";
                        }
                      }
                      for ($i = $start_range; $i <= $end_range; $i++) {
                        if ($i == $current_page) {
                          echo "<b>$i &nbsp</b> ";
                        } else {
                          echo "<a href='participation_update_organization.php?page=$i'>$i &nbsp</a> ";
                        }
                      }
                      if ($end_range < $total_pages) {
                        if ($end_range < $total_pages - 1) {
                          echo "... &nbsp";
                        }
                        echo "<a href='participation_update_organization.php?page=$total_pages'>$total_pages &nbsp</a> ";
                      }
                      if ($current_page < $total_pages) {
                        echo "<a href='participation_update_organization.php?page=" . ($current_page + 1) . "'>Next &nbsp</a> ";
                      };
              
                      } else {    // If it is not found..
                        echo '
                        <center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                        <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_s0fkqiqh.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px; margin-top:-40px"  loop  autoplay></lottie-player>
                        <p class="error">0 results found.</p></center>';
                      }

                    } else { // if the user does not attempt to search yet, display all data in the table
                    
                    // Retrieve the records from the database
                    $sql = "SELECT id, status, volunteer_id, voluntary_work_id, voluntary_work_name, volunteer_username, voluntary_work_date, voluntary_work_start_time, organizer_of_voluntary_work_id
                    FROM
                    (
                        SELECT application.id, application.status, application.volunteer_id, voluntary_work_organization.id AS voluntary_work_id, 
                          voluntary_work_organization.name AS voluntary_work_name, volunteer.username AS volunteer_username, voluntary_work_organization.organization_id AS organizer_of_voluntary_work_id,
                          voluntary_work_organization.date as voluntary_work_date, voluntary_work_organization.start_time as voluntary_work_start_time
                        FROM application
                        LEFT JOIN voluntary_work_institution ON application.voluntary_work_institution_id = voluntary_work_institution.id
                        LEFT JOIN voluntary_work_organization ON application.voluntary_work_organization_id = voluntary_work_organization.id
                        LEFT JOIN organization ON voluntary_work_organization.organization_id = organization.id
                        LEFT JOIN volunteer ON application.volunteer_id = volunteer.id
                        WHERE voluntary_work_organization.organization_id = $org_id AND application.status != 'REJECTED' AND application.status != 'PENDING' AND application.status != 'COMPLETED' AND application.status != 'DONE'
                        UNION ALL
                        SELECT application.id, application.status, application.volunteer_id, voluntary_work_institution.id AS voluntary_work_id, 
                          voluntary_work_institution.name AS voluntary_work_name, volunteer.username AS volunteer_username, voluntary_work_institution.institution_id AS organizer_of_voluntary_work_id,
                          voluntary_work_institution.date as voluntary_work_date, voluntary_work_institution.start_time as voluntary_work_start_time                          
                        FROM application
                        LEFT JOIN voluntary_work_institution ON application.voluntary_work_institution_id = voluntary_work_institution.id
                        LEFT JOIN voluntary_work_organization ON application.voluntary_work_organization_id = voluntary_work_organization.id
                        LEFT JOIN institution ON voluntary_work_institution.institution_id = institution.id
                        LEFT JOIN volunteer ON application.volunteer_id = volunteer.id
                        WHERE voluntary_work_organization.organization_id = $org_id AND application.status != 'REJECTED' AND application.status != 'PENDING' AND application.status != 'COMPLETED' AND application.status != 'DONE'
                    ) AS subquery
                        WHERE voluntary_work_name IS NOT NULL
                        ORDER BY voluntary_work_date ASC
                        LIMIT $offset, $records_per_page";

                    $result = mysqli_query($dbc, $sql);

                    // Display the records
                    if (mysqli_num_rows($result) > 0) {

                      echo "<center><p>There are currently <b>{$row['total']}</b> volunteer's participation needs to be updated</p><br></center>";

                      // Output the results in a table
                      // Table header:
                      echo '
                      <table class="mb-4" align="center" cellspacing="8" cellpadding="8" width="100%">
                          <tr>
                            <td align="center"><b>No. </b></td>
                            <td align="center"><b>Voluntary Work Name </b></td>
                            <td align="center"><b>Date </b></td>
                            <td align="center"><b>Start Time </b></td>
                            <td align="center"><b>Volunteer Username </b></td>
                            <td align="center"><b>Status </b></td>
                            <td align="center"><b>Applicant\'s Details</b></td>
                            <td align="center"><b>Participate </b></td>
                            <td align="center"><b>Absent </b></td>
                            <td align="center"><b>Completed </b></td>
                          </tr>';

                            $row_num = ($current_page - 1) * $records_per_page + 1; // Calculate the initial row number for the current page
                            
                            // Fetch and print all the records:
                            while ($row = mysqli_fetch_assoc($result)) {

                              //Determining the colour of the status message
                              $status = $row['status'];
                              $backgroundColor = '';

                              if ($status == 'APPROVED') {
                                $backgroundColor = '#FFD32D'; // Yellow color
                              } elseif ($status == 'PARTICIPATE') {
                                $backgroundColor = '#38E54D'; // Light Green color
                              } elseif ($status == 'ABSENT') {
                                $backgroundColor = '#850000'; // Dark Red color
                              }

                              echo '
                                <tr>
                                  <td align="center">' . $row_num++ . '</td>
                                  <td align="center">' . $row['voluntary_work_name'] . '</td>
                                  <td align="center">' . $row['voluntary_work_date'] . '</td>
                                  <td align="center">' . $row['voluntary_work_start_time'] . '</td>
                                  <td align="center">' . $row['volunteer_username'] . '</td>
                                  <td align="center">
                                    <button class="btn btn-secondary px-4" style="background-color: ' . $backgroundColor . ';">' . $status . '</button>
                                  </td>
                                  <td align="center">
                                    <div>';
                                    // Check if status is 'REJECTED' to disable the button
                                    if ($status != 'REJECTED') { // If the status is 'REJECTED'
                                      echo '<a style="background-color: #89C4E1;" class="btn btn-secondary" role="button" href="view_applicants_details_participation_update_organization.php?id=' . $row['volunteer_id'] . '">VIEW</a>';
                                    } else { // If the status is 'REJECTED'
                                      echo '<button class="btn btn-danger" style="background-color: #89C4E1;" disabled>VIEW</button>';
                                    }
                                      
                                    echo'</div>
                                  </td>
                                  <td align="center">
                                    <div>';
                                      // Check if status is 'PARTICIPATE' to disable the button
                                      if ($status != 'PARTICIPATE') { // If the status is 'PARTICIPATE'
                                        echo '<a style="background-color: #54B435;" class="btn btn-secondary" role="button" href="participation_update_participate_organization.php?id=' . $row['id'] . '"><i class="fa-solid fa-square-check"></i></a>';
                                      } else { // If the status is 'PARTICIPATE'
                                        echo '<button class="btn btn-danger" style="background-color: #54B435;" disabled><i class="fa-solid fa-square-check"></i></button>';
                                      }
                                    echo' </div>
                                  </td>
                                  <td align="center">
                                    <div>';
                                      // Check if status is 'ABSENT' to disable the button
                                      if ($status != 'ABSENT') { // If the status is 'ABSENT'
                                        echo '<a style="background-color: #DF2E38;" class="btn btn-danger" role="button" href="participation_update_absent_organization.php?id=' . $row['id'] . '"><i class="fa-solid fa-square-xmark"></i></a>';
                                      } else { // If the status is 'ABSENT'
                                        echo '<button class="btn btn-danger" style="background-color: #DF2E38;" disabled><i class="fa-solid fa-square-xmark"></i></button>';
                                      }
                                echo '</div>
                                  </td>
                                  <td align="center">
                                    <div>';
                                      // Check if status is other than 'ABSENT' or 'PARTICIPATE' to disable the button
                                      if ($status == 'PARTICIPATE') { // If the status is 'ABSENT' or 'PARTICIPATE'
                                        echo '<a style="background-color: #367E18;" class="btn btn-danger" role="button" href="participation_update_completed_organization.php?id=' . $row['id'] . '"><i class="fa-solid fa-thumbs-up"></i></a>';
                                      } else { // If the status is not 'ABSENT' or 'PARTICIPATE'
                                        echo '<button class="btn btn-danger" style="background-color: #367E18;" disabled><i class="fa-solid fa-thumbs-up"></i></button>';
                                      }
                                echo '</div>
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
                      echo "<a href='participation_update_organization.php?page=" . ($current_page - 1) . "'>Previous &nbsp</a> ";
                    }
                    if ($start_range > 1) {
                      echo "<a href='participation_update_organization.php?page=1'>1 &nbsp</a> ";
                      if ($start_range > 2) {
                        echo "... ";
                      }
                    }
                    for ($i = $start_range; $i <= $end_range; $i++) {
                      if ($i == $current_page) {
                        echo "<b>$i &nbsp</b> ";
                      } else {
                        echo "<a href='participation_update_organization.php?page=$i'>$i &nbsp</a> ";
                      }
                    }
                    if ($end_range < $total_pages) {
                      if ($end_range < $total_pages - 1) {
                        echo "... &nbsp";
                      }
                      echo "<a href='participation_update_organization.php?page=$total_pages'>$total_pages &nbsp</a> ";
                    }
                    if ($current_page < $total_pages) {
                      echo "<a href='participation_update_organization.php?page=" . ($current_page + 1) . "'>Next &nbsp</a> ";
                    }

                      mysqli_free_result($result); // Free memory associated with $r	

                    } else { // If no records are found, display alert message.
                      echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                        <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_s0fkqiqh.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px; margin-top:-30px"  loop  autoplay></lottie-player>';
                      echo '<p class="error">There are currently no participation to be updated.</p><br></center>';
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