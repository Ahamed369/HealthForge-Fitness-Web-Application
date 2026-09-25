<?php
session_start();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';
$userRole = $isLoggedIn ? $_SESSION['user_role'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTHFORGE - Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

   <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <div class="nav-container">
                <div class="nav-logo">
                    <h2><a href="index.php" style="color: white; text-decoration: none;"><i class="fas fa-dumbbell"></i> HEALTHFORGE</a></h2>
                </div>
                <div class="nav-menu" id="nav-menu">
                    <a href="index.php" class="nav-link active">HOME</a>
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
                <div class="hamburger" id="hamburger">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section id="home" class="hero">
            <div class="hero-content">
                <h1>Your One-Stop Shop for all Health & Fitness Products</h1>
                <button class="cta-button" onclick="window.location.href='products.php'">Explore Now</button>
                <p>Discover all types of Health & Fitness products</p>
            </div>
        </section>

        <!-- Featured Products-->
        <section id="featured" class="featured-products">
            <div class="container">
                <h2>Featured Products</h2>
                <div class="products-grid" id="featured-grid">
                    <!--Featured products will be populated by JavaScript -->
                </div>
            </div>
        </section>

     <!-- Categories -->
        <section class="categories">
            <div class="container">
                <h2>Shop by Category</h2>
                <div class="categories-grid">
                    <div class="category-card" data-category="supplement">
                        <i class="fas fa-prescription-bottle-alt"></i>
                        <h3>Supplements & Nutrition</h3>
                        <p>Protien Powders | Vitamins & Minerals</p>
                    </div>
                    <div class="category-card" data-category="equipment">
                        <i class="fas fa-dumbbell"></i>
                        <h3>Gym Equipments & Machines</h3>
                        <p>Weights | Other Equipments</p>
                    </div>
                    <div class="category-card" data-category="accessories">
                        <i class="fas fa-bolt"></i>
                        <h3>Workout Accessories</h3>
                        <p>Training Accessories | Workout footwear & clothing</p>
                    </div>
                    <div class="category-card" data-category="wellness">
                        <i class="fas fa-spa"></i>
                        <h3>Wellness & Recovery Products</h3>
                        <p>Yoga Equipments | Tools</p>
                    </div>
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
                        <p><i class="fas fa-envelope"></i> info@healthforge.com</p>
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

    <!-- Login -->
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

    <!-- Signup -->
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

    <!-- Cart -->
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

    <!--Product Detail -->
    <div class="modal" id="product-modal">
        <div class="modal-content product-modal-content">
            <div class="modal-header">
                <span class="close" id="close-product">&times;</span>
            </div>
            <div class="modal-body" id="product-detail">
            </div>
        </div>
    </div>
    <!-- Profile Modal -->
    <div class="modal" id="profile-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-user"></i> My Profile</h3>
                <span class="close" onclick="closeModal('profile-modal')">&times;</span>
            </div>
            <div class="modal-body">
                <div class="profile-info">
                    <div class="profile-item">
                        <label><i class="fas fa-user"></i> Name:</label>
                        <p id="profile-name"><?php echo htmlspecialchars($userName); ?></p>
                    </div>
                    <div class="profile-item">
                        <label><i class="fas fa-envelope"></i> Email:</label>
                        <p id="profile-email"><?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : ''; ?></p>
                    </div>
                    <div class="profile-item">
                        <label><i class="fas fa-shield-alt"></i> Role:</label>
                        <p id="profile-role"><?php echo ucfirst($userRole); ?></p>
                    </div>
                    <div class="profile-item">
                        <label><i class="fas fa-calendar"></i> Member Since:</label>
                        <p id="profile-joined">-</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order History Modal -->
    <div class="modal" id="order-history-modal">
        <div class="modal-content" style="max-width: 800px;">
            <div class="modal-header">
                <h3><i class="fas fa-history"></i> Order History</h3>
                <span class="close" onclick="closeModal('order-history-modal')">&times;</span>
            </div>
            <div class="modal-body">
                <div id="order-history-content">
                    <p style="text-align: center; padding: 40px; color: #666;">Loading your orders...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Track Orders Modal -->
    <div class="modal" id="track-orders-modal">
        <div class="modal-content" style="max-width: 800px;">
            <div class="modal-header">
                <h3><i class="fas fa-truck"></i> Track Your Orders</h3>
                <span class="close" onclick="closeModal('track-orders-modal')">&times;</span>
            </div>
            <div class="modal-body">
                <div id="track-orders-content">
                    <p style="text-align: center; padding: 40px; color: #666;">Loading tracking information...</p>
                </div>
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
</body>
</html>