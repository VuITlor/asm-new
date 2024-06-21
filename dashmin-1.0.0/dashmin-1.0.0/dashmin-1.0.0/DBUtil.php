<?php
include "Database.php";
define("HOST", "localhost");
define("DB_NAME", "asm-gd1");
define("USERNAME", "root");
define("PASSWORD", "");

class DBUntil
{
    private $connection = null;
    
    function __construct()
    {
        $db = new Database(HOST, USERNAME, PASSWORD, DB_NAME);
        $this->connection = $db->getConnection();
    }

    public function select($sql, $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    public function selectOne($sql, $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($table, $data)
    {
        $keys = array_keys($data);
        $fields = implode(", ", $keys);
        $placeholders = ":" . implode(", :", $keys);
        $sql = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $this->connection->lastInsertId();
    }

    public function update($table, $data, $condition, $params = [])
    {
        $updateFields = [];
        foreach ($data as $key => $value) {
            $updateFields[] = "$key = :$key";
        }
        $updateFields = implode(", ", $updateFields);
        $sql = "UPDATE $table SET $updateFields WHERE $condition";
        $stmt = $this->connection->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete($table, $condition, $params = [])
    {
        $sql = "DELETE FROM $table WHERE $condition";
        $stmt = $this->connection->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function execute($sql, $params = [])
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    // Lấy thông tin chi tiết đơn hàng bằng order_id
    public function getOrderById($order_id)
    {
        $sql = "SELECT o.order_id AS order_id, o.customer_name, o.customer_email, o.customer_phone, o.customer_address, o.payment_method, 
                o.total_amount, o.discount, o.coupon_code, o.created_at, o.status, od.product_name, od.quantity, od.price, od.total
                FROM orders o
                JOIN order_details od ON o.order_id = od.order_id
                WHERE o.order_id = :order_id";
        return $this->selectOne($sql, [':order_id' => $order_id]);
    }

    // Lấy danh sách đơn hàng
    public function getAllOrders()
    {
        $sql = "SELECT o.order_id AS order_id, o.customer_name, o.customer_email, o.customer_phone, o.customer_address, o.payment_method, 
                o.total_amount, o.discount, o.coupon_code, o.created_at, o.status, od.product_name, od.quantity, od.price, od.total
                FROM orders o
                JOIN order_details od ON o.order_id = od.order_id
                ORDER BY o.order_id DESC";
        return $this->select($sql);
    }

    // Cập nhật trạng thái đơn hàng
    public function updateOrderStatus($order_id, $status)
    {
        $data = [
            'status' => $status,
        ];
        $condition = "order_id = :order_id";
        $params = [
            'order_id' => $order_id,
        ];
        return $this->update('orders', $data, $condition, $params);
    }
}
?>
