<?php
class Reporting{

    // database connection and table name
    private $conn;
    private $table_name = "cnperf_reporting";

    // object properties
    public $id;
    public $sort;
    public $cmdid;
    public $localhost;
    public $remotehost;
    public $remoteport;
    public $send_bytes;
    public $send_bitsec;
    public $received_bytes;
    public $received_bitsec;
    public $version;
    public $system_info;
    public $timestamp;

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
                   where cmdtype = 'iperf3' 
                     and archiv = 0
                 ORDER BY
                   p.id, p.cmdid";

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
                id=:id, 
                sort=:sort, 
                cmdid=:cmdid,
                localhost=:localhost,
                remotehost=:remotehost,
                remoteport=:remoteport, 
                send_bytes=:send_bytes, 
                received_bytes=:received_bytes, 
                send_bitsec=:send_bitsec, 
                received_bitsec=:received_bitsec,
                version=:version,
                system_info=:system_info,
                timestamp=:timestamp ";

        // prepare query
        $stmt = $this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->sort=htmlspecialchars(strip_tags($this->sort));
        $this->cmdid=htmlspecialchars(strip_tags($this->cmdid));
        $this->localhost=htmlspecialchars(strip_tags($this->localhost));
        $this->remotehost=htmlspecialchars(strip_tags($this->remotehost));
        $this->remoteport=htmlspecialchars(strip_tags($this->remoteport));
        $this->send_bytes=htmlspecialchars(strip_tags($this->send_bytes));
        $this->received_bytes=htmlspecialchars(strip_tags($this->received_bytes));
        $this->send_bitsec=htmlspecialchars(strip_tags($this->send_bitsec));
        $this->received_bitsec=htmlspecialchars(strip_tags($this->received_bitsec));

        // bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":sort", $this->sort);
        $stmt->bindParam(":cmdid", $this->cmdid);
        $stmt->bindParam(":localhost", $this->localhost);
        $stmt->bindParam(":remotehost", $this->remotehost);
        $stmt->bindParam(":remoteport", $this->remoteport);
        $stmt->bindParam(":send_bytes", $this->send_bytes);
        $stmt->bindParam(":received_bytes", $this->received_bytes);
        $stmt->bindParam(":send_bitsec", $this->send_bitsec);
        $stmt->bindParam(":received_bitsec", $this->received_bitsec);
        $stmt->bindParam(":version", $this->version);
        $stmt->bindParam(":system_info", $this->system_info);
        $stmt->bindParam(":timestamp", $this->timestamp);

        //echo $this->timestamp . PHP_EOL;

        // execute query
        if($stmt->execute()){
            return true;
        } else {
            $errors = $stmt->errorInfo();
            echo($errors[2]);
        }
        return false;
    }

        function setarchiv(){

            $query = "update cnperf_results 
                         set archiv = 1 
                        where id=:id
                          and sort=:sort
                          and cmdid=:cmdid";

            // prepare query
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":sort", $this->sort);
            $stmt->bindParam(":cmdid", $this->cmdid);

            if($stmt->execute()){
                return true;
            } else {
                $errors = $stmt->errorInfo();
                echo($errors[2]);
            }
            return false;
        }

        function listall() {
            $query = "SELECT
                      p.id, 
                      p.sort, 
                      p.cmdid, 
                      p.localhost, 
                      p.remotehost, 
                      p.remoteport,
                      p.version,
                      p.system_info,
                      p.send_bytes,
                      p.received_bytes,
                      p.send_bitsec,
                      p.received_bitsec,
                      p.timestamp 
                    FROM " . $this->table_name . " p
                 ORDER BY
                     p.timestamp";

            // prepare query statement
            $stmt = $this->conn->prepare($query);

            // execute query
            //$stmt->execute();
            if($stmt->execute()){
                return $stmt;
            } else {
                $errors = $stmt->errorInfo();
                echo($errors[2]);
            }

            return $stmt;

        }

}
?>
