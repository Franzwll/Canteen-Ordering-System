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
    <header class="header_section" > 
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg custom_nav-container">
      <a class="navbar-brand" href="index.php">
        <span>
          Project : EAT
        </span>
      </a>
      <div class="" id="">
        <div class="User_option">
            <button type="button" class="btn btn-outline-light position-relative" data-bs-toggle="modal" data-bs-target="#allCartsModal">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                <span>My Carts</span>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="all-carts-count" style="display: none;">
                    0
                </span>
            </button>
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
            <a href="contact.php">Contact</a>
          </div>
        </div>
      </div>
    </nav>
    
    <!-- All Carts Modal -->
    <div class="modal fade" id="allCartsModal" tabindex="-1" aria-labelledby="allCartsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="allCartsModalLabel">My Shopping Carts</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="stallCarts">
                        <!-- Stall carts will be inserted here dynamically -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
  </div>
</header>
    <!-- end header section -->
  </div>


  <!-- about section -->

  <?php
include 'connection.php'; // Include the database connection

$sql = "SELECT id, name, image FROM stall";
$result = $conn->query($sql);
?>

<section class="food_section layout_padding">
    <div class="container">
      <a href="index.php" class="btn btn-secondary">
          <i class="fa fa-arrow-left" aria-hidden="true"></i>
        </a>
      <div class="heading_container heading_center">
        <h2>
          Our Stalls
        </h2>
      </div>
      
      <!-- Search Box -->
      <div class="row justify-content-center mb-4 mt-4">
        <div class="col-md-6">
          <input type="text" class="form-control" id="searchInput" placeholder="Search stalls...">
        </div>
      </div>

      <div class="row" id="stalls-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4 stall-item" data-name="<?= htmlspecialchars($row['name']) ?>">
                    <div class="card h-100">
                        <img src="uploads/stall/<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['name']) ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
                            <a href="viewmenu.php?stall_id=<?= $row['id'] ?>" class="btn btn-primary">View Menu</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">No stalls available at the moment.</p>
        <?php endif; ?>
      </div>
      <!-- No Results Message -->
      <div id="noResults" class="text-center mt-4" style="display: none;">
        <p>No stalls found matching your search.</p>
      </div>
    </div>
</section>

<?php
$conn->close(); // Close the database connection
?>


  <!-- end about section -->

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
                Contact Us
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
    <div class="container" ></div>
      <p style="display: none;">
          &copy; <span id="displayYear"></span> All Rights Reserved By
          <a href="https://html.design/">Free Html sTemplate</a><br>
          Distributed By: <a href="https://themewagon.com/">ThemeWagon</a>
      </p>
    </div>
  </footer>
    <!-- footer section -->

  </div>
  <!-- jQery -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- bootstrap js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <!-- slick  slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js"></script>
  <!-- nice select -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js" integrity="sha256-Zr3vByTlMGQhvMfgkQ5BtWRSKBGa2QlspKYJnkjZTmo=" crossorigin="anonymous"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>
  <script src="js/cart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Initialize cart when page loads
    document.addEventListener('DOMContentLoaded', function() {
        initializeStallCarts();
        updateAllCartCounts();
        
        // Add event listener for cart modal
        const allCartsModal = document.getElementById('allCartsModal');
        if (allCartsModal) {
            allCartsModal.addEventListener('show.bs.modal', function () {
                updateAllCartsModal();
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('searchInput');
      const stallItems = document.querySelectorAll('.stall-item');
      const noResults = document.getElementById('noResults');

      searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        let hasVisibleItems = false;

        stallItems.forEach(item => {
          const stallName = item.dataset.name.toLowerCase();
          
          if (stallName.includes(searchTerm)) {
            item.style.display = '';
            hasVisibleItems = true;
          } else {
            item.style.display = 'none';
          }
        });

        // Show/hide no results message
        noResults.style.display = hasVisibleItems ? 'none' : 'block';
      });
    });
  </script>
</body>

</html>