<?php
    include_once "cek_login_manajer.php";
?>
<div class="right-button-margin">
    <a href="logout_manajer.php" class="btn btn-default pull-right">Logout</a>
</div>
<?php
$page_title = "IVT";

include_once 'config/database.php';
include_once 'objects/transaksi.php';


include_once "header.php";

?>
<ul class="nav nav-tabs">
  <li><a href="view-pembelianbarang.php">Pembelian Barang</a></li>
  <li><a href="view-barangrusakm.php">Barang Rusak</a></li>
  <li><a href="view-pegawai.php">Pegawai</a></li>
  <li><a href="view-pemasok.php">Pemasok</a></li>
  <li  class="active"><a href="view-transaksi.php">Laporan Keuangan</a></li>
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

$transaksi = new Transaksi($db);

// Query product
$stmt = $transaksi->readAll($page, $from_record_num, $records_per_page);
$num = $stmt->rowCount();

if ($num >0)
{
  
    echo '<table class="table table-hover table-responsive table-bordered" id="c">';
     
    echo '  <tr>';
    echo '      <th>Tanggal</th>';
    echo '      <th>Pemasukan</th>';
    echo '      <th>Pengeluaran</th>';
    echo '  </tr>';

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);
        echo '<tr>';
         echo '  <td>'.$tanggal.'</td>';
          echo '  <td>'.$pemasukan.'</td>';
        echo '  <td>'.$pengeluaran.'</td>';
     
        echo '</tr>';
    }

    $tot_pengeluaran= $transaksi->TotalPengeluaran();
    $tot_pemasukan=$transaksi->TotalPemasukan();
    $tot_saldo= $tot_pemasukan-$tot_pengeluaran;
    echo '</table>';

    echo '<table>';
    echo '  <tr>';
    echo '      <th>Total Pemasukan</th>';
    echo '      <th>: Rp. '.$tot_pemasukan.',-</th>';
    echo '  </tr>';
     echo '  <tr>';
    echo '      <th>Total Pengeluaran</th>';
    echo '      <th>: Rp. '.$tot_pengeluaran.',-</th>';
    echo '  </tr>';
    echo '  <tr>';
    echo '      <th>Saldo</th>';
    echo '      <th>: Rp. '.$tot_saldo.',-</th>';
    echo '  </tr>';
    echo '</table>';

    // paging button will be here
}
else
{
    echo '<div>Transaksi Kosong.</div>';
}

?>
<?php
include_once 'paging-transaksi.php';
/*include_once 'paging_category.php';*/
?>


<?
include_once "footer.php";
?>