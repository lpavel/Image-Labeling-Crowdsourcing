<?php

require_once("AnnotationDb.php");
require_once("SessionDb.php");

class Annotation {
    
    private $image_index = null;
    private $session_id  = null;
    private $coordinates = null;
    
    private $annotationDb = null;
    private $sessionDb = null;
    
    public function __construct($body = null) {
        if(isset($body)) {
            $this->image_index = $body['image_index'];
            $this->session_id  = $body['session_id'];
            $this->coordinates = $body['coordinates'];
            $this->sessionDb = new SessionDb($this->session_id);
        }
        $this->annotationDb = new AnnotationDb();
    }
    
    public function saveAnnotation() {

        self::writeFile();
        self::updateAnnotationDb();
        self::updateSessionDb();
        return self::isTaskCompleted();
    }
    
    private function writeFile() {
        $file_name = "/home/lpavel/resultsContours/Image" . 
                   $this->image_index . "-" . $this->session_id . ".json"; 
        
        file_put_contents($file_name, json_encode($this->coordinates));
    }
    
    private function updateAnnotationDb() {
        $this->annotationDb->incrementOccurences($this->image_index);
    }

    private function updateSessionDb() {
        if($this->sessionDb->tasksCompleted() > 0) {
            $this->sessionDb->incrementTask();
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

    /**
     * Finds the least processed image
     * @return array($index, $occurences)
     */
    public function getMin() {
        $image = $this->annotationDb->retrieveMin();

        // get size of image here
        $imagePath = '../img/Image' . $image['id'] . '.jpg';
        list($imgWidth, $imgHeight) = getimagesize($imagePath);        

        return array("id"         => $image['id'],
                     "occurences" => $image['occurences'],
                     "height"     => $imgHeight,
                     "width"      => $imgWidth);
    }

}
