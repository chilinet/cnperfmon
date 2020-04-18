<?php
class Results{

    // database connection and table name
    private $conn;
    private $table_name = "cnperf_results";

    // object properties
    public $id;
    public $sort;
    public $cmdtype;
    public $command;
    public $result;
    public $cmd_dttm;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

function push(){

    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                id=:id, sort=:sort, cmdtype=:cmdtype, command=:command, result=:result, cmd_dttm=:cmd_dttm";

    // prepare query
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
    $this->sort=htmlspecialchars(strip_tags($this->sort));
    $this->cmdtype=htmlspecialchars(strip_tags($this->cmdtype));
    $this->command=htmlspecialchars(strip_tags($this->command));
    $this->result=json_encode($this->result);
    $this->cmd_dttm=htmlspecialchars(strip_tags($this->cmd_dttm));

    // bind values
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":sort", $this->sort);
    $stmt->bindParam(":cmdtype", $this->cmdtype);
    $stmt->bindParam(":command", $this->command);
    $stmt->bindParam(":result", $this->result);
    $stmt->bindParam(":cmd_dttm", $this->cmd_dttm);

    //var_dump($this->result);

    // execute query
    if($stmt->execute()){

       $query = "update cnperf_cmd  SET scheduled = 0 where id=:id and sort=:sort";

       // prepare query
       $stmt = $this->conn->prepare($query);

       $stmt->bindParam(":id", $this->id);
       $stmt->bindParam(":sort", $this->sort);

       if($stmt->execute()){
           return true;
       }
    }

    return false;

    }

}
?>
