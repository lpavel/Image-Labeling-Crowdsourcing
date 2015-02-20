<?php

define('PATH_TO_MODEL','../Model/');

require_once(PATH_TO_MODEL . 'Dots.php');

switch( $_SERVER['REQUEST_METHOD'] ) {
    
case 'GET':
    $dots = new Dots();
    echo json_encode($dots->getMin());
    break;
case 'POST':
    $dots  = new Dots($_POST);
    echo json_encode(array( "response" => $dots->saveDots()));
    break;
default:
    throw new Exception('Invalid request \n');
    break;
}
