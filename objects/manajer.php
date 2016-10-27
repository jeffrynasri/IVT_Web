<?php
class Manajer{

    // database connection and table nama
    private $conn;
    private $table_name = "manajer";

    // object properties
    public $nim;
    public $nama;
   
    public $no_tlp;
    public $username;
    public $password;
    

    public function __construct($db){
        $this->conn = $db;
    }
    function selectAll(){

        $query = "SELECT
        nim, nama,no_tlp
        FROM
        " . $this->table_name . "
        ";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }
    function readAll($page, $from_record_num, $records_per_page){

    $query = "SELECT
    nim, nama, no_tlp,username,password 
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

    $query = "DELETE FROM " . $this->table_name . " WHERE nim = ?";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->nim);


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
                    no_tlp = :no_tlp,
                    username = :username,
                    password = :password
                    
                WHERE
                    nim = :nim";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->nama=htmlspecialchars(strip_tags($this->nama));
        $this->no_tlp=htmlspecialchars(strip_tags($this->no_tlp));
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->password=htmlspecialchars(strip_tags($this->password));        
        $this->nim=htmlspecialchars(strip_tags($this->nim));

        // bind parameters
        $stmt->bindValue(':nama', $this->nama, PDO::PARAM_STR);
        $stmt->bindValue(':no_tlp', $this->no_tlp, PDO::PARAM_STR);
        $stmt->bindValue(':nim', $this->nim, PDO::PARAM_INT);    
        $stmt->bindValue(':username', $this->nim, PDO::PARAM_STR); 
        $stmt->bindValue(':password', $this->nim, PDO::PARAM_STR); 
        
            
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

        $query = "SELECT nim FROM " . $this->table_name . "";

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
                    nama = ?, no_tlp = ?, username = ?, password = ?";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->nama=htmlspecialchars(strip_tags($this->nama));
    
        $this->no_tlp=htmlspecialchars(strip_tags($this->no_tlp));
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->password=htmlspecialchars(strip_tags($this->password));        

        // bind values
        $stmt->bindParam(1, $this->nama);
       
        $stmt->bindParam(2, $this->no_tlp);
        $stmt->bindParam(3, $this->username);
        $stmt->bindParam(4, $this->password);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

      public function readOne(){

        $query = "SELECT
                    nama, no_tlp ,username,password
                FROM
                    " . $this->table_name . "
                WHERE
                    nim = ?
                LIMIT
                    0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->nim);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->nama = $row['nama'];
        $this->no_tlp = $row['no_tlp'];
        $this->no_tlp = $row['username'];
        $this->no_tlp = $row['password'];
    }
    function login($username,$password){

        //write query
        $query = "SELECT * FROM
                    " . $this->table_name . "
                WHERE
                    username = '" . $username . "' AND password = '" . $password . "'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        // print_r($stmt);
        $ada =0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            $ada++;
        }
        
        if($stmt->execute() && $ada>0){
            return true;
        }else{
            return false;
        }

    }
   /* function membeli_barang(nim,nip,nib,id_tra){
        include_once 'objects/pembelian_barang.php';

    }*/
}
?>