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
include_once 'objects/barang.php';
include_once 'objects/pegawai.php';
include_once 'objects/transaksi.php';
include_once 'objects/penjualan_barang.php';

$database = new Database();
$db = $database->getConnection();
?>
<div class="right-button-margin">
    <a href="view-penjualanbarang.php" class="btn btn-default pull-right">Kembali</a>
</div>

<!-- Kode apabila form disubmit -->
<?php
echo '<h1 style="text-align:center;">Update Penjualan Barang</h1>';
if($_POST){

    // set product property values
    $penjualan_barang = new Penjualan_Barang($db);
    $barang = new Barang($db);
    $transaksi = new Transaksi($db);

    $penjualan_barang->id_penjualan = $_POST['id_penjualan'];
    $penjualan_barang->nipg = $_POST['nipg'];
    $penjualan_barang->nib = $_POST['nib'];
    $penjualan_barang->id_tra = $_POST['id_tra'];

   /* $barang->nib= $_POST['nib'];
    $barang->readOne();
    $barang->jumlah=$_POST['bar_jumlah'];*/

    $transaksi->id_tra= $_POST['id_tra'];
    $transaksi->readOne();
    //echo $transaksi->pengeluaran;
    $transaksi->pemasukan=$_POST['total'];
    $transaksi->tanggal=$_POST['tanggal'];
/*
    echo $_POST['id_penjualan'];
    echo $_POST['nim'];
    echo $_POST['nip'];
    echo $_POST['nib'];
    echo$_POST['id_tra'];
    echo $_POST['bar_jumlah'];
    echo $_POST['bar_harga_jual'];
    echo $_POST['tanggal_tambah'];
    echo $_POST['tra_pengeluaran'];
  */  // update the product
    if($transaksi->update()){
        echo "<div class=\"alert alert-success alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
            echo "Update Transaksi Sukses.";
        echo "</div>";
    }

    // if unable to update the product, tell the user
    else{
        echo "<div class=\"alert alert-danger alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
            echo "Update Transaksi Gagal";
        echo "</div>";
    
    }
    if($penjualan_barang->update()){
        echo "<div class=\"alert alert-success alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
            echo "Update Penjualan Barang Sukses.";
        echo "</div>";
    }

    // if unable to update the product, tell the user
    else{
        echo "<div class=\"alert alert-danger alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
            echo "Update Penjualan_Barang Gagal";
        echo "</div>";
		
    }
}
?>

<!-- Dapatkan satu `product` berdasarkan request `id` -->
<?php
  //  echo $_GET['id'];
    $id_penjualan = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
//    echo $id_penjualan;
    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare product object
    $penjualan_barang = new Penjualan_Barang($db);
    $pegawai=new Pegawai($db);
    $barang=new Barang($db);
    $transaksi=new Transaksi($db);
    // set ID property of product to be edited
    $penjualan_barang->id_penjualan = $id_penjualan;
    $penjualan_barang->readOne();

   
    $pegawai->nipg=$penjualan_barang->nipg;
    $barang->nib=$penjualan_barang->nib;
    $transaksi->id_tra=$penjualan_barang->id_tra;

    $pegawai->readOne();
    $barang->readOne();
    $transaksi->readOne();
    
?>
<!-- Form Edit Product -->
<form action="update-penjualan.php?id=<?php echo $id;?>" method="post">
    <table class="table table-hover table-responsive table-bordered">
        <input type="hidden" name="id_penjualan" value="<?php echo $penjualan_barang->id_penjualan;?>">
        <input type="hidden" name="nib" value="<?php echo $barang->nib;?>">
        <input type="hidden" name="id_tra" value="<?php echo $transaksi->id_tra;?>">
        <tr>
           <td>Tanggal Jual</td>
           <td><input type="date" name="tanggal" class="form-control"value="<?php echo $barang->tanggal_tambah; ?>"></td>
       </tr>
       <tr>
           <td>Pegawai</td>
           <td>
           <?php
                
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
           <td>Nama Barang</td>
           <td>
           <?php
              
              
                
                // put them in a select drop-down
                echo "<select class='form-control' name='nib'>";

                    echo "<option value='$barang->nib'>$barang->nama</option>";
                    $temp=$barang->nama;
                      $stmt = $barang->selectAll();
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
           <td>Jumlah(Dalam Kardus)</td>
           <td><input type="number" name="jumlah" class="form-control"value="<?php echo $barang->jumlah; ?>"></td>
       </tr>
       <tr>
           <td>Total</td>
           <td><input type="number" name="total" class="form-control"value="<?php echo $transaksi->pemasukan; ?>"></td>
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