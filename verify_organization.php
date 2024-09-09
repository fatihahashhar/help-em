<?php
$page_title = "Email Verification";
include('includes/header.php');

require('../mysqli_connect_fyp.php'); // Connect to the db.

if (isset($_GET['email']) && isset($_GET['v_code'])) {
  $query = "SELECT * FROM organization WHERE email = '$_GET[email]' AND verification_code = '$_GET[v_code]'";
  $result = mysqli_query($dbc, $query);

  if ($result){
    if (mysqli_num_rows($result) == 1) {
      $result_fetch = mysqli_fetch_assoc($result);
      if ($result_fetch['is_verified'] == 0) {
        $update="UPDATE organization SET is_verified = '1' WHERE email = '$result_fetch[email]'";
          if (mysqli_query($dbc, $update)){
            echo"
            <script>
              alert('Email verification successful');
              window.location.href = 'index.php';
            </script>";
          }

          else {
            echo"
            <script>
              alert('Email already registered');
              window.location.href = 'index.php';
            </script>";
          }
      }

      else {
        echo"
        <script>
          alert('Email already registered');
          window.location.href = 'index.php';
        </script>";
      }
    }
  }
}

include('includes/footer.php');

?>