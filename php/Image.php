<?php

require_once("ImageDb.php");

class Image {
    
    private $min_value = 1000;
    private $min_position = 0;
    private $imageDb = null;

    public function __construct() {
        $this->imageDb = new ImageDb();
    }


    /**
     * Finds the least processed image
     * @return json encoded array($index, $occurences)
     */
    public function getMin() {
        $images = $this->imageDb->retrieve();
        foreach($images as $image) {
            if($this->min_value > $image["occurences"]) {
                $this->min_value = $image["occurences"];
                $this->min_position = $image["id"];
            }
        }
        
        return array("id"         => $this->min_position,
                     "occurences" => $this->min_value);
    }   
}
