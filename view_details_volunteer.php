<?php
// This page is for viewing the details for any particular volunteer record.
// This page is accessed through view_list_volunteer.php.
$page_title = 'View Volunteer Details';
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
							<div class="container mx-auto" style="width: 70rem;"><br>
								<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 70rem;" >
									<div class="card-header">
										<img src="images\av.png" class="p-3 mb-2" height="200" alt="About Volunteer Logo" loading="lazy" style="margin-top: -1px />
									</div>
							<div class="card-body text-start">
								<form class="row g-3 px-4 py-2" action="view_details_volunteer.php?id=' . $id . '" method="post">
								<fieldset>';
						echo '
							<div class="form-group row mb-2">
								<div class="input-group mb-2">
									<span class="input-group-text w-25" id="basic-addon1">Full Name</span>
									<input type="text" class="form-control" name="name" size="100" maxlength="100" value="' . $row['first_name'] . ' ' . $row['last_name'] . '"/ disabled>
								</div>
								<div class="input-group mb-2">
									<span class="input-group-text w-25" id="basic-addon1">Email</span>
									<input type="text" class="form-control" name="email" size="50" maxlength="50" value="' . $row['email'] . '"/ disabled>
								</div>
								<div class="input-group mb-2">
									<span class="input-group-text w-25" id="basic-addon1">Username</span>
									<input type="text" class="form-control" name="username" size="20" maxlength="20" value="' . $row['username'] . '"/ disabled>
								</div>
								<div class="input-group mb-2">
									<span class="input-group-text w-25" id="basic-addon1">Address</span>
									<input type="text" class="form-control" name="address" size="100" maxlength="100" value="' . $row['address'] . ', ' . $row['postcode'] . ', ' . $row['city'] . ', ' . $row['state'] . '"/ disabled>
								</div>
								<div class="input-group mb-2">
									<span class="input-group-text w-25" id="basic-addon1">IC Number</span>
									<input type="text" class="form-control" name="ic_number" size="50" maxlength="50" value="' . $row['ic_number'] . '"/ disabled>
								</div>
								<div class="input-group mb-2">
									<span class="input-group-text w-25" id="basic-addon1">Contact Number</span>
									<input type="text" class="form-control" name="contact_number" size="10" maxlength="10" value="' . $row['contact_number'] . '"/ disabled>
								</div>
								<div class="input-group mb-2">
									<span class="input-group-text w-25" id="basic-addon1">Experience</span>
									<input type="text" class="form-control" name="experience" size="100" maxlength="100" value="' . $row['experience'] . '"/ disabled>
								</div>
								<div class="input-group mb-2">
									<span class="input-group-text w-25" id="basic-addon1">Bank Name</span>
									<input type="text" class="form-control" name="bank_name" size="100" maxlength="100" value="' . $row['bank_name'] . '"/ disabled>
								</div>
								<div class="input-group mb-2">
									<span class="input-group-text w-25" id="basic-addon1">Account Number</span>
									<input type="text" class="form-control" name="account_number" size="20" maxlength="20" value="' . $row['account_number'] . '"/ disabled>
								</div>
							</div>';
				?>
						</fieldset>
						<div align="right">
							<a href="view_list_volunteer.php" style="background-color: #518cbb;" class="btn btn-danger btn-lg col-sm-2" tabindex="-1" role="button" aria-disabled="true">DONE</a>
						</div>
			</div>
			</form>
	<?php
					} else { // Not a valid volunteer ID.
						echo '<div class="container mx-auto" style="width: 55rem;"><br>
					<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
					<div class="card-header">
						<img src="images\av.png" class="p-3 mb-2" height="200" alt="About Volunteer Logo" loading="lazy" style="margin-top: -1px />
					</div>
					<div class="card-body text-start">';
						echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
							<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player></br>';
						echo '<p class="error">This page has been accessed in error due to <b>invalid volunteer id</b>.</p>
						</br><a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-danger btn-lg" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
					}

					mysqli_close($dbc);
				} //END FUNCTION

				echo ' </div></div></div></div></div></br>';
				include('includes/footer.php');
	?>
	</div>
	</section>
	<!-- Section: Main chart -->
	</div>
</main>
<!--Main layout-->