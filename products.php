<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';
$userRole = $isLoggedIn ? $_SESSION['user_role'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products - HEALTHFORGE</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <header class="header">
        <nav class="navbar">
            <div class="nav-container">
                <div class="nav-logo">
                    <h2><a href="index.php" style="color: white; text-decoration: none;"><i class="fas fa-dumbbell"></i> HEALTHFORGE</a></h2>
                </div>
                <div class="nav-menu" id="nav-menu">
                    <a href="index.php" class="nav-link">HOME</a>
                    <a href="products.php" class="nav-link">PRODUCTS</a>
                    <a href="aboutus.php" class="nav-link">ABOUT US</a>
                    <a href="contact.php" class="nav-link">CONTACT US</a>
                </div>
                <div class="nav-actions">
                    <div class="auth-buttons">
                        <button class="cart-btn" id="cart-btn">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-count" id="cart-count">0</span>
                        </button>
                        <?php if (!$isLoggedIn): ?>
                        <button class="btn-login" id="login-btn">Login</button>
                        <button class="btn-signup" id="signup-btn">Sign Up</button>
                        <?php else: ?>
                        <div class="user-profile" id="user-profile">
                            <button class="profile-btn" id="profile-btn">
                                <i class="fas fa-user"></i> <span id="username"><?php echo htmlspecialchars($userName); ?></span>
                            </button>
                            <div class="dropdown-menu" id="profile-dropdown">
                                <?php if ($userRole === 'admin'): ?>
                                <a href="admin/admin.php"><i class="fas fa-user-shield"></i> Admin Panel</a>
                                <?php endif; ?>
                                <a href="#" id="view-profile"><i class="fas fa-user"></i> My Profile</a>
                                <a href="#" id="order-history"><i class="fas fa-history"></i> Order History</a>
                                <a href="#" id="track-orders"><i class="fas fa-truck"></i> Track Orders</a>
                                <a href="#" id="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                        </div>
                    </div>
                </div>
                <div class="hamburger" id="hamburger">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            </div>
        </nav>
    </header>

    <main>
    <!--All Products-->
    <section id="products" class="all-products">
        <div class="container">
            <div class="products-header">
                <h2>All Products</h2>
                <div class="search-box">
                    <input type="text" placeholder="Search products..." id="search-input">
                    <button id="search-btn"><i class="fas fa-search"></i></button>
                </div>
                <div class="filters">
                    <select id="category-filter">
                        <option value="">All Categories</option>
                        <option value="supplement">Supplement & Nutrition</option>
                        <option value="equipment">Gym Equipments & Machines</option>
                        <option value="accessories">Workout Accessories</option>
                        <option value="wellness">Wellness & Recovery Products</option>
                    </select>
                    <select id="price-filter">
                        <option value="">All Prices</option>
                        <option value="0-5000">LKR 0 - 5,000</option>
                        <option value="5000-10000">LKR 5,000 - 10,000</option>
                        <option value="10000-20000">LKR 10,000 - 20,000</option>
                        <option value="20000+">LKR 20,000+</option>
                    </select>
                    <select id="sort-filter">
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                    </select>
                </div>
            </div>
            <div class="products-grid" id="products-grid">
                <!-- Products will be populated by JavaScript -->
            </div>
            <div class="load-more">
                <button class="btn-load-more" id="load-more">Load More Products</button>
            </div>
        </div>
    </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3><i class="fas fa-dumbbell"></i> HEALTHFORGE</h3>
                    <p>Your trusted Health & Fitness products.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="products.php">Products</a></li>
                        <li><a href="aboutus.php">About Us</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Customer Service</h4>
                    <ul>
                        <li><a href="#" id="terms-link">Terms & Conditions</a></li>
                        <li><a href="#" id="privacy-link">Privacy Policy</a></li>
                        <li><a href="#" id="shipping-link">Shipping Info</a></li>
                        <li><a href="contact.php#faq" id="faq-link">FAQs</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact Info</h4>
                    <div class="contact-info">
                        <p><i class="fas fa-envelope"></i> <a href="mailto:info@healthforge.com" style="color: inherit; text-decoration: none;">info@healthforge.com</a></p>
                        <p><i class="fas fa-phone"></i> +94778389933</p>
                        <p><i class="fas fa-map-marker-alt"></i> 11, Wathhimi Road, Kurunegala</p>
                        <p><i class="fas fa-clock"></i>24 / 7 Shopping</p>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 HEALTHFORGE. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Modals -->
    <!-- Login Modal -->
    <div class="modal" id="login-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Login to HEALTHFORGE</h3>
                <span class="close" id="close-login">&times;</span>
            </div>
            <div class="modal-body">
                <form id="login-form">
                    <div class="form-group">
                        <label for="login-email">Email:</label>
                        <input type="email" id="login-email" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password:</label>
                        <input type="password" id="login-password" required>
                    </div>
                    <button type="submit" class="btn-primary">Login</button>
                    <p class="switch-form">Don't have an account? <a href="#" id="switch-to-signup">Sign up</a></p>
                </form>
            </div>
        </div>
    </div>

    <!-- Signup Modal -->
    <div class="modal" id="signup-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Join HEALTHFORGE</h3>
                <span class="close" id="close-signup">&times;</span>
            </div>
            <div class="modal-body">
                <form id="signup-form">
                    <div class="form-group">
                        <label for="signup-name">Full Name:</label>
                        <input type="text" id="signup-name" required>
                    </div>
                    <div class="form-group">
                        <label for="signup-email">Email:</label>
                        <input type="email" id="signup-email" required>
                    </div>
                    <div class="form-group">
                        <label for="signup-password">Password:</label>
                        <input type="password" id="signup-password" required>
                    </div>
                    <div class="form-group">
                        <label for="signup-confirm">Confirm Password:</label>
                        <input type="password" id="signup-confirm" required>
                    </div>
                    <button type="submit" class="btn-primary">Sign Up</button>
                    <p class="switch-form">Already have an account? <a href="#" id="switch-to-login">Login</a></p>
                </form>
            </div>
        </div>
    </div>

    <!-- Cart Modal -->
    <div class="modal" id="cart-modal">
        <div class="modal-content cart-modal-content">
            <div class="modal-header">
                <h3>Shopping Cart</h3>
                <span class="close" id="close-cart">&times;</span>
            </div>
            <div class="modal-body">
                <div id="cart-items">
                    <!-- Cart items will be populated by JavaScript -->
                </div>
                <div class="cart-summary">
                    <div class="cart-total">
                        <strong>Total: LKR <span id="cart-total">0</span></strong>
                    </div>
                    <div class="cart-actions">
                        <button class="btn-secondary" id="clear-cart">Clear Cart</button>
                        <button class="btn-primary" id="checkout-btn">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Detail Modal -->
    <div class="modal" id="product-modal">
        <div class="modal-content product-modal-content">
            <div class="modal-header">
                <span class="close" id="close-product">&times;</span>
            </div>
            <div class="modal-body" id="product-detail">
                <!-- Product details will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <script>
        // Pass PHP session data to JavaScript
        <?php if ($isLoggedIn): ?>
        window.currentUserFromPHP = {
            id: <?php echo $_SESSION['user_id']; ?>,
            name: '<?php echo addslashes($userName); ?>',
            email: '<?php echo addslashes($_SESSION['user_email']); ?>',
            role: '<?php echo addslashes($userRole); ?>'
        };
        <?php else: ?>
        window.currentUserFromPHP = null;
        <?php endif; ?>
    </script>
    <script src="js/app.js"></script>
    <script src="js/app_fixes.js"></script>
</body>
</html>