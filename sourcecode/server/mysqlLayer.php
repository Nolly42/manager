<?php

/**
 * Created by IntelliJ IDEA.
 * User: philipp
 * Date: 12.08.16
 * Time: 18:48
 */
class mysqlLayer
{

    private $name;
    private $host;
    private $user;
    private $pass;
    private $port;
    private $socket;

    private $db;

    public function __construct($host, $name, $user, $pass, $port=NULL, $socket=NULL){
        $this->db = NULL;
        $this->host = $host;
        $this->name = $name;
        $this->user = $user;
        $this->pass = $pass;
        $this->port = $port;
        $this->socket = $socket;
    }

    /**
     * Connects to the SQL Server
     * @return boolean result
     *      true if connection successfully established
     *      false otherwise if already connected
     * @throws Exception for any database "problem"
     */
    public function connect(){
        if($this->db !== NULL){ return false; }
        $this->db = new mysqli($this->host, $this->user, $this->pass, $this->name);

        if ($this->db->connect_error) {
            $this->db = NULL;
            throw new Exception('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }
        return true;
    }

    /**
     * Closes the connection to the SQL Server
     */
    public function close(){
        $this->db->close();
        $this->db = NULL;
    }

    /**
     * Returns whether or not there is an open
     * connection to the SQL Server
     * @return boolean result
     *      true if there is an open connection
     *      false otherwise
     */
    public function isConnected(){
        return $this->db !== NULL;
    }

    /**
     * SQL Query with Result
     *      @queryString sql query to perform
     *      @resultHandler function that handles the sql result
     *      @return true
     */
    public function queryNonBlockingResult($queryString, $resultHandler){
        if ($result = $this->db->query($queryString)) {
            $resultHandler($result);
            $result->close();
        }
        return true;
    }

    /**
     * Synced SQL Query with Result
     *      @queryString sql query to perform
     *      @resultHandler function that handles the sql result
     *      Note, that we can't execute any functions which interact with the
     *      server until result set was closed. All calls will return an
     *      'out of sync' error
     */
    public function syncedQueryResult($queryString, $resultHandler){
        if ($result = $this->db->query($queryString, $hugeAmount)) {
            $resultHandler($result);
            $result->close();
        }
    }

    /**
     * SQL Query without Result
     *      @queryString sql query to perform
     *      @return boolean
     *          true on success
     *          false otherwise
     */
    public function query($queryString){
        return $this->db->query($queryString) === TRUE;
    }
}