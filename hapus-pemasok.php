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
    include_once 'objects/pemasok.php';

    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare product object
    $pemasok = new Pemasok($db);

    // set product id to be deleted
    $pemasok->nip = $_POST['nip'];

    // delete the product
    if($pemasok->delete()){
        echo "Pemasok Berhasil Dihapus.";
    }

    // if unable to delete the product
    else{
        echo "Pemasok Gagal Dihapus.";

    }
}
?>