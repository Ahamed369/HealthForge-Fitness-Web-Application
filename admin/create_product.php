<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

$page_title = 'Add New Product';
$current_page = 'products';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once '../config/database.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $rating = $_POST['rating'];
    $reviews = $_POST['reviews'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    
    try {
        $query = "INSERT INTO products (name, price, category, rating, reviews, description, image) 
                  VALUES (:name, :price, :category, :rating, :reviews, :description, :image)";
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':reviews', $reviews);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Product created successfully.";
            header('Location: admin-products.php');
            exit();
        } else {
            $_SESSION['error'] = "Failed to create product.";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
}

include 'admin_header.php';
?>

<!-- Page Header -->
<div class="page-header">
    <h1>Add New Product</h1>
    <p>Create a new product for your store</p>
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
    <form method="POST" action="create_product.php" style="max-width: 800px;">
        <div class="form-group">
            <label>Product Name *</label>
            <input type="text" name="name" required class="form-control">
        </div>
        
        <div class="form-group">
            <label>Price (LKR) *</label>
            <input type="number" step="0.01" name="price" required class="form-control">
        </div>
        
        <div class="form-group">
            <label>Category *</label>
            <select name="category" required class="form-control">
                <option value="">Select Category</option>
                <option value="supplements">Supplements</option>
                <option value="equipment">Equipment</option>
                <option value="wellness">Wellness</option>
                <option value="accessories">Accessories</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Rating (0-5) *</label>
            <input type="number" step="0.1" min="0" max="5" name="rating" required class="form-control">
        </div>
        
        <div class="form-group">
            <label>Number of Reviews *</label>
            <input type="number" name="reviews" required class="form-control">
        </div>
        
        <div class="form-group">
            <label>Description *</label>
            <textarea name="description" rows="4" required class="form-control"></textarea>
        </div>
        
        <div class="form-group">
            <label>Image Path *</label>
            <input type="text" name="image" placeholder="e.g., images/product.jpg" required class="form-control">
            <small style="color: #666; display: block; margin-top: 5px;">Enter the relative path to the product image</small>
        </div>
        
        <div class="form-actions" style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Create Product
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