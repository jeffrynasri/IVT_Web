<?php
   // include_once "cek_login.php";
?>
<?php

$page_title = "IVT";
include_once "header.php";
include_once 'config/database.php';
include_once 'objects/barang.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$barang = new Barang($db);

?>
<div class="right-button-margin">
    <a href="view-barang.php" class="btn btn-default pull-right">Kembali</a>
</div>

<!-- Kode apabila form disubmit -->
<?php
echo '<h1 style="text-align:center;">Update Barang</h1>';
if($_POST){

    // set product property values
    $barang = new Barang($db);

    $barang->tanggal_tambah = $_POST['tanggal_tambah'];
    $barang->nama = $_POST['nama'];
    $barang->jumlah = $_POST['jumlah'];
    $barang->harga_jual = $_POST['harga_jual'];
    $barang->nib = $_POST['nib'];
   
    
    // update the product
    if($barang->update()){
        echo "<div class=\"alert alert-success alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
            echo "Update Barang Sukses.";
        echo "</div>";
    }

    // if unable to update the product, tell the user
    else{
        echo "<div class=\"alert alert-danger alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
            echo "Update Barang Gagal";
        echo "</div>";
        
    }
}
?>

<!-- Dapatkan satu `product` berdasarkan request `id` -->
<?php
  //  echo $_GET['id'];
    $nib = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
//    echo $nib;
    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare product object
    $barang = new Barang($db);

    // set ID property of product to be edited
    $barang->nib = $nib;

    //echo $nib;
    // read the details of product to be edited
    $barang->readOne();
?>
<!-- Form Edit Product -->
<form action="update-barang.php?id=<?php echo $id;?>" method="post">
    <table class="table table-hover table-responsive table-bordered">
        <input type="hidden" name="nib" value="<?php echo $barang->nib;?>">
        <tr>
            <td>Tanggal Beli</td>
            <td><input type="date" name="tanggal_tambah" value="<?php echo $barang->tanggal_tambah; ?>"></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td><input type="text" name="nama" value="<?php echo $barang->nama; ?>"></td>
        </tr>
         <tr>
            <td>Jumlah</td>
            <td><input type="number" name="jumlah" value="<?php echo $barang->jumlah; ?>"></td>
        </tr>
        <tr>
            <td>Harga(satuan)</td>
            <td><input type="text" name="harga_jual" value="<?php echo $barang->harga_jual; ?>"></td>
        </tr>
      
        <tr>
            <td></td>
            <td>
                <button class="btn btn-primary" type="submit">Update</button>
            </td>
        </tr>
    </table>
</form>

<?php

include_once "footer.php";
?>