<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$where=$phrase[81]; 
if (loggedIn($where)) {
	echo '<div class="container"';

	$sql = "SELECT COUNT(message) FROM messages WHERE deleted = '0' AND receiver = '".$_SESSION['username']."'";
	$rs_result = mysql_query($sql); 
	$row = mysql_fetch_row($rs_result);
	$sql = "SELECT COUNT(new) FROM messages WHERE deleted = '0' AND receiver = '".$_SESSION['username']."' AND new='1'";
	$rs_result = mysql_query($sql); 
	$row1 = mysql_fetch_row($rs_result);
	if ($row1[0] > 0) { $strong1 = "<b>"; $strong2 = "</b>"; }else { $strong1 = ""; $strong2 = ""; }
	echo" " . $phrase[44] . "
    " . $phrase[45] . "<br>
	" . $phrase[46] . "  <a href=\"users_online.php\">" . countOnlineUsers() . "</a><br>
	<a href=\"pm.php\">".$strong1."" . $phrase[89] . " [".$row[0]."/".$max_pm."]".$strong2."</a><br>
	<a href=\"m.php\">" . $phrase[47] . "</a><br>";
    
     $sql = "SELECT type FROM users where username='".$_SESSION['username']."' LIMIT 1";
                    $query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
                    $row = mysql_fetch_array($query);
	if ($row[type]=="Administratorius") { echo"<a href=\"admin.php\">" . $phrase[17] . "</a><br/>"; }
    
    echo $phrase[48]; 

    echo '</div>';
} else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>