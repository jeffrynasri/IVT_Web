<?php
	session_start();
	session_unset($_SESSION['admin_username']);
	session_unset($_SESSION['admin_password']);
	session_unset($_SESSION['admin_manajer']);
	header ("location:index.php");

?>