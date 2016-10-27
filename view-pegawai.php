<?php
$page_title = "IVT";

include_once 'config/database.php';
include_once 'objects/pegawai.php';


include_once "header.php";

?>
<ul class="nav nav-tabs">
  <li ><a href="view-pembelianbarang.php">Pembelian Barang</a></li>
  <li><a href="view-barangrusakm.php">Barang Rusak</a></li>
  <li class="active"><a href="view-pegawai.php">Pegawai</a></li>
  <li ><a href="view-pemasok.php">Pemasok</a></li>
  <li><a href="view-transaksi.php">Laporan Keuangan</a></li>
</ul>
<!--Button Create Product-->
    
<div class="right-button-margin">
    <a href="tambah-pegawai.php" class="btn btn-default pull-right">Tambah</a>
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

$pegawai = new Pegawai($db);

// Query product
$stmt = $pegawai->readAll($page, $from_record_num, $records_per_page);
$num = $stmt->rowCount();

if ($num >0)
{

    echo '<table class="table table-hover table-responsive table-bordered" id="c">';
    echo '  <tr>';
    echo '      <th>Nipg</th>';
    echo '      <th>Nama</th>';
    echo '      <th>Alamat</th>';
    echo '      <th>No Telepon</th>';
    echo '      <th>Username</th>';
    echo '      <th>Password</th>';
    echo '      <th>Actions</th>';
    echo '  </tr>';

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);
        echo '  <td>'.$nipg.'</td>';
        echo '  <td>'.$nama.'</td>';
        echo '  <td>'.$alamat.'</td>';
        echo '  <td>'.$no_tlp.'</td>';
        echo '  <td>'.$username.'</td>';
        echo '  <td>'.$password.'</td>';
        echo '  <td>';
            //<!--Ubah dan Hapus button-->
            echo '<a href="update-pegawai.php?id='.$nipg.'" class="btn btn-default left-margin">Ubah</a>';
            echo '<a delete-id="'.$nipg.'" class="btn btn-danger delete-object">Hapus</a>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</table>';

    // paging button will be here
}
else
{
    echo '<div>Pegawai Kosong.</div>';
}

?>
<?php
include_once 'paging-pegawai.php';
/*include_once 'paging_category.php';*/
?>



<!-- Script untuk delete product -->
<script>

$(document).on('click', '.delete-object', function(){

    var id = $(this).attr('delete-id');
    var q = confirm("Anda Yakin??");

    if (q == true){

        $.post('hapus-pegawai.php', {
            nipg: id
        }, function(data){
            location.reload();
        }).fail(function() {
            alert('Gagal Hapus.');
        });

    }

    return false;
});
</script>
<?
include_once "footer.php";
?>