<?php

define('PATH_TO_MODEL','../Model/');

require_once(PATH_TO_MODEL . 'Annotation.php');

switch( $_SERVER['REQUEST_METHOD'] ) {
    
case 'GET':
    $annotation = new Annotation();
    echo json_encode($annotation->getMin());
    break;
case 'POST':
    $annotation  = new Annotation($_POST);
    echo json_encode(array( "response" => $annotation->saveAnnotation()));
    break;
default:
    throw new Exception('Invalid request \n');
    break;
}
