<?php
// This page is for editing a user record.
$page_title = 'Edit Profile Volunteer';
session_start(); // Start the session.

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
	<?php
		// Check if the form has been submitted:
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			require('../mysqli_connect_fyp.php');

			echo '	
			<div class="container-fluid" style="width: 55rem;"><br>
			<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
			<div class="card-header">
				<img src="images\ep.png" class="p-3 mb-2" height="200" alt="Edit Profile Logo" loading="lazy" style="margin-top: -1px />
			</div>
			<div class="card-body text-start">';
				$fi = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
				$la = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
				$em = mysqli_real_escape_string($dbc, trim($_POST['email']));
				$us = mysqli_real_escape_string($dbc, trim($_POST['username']));
				$ad = mysqli_real_escape_string($dbc, trim($_POST['address']));
				$po = mysqli_real_escape_string($dbc, trim($_POST['postcode']));
				$ci = mysqli_real_escape_string($dbc, trim($_POST['city']));
				$st = mysqli_real_escape_string($dbc, trim($_POST['state']));
				$ic = mysqli_real_escape_string($dbc, trim($_POST['ic_number']));
				$co = mysqli_real_escape_string($dbc, trim($_POST['contact_number']));
				$ex = mysqli_real_escape_string($dbc, trim($_POST['experience']));
				$ba = mysqli_real_escape_string($dbc, trim($_POST['bank_name']));
				$ac = mysqli_real_escape_string($dbc, trim($_POST['account_number']));
				$id = $_GET['id'];

				// Make the query:
				$q = "UPDATE volunteer SET first_name='$fi', last_name='$la', email='$em', username='$us', address='$ad', postcode='$po', city='$ci', state='$st', 
					ic_number='$ic' , contact_number='$co' , experience='$ex' , bank_name='$ba' , account_number='$ac' WHERE id = $id LIMIT 1";
				$r = @mysqli_query($dbc, $q);

				if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
					echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
						<lottie-player src="https://assets7.lottiefiles.com/private_files/lf30_z1sghrbu.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px;"  loop  autoplay></lottie-player>';
					// Print a message:
					echo '</br><p>Your profile has been edited.</p></center></br>';
					echo '<a href="profile_volunteer.php" class="btn btn-danger btn-lg col-sm-2 me-1 mb-3" tabindex="-1" style="background-color: #518cbb;" role="button" aria-disabled="true">DONE</a></center>';
				} else if (mysqli_affected_rows($dbc) == 0) { // No changes on the data
					echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
						<lottie-player src="https://assets3.lottiefiles.com/packages/lf20_CzdM5kDsY2.json"  background="transparent" class="mb-2" speed="1"  style="width: 200px; height: 200px;"  loop  autoplay></lottie-player>';
					// Print a message:
					echo '</br><p>Your profile is <b>NOT</b> being edited.</p></center></br>';
					echo '<a href="profile_volunteer.php" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">DONE</a></center>';
				} else { // If it did not run OK.
					echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
						<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player>';
					echo '<p class="error">Your profile could not be edited due to a system error. We apologize for any inconvenience.</p></center>'; // Public message.
					echo '<p>' . mysqli_error($dbc) . '<center>Query: ' . $q . '</p></center></br>'; // Debugging message.
					echo '<a href="javascript:history.back()" class="btn btn-danger btn-lg col-sm-2 mb-3" style="background-color: #518cbb;" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
				}
			} else {
				//Check if have valid volunteer ID and show the form
				if ((isset($_SESSION['volunteer_id']))) {
					$id = $_SESSION['volunteer_id'];
					edit_profile($id);
				} else {
					$id = 0;
				}
			}

			//Function to edit profile
			function edit_profile($id){
				require('../mysqli_connect_fyp.php');

				// Retrieve the volunteer's information:
				$q = "SELECT volunteer.first_name, volunteer.last_name, volunteer.email, volunteer.username, volunteer.address, volunteer.postcode, volunteer.city, volunteer.state, volunteer.ic_number, volunteer.contact_number, volunteer.experience, volunteer.bank_name, volunteer.account_number FROM volunteer WHERE volunteer.id = $id";

				$r = @mysqli_query($dbc, $q);

				if (mysqli_num_rows($r) == 1) { // Valid volunteer ID, show the form.

					// Get the volunteer's information:
					$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

					// Create the form:
					echo '	
					<div class="container mx-auto" style="width: 55rem;"><br>
						<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
							<div class="card-header">
								<img src="images\ep.png" class="p-3 mb-2" height="200" alt="Edit Profile Logo" loading="lazy" style="margin-top: -1px />
							</div>
							<div class="card-body text-start">
							<form class="px-4 py-2" action="edit_profile_volunteer.php?id=' . $id . '" method="post">
							<fieldset>
								<div class="form-group row mb-2">
									<div class="input-group mb-2">
										<span class="input-group-text w-25" id="basic-addon1">First Name</span>
										<input required oninput="this.value = this.value.toUpperCase()" type="text" class="form-control" name="first_name" size="50" maxlength="50" value="' . $row['first_name'] . '" >
									</div>
									<div class="input-group mb-2">
										<span class="input-group-text w-25" id="basic-addon1">Last Name</span>
										<input required oninput="this.value = this.value.toUpperCase()" type="text" class="form-control" name="last_name" size="50" maxlength="50" value="' . $row['last_name'] . '" >
									</div>
									<div class="input-group mb-2">
										<span class="input-group-text w-25" id="basic-addon1">Email</span>
										<input required type="email" class="form-control" name="email" size="50" maxlength="50" value="' . $row['email'] . '" >
									</div>
									<div class="input-group mb-2">
										<span class="input-group-text w-25" id="basic-addon1">Username</span>
										<input required type="text" class="form-control" name="username" size="20" maxlength="20" value="' . $row['username'] . '" >
									</div>
									<div class="input-group mb-2">
										<span class="input-group-text w-25" id="basic-addon1">IC Number</span>
										<input required type="text" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="form-control" name="ic_number" size="12" maxlength="12" value="' . $row['ic_number'] . '" >
									</div>
									<div class="input-group mb-2">
										<span class="input-group-text w-25" id="basic-addon1">Address</span>
										<input required oninput="this.value = this.value.toUpperCase()" type="text" class="form-control" name="address" size="100" maxlength="100" value="' . $row['address'] . '" >
									</div>
									<div class="input-group mb-2">
										<span class="input-group-text w-25" id="basic-addon1">Postcode</span>
										<input required type="text" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="form-control" name="postcode" size="5" maxlength="5" value="' . $row['postcode'] . '"/>
									</div>
									<div class="input-group mb-2">
										<span class="input-group-text w-25" id="basic-addon1">City/Town</span>
										<input required oninput="this.value = this.value.toUpperCase()" type="text" class="form-control" name="city" size="20" maxlength="20" value="' . $row['city'] . '"/>
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
										<span class="input-group-text w-25" id="basic-addon1">Experience</span>
										<textarea oninput="this.value = this.value.toUpperCase(); autoResize();" required class="form-control" id="experience" name="experience" size="500" maxlength="500">' . $row['experience'] . '</textarea>
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
								<a href="profile_volunteer.php" class="btn btn-danger btn-lg col-sm-2 mt-3" style="background-color: #89C4E1;" tabindex="-1" role="button" aria-disabled="true">CANCEL</a>
							</div>
							</form>
						</div>
					</div>
					<?php

				} else { // Not a valid member ID.
					echo '
					<div class="container-fluid" style="width: 55rem;"><br>
					<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
						<div class="card-header">
						<img src="images\ep.png" class="p-3 mb-2" height="200" alt="Edit Profile Logo" loading="lazy" style="margin-top: -1px />
						</div>
						<div class="card-body text-start">';
						echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
						<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player></br>
						<p class="error">This page has been accessed in error due to <b>invalid volunteer id</b>.</p></br>
						<a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
				}
				mysqli_close($dbc);
			} //END FUNCTION

			echo '</div></div></div></div></div></br>';
			include('includes/footer.php');
	?>