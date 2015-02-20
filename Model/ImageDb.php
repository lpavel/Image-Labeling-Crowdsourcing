<?php

require('../ConfigLocal.php');

class ImageDb {

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
            die('Connect Error (' . $this->db_conn->connect_errno . ') ' . 
                $this->db_conn->connect_error);
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
        if ( $stmt = $this->db_conn->prepare("INSERT INTO LabeledImages".
                                             " (id,occurences)".
                                             " VALUES(?, ?)") ) {            
            // bind parameters for markers                          
            $stmt->bind_param("dd", $params['id'], $params['occurences'] );

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
        if ($stmt = $this->db_conn->prepare("SELECT id,name,occurences".
                                            " FROM LabeledImages")) {
            if (!$stmt->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            
            $stmt->bind_result($thisID, $thisName, $thisOccurences);
            
            while ($stmt->fetch()) {
                $images[] = array( "id"         => $thisID, 
                                   "name"       => $thisName, 
                                   "occurences" => $thisOccurences);
            }
            $stmt->close();
        }
        return $images;
    }

    /**
     * updates method for the database
     * @params $id, $occurences
     **/
    public function update($id, $occurences) {
        //create a prepared statement                                       
        if ( $stmt = $this->db_conn->prepare("UPDATE LabeledImages".
                                             " SET occurences=?".
                                             " WHERE id=?") ) {            
            // bind parameters for markers                          
            $stmt->bind_param("dd", $params['occurences'], $params['id'] );
            
            // execute query             
            $stmt->execute();
            //and close statement
            $stmt->close();
            echo "Row updated";
        }
        else {
            echo "Row could not be updated";
        }
    }

    /**
     * increment the number of occurences of a picture in the database
     * @params object $image
     **/
    public function incrementOccurences($id) {
        if ( $stmt = $this->db_conn->prepare("UPDATE LabeledImages".
                                             " SET occurences=occurences+1".
                                             " WHERE id=?") ) {            
            // bind parameters for markers                          
            $stmt->bind_param("d", $id );
            
            // execute query
            $stmt->execute();
            //and close statement
            $stmt->close();
        }
        else {
            echo "Row could not be updated";
        }
    }


    /**
     * selects only one object form the database
     * @return object $image
     **/
    public function retrieveOne($id) {
        $image = array();
        if ($stmt = $this->db_conn->prepare("SELECT id,name,occurences".
                                            " FROM LabeledImages WHERE ".
                                            " id = ?")) {
            $stmt->bind_param("d", $id);
            if (!$stmt->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            $stmt->bind_result($thisID, $thisName, $thisOccurences);
            
            if ($stmt->fetch()) {
                $image = array("id"         => $thisID, 
                               "name"       => $thisName, 
                               "occurences" => $thisOccurences);
            }
            else {
                echo "Not enough data gotten";
            }
        }
        return $image;
    }
    
    /**
     * Finds the least processed image
     * @return array($index, $occurences)
     */
    public function retrieveMin() {
        $min_value = 1000;
        $min_position = 0;
        

        $images = $this->retrieve();
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
