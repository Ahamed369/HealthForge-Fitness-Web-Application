<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $rating = $_POST['rating'];
    $reviews = $_POST['reviews'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    
    try {
        $query = "UPDATE products 
                  SET name = :name, price = :price, category = :category, 
                      rating = :rating, reviews = :reviews, description = :description, image = :image 
                  WHERE id = :id";
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':reviews', $reviews);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':id', $product_id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Product updated successfully.";
            header('Location: admin-products.php');
            exit();
        } else {
            $_SESSION['error'] = "Failed to update product.";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
}

// Get product data
if (!isset($_GET['id'])) {
    header('Location: admin-products.php');
    exit();
}

$query = "SELECT * FROM products WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $_GET['id']);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: admin-products.php');
    exit();
}

$page_title = 'Edit Product';
$current_page = 'products';
include 'admin_header.php';
?>

<!-- Page Header -->
<div class="page-header">
    <h1>Edit Product</h1>
    <p>Update product information</p>
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

<!-- Product Form -->
<div class="content-section">
    <form method="POST" action="update_product.php" style="max-width: 800px;">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        
        <div class="form-group">
            <label>Product Name *</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required class="form-control">
        </div>
        
        <div class="form-group">
            <label>Price (LKR) *</label>
            <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required class="form-control">
        </div>
        
        <div class="form-group">
            <label>Category *</label>
            <select name="category" required class="form-control">
                <option value="">Select Category</option>
                <option value="supplements" <?php echo $product['category'] === 'supplements' ? 'selected' : ''; ?>>Supplements</option>
                <option value="equipment" <?php echo $product['category'] === 'equipment' ? 'selected' : ''; ?>>Equipment</option>
                <option value="protein" <?php echo $product['category'] === 'protein' ? 'selected' : ''; ?>>Protein</option>
                <option value="vitamins" <?php echo $product['category'] === 'vitamins' ? 'selected' : ''; ?>>Vitamins</option>
                <option value="accessories" <?php echo $product['category'] === 'accessories' ? 'selected' : ''; ?>>Accessories</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Rating (0-5) *</label>
            <input type="number" step="0.1" min="0" max="5" name="rating" value="<?php echo $product['rating']; ?>" required class="form-control">
        </div>
        
        <div class="form-group">
            <label>Number of Reviews *</label>
            <input type="number" name="reviews" value="<?php echo $product['reviews']; ?>" required class="form-control">
        </div>
        
        <div class="form-group">
            <label>Description *</label>
            <textarea name="description" rows="4" required class="form-control"><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Image Path *</label>
            <input type="text" name="image" value="<?php echo htmlspecialchars($product['image']); ?>" placeholder="e.g., images/product.jpg" required class="form-control">
        </div>
        
        <div class="form-group">
            <label>Current Image Preview</label>
            <div>
                <img src="../<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" style="max-width: 200px; border-radius: 8px; margin-top: 10px;">
            </div>
        </div>
        
        <div class="form-actions" style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Update Product
            </button>
            <button type="button" onclick="window.location.href='admin-products.php'" class="btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </button>
        </div>
    </form>
</div>

</div> <!-- Close admin-container -->

<script src="../js/admin.js"></script>
</body>
</html>