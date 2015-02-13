<?php

require('ImageDb.php');
require('SessionDb.php');

class Annotation {
    
    private $image_index = null;
    private $session_id  = null;
    private $coordinates = null;

    $imageDb = null;
    $sessionDb = null;
    
    // make sure to call it with $_POST
    public function __construct($body) {
        $image_index = $body['image_index'];
        $session_id  = $body['session_id'];
        $coordinates = $body['coordinates'];
    
        $sessionDb = new SessionDb($session_id);
        $imageDb = new ImageDb();
    }
    
    public function saveAnnotation() {
        writeFile();
        updateImageDb();
        updateSessionsDb();
        return isTaskCompleted();
    }
    
    private function writeFile() {
        $file_name = "/home/lpavel/results/Image" . 
                   $image_index . "-" . $session_id . ".json"; 
        
        file_put_contents($file_name, json_encode($coordinates));
    }
    
    private function updateImageDb() {
        $imageDb->incrementOccurences($image_index);
    }

    private function updateSessionDb() {
        $sessionDb->incrementTasks();
    }

    private function isTaskCompleted() {
        if($sessionDb->tasksCompleted() == 3) {
            return rand(1000,9999) . "." . rand(1000,9999);
        }
        return null;
    }

?>