<?php
class Cart {
    private $conn;
    private $table_name = "cart";

    public $id;
    public $user_id;
    public $product_id;
    public $quantity;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addToCart() {
        // Check if item already exists in cart
        $check_query = "SELECT id, quantity FROM " . $this->table_name . " WHERE user_id = :user_id AND product_id = :product_id";
        $check_stmt = $this->conn->prepare($check_query);
        $check_stmt->bindParam(":user_id", $this->user_id);
        $check_stmt->bindParam(":product_id", $this->product_id);
        $check_stmt->execute();

        if($check_stmt->rowCount() > 0) {
            // Update quantity
            $row = $check_stmt->fetch(PDO::FETCH_ASSOC);
            $query = "UPDATE " . $this->table_name . " SET quantity = quantity + 1 WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $row['id']);
        } else {
            // Insert new item
            $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, product_id=:product_id, quantity=:quantity";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":product_id", $this->product_id);
            $stmt->bindParam(":quantity", $this->quantity);
        }

        return $stmt->execute();
    }

    public function getCartItems() {
        $query = "SELECT c.*, p.name, p.price, p.image FROM " . $this->table_name . " c 
                  LEFT JOIN products p ON c.product_id = p.id 
                  WHERE c.user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();
        return $stmt;
    }

    public function updateQuantity() {
        $query = "UPDATE " . $this->table_name . " SET quantity = :quantity WHERE id = :id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->user_id);
        return $stmt->execute();
    }

    public function removeFromCart() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->user_id);
        return $stmt->execute();
    }

    public function clearCart() {
        $query = "DELETE FROM " . $this->table_name . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        return $stmt->execute();
    }

    public function getCartCount() {
        $query = "SELECT SUM(quantity) as total FROM " . $this->table_name . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ? $row['total'] : 0;
    }
}
?>