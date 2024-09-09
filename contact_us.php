<?php
session_start(); // Start the session.
$page_title = "Contact Us";
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
    background-color: rgba(0, 0, 0, 0.7); 
  }

  .overlay-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: #fff;
    width: 80%;
    max-width: 900px;
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

  h5 {
    color: #518cbb;
  }
</style>

<main class="container-fluid p-0">
  <!-- Who We Are -->
    <section class="volunteer-now-section">
      <div style="position: relative;">
        <div class="row">
          <div class="col">
            <div class="position-relative">
              <img src="images/bgr4.png" class="img-fluid" alt="Background Image" />
              <div class="overlay"></div>
              <div class="overlay-content" style="background-color: rgba(0, 0, 0, 0.5); color: white; text-align: justify;">
                <br><h1 style="text-align: center;">Contact Us</h1><br>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <!-- Who We Are -->
  <br>

  <section class="px-4">
  <div class="row">
    <div class="col-md-4 mb-4">
      <div class="card bg-light custom-card d-flex flex-column" style="box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);">
        <div class="m-4 text-center justify-content-center align-items-center">
          <img src="images/cai.png" class="mb-3" height="130" alt="Our Aim Logo" loading="lazy" />
        </div>
        <div class="row">
          <div class="col-md-12 mb-3 mx-3">
            <h5><i class="fa-solid fa-map-location-dot me-3"></i>Address</h5>
            <p class="card-text text-justify">Universiti Kuala Lumpur (UNIKL) Malaysian Institute of Information Technology (MIIT), <br>1016, Jln Sultan Ismail, Bandar Wawasan, 50250 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 m-3">
            <h5><i class="fas fa-phone me-3"></i>Phone Number</h5>
            <p class="card-text text-justify"> +603 4212 8515 [9am - 6pm]</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 m-3">
            <h5><i class="fa-brands fa-whatsapp me-3"></i>Whatsapp</h5>
            <p class="card-text text-justify">+614 502 4250 [9am - 6pm]</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 m-3">
            <h5><i class="fa-solid fa-at me-3"></i>Email</h5>
            <p class="card-text text-justify">helpem.malaysia@gmail.com</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 m-3">
            <h5><i class="fa-solid fa-globe me-3"></i>Website</h5>
            <p class="card-text text-justify">helpem.com.my</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-8 mb-4">
      <div class="card bg-light custom-card d-flex flex-column" style="box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);">
        <div class="m-4 text-center justify-content-center align-items-center">
          <img src="images/ch.png" class="mb-3" height="130" alt="Our Aim Logo" loading="lazy" />
        </div>
        <div class="row">
          <div class="col-md-12 mb-3 mx-3">
            <p class="card-text text-justify">At Help'em, we strive to provide a seamless and satisfactory experience for all users of our platform. However, we understand that concerns or issues may arise from time to time. We take complaints seriously and are committed to addressing them promptly and fairly. Our complaint handling process is designed to ensure that all complaints are handled in a transparent and efficient manner.</p>
            <hr>
            <h5>Submitting a Complaint:</h5>
            <p class="card-text text-justify">To submit a complaint, email <a href="mailto:helpem.malaysia@gmail.com">us </a> or use the online complaint form on our website. Please provide detailed information, including dates, names, and supporting documents.</p>
            <h5>Timelines and Response:</h5>
            <p class="card-text text-justify">We'll acknowledge your complaint within [5] business days and aim to provide a substantive response within [5] business days. We'll keep you updated on the progress if additional time is needed.</p>
            <h5>Investigation and Confidentiality:</h5>
            <p class="card-text text-justify">We'll conduct a thorough investigation, respecting the confidentiality of your complaint and involving only relevant individuals. Anonymous complaints are accepted, although it may limit our ability to address concerns fully.</p>
            <h5>Escalation Process:</h5>
            <p class="card-text text-justify">If you're unsatisfied with the resolution, you can escalate your complaint by contacting us via <a href="mailto:helpem.malaysia@gmail.com">our email </a>. Our designated supervisor will conduct an additional investigation and provide a final resolution.</p>
            <h5>Resolution and Follow-up:</h5>
            <p class="card-text text-justify">We'll promptly communicate the outcome and, if necessary, take corrective actions to prevent recurrence. Your feedback helps us continually improve our services and user experience.</p>
            <h5>External Mediation or Arbitration:</h5>
            <p class="card-text text-justify">If a satisfactory resolution cannot be achieved internally, you may explore external mediation or arbitration options.</p>
            <hr>
            <p class="card-text text-justify">We value your trust and appreciate your feedback. For questions or further assistance, contact our Complaints Department at <a href="mailto:helpem.malaysia@gmail.com">this email</a>.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="volunteer-now-section">
  <div style="position: relative;">
    <div class="row">
      <div class="col">
        <div class="position-relative">
          <img src="images/bgr8.png" class="img-fluid" alt="Background Image" />
          <div class="overlay"></div>
          <div class="overlay-content" style="background-color: rgba(255, 255, 255, 0.3); color: white; text-align: start; display: flex; align-items: center;">
            <div class="mx-4">
              <h3 style="margin-right: 20px;">Get In Touch</h3>
              <p class="card-text text-start">Have a little something you wanna talk to us about? Well give us a ring, send us an email, or fill out the form beside.</p>
            </div>
            <div class="row justify-content-center">
              <form action="mailto:helpem.malaysia@gmail.com" class="p-4" method="post" enctype="text/plain">
                <div class="form-group mb-3 mx-3">
                  <input type="text" class="form-control" placeholder="Name" aria-label="Name" id="name" name="name" style="width: 450px;" required>
                </div>
                <div class="form-group m-3">
                  <input type="text" class="form-control" placeholder="Subject" aria-label="Subject" id="subject" name="subject" style="width: 450px;" required>
                </div>
                <div class="form-group m-3">
                  <textarea required class="form-control" placeholder="Message" aria-label="Message" id="message" rows="7" name="message" style="width: 450px;" size="500" maxlength="500"></textarea>
                </div>
                <div align="right">
                  <input style="background-color: #518cbb;" class="btn btn-primary btn-lg col-sm-3 mt-3 me-4" type="submit" name="submit" value="Send" />
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<script>
  // Get the name input element
  const nameInput = document.getElementById('name');
  // Get the subject input element
  const subjectInput = document.getElementById('subject');
  // Get the message input element
  const messageInput = document.getElementById('message');
  // Get the form element
  const form = document.querySelector('form');

  // Add an event listener to the form submission
  form.addEventListener('submit', function(event) {
    // Get the value of the name input
    const nameValue = nameInput.value;
    // Get the value of the subject input
    const subjectValue = subjectInput.value;
    // Get the value of the message input
    const messageValue = messageInput.value;

    // Set the action of the form to the email platform with the subject and body
    form.setAttribute('action', `mailto:helpem.malaysia@gmail.com?subject=${encodeURIComponent(subjectValue + ' - Help\'em Concerns')}&body=${encodeURIComponent(`NAME: ${nameValue}\n\nMESSAGE: ${messageValue}\n`)}`);
  });
</script>






</main>

<?php
include('includes/footer.php');
?>
