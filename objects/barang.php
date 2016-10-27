<?php
class Barang{

    // database connection and table nama
    private $conn;
    private $table_name = "barang";

    // object properties
    public $nib;
    public $nama;
    public $harga_jual;
    public $jumlah;
    public $tanggal_tambah;

    public function __construct($db){
        $this->conn = $db;
    }
    function selectAll(){

        $query = "SELECT
        nib,nama,harga_jual,jumlah,tanggal_tambah
        FROM
        " . $this->table_name . "
        ";


        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }
	function readAll($page, $from_record_num, $records_per_page){

    $query = "SELECT
    nib, nama, jumlah, harga_jual,tanggal_tambah 
    FROM
    " . $this->table_name . "
    ORDER BY
    nama ASC
    LIMIT
    {$from_record_num}, {$records_per_page}";

    $stmt = $this->conn->prepare( $query );
    $stmt->execute();

    return $stmt;
}
		
	public function delete(){

    $query = "DELETE FROM " . $this->table_name . " WHERE nib = ?";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->nib);


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
                    harga_jual = :harga_jual,
                    jumlah = :jumlah,
                    tanggal_tambah= :tanggal_tambah
                    
                WHERE
                    nib = :nib";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->nama=htmlspecialchars(strip_tags($this->nama));
        $this->harga_jual=htmlspecialchars(strip_tags($this->harga_jual));
        $this->jumlah=htmlspecialchars(strip_tags($this->jumlah));
        $this->tanggal_tambah=htmlspecialchars(strip_tags($this->tanggal_tambah));
        $this->nib=htmlspecialchars(strip_tags($this->nib));

        // bind parameters
        $stmt->bindValue(':nama', $this->nama, PDO::PARAM_STR);
        $stmt->bindValue(':harga_jual', $this->harga_jual, PDO::PARAM_INT);
        $stmt->bindValue(':jumlah', $this->jumlah, PDO::PARAM_INT);
        $stmt->bindValue(':tanggal_tambah', $this->tanggal_tambah, PDO::PARAM_STR);
        $stmt->bindValue(':nib', $this->nib, PDO::PARAM_INT);    
		
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

        $query = "SELECT nib FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }
     // used for paging products
    public function getLastId(){

        $query = "SELECT nib FROM " . $this->table_name . " ORDER BY nib DESC LIMIT 1";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $last= $row['nib'];

        return $last;
    }
    // create product
    function create(){

        // to get time-stamp for 'created' field
       // $this->getTimestamp();

        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    nama = ?, harga_jual = ?, jumlah = ?, tanggal_tambah = ? ";

        $stmt = $this->conn->prepare($query);

        // posted values
        $this->nama=htmlspecialchars(strip_tags($this->nama));
        $this->harga_jual=htmlspecialchars(strip_tags($this->harga_jual));
        $this->jumlah=htmlspecialchars(strip_tags($this->jumlah));
        $this->tanggal_tambah=htmlspecialchars(strip_tags($this->tanggal_tambah));

        // bind values
        $stmt->bindParam(1, $this->nama);
        $stmt->bindParam(2, $this->harga_jual);
        $stmt->bindParam(3, $this->jumlah);
        $stmt->bindParam(4, $this->tanggal_tambah);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

    // used for the 'created' field when creating a product
    function getTimestamp(){
        date_default_timezone_set('Asia/Jakarta');
        $this->tanggal_tambah = date('Y-m-d H:i:s');
    }
	  public function readOne(){

        $query = "SELECT
                    nama, harga_jual, jumlah,tanggal_tambah 
                FROM
                    " . $this->table_name . "
                WHERE
                    nib = ?
                LIMIT
                    0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->nib);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->nama = $row['nama'];
        $this->harga_jual = $row['harga_jual'];
        $this->jumlah = $row['jumlah'];
        $this->tanggal_tambah = $row['tanggal_tambah'];
    }
    
        
}
?>