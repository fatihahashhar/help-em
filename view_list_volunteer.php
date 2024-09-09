<?php
// This script retrieves all the records from the volunteer table.
// This new version links to view and delete pages.
$page_title = 'View List of Volunteers';
session_start(); // Start the session.

// If no session value is present, redirect the user:
if (!isset($_SESSION['admin_id'])) {
  header("Location: login_admin.php");
}

?>
<!--Main Navigation-->
<header>
  <!-- Sidebar -->
  <?php
  include('includes/sidebar_for_admin.html');
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
  <div class="container pt-4">
    <!-- Section: Main chart -->
    <section class="mb-4">
      <div>
        <?php
        require('../mysqli_connect_fyp.php');

        echo ' <div class="container mx-auto" style="width: 75rem;"><br>
            <div class="card text-center bg-light text-dark bg-opacity-100" style="width: 75rem;">
              <div class="card-header">
                <img src="images/v.png" class="p-2 my-2" height="200" alt="Volunteer Logo" loading="lazy" style="margin-top: -1px />
              </div>
          <div class=" card-body text-start">';

        //Search form
        $search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';
        echo '<form class="m-3 d-flex justify-content-center" method="GET" action="view_list_volunteer.php">
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
          $sql = "SELECT * FROM volunteer WHERE first_name LIKE '%$search_query%' OR last_name LIKE '%$search_query%' OR username LIKE '%$search_query%'";

          // Execute the query
          $r = @mysqli_query($dbc, $sql);

          // Count the number of returned rows:
          $num = mysqli_num_rows($r);

          // Check if any results are found
          if ($num > 0) {     //If it is found..
            echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
	            <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_zyjeeirq.json"  background="transparent"  speed="1" class="mb-2" style="width: 150px; height: 150px;"  loop  autoplay></lottie-player>';
            // Print how many members there are:
            echo "<p><b>$num</b> results found.</p>\n</center>";

            // Output the results in a table
            // Table header:
            echo '<table align="center" cellspacing="8" cellpadding="8" width="100%">
              <tr>
                <td align="center"><b>ID </b></td>
                <td align="center"><b>Name </b></td>
                <td align="center"><b>Email </b></td>
                <td align="center"><b>Contact Number </b></td>
                <td align="center"><b>View Details </b></td>
                <td align="center"><b>Delete </b></td>
              </tr>';

            // Fetch and print all the records:
            while ($row = $r->fetch_assoc()) {
              echo '<tr>
                  <td align="center">' . $row['id'] . '</td>
                  <td align="center">' . $row['first_name'] . ' ' . $row['last_name'] . '</td>
                  <td align="center">' . $row['email'] . '</td>
                  <td align="center">' . $row['contact_number'] . '</td>
                  <td align="center">
                    <div>
                      <a style="background-color: #89C4E1;" class="btn btn-secondary" role="button" href="view_details_volunteer.php?id=' . $row['id'] . '"><i class="far fa-eye"></i></a>
                    </div>
                  </td>
                  <td align="center">
                    <div>
                      <a style="background-color: #518cbb;" class="btn btn-danger" role="button" href="delete_volunteer.php?id=' . $row['id'] . '"><i class="fas fa-trash"></i></a>
                    </div>
                  </td>
                </tr>';
            }
            echo "</table>";
          } else {    // If it is not found..
            echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
	              <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_s0fkqiqh.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px; margin-top:-15px"  loop  autoplay></lottie-player>';
            echo '<p class="error">No volunteer found.</p></center>';
          }
        } else { // if the user does not attempt to search yet, display all data in the table
          // Set the number of records to display per page
          $records_per_page = 5;

          // Calculate the total number of pages
          $sql = 'SELECT COUNT(*) AS total FROM volunteer';
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
          $sql = "SELECT volunteer.id, volunteer.first_name, volunteer.last_name, volunteer.email, volunteer.contact_number FROM volunteer LIMIT $offset, $records_per_page";
          $result = mysqli_query($dbc, $sql);

          // Display the records
          if (mysqli_num_rows($result) > 0) {
            echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
        <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_zyjeeirq.json"  background="transparent"  speed="1" class="mb-2" style="width: 150px; height: 150px; margin-top: -5px;"  loop  autoplay></lottie-player>';
            echo "<p>There are currently <b>{$row['total']}</b> volunteer registered.</p></center>";

            // Output the results in a table
            // Table header:
            echo '<table class="mb-4" align="center" cellspacing="8" cellpadding="8" width="100%">
                <tr>
                  <td align="center"><b>ID </b></td>
                  <td align="center"><b>Name </b></td>
                  <td align="center"><b>Email </b></td>
                  <td align="center"><b>Contact Number </b></td>
                  <td align="center"><b>View Details </b></td>
                  <td align="center"><b>Delete </b></td>';

            // Fetch and print all the records:
            while ($row = mysqli_fetch_assoc($result)) {
              echo '<tr>
                <td align="center">' . $row['id'] . '</td>
                <td align="center">' . $row['first_name'] . ' ' . $row['last_name'] . '</td>
                <td align="center">' . $row['email'] . '</td>
                <td align="center">' . $row['contact_number'] . '</td>
                <td align="center">
                    <div>
                      <a style="background-color: #89C4E1;" class="btn btn-secondary" role="button" href="view_details_volunteer.php?id=' . $row['id'] . '"><i class="far fa-eye"></i></a>
                    </div>
                  </td>
                  <td align="center">
                    <div>
                      <a style="background-color: #518cbb;" class="btn btn-danger" role="button" href="delete_volunteer.php?id=' . $row['id'] . '"><i class="fas fa-trash"></i></a>
                    </div>
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
              echo "<a href='view_list_volunteer.php?page=" . ($current_page - 1) . "'>Previous &nbsp</a> ";
            }
            if ($start_range > 1) {
              echo "<a href='view_list_volunteer.php?page=1'>1 &nbsp</a> ";
              if ($start_range > 2) {
                echo "... ";
              }
            }
            for ($i = $start_range; $i <= $end_range; $i++) {
              if ($i == $current_page) {
                echo "<b>$i &nbsp</b> ";
              } else {
                echo "<a href='view_list_volunteer.php?page=$i'>$i &nbsp</a> ";
              }
            }
            if ($end_range < $total_pages) {
              if ($end_range < $total_pages - 1) {
                echo "... &nbsp";
              }
              echo "<a href='view_list_volunteer.php?page=$total_pages'>$total_pages &nbsp</a> ";
            }
            if ($current_page < $total_pages) {
              echo "<a href='view_list_volunteer.php?page=" . ($current_page + 1) . "'>Next &nbsp</a> ";
            }
            echo "</div></div>";

            mysqli_free_result($result); // Free memory associated with $r	

          } else { // If no records are found, display alert message.
            echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
              <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_s0fkqiqh.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px; margin-top:-15px"  loop  autoplay></lottie-player>';
            echo '<p class="error">There are currently no volunteer.</p></center>';
          }
        }

        // Close the database connection
        mysqli_close($dbc); // Close database connection

        echo ' </div></div></div></div></div></br>';
        include('includes/footer.php');

        ?>
      </div>
    </section>
    <!-- Section: Main chart -->
  </div>
</main>
<!--Main layout-->