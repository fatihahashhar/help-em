<?php
$page_title = 'Reject Volunteer Application';
session_start(); // Start the session

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
	<div class="container pt-4">
		<!-- Section: Main chart -->
		<section class="mb-4">
			<div>
				<?php
				// Check for a valid ID, through GET or POST:
					echo '	
					<div class="container mx-auto" style="width: 50rem;"><br>
						<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 50rem;" >
						<div class="card-header">
							<img src="images/aplrjc.png" class="p-3 mb-2" height="200" alt="Reject Application Logo" loading="lazy" style="margin-top: -1px />
						</div>
						<div class="card-body text-start">';
							if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) { 
								$id = $_GET['id'];
							} else if ((isset($_POST['id'])) && (is_numeric($_POST['id']))) { // Form submission.
								$id = $_POST['id'];
							} else { // No valid ID, kill the script.
								echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
									<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player></br>
								<p class="error">This page has been accessed in error.</p></center>';
								include('includes/footer.php');
								exit();
							}

							require('../mysqli_connect_fyp.php');
			
							// Check if the form has been submitted:
							if ($_SERVER['REQUEST_METHOD'] == 'POST') {
								if ($_POST['sure'] == 'Yes') { // Reject the application.
			
									// Make the query:
									$q = "UPDATE application SET application.status='REJECTED' WHERE application.id = $id LIMIT 1";
			
									$r = @mysqli_query($dbc, $q);
			
									if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
			
										// Print a message:
										echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
											<lottie-player src="https://assets7.lottiefiles.com/private_files/lf30_z1sghrbu.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px;"  loop  autoplay></lottie-player>';
										echo '</br><p>The application has been <b>rejected</b>.</p></br>';
										echo '<a href="view_applications_pending_organization.php" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">DONE</a></center>';
									} else { // If the query did not run OK.
										echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
											<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player></br>
											<p class="error">The application could not be rejected due to a system error.</p>'; // Public message.
										echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
										echo '<a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-primary btn-lg" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
									}

								} else { // No confirmation of deletion.
									echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
										<lottie-player src="https://assets3.lottiefiles.com/packages/lf20_CzdM5kDsY2.json"  background="transparent" class="mb-2" speed="1"  style="width: 200px; height: 200px;"  loop  autoplay></lottie-player>
										</br><p>The application has <b>NOT</b> been rejected.</p></br>';
									echo '<a href="view_applications_pending_organization.php" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">DONE</a></center>';
								}

							} else { // Show the form.

							// Retrieve the reservation's information:
							$q = "SELECT application.id, application.status, application.volunteer_id, volunteer.username 
							FROM application LEFT JOIN volunteer ON application.volunteer_id = volunteer.id WHERE application.id = $id";
							$r = @mysqli_query($dbc, $q);
		
							if (mysqli_num_rows($r) == 1) { // Valid ID, show the form.
								
								// Get the reservation's information:
								$row = mysqli_fetch_array($r, MYSQLI_NUM);
		
								echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
									<lottie-player src="https://assets8.lottiefiles.com/packages/lf20_Tkwjw8.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player>';
								
								// Display the record being rejected:
								echo "</br><h5><b>Application ID: $row[0]</b></h5>
								Are you sure you want to <b>REJECT</b> the application from <b>$row[3]</b>";
		
								// Create the form:
								echo '<form action="reject_volunteer_application_organization.php" method="post"><br/>
									<input type="radio" name="sure" value="Yes" /> <b>Yes</b> &nbsp &nbsp
									<input type="radio" name="sure" value="No" checked="checked" /> <b>No</b> <br/><br/>
									<div align="center"><input class="btn btn-primary btn-lg" style="background-color: #518cbb;" type="submit" name="submit" value="Confirm" /> &nbsp&nbsp
									<a href="javascript:history.back()" style="background-color: #89C4E1;" class="btn btn-secondary btn-lg" tabindex="-1" role="button" aria-disabled="true">CANCEL</a></div>
									<input type="hidden" name="id" value="' . $id . '" /></center>
									</form>';

								} else { // Not a valid ID.
									echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
										<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player></br>
										<p class="error">This page has been accessed in error.</p></br>
										<a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
								}

							} // End of the main submission conditional.
			
							mysqli_close($dbc);
			
							echo ' </div></div></div></div></div></br>';
						include('includes/footer.php');
						?>
					</div>
				</section>
				<!-- Section: Main chart -->
			</div>
		</main>
		<!--Main layout-->