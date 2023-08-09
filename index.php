<?php
require_once 'controller/userController.php';
require_once 'controller/sportsController.php';

if (!isset ($_SESSION['user'])){
    header('Location: view/register.php');
}
echo $_SESSION['user'];
if (isset($_GET['model']) && $_GET['model'] == 'user') {
$controller = new userController();
} else {
$controller = new sportsController();
}

$controller->mvcHandler();
?>
<a href="view/register.php" >View Register</a>
