<?php
// This page lets the organization logout.
// This version uses sessions.
session_start();

// If no session value is present, redirect the user:
if (!isset($_SESSION['organization_id'])) {
	header("Location: login_organization.php");
}

// destroy everything in this session
unset($_SESSION);

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"],$params["httponly"]);
}

session_destroy();

// Set the page title and include the HTML header:
$page_title = 'Logged Out!';

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

include ('includes/header.php');

// Print a customized message:
echo '<div class="container-fluid mx-auto" style="width: 40rem;"><br>
	<div class="card text-center bg-light text-dark bg-opacity-100" style="width: 40rem;" >
	<div class="card-header">
		<img src="images/lt.png" class="p-3" height="200" alt="Help\'em Logo" loading="lazy" style="margin-top: -1px />
	</div>
<div class="card-body text-start">';
echo'<center><script class="p-3" src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<lottie-player src="https://assets9.lottiefiles.com/packages/lf20_s8dabnj6.json"  background="transparent"  speed="1"  style="width: 300px; height: 300px;"  loop  autoplay></lottie-player>';
echo'</br><p>You are now logged out! </br>See you again! Bye Bye!</p></br>
<a href="index.php" style="background-color: #518cbb;" class="btn btn-primary btn-lg col-sm-3 mb-3" tabindex="-1" role="button" aria-disabled="true">DONE</a></center>
</div>
</div>
</div>
</div>
</br>';

include ('includes/footer.php');
