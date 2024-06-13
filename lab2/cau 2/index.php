<?php
require 'Company/Employee.php';

use Company\Employee;

$employee1 = new Employee(1, "Nguyen Van A", 7000000, 2000000, "Nhan Vien");
echo $employee1->getInfo();
?>
