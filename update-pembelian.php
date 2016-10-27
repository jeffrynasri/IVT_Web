<?php
   // include_once "cek_login.php";
?>
<?php

$page_title = "IVT";
include_once "header.php";
include_once 'config/database.php';
include_once 'objects/manajer.php';
include_once 'objects/pegawai.php';
include_once 'objects/barang_rusak.php';
include_once 'objects/barang.php';
include_once 'objects/pemasok.php';
include_once 'objects/transaksi.php';
include_once 'objects/pembelian_barang.php';

$database = new Database();
$db = $database->getConnection();
?>
<div class="right-button-margin">
    <a href="view-pembelianbarang.php" class="btn btn-default pull-right">Kembali</a>
</div>

<!-- Kode apabila form disubmit -->
<?php
echo '<h1 style="text-align:center;">Update Pembelian Barang</h1>';
if($_POST){

    // set product property values
    $pembelian_barang = new Pembelian_Barang($db);
    $barang = new Barang($db);
    $transaksi = new Transaksi($db);

    $pembelian_barang->id_pembelian = $_POST['id_pembelian'];
    $pembelian_barang->nim = $_POST['nim'];
	$pembelian_barang->nip = $_POST['nip'];
    $pembelian_barang->nib = $_POST['nib'];
    $pembelian_barang->id_tra = $_POST['id_tra'];
   
    $barang->nib= $_POST['nib'];
    $barang->readOne();
    $barang->jumlah=$_POST['bar_jumlah'];
    $barang->harga_jual=$_POST['bar_harga_jual'];
    $barang->tanggal_tambah=$_POST['tanggal_tambah'];

    $transaksi->id_tra= $_POST['id_tra'];
    $transaksi->readOne();
    $transaksi->pengeluaran=$_POST['tra_pengeluaran'];
    $transaksi->tanggal=$_POST['tanggal_tambah'];
/*
    echo $_POST['id_pembelian'];
    echo $_POST['nim'];
    echo $_POST['nip'];
    echo $_POST['nib'];
    echo$_POST['id_tra'];
    echo $_POST['bar_jumlah'];
    echo $_POST['bar_harga_jual'];
    echo $_POST['tanggal_tambah'];
    echo $_POST['tra_pengeluaran'];
  */  // update the product
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
    
    if($pembelian_barang->update()){
        echo "<div class=\"alert alert-success alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
            echo "Update Pembelian Barang Sukses.";
        echo "</div>";
    }

    // if unable to update the product, tell the user
    else{
        echo "<div class=\"alert alert-danger alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
            echo "Update Pembelian Barang Gagal";
        echo "</div>";
		
    }
}
?>

<!-- Dapatkan satu `product` berdasarkan request `id` -->
<?php
  //  echo $_GET['id'];
    $id_pembelian = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
//    echo $id_pembelian;
    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare product object
    $pembelian_barang = new Pembelian_Barang($db);
    $manajer=new Manajer($db);
    $pemasok=new Pemasok($db);
    $barang=new Barang($db);
    $transaksi=new Transaksi($db);
    // set ID property of product to be edited
    $pembelian_barang->id_pembelian = $id_pembelian;
    $pembelian_barang->readOne();

    $manajer->nim=$pembelian_barang->nim;
    $pemasok->nip=$pembelian_barang->nip;
    $barang->nib=$pembelian_barang->nib;
    $transaksi->id_tra=$pembelian_barang->id_tra;

    $manajer->readOne();
    $pemasok->readOne();
    $barang->readOne();
    $transaksi->readOne();
    
?>
<!-- Form Edit Product -->
<form action="update-pembelian.php?id=<?php echo $id;?>" method="post">
    <table class="table table-hover table-responsive table-bordered">
        <input type="hidden" name="id_pembelian" value="<?php echo $pembelian_barang->id_pembelian;?>">
        <input type="hidden" name="nib" value="<?php echo $barang->nib;?>">
        <input type="hidden" name="id_tra" value="<?php echo $transaksi->id_tra;?>">
        <tr>
           <td>Tanggal Beli</td>
           <td><input type="date" name="tanggal_tambah" class="form-control"value="<?php echo $barang->tanggal_tambah; ?>"></td>
       </tr>
       <tr>
           <td>Manajer</td>
           <td>
           <?php
                
                // put them in a select drop-down
                echo "<select class='form-control' name='nim'>";

                    echo "<option value='$manajer->nim'>$manajer->nama</option>";
                    $temp=$manajer->nama;
                    $stmt = $manajer->selectAll();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        if($temp==$nama){
                            continue;
                        }
                        echo "<option value='$nim'>";
                        echo "$nama</option>";
                    }
                echo "</select>";
            ?>
           </td>
       </tr>
       <tr>
           <td>Pemasok</td>
           <td>
           <?php
                // put them in a select drop-down
                echo "<select class='form-control' name='nip'>";

                    echo "<option value='$pemasok->nip'>$pemasok->nama</option>";
                    $temp=$pemasok->nama;
                    $stmt = $pemasok->selectAll();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        if($nama==$temp){
                            continue;
                        }
                        echo "<option value='$nip'>";
                        echo "$nama</option>";
                    }
                echo "</select>";
            ?>
           </td>
       </tr>
       <tr>
           <td>Nama Barang</td>
           <td><input type="text" name="bar_nama" class="form-control" value="<?php echo $barang->nama; ?>"></td>
       </tr>
       <tr>
           <td>Jumlah</td>
           <td><input type="number" name="bar_jumlah" value="<?php echo $barang->jumlah; ?>"> Kardus </td>
           
       </tr>
        <tr>
           <td>Harga Beli</td>
           <td>Rp <input type="number" name="tra_pengeluaran" value="<?php echo $transaksi->pengeluaran; ?>"> ,- </td>
           
       </tr>
       
       <tr>
           <td>Harga Jual (satuan) </td>
           
           <td> Rp <input type="number" name="bar_harga_jual" value="<?php echo $barang->harga_jual; ?>"> ,- </td>
           
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