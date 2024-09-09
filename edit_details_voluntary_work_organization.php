<?php
$page_title = 'Edit Voluntary Work Details';
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
				// This page is for editing the details for any particular voluntary work record.
				// This page is accessed through view_voluntary_work_list_institution.php.

				// Check if the form has been submitted:
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					require('../mysqli_connect_fyp.php');

					echo '
					<div class="container mx-auto" style="width: 65rem;"><br>
						<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 65rem;" >
							<div class="card-header">
								<img src="images/evw.png" class="p-3 mb-2" height="200" alt="Edit Voluntary Work Logo" loading="lazy" style="margin-top: -1px />
							</div>
					<div class="card-body text-start">';

					$na = mysqli_real_escape_string($dbc, trim($_POST['name']));

					$ta = mysqli_real_escape_string($dbc, trim($_POST['task']));

					$de = mysqli_real_escape_string($dbc, trim($_POST['description']));

					$da = mysqli_real_escape_string($dbc, trim($_POST['date']));

					$ti = mysqli_real_escape_string($dbc, trim($_POST['start_time']));

					$en = mysqli_real_escape_string($dbc, trim($_POST['end_time']));

					$ce = mysqli_real_escape_string($dbc, trim($_POST['certification']));

					$me = mysqli_real_escape_string($dbc, trim($_POST['meals']));

					$tr = mysqli_real_escape_string($dbc, trim($_POST['transportation']));

					$al = mysqli_real_escape_string($dbc, trim($_POST['allowance']));

					$st = mysqli_real_escape_string($dbc, trim($_POST['status']));

					// Validate image file
					if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
						echo '	<div class="container mx-auto" style="width: 55rem;"><br>
						<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
						<div class="card-header">
							<img src="images/evw.png" class="p-3 mb-2" height="200" alt="Edit Voluntary Work Logo" loading="lazy" style="margin-top: -1px />
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
							echo '</br><a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-primary btn-lg m-3" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
							echo '</div></div></div></div></div></br>';
							include('includes/footer.php');
							exit();
						}

						// Check file type
						else if ($image_type != "image/jpeg" && $image_type != "image/png" && $image_type != "image/gif") {
							echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
								<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json" class="mb-3" background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player>';
							echo "Only JPEG, PNG, and GIF images are allowed";
							echo '</br><a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-primary btn-lg mt-5 mb-3" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
							echo '</div></div></div></div></div></br>';
							include('includes/footer.php');
							exit();
						} else {

							// Register the reservation in the database...
							require('../mysqli_connect_fyp.php'); // Connect to the db.
							$image = mysqli_real_escape_string($dbc, file_get_contents($image_tmp_name));
						}
					}

					$id = $_GET['id'];

					// Make the query:
					$q = "UPDATE voluntary_work_organization SET name='$na', task='$ta', description='$de', date='$da', start_time='$ti', end_time='$en', 
					certification='$ce', meals='$me', transportation='$tr', allowance='$al', status='$st' WHERE id = $id LIMIT 1";
					$r = @mysqli_query($dbc, $q);

					if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

						echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
		<lottie-player src="https://assets7.lottiefiles.com/private_files/lf30_z1sghrbu.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px;"  loop  autoplay></lottie-player>';
						// Print a message:
						echo '</br><p>The voluntary work has been edited.</p></center></br>';
						echo '<a href="view_voluntary_work_list_organization.php" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">DONE</a></center>';
					} else if (mysqli_affected_rows($dbc) == 0) { // No changes on the data
						echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
							<lottie-player src="https://assets3.lottiefiles.com/packages/lf20_CzdM5kDsY2.json"  background="transparent" class="mb-2" speed="1"  style="width: 200px; height: 200px;"  loop  autoplay></lottie-player>';
						// Print a message:
						echo '</br><p>The voluntary work is <b>NOT</b> being edited.</p></center></br>';
						echo '<a href="view_voluntary_work_list_organization.php" style="background-color: #518cbb;" class="btn btn-primary btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">DONE</a></center>';
					} else { // If it did not run OK.
						echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
		<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px;"  loop  autoplay></lottie-player>';
						echo '<p class="error">The voluntary work could not be edited due to a system error. We apologize for any inconvenience.</p></center>'; // Public message.
						echo '<p>' . mysqli_error($dbc) . '<center>Query: ' . $q . '</p></center></br>'; // Debugging message.
						echo '<a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-primary btn-lg" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
					}
				} else {
					// Always show the form...
					//Check if have valid voluntary work ID
					if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
						$id = $_GET['id'];
						showForm($id);
					} else if ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
						$id = $_POST['id'];
						showForm($id);
					} else {
						$id = 0;
					}
				}

				//FUNCTION
				function showForm($id)
				{

					require('../mysqli_connect_fyp.php');

					// Retrieve the voluntary work's information:
					$q = "SELECT * FROM voluntary_work_organization WHERE voluntary_work_organization.id = $id";

					$r = @mysqli_query($dbc, $q);

					if (mysqli_num_rows($r) == 1) { // Valid voluntary work ID, show the form.

						// Get the voluntary work's information:
						$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

						// Create the form:
						echo '
		<div class="container mx-auto" style="width: 65rem;"><br>
			<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 65rem;" >
				<div class="card-header">
					<img src="images/evw.png" class="p-3 mb-2" height="200" alt="Edit Voluntary Work Logo" loading="lazy" style="margin-top: -1px />
				</div>
		<div class="card-body text-start">
			<form class="row g-3 px-2" action="edit_details_voluntary_work_organization.php?id=' . $id . '" method="post">
			<fieldset>';
						echo '
		<div class="form-group row mb-2">
			<div class="input-group mb-2">
				<span class="input-group-text w-25" style="background-color: #EEEEEE;" id="basic-addon1">Voluntary Work Name</span>
				<input oninput="this.value = this.value.toUpperCase()" required type="text" class="form-control" name="name" size="100" maxlength="100" value="' . $row['name'] . '" >
			</div>
			<div class="input-group mb-2">
				<span class="input-group-text w-25" style="background-color: #EEEEEE;" id="basic-addon1">Task</span>
				<input oninput="this.value = this.value.toUpperCase()" required type="text" class="form-control" name="task" size="150" maxlength="150" value="' . $row['task'] . '">
			</div>
			<div class="input-group mb-2">
				<span class="input-group-text w-25" style="background-color: #EEEEEE;" id="basic-addon1">Voluntary Work Description</span>
				<textarea oninput="this.value = this.value.toUpperCase(); autoResize();" required class="form-control" id="description" name="description" size="500" maxlength="500">' . $row['description'] . '</textarea>
			</div>';

				?>
						<script>
							function autoResize() {
								var textarea = document.getElementById("description");
								textarea.style.height = "auto";
								textarea.style.height = (textarea.scrollHeight) + "px";
							}
							autoResize();
						</script>
						<?php

						echo '<div class="input-group mb-2">
			<span class="input-group-text w-25" style="background-color: #EEEEEE;" id="basic-addon1">Certification</span>
			<div class="col-md-3">
				<select id="inputCertification" name="certification" class="form-select" required>
				<option value="">Select</option>';
						$arr_certification = array("PROVIDED", "NOT PROVIDED");
						for ($i = 0; $i < 2; $i++) {
							if ($row['certification'] == $arr_certification[$i]) {
								$select =  ' selected ';
							} else {
								$select =  '';
							}
							echo '<option ' . $select . ' >';
							echo $arr_certification[$i];
							echo '</option>';
						}
						echo '</select>
			</div>
		</div>

		<div class="input-group mb-2">
			<span class="input-group-text w-25" style="background-color: #EEEEEE;" id="basic-addon1">Meals</span>
			<div class="col-md-3">
				<select id="inputMeals" name="meals" class="form-select" required>
				<option value="">Select</option>';
						$arr_meals = array("PROVIDED", "NOT PROVIDED");
						for ($i = 0; $i < 2; $i++) {
							if ($row['meals'] == $arr_meals[$i]) {
								$select =  ' selected ';
							} else {
								$select =  '';
							}
							echo '<option ' . $select . ' >';
							echo $arr_meals[$i];
							echo '</option>';
						}
						echo '</select>
			</div>
		</div>

		<div class="input-group mb-2">
		<span class="input-group-text w-25" style="background-color: #EEEEEE;" id="basic-addon1">Transportation</span>
		<div class="col-md-3">
			<select id="inputTransportation" name="transportation" class="form-select" required>
			<option value="">Select</option>';
						$arr_transportation = array("PROVIDED", "NOT PROVIDED");
						for ($i = 0; $i < 2; $i++) {
							if ($row['transportation'] == $arr_transportation[$i]) {
								$select =  ' selected ';
							} else {
								$select =  '';
							}
							echo '<option ' . $select . ' >';
							echo $arr_transportation[$i];
							echo '</option>';
						}
						echo '</select>
		</div>
	</div>

	<div class="input-group mb-2">
		<span class="input-group-text w-25" style="background-color: #EEEEEE;" id="basic-addon1">Allowance</span>
		<div class="col-md-3">
			<select id="inputAllowance" name="allowance" class="form-select" required>
			<option value="">Select</option>';
						$arr_allowance = array("PROVIDED", "NOT PROVIDED");
						for ($i = 0; $i < 2; $i++) {
							if ($row['allowance'] == $arr_allowance[$i]) {
								$select =  ' selected ';
							} else {
								$select =  '';
							}
							echo '<option ' . $select . ' >';
							echo $arr_allowance[$i];
							echo '</option>';
						}
						echo '</select>
		</div>
	</div>

			<div class="input-group mb-2">
				<span class="input-group-text w-25" style="background-color: #EEEEEE;" id="basic-addon1">Date</span>
				<input required type="date" class="form-control" name="date" size="8" maxlength="8" value="' . $row['date'] . '">
			</div>
			<div class="input-group mb-2">
				<span class="input-group-text w-25" style="background-color: #EEEEEE;" id="basic-addon1">Start Time</span>
				<input required type="time" class="form-control" name="start_time" size="20" maxlength="20" value="' . $row['start_time'] . '">
			</div>
			<div class="input-group mb-2">
				<span class="input-group-text w-25" style="background-color: #EEEEEE;" id="basic-addon1">End Time</span>
				<input required type="time" class="form-control" name="end_time" size="20" maxlength="20" value="' . $row['end_time'] . '">
			</div>

			<div class="input-group mb-2">
				<span class="input-group-text w-25" style="background-color: #EEEEEE;" id="basic-addon1">Status</span>
				<div class="col-md-4">
					<select id="inputStatus" name="status" class="form-select" required>
					<option value="">Select</option>';
						$arr_status = array("COMING SOON", "OPEN FOR REGISTRATION", "CLOSED FOR REGISTRATION", "IN REVIEW", "ON-GOING", "FINISHED");
						for ($i = 0; $i < 6; $i++) {
							if ($row['status'] == $arr_status[$i]) {
								$select =  ' selected ';
							} else {
								$select =  '';
							}
							echo '<option ' . $select . ' >';
							echo $arr_status[$i];
							echo '</option>';
						}
						echo '</select>
				</div>
			</div>
		</div>';
	?>

			</fieldset>
			<div align="right"><input class="btn btn-primary btn-lg ms-2" style="background-color: #518cbb;" type="submit" name="submit" value=" Submit " /> &nbsp&nbsp
				<a href="view_voluntary_work_list_organization.php" class="btn btn-secondary btn-lg" style="background-color: #8fbfe7;" tabindex="-1" role="button" aria-disabled="true">CANCEL</a>
			</div>
	</div>
	</div>
	</form>
<?php
					} else { // Not a valid voluntary work ID.
						echo '<div class="container mx-auto" style="width: 55rem;"><br>
<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
<div class="card-header">
	<img src="images/evw.png" class="p-3 mb-2" height="200" alt="Edit Voluntary Work Logo" loading="lazy" style="margin-top: -1px />
</div>
<div class="card-body text-start">';
						echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
		<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px;"  loop  autoplay></lottie-player></br>';
						echo '<p class="error">This page has been accessed in error due to <b>invalid voluntary work id</b>.</p>
	</br><a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-primary btn-lg" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>';
					}

					mysqli_close($dbc);
				} //END FUNCTION

				echo '</div></div></div></div></div></br>';
				include('includes/footer.php');
?>
</div>
</section>
<!-- Section: Main chart -->
</div>
</main>
<!--Main layout-->