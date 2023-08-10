<?php
require_once 'controller/userController.php';
require_once 'controller/sportsController.php';

if (!isset ($_SESSION['someuser'])){
    header('Location: view/register.php');
}
if (isset($_GET['model']) && $_GET['model'] == 'user') {
$controller = new userController();
} else {
$controller = new sportsController();
}

$controller->mvcHandler();
?>
