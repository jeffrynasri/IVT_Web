<?php
$page_title = "IVT";

//include_once 'config/database.php';
//include_once 'objects/pegawai.php';

include_once "header.php";

?>
<center>
<h2>Admin Page</h1> 
</center>
<form role="form" method = "post">

  <div class="form-group">
    <label for="email">Username:</label>
    <input type="text" class="form-control" id="email" name="username">
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" id="pwd"  name="password">
  </div>
  <div>
  		<input type="radio" name="manajer"> Manajer<br>
  		<input type="radio" name="petugas"> Petugas Gudang<br>
  </div>
  <button type="submit" class="btn btn-default" name="login">Login</button>
</form>

 <?php
 	if(isset($_POST['login'])){
	 	include 'config/database.php';
	 	include_once 'objects/pegawai.php';
	 	include_once 'objects/manajer.php';

	 	$database = new Database();	
		$db = $database->getConnection();
	 	$user = $_POST['username'];
	 	$password = $_POST['password'];



	 	if(isset($_POST['manajer'])){
	 		$pemakai = new Manajer($db);
	 	}
	 	else if(isset($_POST['petugas'])){
	 		$pemakai = new Pegawai($db);
	 	}

	 	if($pemakai->login($user,$password)){
	 		if(!isset($_SESSION)) 
   			 { 
  			      session_start(); 
		    }
	 		$_SESSION['admin_username']=$user;
	 		$_SESSION['admin_password']=$password;
	 		/*session_start();
	 		$_SESSION['admin_username']=$user;
	 		$_SESSION['admin_password']=$password;*/
	 		if(isset($_POST['manajer'])){
	 			$_SESSION['admin_manajer']=1;
	 			header("location:view-pembelianbarang.php");
	 		}
	 		else if(isset($_POST['petugas'])){
	 			$_SESSION['admin_pegawai']=1;
	 			header("location:view-penjualanbarang.php");
	 		}
	 	}else{
	 		 echo '<div class="alert alert-danger alert-dismissable">';
          		echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
         		  echo 'Username Atau Password Salah.';
      		 echo '</div>';
	 	}
	 } 
	
 	?>
<?
include_once "footer.php";
?>