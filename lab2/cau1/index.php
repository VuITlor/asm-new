<?php
require 'model/user.php';
require 'controller/user.php';
require 'view/user.php';

use model\user as Modeluser;
use controller\user as Controlleruser;
use view\user as Viewuser;

$modeluser = new Modeluser();
$controlleruser = new Controlleruser();
$viewuser = new Viewuser();

$modeluser->hello()."<br>";
$controlleruser->hello()."<br>";
$viewuser->hello()."<br>";
?>
