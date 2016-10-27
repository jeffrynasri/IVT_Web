<?php
class Penjualan_Barang{

    // database connection and table id_tra
    private $conn;
    private $table_name = "penjualan_barang";

    // object properties
    public $id_penjualan;
    public $id_tra;
    public $nipg;
    public $nib;

    public function __construct($db){
        $this->conn = $db;
    }
    function readAll($page, $from_record_num, $records_per_page){

    $query = "SELECT
    id_penjualan, id_tra, nib, nipg 
    FROM
    " . $this->table_name . "
    ORDER BY
    id_tra ASC
    LIMIT
    {$from_record_num}, {$records_per_page}";

    $stmt = $this->conn->prepare( $query );
    $stmt->execute();

    return $stmt;
}
        
    public function delete(){

    $query = "DELETE FROM " . $this->table_name . " WHERE id_penjualan = ?";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id_penjualan);


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
                    id_tra = :id_tra,
                    nipg = :nipg,
                    nib = :nib
                    
                WHERE
                    id_penjualan = :id_penjualan";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->id_tra=htmlspecialchars(strip_tags($this->id_tra));
        $this->nipg=htmlspecialchars(strip_tags($this->nipg));
        $this->nib=htmlspecialchars(strip_tags($this->nib));
        $this->id_penjualan=htmlspecialchars(strip_tags($this->id_penjualan));

        // bind parameters
        $stmt->bindValue(':id_tra', $this->id_tra, PDO::PARAM_INT);
        $stmt->bindValue(':nipg', $this->nipg, PDO::PARAM_INT);
        $stmt->bindValue(':nib', $this->nib, PDO::PARAM_INT);
        $stmt->bindValue(':id_penjualan', $this->id_penjualan, PDO::PARAM_INT);    
        
            
        // execute the query
        if($stmt->execute()){
            return true;
        }else{
            $stmt->errorInfo();
            return false;
        }
    }
     // used for paging products
    public function countAll(){

        $query = "SELECT id_penjualan FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }
    // create product
    function create(){

        // to get time-stamp for 'created' field
      

        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    id_tra = ?, nipg = ?, nib = ?";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->id_tra=htmlspecialchars(strip_tags($this->id_tra));
        $this->nipg=htmlspecialchars(strip_tags($this->nipg));
        $this->nib=htmlspecialchars(strip_tags($this->nib));
       

        // bind values
        $stmt->bindParam(1, $this->id_tra);
        $stmt->bindParam(2, $this->nipg);
        $stmt->bindParam(3, $this->nib);
       

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

   
      public function readOne(){

        $query = "SELECT
                    id_tra, nipg, nib 
                FROM
                    " . $this->table_name . "
                WHERE
                    id_penjualan = ?
                LIMIT
                    0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id_penjualan);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id_tra = $row['id_tra'];
        $this->nipg = $row['nipg'];
        $this->nib = $row['nib'];
    }
}
?>