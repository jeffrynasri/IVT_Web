<?php
class Barang_Rusak{

    // database connection and table keterangan
    private $conn;
    private $table_name = "barang_rusak";

    // object properties
    public $id_barang_rusak;
    public $keterangan;
    public $nipg;
    public $nib;
    public $jumlah;
    
    public function __construct($db){
        $this->conn = $db;
    }
    function readAll($page, $from_record_num, $records_per_page){

    $query = "SELECT
    id_barang_rusak, keterangan, nib, nipg,jumlah
    FROM
    " . $this->table_name . "
    ORDER BY
    keterangan ASC
    LIMIT
    {$from_record_num}, {$records_per_page}";

    $stmt = $this->conn->prepare( $query );
    $stmt->execute();

    return $stmt;
}
        
    public function delete(){

    $query = "DELETE FROM " . $this->table_name . " WHERE id_barang_rusak = ?";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id_barang_rusak);


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
                    keterangan = :keterangan,
                    nipg = :nipg,
                    nib = :nib,
                    jumlah = :jumlah
                    
                WHERE
                    id_barang_rusak = :id_barang_rusak";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->keterangan=htmlspecialchars(strip_tags($this->keterangan));
        $this->nipg=htmlspecialchars(strip_tags($this->nipg));
        $this->nib=htmlspecialchars(strip_tags($this->nib));
        $this->id_barang_rusak=htmlspecialchars(strip_tags($this->id_barang_rusak));
        $this->jumlah=htmlspecialchars(strip_tags($this->jumlah));

        // bind parameters
        $stmt->bindValue(':keterangan', $this->keterangan, PDO::PARAM_STR);
        $stmt->bindValue(':nipg', $this->nipg, PDO::PARAM_INT);
        $stmt->bindValue(':nib', $this->nib, PDO::PARAM_STR);
        $stmt->bindValue(':id_barang_rusak', $this->id_barang_rusak, PDO::PARAM_INT);    
        $stmt->bindValue(':jumlah', $this->jumlah, PDO::PARAM_INT);    
            
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

        $query = "SELECT id_barang_rusak FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }
    // create product
    function create(){


        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    keterangan = ?, nipg = ?, nib = ?, jumlah = ?";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->keterangan=htmlspecialchars(strip_tags($this->keterangan));
        $this->nipg=htmlspecialchars(strip_tags($this->nipg));
        $this->nib=htmlspecialchars(strip_tags($this->nib));
        $this->jumlah=htmlspecialchars(strip_tags($this->jumlah));
      

        // bind values
        $stmt->bindParam(1, $this->keterangan);
        $stmt->bindParam(2, $this->nipg);
        $stmt->bindParam(3, $this->nib);
        $stmt->bindParam(4, $this->jumlah);


        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

  
      public function readOne(){

        $query = "SELECT
                    keterangan, nipg, nib,jumlah 
                FROM
                    " . $this->table_name . "
                WHERE
                    id_barang_rusak = ?
                LIMIT
                    0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id_barang_rusak);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->keterangan = $row['keterangan'];
        $this->nipg = $row['nipg'];
        $this->nib = $row['nib'];
        $this->jumlah = $row['jumlah'];
    }
}
?>