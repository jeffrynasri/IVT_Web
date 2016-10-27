<!--<?php
    include_once "cek_login.php";
?>-->
<?php

$page_title = "IVT";

include_once "header.php";
include_once 'config/database.php';
include_once 'objects/barang_rusak.php';
include_once 'objects/pegawai.php';
include_once 'objects/barang.php';


$database = new Database(); 
$db = $database->getConnection();
?>

<!--Area button Read Products-->

<div class="right-button-margin">
   <a href="view-barangrusakp.php" class="btn btn-default pull-right">Kembali</a>
</div>
<!--Area memproses POST form-->

<?php
echo '<h1 style="text-align:center;">Tambah Barang Rusak</h1>';
// if the form was submitted
if($_POST){
  
   $barang_rusak = new Barang_Rusak($db);
   $barang_rusak->nipg=$_POST['nipg'];
   $barang_rusak->nib=$_POST['nib'];
   $barang_rusak->keterangan=$_POST['keterangan'];
   $barang_rusak->jumlah=$_POST['jumlah'];

   if($barang_rusak->create()){
       echo '<div class="alert alert-success alert-dismissable">';
           echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
           echo "Barang Rusak Berhasil Ditambahkan.";
       echo "</div>";
   }

   // if unable to create the product, tell the user
   else{
       echo '<div class="alert alert-danger alert-dismissable">';
           echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
           echo 'Barang Rusak Gagal Ditambahkan.';
       echo '</div>';
   }
  
}

?>

<!--Area Form-->
<form action="tambah-barangrusak.php" method="post">
   <table class="table table-hover table-responsive table-bordered">
      <tr>
           <td>Pegawai</td>
           <td>
           <?php
                $pegawai= new Pegawai($db);
                $stmt = $pegawai->selectAll();
                // put them in a select drop-down
                echo "<select class='form-control' name='nipg'>";

                    echo "<option>Silahkan Dipilih.......</option>";
      
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
           <td>Barang</td>
           <td>
           <?php
                $barang= new Barang($db);
                $stmt = $barang->selectAll();
                // put them in a select drop-down
                echo "<select class='form-control' name='nib'>";

                    echo "<option>Silahkan Dipilih.......</option>";
      
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
           <td>Jumlah</td>
           <td><input type="number" name="jumlah" class="form-control"></td>
       </tr>
       <tr>
           <td>Keterangan</td>
           <td><input type="text" name="keterangan" class="form-control"></td>
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