<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$where=$phrase[77]; 
if (loggedIn($where)) {
$sOutput="";
require_once('includes/recaptchalib.php');
?>
<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'white'
 };</script>
<?php
	if (isset($_GET['action'])) { 
		if  (strtolower($_GET['action']) == 'change_pass') {
			if (!empty($_POST['password1']) && !empty($_POST['password2']) && !empty($_POST['password3'])) {
				if ($_POST['password2'] == $_POST['password3']) {
					if ($_POST['password1'] <> $_POST['password2']) {
						if ((strlen($_POST['password2']) > 6) && (strlen($_POST['password2']) <= 30)) {
							if ($_POST["recaptcha_response_field"]) { 
								$resp = recaptcha_check_answer ($privatekey,
									$_SERVER["REMOTE_ADDR"],
									$_POST["recaptcha_challenge_field"],
									$_POST["recaptcha_response_field"]);
								if (!$resp->is_valid) {
									$_SESSION['error'] = $phrase[9]; $_GET['action'] = 'pass';
								}else {
									$sql = "SELECT password FROM users WHERE username = '" . $_SESSION['username'] . "' AND
									password = '" . sha1(mysql_real_escape_string($_POST['password1'])) . "' LIMIT 1";
									$query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
									if (mysql_num_rows($query) == 1) { 
										$result = mysql_query("UPDATE users SET password='" . sha1(mysql_real_escape_string($_POST['password2'])) . "' 
										WHERE username='" . $_SESSION['username'] . "'") or die(mysql_error());
										$sOutput = '
										<table width="340" border="1" align="center" cellpadding="5" cellspacing="0">
											<tr>
												<td><div align="center">' . $phrase[26] . '</div></td>
											</tr>
										</table>';
									}else { $_SESSION['error'] = $phrase[27]; $_GET['action'] = 'pass'; }
								}						
							}else { 
								$_SESSION['error'] = $phrase[12]; $_GET['action'] = 'pass'; }
						}else { $_SESSION['error'] = $phrase[28]; $_GET['action'] = 'pass'; }
					}else { $_SESSION['error'] = $phrase[29]; $_GET['action'] = 'pass'; }
				}else { $_SESSION['error'] = $phrase[30]; $_GET['action'] = 'pass'; }
			}else { $_SESSION['error'] = $phrase[31]; $_GET['action'] = 'pass'; }
		}
		if (strtolower($_GET['action']) == 'change_email') {
			if (!empty($_POST['email'])) {
				if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { 
					if ((strlen($_POST['email']) > 5) && (strlen($_POST['password2']) <= 60)) {
						$sql = "SELECT email FROM users WHERE username = '" . $_SESSION['username'] . "' LIMIT 1";
						$query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
						if (mysql_num_rows($query) == 1) {
							$row = mysql_fetch_assoc($query);
							if ($row['email'] <> $_POST['email']) {
								$sql1 = "SELECT email FROM users WHERE email = '" . mysql_real_escape_string($_POST['email']) . "' LIMIT 1";
								$query1 = mysql_query($sql1) or trigger_error("Query Failed: " . mysql_error());
								if (mysql_num_rows($query1) == 0) {
									if ($_POST["recaptcha_response_field"]) { 
										$resp = recaptcha_check_answer ($privatekey,
												$_SERVER["REMOTE_ADDR"],
												$_POST["recaptcha_challenge_field"],
												$_POST["recaptcha_response_field"]);
										if (!$resp->is_valid) {
											$_SESSION['error'] = $phrase[9]; $_GET['action'] = 'email';
										}else {
											$result = mysql_query("UPDATE users SET email='" . mysql_real_escape_string($_POST['email']) . "' 
											WHERE username='" . $_SESSION['username'] . "'") or die(mysql_error());
											$sOutput = '
											<table width="340" border="1" align="center" cellpadding="5" cellspacing="0">
												<tr>
													<td><div align="center">' . $phrase[32] . '</div></td>
												</tr>
											</table>';
										}						
									}else { 
										$_SESSION['error'] = $phrase[12]; $_GET['action'] = 'email'; }
								}else { $_SESSION['error'] = $phrase[33]; $_GET['action'] = 'email'; }
							}else { $_SESSION['error'] = $phrase[34]; $_GET['action'] = 'email'; }
						}else { $_SESSION['error'] = $phrase[35]; $_GET['action'] = 'email'; } 
					}else { $_SESSION['error'] = $phrase[36]; $_GET['action'] = 'email'; }
				}else { $_SESSION['error'] = $phrase[37]; $_GET['action'] = 'email'; }
			}else { $_SESSION['error'] = "email was not supplied."; $_GET['action'] = 'email'; }
		}
        if  (strtolower($_GET['action']) == 'change_other') {
			if ($_POST["recaptcha_response_field"]) { 
				$resp = recaptcha_check_answer ($privatekey,
							$_SERVER["REMOTE_ADDR"],
							$_POST["recaptcha_challenge_field"],
							$_POST["recaptcha_response_field"]);
				if (!$resp->is_valid) {
					$_SESSION['error'] = $phrase[9]; $_GET['action'] = 'other';
				}else {
					$result = mysql_query("UPDATE users SET name='" .mysql_real_escape_string($_POST['name']) . "',
                                                            surname='" . mysql_real_escape_string($_POST['surname']) . "',
                                                            description='" . mysql_real_escape_string($_POST['description']) . "',
                                                            private='" . mysql_real_escape_string($_POST['private']) . "'
					WHERE username='" . $_SESSION['username'] . "'") or die(mysql_error());
										$sOutput = '
										<table width="340" border="1" align="center" cellpadding="5" cellspacing="0">
											<tr>
												<td><div align="center">Pakeista sėkmingai! <br/> <a href="index.php">Titulinis</a></div></td>
											</tr>
										</table>';
                              }						
							}else { 
								$_SESSION['error'] = $phrase[12]; $_GET['action'] = 'other'; }
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
		if  (strtolower($_GET['action']) == 'pass') {
			$sOutput .= '<form name="change" method="post" action="change_pass.php?action=change_pass">
			<table width="340" border="1" align="center" cellpadding="5" cellspacing="0">
			<tr> 
				<td><strong>' . $phrase[39] . '</strong></td>
				<td align="center"><input type="password" name="password1" value=""></td>
			</tr>
			<tr> 
				<td><strong>' . $phrase[40] . '</strong></td>
				<td align="center"><input type="password" name="password2" value=""></td>
			</tr>
			<tr> 
				<td><strong>' . $phrase[41] . '</strong></td>
				<td align="center"><input type="password" name="password3" value=""></td>
			</tr>
			<tr> 
				<td colspan="2" align="center">' . recaptcha_get_html($publickey) . '</td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="submit" value=" ' . $phrase[42] . ' "></td>
			</tr></table></form>';
		}
		if  (strtolower($_GET['action']) == 'email') {
			$sOutput .= '<form name="change" method="post" action="change_pass.php?action=change_email">
			<table width="340" border="1" align="center" cellpadding="5" cellspacing="0">
			<tr> 
				<td><strong>' . $phrase[43] . '</strong></td>
				<td align="center"><input type="text" name="email" value=""></td>
			</tr>
			<tr> 
				<td colspan="2" align="center">' . recaptcha_get_html($publickey) . '</td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="submit" value=" ' . $phrase[42] . ' "></td>
			</tr></table></form>';
		}
        if  (strtolower($_GET['action']) == 'other') {
			$sOutput .= '<form name="change" method="post" action="change_pass.php?action=change_other">
			<table width="340" border="1" align="center" cellpadding="5" cellspacing="0">
			<tr> 
				<td><strong>Vardas:</strong></td>
				<td align="center"><input type="text" name="name" value=""></td>
			</tr>
			<tr> 
				<td><strong>Pavarde:</strong></td>
				<td align="center"><input type="text" name="surname" value=""></td>
			</tr>
			<tr> 
				<td><strong>Apibūdinimas:</strong></td>
				<td align="center"><input type="text" name="description" value=""></td>
			</tr>
            <tr> 
				<td colspan="2" align="center"><input type="checkbox" name="private" value="1"> Paskyra privati<br></td>
			</tr>
			<tr> 
				<td colspan="2" align="center">' . recaptcha_get_html($publickey) . '</td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="submit" value=" ' . $phrase[42] . ' "></td>
			</tr></table></form>';
		}
	}else { echo"<script>top.location = 'm.php';</script>"; }
	echo $sOutput;
}else {
	include('include_content/not_registered.php');	
}
include('include_content/html_bottom.php'); 
?>