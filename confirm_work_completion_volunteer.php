<?php
$page_title = 'Work Completion Confirmation';
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
<div class="container-fluid">
	<?php
	// Check for a valid ID, through GET or POST:
	echo '	
		<div class="container-fluid" style="width: 55rem;">
		<div class="row py-3">
		<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
			<div class="card-header">
				<img src="images\cc.png" class="p-3 mb-2" height="200" alt="Completion Confirmation Logo" loading="lazy" style="margin-top: -1px />
			</div>
			<div class="card-body text-start">';
				if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) { // From view_applications_volunteer.php
					$id = $_GET['id'];
				} else if ((isset($_POST['id'])) && (is_numeric($_POST['id']))) { // Form submission.
					$id = $_POST['id'];
				} else { // No valid ID, kill the script.
					$id = 0;
				}

				require('../mysqli_connect_fyp.php');

				// Check if the form has been submitted:
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					if ($_POST['sure'] == 'Yes') { // Approve the application.

						// Make the query:
						$q = "UPDATE application SET application.status='DONE' WHERE application.id = $id LIMIT 1";

						$r = @mysqli_query($dbc, $q);

						if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

							// Print a message:
							echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
								<lottie-player src="https://assets7.lottiefiles.com/private_files/lf30_z1sghrbu.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px; margin-top:-30px;"  loop  autoplay></lottie-player>';
							echo '</br><p>Congratulations ! <i class="fa-solid fa-hands-clapping ms-2"></i> <br>
							You have <b>completed</b> a work.</p></br>';
							echo '<a href="view_work_progress_volunteer.php" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">DONE</a></center>';
						} else { // If the query did not run OK.
							echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
								<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px; margin-top:-30px;"  loop  autoplay></lottie-player></br>
								<p class="error">The work status could not be updated due to a system error.</p>'; // Public message.
							echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
							echo '<a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
						}

					} else { // No confirmation of deletion.
						echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
							<lottie-player src="https://assets3.lottiefiles.com/packages/lf20_CzdM5kDsY2.json"  background="transparent" class="mb-2" speed="1"  style="width: 200px; height: 200px; margin-top:-30px;"  loop  autoplay></lottie-player>
							</br><p>You have <b>NOT</b> completed the work yet.</p></br>';
						echo '<a href="view_work_progress_volunteer.php" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">DONE</a></center>';
					}

				} else { // Show the form.

				// Retrieve the reservation's information:
				$q = "SELECT application_id, status, volunteer_id, organizer_name, voluntary_work_name, voluntary_work_id
				FROM
				(
					SELECT application.id AS application_id, application.status, application.volunteer_id, organization.name AS organizer_name, voluntary_work_organization.name AS voluntary_work_name, voluntary_work_organization.id AS voluntary_work_id
					FROM application 
						LEFT JOIN voluntary_work_institution ON application.voluntary_work_institution_id = voluntary_work_institution.id
						LEFT JOIN voluntary_work_organization ON application.voluntary_work_organization_id = voluntary_work_organization.id
						LEFT JOIN organization ON voluntary_work_organization.organization_id = organization.id
						LEFT JOIN volunteer ON application.volunteer_id = volunteer.id WHERE application.id = $id
					
					UNION ALL
					
					SELECT application.id AS application_id, application.status, application.volunteer_id, institution.name AS organizer_name, voluntary_work_institution.name AS voluntary_work_name, voluntary_work_institution.id AS voluntary_work_id
					FROM application 
						LEFT JOIN voluntary_work_institution ON application.voluntary_work_institution_id = voluntary_work_institution.id
						LEFT JOIN voluntary_work_organization ON application.voluntary_work_organization_id = voluntary_work_organization.id
						LEFT JOIN institution ON voluntary_work_institution.institution_id = institution.id
						LEFT JOIN volunteer ON application.volunteer_id = volunteer.id WHERE application.id = $id
				) 
				AS SUBQUERY
				WHERE organizer_name IS NOT NULL AND application_id = $id";

				$r = @mysqli_query($dbc, $q);

				if (mysqli_num_rows($r) == 1) { // Valid ID, show the form.
					
					// Get the reservation's information:
					$row = mysqli_fetch_array($r, MYSQLI_NUM);

					echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
					<lottie-player src="https://assets9.lottiefiles.com/packages/lf20_kfl4ksd9.json"  background="transparent"  speed="1"  style="width: 250px; height: 250px; margin-top:-30px;"    autoplay></lottie-player>';
					
					// Display the record being updated:
					echo "
					<div class='alert alert-info mx-4 my-2' role='alert'>
					Voluntary Work Name: <b>$row[4]</b><br>
					Organizer: <b>$row[3]</b>
					</div>
					<div class='alert alert-danger m-4' role='alert'>
						<b>Please note that this action cannot be undone</b><br>
						Only proceed with the action once you have received your allowance and certificate (if any)!
					</div>
					Confirm that you have <b>COMPLETED</b> this work?";


					// Create the form:
					echo '<form action="confirm_work_completion_volunteer.php" method="post"><br/>
						<input type="radio" name="sure" value="Yes" /> <b>Yes</b> &nbsp &nbsp
						<input type="radio" name="sure" value="No" checked="checked" /> <b>No</b> <br/><br/>
						<div align="center"><input class="btn btn-primary btn-lg mb-3" style="background-color: #518cbb;" type="submit" name="submit" value="Confirm" /> &nbsp&nbsp
						<a href="javascript:history.back()" style="background-color: #89C4E1;" class="btn btn-secondary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">CANCEL</a></div>
						<input type="hidden" name="id" value="' . $id . '" /></center>
						</form>';

					} else { // Not a valid ID.
						echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
							<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px; margin-top:-30px;"  loop  autoplay></lottie-player></br>
							<p class="error">This page has been accessed in error.</p></br>
							<a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
					}

				} // End of the main submission conditional.
			
			mysqli_close($dbc);

			echo ' </div></div></div></div></div>';
		include('includes/footer.php');
		?>