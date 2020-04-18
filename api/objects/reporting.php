<?php
class Reporting{

    // database connection and table name
    private $conn;
    private $table_name = "cnperf_reporting";

    // object properties
    public $id;
    public $sort;
    public $cmdid;
    public $cmdtype;
    public $command;
    public $result;
    public $cmd_dttm;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function allresults(){

        // select all query
        $query = "SELECT
                      p.id, p.sort, p.cmdid, p.cmdtype, p.command, p.result, p.cmd_dttm
                    FROM cnperf_results p
                   where archiv = 0
                 ORDER BY
                   p.id, p.cmdid limit 1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function insertresult(){

        // query to insert record
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                id=:id, sort=:sort, cmdid=:cmdid, send_bytes=:send_bytes, received_bytes=:received_bytes, sent_bitsec=:sent_bitsec, received_bitsec=:received_bitsec";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":sort", $this->sort);
        $stmt->bindParam(":cmdid", $this->cmdid);
        $stmt->bindParam(":send_bytes", $this->send_bytes);
        $stmt->bindParam(":received_bytes", $this->received_bytes);
        $stmt->bindParam(":sent_bitsec", $this->sent_bitsec);
        $stmt->bindParam(":received_bitsec", $this->received_bitsec);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;

    }

}
?>
