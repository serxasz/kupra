<?php 
include('config.php');
$where = "naujas_valgiarastis"; 
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
if (loggedIn($where)) {

	$username = $_SESSION['username'];
    echo'
    <ol class="breadcrumb">
      <li><span class="glyphicon glyphicon-home"></span><a href="/"> Pradinis</a></li>
      <li class="active"><center>Sukurti Valgiarasti </center></li>
    </ol>
	
	  <table  style="background: rgba(245,245,245,0.7);width: 50%" class="table table-bordered" align="center" >
';

	

	echo' <form method="post" action="sukurti_valgiarasti.php">
		
		<div class="form-group">
		<tr> <td><center>
		 <label class="control-label" for="menuname">Pavadinimas</label>
		 </center> </td></tr>
		 <tr> <td>
		<center> <input class="form-control" placeholder="" type="text" name="menuname"></center>
		</div>
		 </td></tr>
		 <tr> <td>
		<center><input name="go" type="submit" value="Sukurti Valgiarasti" /></center>
		 </td></tr>
		
		</form></table>';;
		
	if (isset($_POST['go'])) {
		$menuname = $_POST['menuname'];
			$sql = "INSERT INTO menus (username, name) VALUES ('$username', '$menuname')";

		if (mysql_query($sql)) {
			echo "Naujas Valgiarastis Sukurtas.";
		}
	}
}else {

				
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>