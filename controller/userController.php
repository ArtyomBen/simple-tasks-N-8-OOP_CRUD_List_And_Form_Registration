<?php
require 'model/userModel.php';
require 'model/user.php';
require_once 'config.php';
session_start();
class userController{
    private $objconfig;
private $modelObj;
public function __construct()
{
$this->objconfig = new config();
$this->modelObj = new userModel($this->objconfig);
}
public function mvcHandler()
{
$act = isset($_GET['act']) ? $_GET['act'] : null;
switch ($act) {
case 'register':
$this->register();
break;
default:
$this->login();
}
}
public function pageRedirect($url){
header('Location:' . $url);
}
public function register()
{
$user = new user();
if (isset($_POST['addbtn'])) {
$user->username = trim($_POST['username']);
$user->password = trim($_POST['password']);
$user->repeat_password = trim($_POST['repeat_password']);
$chk = $this->checkValidation($user);
if ($chk) {
$pid = $this->modelObj->insertRecord($user);
if ($pid > 0) {
$this->pageRedirect("index.php");
$_SESSION['user'] = serialize($user -> username);
} else {
echo "Something is wrong..., try again.";
}
} else {
$_SESSION['user'] = serialize($user); //add session obj
$this->pageRedirect("view/register.php");
}
}
}
public function checkValidation(User $user){
$noerror = true;
// Validate username
if (empty($user->username)) {
$user->username_msg = "Field is empty.";
$noerror = false;
} elseif (!preg_match(
'/^[a-zA-Z0-9]{5,}$/',
$user->username
)) {
$user->username_msg = "Invalid entry.";
$noerror = false;
} else {
$user->username_msg = "";
}

if ($_POST['username']){
    $username = $_POST['username'];
    $_SESSION['username'] = $username;
}
if ($user -> username == $this -> modelObj -> checkNameForUniqueness($user -> username) && !empty($user -> username)){
    $user -> repeatUsername_msg = 'your name is already registered, please try another name';
    $noerror = false;
}else {
    $user -> repeatUsername_msg = "";
}
// Validate password
if (strlen($user->password) <= '8') {
$user->password_msg = "Your Password Must Contain At Least 8 Characters!";
$noerror = false;
} elseif (!preg_match("#[0-9]+#", $user->password)) {
$user->password_msg = "Your Password Must Contain At Least 1 Number!";
$noerror = false;
} elseif (!preg_match("#[A-Z]+#", $user->password)) {
$user->password_msg = "Your Password Must Contain At Least 1 Capital Letter!";
$noerror = false;
} elseif (!preg_match("#[a-z]+#", $user->password)) {
$user->password_msg = "Your Password Must Contain At Least 1 Lowercase Letter!";
$noerror = false;
}// Validate repeat password
if ($user->password != $user->repeat_password) {
    $user->repeat_password_msg = "Passwords don't match!";
    $noerror = false;
    }
    return $noerror;
    }
    // checkValidation function end
    public function login()
{
$user = new user();
if (isset($_POST['addbtn'])) {
// read form value
$username = trim($_POST['username']);
$password = trim($_POST['password']);
$result = $this->modelObj
->getUserByUsername($username);

$userFromDB = mysqli_fetch_array($result);

if (!$userFromDB) {
$user->username_msg = "Username does not exist";
$_SESSION['user'] = serialize($user);
$this->pageRedirect("view/login.php");
} elseif (!password_verify(
$password,
$userFromDB['password']
)) {
$user->password_msg = "Password is not correct";
$_SESSION['user'] = serialize($user);
$this->pageRedirect("view/login.php");
} else {
$_SESSION['current_user_id'] = $userFromDB['id'];
$this->pageRedirect("index.php");
}
}
}
}


