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
    <title>About Us - HEALTHFORGE</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/aboutus.css">
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
                <div class="hamburger"
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main style="margin-top: 80px;">
        <!-- Hero Section -->
        <section class="page-hero">
            <div class="container">
                <h1>About HEALTHFORGE</h1>
                <p>Your trusted partner in Health & Fitness products</p>
            </div>
        </section>

        <!-- About Content -->
        <section class="about-content">
            <div class="container">
                <div class="about-grid">
                    <div class="about-text">
                        <h2>Our Mission</h2>
                        <p>To revolutionize the health and fitness industry in Sri Lanka by creating an accessible, reliable, and comprehensive online marketplace that connects fitness enthusiasts with premium quality products, expert guidance, and a supportive community to achieve their wellness goals.</p>
                        
                        <p>While others sell products, we build fitness journeys. While others focus on profit, we focus on genuine health transformation for Sri Lanka.</p>

                        <h3>What Makes Us Different from Others</h3>
                        <ul class="feature-list">
                            <li><i class="fas fa-check-circle"></i> Expert Product Curation & Authentication</li>
                            <li><i class="fas fa-check-circle"></i> Education-First Approach</li>
                            <li><i class="fas fa-check-circle"></i> Complete Beginner to Pro Journey</li>
                            <li><i class="fas fa-check-circle"></i> Transparent Pricing & Value Guarantee</li>
                            <li><i class="fas fa-check-circle"></i> Same-Day Delivery in Major Cities</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Values Section -->
        <section class="values">
            <div class="container">
                <h2>Our Values</h2>
                <div class="values-grid">
                    <div class="value-card">
                        <i class="fas fa-certificate"></i>
                        <h3>Quality & Authenticity First</h3>
                        <p>Every product we sell is personally verified, tested, and guaranteed authentic. We never compromise on quality - your health and results matter more than our profits.</p>
                    </div>
                    <div class="value-card">
                        <i class="fas fa-bolt"></i>
                        <h3>Speed & Reliability</h3>
                        <p>Fast delivery, quick customer support, and dependable service you can count on when you need it most.</p>
                    </div>
                    <div class="value-card">
                        <i class="fas fa-handshake"></i>
                        <h3>Transparency & Trust</h3>
                        <p>No hidden fees, no misleading claims, no false promises. We believe in honest business practices and building trust through transparency in everything we do.</p>
                    </div>
                    <div class="value-card">
                        <i class="fas fa-recycle"></i>
                        <h3>Eco-Friendly Packaging</h3>
                        <p>Biodegradable and recyclable packaging materials for all shipments.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Impact Section -->
        <section class="impact">
            <div class="container">
                <h2>Currently,</h2>
                <div class="impact-stats">
                    <div class="stat-card">
                        <div class="stat-number">1000+</div>
                        <div class="stat-label">Happy Customers</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">100+</div>
                        <div class="stat-label">Products</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="team">
            <div class="container">
                <h2>Meet Our Team</h2>
                <div class="team-grid">
                    <div class="team-member">
                        <div class="member-image">
                            <i class="fas fa-user-circle fa-5x"></i>
                        </div>
                        <h3>M.R.AHAMED</h3>
                        <p class="member-role">Founder & CEO</p>
                        <p>IT student with entrepreneurial vision for Sri Lankan fitness market.</p>
                    </div>
                    <div class="team-member">
                        <div class="member-image">
                            <i class="fas fa-user-circle fa-5x"></i>
                        </div>
                        <h3>Mohomed Aazim</h3>
                        <p class="member-role">Technology Lead</p>
                        <p>Full-stack developer specializing in e-commerce solutions.</p>
                    </div>
                    <div class="team-member">
                        <div class="member-image">
                            <i class="fas fa-user-circle fa-5x"></i>
                        </div>
                        <h3>Chanuka Jayasundara</h3>
                        <p class="member-role">Chief product officer</p>
                        <p>Certified fitness trainer with supplement and equipment expertise.</p>
                    </div>
                    <div class="team-member">
                        <div class="member-image">
                            <i class="fas fa-user-circle fa-5x"></i>
                        </div>
                        <h3>Themiya Abeykoon</h3>
                        <p class="member-role">Chief Medical officer</p>
                        <p>Medical doctor specializing in Sports Medicine with 5+ years of experience in athlete nutrition and supplement research in tropical climates.</p>
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