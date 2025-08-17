<?php
include 'connection.php';

// Get stall_id from URL
$stall_id = isset($_GET['stall_id']) ? (int) $_GET['stall_id'] : 0;

// Fetch stall details
$stall_query = "SELECT name FROM stall WHERE id = ?";
$stall_stmt = $conn->prepare($stall_query);
$stall_stmt->bind_param("i", $stall_id);
$stall_stmt->execute();
$stall_result = $stall_stmt->get_result();
$stall = $stall_result->fetch_assoc();

// If stall not found, display an error
if (!$stall) {
    die("Error: Stall not found.");
}

// Fetch menu items for this stall
$item_query = "SELECT id, name, price, image, item_category FROM item WHERE stall_id = ?";
$item_stmt = $conn->prepare($item_query);
$item_stmt->bind_param("i", $stall_id);
$item_stmt->execute();
$item_result = $item_stmt->get_result();
?>



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

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
                <img src="../uploads/" alt="">
              </button>
            </div>
            <div id="myNav" class="overlay">
              <div class="overlay-content">
                <a href="index.html">Home</a>
                <a href="about.html">About</a>
                <a href="blog.html">Blog</a>
                <a href="testimonial.html">Testimonial</a>
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
                </div>
            </div>
        </div>
      </div>
    </header>
    <!-- end header section -->
  </div>

  

  <section class="food_section layout_padding">
    <div class="container">
      <div class="text-start mb-4">
        <a href="stalls.php" class="btn btn-secondary">
          <i class="fa fa-arrow-left" aria-hidden="true"></i>
        </a>
      </div>
      <div class="heading_container heading_center">
        <h2>
          <?php echo htmlspecialchars($stall['name']); ?> Menu
        </h2>
      </div>
      
      <div style="height: 32px;"></div>

      <div class="row">
          <div class="col-md-3 mb-4">
              <!-- Search Box -->
              <div class="mb-4">
                  <input type="text" class="form-control" id="searchInput" placeholder="Search menu items...">
              </div>
              <!-- Sidebar: Food Categories -->
              <div class="list-group" id="category-list">
                  <button class="list-group-item list-group-item-action active" data-category="all">All</button>
                  <button class="list-group-item list-group-item-action" data-category="Rice Meals">Rice Meals</button>
                  <button class="list-group-item list-group-item-action" data-category="Snacks">Snacks</button>
                  <button class="list-group-item list-group-item-action" data-category="Beverages">Beverages</button>
                  <button class="list-group-item list-group-item-action" data-category="Desserts">Desserts</button>
                  <button class="list-group-item list-group-item-action" data-category="Noodles/Pasta">Noodles/Pasta</button>
                  <button class="list-group-item list-group-item-action" data-category="Sandwiches/Burgers">Sandwiches/Burgers</button>
                  <button class="list-group-item list-group-item-action" data-category="Vegetarian">Vegetarian</button>
                  <button class="list-group-item list-group-item-action" data-category="Combo Meals">Combo Meals</button>
                  <button class="list-group-item list-group-item-action" data-category="Breakfast">Breakfast</button>
                  <button class="list-group-item list-group-item-action" data-category="Others">Others</button>

                  
                  
              </div>
          </div>

          <div class="col-md-9">
              <div class="row" id="menu-items">
                  <?php while ($item = $item_result->fetch_assoc()): ?>
                      <div class="col-md-4 mb-4 menu-item" data-category="<?= htmlspecialchars($item['item_category']) ?>" data-name="<?= htmlspecialchars($item['name']) ?>" data-price="<?= $item['price'] ?>">
                          <div class="card h-100 text-center">
                              <img src="uploads/item/<?= htmlspecialchars($item['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['name']) ?>">
                              <div class="card-body">
                                  <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
                                  <p class="card-text">₱<?= number_format($item['price'], 2) ?></p>
                                  <div class="d-flex justify-content-center align-items-center menu-controls">
                                      <button class="btn btn-primary btn-sm add-to-cart" data-name="<?= htmlspecialchars($item['name']) ?>" data-price="<?= $item['price'] ?>">Add </button>
                                      <span class="mx-2 item-qty" style="display:none;"> 0</span>
                                      <button class="btn btn-danger btn-sm remove-from-cart ms-2" data-name="<?= htmlspecialchars($item['name']) ?>" style="display:none;">-</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                  <?php endwhile; ?>
              </div>
          </div>

          

      </div>
    </div>
  </section>

  <!-- Cart Modal -->
  <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="cartModalLabel">Your Cart</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <table class="table table-bordered" id="cart-table">
                      <thead>
                          <tr>
                              <th>Item</th>
                              <th>Qty</th>
                              <th>Price</th>
                              <th>Total</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody></tbody>
                  </table>
                  <div class="text-end">
                      <strong>Total: ₱<span id="cart-grand-total">0</span></strong>
                  </div>
              </div>
  <div class="modal-footer">
      <button class="btn btn-danger" id="clear-cart">Clear Cart</button>
      <button class="btn btn-primary" id="checkout-btn" data-stall-id="<?php echo $stall_id; ?>">Checkout</button>
  </div>
          </div>
      </div>
  </div>



    <!-- about section -->



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
              <a href="index.html">
                Home
              </a>
            </li>
            <li>
              <a href="about.html">
                About
              </a>
            </li>
            <li>
              <a class="" href="blog.html">
                Blog
              </a>
            </li>
            <li>
              <a class="" href="testimonial.html">
                Testimonial
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
  <script src="js/bootstrap.js"></script>
  <!-- slick  slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js"></script>
  <!-- nice select -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js" integrity="sha256-Zr3vByTlMGQhvMfgkQ5BtWRSKBGa2QlspKYJnkjZTmo=" crossorigin="anonymous"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="js/cart.js"></script>
  
  <!-- Search Functionality -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('searchInput');
      const menuItems = document.querySelectorAll('.menu-item');

      searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        menuItems.forEach(item => {
          const itemName = item.dataset.name.toLowerCase();
          const itemCategory = item.dataset.category.toLowerCase();
          
          if (itemName.includes(searchTerm) || itemCategory.includes(searchTerm)) {
            item.style.display = '';
          } else {
            item.style.display = 'none';
          }
        });
      });
    });
  </script>
</body>

</html>