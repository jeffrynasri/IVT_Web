<?php
class Pegawai{

    // database connection and table nama
    private $conn;
    private $table_name = "pegawai";

    // object properties
    public $nipg;
    public $nama;
    public $alamat;
    public $no_tlp;
    public $username;
    public $password;
    

    public function __construct($db){
        $this->conn = $db;
    }
    function selectAll(){

        $query = "SELECT
        nipg,nama,no_tlp,alamat,username,password
        FROM
        " . $this->table_name . "
        ";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }
    function readAll($page, $from_record_num, $records_per_page){

    $query = "SELECT
    nipg, nama, no_tlp, alamat,username,password 
    FROM
    " . $this->table_name . "
    ORDER BY
    nipg ASC
    LIMIT
    {$from_record_num}, {$records_per_page}";

    $stmt = $this->conn->prepare( $query );
    $stmt->execute();

    return $stmt;
}
        
    public function delete(){

    $query = "DELETE FROM " . $this->table_name . " WHERE nipg = ?";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->nipg);


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
                    no_tlp = :no_tlp,
                    username = :username,
                    password = :password
                    
                WHERE
                    nipg = :nipg";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->nama=htmlspecialchars(strip_tags($this->nama));
        $this->alamat=htmlspecialchars(strip_tags($this->alamat));
        $this->no_tlp=htmlspecialchars(strip_tags($this->no_tlp));
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->password=htmlspecialchars(strip_tags($this->password));        
        $this->nipg=htmlspecialchars(strip_tags($this->nipg));

        // bind parameters
        $stmt->bindValue(':nama', $this->nama, PDO::PARAM_STR);
        $stmt->bindValue(':alamat', $this->alamat, PDO::PARAM_STR);
        $stmt->bindValue(':no_tlp', $this->no_tlp, PDO::PARAM_STR);
        $stmt->bindValue(':nipg', $this->nipg, PDO::PARAM_INT);    
        $stmt->bindValue(':username', $this->nipg, PDO::PARAM_STR); 
        $stmt->bindValue(':password', $this->nipg, PDO::PARAM_STR); 
        
            
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

        $query = "SELECT nipg FROM " . $this->table_name . "";

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
                    nama = ?, alamat = ?, no_tlp = ?, username = ?, password = ?";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->nama=htmlspecialchars(strip_tags($this->nama));
        $this->alamat=htmlspecialchars(strip_tags($this->alamat));
        $this->no_tlp=htmlspecialchars(strip_tags($this->no_tlp));
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->password=htmlspecialchars(strip_tags($this->password));        

        // bind values
        $stmt->bindParam(1, $this->nama);
        $stmt->bindParam(2, $this->alamat);
        $stmt->bindParam(3, $this->no_tlp);
        $stmt->bindParam(4, $this->username);
        $stmt->bindParam(5, $this->password);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

      public function readOne(){

        $query = "SELECT
                    nama, alamat, no_tlp ,username,password
                FROM
                    " . $this->table_name . "
                WHERE
                    nipg = ?
                LIMIT
                    0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->nipg);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->nama = $row['nama'];
        $this->alamat = $row['alamat'];
        $this->no_tlp = $row['no_tlp'];
        $this->username = $row['username'];
        $this->password = $row['password'];
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
}
?>