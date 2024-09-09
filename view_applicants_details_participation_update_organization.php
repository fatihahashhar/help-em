<?php
$page_title = 'Manage volunteer application';
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
	<div class="container pt-4">
		<!-- Section: Main chart -->
		<section class="mb-4">
			<div>
				<?php
				// This script retrieves all the records from the volunteer table.
				// This new version links to view and delete pages.

				// Always show the form...
				//Check if have valid volunteer ID
				if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
					$id = $_GET['id'];
					showForm($id);
				} else if ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
					$id = $_POST['id'];
					showForm($id);
				} else {
					$id = 0;
				}

				//FUNCTION
				function showForm($id)
				{
					require('../mysqli_connect_fyp.php');

					// Retrieve the volunteer's information:
					$q = "SELECT volunteer.id, volunteer.first_name, volunteer.last_name, volunteer.email, volunteer.username, volunteer.address, volunteer.postcode, volunteer.city, volunteer.state, 
						volunteer.ic_number, volunteer.contact_number, volunteer.experience, volunteer.bank_name, volunteer.account_number FROM volunteer WHERE volunteer.id = $id";

					$r = @mysqli_query($dbc, $q);

					if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

						// Get the user's information:
						$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

						// Create the form:
						echo '
							<div class="container mx-auto" style="width: 60rem;">
								<div class="row py-3">
									<div class="col-md-4">
										<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 60rem;" >
											<div class="card-header">
												<img src="images/ad.png" class="p-3 my-2" height="200" alt="Applicants Details Logo" loading="lazy" style="margin-top: -1px />
											</div>
											<div class="card-body text-start">
											<div class="card-body">
												<form class="row g-3 px-2" action="view_applicants_details_pending_organization.php?id=' . $id . '" method="post">
													<fieldset>';
													echo '
														<div class="form-group px-2 row mb-2 text-start">
														
															<div style="background-color: #6096B4;" class="card border rounded-4 shadow p-3 text-dark bg-opacity-100 w-100">
															<div style="margin-bottom: 20px;"> <strong><span style="background-color: #BDCDD6; padding: 5px;"><i class="fa-solid fa-user"></i></span>&nbsp USERNAME: </strong>' . $row['username'] . '</div>
															<div style="margin-bottom: 20px;"> <strong><span style="background-color: #BDCDD6; padding: 5px;"><i class="fa-solid fa-id-badge"></i></span>&nbsp FIRST NAME: </strong>' . $row['first_name'] . '
															<strong style="margin-left: 20px;"><span style="background-color: #BDCDD6; padding: 5px;"><i class="fa-solid fa-id-badge"></i></span>&nbsp LAST NAME: </strong>' . $row['last_name'] . '</div>
															<div style="margin-bottom: 20px;"> <strong><span style="background-color: #BDCDD6; padding: 5px;"><i class="fa-solid fa-id-card"></i></span>&nbsp IC NUMBER: </strong>' . $row['ic_number'] . '</div>
															<div style="margin-bottom: 20px;"> <strong><span style="background-color: #BDCDD6; padding: 5px;"><i class="fa-solid fa-at"></i></span>&nbsp EMAIL: </strong>'. $row['email'] . '</div>
															<div style="margin-bottom: 20px;"> <strong><span style="background-color: #BDCDD6; padding: 5px;"><i class="fa-solid fa-phone"></i></span>&nbsp CONTACT NUMBER: </strong>' . $row['contact_number'] . '</div>
															<div><strong><span style="background-color: #BDCDD6; padding: 5px;"><i class="fa-solid fa-map-location-dot"></i></span>&nbsp ADDRESS: </strong>' . $row['address'] . ', ' . $row['postcode'] . ', ' . $row['city'] . ', ' . $row['state'] . '</div>
															</div>

															<div style="background-color: #93BFCF;" class="card border rounded-4 shadow p-3 text-dark bg-opacity-100 w-100">
															<strong><span style="background-color: #BDCDD6; padding: 5px;"><i class="fa-solid fa-circle-info"></i></span>&nbsp EXPERIENCE: </strong>' . nl2br(htmlspecialchars($row['experience'])) . '
															
															</div>

															<div style="background-color: #93BFCF;" class="card border rounded-4 shadow p-3 text-dark bg-opacity-100 w-100">
															<div style="margin-bottom: 20px;"> <strong><span style="background-color: #BDCDD6; padding: 5px;"><i class="fa-solid fa-building-columns"></i></span>&nbsp BANK NAME: </strong>' . $row['bank_name'] . '</div>
															<div><strong><span style="background-color: #BDCDD6; padding: 5px;"><i class="fa-solid fa-credit-card"></i></span>&nbsp ACCOUNT NUMBER: </strong>' . $row['account_number'] . '</div>
															</div>

														</div>';
													?>
													</fieldset>
													<?php
													echo' <div align="right" style="padding-right: -15px;">
														<a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-danger btn-lg col-sm-2 mt-3" tabindex="-1" role="button" aria-disabled="true">BACK</a>
													</div>';
													?>
												</form>
				<?php
					} else { // Not a valid volunteer ID.
						echo '
						<div class="container mx-auto" style="width: 55rem;">
							<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
							<div class="card-header">
								<img src="images/ad.png" class="p-3 my-2" height="200" alt="Applicants Details Logo" loading="lazy" style="margin-top: -1px />
							</div>
							<div class="card-body text-start">';
							echo '
								<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
								<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player></br>
								<p class="error">This page has been accessed in error due to <b>invalid volunteer id</b>.</p></br>
								<a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-danger btn-lg mb-4" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
					}

					mysqli_close($dbc);
				} //END FUNCTION

				echo ' </div></div></div></div></div></div></div></div>';
				include('includes/footer.php');
				?>
			</div>
		</section>
		<!-- Section: Main chart -->
	</div>
</main>
<!--Main layout-->