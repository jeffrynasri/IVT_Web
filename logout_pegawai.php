<?php
	session_start();
	session_unset($_SESSION['admin_username']);
	session_unset($_SESSION['admin_password']);
	session_unset($_SESSION['admin_pegawai']);
	header ("location:index.php");

?>