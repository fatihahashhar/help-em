<?php
$page_title = 'View Active Voluntary Work';
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
	<div class="container pt-4"  style="padding-right: 30px;">
		<!-- Section: Main chart -->
		<section class="mb-4">
			<div>
				<?php
				// This script retrieves all the records from the voluntary_work_organization table.
				// This new version links to view and delete pages.

				require('../mysqli_connect_fyp.php');

				$query_get_org_id = (isset($_SESSION['organization_id']));
				$org_id = $_SESSION['organization_id']; // Run the query.

				echo ' 
		<div class="container mx-auto" style="width: 75rem;">
            <div class="card px-3 text-center bg-light text-dark bg-opacity-100" style="width: 75rem;">
              <div class="card-header">
                <img src="images/vw.png" class="p-2 my-3" height="200" alt="Voluntary Work Logo" loading="lazy" style="margin-top: -1px />
              </div>
          	<div class="card-body text-start">';

				// Set the number of records to display per page
				$records_per_page = 5;

				// Calculate the total number of pages
				$sql = "SELECT COUNT(*) AS total FROM voluntary_work_organization WHERE organization_id = $org_id AND voluntary_work_organization.status != 'FINISHED'";
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
				<form id="search_box" class="m-3 d-flex justify-content-center" method="GET" action="view_voluntary_work_list_organization.php">
					<div class="input-group w-75">
					<input type="text" name="search_query" placeholder="Search... (Program Name or Task)" class="form-control" style="height: 39px; width: 250px;" maxlength="50" value="' . htmlspecialchars($search_query) . '">
					<select class="form-select" name="status_filter" style="width: 100px;">
						<option value="">STATUS ?</option>
						<option value="OPEN FOR REGISTRATION"' . ($status_filter == 'OPEN FOR REGISTRATION' ? ' selected' : '') . '>OPEN FOR REGISTRATION</option>
						<option value="IN REVIEW"' . ($status_filter == 'IN REVIEW' ? ' selected' : '') . '>IN REVIEW</option>
						<option value="COMING SOON"' . ($status_filter == 'COMING SOON' ? ' selected' : '') . '>COMING SOON</option>
						<option value="ON-GOING"' . ($status_filter == 'ON-GOING' ? ' selected' : '') . '>ON-GOING</option>
						<option value="CLOSED FOR REGISTRATION"' . ($status_filter == 'CLOSED FOR REGISTRATION' ? ' selected' : '') . '>CLOSED FOR REGISTRATION</option>
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

					// Get input given by the user in the text box
					$search_query = $_GET["search_query"];
					$status_filter = isset($_GET["status_filter"]) ? $_GET["status_filter"] : '';

					// Prepare the SQL query
					$sql = "SELECT * FROM voluntary_work_organization 
							WHERE (name LIKE '%$search_query%' OR task LIKE '%$search_query%') 
							AND organization_id = $org_id AND status != 'FINISHED'";

					if (!empty($status_filter)) {
						$sql .= " AND status = '$status_filter'";
					}

					$sql .= " ORDER BY date ASC";

					// Execute the query
					$r = @mysqli_query($dbc, $sql);

					// Count the number of returned rows:
					$num = mysqli_num_rows($r);

					// Check if any results are found
					if ($num > 0) {     //If it is found..
						// Print how many members there are:
						echo "<center><p><b>$num</b> voluntary work found.</p>\n</center><br>";

						// Output the results in a table
						// Table header:
						echo '<table align="center" cellspacing="8" cellpadding="8" width="100%">
						<tr>
							<td align="center"><b>ID </b></td>
							<td align="center"><b>Program Name </b></td>
							<td align="center"><b>Task </b></td>
							<td align="center"><b>Date </b></td>
							<td align="center"><b>Status </b></td>
							<td align="center"><b>Edit Details </b></td>
							<td align="center"><b>Delete </b></td>
						</tr>';

						// Fetch and print all the records:
						while ($row = $r->fetch_assoc()) {
							echo '<tr>
							<td align="center">' . $row['id'] . '</td>
							<td align="center">' . $row['name'] . '</td>
							<td align="center">' . $row['task'] . '</td>
							<td align="center">' . $row['date'] . '</td>
							<td align="center">' . $row['status'] . '</td>
							<td align="center">
								<div>
									<a style="background-color: #89C4E1;" class="btn btn-secondary" role="button" href="edit_details_voluntary_work_organization.php?id=' . $row['id'] . '"><i class="fas fa-edit"></i></a>
								</div>
							</td>
							<td align="center">
								<div>
									<a style="background-color: #518cbb;" class="btn btn-danger" role="button" href="delete_voluntary_work_organization.php?id=' . $row['id'] . '"><i class="fas fa-trash"></i></a>
								</div>
							</td>
                			</tr>';
						}
						echo "</table>";

						echo' <div class="mb-2">';
							// Determine the range of pages to display
							$range = 2; // Number of links to show before and after the current page
							$start_range = max(1, $current_page);
							$end_range = min($total_pages, $current_page + $range);

							// Render pagination links
							if ($current_page > 1) {
								echo "<a href='view_voluntary_work_list_organization.php?page=" . ($current_page - 1) . "'>Previous &nbsp</a> ";
							}
							if ($start_range > 1) {
								echo "<a href='view_voluntary_work_list_organization.php?page=1'>1 &nbsp</a> ";
								if ($start_range > 2) {
									echo "... ";
								}
							}
							for ($i = $start_range; $i <= $end_range; $i++) {
								if ($i == $current_page) {
									echo "<b>$i &nbsp</b> ";
								} else {
									echo "<a href='view_voluntary_work_list_organization.php?page=$i'>$i &nbsp</a> ";
								}
							}
							if ($end_range < $total_pages) {
								if ($end_range < $total_pages - 1) {
									echo "... &nbsp";
								}
								echo "<a href='view_voluntary_work_list_organization.php?page=$total_pages'>$total_pages &nbsp</a> ";
							}
							if ($current_page < $total_pages) {
								echo "<a href='view_voluntary_work_list_organization.php?page=" . ($current_page + 1) . "'>Next &nbsp</a> ";
							}

					} else {    // If it is not found..
						echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
	              			<lottie-player src="https://assets1.lottiefiles.com/packages/lf20_s0fkqiqh.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px; margin-top:-15px"  loop  autoplay></lottie-player>';
						echo '<p class="error">No results found.</p></center>';
					}

				} else { // if the user does not attempt to search yet, display all data in the table
					
					// Retrieve the records from the database
					$sql = "SELECT voluntary_work_organization.id, voluntary_work_organization.name, voluntary_work_organization.task, voluntary_work_organization.date, voluntary_work_organization.status 
					FROM voluntary_work_organization WHERE organization_id = $org_id AND voluntary_work_organization.status != 'FINISHED' ORDER BY voluntary_work_organization.date ASC LIMIT $offset, $records_per_page";
					$result = mysqli_query($dbc, $sql);

					// Display the records
					if (mysqli_num_rows($result) > 0) {
						echo "<center><p>There are currently <b>{$row['total']}</b> active voluntary work.</p></center><br>";

						// Output the results in a table
						// Table header:
						echo '<table class="mb-4" align="center" cellspacing="8" cellpadding="8" width="100%">
							<tr>
								<td align="center"><b>ID </b></td>
								<td align="center"><b>Program Name </b></td>
								<td align="center"><b>Task </b></td>
								<td align="center"><b>Date </b></td>
								<td align="center"><b>Status </b></td>
								<td align="center"><b>Edit Details </b></td>
								<td align="center"><b>Delete </b></td>
							</tr>';

						// Fetch and print all the records:
						while ($row = mysqli_fetch_assoc($result)) {
							echo '<tr>
							<td align="center">' . $row['id'] . '</td>
							<td align="center">' . $row['name'] . '</td>
							<td align="center">' . $row['task'] . '</td>
							<td align="center">' . $row['date'] . '</td>
							<td align="center">' . $row['status'] . '</td>
							<td align="center">
								<div>
									<a style="background-color: #89C4E1;" class="btn btn-secondary" role="button" href="edit_details_voluntary_work_organization.php?id=' . $row['id'] . '"><i class="fas fa-edit"></i></a>
								</div>
							</td>
							<td align="center">
								<div>
									<a style="background-color: #518cbb;" class="btn btn-danger" role="button" href="delete_voluntary_work_organization.php?id=' . $row['id'] . '"><i class="fas fa-trash"></i></a>
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
							echo "<a href='view_voluntary_work_list_organization.php?page=" . ($current_page - 1) . "'>Previous &nbsp</a> ";
						}
						if ($start_range > 1) {
							echo "<a href='view_voluntary_work_list_organization.php?page=1'>1 &nbsp</a> ";
							if ($start_range > 2) {
								echo "... ";
							}
						}
						for ($i = $start_range; $i <= $end_range; $i++) {
							if ($i == $current_page) {
								echo "<b>$i &nbsp</b> ";
							} else {
								echo "<a href='view_voluntary_work_list_organization.php?page=$i'>$i &nbsp</a> ";
							}
						}
						if ($end_range < $total_pages) {
							if ($end_range < $total_pages - 1) {
								echo "... &nbsp";
							}
							echo "<a href='view_voluntary_work_list_organization.php?page=$total_pages'>$total_pages &nbsp</a> ";
						}
						if ($current_page < $total_pages) {
							echo "<a href='view_voluntary_work_list_organization.php?page=" . ($current_page + 1) . "'>Next &nbsp</a> ";
						}
						echo "</div></div>";

						mysqli_free_result($result); // Free memory associated with $r	

					} else { // If no records are found, display alert message.
						echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
              				<lottie-player src="https://assets1.lottiefiles.com/packages/lf20_s0fkqiqh.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px; margin-top:-15px"  loop  autoplay></lottie-player>';
						echo '<p class="error">There are currently no active voluntary work.</p></center>';
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