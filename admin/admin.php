<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

include_once '../config/database.php';
include_once '../models/User.php';
include_once '../models/Product.php';
include_once '../models/Order.php';

$database = new Database();
$db = $database->getConnection();

// Get stats
$user = new User($db);
$product = new Product($db);
$order = new Order($db);

// Count users (excluding current admin)
$user_count = $user->getUserCount();

// Count products
$product_count = $product->getProductCount();

// Get order stats (with error handling)
try {
    $order_count = $order->getOrderCount();
    $total_revenue = $order->getTotalRevenue();
    $recent_orders = $order->getRecentOrders(5);
} catch (Exception $e) {
    $order_count = 0;
    $total_revenue = 0;
    $recent_orders = array();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - HEALTHFORGE</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <!-- Admin Header with Red Theme -->
    <header class="admin-header">
        <nav class="admin-nav">
            <div class="admin-logo">
                <h1><i class="fas fa-dumbbell"></i> HEALTHFORGE Admin</h1>
            </div>
            <div class="admin-menu">
                <a href="admin.php" class="active">
                    <i class="fas fa-chart-line"></i> Overview
                </a>
                <a href="admin-users.php">
                    <i class="fas fa-users"></i> Users
                </a>
                <a href="admin-products.php">
                    <i class="fas fa-box"></i> Products
                </a>
                <a href="admin-orders.php">
                    <i class="fas fa-shopping-cart"></i> Orders
                </a>
                <a href="admin-faq.php">
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
        <!-- Page Header -->
        <div class="page-header">
            <h1>Admin Dashboard - Overview</h1>
            <p>Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Users</h3>
                    <p><?php echo $user_count; ?></p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Products</h3>
                    <p><?php echo $product_count; ?></p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Orders</h3>
                    <p><?php echo $order_count; ?></p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Revenue</h3>
                    <p>LKR <?php echo number_format($total_revenue, 2); ?></p>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="content-section">
            <div class="section-header">
                <h2><i class="fas fa-clock"></i> Recent Orders</h2>
            </div>

            <?php if (!empty($recent_orders) && $recent_orders->rowCount() > 0): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $recent_orders->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td>#<?php echo $row['order_number']; ?></td>
                        <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                        <td>LKR <?php echo number_format($row['total_amount'], 2); ?></td>
                        <td>
                            <?php
                            $status = $row['status'];
                            $badge_class = 'badge-info';
                            if ($status === 'completed') $badge_class = 'badge-success';
                            elseif ($status === 'pending') $badge_class = 'badge-warning';
                            elseif ($status === 'cancelled') $badge_class = 'badge-danger';
                            ?>
                            <span class="badge <?php echo $badge_class; ?>">
                                <?php echo ucfirst($status); ?>
                            </span>
                        </td>
                        <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>No orders yet</h3>
                <p>Orders will appear here once customers start placing them</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="../js/admin.js"></script>
</body>
</html>