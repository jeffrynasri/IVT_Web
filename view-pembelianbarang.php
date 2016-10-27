<?php
$page_title = "IVT";

include_once 'config/database.php';
include_once 'objects/manajer.php';
include_once 'objects/pegawai.php';
include_once 'objects/barang_rusak.php';
include_once 'objects/barang.php';
include_once 'objects/pemasok.php';
include_once 'objects/transaksi.php';
include_once 'objects/pembelian_barang.php';

include_once "header.php";

?>
<ul class="nav nav-tabs">
  <li class="active"><a href="view-pembelianbarang.php">Pembelian Barang</a></li>
  <li><a href="view-barangrusakm.php">Barang Rusak</a></li>
  <li><a href="view-pegawai.php">Pegawai</a></li>
  <li><a href="view-pemasok.php">Pemasok</a></li>
  <li><a href="view-transaksi.php">Laporan Keuangan</a></li>
</ul>
<!--Button Create Product-->
	
<div class="right-button-margin">
    <a href="tambah-pembelian.php" class="btn btn-default pull-right">Beli Barang</a>
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

$pembelian_barang = new Pembelian_Barang($db);

// Query product
$stmt = $pembelian_barang->readAll($page, $from_record_num, $records_per_page);
$num = $stmt->rowCount();

if ($num >0)
{
    $pemasok = new Pemasok($db);
    $barang = new Barang($db);
    $transaksi = new Transaksi($db);
    $manajer = new Manajer($db);

    echo '<table class="table table-hover table-responsive table-bordered" id="c">';
    echo '  <tr>';
    echo '      <th>Tanggal Beli</th>';
    echo '      <th>Manajer</th>';
    echo '      <th>Pemasok</th>';
    echo '      <th>Nama Barang</th>';
    echo '      <th>Jumlah(Dalam Kardus)</th>';
    echo '      <th>Harga Beli</th>';
    echo '      <th>Harga Jual (satuan)</th>';
    echo '      <th>Actions</th>';
    echo '  </tr>';

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);
        echo '<tr>';
        echo '  <td>';
            $barang->nib = $nib;
            $barang->readOne();
            echo $barang->tanggal_tambah;
        echo '</td>';
        echo '  <td>';
            $manajer->nim = $nim;
            $manajer->readOne();
            echo $manajer->nama;
        echo '</td>';
        echo '  <td>';
            $pemasok->nip = $nip;
            $pemasok->readOne();
            echo $pemasok->nama;
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
            $transaksi->id_tra = $id_tra;
            $transaksi->readOne();
            echo $transaksi->pengeluaran;
        echo '</td>';
        echo '  <td>';
            echo $barang->harga_jual;
        echo '</td>';
        echo '  <td>';
            //<!--Ubah dan Delete button-->
			echo '<a href="update-pembelian.php?id='.$id_pembelian.'" class="btn btn-default left-margin">Ubah</a>';
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
include_once 'paging-pembelianbarang.php';
/*include_once 'paging_category.php';*/
?>




<?
include_once "footer.php";
?>