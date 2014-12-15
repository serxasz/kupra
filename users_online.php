<?php 
include('config.php');
include('include_content/language.php');
include($_SESSION['lang']);
$where=$phrase[79]; 
if (loggedIn($where)) {
	include('include_content/html_top.php');
	if (isset($_GET["page"])) {
		if ((is_numeric($_GET["page"])) && (0<=$_GET["page"]) && ($_GET["page"]<=1000)) {
			$page  = $_GET["page"];
		}else { $page=1; }	
	}else { $page=1; }; 
	$start_from = ($page-1) * 20;
	$sql = "SELECT username,place FROM users_online,users WHERE users_online.uid = users.id ORDER BY username ASC LIMIT $start_from, 20"; 
	$query = mysql_query($sql) or die("Query Failed: " . mysql_error());
	$sOutput = '<table width="340" border="1" align="center" cellpadding="5" cellspacing="0">
					<tr> 
						<td colspan="2" align="center"> ' . $phrase[75] . ' </td>
					</tr>';
	while ($row = mysql_fetch_assoc($query)) {
		$sOutput .= "<tr><td width='40%' align='center'><a href='m.php?user=$row[username]'>$row[username]</a></td>
					 <td width='60%' align='center'>$row[place]</td></tr>";  
	}
	$sql = "SELECT COUNT(uid) FROM users_online"; 
	$rs_result = mysql_query($sql); 
	$row = mysql_fetch_row($rs_result); 
	$total_records = $row[0];
	$total_pages = ceil($total_records / 20);
	$sOutput .= '<tr><td colspan="2" align="center">';
	for ($i=1; $i<=$total_pages; $i++) { 
		$sOutput .="<a href='users_online.php?page=$i'>$i</a> "; 
	};
	$sOutput .="<br><a href='index.php'> " . $phrase[56] . " </a>";
	$sOutput .= '</td></tr>';
	$sOutput .= '</table>';
	echo $sOutput;
}else {
	include('include_content/html_top.php');
	include('include_content/not_registered.php');	
}
include('include_content/html_bottom.php'); 
?>