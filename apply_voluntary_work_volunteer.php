<?php
$page_title = 'Apply for Voluntary Work';
session_start(); // Start the session

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
</header>
<!--Main Navigation-->

<!--Main layout-->
<div>
	<?php
	// This script performs an INSERT query to add a record to the application table.

		// Check for a valid ID, through GET or POST:
		echo '
		<div class="container-fluid" style="width: 50rem;"><br>
		<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 50rem;" >
		<div class="card-header">
			<img src="images/a.png" class="p-3" height="200" alt="Apply Voluntary Work Logo" loading="lazy" style="margin-top: -1px />
		</div>
		<div class="card-body text-start">';

		if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
			$id = $_GET['id'];
			require('../mysqli_connect_fyp.php');
		} else if ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
			$id = $_POST['id'];
			require('../mysqli_connect_fyp.php');
		} else {
			$id = 0;
		}

		// Check if the id exists in voluntary_work_institution table
		$query1 = "SELECT voluntary_work_institution.id FROM voluntary_work_institution WHERE voluntary_work_institution.id = $id";
		$result1 = mysqli_query($dbc, $query1);

		// Check if the id exists in voluntary_work_organization table
		$query2 = "SELECT voluntary_work_organization.id FROM voluntary_work_organization WHERE voluntary_work_organization.id = $id";
		$result2 = mysqli_query($dbc, $query2);

		// Make the query to get the user (volunteer) id
		$t = (isset($_SESSION['volunteer_id']));
		$u = $_SESSION['volunteer_id']; // Run the query.

		// Fuction to show the form to the volunteer
		function showForm($id, $row, $dbc){
			// Show the form.
			$q = "SELECT voluntary_work_institution.name FROM voluntary_work_institution WHERE voluntary_work_institution.id = $id UNION ALL SELECT voluntary_work_organization.name FROM voluntary_work_organization WHERE voluntary_work_organization.id = $id";
			$r = @mysqli_query($dbc, $q);

			if (mysqli_num_rows($r) == 1) { // Valid voluntary work ID, show the form.

				// Get the information:
				$row = mysqli_fetch_array($r, MYSQLI_NUM);

				echo '
				<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
				<lottie-player src="https://assets9.lottiefiles.com/packages/lf20_d97uxr.json"  background="transparent"  speed="1"  style="width: 250px; height: 250px; margin-top: -25px; margin-bottom: -25px;" loop  autoplay></lottie-player>';
				// Display the voluntary work details:
				echo "</br><h5><b>NAME: $row[0]</b></h5>
				Do you want to send the application <b>NOW</b>?";

				// Create the form:
				echo '<form action="apply_voluntary_work_volunteer.php" method="post">
				<br/>
				<input type="radio" name="sure" value="Yes" /> <b>Yes</b> &nbsp &nbsp
				<input type="radio" name="sure" value="No" checked="checked" /> <b>No</b> <br/><br/>
				<div align="center"><input class="btn btn-primary btn-lg col-sm-2 mb-3" style="background-color: #518cbb;" type="submit" name="submit" value="CONFIRM" /> &nbsp&nbsp
				<a href="browse_voluntary_work_volunteer.php" style="background-color: #89C4E1;" class="btn btn-secondary btn-lg col-sm-2 mb-3" tabindex="-1" role="button" aria-disabled="true">CANCEL</a></div>
				<input type="hidden" name="id" value="' . $id . '" /></center>
				</form>';
				} 
				
				else { // Not a valid voluntary work ID.
					echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
				<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player></br>
				<p class="error">This page has been accessed in error.</p>
				</br><a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
								}
		}// End of function

		if (mysqli_num_rows($result1) == 1) { // If the voluntary work is organized by the institution (has valid voluntary_work_institution_id)
			$row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
			
			// Check if the form has been submitted:
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					if ($_POST['sure'] == 'Yes') { // Insert the record.

						// Make the query:
						$q = "INSERT INTO application (volunteer_id, voluntary_work_institution_id, status) VALUES ('$u', '$id', 'PENDING')";
						$r = @mysqli_query($dbc, $q); // Run the query.

						if ($r) { // If it ran OK.
							// Print a message:
							echo '
							<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
							<lottie-player src="https://assets7.lottiefiles.com/private_files/lf30_z1sghrbu.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px;"  loop  autoplay></lottie-player></br>
							<h2>Thank you for applying!</h2>
							<p>Your application will be processed by the organizer soon.</p>';
							echo '<a href="browse_voluntary_work_volunteer.php" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">DONE</a></center>';
						} else { // If the query did not run OK.
							echo '
							<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
							<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player></br>
							<p class="error">Your application cannot be processed due to a system error.</p>'; // Public message.
							echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
							echo '<a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
						}
					} else { // No confirmation of the application.
						echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
							<lottie-player src="https://assets3.lottiefiles.com/packages/lf20_CzdM5kDsY2.json"  background="transparent" class="mb-2" speed="1"  style="width: 200px; height: 200px;"  loop  autoplay></lottie-player>
							</br><p>The application is <b>NOT</b> being processed.</p></br>';
						echo '<a href="browse_voluntary_work_volunteer.php" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">DONE</a>&nbsp&nbsp
						<a href="javascript:history.back()" style="background-color: #89C4E1;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
					} 
				}
	
				else { 
					// Show the form.
					showForm($id, $row, $dbc);
				} // End of the main submission conditional.

		} else if (mysqli_num_rows($result2) == 1) { // If the voluntary work is organized by the organization (has valid voluntary_work_organization_id)
			$row = mysqli_fetch_array($result2, MYSQLI_ASSOC);
			// Check if the form has been submitted:
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					if ($_POST['sure'] == 'Yes') { // Insert the record.
	
						// Make the query:
						$q = "INSERT INTO application (volunteer_id, voluntary_work_organization_id, status) VALUES ('$u', '$id', 'PENDING')";
						$r = @mysqli_query($dbc, $q); // Run the query.
	
						if ($r) { // If it ran OK.
							// Print a message:
							echo '
							<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
							<lottie-player src="https://assets7.lottiefiles.com/private_files/lf30_z1sghrbu.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px;"  loop  autoplay></lottie-player></br>
							<h2>Thank you!</h2>
							<p>Your application will be processed soon.</p>';
							echo '<a href="browse_voluntary_work_volunteer.php" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">DONE</a></center>';
						} else { // If the query did not run OK.
							echo '
							<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
							<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player></br>
							<p class="error">Your application cannot be processed due to a system error.</p>'; // Public message.
							echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
							echo '<a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
						}
					} else { // No confirmation of the application.
						echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
							<lottie-player src="https://assets3.lottiefiles.com/packages/lf20_CzdM5kDsY2.json"  background="transparent" class="mb-2" speed="1"  style="width: 200px; height: 200px;"  loop  autoplay></lottie-player>
							</br><p>The application is <b>NOT</b> being processed.</p></br>';
						echo '<a href="browse_voluntary_work_volunteer.php" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">DONE</a>&nbsp&nbsp
						<a href="javascript:history.back()" style="background-color: #89C4E1;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
					} 
				}
				else { 
					// Show the form.
					showForm($id, $row, $dbc);
				} // End of the main submission conditional.
	
		} else { // Not a valid voluntary work id.
			echo '
			<div class="container mx-auto" style="width: 55rem;">
				<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
					<div class="card-header">
						<img src="images/a.png" class="p-3 mb-2" height="200" alt="About Voluntary Work Logo" loading="lazy" style="margin-top: -1px />
					</div>
					<div class="card-body text-start">';
					echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
							<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player></br>';
					echo '<p class="error">This page has been accessed in error due to <b>invalid voluntary work id</b>.</p>
						</br><a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-danger btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>
					</div>
				</div>
			</div>';
		}	

		mysqli_close($dbc);
										
		echo ' </div></div></div></div></br>';
		include('includes/footer.php');
		?>