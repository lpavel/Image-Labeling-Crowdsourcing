<?php

require('ConfigLocal.php');

class Db {

    private $db_conn = null;
    /**                    
     * Constructor        
     * Opens a connection to the DB
     */
    public function __construct() {
        //Open DB connection       
        $this->db_conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        //check that everything is OK
        if ($this->db_conn->connect_error) {
            die('Connect Error (' . $this->db_conn->connect_errno . ') ' . $this->db_conn->connect_error);
        }
    }

    /**
     * Destructor
     * Closes the DB connection opened in constructor
     */
    public function __destruct() {
        //    echo "Closing DB";
        //close connection
        if( $this->db_conn ) {
            $this->db_conn->close();
        }
    }

    /**                  
     * Inserts in DB 
     * @param array $params    
     */
    public function insert( $params) {
        //create a prepared statement                                       
        if ( $stmt = $this->db_conn->prepare("INSERT INTO Coughs (id,date) VALUES('', ?)") ) {            
            // bind parameters for markers                          
            $stmt->bind_param("s", $params['date'] );

            // execute query             
            $stmt->execute();
            //and close statement
            $stmt->close();
        }
        echo "Row Inserted";
    }


    /**
     * Selects from Db
     * @return array $coughs
     */
    public function retrieve() {
        $images = array();
        //create stmt     
        //You need to specify exacly the rows you want   
        if ($stmt = $this->db_conn->prepare("SELECT id,name,occurences FROM LabeledImages")) {
            if (!$stmt->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            
            //            echo "got here\r\n";
            $stmt->bind_result($thisID, $thisName, $thisOccurences);
            
            while ($stmt->fetch()) {
                $images[] = array( "id"         => $thisID, 
                                   "name"       => $thisName, 
                                   "occurences" => $thisOccurences);
            }
            //            echo "now images\r\n";
            
            //close 
            $stmt->close();
        }
        //        var_dump($images);
        return $images;
    }

    
    /**
     * Finds the least processed image
     * @return array($index, $occurences)
     */
    public function retrieveMin() {
        $min_value = 1000;
        $min_position = 0;
        

        $images = $this->retrieve();
        //        var_dump($images);
        foreach($images as $image) {
            if($min_value > $image["occurences"]) {
                $min_value = $image["occurences"];
                $min_position = $image["id"];
            }
        }
        return array("id"         => $min_position,
                     "occurences" => $min_value);
    }
}
?>
