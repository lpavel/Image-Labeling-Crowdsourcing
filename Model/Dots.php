<?php

require_once("DotsDb.php");
require_once("SessionDb.php");

class Dots {
    
    private $image_index = null;
    private $session_id  = null;
    private $coordinates = null;

    private $dotsDb = null;
    private $sessionDb = null;

    public function __construct($body) {
        $this->image_index = $body['image_index'];
        $this->session_id  = $body['session_id'];
        $this->coordinates = $body['coordinates'];
    
        $this->sessionDb = new SessionDb($this->session_id);
        $this->dotsDb = new DotsDb();
    }

    public function saveDots() {

        self::writeFile();
        self::updateDotsDb();
        self::updateSessionDb();
        return self::isTaskCompleted();
    }
    
    private function writeFile() {
        $file_name = "/home/lpavel/resultsDots/Image" . 
                   $this->image_index . "-" . $this->session_id . ".json"; 
        
        file_put_contents($file_name, json_encode($this->coordinates));
    }
    
    private function updateDotsDb() {
        $this->dotsDb->incrementOccurences($this->image_index);
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
     * @return json encoded array($index, $occurences)
     */
    public function getMin() {
        $image = $this->dotsDb->retrieveMin();
        
        // get size of image here
        $imagePath = '../img/Image' . $image['id'] . '.jpg';
        list($imgWidth, $imgHeight) = getimagesize($imagePath);        

        return array("id"         => $image['id'],
                     "occurences" => $image['occurences'],
                     "height"     => $imgHeight,
                     "width"      => $imgWidth);
    }
}
