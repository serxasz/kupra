<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
$where=$phrase[81]; 
if (loggedIn($where)) {	
	$term = $_POST['term'];	
	$sql = mysql_query("select username, name from recipes where name like '%$term%' or username like '%$term%'");
	echo '<b>Rasti receptai:</b>';
	if (mysql_num_rows($sql) > 0){
	while ($row = mysql_fetch_assoc($sql)){
	//$sOutput .= "<a href='m.php?user=$row[username]'>$row[username]</a>";
		echo '<br>//////////////////////////////////////////////////////'; 
		echo '<br>Autorius: '.$row['username'];//.$sOutput;	
		echo '<br>Receptas: '.$row['name'];
		}		
	} else {
	echo '<br><font color="red">Ner tokio recepto kaip </font>'.$term;
	}
	echo '<br><br><a href="index.php"><font color="blue">Atgal i pagrindini</font></a>';
}else {
	echo '<font color="red">Reikia prisijungti!</font>';
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>