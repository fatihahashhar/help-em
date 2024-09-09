<?php
session_start(); // Start the session.
$page_title = "Our Policies";
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
    height: 190px;
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
              <img src="images/bgr3.png" class="img-fluid" alt="Background Image" />
              <div class="overlay"></div>
              <div class="overlay-content" style="background-color: rgba(0, 0, 0, 0.5); color: white; text-align: justify;">
                <br><h1 style="text-align: center;">Our Policies</h1><br>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <!-- Our Policies -->
  <br>

  <section class="px-3">
  <div class="row">
    <div class="col-md-6 mb-3">
      <div class="card bg-light custom-card" style="box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);">
        <div class="row">
          <div class="col-md-4 mt-3">
            <img src="images/feedback.png" class="img-fluid" alt="Empower Image" style="width: 190px;" />
          </div>
          <div class="col-md-8 my-3">
            <h5>Feedback and Dispute Resolution</h5>
            <p class="card-text text-justify">This policy explains how users can provide feedback, report issues, or resolve disputes related to their experience on the Help'em website. It may outline the process for submitting feedback, reporting concerns, and seeking assistance in resolving conflicts.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="card bg-light custom-card" style="box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);">
        <div class="row">
          <div class="col-md-4 mt-3">
            <img src="images/guideline.png" class="img-fluid" alt="Empower Image" style="width: 190px;" />
          </div>
          <div class="col-md-8 my-3">
            <h5>Volunteer and Organization Guidelines</h5>
            <p class="card-text text-justify">These guidelines outline the expectations and responsibilities for volunteers and organizations using the Help'em platform. It may include guidelines on appropriate behavior, respect, confidentiality, and compliance with relevant laws and regulations.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 mb-3">
      <div class="card bg-light custom-card" style="box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);">
        <div class="row">
          <div class="col-md-4 mt-3">
            <img src="images/privacy_policy.png" class="img-fluid" alt="Empower Image" style="width: 190px;" />
          </div>
          <div class="col-md-8 my-3">
            <h5>Privacy Policy</h5>
            <p class="card-text text-justify">This policy outlines how Help'em collects, uses, stores, and protects the personal information of users. It specifies the types of data collected, the purpose of data collection, and the measures taken to ensure data security and confidentiality.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="card bg-light custom-card" style="box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);">
        <div class="row">
          <div class="col-md-4 mt-3">
            <img src="images/safety_security.png" class="img-fluid" alt="Empower Image" style="width: 190px;" />
          </div>
          <div class="col-md-8 my-3">
          <h5>Safety and Security Policy</h5>
            <p class="card-text text-justify">This policy focuses on the safety and security measures in place to protect both volunteers and organizations. It may cover topics such as volunteer screening, background checks, reporting mechanisms for any concerns or incidents, and guidelines for safe interactions.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 mb-3">
      <div class="card bg-light custom-card" style="box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);">
        <div class="row">
          <div class="col-md-4 mt-3">
            <img src="images/terms_of_service.png" class="img-fluid" alt="Empower Image" style="width: 190px;" />
          </div>
          <div class="col-md-8 my-3">
          <h5>Terms of Service</h5>
            <p class="card-text text-justify">The Terms of Service define the rules and guidelines for using the Help'em website. It covers aspects such as user responsibilities, prohibited activities, intellectual property rights, and limitations of liability. It also clarifies the relationship between Help'em and the users of the platform.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-3">
      <div class="card bg-light custom-card" style="box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);">
        <div class="row">
          <div class="col-md-4 mt-3">
            <img src="images/user_contribution.png" class="img-fluid" alt="Empower Image" style="width: 190px;" />
          </div>
          <div class="col-md-8 my-3">
          <h5>Content and User Contributions</h5>
            <p class="card-text text-justify">This policy clarifies the rules and guidelines regarding user-generated content on the Help'em platform. It may include guidelines on acceptable content, moderation processes, intellectual property rights, and consequences for violating the content policy.</p>
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
