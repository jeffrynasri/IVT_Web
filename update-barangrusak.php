<?php
    include_once "cek_login.php";
?>
<div class="right-button-margin">
    <a href="logout.php" class="btn btn-default pull-right">Logout</a>
</div>
<?php

$page_title = "IVT";
include_once "header.php";
include_once 'config/database.php';
include_once 'objects/barang_rusak.php';
include_once 'objects/pegawai.php';
include_once 'objects/barang.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$pegawai = new Pegawai($db);
$barang = new Barang($db);
$barang_rusak = new Barang_Rusak($db);
?>
<div class="right-button-margin">
    <a href="view-barangrusakp.php" class="btn btn-default pull-right">Kembali</a>
</div>

<!-- Kode apabila form disubmit -->
<?php
echo '<h1 style="text-align:center;">Update Pegawai</h1>';
if($_POST){

    // set product property values
     $barang_rusak = new Barang_Rusak($db);
     $barang_rusak->id_barang_rusak=$_POST['id_barang_rusak'];
    $barang_rusak->nipg=$_POST['nipg'];
     $barang_rusak->nib=$_POST['nib'];
      $barang_rusak->keterangan=$_POST['keterangan'];
       $barang_rusak->jumlah=$_POST['jumlah'];
   
    
    // update the product
    if($barang_rusak->update()){
        echo "<div class=\"alert alert-success alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
            echo "Update Barang Rusak Sukses.";
        echo "</div>";
    }

    // if unable to update the product, tell the user
    else{
        echo "<div class=\"alert alert-danger alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
            echo "Update Barang Rusak Gagal";
        echo "</div>";
        
    }
}
?>

<!-- Dapatkan satu `product` berdasarkan request `id` -->
<?php
  //  echo $_GET['id'];
    $id_barang_rusak = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
//    echo $nipg;
    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // set ID property of product to be edited
    $barang_rusak->id_barang_rusak = $id_barang_rusak;

    //echo $nipg;
    // read the details of product to be edited
    $barang_rusak->readOne();
?>
<!-- Form Edit Product -->
<form action="update-barangrusak.php?id=<?php echo $id;?>" method="post">
    <table class="table table-hover table-responsive table-bordered">
        <input type="hidden" name="id_barang_rusak" value="<?php echo $barang_rusak->id_barang_rusak;?>">
        <tr>
           <td>Pegawai</td>
           <td>
           <?php
                $pegawai->nipg=$barang_rusak->nipg;
                $pegawai->readOne();
                // put them in a select drop-down
                echo "<select class='form-control' name='nipg'>";

                    echo "<option value='$pegawai->nipg'>$pegawai->nama</option>";
                     $temp=$pegawai->nama;
                    $stmt = $pegawai->selectAll();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        if($temp==$nama){
                            continue;
                        }
                        echo "<option value='$nipg'>";
                        echo "$nama</option>";
                    }
                echo "</select>";
            ?>
           </td>
       </tr>
       <tr>
           <td>Barang</td>
           <td>
           <?php
                $barang->nib=$barang_rusak->nib;
                $barang->readOne();
                // put them in a select drop-down
                echo "<select class='form-control' name='nib'>";

                    echo "<option value='$barang->nib'>$barang->nama</option>";
                    $temp=$pegawai->nama;
                    $stmt = $pegawai->selectAll();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                      extract($row);
                      if($temp==$nama){
                            continue;
                        }
                        echo "<option value='$nib'>";
                        echo "$nama</option>";
                    }
                echo "</select>";
            ?>
           </td>
       </tr>
       <tr>
           <td>Jumlah</td>
           <td><input type="number" name="jumlah" class="form-control" value="<?php echo $barang_rusak->jumlah; ?>"></td>
       </tr>
       <tr>
           <td>Keterangan</td>
           <td><input type="text" name="keterangan" class="form-control" value="<?php echo $barang_rusak->keterangan; ?>"></td>
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