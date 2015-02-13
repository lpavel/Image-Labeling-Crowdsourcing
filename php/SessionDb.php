<?php

require_once("ConfigLocal.php");

class SessionDb {
    
    private $db_conn = null;
    private $session_id = null;
    
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
                                             " WHERE session_id=?") ) {            
            // bind parameters for markers                          
            $stmt->bind_param("s", $this->session_id );
            
            // execute query
            $stmt->execute();
            //and close statement
            $stmt->close();
        }
        else {
            printf('errno: %d, error: %s', 
                   $this->db_conn->errno, 
                   $this->db_conn->error);
            die;
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

            // bind parameters for markers                          
            $stmt->bind_param("s", $this->session_id );
            
            if (!$stmt->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }
            
            $stmt->bind_result($thisCount);
            
            if ($stmt->fetch()) {
                $count = $thisCount;
            }
        }
        return $count;
    }

    public function insertTask() {
        if ($stmt = $this->db_conn->prepare("INSERT INTO Sessions".
                                            " VALUES(?,1)")) {
            $stmt->bind_param("s", $this->session_id);

            // execute query             
            $stmt->execute();
            //and close statement
            $stmt->close();            
        }        
    }
}
