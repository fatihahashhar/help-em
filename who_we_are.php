<?php
session_start(); // Start the session.
$page_title = "Who We Are";
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

  .custom-card {
    height: 270px;
  }

  body {
    overflow-x: hidden;
  }
</style>

<main class="container-fluid p-0">
  <!-- Who We Are -->
    <section class="volunteer-now-section">
      <div style="position: relative;">
        <div class="row">
          <div class="col">
            <div class="position-relative">
              <img src="images/bgr1.png" class="img-fluid" alt="Background Image" />
              <div class="overlay"></div>
              <div class="overlay-content" style="background-color: rgba(0, 0, 0, 0.5); color: white; text-align: justify;">
                <br><h1 style="text-align: center;">Who We Are</h1><br>
                <p>Help'em is a transformative web-based application designed to empower organizations and institutions in their quest to recruit passionate volunteers for their meaningful initiatives. At Help'em, our mission is to connect dedicated individuals with volunteering opportunities that match their interests and make a positive impact in their communities.</p>
                <p>Our innovative system serves as a comprehensive platform that facilitates seamless coordination between organizations, institutions, and volunteers. By leveraging the power of technology, Help'em simplifies the volunteering process, enabling both sides to effortlessly navigate the journey towards collaboration and social change.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <!-- Who We Are -->
  <br><br>

    <section class="p-3">
      <div class="row">
        <div class="col">
          <center>
            <img src="images/oa.png" class="p-3 mb-3" height="200" alt="Our Aim Logo" loading="lazy" style="margin-top: -1px; margin-bottom: -10px;" />
          </center>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="card custom-card" style="background-color: #7ea5c4; box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);">
            <center>
              <img src="images/recruit.png" class="img-fluid" alt="Recruit Image" />
            </center>
            <div class="card-body">
              <p class="card-text text-center">Simplify Volunteer Recruitment</p>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card custom-card" style="background-color: #7ea5c4; box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);">
            <center>
              <img src="images/empower.png" class="img-fluid" alt="Empower Image" style="width: 240px;" />
            </center>
            <div class="card-body">
              <p class="card-text text-center">Empower Volunteers</p>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card custom-card" style="background-color: #7ea5c4; box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);">
            <center>
              <img src="images/matching.png" class="img-fluid" alt="Matching Image" />
            </center>
            <div class="card-body">
              <p class="card-text text-center">Enhance Volunteer-Organization Matching</p>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card custom-card" style="background-color: #7ea5c4; box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);">
            <center>
              <img src="images/community.png" class="img-fluid" alt="Community Image" />
            </center>
            <div class="card-body">
              <p class="card-text text-center">Foster Community and Collaboration</p>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card custom-card" style="background-color: #7ea5c4; box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);">
            <center>
              <img src="images/management.png" class="img-fluid" alt="Management Image" />
            </center>
            <div class="card-body">
              <p class="card-text text-center">Simplify Volunteer Management</p>
            </div>
          </div>
        </div>
      </div>
    </section>
<br>



</main>

<?php
include('includes/footer.php');
?>
