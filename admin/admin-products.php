<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

include_once '../config/database.php';
include_once '../models/Product.php';

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);
$products = $product->read();

$page_title = 'Product Management';
$current_page = 'products';
include 'admin_header.php';
?>

<!-- Page Header -->
<div class="page-header">
    <h1>Product Management</h1>
    <p>Manage your product catalog and inventory</p>
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

<!-- Products Section -->
<div class="content-section">
    <div class="section-header">
        <h2><i class="fas fa-box"></i> All Products</h2>
        <button class="btn-primary" onclick="window.location.href='create_product.php'">
            <i class="fas fa-plus"></i> Add New Product
        </button>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price (LKR)</th>
                <th>Rating</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $products->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td>
                    <img src="../<?php echo htmlspecialchars($row['image']); ?>" 
                         alt="<?php echo htmlspecialchars($row['name']); ?>" 
                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                </td>
                <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
                <td>
                    <span class="badge badge-info"><?php echo ucfirst($row['category']); ?></span>
                </td>
                <td><?php echo number_format($row['price'], 2); ?></td>
                <td>
                    <span style="color: #f39c12;">
                        <?php echo str_repeat('★', floor($row['rating'])); ?>
                        <?php echo str_repeat('☆', 5 - floor($row['rating'])); ?>
                    </span>
                    <?php echo $row['rating']; ?>
                </td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-icon btn-edit" onclick="window.location.href='update_product.php?id=<?php echo $row['id']; ?>'">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn-icon btn-delete" onclick="deleteProduct(<?php echo $row['id']; ?>)">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</div> <!-- Close admin-container -->

<script>
function deleteProduct(productId) {
    if (confirm('Are you sure you want to delete this product?')) {
        window.location.href = 'delete_product.php?id=' + productId;
    }
}
</script>
<script src="../js/admin.js"></script>
</body>
</html>