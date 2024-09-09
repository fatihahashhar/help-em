<?php
session_start(); // Start the session.
$page_title = "How We Works";
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
    background-color: rgba(0, 0, 0, 0.6); 
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

  h4 {
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    font-weight: bold;
  }

  h3 {
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    font-weight: bolder;
  }
</style>

<main class="container-fluid p-0">
    <section class="volunteer-now-section">
      <div style="position: relative;">
        <div class="row">
          <div class="col">
            <div class="position-relative">
              <img src="images/bgr10.png" class="img-fluid" alt="Background Image" />
              <div class="overlay"></div>
              <div class="overlay-content" style="background-color: rgba(0, 0, 0, 0.5); color: white; text-align: justify;">
                <br><h1 style="text-align: center;">How Help'em Works</h1><br>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  <section class="px-3" style="background-color: #fbfbfb;">
  <div class="row justify-content-center">
    <div class="col mb-4">
      <div class="row text-center">
        <div class="col-md-8 mt-5 mx-auto">
          <h4>What is Help'em ?</h4>
          <p style="text-align: justify;">Help'em is a web-based system that revolutionizes volunteer recruitment and engagement. 
            Organizations effortlessly connect with dedicated volunteers, while volunteers find meaningful opportunities in their community. 
            With streamlined user management and a user-friendly interface, Help'em makes volunteering easy and impactful. 
            Join Help'em today and make a difference in your community. <i class="fa-regular fa-face-grin-stars" style="color: #518cbb;"></i></p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- For Volunteer -->
<section class="px-3" style="background-color: #AAAAAA;">
  <div class="row justify-content-center">
    <div class="col mt-3 mb-2">
      <div class="row text-center">
        <div class="col-md-8 mx-auto">
          <h3>For Volunteer</h3>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="pe-3" style="background-color: #E0E0E0;">
  <div class="row justify-content-center align-items-center">
    <div class="col">
      <div class="row">
        <div class="col-md-6">
          <img src="images/browse.png" class="img-fluid" alt="Browse Image" style="height: 100%;" />
        </div>
        <div class="col-md-6">
          <div class="d-flex flex-column justify-content-center align-items-start h-100">
          <h4 class="text-start">1. Browse</h4>
            <p style="text-align: justify;">
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Browse through the list of available voluntary work. <br>
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Click on the title or image of the voluntary work to read more information about it. <br>
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Find the opportunities that interest you and make a difference in your community. <br>
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Narrow your program search results using filters such as status, name, and task. 
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="ps-4" style="background-color: #E0E0E0;">
  <div class="row justify-content-center align-items-center">
    <div class="col">
      <div class="row">
      <div class="col-md-6 mt-3">
          <div class="d-flex flex-column justify-content-center align-items-start h-100">
          <h4 class="text-start">2. Apply</h4>
            <p style="text-align: justify;">
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Register yourself if you haven't created an account yet. <br>
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>For existing users, simply log in to your account. <br>
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Click on your preferred voluntary work and submit your application. <br>
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Keep an eye on your inbox for updates from the organizers regarding the status of your application. 
            </p>
          </div>
        </div>
        <div class="col-md-6 mt-3">
          <img src="images/apply.png" class="img-fluid" alt="Apply Image" style="height: 100%;" />
        </div>
      </div>
    </div>
  </div>
</section>
<section class="pe-3" style="background-color: #E0E0E0;">
  <div class="row justify-content-center align-items-center">
    <div class="col">
      <div class="row">
        <div class="col-md-6 mt-3">
          <img src="images/take_action.png" class="img-fluid" alt="Take Action Image" style="height: 100%;" />
        </div>
        <div class="col-md-6 mt-3">
          <div class="d-flex flex-column justify-content-center align-items-start h-100">
          <h4 class="text-start">3. Take Action</h4>
            <p style="text-align: justify;">
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Get ready to start volunteering by gathering any necessary information or materials related to the specific volunteer opportunity you've been approved for. <br>
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Reach out to the organizer or contact person provided by Help'em to coordinate and finalize the details of your volunteering schedule, tasks, and any specific requirements. <br>
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Begin your volunteering work according to the agreed-upon schedule and guidelines. <br>
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Don't forget to inquire about any recognition or certificates of appreciation you may receive for your dedicated efforts. <br>
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>If you have any inquiries or need assistance during your volunteering journey, feel free to contact the Help'em administrator. They are available to provide guidance and support throughout the process. <br>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- For Volunteer -->

<!-- For Organizer -->
<section class="px-3" style="background-color: #AAAAAA;">
  <div class="row justify-content-center">
    <div class="col mt-3 mb-2">
      <div class="row text-center">
        <div class="col-md-8 mx-auto">
          <h3>For Organization & Institution</h3>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="ps-4" style="background-color: #E0E0E0;">
  <div class="row justify-content-center align-items-center">
    <div class="col">
      <div class="row">
      <div class="col-md-6">
          <div class="d-flex flex-column justify-content-center align-items-start h-100">
            <h4 class="text-start">1. Register</h4>
            <p style="text-align: justify;">
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Register your organization or institution first if you haven't created any account yet. <br>
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>For existing users, simply log in to your account. <br>
            </p>
          </div>
        </div>
        <div class="col-md-6">
          <img src="images/register.png" class="img-fluid" alt="Register Image" style="height: 100%;" />
        </div>
      </div>
    </div>
  </div>
</section>
<section class="pe-3" style="background-color: #E0E0E0;">
  <div class="row justify-content-center align-items-center">
    <div class="col">
      <div class="row">
        <div class="col-md-6 mt-3">
          <img src="images/advertise.png" class="img-fluid" alt="Advertise Image" style="height: 100%;" />
        </div>
        <div class="col-md-6 mt-3">
          <div class="d-flex flex-column justify-content-center align-items-start h-100">
            <h4 class="text-start">2. Advertise</h4>
            <p style="text-align: justify;">
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Start adding your voluntary work by providing required information regarding on the voluntary work that will be organized. <br>
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Set the status of the voluntary work to - OPEN FOR REGISTRATION to allow the volunteers to apply themselves. <br>
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Change the status of the voluntary work to stop accepting any new application from the volunteers. <br>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="ps-4" style="background-color: #E0E0E0;">
  <div class="row justify-content-center align-items-center">
    <div class="col">
      <div class="row">
      <div class="col-md-6 mt-3">
          <div class="d-flex flex-column justify-content-center align-items-start h-100">
            <h4 class="text-start">3. Recruit</h4>
            <p style="text-align: justify;">
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>View the details of the applicants before recruiting any volunteers for your voluntary work. <br>
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Recruit any preferred volunteers among your applicants for your voluntary work. <br>
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Feel free to reject any volunteer's application. <br>
            </p>
          </div>
        </div>
        <div class="col-md-6 mt-3">
          <img src="images/recruit_bgr.png" class="img-fluid" alt="Recruit Image" style="height: 100%;" />
        </div>
      </div>
    </div>
  </div>
</section>
<section class="pe-3" style="background-color: #E0E0E0;">
  <div class="row justify-content-center align-items-center">
    <div class="col">
      <div class="row">
        <div class="col-md-6 mt-3">
          <img src="images/manage.png" class="img-fluid" alt="Manage Image" style="height: 100%;" />
        </div>
        <div class="col-md-6 mt-3">
          <div class="d-flex flex-column justify-content-center align-items-start h-100">
            <h4 class="text-start">4. Manage</h4>
            <p style="text-align: justify;">
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Manage the application status of your applicants. <br>
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Manage also on the participation status of your volunteers on the day that your voluntary work is organized. <br>
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Alert on the allowance or certification that has been agreed to be given out upon completing the voluntary work. <br>
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Set the status of your voluntary work to - FINISHED to indicate that the voluntary work has been successfully organized. <br>
              <i class="fa-solid fa-circle-check me-3" style="color: #518cbb;"></i>Do not forget to update on the work completion for each of your volunteers. <br>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- For Organizer -->




</main>

<?php
include('includes/footer.php');
?>
