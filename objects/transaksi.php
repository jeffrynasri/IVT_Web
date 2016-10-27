<?php
class Transaksi{

    // database connection and table  
    private $conn;
    private $table_name = "transaksi";

    // object properties
    public $id_tra;
    public $pengeluaran;
    public $pemasukan;
    public $tanggal;

    public function __construct($db){
        $this->conn = $db;
    }
    function readAll($page, $from_record_num, $records_per_page){

    $query = "SELECT
    id_tra, pemasukan, pengeluaran,tanggal 
    FROM
    " . $this->table_name . "
    ORDER BY id_tra
      ASC
    LIMIT
    {$from_record_num}, {$records_per_page}";


    $stmt = $this->conn->prepare( $query );

    $stmt->execute();

    return $stmt;
}
    public function getLastId(){

        $query = "SELECT id_tra FROM " . $this->table_name . " ORDER BY id_tra DESC LIMIT 1";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $last= $row['id_tra'];

        return $last;
    }
    public function TotalPemasukan(){

        $query = "SELECT pemasukan FROM transaksi";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $total = 0;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $total += $pemasukan;
        }
        
        return $total;
    }
    public function TotalPengeluaran(){

        $query = "SELECT pengeluaran FROM transaksi";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $total=0;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $total+=$pengeluaran;
        }
        
        return $total;
    }
    public function delete(){

    $query = "DELETE FROM " . $this->table_name . " WHERE id_tra = ?";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id_tra);


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
                    pengeluaran = :pengeluaran,
                    pemasukan = :pemasukan,
                    tanggal = :tanggal
                    
                WHERE
                    id_tra = :id_tra";

        $stmt = $this->conn->prepare($query);

        // posted values

        $this->pengeluaran=htmlspecialchars(strip_tags($this->pengeluaran));
        $this->pemasukan=htmlspecialchars(strip_tags($this->pemasukan));
        $this->tanggal=htmlspecialchars(strip_tags($this->tanggal));
        $this->id_tra=htmlspecialchars(strip_tags($this->id_tra));

        // bind parameters
        
        $stmt->bindValue(':pengeluaran', $this->pengeluaran, PDO::PARAM_INT);
        $stmt->bindValue(':pemasukan', $this->pemasukan, PDO::PARAM_INT);
        $stmt->bindValue(':tanggal', $this->tanggal, PDO::PARAM_STR);
        $stmt->bindValue(':id_tra', $this->id_tra, PDO::PARAM_INT);    
        
        
        //print_r($stmt);
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

        $query = "SELECT id_tra FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }
    // create product
    function create(){

        // to get time-stamp for 'created' field
        //$this->getTimestamp();

        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                      pengeluaran = ?, pemasukan = ?, tanggal = ?";

        $stmt = $this->conn->prepare($query);

        // posted values
      
        $this->pengeluaran=htmlspecialchars(strip_tags($this->pengeluaran));
        $this->pemasukan=htmlspecialchars(strip_tags($this->pemasukan));
        $this->tanggal=htmlspecialchars(strip_tags($this->tanggal));

        // bind values
     
        $stmt->bindParam(1, $this->pengeluaran);
        $stmt->bindParam(2, $this->pemasukan);
        $stmt->bindParam(3, $this->tanggal);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

    // used for the 'created' field when creating a product
    function getTimestamp(){
        date_default_timezone_set('Asia/Jakarta');
        $this->tanggal = date('Y-m-d H:i:s');
    }
      public function readOne(){

        $query = "SELECT
                     tanggal, pengeluaran, pemasukan 
                FROM
                    " . $this->table_name . "
                WHERE
                    id_tra = ?
                LIMIT
                    0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id_tra);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->tanggal = $row['tanggal'];
        $this->pengeluaran = $row['pengeluaran'];
        $this->pemasukan = $row['pemasukan'];

       
        }
        
       
}
?>