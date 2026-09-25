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
    $user_id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'] ?? '';
    
    try {
        // Check if email exists for another user
        $check_query = "SELECT id FROM users WHERE email = :email AND id != :id";
        $check_stmt = $db->prepare($check_query);
        $check_stmt->bindParam(':email', $email);
        $check_stmt->bindParam(':id', $user_id);
        $check_stmt->execute();
        
        if ($check_stmt->rowCount() > 0) {
            $_SESSION['error'] = "Email already exists for another user.";
            header("Location: update_user.php?id=" . $user_id);
            exit();
        }
        
        // Update user
        if (!empty($password)) {
            // Update with new password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $query = "UPDATE users SET name = :name, email = :email, role = :role, password = :password WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':password', $hashed_password);
        } else {
            // Update without password
            $query = "UPDATE users SET name = :name, email = :email, role = :role WHERE id = :id";
            $stmt = $db->prepare($query);
        }
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $user_id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "User updated successfully.";
            header('Location: admin-users.php');
            exit();
        } else {
            $_SESSION['error'] = "Failed to update user.";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
}

// Get user data
if (!isset($_GET['id'])) {
    header('Location: admin-users.php');
    exit();
}

$query = "SELECT * FROM users WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $_GET['id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header('Location: admin-users.php');
    exit();
}

$page_title = 'Edit User';
$current_page = 'users';
include 'admin_header.php';
?>

<!-- Page Header -->
<div class="page-header">
    <h1>Edit User</h1>
    <p>Update user information and role</p>
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

<!-- User Form -->
<div class="content-section">
    <form method="POST" action="update_user.php" style="max-width: 600px;">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        
        <div class="form-group">
            <label>Name *</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required class="form-control">
        </div>
        
        <div class="form-group">
            <label>Email *</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required class="form-control">
        </div>
        
        <div class="form-group">
            <label>Role *</label>
            <select name="role" required class="form-control">
                <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>New Password (leave empty to keep current)</label>
            <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password" minlength="6">
        </div>
        
        <div class="form-actions" style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Update User
            </button>
            <button type="button" onclick="window.location.href='admin-users.php'" class="btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </button>
        </div>
    </form>
</div>

</div> <!-- Close admin-container -->

<script src="../js/admin.js"></script>
</body>
</html>