<?php
class baseModel{
    private string $host;
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
// open mysql data base
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
}
