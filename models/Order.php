<?php
class Order {
    private $conn;
    private $table_name = "orders";

    public $id;
    public $user_id;
    public $order_number;
    public $total_amount;
    public $status;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET user_id=:user_id, order_number=:order_number, total_amount=:total_amount, status=:status";
        
        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->order_number = htmlspecialchars(strip_tags($this->order_number));
        $this->total_amount = htmlspecialchars(strip_tags($this->total_amount));
        $this->status = htmlspecialchars(strip_tags($this->status));

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":order_number", $this->order_number);
        $stmt->bindParam(":total_amount", $this->total_amount);
        $stmt->bindParam(":status", $this->status);

        if($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    public function addOrderItem($product_id, $quantity, $price) {
        $query = "INSERT INTO order_items SET order_id=:order_id, product_id=:product_id, quantity=:quantity, price=:price";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":order_id", $this->id);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->bindParam(":quantity", $quantity);
        $stmt->bindParam(":price", $price);

        return $stmt->execute();
    }

    // FIXED: Return PDOStatement instead of array
    public function getRecentOrders($limit = 5) {
        $query = "SELECT o.*, u.name as customer_name 
                  FROM " . $this->table_name . " o 
                  LEFT JOIN users u ON o.user_id = u.id 
                  ORDER BY o.created_at DESC 
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt; // Return statement, not array
    }

    public function getOrderCount() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ? $row['total'] : 0;
    }

    public function getTotalRevenue() {
        $query = "SELECT SUM(total_amount) as revenue FROM " . $this->table_name . " WHERE status != 'Cancelled'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['revenue'] ? $row['revenue'] : 0;
    }

    public function getOrdersByStatus($status) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE status = :status";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'];
    }

    // FIXED: Return PDOStatement instead of array
    public function getAllOrders() {
        $query = "SELECT o.*, u.name as customer_name, u.email as customer_email 
                  FROM " . $this->table_name . " o 
                  LEFT JOIN users u ON o.user_id = u.id 
                  ORDER BY o.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt; // Return statement, not array
    }

    public function getOrderById($id) {
        $query = "SELECT o.*, u.name as customer_name, u.email as customer_email 
                  FROM " . $this->table_name . " o 
                  LEFT JOIN users u ON o.user_id = u.id 
                  WHERE o.id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function getOrderItems($order_id) {
        $query = "SELECT oi.*, p.name as product_name, p.image as product_image 
                  FROM order_items oi 
                  LEFT JOIN products p ON oi.product_id = p.id 
                  WHERE oi.order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":order_id", $order_id);
        $stmt->execute();
        
        $items = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = $row;
        }
        return $items;
    }

    public function updateStatus($order_id, $status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $order_id);
        return $stmt->execute();
    }

    public function updateOrder($order_id, $status, $customer_name, $customer_email, $customer_phone, $shipping_address, $total_amount) {
        $query = "UPDATE " . $this->table_name . " SET status = :status, total_amount = :total_amount WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":total_amount", $total_amount);
        $stmt->bindParam(":id", $order_id);
        
        return $stmt->execute();
    }

    public function deleteOrder($order_id) {
        // First delete order items
        $query_items = "DELETE FROM order_items WHERE order_id = :order_id";
        $stmt_items = $this->conn->prepare($query_items);
        $stmt_items->bindParam(":order_id", $order_id);
        $stmt_items->execute();
        
        // Then delete the order
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $order_id);
        return $stmt->execute();
    }

    public function createManualOrder($order_number, $user_id, $total_amount, $status = 'processing') {
        $query = "INSERT INTO " . $this->table_name . " (order_number, user_id, total_amount, status) VALUES (:order_number, :user_id, :total_amount, :status)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":order_number", $order_number);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":total_amount", $total_amount);
        $stmt->bindParam(":status", $status);
        
        return $stmt->execute();
    }

    public function getTotalOrders() {
        return $this->getOrderCount();
    }
}
?>