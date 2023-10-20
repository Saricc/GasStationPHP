<?php
$db = new MySQLi('localhost', 'root', '', 'Benza');
if ($db->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
