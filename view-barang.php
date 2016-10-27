<?php
    include_once "cek_login_pegawai.php";
?>
<div class="right-button-margin">
    <a href="logout_pegawai.php" class="btn btn-default pull-right">Logout</a>
</div>
<?php
$page_title = "IVT";

include_once 'config/database.php';
include_once 'objects/barang.php';


include_once "header.php";

?>
<ul class="nav nav-tabs">
  <li ><a href="view-penjualanbarang.php">Penjualan</a></li>
  <li class="active"><a href="view-barang.php">Barang</a></li>
  <li><a href="view-barangrusakp.php">Barang Rusak</a></li>
</ul>
<!--Button Create Product-->

<!--Content area-->




<?php 
// Tambahkan pagination
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Set jumlah record dalam 1 halaman
$records_per_page = 3;

// Hitung limit data dalam query
$from_record_num = ($records_per_page * $page) - $records_per_page;


$database = new Database();
$db = $database->getConnection();

$barang = new Barang($db);

// Query product
$stmt = $barang->readAll($page, $from_record_num, $records_per_page);
$num = $stmt->rowCount();

if ($num >0)
{

    echo '<table class="table table-hover table-responsive table-bordered" id="c">';
    echo '  <tr>';
    echo '      <th>Tanggal Masuk</th>';
    echo '      <th>Nama</th>';
    echo '      <th>Jumlah</th>';
    echo '      <th>Harga Jual</th>';
    echo '      <th>Actions</th>';
    echo '  </tr>';

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);
        echo '  <td>'.$tanggal_tambah.'</td>';
        echo '  <td>'.$nama.'</td>';
        echo '  <td>'.$jumlah.'</td>';
        echo '  <td>'.$harga_jual.'</td>';
        echo '  <td>';
            //<!--Ubah dan Hapus button-->
            echo '<a href="update-barang.php?id='.$nib.'" class="btn btn-default left-margin">Ubah</a>';
           
        echo '</td>';
        echo '</tr>';
    }

    echo '</table>';

    // paging button will be here
}
else
{
    echo '<div>Barang Kosong.</div>';
}

?>
<?php
include_once 'paging-barang.php';
/*include_once 'paging_category.php';*/
?>



<!-- Script untuk delete product -->

<?
include_once "footer.php";
?>