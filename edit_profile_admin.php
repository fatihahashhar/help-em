<?php
// This page is for viewing the details for any particular admin record.
$page_title = 'View Profile Admin';
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
				$page_title = 'View Profile';

				// Check if the form has been submitted:
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					require('../mysqli_connect_fyp.php');

					echo '
					<div class="container mx-auto" style="width: 55rem;"><br>
						<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
							<div class="card-header">
								<img src="images\ep.png" class="p-3 mb-2" height="200" alt="Edit Profile Logo" loading="lazy" style="margin-top: -1px />
							</div>
							<div class="card-body text-start">';

							$un = mysqli_real_escape_string($dbc, trim($_POST['username']));

							$em = mysqli_real_escape_string($dbc, trim($_POST['email']));

							$id = $_GET['id'];

							// Make the query:
							$q = "UPDATE admin SET username='$un', email='$em' WHERE id = $id LIMIT 1";
							$r = @mysqli_query($dbc, $q);

							if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

								echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
									<lottie-player src="https://assets7.lottiefiles.com/private_files/lf30_z1sghrbu.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px;"  loop  autoplay></lottie-player>';
								// Print a message:
								echo '</br><p>Your profile has been edited.</p></center></br>';
								echo '<a href="profile_admin.php" class="btn btn-danger btn-lg col-sm-2 me-1 mb-3" tabindex="-1" style="background-color: #518cbb;" role="button" aria-disabled="true">DONE</a></center>';
							} else if (mysqli_affected_rows($dbc) == 0) { // No changes on the data
								echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
									<lottie-player src="https://assets3.lottiefiles.com/packages/lf20_CzdM5kDsY2.json"  background="transparent" class="mb-2" speed="1"  style="width: 200px; height: 200px;"  loop  autoplay></lottie-player>';
								// Print a message:
								echo '</br><p>Your profile is <b>NOT</b> being edited.</p></center></br>';
								echo '<a href="profile_admin.php" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">DONE</a></center>';
							} else { // If it did not run OK.
								echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
									<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player>';
								echo '<p class="error">Your profile could not be edited due to a system error. We apologize for any inconvenience.</p></center>'; // Public message.
								echo '<p>' . mysqli_error($dbc) . '<center>Query: ' . $q . '</p></center></br>'; // Debugging message.
								echo '<a href="javascript:history.back()" class="btn btn-danger btn-lg col-sm-2 mb-3" style="background-color: #518cbb;" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
							}
				} else {
					// Always show the form...
					//Check if have valid admin ID
					if ((isset($_SESSION['admin_id']))) {
						$id = $_SESSION['admin_id'];
						edit_profile($id);
					} else {
						$id = 0;
					}
				}

				//FUNCTION
				function edit_profile($id){

					require('../mysqli_connect_fyp.php');

					// Retrieve the admin information:
					$q = "SELECT admin.id, admin.username, admin.email FROM admin WHERE admin.id = $id";

					$r = @mysqli_query($dbc, $q);

					if (mysqli_num_rows($r) == 1) { // Valid voluntary work ID, show the form.

						// Get the admin's information:
						$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

						// Create the form:
						echo '
						<div class="container mx-auto" style="width: 55rem;">
							<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
								<div class="card-header">
									<img src="images\ep.png" class="p-3 mb-2" height="200" alt="Edit Profile Logo" loading="lazy" style="margin-top: -1px />
								</div>
								<div class="card-body text-start">
									<form class="row g-3 px-4 py-2" action="edit_profile_admin.php?id=' . $id . '" method="post">
										<fieldset>
											<div class="form-group row mb-2">
												<div class="input-group mb-2">
													<span class="input-group-text w-25" id="basic-addon1">Username</span>
													<input required type="text" class="form-control" name="username" size="50" maxlength="50" value="' . $row['username'] . '" >
												</div>
												<div class="input-group mb-2">
													<span class="input-group-text w-25" id="basic-addon1">Email</span>
													<input required type="email" class="form-control" name="email" size="50" maxlength="50" value="' . $row['email'] . '">
												</div>
											</div>';
											?>
										</fieldset>
											<div align="right">
												<input class="btn btn-danger btn-lg col-sm-2 me-1" tabindex="-1" style="background-color: #518cbb;" aria-disabled="true" type="submit" name="submit" value=" Submit " /> &nbsp&nbsp
												<a href="profile_admin.php" class="btn btn-danger btn-lg col-sm-2" style="background-color: #89C4E1;" tabindex="-1" role="button" aria-disabled="true">CANCEL</a>
											</div>
									</form>
						<?php
					} else { // Not a valid admin ID.
						echo '
						<div class="container mx-auto" style="width: 55rem;">
							<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
								<div class="card-header">
									<img src="images\ep.png" class="p-3 mb-2" height="200" alt="Edit Profile Logo" loading="lazy" style="margin-top: -1px />
								</div>
							</div>
							<div class="card-body text-start">';
							echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
								<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player></br>
								<p class="error">This page has been accessed in error due to <b>invalid admin id</b>.</p>
								</br><a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
					}

					mysqli_close($dbc);
				} //END FUNCTION

				echo '</div></div></div></div></div>';
				include('includes/footer.php');
			?>
		</div>
	</section>
	<!-- Section: Main chart -->
</div>
</main>
<!--Main layout-->