<?php
// This script performs an INSERT query to add a record to the reservation table.
$page_title = "Admin Registration";
include('includes/header.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($email, $v_code) {
	require 'PHPMailer-master/src/PHPMailer.php';
	require 'PHPMailer-master/src/SMTP.php';
	require 'PHPMailer-master/src/Exception.php';

	// Send the email notification
	$mail = new PHPMailer(true); // Create a new PHPMailer instance

	// Configure SMTP settings
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com'; // Replace with your SMTP host
	$mail->SMTPAuth = true;
	$mail->Username = 'snfbwam@gmail.com'; // Replace with your SMTP username
	$mail->Password = 'fdzrqriwnwtalair'; // Replace with your SMTP password
	$mail->SMTPSecure = 'ssl';
	$mail->Port = 465;

	// Set the email content
	$mail->setFrom('snfbwam@gmail.com'); // Replace with your email and name
	$mail->addAddress($em); // Add the recipient email address
	$mail->isHTML(true);

	$mail->Subject = 'Registration Successful';
	$mail->Body = 'Dear admin, your registration is successful.';

	// Send the email
	$mail->send();

	// Print a success message
	echo "
	<script>
	alert('Registration is successful');
	document.location.href = 'register_admin.php';
	</script>";
}


// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$un = trim($_POST['username']);
	$em = trim($_POST['email']);

	// Check for a password and match against the confirmed password:
	if ($_POST['pass1'] != $_POST['pass2']) {
		$errors[] = 'Your password did not match the confirmed password.';
	} else {
		$pw = trim($_POST['pass1']);
	}

	// If everything's OK. ($fn && $ln && $ac && $mh && $bd && $tp && $pr && $un && $pw)
	if (empty($errors)) {

		// Register the reservation in the database...
		require('../mysqli_connect_fyp.php'); // Connect to the db.

		$user_exist_query = "SELECT * FROM admin WHERE username='$un' OR email='$em'";
		$s = mysqli_query($dbc, $user_exist_query); // Run the query.

		if ($s){
			if(mysqli_num_rows($s)>0) {
				$result_fetch = mysqli_fetch_assoc($s);
				if ($result_fetch['username']==$_POST['username']) {
					echo'
					<script>
						alert("Username already taken");
						window.location.href = "javascript:history.back()";
					</script>';
				}

				else {
					echo'
					<script>
						alert("Email already registered");
						window.location.href = "javascript:history.back()";
					</script>';
				}
			}

			else {
				// Make the query:
				$v_code = bin2hex(random_bytes(16));
				$q = "INSERT INTO admin (username, email, password, verification_code, is_verified) VALUES ('$un', '$em', SHA1('$pw'), '$v_code', '0')";
				$r = mysqli_query($dbc, $q); // Run the query.

				$u = "SELECT id FROM admin WHERE username='$un' and password=SHA1('$pw')";
				$v = mysqli_query($dbc, $u,); // Run the query.
				$row = mysqli_fetch_array($v, MYSQLI_ASSOC);
				$w = $row['id'];

				// Print a message:
				echo '
				<div class="container mx-auto" style="width: 40rem;"><br>
					<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 40rem;" >
					<div class="card-header">
						<img src="images/r.png" class="p-3 mb-2" height="200" alt="Registration Logo" loading="lazy" style="margin-top: -1px />
					</div>
					<div class="card-body text-start">
				<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
				<lottie-player class="p-3 mb-2" src="https://assets7.lottiefiles.com/private_files/lf30_z1sghrbu.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px;"  loop  autoplay></lottie-player>';
				echo '</br><h2>Thank you!</h2>
				<p>You are now an admin of Help\'em.</p>';
				echo '<a href="index.php" class="btn btn-primary btn-lg mb-2" tabindex="-1" role="button" aria-disabled="true">Done</a></center>
				</div></div></div></br>';
			}

		} else { // If it did not run OK.
			echo '<div class="container mx-auto" style="width: 40rem;"><br>';
			echo '<div class="card text-center bg-light p-4 text-dark bg-opacity-100" style="width: 40rem;" >
			<div class="card-header">
			<img src="images/r.png" class="p-3 mb-2" height="200" alt="Registration Logo" loading="lazy" style="margin-top: -1px />
			</div>
		
		 	<div class="card-body">';
			// Public message:
			echo '<center><h1>System Error</h1>
			<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';

			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
			echo '<a href="javascript:history.back()" class="btn btn-primary btn-lg mb-2" tabindex="-1" role="button" aria-disabled="true">Back</a></center>';
		} // End of if ($r) IF.

		mysqli_close($dbc); // Close the database connection.

		// Include the footer and quit the script:
		include('includes/footer.php');
		exit();

	} else { // Report the errors.
		echo '<div class="container mx-auto" style="width: 40rem;"><br>';
		echo '<div class="card text-center bg-light p-4 text-dark bg-opacity-100" style="width: 40rem;" >
			<div class="card-header">
			<img src="images/r.png" class="p-3 mb-2" height="200" alt="Registration Logo" loading="lazy" style="margin-top: -1px />
			</div>
		
		 	<div class="card-body">';
		echo '<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
		<lottie-player class="p-3 mb-2" src="https://assets1.lottiefiles.com/packages/lf20_gzlupphk.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;" loop  autoplay></lottie-player>';
		echo '<p style= color:red><b>Please fill in all the required information!</b>';
		echo '<p class="error"><b>The following error(s) occurred:</b></br>';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p><b>Please try again.</b></p>
		</br><a href="javascript:history.back()" class="btn btn-primary btn-lg mb-2" tabindex="-1" role="button" aria-disabled="true">Back</a></center>
		</div></div></div></div>
		</br>';
	} // End of if (empty($errors)) IF.
} else { // End of the main Submit conditional.
	echo '<div class="container mx-auto" style="width: 40rem;"><br>
<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 40rem;" >
<div class="card-header">
<img src="images/r.png" class="p-3 mb-2" height="200" alt="Registration Logo" loading="lazy" style="margin-top: -1px />
</div>
<div class="card-body text-start">
	<form class="row g-3 px-3 needs-validation" action="register_admin.php" method="post">
	<fieldset>';
	echo '
<div class="form-group row mb-3">
<div class="col-sm-6">
<div class="input-group mb-1">
<span class="input-group-text" id="basic-addon1">Username</span>
    <input required type="text" class="form-control" id="inputUsername" name="username" size="20" maxlength="20" value="';
	if (isset($_POST['username'])) echo $_POST['username'];
	echo '"/>
  </div>
  </div>
  <div class="col-sm-6">
  <div class="input-group mb-1">
  <span class="input-group-text" id="basic-addon1">Email</span>
    <input required type="email" class="form-control" id="inputEmail" name="email" size="50" maxlength="50" value="';
	if (isset($_POST['email'])) echo $_POST['email'];
	echo '"/>
  </div>
  </div>
</div>
<div class="form-group row mb-3">
<div class="col-sm-6">
<div class="input-group mb-3">
<span class="input-group-text" id="basic-addon1">Password</span>
    <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required class="form-control" id="inputpassword" name="pass1" size="20" maxlength="20" value="';
	if (isset($_POST['pass1'])) echo $_POST['pass1'];
	echo '"/>
  </div>
  </div>
  <div class="col-sm-6">
  <div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1">Confirm Password</span>
    <input type="password" class="form-control" id="inputcpassword" name="pass2" size="20" maxlength="20" value="';
	if (isset($_POST['pass2'])) echo $_POST['pass2'];
	echo '"/>
  </div>
  </div>
</div>';
?>
	</fieldset>
	<div align="right"><input class="btn btn-primary btn-lg col-sm-3 mb-2" type="submit" name="submit" value=" Submit " /></div> </br>
	</form>
	</div>
	<div class="card-footer text-muted">Already have an account? <a href="login_admin.php">Login Now!!!</a></div>
	</div>
	</div>
	</div>
	</div>
	</div>
	</br>
<?php }
include('includes/footer.php');
?>