<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

include_once '../config/database.php';
include_once '../models/Order.php';

$database = new Database();
$db = $database->getConnection();
$order = new Order($db);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $total_amount = $_POST['total_amount'];
    
    if ($order->updateOrder($order_id, $status, '', '', '', '', $total_amount)) {
        $_SESSION['success'] = "Order updated successfully!";
        header("Location: admin-orders.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to update order!";
    }
}

// Get order data
if (!isset($_GET['id'])) {
    header('Location: admin-orders.php');
    exit();
}

$order_id = $_GET['id'];
$order_data = $order->getOrderById($order_id);

if (!$order_data) {
    header('Location: admin-orders.php');
    exit();
}

$page_title = 'Edit Order';
$current_page = 'orders';
include 'admin_header.php';
?>

<!-- Page Header -->
<div class="page-header">
    <h1>Edit Order</h1>
    <p>Update order status and details</p>
</div>

<!-- Display Messages -->
<?php if (isset($_SESSION['error'])): ?>
<div class="alert alert-danger">
    <?php 
    echo $_SESSION['error']; 
    unset($_SESSION['error']);
    ?>
</div>
<?php endif; ?>

<!-- Order Form -->
<div class="content-section">
    <form method="POST" action="update_order.php" style="max-width: 800px;">
        <input type="hidden" name="order_id" value="<?php echo $order_data['id']; ?>">
        
        <div class="form-group">
            <label>Order Number</label>
            <input type="text" value="#<?php echo htmlspecialchars($order_data['order_number']); ?>" class="form-control" disabled>
        </div>
        
        <div class="form-group">
            <label>Customer Name</label>
            <input type="text" value="<?php echo htmlspecialchars($order_data['customer_name']); ?>" class="form-control" disabled>
        </div>
        
        <div class="form-group">
            <label>Customer Email</label>
            <input type="email" value="<?php echo htmlspecialchars($order_data['customer_email']); ?>" class="form-control" disabled>
        </div>
        
        <div class="form-group">
            <label>Total Amount (LKR) *</label>
            <input type="number" step="0.01" name="total_amount" value="<?php echo $order_data['total_amount']; ?>" required class="form-control">
        </div>
        
        <div class="form-group">
            <label>Status *</label>
            <select name="status" required class="form-control">
                <option value="pending" <?php echo $order_data['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                <option value="processing" <?php echo $order_data['status'] === 'processing' ? 'selected' : ''; ?>>Processing</option>
                <option value="completed" <?php echo $order_data['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                <option value="cancelled" <?php echo $order_data['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Order Date</label>
            <input type="text" value="<?php echo date('M d, Y H:i', strtotime($order_data['created_at'])); ?>" class="form-control" disabled>
        </div>
        
        <div class="form-actions" style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Update Order
            </button>
            <button type="button" onclick="window.location.href='admin-orders.php'" class="btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </button>
        </div>
    </form>
</div>

</div> <!-- Close admin-container -->

<script src="../js/admin.js"></script>
</body>
</html>