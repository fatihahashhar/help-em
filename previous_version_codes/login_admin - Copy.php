<?php
session_start();
// Include the header:
$page_title = 'Admin Login';
include('includes/header.php');
require('../mysqli_connect_fyp.php');

// If the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Get input from user and then set to the corresponding variables
	$username = $_POST['username'];
	$password = $_POST['password'];

	// Find id from table admin in database
	$q = "SELECT id FROM admin WHERE username='$username' AND password=SHA1('$password')";
	$r = @mysqli_query($dbc, $q);

	if (mysqli_num_rows($r) == 1) {			// If found
		while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
			// Set the session data:
			$_SESSION["admin_id"] = $row['id'];

			echo '<div class="container mx-auto" style="width: 40rem;"><br>
	<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 40rem;" >
	<div class="card-header">
	<img src="logo.png" class="p-3 mb-2" height="170" alt="Help\'em Logo" loading="lazy" style="margin-top: -1px />
	</div>
<div class="card-body text-start">';
			echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
			<lottie-player class="p-3 mb-2" src="https://assets7.lottiefiles.com/private_files/lf30_z1sghrbu.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px;"  loop  autoplay></lottie-player>';
			echo "</br><p>You are now logged in, $username!</p></center></br>";
			echo '<a href="view_list_institution.php" style="background-color: #518cbb;" class="btn btn-primary btn-lg col-sm-3 mb-3" tabindex="-1" role="button" aria-disabled="true">DONE</a></center>';
			echo '</div></div></div></div></br>';
		}
	} else {								// If not found
		echo '<div class="container mx-auto" style="width: 40rem;"><br>
	<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 40rem;" >
	<div class="card-header">
	<img src="logo.png" class="p-3 mb-2" height="170" alt="Help\'em Logo" loading="lazy" style="margin-top: -1px />
	</div>
<div class="card-body text-start">';
		echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
		<lottie-player class="p-3 mb-2" src="https://assets1.lottiefiles.com/packages/lf20_gzlupphk.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px;"  loop  autoplay></lottie-player>
	<p class="error"><b>The following error(s) occurred:</b><br/>
	The username and password entered do not match those on file.';
		echo '</p><p>Please try again.</p>
	</br><a href="javascript:history.back()" style="background-color: #518cbb;" class="btn btn-primary btn-lg" tabindex="-1" role="button" aria-disabled="true">BACK</a></center>
	</br></div></div></div></div>
	</br>';
	}
} // End of the main submit conditional.

//If the form has not been submitted
else {
	// Display the form:
	echo ' <div class="container mx-auto" style="width: 25rem;"><br>
	<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 25rem;">
		<div class="card-header">
		<img src="logo.png" class="p-3 mb-2" height="170" alt="Help\'em Logo" loading="lazy" style="margin-top: -1px />
			</div>
		<div class=" card-body text-start">';
?>
	<form class="px-2" action="login_admin.php" method="post">
		<fieldset>
			<div class="form-group username-label row mb-1">
				<div class="mb-3">
					<input required type="text" placeholder="Username" aria-label="Username" class="form-control" name="username" size="20" maxlength="20" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>" />
				</div>
			</div>
			<div class="form-group password-label row mb-2">
				<div class="mb-3">
					<input required type="password" placeholder="Password" aria-label="Password" class="form-control" id="inputpassword" name="password" size="20" maxlength="20" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>" />
				</div>
			</div>
			<div align="right"><input style="background-color: #518cbb;" class="btn btn-primary btn-lg col-sm-5 mb-3" type="submit" name="submit" value="Login" /></div>
	</form>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	</br>
<?php }
include('includes/footer.php'); ?>