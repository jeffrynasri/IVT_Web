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
    include_once 'objects/barang_rusak.php';

    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare product object
    $barang_rusak = new Barang_Rusak($db);

    // set product id to be deleted
    $barang_rusak->id_barang_rusak = $_POST['id_barang_rusak'];

    // delete the product
    if($barang_rusak->delete()){
        echo "Barang Rusak Berhasil Dihapus.";
    }

    // if unable to delete the product
    else{
        echo "Barang Rusak Gagal Dihapus.";

    }
}
?>