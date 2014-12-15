<?php 
/* m.php is for viewing members profiles. */
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$where=$phrase[78]; 
if (loggedIn($where)) {
	if (isset($_GET["user"])) {
		if ((5<=strlen($_GET["user"])) && (strlen($_GET["user"])<=15)) {
			$user  = mysql_real_escape_string($_GET["user"]);
			$sql = "SELECT * FROM users where username='$user' LIMIT 1";  
			$query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
			if (mysql_num_rows($query) == 1) {
				$row = mysql_fetch_array($query);
				$sql1 = "SELECT uid FROM users_online where uid='".$row['id']."' LIMIT 1";  
				$query1 = mysql_query($sql1) or trigger_error("Query Failed: " . mysql_error());
				$sOutput = "<table width='340' border='1' align='center' cellpadding='5' cellspacing='0'>";
				if (mysql_num_rows($query1) == 1) {
				$sOutput .= "<tr><td colspan='2' align='center'>" . $phrase[49] . "</td></tr>";
				} else { $sOutput .= "<tr><td colspan='2' align='center'>" . $phrase[50] . "</td></tr>"; }
				if ($row['username'] == $_SESSION['username']) {
					$sOutput .= "<tr> 
									<td width='40%'><strong>" . $phrase[51] . "</strong></td>
									<td width='60%' align='center'>" . $row['id'] . "</td>
								</tr>
								<tr> 
									<td width='40%'><strong>" . $phrase[16] . "</strong></td>
									<td width='60%' align='center'>" . $row['username'] . "</td>
								</tr>
								<tr> 
									<td width='40%'><strong>" . $phrase[52] . "</strong></td>
									<td width='60%' align='center'>" . $row['email'] . "</td>
								</tr>
								<tr> 
									<td colspan='2' align='center'>
									<a href='change_pass.php?action=pass'>" . $phrase[53] . "</a><br>
									<a href='change_pass.php?action=email'>" . $phrase[54] . "</a><br>
									</td>
								</tr></table>";
				}else {
					$sOutput .= "<tr> 
									<td width='40%'><strong>" . $phrase[51] . "</strong></td>
									<td width='60%' align='center'>" . $row['id'] . "</td>
								</tr>
								<tr> 
									<td width='40%'><strong>" . $phrase[16] . "</strong></td>
									<td width='60%' align='center'>" . $row['username'] . "</td>
								</tr>
								<tr> 
									<td width='40%'><strong>" . $phrase[52] . "</strong></td>
									<td width='60%' align='center'>" . $row['email'] . "</td>
								</tr></table>";
				}				
			}else { $sOutput = $phrase[55]; }
		}else { $sOutput = $phrase[55]; }	
	}else { echo"<script>top.location = 'm.php?user=" . $_SESSION['username'] . "';</script>"; } 
	echo $sOutput;
	echo "<br><a href='index.php'>" . $phrase[56] . "</a>";
}else {
	include('include_content/not_registered.php');	
}
include('include_content/html_bottom.php'); 
?>