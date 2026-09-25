<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';
$userRole = $isLoggedIn ? $_SESSION['user_role'] : '';

// Load FAQs from database
include_once 'config/database.php';
$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM faqs ORDER BY id ASC";
$stmt = $db->prepare($query);
$stmt->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - HEALTHFORGE</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/contact.css">
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
                <div class="hamburger" id="hamburger">
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
                <h1>Contact Us</h1>
                <p>Get in touch with your trusted Health & Fitness partner!</p>
            </div>
        </section>

        <!-- Contact Content -->
        <section class="contact-content">
            <div class="container">
                <div class="contact-grid">
                    <!-- Contact Form -->
                    <div class="contact-form-section">
                        <h2>Chat With Us Now</h2>
                        <form class="contact-form" id="contact-form">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="first-name">First Name *</label>
                                    <input type="text" id="first-name" name="firstName" required>
                                </div>
                                <div class="form-group">
                                    <label for="last-name">Last Name *</label>
                                    <input type="text" id="last-name" name="lastName" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone">
                            </div>
                            
                            <div class="form-group">
                                <label for="subject">Subject *</label>
                                <select id="subject" name="subject" required>
                                    <option value="">Select a subject</option>
                                    <option value="general">General Information</option>
                                    <option value="product">Product Information</option>
                                    <option value="payment">Payment Information</option>
                                    <option value="shipping">Shipping & Delivery</option>
                                    <option value="feedback">Feedback</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="message">Message *</label>
                                <textarea id="message" name="message" rows="6" placeholder="Tell about us..." required></textarea>
                            </div>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-envelope"></i> Send Message
                            </button>
                        </form>
                    </div>

                    <!-- Contact Information -->
                    <div class="contact-info-section">
                        <h2>Contact / Visit Us Now</h2>
                        
                        <div class="contact-method">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-details">
                                <h3>Visit Us Now</h3>
                                <p>11, Wathhimi Road<br>
                                Kurunegala<br>
                                Sri Lanka</p>
                            </div>
                        </div>

                        <div class="contact-method">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-details">
                                <h3>Call Us</h3>
                                <p>Phone: +94778389933<br>
                                WhatsApp: +947783899333<br></p>
                            </div>
                        </div>

                        <div class="contact-method">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <h3>Email Us</h3>
                                <p>General: <a href="mailto:info@healthforge.com" style="color: #2e8b57; text-decoration: none;">info@healthforge.com</a><br></p>
                            </div>
                        </div>

                        <div class="contact-method">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="contact-details">
                                <h3>Shop Open Times</h3>
                                <p>Monday - Friday: 9:00 AM - 8:00 PM<br>
                                Saturday: 9:00 AM - 3:00 PM<br>
                                Sunday: Closed</p>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="social-section">
                            <h3>Follow Us</h3>
                            <div class="social-links">
                                <a href="#" class="social-link facebook">
                                    <i class="fab fa-facebook-f"></i>
                                    <span>Facebook</span>
                                </a>
                                <a href="#" class="social-link twitter">
                                    <i class="fab fa-twitter"></i>
                                    <span>Twitter</span>
                                </a>
                                <a href="#" class="social-link instagram">
                                    <i class="fab fa-instagram"></i>
                                    <span>Instagram</span>
                                </a>
                                <a href="#" class="social-link linkedin">
                                    <i class="fab fa-linkedin-in"></i>
                                    <span>LinkedIn</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="faq-section" id="faq">
            <div class="container">
                <h2>FAQ'S</h2>
                <div class="faq-grid">
                    <?php if ($stmt->rowCount() > 0): ?>
                        <?php while($faq = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <div class="faq-item">
                            <h3><?php echo htmlspecialchars($faq['question']); ?></h3>
                            <p><?php echo htmlspecialchars($faq['answer']); ?></p>
                        </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="faq-item">
                            <h3>No FAQs Available</h3>
                            <p>Please check back later for frequently asked questions.</p>
                        </div>
                    <?php endif; ?>
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

    <!-- Success Modal -->
    <div class="modal" id="success-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Message Sent Successfully!</h3>
                <span class="close" onclick="closeModal('success-modal')">&times;</span>
            </div>
            <div class="modal-body">
                <div class="success-content">
                    <i class="fas fa-check-circle"></i>
                    <p>Thank you for contacting us! We've received your message and will get back to you.</p>
                    <button class="btn-primary" onclick="closeModal('success-modal')">Close</button>
                </div>
            </div>
        </div>
    </div>

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
                        <button class="btn-                        <button class="btn-primary" id="checkout-btn">Checkout</button>
                    </div>
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
    <script src="js/contact.js"></script>
</body>
</html>