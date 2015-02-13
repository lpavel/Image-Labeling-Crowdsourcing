<?php

include 'ConfigLocal.php';
require('ImageDb.php');

$db = new ImageDb();

switch( $_SERVER['REQUEST_METHOD'] ) {
    
case 'GET': {
    echo json_encode($db->retrieveMin());
    break;
}
case 'POST':
    $annotation  = new Annotation($_POST);
    $annotation->saveAnnotation();
    break;
default:
    throw new Exception('Invalid request \n');
    break;

}

?>