<?php
session_start();
// Include the header:
$page_title = 'Organization Login';
include('includes/header.php');

?>

<style>
	.container-fluid {
      position: relative;
      padding: 0;
    }
	
    body {
    overflow-x: hidden;
	}
</style>

<?php

require('../mysqli_connect_fyp.php');

// If the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Get input from user and then set to the corresponding variables
	$email = $_POST['email'];
	$password = $_POST['password'];

	// Find id from table organization in database
	$q = "SELECT * FROM organization WHERE email='$email' AND password=SHA1('$password')";
	$r = @mysqli_query($dbc, $q);

	if (mysqli_num_rows($r) == 1) {	// If found

		$result_fetch = mysqli_fetch_assoc($r);
		if ($result_fetch['is_verified'] == 1) {
			$_SESSION["organization_id"] = $result_fetch['id'];
			$_SESSION["username"] = $result_fetch['username'];
			echo '
			<script>
				alert("Login successful");
				window.location.href = "view_voluntary_work_list_organization.php";
			</script>';

		} else {
			echo '
			<script>
				alert("Email Not Verified");
				window.location.href = "javascript:history.back()";
			</script>';
		}
	} else {// If not found
		echo '
		<script>
			alert("Email or Username Not Registered");
			window.location.href = "javascript:history.back()";
		</script>';
	}
} // End of the main submit conditional.

//If the form has not been submitted
else {
	// Display the form:
	echo ' <div class="container-fluid mx-auto" style="width: 25rem;"><br>
	<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 25rem;">
		<div class="card-header">
			<img src="logo.png" class="p-3 mb-2" height="170" alt="Help\'em Logo" loading="lazy" style="margin-top: -1px />
		</div>
		<div class=" card-body text-start">';
?>
	<form class="px-3" action="login_organization.php" method="post">
		<fieldset>
			<div class="form-group username-label row mb-1">
				<div class="mb-3">
					<input required type="text" placeholder="Email" aria-label="Email" class="form-control" name="email" size="50" maxlength="50" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" />
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
	<div class="card-footer text-muted">Don't have an account yet? <br> <a href="register_organization.php">Create New Account</a></div>
	</div>
	</div>
	</div>
	</div>
	</div>
	</br>
<?php }
include('includes/footer.php'); ?>