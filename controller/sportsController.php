<?php
require 'model/sportsModel.php';
require 'model/sports.php';
require_once 'config.php';
session_status() === PHP_SESSION_ACTIVE ? true : session_start();
class sportsController{
    private object $objconfig;
    private object $objsm;
public function __construct()
{
$this->objconfig = new config();
$this->objsm = new sportsModel($this->objconfig);
}
function list() {
$result = $this->objsm->selectRecord(0);
include "view/list.php";
}
// mvc handler request
public function mvcHandler()
{
$act = isset($_GET['act']) ? $_GET['act'] : null;
switch ($act) {
case 'add':
$this->insert();
break;
case 'update':
$this->update();
break;
case 'delete':
$this->delete();
break;
default:
$this->list();
}
}
public function insert()
{
$sporttb = new sports();
if (isset($_POST['addbtn'])) {
// read form value
$sporttb->category = trim($_POST['category']);
$sporttb->name = trim($_POST['name']);
//call validation
$chk = $this->checkValidation($sporttb);
if ($chk) {
//call insert record
$pid = $this->objsm->insertRecord($sporttb);
if ($pid > 0) {
$this->list();
} else {
echo "Something is wrong..., try again.";
}
} else {
$_SESSION['sporttbl0'] = serialize($sporttb); //add session obj
$this->pageRedirect("view/insert.php");
}
}
}
public function checkValidation($sporttb)
{
$noerror = true;
// Validate category
if (empty($sporttb->category)) {
$sporttb->category_msg = "Field is empty.";
$noerror = false;
} elseif (!filter_var(
$sporttb->category, 
FILTER_VALIDATE_REGEXP, 
["options" => ["regexp" => "/^[a-zA-Z\s]+$/"]])
) {
$sporttb->category_msg = "Invalid entry.";
$noerror = false;
} else {
$sporttb->category_msg = "";
}
// Validate name
if (empty($sporttb->name)) {
$sporttb->name_msg = "Field is empty.";
$noerror = false;
} elseif (!filter_var(
$sporttb->name,
FILTER_VALIDATE_REGEXP,
["options" => ["regexp" => "/^[a-zA-Z\s]+$/"]]
)) {
$sporttb->name_msg = "Invalid entry.";
$noerror = false;
} else {
$sporttb->name_msg = "";
}
return $noerror;
}
public function pageRedirect($url)
{
header('Location:' . $url);
}
public function update()
{
if (isset($_POST['updatebtn'])) {
$sporttb = unserialize($_SESSION['sporttbl0']);
$sporttb->id = trim($_POST['id']);
$sporttb->category = trim($_POST['category']);
$sporttb->name = trim($_POST['name']);
// check validation
$chk = $this->checkValidation($sporttb);
if ($chk) {
$res = $this->objsm->updateRecord($sporttb);
if ($res) {
$this->list();
} else {
echo "Something is wrong..., try again.";
}
} else {
$_SESSION['sporttbl0'] = serialize($sporttb);
$this->pageRedirect("view/update.php");
}
} elseif (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
$id = $_GET['id'];
$result = $this->objsm->selectRecord($id);
$row = mysqli_fetch_array($result);
$sporttb = new sports();
$sporttb->id = $row["id"];
$sporttb->name = $row["name"];
$sporttb->category = $row["category"];
$_SESSION['sporttbl0'] = serialize($sporttb);
$this->pageRedirect('view/update.php');
} else {
echo "Invalid operation.";
}
}
public function delete()
{
if (isset($_GET['id'])) {
$id = $_GET['id'];
$res = $this->objsm->deleteRecord($id);
if ($res) {
$this->pageRedirect('index.php');
} else {
echo "Something is wrong..., try again.";
}
} else {
echo "Invalid operation.";
}
}
}