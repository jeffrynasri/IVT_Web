<?php
    include_once "cek_login_manajer.php";
?>
<div class="right-button-margin">
    <a href="logout_manajer.php" class="btn btn-default pull-right">Logout</a>
</div>
<?php

$page_title = "IVT";
include_once "header.php";
include_once 'config/database.php';
include_once 'objects/pegawai.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$pegawai = new Pegawai($db);

?>
<div class="right-button-margin">
    <a href="view-pegawai.php" class="btn btn-default pull-right">Kembali</a>
</div>

<!-- Kode apabila form disubmit -->
<?php
echo '<h1 style="text-align:center;">Update Pegawai</h1>';
if($_POST){

    // set product property values
    $pegawai = new Pegawai($db);

    $pegawai->nama = $_POST['nama'];
    $pegawai->alamat = $_POST['alamat'];
    $pegawai->no_tlp = $_POST['no_tlp'];
    $pegawai->username = $_POST['username'];
    $pegawai->password = $_POST['password'];
    $pegawai->nipg = $_POST['nipg'];
   
    
    // update the product
    if($pegawai->update()){
        echo "<div class=\"alert alert-success alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
            echo "Update Pegawai Sukses.";
        echo "</div>";
    }

    // if unable to update the product, tell the user
    else{
        echo "<div class=\"alert alert-danger alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
            echo "Update Pegawai Gagal";
        echo "</div>";
        
    }
}
?>

<!-- Dapatkan satu `product` berdasarkan request `id` -->
<?php
  //  echo $_GET['id'];
    $nipg = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
//    echo $nipg;
    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare product object
    $pegawai = new Pegawai($db);

    // set ID property of product to be edited
    $pegawai->nipg = $nipg;

    //echo $nipg;
    // read the details of product to be edited
    $pegawai->readOne();
?>
<!-- Form Edit Product -->
<form action="update-pegawai.php?id=<?php echo $id;?>" method="post">
    <table class="table table-hover table-responsive table-bordered">
        <input type="hidden" name="nipg" value="<?php echo $pegawai->nipg;?>">
        <tr>
            <td>Nama</td>
            <td><input type="text" name="nama" value="<?php echo $pegawai->nama; ?>"></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td><input type="text" name="alamat" value="<?php echo $pegawai->alamat; ?>"></td>
        </tr>
         <tr>
            <td>No Telepon</td>
            <td><input type="number" name="no_tlp" value="<?php echo $pegawai->no_tlp; ?>"></td>
        </tr>
        <tr>
            <td>Username</td>
            <td><input type="text" name="username" value="<?php echo $pegawai->username; ?>"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="text" name="password" value="<?php echo $pegawai->password; ?>"></td>
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