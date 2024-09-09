<?php
session_start(); // Start the session.
$page_title = "Vision, Mission, and Values";
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

  .custom-card {
    height: 270px;
  }

  body {
    overflow-x: hidden;
  }

  .accordion-header {
    background-color: transparent;
    border: none;
    color: white;
    font-weight: bold;
    cursor: pointer;
    font-size: 20px;
    padding: 10px;
    text-align: center;
    width: 100%;
  }

  .accordion-panel {
    display: none;
    overflow: hidden;
  }

  .accordion-content {
    padding: 10px;
    color: whitesmoke;
  }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    // Collapse all accordion items except the first one on page load
    $('.accordion-item:not(:first-child)').removeClass('expanded');
    $('.accordion-content:not(:first-child)').slideUp();

    $('.accordion-header').click(function() {
      // Check if the clicked accordion item is already expanded
      if ($(this).parent().hasClass('expanded')) {
        // Collapse the clicked accordion item
        $(this).parent().removeClass('expanded');
        $(this).next().slideUp();
      } else {
        // Collapse all accordion items
        $('.accordion-item').removeClass('expanded');
        $('.accordion-content').slideUp();

        // Expand the clicked accordion item
        $(this).parent().addClass('expanded');
        $(this).next().slideDown();
      }
    });
  });
</script>


<main class="container-fluid p-0">
  <!-- Who We Are -->
    <section class="volunteer-now-section">
      <div style="position: relative;">
        <div class="row">
          <div class="col">
            <div class="position-relative">
              <img src="images/bgr2.png" class="img-fluid" alt="Background Image" />
              <div class="overlay"></div>
              <div class="overlay-content" style="background-color: rgba(0, 0, 0, 0.5); color: white; text-align: justify;">
                <br><h1 style="text-align: center;">Vision, Mission, and Values</h1><br>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <!-- Who We Are -->
  <br>

  <section class="p-3">
    <div class="row">
      <div class="col-sm-4 mx-auto">
        <div class="card" style="background-color: #7ea5c4; box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);">
          <div class="card-header text-center">
          <img src="images/vision.png" class="p-3 mb-2" height="150" alt="Vision Logo" loading="lazy" style="margin-top: -1px;" />
          </div>
          <div class="card-body">
            <p class="card-text" style="text-align: justify;">To create a world where every individual is empowered to make a positive impact by connecting passionate volunteers with organizations and institutions in need.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="p-3">
    <div class="row">
      <div class="col-sm-8 mx-auto">
        <div class="card" style="background-color: #7ea5c4; box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);">
          <div class="card-header text-center">
            <img src="images/mission.png" class="p-3 mb-2" height="150" alt="Mission Logo" loading="lazy" style="margin-top: -1px;" />
          </div>
          <div class="card-body mx-3">
            <div class="row">
              <div class="col mx-3">
                <h5>Mission 1</h5>
                <p class="card-text" style="text-align: justify;">Connect organizations and institutions with passionate volunteers, streamlining the recruitment process and facilitating impactful collaborations that address pressing social, environmental, and humanitarian challenges.</p>
              </div>
              <div class="col mx-3">
                <h5>Mission 2</h5>
                <p class="card-text" style="text-align: justify;">Empower individuals to actively engage in volunteerism by providing a user-friendly platform that offers a wide range of volunteering opportunities. We aim to inspire and support volunteers in making a positive difference in their communities and beyond.</p>
              </div>
              <div class="col mx-3">
                <h5>Mission 3</h5>
                <p class="card-text" style="text-align: justify;">Leverage technology to create a vibrant and inclusive community where volunteers, organizations, and institutions can connect, collaborate, and amplify their collective impact. We strive to foster a culture of social responsibility and encourage active participation in volunteer activities worldwide.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <br>

  <section class="volunteer-now-section">
  <div style="position: relative;">
    <div class="row">
      <div class="col">
        <div class="position-relative">
          <img src="images/bgr7.png" class="img-fluid" alt="Background Image" />
          <div class="overlay"></div>
          <div class="overlay-content" style="background-color: rgba(0, 0, 0, 0.0); color: white; text-align: justify;">
            <h2 style="text-align: center;">Values</h2><br>
            <div class="accordion">
              <div class="accordion-item" style="background: linear-gradient(rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.3));">
                <button class="accordion-header">Empowerment</button>
                  <div class="accordion-content">
                  We believe in empowering individuals to contribute their time, skills, and passion towards making a difference in their communities. We strive to provide a platform that enables volunteers to explore and engage in opportunities that align with their interests and values.
                  </div>
              </div>
              <div class="accordion-item" style="background: linear-gradient(rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.3));">
                <button class="accordion-header">Accessibility</button>
                  <div class="accordion-content">
                  We are committed to promoting inclusivity and accessibility. Our platform aims to be accessible to individuals from diverse backgrounds, regardless of their location, abilities, or socioeconomic status, ensuring that everyone has equal opportunities to engage in volunteer work.
                  </div>
              </div>
              <div class="accordion-item" style="background: linear-gradient(rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.3));">
                <button class="accordion-header">Integrity</button>
                  <div class="accordion-content">
                  We uphold the highest standards of integrity, transparency, and ethical conduct. We are committed to ensuring that the information and opportunities provided through our platform are accurate, trustworthy, and aligned with the values of our community.
                  </div>
              </div>
              <div class="accordion-item" style="background: linear-gradient(rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.3));">
                <button class="accordion-header">Impact</button>
                  <div class="accordion-content">
                  We are driven by a commitment to creating tangible and meaningful impact. We prioritize opportunities and initiatives that address pressing social, environmental, and humanitarian challenges, aiming to maximize the positive change that can be achieved through volunteering.
                  </div>
              </div>
              <div class="accordion-item" style="background: linear-gradient(rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.3));">
                <button class="accordion-header">Innovation</button>
                  <div class="accordion-content">
                  We embrace innovation and strive to leverage technology to continuously improve the volunteering experience. We are dedicated to staying at the forefront of technological advancements, exploring new possibilities, and adapting to meet the evolving needs of our users.
                  </div>
              </div>
              <div class="accordion-item" style="background: linear-gradient(rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.3));">
                <button class="accordion-header">Collaboration</button>
                  <div class="accordion-content">
                  We value the power of collaboration and understand that sustainable change is best achieved through collective action. We foster a collaborative environment where organizations, institutions, and volunteers can connect, share resources, and work together towards common goals.
                  </div>
              </div>
            </div>
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
