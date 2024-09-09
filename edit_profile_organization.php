<?php
// This page is for editing a organization record.
$page_title = 'Edit Profile Organization';
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
				// Check if the form has been submitted:
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					require('../mysqli_connect_fyp.php');

					echo '	<div class="container mx-auto" style="width: 55rem;">
				<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
				<div class="card-header">
					<img src="images\ep.png" class="p-3 mb-2" height="200" alt="Edit Profile Logo" loading="lazy" style="margin-top: -1px />
				</div>
		<div class="card-body text-start">';

					$na = mysqli_real_escape_string($dbc, trim($_POST['name']));

					$em = mysqli_real_escape_string($dbc, trim($_POST['email']));

					$ad = mysqli_real_escape_string($dbc, trim($_POST['address']));

					$po = mysqli_real_escape_string($dbc, trim($_POST['postcode']));

					$ci = mysqli_real_escape_string($dbc, trim($_POST['city']));

					$st = mysqli_real_escape_string($dbc, trim($_POST['state']));

					$co = mysqli_real_escape_string($dbc, trim($_POST['contact_number']));

					$fa = mysqli_real_escape_string($dbc, trim($_POST['focus_area']));

					$ba = mysqli_real_escape_string($dbc, trim($_POST['bank_name']));

					$ac = mysqli_real_escape_string($dbc, trim($_POST['account_number']));

					$id = $_GET['id'];

					// Make the query:
					$q = "UPDATE organization SET name='$na', email='$em', address='$ad', postcode='$po', city='$ci', state='$st', 
		contact_number='$co', focus_area='$fa', bank_name='$ba', account_number='$ac' WHERE id = $id LIMIT 1";
					$r = @mysqli_query($dbc, $q);

					if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
						echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
		<lottie-player src="https://assets7.lottiefiles.com/private_files/lf30_z1sghrbu.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px;"  loop  autoplay></lottie-player>';
						// Print a message:
						echo '</br><p>Your profile has been edited.</p></center></br>';
						echo '<a href="profile_organization.php" class="btn btn-danger btn-lg col-sm-2 me-1 mb-3" tabindex="-1" style="background-color: #518cbb;" role="button" aria-disabled="true">DONE</a></center>';
					} else if (mysqli_affected_rows($dbc) == 0) { // No changes on the data
						echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
							<lottie-player src="https://assets3.lottiefiles.com/packages/lf20_CzdM5kDsY2.json"  background="transparent" class="mb-2" speed="1"  style="width: 200px; height: 200px;"  loop  autoplay></lottie-player>';
						// Print a message:
						echo '</br><p>Your profile is <b>NOT</b> being edited.</p></center></br>';
						echo '<a href="profile_organization.php" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">DONE</a></center>';
					} else { // If it did not run OK.
						echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
		<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player>';
						echo '<p class="error">Your profile could not be edited due to a system error. We apologize for any inconvenience.</p></center>'; // Public message.
						echo '<p>' . mysqli_error($dbc) . '<center>Query: ' . $q . '</p></center></br>'; // Debugging message.
						echo '<a href="javascript:history.back()" class="btn btn-danger btn-lg col-sm-2 mb-3" style="background-color: #518cbb;" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
					}
				} else {
					// Always show the form...
					//Check if have valid organization ID
					if ((isset($_SESSION['organization_id']))) {
						$id = $_SESSION['organization_id'];
						edit_profile($id);
					} else {
						$id = 0;
					}
				}

				//Function to edit profile
				function edit_profile($id)
				{

					require('../mysqli_connect_fyp.php');

					// Retrieve the organization's information:
					$q = "SELECT organization.name, organization.email, organization.address, organization.postcode, organization.city, 
	organization.state, organization.contact_number, organization.focus_area, organization.bank_name, 
	organization.account_number FROM organization WHERE organization.id = $id";

					$r = @mysqli_query($dbc, $q);

					if (mysqli_num_rows($r) == 1) { // Valid organization ID, show the form.

						// Get the organization's information:
						$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

						// Create the form:
						echo '	<div class="container mx-auto" style="width: 55rem;">
			<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
			<div class="card-header">
				<img src="images\ep.png" class="p-3 mb-2" height="200" alt="Edit Profile Logo" loading="lazy" style="margin-top: -1px />
			</div>
	<div class="card-body text-start">
			<form class="px-2" action="edit_profile_organization.php?id=' . $id . '" method="post">
			<fieldset>';
						echo '<div class="form-group row mb-2">
		<div class="input-group mb-2">
			<span class="input-group-text w-25" id="basic-addon1">Name</span>
			<input required oninput="this.value = this.value.toUpperCase()" type="text" class="form-control" name="name" size="100" maxlength="100" value="' . $row['name'] . '">
		</div>
		<div class="input-group mb-2">
			<span class="input-group-text w-25" id="basic-addon1">Email</span>
			<input required type="text" class="form-control" name="email" size="50" maxlength="50" value="' . $row['email'] . '">
		</div>
		<div class="input-group mb-2">
			<span class="input-group-text w-25" id="basic-addon1">Address</span>
			<input required oninput="this.value = this.value.toUpperCase()" type="text" class="form-control" name="address" size="100" maxlength="100" value="' . $row['address'] . '">
		</div>
		<div class="input-group mb-2">
			<span class="input-group-text w-25" id="basic-addon1">Postcode</span>
			<input required type="text" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="form-control" name="postcode" size="5" maxlength="5" value="' . $row['postcode'] . '">
		</div>
		<div class="input-group mb-2">
			<span class="input-group-text w-25" id="basic-addon1">City/Town</span>
			<input required oninput="this.value = this.value.toUpperCase()" type="text" class="form-control" name="city" size="20" maxlength="20" value="' . $row['city'] . '">
		</div>

		<div class="input-group mb-2">
				<span class="input-group-text w-25" id="basic-addon1">State</span>
				<div class="col-md-3">
					<select id="inputState" name="state" class="form-select" required>
					<option value="">Select</option>';
						$arr_state = array("JOHOR", "KEDAH", "KELANTAN", "KUALA LUMPUR", "LANGKAWI", "MELAKA", "NEGERI SEMBILAN", "PAHANG", "PENANG", "PERAK", "PERLIS", "PUTRAJAYA", "SELANGOR", "TERENGGANU");
						for ($i = 0; $i < 13; $i++) {
							if ($row['state'] == $arr_state[$i]) {
								$select =  ' selected ';
							} else {
								$select =  '';
							}
							echo '<option ' . $select . ' >';
							echo $arr_state[$i];
							echo '</option>';
						}
						echo '</select>
				</div>
			</div>

		<div class="input-group mb-2">
			<span class="input-group-text w-25" id="basic-addon1">Contact Number</span>
			<input required type="text" class="form-control" name="contact_number" size="11" maxlength="11" value="' . $row['contact_number'] . '">
		</div>
		<div class="input-group mb-2">
			<span class="input-group-text w-25" id="basic-addon1">Focus Area</span>
			<input required type="text" oninput="this.value = this.value.toUpperCase()" class="form-control" name="focus_area" size="20" maxlength="20" value="' . $row['focus_area'] . '">
		</div>
		<div class="input-group mb-2">
			<span class="input-group-text w-25" id="basic-addon1">Bank Name</span>
			<input required type="text" class="form-control" name="bank_name" size="100" maxlength="100" value="' . $row['bank_name'] . '">
		</div>
		<div class="input-group mb-2">
			<span class="input-group-text w-25" id="basic-addon1">Account Number</span>
			<input required type="text" class="form-control" name="account_number" size="20" maxlength="20" value="' . $row['account_number'] . '">
		</div>
		</div>';
				?>
						</fieldset>

						<div align="right"><input class="btn btn-danger btn-lg col-sm-2 mt-3 me-1" tabindex="-1" style="background-color: #518cbb;" aria-disabled="true" type="submit" name="submit" value=" Submit " /> &nbsp&nbsp
							<a href="profile_organization.php" class="btn btn-danger btn-lg col-sm-2 mt-3" style="background-color: #89C4E1;" tabindex="-1" role="button" aria-disabled="true">CANCEL</a>
						</div>
			</div>
			</form>
	<?php
					} else { // Not a valid member ID.
						echo '<div class="container mx-auto" style="width: 55rem;">
<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
<div class="card-header">
	<img src="images\ep.png" class="p-3 mb-2" height="200" alt="Edit Profile Logo" loading="lazy" style="margin-top: -1px />
</div>
<div class="card-body text-start">';
						echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player></br>';
						echo '<p class="error">This page has been accessed in error due to <b>invalid organization id</b>.</p>
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