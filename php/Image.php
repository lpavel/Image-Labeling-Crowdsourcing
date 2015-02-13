<?php

require('ImageDb');

class Image {
    
    $min_value = 10000;
    $min_position = 0;
    $imageDb = new ImageDb();

    /**
     * Finds the least processed image
     * @return array($index, $occurences)
     */
    public function getMin() {
        $images = $imageDb->retrieve();
        foreach($images as $image) {
            if($min_value > $image["occurences"]) {
                $min_value = $image["occurences"];
                $min_position = $image["id"];
            }
        }
        return json_encode(array("id"         => $min_position,
                                 "occurences" => $min_value));
    }   
}
?>