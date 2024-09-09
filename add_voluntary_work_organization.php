<?php
$page_title = 'Add Voluntary Work';
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
				// This script performs an INSERT query to add a record to the voluntary_work_organization table.

				// Check for form submission:
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$na = trim($_POST['name']);
					$ta = trim($_POST['task']);
					$de = trim($_POST['description']);
					$da = trim($_POST['date']);
					$ti = trim($_POST['start_time']);
					$en = trim($_POST['end_time']);
					$ce = trim($_POST['certification']);
					$me = trim($_POST['meals']);
					$tr = trim($_POST['transportation']);
					$al = trim($_POST['allowance']);
					$st = trim($_POST['status']);

					// Validate image file
					if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
						echo '	
						<div class="container mx-auto" style="width: 55rem;">
							<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
								<div class="card-header">
									<img src="images/advw.png" class="p-3 mb-2" height="200" alt="Add Voluntary Work Logo" loading="lazy" style="margin-top: -1px />
								</div>
								<div class="card-body text-start">';
									$image_size = $_FILES["image"]["size"];
									$image_type = $_FILES["image"]["type"];
									$image_tmp_name = $_FILES["image"]["tmp_name"];

									// Check file size (maximum 16MB)
									if ($image_size > 16777216) {
										echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
											<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json" class="mb-3" background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player>';
										echo "Image size must not exceed 16MB";
										echo '</br><a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-primary btn-lg mt-5 mb-3" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
										echo '</div></div></div></div></div>';
										include('includes/footer.php');
										exit();
									}

									// Check file type
									else if ($image_type != "image/jpeg" && $image_type != "image/png") {
										echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
											<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json" class="mb-3" background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player>';
										echo "Only JPEG and PNG images are allowed";
										echo '</br><a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-primary btn-lg mt-5 mb-3" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
										echo '</div></div></div></div></div>';
										include('includes/footer.php');
										exit();
									} 
									
									else {

										// Register the reservation in the database...
										require('../mysqli_connect_fyp.php'); // Connect to the db.
										$image = mysqli_real_escape_string($dbc, file_get_contents($image_tmp_name));
									}
					}

					// Make the query:
					$q = (isset($_SESSION['organization_id']));
					$r = $_SESSION['organization_id']; // Run the query.

					$t = "INSERT INTO voluntary_work_organization (name, task, description, date, start_time, end_time, certification, organization_id, meals, transportation, allowance, status, image) VALUES ('$na', '$ta', '$de', '$da', '$ti', '$en', '$ce', '$r', '$me', '$tr', '$al', '$st', '$image')";
					$u = mysqli_query($dbc, $t); // Run the query.

					if ($u) { // If it ran OK
						// Print a message:
						echo '	
							<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
							<lottie-player src="https://assets7.lottiefiles.com/private_files/lf30_z1sghrbu.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px;"  loop  autoplay></lottie-player>';
						echo '</br><h2>Thank you!</h2>
							<p>You have successfully added one voluntary work</p>';
						echo '<a href="view_voluntary_work_list_organization.php" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3 mt-3" tabindex="-1" role="button" aria-disabled="true">DONE</a></center>
						</div></div></div>';
					} else { // If it did not run OK.
						echo '<div class="container mx-auto" style="width: 55rem;">';
						echo '<div class="card text-center bg-light p-4 text-dark bg-opacity-100" style="width: 55rem;" >
							<div class="card-header">
								<img src="images/advw.png" class="p-3 mb-2" height="200" alt="Add Voluntary Work Logo" loading="lazy" style="margin-top: -1px />
							</div>
						
							<div class="card-body">';
										// Public message:
										echo '<center><h1>System Error</h1>
							<p class="error">Your action cannot be processed due to a system error. We apologize for any inconvenience.</p>';

						// Debugging message:
						echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $t . ' ----- ' . $u . '</p>';
						echo '<a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
					} // End of if ($r) IF.

					mysqli_close($dbc); // Close the database connection.

					// Include the footer and quit the script:
					echo '</div></div></div>';
					include('includes/footer.php');
					exit();
				} else { // End of the main Submit conditional.
					echo '
					<div class="container mx-auto" style="width: 55rem;">
						<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
							<div class="card-header">
								<img src="images/advw.png" class="p-3 mb-2" height="200" alt="Add Voluntary Work Logo" loading="lazy" style="margin-top: -1px />
							</div>
							<div class="card-body text-start">
								<form class="row g-3 px-4 py-2 needs-validation" action="add_voluntary_work_organization.php" method="post" enctype="multipart/form-data">
									<fieldset>';
									echo '
									<div class="form-group row mb-3">
										<div class="col-sm-6">
											<input required oninput="this.value = this.value.toUpperCase()" type="text" class="form-control" placeholder="Voluntary Work Name" aria-label="Voluntary Work Name" id="inputVoluntaryWorkName" name="name" size="100" maxlength="100" value="';
												if (isset($_POST['name'])) echo $_POST['name'];
												echo '"/>
										</div>
										<div class="col-sm-6">
											<input required oninput="this.value = this.value.toUpperCase()" type="text" class="form-control" placeholder="Task or Role" aria-label="Task" id="inputTask" name="task" size="150" maxlength="150" value="';
												if (isset($_POST['task'])) echo $_POST['task'];
												echo '"/>
										</div>
									</div>
									<div class="form-group row mb-3">
										<div class="form-group col-l">
											<textarea required oninput="this.value = this.value.toUpperCase()" class="form-control" placeholder="Description of the Task, Instruction, or any related Information" aria-label="Voluntary Work Description" id="inputVoluntaryWorkDescription" rows="5" name="description" size="500" maxlength="500" value=""></textarea>';
												if (isset($_POST['description'])) echo $_POST['description'];
												echo '
										</div>
									</div>
									<div class="form-group row mb-3">
										<div class="col-sm-6">
											<div class="input-group mb-1">
												<span class="input-group-text" style="background-color: #EEEEEE;" id="basic-addon1">Certification</span>
													<select id="inputCertification" name="certification" class="form-select" required>
													<option value="">Select</option>';
																	$arr_certification = array("PROVIDED", "NOT PROVIDED");
																	foreach ($arr_certification as $value) {
																		if (isset($_REQUEST["certification"]) && $_REQUEST["certification"] == $value) { // creating sticky
																			echo "<option value=\"$value\" selected>$value</option>";
																		} else {
																			echo "<option value=\"$value\">$value</option>";
																		}
																	}
																	echo '</select>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="input-group mb-1">
												<span class="input-group-text" style="background-color: #EEEEEE;" id="basic-addon1">Meals</span>
													<select id="inputMeals" name="meals" class="form-select" required>
													<option value="">Select</option>';
																	$arr_meals = array("PROVIDED", "NOT PROVIDED");
																	foreach ($arr_meals as $value) {
																		if (isset($_REQUEST["meals"]) && $_REQUEST["meals"] == $value) { // creating sticky
																			echo "<option value=\"$value\" selected>$value</option>";
																		} else {
																			echo "<option value=\"$value\">$value</option>";
																		}
																	}
																	echo '</select>
											</div>
										</div>
									</div>
									<div class="form-group row mb-3">
										<div class="col-sm-6">
											<div class="input-group mb-1">
												<span class="input-group-text" style="background-color: #EEEEEE;" id="basic-addon1">Transportation</span>
													<select id="inputTransportation" name="transportation" class="form-select" required>
													<option value="">Select</option>';
																	$arr_transportation = array("PROVIDED", "NOT PROVIDED");
																	foreach ($arr_transportation as $value) {
																		if (isset($_REQUEST["transportation"]) && $_REQUEST["transportation"] == $value) { // creating sticky
																			echo "<option value=\"$value\" selected>$value</option>";
																		} else {
																			echo "<option value=\"$value\">$value</option>";
																		}
																	}
																	echo '</select>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="input-group mb-1">
												<span class="input-group-text" style="background-color: #EEEEEE;" id="basic-addon1">Allowance</span>
													<select id="inputAllowance" name="allowance" class="form-select" required>
													<option value="">Select</option>';
																	$arr_allowance = array("PROVIDED", "NOT PROVIDED");
																	foreach ($arr_allowance as $value) {
																		if (isset($_REQUEST["allowance"]) && $_REQUEST["allowance"] == $value) { // creating sticky
																			echo "<option value=\"$value\" selected>$value</option>";
																		} else {
																			echo "<option value=\"$value\">$value</option>";
																		}
																	}
																	echo '</select>
											</div>
										</div>
									</div>
									<div class="form-group row mb-3">
										<div class="col-sm-4">
											<div class="input-group mb-1">
												<span class="input-group-text" style="background-color: #EEEEEE;" id="basic-addon1">Date</span>
													<input required type="date" class="form-control" placeholder="Date" aria-label="Date" id="inputDate" name="date" size="8" maxlength="8" value="';
																	if (isset($_POST['date'])) echo $_POST['date'];
																	echo '"/>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="input-group mb-1">
												<span class="input-group-text" style="background-color: #EEEEEE;" id="basic-addon1">Start Time</span>
													<input required type="time" class="form-control" placeholder="Start Time" aria-label="Start Time" id="inputStartTime" name="start_time" size="20" minlength="20" maxlength="20" value="';
																	if (isset($_POST['start_time'])) echo $_POST['start_time'];
																	echo '"/>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="input-group mb-1">
												<span class="input-group-text" style="background-color: #EEEEEE;" id="basic-addon1">End Time</span>
													<input required type="time" class="form-control" placeholder="End Time" aria-label="End Time" id="inputEndTime" name="end_time" size="20" minlength="20" maxlength="20" value="';
																	if (isset($_POST['end_time'])) echo $_POST['end_time'];
																	echo '"/>
											</div>
										</div>
									</div>
									<div class="form-group row mb-3">
										<div class="col-sm-5">
											<select id="inputStatus" name="status" class="form-select" required>
											<option value="">Voluntary Work Status</option>';
															$arr_status = array("COMING SOON", "OPEN FOR REGISTRATION", "IN REVIEW");
															foreach ($arr_status as $value) {
																if (isset($_REQUEST["status"]) && $_REQUEST["status"] == $value) { // creating sticky
																	echo "<option value=\"$value\" selected>$value</option>";
																} else {
																	echo "<option value=\"$value\">$value</option>";
																}
															}
															echo '</select>
										</div>
										<div class="col-sm-7">
											<span class="input-group-text" style="background-color: #EEEEEE;" id="basic-addon1">Upload Poster (Recommended size: 11"x17", 18"x24")</span>
											<input type="file" class="form-control" id="inputImage" name="image">
										</div>
									</div>';
									?>
									</fieldset>
										<div align="right"><input style="background-color: #518cbb;" class="btn btn-primary btn-lg col-sm-3 mt-3" type="submit" name="submit" value=" Submit " />
										</div>
								</form>
							</div>
						</div>
					</div></div></div>
					<?php 			
				}
				include('includes/footer.php');
				?>
			</div>
		</section>
		<!-- Section: Main chart -->
	</div>
</main>
<!--Main layout-->