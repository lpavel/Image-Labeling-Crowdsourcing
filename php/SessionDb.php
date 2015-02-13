<?php

require('ConfigLocal.php');

class SessionDb {
    
    private $db_conn = null;
    $session_id = null;
    
    /**                    
     * Constructor        
     * Opens a connection to the DB
     */
    public function __construct($session_id) {
        $this->session_id = $session_id;
        
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
     * increment the number of occurences of a picture in the database
     **/
    public function incrementTask() {
        if ( $stmt = $this->db_conn->prepare("UPDATE Sessions".
                                             " SET count=count+1".
                                             " WHERE id=?") ) {            
            // bind parameters for markers                          
            $stmt->bind_param("d", $session_id );
            
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
     * returns the number of completed tasks by a person
     **/
    public function tasksCompleted() {
        $count = 0;
        if ($stmt = $this->db_conn->prepare("SELECT count".
                                            " FROM Sessions WHERE ".
                                            " session_id = ?")) {
            $stmt->bind_param("d", $session_id);
            if (!$stmt->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            $stmt->bind_result($thisCount);
            
            if ($stmt->fetch()) {
                $count = $thisCount;
            }
            else {
                echo "Not enough data gotten";
            }
        }
        return $count;

    }
}

?>