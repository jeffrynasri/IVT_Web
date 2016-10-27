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
    include_once 'objects/pegawai.php';

    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // prepare product object
    $pegawai = new Pegawai($db);

    // set product id to be deleted
    $pegawai->nipg = $_POST['nipg'];

    // delete the product
    if($pegawai->delete()){
        echo "Pegawai Berhasil Dihapus.";
    }

    // if unable to delete the product
    else{
        echo "Pegawai Gagal Dihapus.";

    }
}
?>