<?php
// This page is for viewing the profile of the admin.
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
				// Always show the form...
				//Check if have valid admin ID
				if ((isset($_SESSION['admin_id']))) {
					$id = $_SESSION['admin_id'];
					view_profile($id);
				} else {
					$id = 0;
				}

				//FUNCTION to view profile of an admin
				function view_profile($id){

					require('../mysqli_connect_fyp.php');

					// Retrieve the admin's information:
					$q = "SELECT * FROM admin WHERE admin.id = $id";

					$r = @mysqli_query($dbc, $q);
					if (mysqli_num_rows($r) == 1) { // Valid admin ID, show the form.

						// Get the admin's information:
						$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

						// Create the form:
						echo '	
						<div class="container mx-auto" style="width: 55rem;">
							<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
								<div class="card-header">
									<img src="images/p.png" class="p-3 mb-2" height="200" alt="Profile Logo" loading="lazy" style="margin-top: -1px />
								</div>
								<div class="card-body text-start">
									<form class="row g-3 px-4 py-2" action="profile_admin.php?id=' . $id . '" method="post">
										<fieldset>
											<div class="form-group row mb-2">
												<div class="input-group mb-2">
													<span class="input-group-text w-25" id="basic-addon1">Username</span>
													<input type="text" class="form-control" name="username" size="50" maxlength="50" value="' . $row['username'] . '"/ disabled>
												</div>
												<div class="input-group mb-2">
													<span class="input-group-text w-25" id="basic-addon1">Email</span>
													<input type="text" class="form-control" name="email" size="50" maxlength="50" value="' . $row['email'] . '"/ disabled>
												</div>
											</div>';
											?>
										</fieldset>
											<div align="right">
												<a href="edit_profile_admin.php" style="background-color: #518cbb;" class="btn btn-danger btn-lg col-sm-2 me-3" tabindex="-1" role="button" aria-disabled="true">EDIT</a>
												<a href="view_list_institution.php" style="background-color: #89C4E1;" class="btn btn-danger btn-lg col-sm-2" tabindex="-1" role="button" aria-disabled="true">BACK</a>
											</div>
									</form>
						<?php
					} else { // Not a valid admin ID.
						echo '
						<div class="container mx-auto" style="width: 55rem;">
							<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
								<div class="card-header">
									<img src="images/p.png" class="p-3 mb-2" height="200" alt="Profile Logo" loading="lazy" style="margin-top: -1px />
								</div>
								<div class="card-body text-start">';
									echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
										<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player></br>';
									echo '<p class="error">This page has been accessed in error due to <b>invalid admin id</b>.</p></br>
									<a href="javascript:history.back()" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
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