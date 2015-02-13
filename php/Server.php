<?php

require('ConfigLocal.php');
require('ImageDb.php');
require('Image');
require('Annotation');

$db = new ImageDb();

switch( $_SERVER['REQUEST_METHOD'] ) {
    
case 'GET': {
    $image = new Image();
    echo $image->getMin();
    break;
}
case 'POST':
    $annotation  = new Annotation($_POST);
    echo $annotation->saveAnnotation();
    break;
default:
    throw new Exception('Invalid request \n');
    break;

}

?>