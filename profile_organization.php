<?php
// This page is for viewing the profile of the organization.
$page_title = 'View Profile Organization';
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

				// Always show the form...
				//Check if have valid organization ID
				if ((isset($_SESSION['organization_id']))) {
					$id = $_SESSION['organization_id'];
					view_profile($id);
				} else {
					$id = 0;
				}

				//FUNCTION to view profile of an organization
				function view_profile($id)
				{
					require('../mysqli_connect_fyp.php');

					// Retrieve the organization's information:
					$q = "SELECT * FROM organization WHERE organization.id = $id";

					$r = @mysqli_query($dbc, $q);
					if (mysqli_num_rows($r) == 1) { // Valid organization ID, show the form.

						// Get the organization's information:
						$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

						// Create the form:
						echo '	<div class="container mx-auto" style="width: 55rem;">
		<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
		<div class="card-header">
			<img src="images/p.png" class="p-3 mb-2" height="200" alt="Profile Logo" loading="lazy" style="margin-top: -1px />
		</div>
<div class="card-body text-start">
	<form class="row g-3 px-4 py-2" action="profile_organization.php?id=' . $id . '" method="post">
	<fieldset>';
						echo '
<div class="form-group row mb-2">
  	<div class="input-group mb-2">
		<span class="input-group-text w-25" id="basic-addon1">Name</span>
		<input required oninput="this.value = this.value.toUpperCase()" type="text" class="form-control" name="name" size="100" maxlength="100" value="' . $row['name'] . '"/ disabled>
	</div>
	<div class="input-group mb-2">
		<span class="input-group-text w-25" id="basic-addon1">Email</span>
		<input required type="text" class="form-control" name="email" size="50" maxlength="50" value="' . $row['email'] . '"/ disabled>
	</div>
	<div class="input-group mb-2">
		<span class="input-group-text w-25" id="basic-addon1">Address</span>
		<input required oninput="this.value = this.value.toUpperCase()" type="text" class="form-control" name="address" size="100" maxlength="100" value="' . $row['address'] . '"/ disabled>
	</div>
	<div class="input-group mb-2">
		<span class="input-group-text w-25" id="basic-addon1">Postcode</span>
		<input required type="text" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="form-control" name="postcode" size="5" maxlength="5" value="' . $row['postcode'] . '"/ disabled>
	</div>
	<div class="input-group mb-2">
		<span class="input-group-text w-25" id="basic-addon1">City/Town</span>
		<input required oninput="this.value = this.value.toUpperCase()" type="text" class="form-control" name="city" size="20" maxlength="20" value="' . $row['city'] . '"/ disabled>
	</div>

	<div class="input-group mb-2">
			<span class="input-group-text w-25" id="basic-addon1">State</span>
			<div class="col-md-3">
				<select id="inputState" name="state" class="form-select" required disabled>
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
		<input required type="text" class="form-control" name="contact_number" size="11" maxlength="11" value="' . $row['contact_number'] . '"/ disabled>
	</div>
	<div class="input-group mb-2">
		<span class="input-group-text w-25" id="basic-addon1">Focus Area</span>
		<input required type="text" oninput="this.value = this.value.toUpperCase()" class="form-control" name="focus_area" size="20" maxlength="20" value="' . $row['focus_area'] . '"/ disabled>
	</div>
	<div class="input-group mb-2">
		<span class="input-group-text w-25" id="basic-addon1">Bank Name</span>
		<input required type="text" class="form-control" name="bank_name" size="100" maxlength="100" value="' . $row['bank_name'] . '"/ disabled>
	</div>
	<div class="input-group mb-2">
		<span class="input-group-text w-25" id="basic-addon1">Account Number</span>
		<input required type="text" class="form-control" name="account_number" size="20" maxlength="20" value="' . $row['account_number'] . '"/ disabled>
	</div>
</div>';
				?>
						</fieldset>
						<div align="right">
							<a href="edit_profile_organization.php" style="background-color: #518cbb;" class="btn btn-danger btn-lg col-sm-2 me-3" tabindex="-1" role="button" aria-disabled="true">EDIT</a>
							<a href="view_voluntary_work_list_organization.php" style="background-color: #89C4E1;" class="btn btn-danger btn-lg col-sm-2" tabindex="-1" role="button" aria-disabled="true">BACK</a>
						</div>
			</div>
	</div>
	</form>
<?php
					} else { // Not a valid organization ID.
						echo '<div class="container mx-auto" style="width: 55rem;">
<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
<div class="card-header">
	<img src="images/p.png" class="p-3 mb-2" height="200" alt="Profile Logo" loading="lazy" style="margin-top: -1px />
</div>
<div class="card-body text-start">';
						echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
		<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player></br>';
						echo '<p class="error">This page has been accessed in error due to <b>invalid organization id</b>.</p>
	</br>
	<a href="javascript:history.back()" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
					}

					mysqli_close($dbc);
				} //END FUNCTION

				echo '</div></div></div></div>';
				include('includes/footer.php');
?>
</div>
</section>
<!-- Section: Main chart -->
</div>
</main>
<!--Main layout-->