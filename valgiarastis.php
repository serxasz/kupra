<?php 
include('config.php');
$where = "valgiarastis"; 
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
if (loggedIn($where)) {

	$username = $_SESSION['username'];

    echo'
    <ol class="breadcrumb">
      <li><span class="glyphicon glyphicon-home"></span><a href="/"> Pradinis</a></li>
      <li class="active">Valgiaraštis</li>
    </ol>';

	
	echo "<h2>Valgiaraštis</h2>";
	 	
			
			
		
		$menus = "SELECT * FROM menus WHERE username='$username' ";
	
		$menus_result = mysql_query($menus);
		
		

	$menuid = 0;
	while ($menu = mysql_fetch_row($menus_result)) {
	
		echo "<table class=\"table table-bordered table-striped\" style=\"width: 70%\">
			<tr>
			  	<th colspan=\"3\"><center>Valgiaraštis $menu[0] '$menu[1]'</center></th>
			   

	  	  	</tr>

		  	<tr>
			    <th style=\"width: 50%\">Recepto Pavadinimas</th>
				<th style=\"width: 30%\">Produktai</th>
				
				
				
			    

	  	  	</tr>";
	    echo 	'<tr>
	       			
					<td>
					';
						
						
					
	
					$recept_result = mysql_query("SELECT * FROM menus_recipes WHERE menuid='$menu[0]' ");
					echo "<table class=\"table table-bordered table-striped\" style=\"width: 20%\">";
					while ($rec = mysql_fetch_row($recept_result)) {
					
						$r_result =mysql_query('SELECT * FROM recipes WHERE id IN ('.$rec[0].')');
						while ($r = mysql_fetch_row($r_result)) {
							echo "<center>
								$r[2] <div>
								</center>";
						}
					}
					echo "</table>";
						
					if (isset($_POST['go'.$menuid])) {
							$pun = $_POST['taskOption'.$menuid];
							
							$sql = "INSERT INTO menus_recipes (recipeid, menuid) VALUES ('$pun', '$menu[0]')";
							if (mysql_query($sql)) {
								echo "<center>Receptas priskirtas</center>";
							}
						
					}
					
					echo'<form method="post" action="valgiarastis.php">
					<center>
					<select name= "taskOption'.$menuid.'" >';
					$recipes = "SELECT * FROM recipes  ";
	
					$recipe_result = mysql_query($recipes);
					echo "<option value=\"0\">- prideti - </option>";
						
					while ($recipe = mysql_fetch_row($recipe_result)) {
						echo '<option value='.$recipe[0].' >'.$recipe[2].'</option>';
					}
					
				
					echo '
						</select>
						<div><br>
						<input name="go' . $menuid . '" type="submit" value="patvirtinti" />
						</form>
					</center>
					<td></td>
					</td>
				
	       	
	       		  </tr>';
				  echo "</table>";
				  	$menuid = $menuid + 1;
   	}

	
		
}else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>