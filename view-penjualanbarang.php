<?php
    include_once "cek_login_pegawai.php";
?>
<div class="right-button-margin">
    <a href="logout_pegawai.php" class="btn btn-default pull-right">Logout</a>
</div>
<?php
$page_title = "IVT";

include_once 'config/database.php';
include_once 'objects/manajer.php';
include_once 'objects/pegawai.php';
include_once 'objects/barang_rusak.php';
include_once 'objects/barang.php';
include_once 'objects/pemasok.php';
include_once 'objects/transaksi.php';
include_once 'objects/penjualan_barang.php';

include_once "header.php";

?>
<ul class="nav nav-tabs">
  <li class="active" ><a href="view-penjualanbarang.php">Penjualan</a></li>
  <li ><a href="view-barang.php">Barang</a></li>
  <li><a href="view-barangrusakp.php">Barang Rusak</a></li>
</ul>
<!--Button Create Product-->
    
<div class="right-button-margin">
    <a href="tambah-penjualan.php" class="btn btn-default pull-right">Tambah</a>
</div>

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

$penjualan_barang = new Penjualan_Barang($db);

// Query product
$stmt = $penjualan_barang->readAll($page, $from_record_num, $records_per_page);
$num = $stmt->rowCount();

if ($num >0)
{
    $pegawai = new Pegawai($db);
    $barang = new Barang($db);
    $transaksi = new Transaksi($db);

    echo '<table class="table table-hover table-responsive table-bordered" id="c">';
    echo '  <tr>';
    echo '      <th>Tanggal Jual</th>';
    echo '      <th>Pegawai</th>';
    echo '      <th>Nama Barang</th>';
    echo '      <th>Jumlah(Dalam Kardus)</th>';
    echo '      <th>Total</th>';
    echo '      <th>Actions</th>';
    echo '  </tr>';

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);
        echo '<tr>';
        echo '  <td>';
            $transaksi->id_tra = $id_tra;
            $transaksi->readOne();
            echo $transaksi->tanggal;
        echo '</td>';
        echo '  <td>';
            $pegawai->nipg = $nipg;
            $pegawai->readOne();
            echo $pegawai->nama;
        echo '</td>';
        echo '  <td>';
            $barang->nib = $nib;
            $barang->readOne();
            echo $barang->nama;
        echo '</td>';
        echo '  <td>';
            echo $barang->jumlah;
        echo '</td>';
        echo '  <td>';
            echo $transaksi->pemasukan;
        echo '</td>';
        
        echo '  <td>';
            //<!--Ubah dan Delete button-->
            echo '<a href="update-penjualan.php?id='.$id_penjualan.'" class="btn btn-default left-margin">Ubah</a>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</table>';

    // paging button will be here
}
else
{
    echo '<div>Penjualan Barang Kosong.</div>';
}

?>
<?php
include_once 'paging-penjualanbarang.php';
/*include_once 'paging_category.php';*/
?>




<?
include_once "footer.php";
?>