<?php
//Bai 3:
require("./config.php");

class Account {
    public $accountId;
    public $email;
    public $password;
    public $role;
    public function __construct($accountId, $email, $password, $role)
    {
        $this-> accountId = $accountId;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }
    function __destruct()
    {
        print"call destroy object";
    }
    function get_accountId($accountId){
        return $this->accountId;
    }
    function set_accountID($accountId){
        return $this->accountId = $accountId;
    }
    function get_email($email){
        return $this->email;
    }
    function set_email($email){
        return $this->email = $email;
    }
    function get_password($password){
        return $this->password;
    }
    function set_password($password){
        return $this->password = $password;
    }
    function get_role($role){
        return $this->role;
    }
    function set_role($role){
        return $this->role = $role;
    }
    function AccountInfo() {
        echo "Account ID: " . $this->accountId . "<br>";
        echo "Email: " . $this->email . "<br>";
        echo "Password: ". $this->password . "<br>";
        echo "Role: " . $this->role . "<br>". "<br>";
    }
}
class User extends Account {
    public $ten;
    public $sdt;
    public $gioitinh;
    public $ngaysinh;

    public function __construct($accountId, $email, $password, $role, $ten, $sdt, $gioitinh, $ngaysinh){
        parent::__construct($accountId, $email, $password, $role);
        $this->ten = $ten;
        $this->sdt = $sdt;
        $this->gioitinh = $gioitinh;
        $this->ngaysinh = $ngaysinh;
    }
    function get_ten($ten){
        return $this->ten;
    }
    function set_ten($ten){
        return $this->ten = $ten;
    }
    function get_sdt($sdt){
        return $this->sdt;
    }
    function set_sdt($sdt){
        return $this->sdt = $sdt;
    }
    function get_gioitinh($gioitinh){
        return $this->gioitinh;
    }
    function set_gioitinh($gioitinh){
        return $this->gioitinh = $gioitinh;
    }
    function get_ngaysinh($ngaysinh){
        return $this->ngaysinh;
    }
    function set_ngaysinh($ngaysinh){
        return $this->ngaysinh = $ngaysinh;
    }
    public function UserInfo() {
        $this->AccountInfo();
        echo "THÔNG TIN USER"."<br>";
        echo "Tên: " . $this->ten . "<br>";
        echo "Số điện thoại: " . $this->sdt . "<br>";
        echo "Giới tính: " . $this->gioitinh . "<br>";
        echo "Ngày sinh: " . $this->ngaysinh . "<br>". "<br>";
    }

}
$user = new User(1, "user1@gmail.com", "123456", "user", "Nguyen Van A", "0123456789", "Nam", "01/01/1990");
$user->UserInfo();


?>