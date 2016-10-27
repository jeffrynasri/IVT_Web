<?php
class Keterangan_Transaksi{

    // database connection and table deskripsi
    private $conn;
    private $table_name = "keterangan_transaksi";

    // object properties
    public $id_keterangan;
    public $deskripsi;
    

    public function __construct($db){
        $this->conn = $db;
    }
    function readAll($page, $from_record_num, $records_per_page){

    $query = "SELECT
    id_keterangan, deskripsi 
    FROM
    " . $this->table_name . "
    ORDER BY
    id_keterangan ASC
    LIMIT
    {$from_record_num}, {$records_per_page}";

    $stmt = $this->conn->prepare( $query );
    $stmt->execute();

    return $stmt;
}
        
    public function delete(){

    $query = "DELETE FROM " . $this->table_name . " WHERE id_keterangan = ?";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id_keterangan);


    if($result = $stmt->execute()){
        return true;
    }else{
        return false;
    }
    }
    public function update(){

        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    deskripsi = :deskripsi,
                    
                WHERE
                    id_keterangan = :id_keterangan";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->deskripsi=htmlspecialchars(strip_tags($this->deskripsi));
        $this->id_keterangan=htmlspecialchars(strip_tags($this->id_keterangan));

        // bind parameters
        $stmt->bindValue(':deskripsi', $this->deskripsi, PDO::PARAM_STR);
        
        $stmt->bindValue(':id_keterangan', $this->id_keterangan, PDO::PARAM_INT);    
        
            
        // execute the query
        if($stmt->execute() && ($stmt->rowCount()>0)){
            return true;
        }else{
            $stmt->errorInfo();
            return false;
        }
    }
     // used for paging products
    public function countAll(){

        $query = "SELECT id_keterangan FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }
    // create product
    function create(){

        // to get time-stamp for 'created' field
        $this->getTimestamp();

        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    deskripsi = ?";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->deskripsi=htmlspecialchars(strip_tags($this->deskripsi));
       
        // bind values
        $stmt->bindParam(1, $this->deskripsi);
        

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

  
      public function readOne(){

        $query = "SELECT
                    deskripsi 
                FROM
                    " . $this->table_name . "
                WHERE
                    id_keterangan = ?
                LIMIT
                    0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id_keterangan);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->deskripsi = $row['deskripsi'];
        
    }
}
?>