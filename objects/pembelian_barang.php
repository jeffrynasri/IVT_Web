<?php
class Pembelian_Barang{

    // database connection and table nim
    private $conn;
    private $table_name = "pembelian_barang";

    // object properties
    public $id_pembelian;
    public $nim;
    public $nip;
    public $nib;
    public $id_tra;

    public function __construct($db){
        $this->conn = $db;
    }
    function readAll($page, $from_record_num, $records_per_page){

    $query = "SELECT
    id_pembelian, nim, nib, nip,id_tra 
    FROM
    " . $this->table_name . "
    ORDER BY
    nim ASC
    LIMIT
    {$from_record_num}, {$records_per_page}";

    $stmt = $this->conn->prepare( $query );
    $stmt->execute();

    return $stmt;
}
        
    public function delete(){

    $query = "DELETE FROM " . $this->table_name . " WHERE id_pembelian = ?";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id_pembelian);


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
                    nim = :nim,
                    nip = :nip,
                    nib = :nib,
                    id_tra = :id_tra
                    
                WHERE
                    id_pembelian = :id_pembelian";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->nim=htmlspecialchars(strip_tags($this->nim));
        $this->nip=htmlspecialchars(strip_tags($this->nip));
        $this->nib=htmlspecialchars(strip_tags($this->nib));
        $this->id_tra=htmlspecialchars(strip_tags($this->id_tra));
        $this->id_pembelian=htmlspecialchars(strip_tags($this->id_pembelian));

        // bind parameters
        $stmt->bindValue(':nim', $this->nim, PDO::PARAM_INT);
        $stmt->bindValue(':nip', $this->nip, PDO::PARAM_INT);
        $stmt->bindValue(':nib', $this->nib, PDO::PARAM_INT);
        $stmt->bindValue(':id_tra', $this->id_tra, PDO::PARAM_INT);
        $stmt->bindValue(':id_pembelian', $this->id_pembelian, PDO::PARAM_INT);    
        
       
        // execute the query
        if($stmt->execute() /*&& ($stmt->rowCount()>0)*/){
            return true;
        }else{
            $stmt->errorInfo();
            return false;
        }
    }
     // used for paging products
    public function countAll(){

        $query = "SELECT id_pembelian FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }
    // create product
    function create(){

        // to get time-stamp for 'created' field
       // $this->getTimestamp();

        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    nim = ?, nip = ?, nib = ?, id_tra = ?";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->nim=htmlspecialchars(strip_tags($this->nim));
        $this->nip=htmlspecialchars(strip_tags($this->nip));
        $this->nib=htmlspecialchars(strip_tags($this->nib));
        $this->id_tra=htmlspecialchars(strip_tags($this->id_tra));

        // bind values
        $stmt->bindParam(1, $this->nim);
        $stmt->bindParam(2, $this->nip);
        $stmt->bindParam(3, $this->nib);
        $stmt->bindParam(4, $this->id_tra);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

  
      public function readOne(){

        $query = "SELECT
                    nim, nip, nib, id_tra
                FROM
                    " . $this->table_name . "
                WHERE
                    id_pembelian = ?
                LIMIT
                    0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id_pembelian);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->nim = $row['nim'];
        $this->nip = $row['nip'];
        $this->nib = $row['nib'];
        $this->id_tra = $row['id_tra'];
    }
}
?>