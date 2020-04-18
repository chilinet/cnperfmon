<?php
class Inventory{

    // database connection and table name
    private $conn;
    private $table_name = "cnperf_inventory";

    // object properties
    public $id;
    public $hostname;
    public $status;
    public $create_dttm;
    public $lastupd_dttm;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }


    function getcmdlist(){

       // select all query
       $query = "SELECT
                   p.id, c.sort, c.cmdtype, c.command, p.value1, p.value2
               FROM " . $this->table_name . " p
                   LEFT JOIN
                       cnperf_cmd c
                           ON p.id = c.id
               where p.id = ?
                 and p.status > 0
                 and c.active = 1
                 and c.scheduled = 1
               ORDER BY
                   c.sort";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);

    // execute query
    $stmt->execute();

    return $stmt;
}


    // read products
    function gethostid(){

    // query to read single record
    $query = "SELECT
                p.id
            FROM
                " . $this->table_name . " p
            WHERE
                p.hostname = ?
            LIMIT
                0,1";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // bind id of product to be updated
    $stmt->bindParam(1, $this->hostname);

    // execute query
    $stmt->execute();

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // set values to object properties
    $this->id = $row['id'];


    $query = "update " . $this->table_name . " SET lastupd_dttm=:upddttm where id=:id";

     // prepare query
    $stmt = $this->conn->prepare($query);

    $lastupd_dttm = date('Y-m-d H:i:s');
    $stmt->bindParam(":upddttm", $lastupd_dttm);
    $stmt->bindParam(":id", $this->id);

    if($stmt->execute()){
         return true;
    }
}

// create product
function create(){

    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                hostname=:hostname, status=:status, create_dttm=:create_dttm, lastupd_dttm=:lastupd_dttm";

    // prepare query
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->hostname=htmlspecialchars(strip_tags($this->hostname));
    $this->status=htmlspecialchars(strip_tags($this->status));
    $this->create_dttm=htmlspecialchars(strip_tags($this->create_dttm));
    $this->lastupd_dttm=htmlspecialchars(strip_tags($this->lastupd_dttm));

    // bind values
    $stmt->bindParam(":hostname", $this->hostname);
    $stmt->bindParam(":status", $this->status);
    $stmt->bindParam(":create_dttm", $this->create_dttm);
    $stmt->bindParam(":lastupd_dttm", $this->lastupd_dttm);

    // execute query
    if($stmt->execute()){
        return true;
    }

    return false;

}
// used when filling up the update product form
function readOne(){

    // query to read single record
    $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.id = ?
            LIMIT
                0,1";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);

    // execute query
    $stmt->execute();

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // set values to object properties
    $this->name = $row['name'];
    $this->price = $row['price'];
    $this->description = $row['description'];
    $this->category_id = $row['category_id'];
    $this->category_name = $row['category_name'];
}
// update the product
function update(){

    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                price = :price,
                description = :description,
                category_id = :category_id
            WHERE
                id = :id";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->price=htmlspecialchars(strip_tags($this->price));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->category_id=htmlspecialchars(strip_tags($this->category_id));
    $this->id=htmlspecialchars(strip_tags($this->id));

    // bind new values
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':price', $this->price);
    $stmt->bindParam(':description', $this->description);
    $stmt->bindParam(':category_id', $this->category_id);
    $stmt->bindParam(':id', $this->id);

    // execute the query
    if($stmt->execute()){
        return true;
    }

    return false;
}
}
?>
