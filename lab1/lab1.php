<?php
//Bai 1:
class User {
    public $username;
    public $password;
    public $email;
    public $role;
    public $status;
    public function __construct($username, $password, $email, $role, $status){
        $this -> username = $username;
        $this -> password = $password;
        $this -> email = $email;
        $this -> role = $role;
        $this -> status = $status;
    }
    function get_username($username){
        return $this->username;     
    }
    function set_username($username){
        return $this->username = $username;
    }
    function get_password($password){
        return $this->password;     
    }
    function set_password($password){
        return $this->password = $password;
    }
    public function login($input_username, $input_password)
    {
        if ($input_username == $this->username && $input_password == $this->password) {
            return true;
        } else {
            return false;
        }
    }
}
$user1 = new User("admin", "12345", "admin@gmail.com", "admin", "active");
if ($user1->login("admin", "12345")) {
    echo "Đăng nhập thành công!" . "<br>". "<br>";
} else {
    echo "Đăng nhập thất bại!" . "<br>". "<br>";
}

//Bai 2:
class Product{
    public $name;
    public $price;
    public $quantity;
    public function __construct($name, $price, $quantity){
        $this -> name = $name;
        $this -> price = $price;
        $this -> quantity = $quantity;
        
    }
    function get_name($name){
        return $this->name;
    }
    function set_name($name){
        return $this->name = $name;
    }
    function get_price($price){
        return $this->price;
    }
    function set_price($price){
        return $this->price = $price;
    }
    function get_quantity($quantity){
        return $this->quantity;
    }
    function set_quantity($quantity){
        return $this->quantity = $quantity;
    }

    public function getInfo()
    {
        return "Product: " . $this->name . "<br>". "Giá: " . $this->price .  "<br>"."Số lượng: " . $this->quantity ;
    }

    public function calculateTotal()
    {
        return $this->price * $this->quantity;
    }
}
$product1 = new Product("Bút chì", 9000, 5);
echo $product1->getInfo() . "<br>"; 
echo "Tổng giá trị đơn hàng: " . $product1->calculateTotal()

?>