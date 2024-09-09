<?php
// This script performs an INSERT query to add a record to the volunteer table.
$page_title = "Volunteer Registration";
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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($em, $v_code) {
	require 'PHPMailer-master/src/PHPMailer.php';
	require 'PHPMailer-master/src/SMTP.php';
	require 'PHPMailer-master/src/Exception.php';

	// Send the email notification
	$mail = new PHPMailer(true); // Create a new PHPMailer instance

	try {
	// Configure SMTP settings
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com'; // Replace with your SMTP host
	$mail->SMTPAuth = true;
	$mail->Username = 'helpem.malaysia@gmail.com'; // Replace with your SMTP username
	$mail->Password = 'gpbubtpumuuvxvdk'; // Replace with your SMTP password
	$mail->SMTPSecure = 'ssl';
	$mail->Port = 465;

	// Set the email content
	$mail->setFrom('helpem.malaysia@gmail.com', "HELP'EM MALAYSIA"); // Replace with your email and name
	$mail->addAddress($em); // Add the recipient email address
	$mail->isHTML(true);
	$mail->Subject = "Email Verification from HELP'EM MALAYSIA";
	$mail->Body = "Thank you for your registration !
		Click the link below to verify the email address <br>
		<a href='http://localhost/Help_em/verify_volunteer.php?email=$em&v_code=$v_code'>Verify</a>";

	// Send the email
	$mail->send();

	return true;
	} catch (Exception $e) {
		return false; 
	}
}

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$fn = trim($_POST['first_name']);
	$ln = trim($_POST['last_name']);
	$un = trim($_POST['username']);
	$em = trim($_POST['email']);
	$ic = trim($_POST['ic_number']);
	$ad = trim($_POST['address']);
	$pc = trim($_POST['postcode']);
	$ct = trim($_POST['city']);
	$st = trim($_POST['state']);
	$cn = trim($_POST['contact_number']);
	$ex = trim($_POST['experience']);
	$bn = trim($_POST['bank_name']);
	$an = trim($_POST['account_number']);

	// Check for a password and match against the confirmed password:
	if ($_POST['pass1'] != $_POST['pass2']) {
		$errors[] = 'Your password did not match the confirmed password.';
	} else {
		$pw = trim($_POST['pass1']);
	}

	// If everything's OK. ($fn && $ln && $un && $em && $ad && $pc && $ct && $st && $ic && $cn && $ex && $bn && $an)
	if (empty($errors)) {

		// Register the reservation in the database...
		require('../mysqli_connect_fyp.php'); // Connect to the db.

		$user_exist_query = "SELECT * FROM volunteer WHERE username='$un' OR email='$em'";
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
				$q = "INSERT INTO volunteer (first_name, last_name, username, email, ic_number, address, postcode, city, state, contact_number, experience, bank_name, account_number, password, verification_code, is_verified) VALUES ('$fn', '$ln', '$un', '$em', '$ic', '$ad', '$pc', '$ct', '$st', '$cn', '$ex', '$bn', '$an', SHA1('$pw'), '$v_code', '0')";

				if (mysqli_query($dbc, $q) && sendMail($_POST['email'], $v_code)) {
					$u = "SELECT id FROM volunteer WHERE username='$un' and password=SHA1('$pw')";
					$v = mysqli_query($dbc, $u,); // Run the query.
					$row = mysqli_fetch_array($v, MYSQLI_ASSOC);
					$w = $row['id'];

					// Print a message:
					echo '
					<div class="container-fluid mx-auto" style="width: 40rem;"><br>
						<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 40rem;" >
						<div class="card-header">
							<img src="images/r.png" class="p-3 mb-2" height="200" alt="Registration Logo" loading="lazy" style="margin-top: -1px />
						</div>
						<div class="card-body text-start">
					<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
					<lottie-player class="p-3 mb-2" src="https://assets7.lottiefiles.com/private_files/lf30_z1sghrbu.json"  background="transparent"  speed="1"  style="width: 200px; height: 200px;"  loop  autoplay></lottie-player>';
					echo '</br><h4>Thank you!</h4>
					<p>One step closer for successful registration ! <br>
					Please verify your email first before continuing with login.
					</p>';
					echo '<a href="index.php" class="btn btn-primary btn-lg mb-2" tabindex="-1" role="button" aria-disabled="true">Done</a></center>
					</div></div></div></br>';
				}

				else {
					echo '<div class="container-fluid mx-auto" style="width: 40rem;"><br>';
					echo '<div class="card text-center bg-light p-4 text-dark bg-opacity-100" style="width: 40rem;" >
					<div class="card-header">
					<img src="images/r.png" class="p-3 mb-2" height="200" alt="Registration Logo" loading="lazy" style="margin-top: -1px />
					</div>
				
					<div class="card-body">';
					// Public message:
					echo '<center><h3>System Error</h3>
					<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';

					// Debugging message:
					echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>';
					echo '<a href="javascript:history.back()" class="btn btn-primary btn-lg my-2" tabindex="-1" role="button" aria-disabled="true">Back</a></center>
					</div></div></div><br>';
				}
			}

		} else { // If it did not run OK.
			echo '
			<div class="container-fluid mx-auto" style="width: 40rem;"><br>';
				echo '<div class="card text-center bg-light p-4 text-dark bg-opacity-100" style="width: 40rem;" >
				<div class="card-header">
					<img src="images/r.png" class="p-3 mb-2" height="200" alt="Registration Logo" loading="lazy" style="margin-top: -1px />
				</div>
			
				<div class="card-body">';
				// Public message:
				echo '<center><h3>System Error</h3>
				<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';

				// Debugging message:
				echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>';
				echo '<a href="javascript:history.back()" class="btn btn-primary btn-lg my-2" tabindex="-1" role="button" aria-disabled="true">Back</a></center>
				</div></div></div><br>';
		} // End of if ($r) IF.

		mysqli_close($dbc); // Close the database connection.

		// Include the footer and quit the script:
		include('includes/footer.php');
		exit();

	} else { // Report the errors.
		echo '
		<div class="container-fluid mx-auto" style="width: 40rem;"><br>
			<div class="card text-center bg-light p-4 text-dark bg-opacity-100" style="width: 40rem;" >
				<div class="card-header">
					<img src="images/r.png" class="p-3 mb-2" height="200" alt="Registration Logo" loading="lazy" style="margin-top: -1px />
				</div>
				<div class="card-body">
					<center><script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
					<lottie-player class="p-3 mb-2" src="https://assets1.lottiefiles.com/packages/lf20_gzlupphk.json"  background="transparent"  speed="1"  style="width: 150px; height: 150px;" loop  autoplay></lottie-player>
					<p style= color:red><b>Please fill in all the required information!</b>
					<p class="error"><b>The following error(s) occurred:</b></br>';
					foreach ($errors as $msg) { // Print each error.
						echo " - $msg<br />\n";
					}
					echo '</p><p><b>Please try again.</b></p> </br>
					<a href="javascript:history.back()" class="btn btn-primary btn-lg mb-2" tabindex="-1" role="button" aria-disabled="true">Back</a></center>
					</div></div></div></div></br>';
	} // End of if (empty($errors)) IF.

} else { // End of the main Submit conditional.
	echo '<div class="container-fluid mx-auto" style="width: 55rem;"><br>
<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 55rem;" >
<div class="card-header">
<img src="images/r.png" class="p-3 mb-2" height="200" alt="Registration Logo" loading="lazy" style="margin-top: -1px />
</div>
<div class="card-body text-start">
	<form class="row g-3 px-3 needs-validation" action="register_volunteer.php" method="post">
	<fieldset>';
	echo '
	<div class="form-group row mb-3">
  <div class="col-sm-6">
  <div class="input-group mb-1">
  <span class="input-group-text" id="basic-addon1">First Name</span>
    <input required oninput="this.value = this.value.toUpperCase()" type="text" class="form-control" id="inputFirstName" name="first_name" size="50" maxlength="50" value="';
	if (isset($_POST['first_name'])) echo $_POST['first_name'];
	echo '"/>
  </div>
  </div>
  <div class="col-sm-6">
  <div class="input-group mb-1">
  <span class="input-group-text" id="basic-addon1">Last Name</span>
    <input required oninput="this.value = this.value.toUpperCase()" type="text" class="form-control" id="inputLastName" name="last_name" size="50" maxlength="50" value="';
	if (isset($_POST['last_name'])) echo $_POST['last_name'];
	echo '"/>
  </div>
  </div>
</div>
<div class="form-group row mb-3">
  <div class="col-sm-5">
  <div class="input-group mb-1">
  <span class="input-group-text" id="basic-addon1">Username</span>
    <input required type="text" class="form-control" id="inputUsername" name="username" size="20" maxlength="20" value="';
	if (isset($_POST['username'])) echo $_POST['username'];
	echo '"/>
  </div>
  </div>
  <div class="col-sm-5">
  <div class="input-group mb-1">
  <span class="input-group-text" id="basic-addon1">Email</span>
  <input required type="email" class="form-control" id="inputEmail" name="email" size="50" maxlength="50" value="';
	if (isset($_POST['email'])) echo $_POST['email'];
	echo '"/>
  </div>
  </div>
</div>
<div class="form-group row mb-3">
<div class="col-sm-4">
  <div class="input-group mb-1">
  <span class="input-group-text" id="basic-addon1">IC Number</span>
  <input required type="text" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="form-control" id="inputICNumber" name="ic_number" size="12" minlength="12" maxlength="12" value="';
	if (isset($_POST['ic_number'])) echo $_POST['ic_number'];
	echo '"/>
  </div>
  </div>
  <div class="col-sm-4">
  <div class="input-group mb-1">
  <span class="input-group-text" id="basic-addon1">Contact Number</span>
    <input required type="text" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="form-control" id="inputContactNumber" name="contact_number" size="11" minlength="10" maxlength="11" value="';
	if (isset($_POST['contact_number'])) echo $_POST['contact_number'];
	echo '"/>
  </div>
  </div>
</div>
<div class="form-group row mb-3">
  <div class="col-sm-8">
  <div class="input-group mb-1">
  <span class="input-group-text" id="basic-addon1">Address</span>
    <input required oninput="this.value = this.value.toUpperCase()" type="text" class="form-control" id="inputAddress" name="address" size="100" maxlength="100" value="';
	if (isset($_POST['address'])) echo $_POST['address'];
	echo '"/>
  </div>
  </div>
  <div class="col-sm-3">
  <div class="input-group mb-1">
  <span class="input-group-text" id="basic-addon1">Postcode</span>
    <input required type="text" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="form-control" id="inputPostcode" name="postcode" size="5" minlength="5" maxlength="5" value="';
	if (isset($_POST['postcode'])) echo $_POST['postcode'];
	echo '"/>
  </div>
  </div>
  </div>
  <div class="form-group row mb-3">
  <div class="col-sm-5">
  <div class="input-group mb-1">
  <span class="input-group-text" id="basic-addon1">City/Town</span>
    <input required oninput="this.value = this.value.toUpperCase()" type="text" class="form-control" id="inputCity" name="city" size="20" maxlength="20" value="';
	if (isset($_POST['city'])) echo $_POST['city'];
	echo '"/>
  </div>
  </div>
  <div class="col-sm-4">
  <div class="input-group mb-1">
  <span class="input-group-text" id="basic-addon1">State</span>
    <select id="inputState" name="state" class="form-select" required>
      <option value="">Select</option>';
	$arr_state = array("JOHOR", "KEDAH", "KELANTAN", "KUALA LUMPUR", "LANGKAWI", "MELAKA", "NEGERI SEMBILAN", "PAHANG", "PENANG", "PERAK", "PERLIS", "PUTRAJAYA", "SELANGOR", "TERENGGANU");
	foreach ($arr_state as $value) {
		if (isset($_REQUEST["state"]) && $_REQUEST["state"] == $value) { // creating sticky
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
  <div class="form-group col-l">
	<textarea required oninput="this.value = this.value.toUpperCase()" class="form-control" placeholder="Voluntary Experience" aria-label="Voluntary Experience" id="inputExperience" rows="5" name="experience" size="500" maxlength="500" value=""></textarea>';
		if (isset($_POST['experience'])) echo $_POST['experience'];
		echo '
	</div>
</div>
<div class="form-group row mb-1">
<div class="col-sm-7">
<div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1">Bank Name</span>
    <input required oninput="this.value = this.value.toUpperCase()" type="int" class="form-control" placeholder="Bank Name" aria-label="Bank Name" id="inputBankName" name="bank_name" size="100" maxlength="100" value="';
	if (isset($_POST['bank_name'])) echo $_POST['bank_name'];
	echo '"/>
  </div>
  </div>
  <div class="col-sm-5">
  <div class="input-group mb-1">
  <span class="input-group-text" id="basic-addon1">Account Number</span>
    <input required type="text" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" class="form-control" id="inputAccountNumber" name="account_number" size="20" maxlength="20" value="';
	if (isset($_POST['account_number'])) echo $_POST['account_number'];
	echo '"/>
  </div>
  </div>
</div>
<div class="form-group row mb-1">
  <div class="col-sm-5">
  <div class="input-group mb-1">
  <span class="input-group-text" id="basic-addon1">Password</span>
    <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required class="form-control" id="inputpassword" name="pass1" size="20" maxlength="20" value="';
	if (isset($_POST['pass1'])) echo $_POST['pass1'];
	echo '"/>
  </div>
  </div>
  <div class="col-sm-6">
  <div class="input-group mb-1">
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
	<div class="card-footer text-muted">Already have an account? <a href="login_volunteer.php">Login Now!!!</a></div>
	</div>
	</div>
	</div>
	</div>
	</div>
	</br>
<?php }
include('includes/footer.php');
?>