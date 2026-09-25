<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

include_once '../config/database.php';
include_once '../models/User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$users = $user->getAllUsers();

$page_title = 'User Management';
$current_page = 'users';
include 'admin_header.php';
?>

<!-- Page Header -->
<div class="page-header">
    <h1>User Management</h1>
    <p>Manage all registered users and their access levels</p>
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

<!-- Users Section -->
<div class="content-section">
    <div class="section-header">
        <h2><i class="fas fa-users"></i> All Users</h2>
        <button class="btn-primary" onclick="window.location.href='create_user.php'">
            <i class="fas fa-user-plus"></i> Add New User
        </button>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Joined Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $users->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td>
                    <?php if($row['role'] === 'admin'): ?>
                        <span class="badge badge-danger">Admin</span>
                    <?php else: ?>
                        <span class="badge badge-info">User</span>
                    <?php endif; ?>
                </td>
                <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-icon btn-edit" onclick="window.location.href='update_user.php?id=<?php echo $row['id']; ?>'">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <?php if($row['id'] != $_SESSION['user_id']): ?>
                        <button class="btn-icon btn-delete" onclick="deleteUser(<?php echo $row['id']; ?>)">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</div> <!-- Close admin-container -->

<script>
function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        window.location.href = 'delete_user.php?id=' + userId;
    }
}
</script>
<script src="../js/admin.js"></script>
</body>
</html>