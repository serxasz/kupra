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
      <li class="active">Sukurti Valgiarasti</li>
    </ol>';
	

	echo'<form method="post" action="sukurti_valgiarasti.php">
		<div class="form-group">
		 <label class="control-label" for="menuname">Pavadinimas</label>
		 <input class="form-control" placeholder="" type="text" name="menuname">
		</div>
		<input name="go" type="submit" value="Sukurti Valgiarasti" />
		</form>';
		
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