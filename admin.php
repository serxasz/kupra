<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$where=$phrase[80]; 
if (loggedIn($where)) {
	require_once('includes/recaptchalib.php');
	?>
	<script type="text/javascript">
	var RecaptchaOptions = {
    theme : 'white'
	};</script>
	<?php
    $sql = "SELECT type FROM users where username='".$_SESSION['username']."' LIMIT 1";
                    $query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
                    $row = mysql_fetch_array($query);
	if ($row[type]=="Administratorius") {
	$sOutput="";
		if (empty($_GET['action'])) {	
			$sOutput = "<h2>Admin panel</h2>
            <a href=\"admin.php?action=member_list\">Narių sąrašas</a><br>
			<a href=\"admin.php?action=delete_user\">" . $phrase[1] . "</a><br>
			<a href=\"admin.php?action=group_email\">" .$phrase[2]. "</a><br>
			<a href=\"admin.php?action=earnings\">" .$phrase[3]. "</a><br>
			<a href=\"edit_clasificator.php\">Matavimo vienetai</a><br><br>
			<a href=\"../index.php\">" .$phrase[4]. "</a>";
		}
		if (strtolower($_GET['action']) == 'delete_user1') {
			if (!empty($_POST['user'])) {
				if ((strlen($_POST['user']) > 4) && (strlen($_POST['user']) <= 15)) {
					$sql = "SELECT username FROM users WHERE username = '" . mysql_real_escape_string($_POST['user']) . "' LIMIT 1";
					$query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
					if ((mysql_num_rows($query) == 1) && (strtolower($_POST['user']) <> strtolower($admin))) { 
						$result = mysql_query("DELETE FROM users WHERE username='" . mysql_real_escape_string($_POST['user']) . "'") or die(mysql_error());
						$sOutput = '
											<table width="340" border="1" align="center" cellpadding="5" cellspacing="0">
												<tr>
													<td><div align="center">' . $phrase[5] . '</div></td>
												</tr>
											</table>';
					}else { $_SESSION['error'] = $phrase[6]; $_GET['action'] = 'delete_user'; }
				}else { $_SESSION['error'] = $phrase[7]; $_GET['action'] = 'delete_user'; }
			}else { $_SESSION['error'] = $phrase[8]; $_GET['action'] = 'delete_user'; }
		}
		if (strtolower($_GET['action']) == 'group_email1') {
			if (!empty($_POST['letter'])) {
				if ((strlen($_POST['letter']) > 50)) {
					if ((strlen($_POST['subject']) > 15)) {
						if ($_POST["recaptcha_response_field"]) { 
								$resp = recaptcha_check_answer ($privatekey,
									$_SERVER["REMOTE_ADDR"],
									$_POST["recaptcha_challenge_field"],
									$_POST["recaptcha_response_field"]);
								if (!$resp->is_valid) {
									$_SESSION['error'] = $phrase[9]; $_GET['action'] = 'group_email';
							}else {
								$headers = $phrase[10];
								$sql = "SELECT email FROM users"; 
								$query = mysql_query($sql) or die("Query Failed: " . mysql_error());
								while ($row = mysql_fetch_assoc($query)) {
									mail($row[email], $_POST['subject'], $_POST['letter'], $headers);
								}
								$sql = "SELECT COUNT(email) FROM users";
								$rs_result = mysql_query($sql); 
								$row = mysql_fetch_row($rs_result); 
								$total_records = $row[0];
								$sOutput = '
											<table width="340" border="1" align="center" cellpadding="5" cellspacing="0">
												<tr>
													<td><div align="center">' . $phrase[11] . '</div></td>
												</tr>
											</table>';
							}						
						}else { $_SESSION['error'] = $phrase[12]; $_GET['action'] = 'group_email'; }
					}else { $_SESSION['error'] = $phrase[13]; $_GET['action'] = 'group_email'; }
				}else { $_SESSION['error'] = $phrase[14]; $_GET['action'] = 'group_email'; }
			}else { $_SESSION['error'] = $phrase[15]; $_GET['action'] = 'group_email'; }
		}
		if (!empty($_SESSION['error'])) { 
			$sError = '<span id="error">' . $_SESSION['error'] . '</span><br>';
			$sOutput .= '
			<table width="340"  border="0" align="center" cellpadding="3" cellspacing="5" bgcolor="#FFCCCC">
				<tr>
					<td><div align="center"><strong><font color="#FF0000">' . $sError . '</font></strong></div></td>
				</tr>
			</table>';
			unset($_SESSION['error']);
		}
		if (strtolower($_GET['action']) == 'delete_user') {
			$sOutput .= '<form name="delete" method="post" action="admin.php?action=delete_user1">
			<table width="340" border="1" align="center" cellpadding="5" cellspacing="0">
			<tr> 
				<td><strong>' . $phrase[16] . '</strong></td>
				<td align="center"><input type="text" name="user" value=""></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="submit" value="' . $phrase[1] . '"><br><a href="admin.php">' . $phrase[17] . '</a></td>
			</tr></table></form>';
		}
		if (strtolower($_GET['action']) == 'group_email') {
			$sOutput .= '<form name="send" method="post" action="admin.php?action=group_email1">
			<table width="450" border="1" align="center" cellpadding="5" cellspacing="0">
			<tr> 
				<td align="center"><strong>' . $phrase[18] . '</strong></td>
			</tr>
			<tr> 
				<td align="center"><strong>' . $phrase[113] . '</strong> <input width="100%" type="text" name="subject" value=""></td>
			</tr>
			<tr> 
				<td><textarea name="letter" style="width: 100%; height: 100%; border: none" id="letter"></textarea></td>
			</tr>
			<tr> 
				<td colspan="2" align="center">' . recaptcha_get_html($publickey) . '</td>
			</tr>
			<tr>
				<td align="center"><input type="submit" name="submit" value="' . $phrase[2] . '"><br><a href="admin.php">' . $phrase[17] . '</a></td>
			</tr></table></form>';
		}
        if (strtolower($_GET['action']) == 'member_list') {
			if (isset($_GET["page"])) {
                if ((is_numeric($_GET["page"])) && (0<=$_GET["page"]) && ($_GET["page"]<=1000)) {
                    $page  = $_GET["page"];
                }else { $page=1; }	
            }else { $page=1; }; 
            $start_from = ($page-1) * 20;
            $sql = "SELECT username, type, confirmed FROM users ORDER BY username ASC LIMIT $start_from, 20"; 
            $query = mysql_query($sql) or die("Query Failed: " . mysql_error());
            $sOutput = '<table width="340" border="1" align="center" cellpadding="5" cellspacing="0">
					<tr> 
						<td colspan="2" align="center">Narių sąrašas</td>
					</tr>';
            while ($row = mysql_fetch_assoc($query)) {
                $sOutput .= "<tr><td align='center' width='200'><a href='m.php?user=$row[username]'>$row[username]</a></td><td border= '0' align='center'>";
                if ($row[type] == "Kulinaras" and $row[confirmed] == 0) {
                    $sOutput .= " <font size='2'>Laukia patvirtinimo</font>";
                } else { $sOutput .= "</td></tr>"; }
            }
	$sql = "SELECT COUNT(id) FROM users"; 
	$rs_result = mysql_query($sql); 
	$row = mysql_fetch_row($rs_result); 
	$total_records = $row[0];
	$total_pages = ceil($total_records / 20);
	$sOutput .= '<tr><td colspan="2" align="center">';
	for ($i=1; $i<=$total_pages; $i++) { 
		$sOutput .="<a href='admin.php?action=member_list&page=$i'>$i</a> "; 
	};
	$sOutput .="<br><a href='index.php'> " . $phrase[56] . " </a>";
	$sOutput .= '</td></tr>';
	$sOutput .= '</table>';
		}
        if  (strtolower($_GET['action']) == 'change_type2') {
					$result = mysql_query("UPDATE users SET type='" .mysql_real_escape_string($_POST['type']) . "'
					WHERE username='" . $_POST['target'] . "'") or die(mysql_error());
										$sOutput = '
										<table width="340" border="1" align="center" cellpadding="5" cellspacing="0">
											<tr>
												<td><div align="center">Pakeista sėkmingai! <br/> <a href="index.php">Titulinis</a></div></td>
											</tr>
										</table>';				
		}
        if  (strtolower($_GET['action']) == 'change_type') {
			$sOutput .= '<form name="change" method="post" action="admin.php?action=change_type2">
			<table width="340" border="1" align="center" cellpadding="5" cellspacing="0">
			<tr> 
				<td align="center">
                <select name="type">
                <option value="Paprastas" selected="selected">   Paprastas   </option>
                <option value="Kulinaras"> Kulinaras </option>
                <option value="Administratorius"> Administratorius </option>
                </select>
                <input type="hidden" name="target" value="'.$_GET['target'].'">
                </td>
			</tr>
				<td align="center"><input type="submit" name="submit" value=" ' . $phrase[42] . ' "></td>
			</tr></table></form>';
		}
         if  (strtolower($_GET['action']) == 'change_confirmed') {
					$result = mysql_query("UPDATE users SET confirmed='1'
					WHERE username='" . $_GET['target'] . "'") or die(mysql_error());
										$sOutput = '
										<table width="340" border="1" align="center" cellpadding="5" cellspacing="0">
											<tr>
												<td><div align="center">Patvirtinta sėkmingai! <br/> <a href="index.php">Titulinis</a></div></td>
											</tr>
										</table>';				
		}
	echo $sOutput;
	}else { echo"<script>top.location = '../index.php';</script>"; }
}else {
	include('include_content/not_registered.php');	
}
include('include_content/html_bottom.php'); 
?>