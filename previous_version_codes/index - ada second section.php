<?php
session_start(); // Start the session.
$page_title = "Help'em";
include('includes/header.php');
?>

</br>
<div class="container-fluid">
  <div align="middle">
    <main class="page_background_colour container-fluid">
      <!-- Carousel wrapper -->
      <div id="carouselMaterialStyle" class="carousel slide carousel-fade" style="width: 100%;" data-mdb-ride="carousel">
        <!-- Indicators -->
        <div class="carousel-indicators">
          <button type="button" data-mdb-target="#carouselMaterialStyle" data-mdb-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-mdb-target="#carouselMaterialStyle" data-mdb-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-mdb-target="#carouselMaterialStyle" data-mdb-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <!-- Inner -->
        <div class="carousel-inner rounded-5 shadow-4-strong" style="height: 100%;">
          <!-- Single item -->
          <div class="carousel-item active">
            <img src="https://cdn.tatlerasia.com/asiatatler/i/sg/2020/06/08185746-marek-okon-twwcqimiumg-unsplash_cover_2000x1125.jpg" class="d-block" style="width: 100%; height: 100%;" alt="Marine Life Conservation" />
            <div class="mask" style="background-color: rgba(0, 0, 0, 0.4)"></div>
            <div class="carousel-caption d-none d-md-block">
              <h5>Marine Life Conservation</h5>
              <p>Protecting marine life habitats</p>
            </div>
          </div>

          <!-- Single item -->
          <div class="carousel-item">
            <img src="https://www.nursinghomeabusecenter.com/wp-content/uploads/2019/11/happy-seniors-nursing-home.png" class="d-block" style="width: 100%; height: 100%;" alt="Nursing and Old Folk's Home" />
            <div class="mask" style="background-color: rgba(0, 0, 0, 0.4)"></div>
            <div class="carousel-caption d-none d-md-block" >
              <h5>Nursing and Old Folk's Home</h5>
              <p>Spending time with them</p>
            </div>
          </div>

          <!-- Single item -->
          <div class="carousel-item">
            <img src="https://assets.nst.com.my/images/articles/floods020922_NSTfield_image_socialmedia.var_1662104392.jpg" class="d-block" style="width: 100%; height: 100%;" alt="Natural Disaster" />
            <div class="mask" style="background-color: rgba(0, 0, 0, 0.4)"></div>
            <div class="carousel-caption d-none d-md-block" >
              <h5>Natural Disasters</h5>
              <p>Helping the flood victims</p>
            </div>
          </div>
        </div>
        <!-- Inner -->

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-mdb-target="#carouselMaterialStyle" data-mdb-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-mdb-target="#carouselMaterialStyle" data-mdb-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
      <!-- Carousel wrapper -->
      <!-- Cards for promotional -->
      </br>
      <section>
        <div class="row row-cols-1 row-cols-md-4 g-4">
          <div class="col">
            <div class="card h-100">
              <img src="https://live-production.wcms.abc-cdn.net.au/09fc4d971d2ae450966dd606be4d3587?impolicy=wcms_crop_resize&cropH=1152&cropW=2048&xPos=0&yPos=417&width=862&height=485" class="card-img-top" alt="Hollywood Sign on The Hill" />
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">
                  This is a longer card with supporting text below as a natural lead-in to
                  additional content. This content is a little bit longer.
                </p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card h-100">
              <img src="https://www.nativebreed.org/wp-content/uploads/2020/01/giant_panda-1024x679.jpg" class="card-img-top" alt="Palm Springs Road" />
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">This is a short card.</p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card h-100">
              <img src="https://images.unsplash.com/photo-1575550959106-5a7defe28b56?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8d2lsZGxpZmV8ZW58MHx8MHx8&w=1000&q=80" class="card-img-top" alt="Los Angeles Skyscrapers" />
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">This is a longer card with supporting text below as a natural lead-in to
                  additional content.</p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card h-100">
              <img src="https://www.kidz-village.ac.th/wp-content/uploads/2020/09/experience-min.jpg" class="card-img-top" alt="Skyscrapers" />
              <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">
                  This is a longer card with supporting text below as a natural lead-in to
                  additional content. This content is a little bit longer.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Cards for promotional -->
      <section>

      </section>
      </br>
  </div>
</div>
</div>
<?php
include('includes/footer.php');
?>