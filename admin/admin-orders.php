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

try {
    $orders = $order->getAllOrders();
} catch (Exception $e) {
    $orders = null;
}

$page_title = 'Order Management';
$current_page = 'orders';
include 'admin_header.php';
?>

<!-- Page Header -->
<div class="page-header">
    <h1>Order Management</h1>
    <p>View and manage all customer orders</p>
</div>

<!-- Display Messages -->
<?php if (isset($_SESSION['success'])): ?>
<div class="alert alert-success" style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 12px; border-radius: 5px; margin-bottom: 20px;">
    <?php 
    echo $_SESSION['success']; 
    unset($_SESSION['success']);
    ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
<div class="alert alert-danger" style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 12px; border-radius: 5px; margin-bottom: 20px;">
    <?php 
    echo $_SESSION['error']; 
    unset($_SESSION['error']);
    ?>
</div>
<?php endif; ?>

<!-- Orders Section -->
<div class="content-section">
    <div class="section-header">
        <h2><i class="fas fa-shopping-cart"></i> All Orders</h2>
    </div>

    <?php if ($orders && $orders->rowCount() > 0): ?>
    <table class="data-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $orders->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><strong>#<?php echo htmlspecialchars($row['order_number']); ?></strong></td>
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
                <td><?php echo date('M d, Y H:i', strtotime($row['created_at'])); ?></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-icon btn-edit" onclick="window.location.href='update_order.php?id=<?php echo $row['id']; ?>'">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn-icon btn-delete" onclick="deleteOrder(<?php echo $row['id']; ?>)">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="empty-state">
        <i class="fas fa-shopping-cart"></i>
        <h3>No orders yet</h3>
        <p>Orders will appear here once customers start placing them</p>
    </div>
    <?php endif; ?>
</div>

</div> <!-- Close admin-container -->

<script>
function deleteOrder(orderId) {
    if (confirm('Are you sure you want to delete this order?')) {
        window.location.href = 'delete_order.php?id=' + orderId;
    }
}
</script>
<script src="../js/admin.js"></script>
</body>
</html>