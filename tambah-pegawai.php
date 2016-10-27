<!--<?php
    include_once "cek_login.php";
?>-->
<?php

$page_title = "IVT";

include_once "header.php";
include_once 'config/database.php';
include_once 'objects/pegawai.php';


$database = new Database();	
$db = $database->getConnection();
?>

<!--Area button Read Products-->

<div class="right-button-margin">
   <a href="view-pegawai.php" class="btn btn-default pull-right">Kembali</a>
</div>
<!--Area memproses POST form-->

<?php
echo '<h1 style="text-align:center;">Tambah Pegawai</h1>';
// if the form was submitted
if($_POST){
  
   $pegawai = new Pegawai($db);
   
   $pegawai->nama =$_POST['nama'];
   $pegawai->alamat=$_POST['alamat'];
   $pegawai->no_tlp=$_POST['no_tlp'];
   $pegawai->username=$_POST['username'];
   $pegawai->password=$_POST['password'];
   if($pegawai->create()){
       echo '<div class="alert alert-success alert-dismissable">';
           echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
           echo "Pegawai Berhasil Ditambahkan.";
       echo "</div>";
   }

   // if unable to create the product, tell the user
   else{
       echo '<div class="alert alert-danger alert-dismissable">';
           echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
           echo 'Pegawai Gagal Ditambahkan.';
       echo '</div>';
   }
  
}

?>

<!--Area Form-->
<form action="tambah-pegawai.php" method="post">
   <table class="table table-hover table-responsive table-bordered">
       <tr>
           <td>Nama</td>
           <td><input type="text" name="nama" class="form-control"></td>
       </tr>
       <tr>
           <td>Alamat</td>
           <td><input type="text" name="alamat" class="form-control"></td>
       </tr>
       <tr>
           <td>No Telepon</td>
           <td><input type="number" name="no_tlp" class="form-control"></td>
       </tr>
       <tr>
           <td>Username</td>
           <td><input type="text" name="username" class="form-control"></td>
       </tr>
       <tr>
           <td>Password</td>
           <td><input type="text" name="password" class="form-control"></td>
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