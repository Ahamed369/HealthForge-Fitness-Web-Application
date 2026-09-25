<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

// Get all FAQs
$query = "SELECT * FROM faqs ORDER BY id DESC";
$stmt = $db->prepare($query);
$stmt->execute();

$page_title = 'FAQ Management';
$current_page = 'faq';
include 'admin_header.php';
?>

<!-- Page Header -->
<div class="page-header">
    <h1>FAQ Management</h1>
    <p>Manage frequently asked questions for your store</p>
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

<!-- FAQ Section -->
<div class="content-section">
    <div class="section-header">
        <h2><i class="fas fa-question-circle"></i> Frequently Asked Questions</h2>
        <button class="btn-primary" onclick="showAddModal()">
            <i class="fas fa-plus"></i> Add New FAQ
        </button>
    </div>

    <div class="faq-list" style="display: flex; flex-direction: column; gap: 15px;">
        <?php if ($stmt->rowCount() > 0): ?>
            <?php while($faq = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <div class="faq-item" style="background: #f8f9fa; padding: 20px; border-radius: 10px; border-left: 4px solid #c41e3a;">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                    <h4 style="color: #2d2d2d; font-size: 18px; margin: 0;"><?php echo htmlspecialchars($faq['question']); ?></h4>
                    <div class="action-buttons">
                        <button class="btn-icon btn-edit" onclick="showEditModal(<?php echo $faq['id']; ?>, '<?php echo htmlspecialchars(addslashes($faq['question'])); ?>', '<?php echo htmlspecialchars(addslashes($faq['answer'])); ?>')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon btn-delete" onclick="deleteFAQ(<?php echo $faq['id']; ?>)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <p style="color: #666; line-height: 1.6; margin: 0;"><?php echo htmlspecialchars($faq['answer']); ?></p>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-question-circle"></i>
                <h3>No FAQs yet</h3>
                <p>Click "Add New FAQ" to create your first FAQ</p>
            </div>
        <?php endif; ?>
    </div>
</div>

</div> <!-- Close admin-container -->

<!-- Add FAQ Modal -->
<div id="addModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div style="background: white; padding: 30px; border-radius: 10px; max-width: 600px; width: 90%;">
        <h2 style="margin-bottom: 20px;">Add New FAQ</h2>
        <form method="POST" action="create_faq.php">
            <div class="form-group">
                <label>Question *</label>
                <input type="text" name="question" required class="form-control">
            </div>
            <div class="form-group">
                <label>Answer *</label>
                <textarea name="answer" rows="4" required class="form-control"></textarea>
            </div>
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Save FAQ
                </button>
                <button type="button" onclick="closeAddModal()" class="btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit FAQ Modal -->
<div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div style="background: white; padding: 30px; border-radius: 10px; max-width: 600px; width: 90%;">
        <h2 style="margin-bottom: 20px;">Edit FAQ</h2>
        <form method="POST" action="update_faq.php">
            <input type="hidden" name="id" id="edit_faq_id">
            <div class="form-group">
                <label>Question *</label>
                <input type="text" name="question" id="edit_question" required class="form-control">
            </div>
            <div class="form-group">
                <label>Answer *</label>
                <textarea name="answer" id="edit_answer" rows="4" required class="form-control"></textarea>
            </div>
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Update FAQ
                </button>
                <button type="button" onclick="closeEditModal()" class="btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showAddModal() {
    document.getElementById('addModal').style.display = 'flex';
}

function closeAddModal() {
    document.getElementById('addModal').style.display = 'none';
}

function showEditModal(id, question, answer) {
    document.getElementById('edit_faq_id').value = id;
    document.getElementById('edit_question').value = question;
    document.getElementById('edit_answer').value = answer;
    document.getElementById('editModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

function deleteFAQ(id) {
    if (confirm('Are you sure you want to delete this FAQ?')) {
        window.location.href = 'delete_faq.php?id=' + id;
    }
}

// Close modals when clicking outside
document.getElementById('addModal').addEventListener('click', function(e) {
    if (e.target === this) closeAddModal();
});

document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});
</script>
<script src="../js/admin.js"></script>
</body>
</html>