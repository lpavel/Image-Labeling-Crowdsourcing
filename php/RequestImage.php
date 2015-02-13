<?php

include 'ConfigLocal.php';
require('Db.php');
/*
$servername = DB_SERVER;
$username   = DB_USER;
$password   = DB_PASS;
$dbname     = DB_NAME;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, name, occurences FROM LabeledImages";
$result = $conn->query($sql);

$min_value = 1000;
$min_position = 0;

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        if($min_value > $row["occurences"]) {
            $min_value = $row["occurences"];
            $min_position = $row["id"];
        }
    }
} else {
    echo "0 results";
}

$conn->close();

$info = array("id"         => $min_position,
              "occurences" => $min_value);
*/


$db = new Db();

switch( $_SERVER['REQUEST_METHOD'] ) {
    
case 'GET': {
    echo json_encode($db->retrieveMin());
    break;
}
case 'POST':
    $db->insert( $_POST );
    break;
default:
    throw new Exception('Invalid request \n');
    break;

}

?>