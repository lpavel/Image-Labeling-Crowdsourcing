<?php

$body = $_POST;

var_dump($body); 
/*
$bodyArray = json_decode($body, true);

$image_index = $bodyArray['image_index'];
$session_id  = $bodyArray['session_id'];

// now write everything else to file
$file_name = "Image" . $image_index . "-" . 
           $session_id . ".json"; 
$file = fopen($file_name, 'w+'); 

fwrite($file, json_encode($bodyArray['coordinates']));
fclose($file);*/
?>