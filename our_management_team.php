<?php
session_start(); // Start the session.
$page_title = "Our Management Team";
include('includes/header.php');
?>

<style>
  .img-fluid {
    width: 100%;
    height: auto;
  }

  .container-fluid {
    position: relative;
    padding: 0;
  }

  .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); 
  }

  .overlay-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: #fff;
    width: 80%;
    max-width: 700px;
    padding: 20px;
  }

  .overlay-content p {
    margin-bottom: 20px;
  }

  .overlay-content a {
    display: inline-block;
    padding: 10px 20px;
    font-size: 18px;
    font-weight: bold;
    background-color: #475053;
    color: #ffffff;
    text-decoration: none;
  }

  .volunteer-now-section {
    padding: 0;
  }

  body {
    overflow-x: hidden;
  }

  .card-text.text-justify {
    text-align: justify;
    margin-right: 30px;
  }
</style>

<main class="container-fluid p-0">
  <!-- Our Policies -->
    <section class="volunteer-now-section">
      <div style="position: relative;">
        <div class="row">
          <div class="col">
            <div class="position-relative">
              <img src="images/bgr9.png" class="img-fluid" alt="Background Image" />
              <div class="overlay"></div>
              <div class="overlay-content" style="background-color: rgba(0, 0, 0, 0.5); color: white; text-align: justify;">
                <br><h1 style="text-align: center;">Our Management Team</h1><br>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <!-- Our Policies -->
  <br>

  <section class="px-3" style="background-color: fbfbfb;">
  <div class="row justify-content-center">
    <div class="col-sm-8 mb-3">
      <div class="card bg-light custom-card" style="box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);">
        <div class="row text-center">
          <div class="col-md-12 mt-3">
            <img src="images/ahmad.png" class="img-fluid" alt="Ahmad Image" style="width: 250px;" />
          </div>
        </div>
        <div class="row text-center">
          <div class="col-md-6 mt-3">
            <img src="images/sofea.png" class="img-fluid" alt="Sofea Image" style="width: 260px;" />
          </div>
          <div class="col-md-6 mt-3">
            <img src="images/luqman.png" class="img-fluid" alt="Luqman Image" style="width: 250px;" />
          </div>
        </div>
        <div class="row text-center">
          <div class="col-md-6 mt-3">
            <img src="images/athirah.png" class="img-fluid" alt="Sofea Image" style="width: 290px;" />
          </div>
          <div class="col-md-6 mt-3">
            <img src="images/naimee.png" class="img-fluid" alt="Luqman Image" style="width: 250px;" />
          </div>
        </div>
        <div class="row text-center">
          <div class="col-md-6 my-3">
            <img src="images/fattah.png" class="img-fluid" alt="Sofea Image" style="width: 290px;" />
          </div>
          <div class="col-md-6 my-3">
            <img src="images/hafieza.png" class="img-fluid" alt="Luqman Image" style="width: 230px;" />
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</main>

<?php
include('includes/footer.php');
?>
