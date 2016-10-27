<?php
/*
    include_once "cek_login.php";
    */
?>
<?php

// check if value was posted
if($_POST){

    // include database and object file
    include_once 'config/database.php';
    include_once 'objects/pembelianbarang.php';

    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare product object
    $pembelian_barang = new Barang($db);

    // set product id to be deleted
    $pembelian_barang->id_pembelian = $_POST['id_pembelian'];

    // delete the product
    if($pembelian_barang->delete()){
        echo "Pembelian Barang Berhasil Dihapus.";
    }

    // if unable to delete the product
    else{
        echo "Pembelian Barang Gagal Dihapus.";

    }
}
?>