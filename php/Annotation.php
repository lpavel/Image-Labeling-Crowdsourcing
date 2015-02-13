<?php

require_once("ImageDb.php");
require_once("SessionDb.php");

class Annotation {
    
    private $image_index = null;
    private $session_id  = null;
    private $coordinates = null;
    
    private $imageDb = null;
    private $sessionDb = null;
    
    public function __construct($body) {
        $this->image_index = $body['image_index'];
        $this->session_id  = $body['session_id'];
        $this->coordinates = $body['coordinates'];
    
        $this->sessionDb = new SessionDb($this->session_id);
        $this->imageDb = new ImageDb();
    }
    
    public function saveAnnotation() {

        self::writeFile();
        self::updateImageDb();
        self::updateSessionDb();
        return self::isTaskCompleted();
    }
    
    private function writeFile() {
        $file_name = "/home/lpavel/results/Image" . 
                   $this->image_index . "-" . $this->session_id . ".json"; 
        
        file_put_contents($file_name, json_encode($this->coordinates));
    }
    
    private function updateImageDb() {
        $this->imageDb->incrementOccurences($this->image_index);
    }

    private function updateSessionDb() {
        echo "----------TasksCompleted:" . $this->sessionDb->tasksCompleted();
        if($this->sessionDb->tasksCompleted() > 0) {
            $this->sessionDb->incrementTasks();
        }
        else {
            $this->sessionDb->insertTask();
        }
    }

    private function isTaskCompleted() {        
        if($this->sessionDb->tasksCompleted() == 3) {
            return rand(1000,9999) . "." . rand(1000,9999);
        }
        return null;
    }
}
?>