<?php
$page_title = "IVT";

include_once 'config/database.php';
include_once 'objects/barang_rusak.php';
include_once 'objects/barang.php';
include_once 'objects/pegawai.php';


include_once "header.php";

?>
<ul class="nav nav-tabs">
  <li ><a href="view-pembelianbarang.php">Pembelian Barang</a></li>
  <li class="active"><a href="view-barangrusakm.php">Barang Rusak</a></li>
  <li><a href="view-pegawai.php">Pegawai</a></li>
  <li ><a href="view-pemasok.php">Pemasok</a></li>
  <li><a href="view-transaksi.php">Laporan Keuangan</a></li>
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

$barang_rusak = new Barang_Rusak($db);
$barang = new Barang($db);
$pegawai = new Pegawai($db);

// Query product
$stmt = $barang_rusak->readAll($page, $from_record_num, $records_per_page);
$num = $stmt->rowCount();

if ($num >0)
{

    echo '<table class="table table-hover table-responsive table-bordered" id="c">';
    echo '  <tr>';
    echo '      <th>Kode Barang</th>';
    echo '      <th>Nama Barang</th>';
    echo '      <th>Jumlah (Kardus)</th>';
    echo '      <th>Keterangan</th>';
    echo '      <th>Pegawai</th>';
    echo '      <th>Actions</th>';
    echo '  </tr>';

     while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);
        $barang->nib = $nib;
        $barang->readOne();
        echo '<tr>';
        echo '  <td>';    
            echo $barang->nib;
        echo '</td>';
        echo '  <td>';
            echo $barang->nama;
        echo '</td>';
         echo '  <td>'.$jumlah.'</td>';
         echo '  <td>'.$keterangan.'</td>';
        echo '  <td>';
            $pegawai->nipg = $nipg;
            $pegawai->readOne();
            echo $pegawai->nama;
        echo '</td>';
        echo '  <td>';
            //<!--Ubah dan Hapus button-->
            echo '<a delete-id="'.$id_barang_rusak.'" class="btn btn-danger delete-object">Hapus</a>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</table>';

    // paging button will be here
}
else
{
    echo '<div>Barang Rusak Kosong.</div>';
}

?>
<?php
include_once 'paging-barangrusakm.php';
/*include_once 'paging_category.php';*/
?>



<!-- Script untuk delete product -->
<script>

$(document).on('click', '.delete-object', function(){

    var id = $(this).attr('delete-id');
    var q = confirm("Anda Yakin??");

    if (q == true){

        $.post('hapus-barangrusak.php', {
            id_barang_rusak: id
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