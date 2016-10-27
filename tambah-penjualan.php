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
include_once 'objects/penjualan_barang.php';
include_once 'objects/transaksi.php';
include_once 'objects/pegawai.php';


$database = new Database();	
$db = $database->getConnection();
?>

<!--Area button Read Products-->

<div class="right-button-margin">
   <a href="view-penjualanbarang.php" class="btn btn-default pull-right">Kembali</a>
</div>
<!--Area memproses POST form-->

<?php
echo '<h1 style="text-align:center;">Penjualan Barang</h1>';
// if the form was submitted
if($_POST){
  
   $penjualan_barang = new Penjualan_Barang($db);
   $transaksi = new Transaksi($db);
   $barang = new Barang($db);  
   $pegawai = new Pegawai($db);  
   // set product property values
   
   $transaksi->pemasukan=$_POST['pemasukan'];
   $transaksi->pengeluaran=0;
   $transaksi->tanggal=$_POST['tanggal'];
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
  
  
   
   $penjualan_barang->nipg =$_POST['nipg'];
   $penjualan_barang->nib=$_POST['nib'];
   $penjualan_barang->id_tra=$transaksi->getLastId() ;
   
   if($penjualan_barang->create()){
       echo '<div class="alert alert-success alert-dismissable">';
           echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
           echo "Penjualan Barang Berhasil Ditambahkan.";
       echo "</div>";
   }

   else{
       echo '<div class="alert alert-danger alert-dismissable">';
           echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
           echo 'Penjualan Barang Gagal Ditambahkan.';
       echo '</div>';
   }
}

?>
  
<form action="tambah-penjualan.php" method="post">
   <table class="table table-hover table-responsive table-bordered">
       <tr>
           <td>Tanggal Jual</td>
           <td><input type="date" name="tanggal" class="form-control"></td>
       </tr>
       <tr>
           <td>Pegawai</td>
           <td>
           <?php
                // read the product categookries from the database
                include_once 'objects/pegawai.php';

                $pegawai = new Pegawai($db);
                $stmt = $pegawai->selectAll();
                
                // put them in a select drop-down
                echo "<select class='form-control' name='nipg'>";

                    echo "<option>Silakan Pilih...</option>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        
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
                // read the product categookries from the database
                include_once 'objects/barang.php';

                $barang = new Barang($db);
                $stmt = $barang->selectAll();
                
                // put them in a select drop-down
                echo "<select class='form-control' name='nib'>";

                    echo "<option>Silakan Pilih...</option>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        
                        echo "<option value='$nib'>";
                        echo "$nama</option>";
                    }
                echo "</select>";
            ?>
           </td>
       </tr>
       <tr>
           <td>Jumlah (Dalam Kardus)</td>
           <td><input type="number" name="jumlah" class="form-control"></td>
       </tr>
       <tr>
           <td>Total</td>
           <td><input type="number" name="pemasukan" class="form-control"></td>
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