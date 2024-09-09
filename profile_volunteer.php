<?php
// This page is for viewing the details for any particular voluntary work record.
// This page is accessed through view_voluntary_work_list_institution.php.
$page_title = 'View Profile Volunteer';
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

	<style>
	.container-fluid {
      position: relative;
      padding: 0;
    }

	body {
      overflow-x: hidden;
    }
</style>
</header>
<!--Main Navigation-->

<!--Main layout-->
			<div>
				<?php
				// Always show the form...
				//Check if have valid volunteer ID
				if ((isset($_SESSION['volunteer_id']))) {
					$id = $_SESSION['volunteer_id'];
					view_profile($id);
				} else {
					$id = 0;
				}

				//FUNCTION to view profile of an volunteer
				function view_profile($id)
				{
					require('../mysqli_connect_fyp.php');

					// Retrieve the volunteer's information:
					$q = "SELECT * FROM volunteer WHERE volunteer.id = $id";

					$r = @mysqli_query($dbc, $q);
					if (mysqli_num_rows($r) == 1) { // Valid volunteer ID, show the form.

						// Get the volunteer's information:
						$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

						// Create the form:
						echo '
						<div class="container-fluid" style="width: 55rem;"><br>
							<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
								<div class="card-header">
									<img src="images/p.png" class="p-3 mb-2" height="200" alt="Profile Logo" loading="lazy" style="margin-top: -1px />
								</div>
								<div class="card-body text-start">
									<form class="row g-3 px-4 py-2" action="profile_volunteer.php?id=' . $id . '" method="post">
										<fieldset>
											<div class="form-group row mb-2">
												<div class="input-group mb-2">
													<span class="input-group-text w-25" id="basic-addon1">First Name</span>
													<input required oninput="this.value = this.value.toUpperCase()" type="text" class="form-control" name="first_name" size="50" maxlength="50" value="' . $row['first_name'] . '"/ disabled>
												</div>
												<div class="input-group mb-2">
													<span class="input-group-text w-25" id="basic-addon1">Last Name</span>
													<input required oninput="this.value = this.value.toUpperCase()" type="text" class="form-control" name="last_name" size="50" maxlength="50" value="' . $row['last_name'] . '"/ disabled>
												</div>
												<div class="input-group mb-2">
													<span class="input-group-text w-25" id="basic-addon1">Email</span>
													<input type="text" class="form-control" name="email" size="50" maxlength="50" value="' . $row['email'] . '"/ disabled>
												</div>
												<div class="input-group mb-2">
													<span class="input-group-text w-25" id="basic-addon1">Username</span>
													<input type="text" class="form-control" name="username" size="50" maxlength="50" value="' . $row['username'] . '"/ disabled>
												</div>
												<div class="input-group mb-2">
													<span class="input-group-text w-25" id="basic-addon1">IC Number</span>
													<input required type="text" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="form-control" name="ic_number" size="12" maxlength="12" value="' . $row['ic_number'] . '"/ disabled>
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
													<span class="input-group-text w-25" id="basic-addon1">Experience</span>
													<textarea oninput="this.value = this.value.toUpperCase(); autoResize();" required class="form-control" id="experience" name="experience" size="500" maxlength="500" disabled>' . $row['experience'] . '</textarea>
													</div>
												<div class="input-group mb-2">
													<span class="input-group-text w-25" id="basic-addon1">Bank Name</span>
													<input required type="text" class="form-control" name="bank_name" size="100" maxlength="100" value="' . $row['bank_name'] . '"/ disabled>
												</div>
												<div class="input-group mb-2">
													<span class="input-group-text w-25" id="basic-addon1">Account Number</span>
													<input required type="text" class="form-control" name="account_number" size="20" maxlength="20" value="' . $row['account_number'] . '"/ disabled>
												</div>
											</div>'; ?>
										</fieldset>
											<div align="right">
												<a href="edit_profile_volunteer.php" style="background-color: #518cbb;" class="btn btn-danger btn-lg col-sm-2 me-3" tabindex="-1" role="button" aria-disabled="true">EDIT</a>
												<a href="index.php" style="background-color: #89C4E1;" class="btn btn-danger btn-lg col-sm-2" tabindex="-1" role="button" aria-disabled="true">BACK</a>
											</div>
									</form>
								</div>
								
					<?php
					} else { // Not a valid volunteer ID.
						echo '
						<div class="container-fluid mx-auto" style="width: 55rem;">
							<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
								<div class="card-header">
									<img src="images/p.png" class="p-3 mb-2" height="200" alt="Profile Logo" loading="lazy" style="margin-top: -1px />
								</div>
								<div class="card-body text-start">';
									echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
									<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player></br>
									<p class="error">This page has been accessed in error due to <b>invalid volunteer id</b>.</p></br>
									<a href="javascript:history.back()" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>
								</div>';
					}
							mysqli_close($dbc);
							echo' 
							</div>
						</div>
					</div>';
				} //END FUNCTION

				echo '</br>';
				include('includes/footer.php');
?>