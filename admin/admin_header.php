<?php
// This should be included in all admin pages AFTER session check
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Admin Dashboard'; ?> - HEALTHFORGE</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <!-- Admin Header -->
    <header class="admin-header">
        <nav class="admin-nav">
            <div class="admin-logo">
                <h1><i class="fas fa-dumbbell"></i> HEALTHFORGE Admin</h1>
            </div>
            <div class="admin-menu">
                <a href="admin.php" class="<?php echo ($current_page == 'overview') ? 'active' : ''; ?>">
                    <i class="fas fa-chart-line"></i> Overview
                </a>
                <a href="admin-users.php" class="<?php echo ($current_page == 'users') ? 'active' : ''; ?>">
                    <i class="fas fa-users"></i> Users
                </a>
                <a href="admin-products.php" class="<?php echo ($current_page == 'products') ? 'active' : ''; ?>">
                    <i class="fas fa-box"></i> Products
                </a>
                <a href="admin-orders.php" class="<?php echo ($current_page == 'orders') ? 'active' : ''; ?>">
                    <i class="fas fa-shopping-cart"></i> Orders
                </a>
                <a href="admin-faq.php" class="<?php echo ($current_page == 'faq') ? 'active' : ''; ?>">
                    <i class="fas fa-question-circle"></i> FAQs
                </a>
            </div>
            <div class="admin-user-info">
                <div class="admin-user-profile">
                    <i class="fas fa-user-shield"></i>
                    <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                </div>
                <a href="../index.php" class="back-to-store">
                    <i class="fas fa-store"></i> Back to Store
                </a>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="admin-container">
