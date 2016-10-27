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
include_once 'objects/barang.php';
include_once 'objects/pembelian_barang.php';
include_once 'objects/pemasok.php';
include_once 'objects/transaksi.php';
include_once 'objects/manajer.php';

$database = new Database();	
$db = $database->getConnection();
?>

<!--Area button Read Products-->

<div class="right-button-margin">
   <a href="view-pembelianbarang.php" class="btn btn-default pull-right">Kembali</a>
</div>
<!--Area memproses POST form-->

<?php
echo '<h1 style="text-align:center;">Pembelian Barang</h1>';
// if the form was submitted
if($_POST){
  
   $pembelian_barang = new Pembelian_Barang($db);
   $transaksi = new Transaksi($db);
   $barang = new Barang($db);  
   // set product property values
   
   $barang->nama =$_POST['nama'];
   $barang->harga_jual=$_POST['harga_jual'];
   $barang->jumlah=$_POST['jumlah'];
   $barang->tanggal_tambah=$_POST['tanggal_tambah'];
   if($barang->create()){
       echo '<div class="alert alert-success alert-dismissable">';
           echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
           echo "Barang Berhasil Ditambahkan.";
       echo "</div>";
   }

   // if unable to create the product, tell the user
   else{
       echo '<div class="alert alert-danger alert-dismissable">';
           echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
           echo 'barang Gagal Ditambahkan.';
       echo '</div>';
   }
  
   $transaksi->pengeluaran=$_POST['pengeluaran'];
   $transaksi->pemasukan=0;
   $transaksi->tanggal=$_POST['tanggal_tambah'];
  if($transaksi->create()){
       echo '<div class="alert alert-success alert-dismissable">';
           echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
           echo "Transaksi Berhasil Ditambahkan.";
       echo "</div>";
   }

   // if unable to create the product, tell the user
   else{
       echo '<div class="alert alert-danger alert-dismissable">';
           echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
           echo 'Transaksi Gagal Ditambahkan.';
       echo '</div>';
   }
   
   $pembelian_barang->nim=$_POST['nim'];
   $pembelian_barang->nip =$_POST['nip'];
   $pembelian_barang->nib=$barang->getLastId() ;
   $pembelian_barang->id_tra=$transaksi->getLastId() ;
   
   if($pembelian_barang->create()){
       echo '<div class="alert alert-success alert-dismissable">';
           echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
           echo "Pembelian Barang Berhasil Ditambahkan.";
       echo "</div>";
   }

   else{
       echo '<div class="alert alert-danger alert-dismissable">';
           echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
           echo 'Pembelian Barang Gagal Ditambahkan.';
       echo '</div>';
   }
}

?>

<!--Area Form-->
<form action="tambah-pembelian.php" method="post">
   <table class="table table-hover table-responsive table-bordered">
       <tr>
           <td>Tanggal Beli</td>
           <td><input type="date" name="tanggal_tambah" class="form-control"></td>
       </tr>
       <tr>
           <td>Manajer</td>
           <td>
           <?php
                // read the product categookries from the database
                include_once 'objects/manajer.php';

                $manajer = new Manajer($db);
                $stmt = $manajer->selectAll();
                
                // put them in a select drop-down
                echo "<select class='form-control' name='nim'>";

                    echo "<option>Silakan Pilih...</option>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        
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
                // read the product categookries from the database
                include_once 'objects/pemasok.php';

                $pemasok = new Pemasok($db);
                $stmt = $pemasok->selectAll();
                
                // put them in a select drop-down
                echo "<select class='form-control' name='nip'>";

                    echo "<option>Silakan Pilih...</option>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        
                        echo "<option value='$nip'>";
                        echo "$nama</option>";
                    }
                echo "</select>";
            ?>
           </td>
       </tr>
       <tr>
           <td>Nama Barang</td>
           <td><input type="text" name="nama" class="form-control"></td>
       </tr>
       <tr>
           <td>Jumlah</td>
           <td><input type="number" name="jumlah"> Kardus </td>
           
       </tr>
        <tr>
           <td>Harga Beli</td>
           <td>Rp <input type="number" name="pengeluaran"> ,- </td>
           
       </tr>
       
       <tr>
           <td>Harga Jual (satuan) </td>
           
           <td> Rp <input type="number" name="harga_jual"> ,- </td>
           
       </tr>
       
       <tr>
           <td></td>
           <td>
               <button class="btn btn-primary" type="submit">Tambahkan</button>
           </td>
       </tr>
   </table>
</form>


<?php
include_once "footer.php";
?>