<?php

require("Image.php");
require("Annotation.php");

switch( $_SERVER['REQUEST_METHOD'] ) {
    
case 'GET':
    $image = new Image();
    echo json_encode($image->getMin());
    break;
case 'POST':
    $annotation  = new Annotation($_POST);
    echo json_encode(array( "response" => $annotation->saveAnnotation()));
    break;
default:
    throw new Exception('Invalid request \n');
    break;

}
