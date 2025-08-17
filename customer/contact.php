<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Project : EAT</title>


  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700&display=swap" rel="stylesheet">

  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <!-- nice select -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha256-mLBIhmBvigTFWPSCtvdu6a76T+3Xyt+K571hupeFLg4=" crossorigin="anonymous" />
  <!-- slidck slider -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha256-UK1EiopXIL+KVhfbFa8xrmAWPeBjMVdvYMYkTAEv/HI=" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css.map" integrity="undefined" crossorigin="anonymous" />


  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />

</head>

<body class="sub_page">

  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand" href="index.php">
            <span>
              Project : EAT
            </span>
          </a>
          <div class="" id="">
            <div class="User_option">
             
            </div>
            <div class="custom_menu-btn">
              <button onclick="openNav()">
                <img src="images/menu.png" alt="">
              </button>
            </div>
            <div id="myNav" class="overlay">
              <div class="overlay-content">
                <a href="index.php">Home</a>
                <a href="about.php">About</a>
                <a href="contact.php">Blog</a>
              </div>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->

  </div>


  <!-- news section -->

  <section class="news_section layout_padding">

    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Contact Us
        </h2>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="map-container">
            <div class="img-box">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3858.7526069185196!2d121.0345630137109!3d14.726574081609233!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b0ff7eb3d621%3A0x437d85420878d598!2sBestlink%20College%20of%20the%20Philippines!5e0!3m2!1sen!2sph!4v1747667736996!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="location-info">
              <h4>
                <i class="fa fa-map-marker" aria-hidden="true"></i> Our Location
              </h4>
              <p>
                123 Food Street, Manila, Philippines
              </p>
              <a href="https://maps.google.com" target="_blank">
                View on Map
              </a>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="contact-info">
            <div class="contact-item">
              <h4>
                <i class="fa fa-envelope" aria-hidden="true"></i> Email Us
              </h4>
              <p>
                Have questions? Send us an email and we'll get back to you as soon as possible.
              </p>
              <a href="mailto:contact@projecteat.com">
                contact@projecteat.com
              </a>
            </div>

            <div class="contact-item">
              <h4>
                <i class="fa fa-phone" aria-hidden="true"></i> Call Us
              </h4>
              <p>
                Need immediate assistance? Give us a call during business hours.
              </p>
              <a href="tel:+639123456789">
                +63 912 345 6789
              </a>
            </div>
          </div>
        </div>
      </div>

      <style>
        .map-container {
          margin-bottom: 30px;
          margin-top: 50px;
        }
        .map-container .img-box {
          height: 300px;
          border-radius: 8px;
          overflow: hidden;
          margin-bottom: 20px;
        }
        .location-info {
          padding: 0 10px;
        }
        .location-info h4 {
          font-size: 1.6em;
          margin-bottom: 15px;
          color: #333;
          display: flex;
          align-items: center;
          gap: 10px;
        }
        .location-info h4 i {
          color: #ff4e45;
        }
        .location-info p {
          margin-bottom: 15px;
          color: #666;
          line-height: 1.6;
          font-size: 1.1em;
        }
        .location-info a {
          color: #ff4e45;
          text-decoration: none;
          font-weight: 500;
          font-size: 1.1em;
          display: inline-block;
          transition: color 0.3s ease;
        }
        .location-info a:hover {
          color: #ff2a20;
        }
        .contact-info {
          padding: 20px;
          margin-top: 30px;
        }
        .contact-item {
          margin-bottom: 40px;
        }
        .contact-item:last-child {
          margin-bottom: 0;
        }
        .contact-item h4 {
          font-size: 1.6em;
          margin-bottom: 15px;
          color: #333;
          display: flex;
          align-items: center;
          gap: 10px;
        }
        .contact-item h4 i {
          color: #ff4e45;
        }
        .contact-item p {
          margin-bottom: 15px;
          color: #666;
          line-height: 1.6;
          font-size: 1.1em;
        }
        .contact-item a {
          color: #ff4e45;
          text-decoration: none;
          font-weight: 500;
          font-size: 1.2em;
          display: inline-block;
          transition: color 0.3s ease;
        }
        .contact-item a:hover {
          color: #ff2a20;
        }
        @media (max-width: 768px) {
          .map-container .img-box {
            height: 250px;
          }
          .contact-info {
            margin-top: 30px;
          }
        }
      </style>
    </div>
  </section>

  <!-- end news section -->


  <div class="footer_container">
    <!-- info section -->
    <section class="info_section ">
      <div class="container">
        <div class="contact_box">
          <a href="">
            <i class="fa fa-map-marker" aria-hidden="true"></i>
          </a>
          <a href="">
            <i class="fa fa-phone" aria-hidden="true"></i>
          </a>
          <a href="">
            <i class="fa fa-envelope" aria-hidden="true"></i>
          </a>
        </div>
        <div class="info_links">
          <ul>
            <li class="active">
              <a href="index.php">
                Home
              </a>
            </li>
            <li>
              <a href="about.php">
                About
              </a>
            </li>
            <li>
              <a class="" href="contact.php">
                Contact
              </a>
            </li>
          </ul>
        </div>
        <div class="social_box">
          <a href="">
            <i class="fa fa-facebook" aria-hidden="true"></i>
          </a>
          <a href="">
            <i class="fa fa-twitter" aria-hidden="true"></i>
          </a>
          <a href="">
            <i class="fa fa-linkedin" aria-hidden="true"></i>
          </a>
        </div>
      </div>
    </section>
    <!-- end info_section -->


    <!-- footer section -->
    <footer class="footer_section">
      <div class="container">
        <p>
          &copy; <span id="displayYear"></span> All Rights Reserved By
          <a href="https://html.design/">Free Html Templates</a><br>
          Distributed By: <a href="https://themewagon.com/">ThemeWagon</a>
        </p>
      </div>
    </footer>
    <!-- footer section -->

  </div>
  <!-- jQery -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.js"></script>
  <!-- slick  slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js"></script>
  <!-- nice select -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js" integrity="sha256-Zr3vByTlMGQhvMfgkQ5BtWRSKBGa2QlspKYJnkjZTmo=" crossorigin="anonymous"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>


</body>

</html>