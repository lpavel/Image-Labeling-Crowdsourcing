<?php
// simply returns a key for security purposes

session_start();
$_SESSION["id"] = rand();
echo json_encode(array("id" => $_SESSION["id"]));

?>