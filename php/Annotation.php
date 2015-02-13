<?php

$body = $_POST;

$image_index = $body['image_index'];
$session_id  = $body['session_id'];

// now write everything else to file
$file_name = "/home/lpavel/results/Image" . $image_index . "-" . 
           $session_id . ".json"; 

file_put_contents($file_name, json_encode($body['coordinates']));


?>