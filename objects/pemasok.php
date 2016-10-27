<?php
class Pemasok{

    // database connection and table nama
    private $conn;
    private $table_name = "pemasok";

    // object properties
    public $nip;
    public $nama;
    public $alamat;
    public $no_tlp;
  
    

    public function __construct($db){
        $this->conn = $db;
    }
    function selectAll(){

        $query = "SELECT
        nip, nama,alamat,no_tlp
        FROM
        " . $this->table_name . "
        ";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }
    function readAll($page, $from_record_num, $records_per_page){

    $query = "SELECT
    nip, nama, no_tlp, alamat
    FROM
    " . $this->table_name . "
    ORDER BY
    nip ASC
    LIMIT
    {$from_record_num}, {$records_per_page}";

    $stmt = $this->conn->prepare( $query );
    $stmt->execute();

    return $stmt;
}
        
    public function delete(){

    $query = "DELETE FROM " . $this->table_name . " WHERE nip = ?";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->nip);


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
                    nama = :nama,
                    alamat = :alamat,
                    no_tlp = :no_tlp
                WHERE
                    nip = :nip";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->nama=htmlspecialchars(strip_tags($this->nama));
        $this->alamat=htmlspecialchars(strip_tags($this->alamat));
        $this->no_tlp=htmlspecialchars(strip_tags($this->no_tlp));
        $this->nip=htmlspecialchars(strip_tags($this->nip));

        // bind parameters
        $stmt->bindValue(':nama', $this->nama, PDO::PARAM_STR);
        $stmt->bindValue(':alamat', $this->alamat, PDO::PARAM_STR);
        $stmt->bindValue(':no_tlp', $this->no_tlp, PDO::PARAM_STR);
        $stmt->bindValue(':nip', $this->nip, PDO::PARAM_INT);    
      
        
            
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

        $query = "SELECT nip FROM " . $this->table_name . "";

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
                    nama = ?, alamat = ?, no_tlp = ?";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->nama=htmlspecialchars(strip_tags($this->nama));
        $this->alamat=htmlspecialchars(strip_tags($this->alamat));
        $this->no_tlp=htmlspecialchars(strip_tags($this->no_tlp));
         

        // bind values
        $stmt->bindParam(1, $this->nama);
        $stmt->bindParam(2, $this->alamat);
        $stmt->bindParam(3, $this->no_tlp);
       

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

      public function readOne(){

        $query = "SELECT
                    nama, alamat, no_tlp 
                FROM
                    " . $this->table_name . "
                WHERE
                    nip = ?
                LIMIT
                    0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->nip);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->nama = $row['nama'];
        $this->alamat = $row['alamat'];
        $this->no_tlp = $row['no_tlp'];
       
    }
}
?>