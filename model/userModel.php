<?php
require_once 'baseModel.php';
class userModel extends baseModel{
    private string $host = "localhost";
    private string $user = "root";
    private string $pass = '';
    private string $db = 'training';
    private $condb;
    public function insertRecord($obj){
try {
$this->open_db();
$this->condb = new mysqli(
    $this->host, $this->user,
    $this->pass, $this->db);
$query = $this->condb->prepare(
"INSERT INTO users (username,password) VALUES (?, ?)"
);
$passwordHash = password_hash($obj->password, PASSWORD_DEFAULT);
$query->bind_param("ss",$obj->username,$passwordHash);
$query->execute();
$last_id = $this->condb->insert_id;
$query->close();
$this->close_db();
return $last_id;
} catch (Exception $e) {
$this->close_db();
throw $e;
}
}
public function getUserByUsername($username)
{
try {
    $this->condb = new mysqli( $this->host, $this->user,$this->pass, $this->db);
$this->open_db();
$query = $this->condb->prepare(
"SELECT * FROM users WHERE username=?");
$query->bind_param("s", $username);
$query->execute();
$res = $query->get_result();
$query->close();
$this->close_db();
return $res;
} catch (Exception $e) {
$this->close_db();
throw $e;
}
}
public function checkNameForUniqueness ($username){

    $this->condb = new mysqli( $this->host, $this->user,$this->pass, $this->db);
    $this -> open_db();
    $query = $this -> condb -> prepare("SELECT username FROM users WHERE username = ?");
    $query -> bind_param ("s", $username);
    $query -> execute ();
    $res = $query -> get_result();
    if ($res-> num_rows > 0 ){
        return TRUE;
    }else {
        return FALSE;
    }
}
}