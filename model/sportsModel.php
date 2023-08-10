<?php
class sportsModel{
    public string $host;
    private string $user;
    private string $pass;
    private string $db;
    private $condb;
// set database config for mysql
public function __construct($consetup)
{
$this->host = $consetup->host;
$this->user = $consetup->user;
$this->pass = $consetup->pass;
$this->db = $consetup->db;
}
// open mysql database
public function open_db()
{
$this->condb = new mysqli(
$this->host, $this->user,
$this->pass, $this->db
);
if ($this->condb->connect_error) {
die("Error in connection: "
. $this->condb->connect_error);
}
}
// close database
public function close_db()
{
$this->condb->close();
}
public function selectRecord($id)
{
try
{
$this->open_db();
if ($id > 0) {
$query = $this->condb->prepare("SELECT * FROM sports WHERE id=?");
$query->bind_param("i", $id);
} else { $query = $this->condb->prepare("SELECT * FROM sports");}
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
public function insertRecord($obj)
{
try {
$this->open_db();
$query = $this->condb->prepare(
"INSERT INTO sports (category,name) VALUES (?, ?)"
);
$query->bind_param("ss", $obj->category, $obj->name);
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
public function updateRecord($obj)
{
try {
$this->open_db();
$query = $this->condb->prepare(
"UPDATE sports SET category=?,name=? WHERE id=?"
);
$query->bind_param("ssi", $obj->category, $obj->name, $obj->id);
$query->execute();
$query->close();
$this->close_db();
return true;
} catch (Exception $e) {
$this->close_db();
throw $e;
}
}
public function deleteRecord($id)
{
try {
$this->open_db();
$query = $this->condb->prepare(
"DELETE FROM sports WHERE id=?"
);
$query->bind_param("i", $id);
$query->execute();
$query->close();
$this->close_db();
return true;
} catch (Exception $e) {
$this->close_db();
throw $e;
}
}
}

