<?php
$page_title = 'View Details of Past Voluntary Work';
session_start(); // Start the session.

?>
<!--Main Navigation-->
<header>
	<!-- Sidebar -->
	<?php
	include('includes/sidebar_for_institution.html');
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
  <div class="container pt-4" style="padding-right: 30px;">
      <!-- Section: Main chart -->
        <section class="mb-4">
          <div>
            <?php
				//Check if have valid ID
				if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
					$id = $_GET['id'];
					require('../mysqli_connect_fyp.php');
				} else if ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
					$id = $_POST['id'];
					require('../mysqli_connect_fyp.php');
				} else {
					$id = 0;
				}

				$query1 = "SELECT voluntary_work_institution.id, voluntary_work_institution.name, voluntary_work_institution.task, voluntary_work_institution.description, voluntary_work_institution.date, 
				voluntary_work_institution.start_time, voluntary_work_institution.end_time, voluntary_work_institution.institution_id as institution_id, voluntary_work_institution.image, 
				voluntary_work_institution.certification, voluntary_work_institution.meals, voluntary_work_institution.transportation, voluntary_work_institution.allowance, voluntary_work_institution.status
				FROM voluntary_work_institution
				JOIN institution ON voluntary_work_institution.institution_id = institution.id
				WHERE voluntary_work_institution.id = $id";
				$result1 = mysqli_query($dbc, $query1);

				if (mysqli_num_rows($result1) == 1) {
					$row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
					showForm($id, $row, $dbc);
				} else { // Not a valid institution ID.
					echo '
					<div class="container mx-auto" style="width: 55rem;">
						<div class="row py-3">
							<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
								<div class="card-header">
									<img src="images/avw.png" class="p-2 my-3" height="200" alt="About Voluntary Work Logo" loading="lazy" style="margin-top: -1px />
								</div>
								<div class="card-body text-start">';
								echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
										<lottie-player src="https://assets6.lottiefiles.com/packages/lf20_j3UXNf.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;"  loop  autoplay></lottie-player></br>';
								echo '<p class="error">This page has been accessed in error due to <b>invalid voluntary work id</b>.</p>
									</br><a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-danger btn-lg mb-3" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>';
		}

	//FUNCTION
	function showForm($id, $row, $dbc)
	{
		$image = $row['image'];
      	$imageData = base64_encode($image);

		// Create the form:
		echo '
			<div class="container mx-auto" style="width: 75rem;">		
				<div class="row py-3">
					<div class="col-md-8">
						<div class="card bg-light text-dark bg-opacity-100 w-100">
							<div class="card-header text-center">
								<img src="images/avw.png" class="p-3 mb-2" height="200" alt="About Voluntary Work Logo" loading="lazy" style="margin-top: -1px />
							</div>
							<div class="card-body text-start">
								<div class="card-body">
									<form class="row g-3 px-2" action="read_more_voluntary_work_details_volunteer.php?id=' . $id . '" method="post">
										<fieldset>
												<div class="form-group row mb-2 text-start">
												<div style="margin-bottom: 10px;"><h4 style="text-decoration: underline;">' . $row['name'] . '</h4></div>
												
												<div style="background-color: #6096B4;" class="card border rounded-4 shadow p-3 text-dark bg-opacity-100 w-100">
												<strong><span style="background-color: #BDCDD6; padding: 5px;"><i class="fa-solid fa-list-check"></i></span>&nbsp TASK: </strong>
												<p>' . $row['task'] . '</p>
												<strong><span style="background-color: #BDCDD6; padding: 5px;"><i class="fa-solid fa-circle-info"></i></span>&nbsp DESCRIPTION: </strong>' . nl2br(htmlspecialchars($row['description'])) . '
												</div>

												<div style="background-color: #93BFCF;" class="card border rounded-4 shadow p-3 text-dark bg-opacity-100 w-100">
												<div> <strong><span style="background-color: #BDCDD6; padding: 5px;"><i class="fa-solid fa-calendar-days"></i></span>&nbsp DATE: </strong>' . date('d M Y', strtotime($row['date'])) . '
												<strong style="margin-left: 30px;"><span style="background-color: #BDCDD6; padding: 5px;"><i class="fa-solid fa-clock"></i></span>&nbsp START TIME: </strong> ' . date('g:i A', strtotime($row['start_time'])) . '
												<strong style="margin-left: 30px;"><span style="background-color: #BDCDD6; padding: 5px;"><i class="fa-solid fa-clock"></i></span>&nbsp END TIME: </strong> ' . date('g:i A', strtotime($row['end_time'])) . '</div>
												</div>

												<div style="background-color: #93BFCF;" class="card border rounded-4 shadow p-3 text-dark bg-opacity-100 w-100">
												<div style="margin-bottom: 20px;"> <strong><span style="background-color: #BDCDD6; padding: 5px;"><i class="fas fa-certificate"></i></span>&nbsp CERTIFICATION: </strong>' . $row['certification'] . '
												<strong style="margin-left: 20px;"><span style="background-color: #BDCDD6; padding: 5px;"><i class="fas fa-utensils"></i></span>&nbsp MEALS: </strong>' . $row['meals'] . '</div>
												<div> <strong><span style="background-color: #BDCDD6; padding: 5px;"><i class="fa-solid fa-house"></i></span>&nbsp TRANSPORTATION: </strong>' . $row['transportation'] . '
												<strong style="margin-left: 20px;"><span style="background-color: #BDCDD6; padding: 5px;"><i class="fa-solid fa-money-bill-wave"></i></span>&nbsp ALLOWANCE: </strong>' . $row['allowance'] . '</div>
												</div>

												<div style="background-color: #93BFCF;" class="card border rounded-4 shadow p-3 text-dark bg-opacity-100 w-100 mb-3">
												<div> <strong><span style="background-color: #BDCDD6; padding: 5px;"><i class="fas fa-spinner"></i></span>&nbsp STATUS: </strong>' . $row['status'] . '</div>
												</div>
												</div>
										</fieldset>

										<div align="right">
											<a href="javascript:history.back()" style="background-color: #518cbb; margin-bottom: -6px;" class="btn btn-danger btn-lg col-sm-2" tabindex="-1" role="button" aria-disabled="true">BACK</a>';?>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="card text-center bg-light text-dark bg-opacity-100 w-100">
							<div class="card-body">
								<img src="data:image/jpeg;base64,<?php echo $imageData; ?>" class="card-img-top" alt="Image" style="width: 100%; height: auto;">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--Main layout-->

<?php
	mysqli_close($dbc); // Close database connection
	} //END FUNCTION
	include('includes/footer.php');
?>