<?php
    include_once "cek_login_pegawai.php";
?>
<div class="right-button-margin">
    <a href="logout_pegawai.php" class="btn btn-default pull-right">Logout</a>
</div>
<?php

$page_title = "IVT";
include_once "header.php";
include_once 'config/database.php';
include_once 'objects/pemasok.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$pemasok = new Pemasok($db);

?>
<div class="right-button-margin">
    <a href="view-pemasok.php" class="btn btn-default pull-right">Kembali</a>
</div>

<!-- Kode apabila form disubmit -->
<?php
echo '<h1 style="text-align:center;">Update Pemasok</h1>';
if($_POST){

    // set product property values
    $pemasok = new Pemasok($db);

    $pemasok->nama = $_POST['nama'];
    $pemasok->alamat = $_POST['alamat'];
	$pemasok->no_tlp = $_POST['no_tlp'];
    $pemasok->nip = $_POST['nip'];
   
    
    // update the product
    if($pemasok->update()){
        echo "<div class=\"alert alert-success alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
            echo "Update Pemasok Sukses.";
        echo "</div>";
    }

    // if unable to update the product, tell the user
    else{
        echo "<div class=\"alert alert-danger alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
            echo "Update Pemasok Gagal";
        echo "</div>";
		
    }
}
?>

<!-- Dapatkan satu `product` berdasarkan request `id` -->
<?php
  //  echo $_GET['id'];
    $nip = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
//    echo $nip;
    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare product object
    $pemasok = new Pemasok($db);

    // set ID property of product to be edited
    $pemasok->nip = $nip;

    //echo $nip;
    // read the details of product to be edited
    $pemasok->readOne();
?>
<!-- Form Edit Product -->
<form action="update-pemasok.php?id=<?php echo $id;?>" method="post">
    <table class="table table-hover table-responsive table-bordered">
        <input type="hidden" name="nip" value="<?php echo $pemasok->nip;?>">
        <tr>
            <td>Nama</td>
            <td><input type="text" name="nama" value="<?php echo $pemasok->nama; ?>"></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td><input type="text" name="alamat" value="<?php echo $pemasok->alamat; ?>"></td>
        </tr>
         <tr>
            <td>No Telepon</td>
            <td><input type="number" name="no_tlp" value="<?php echo $pemasok->no_tlp; ?>"></td>
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