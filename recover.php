<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
require_once('includes/recaptchalib.php');
$sOutput="";
?>
<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'white'
 };</script>
<?php
if (isset($_GET['action'])) { 
	if (strtolower($_GET['action']) == 'send') {
		if (!empty($_POST['email'])) {
			if ((strlen($_POST['email']) <= 60) && (strlen($_POST['email']) >= 6)) {
				if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
					if ($_POST["recaptcha_response_field"]) { 
						$resp = recaptcha_check_answer ($privatekey,
									$_SERVER["REMOTE_ADDR"],
									$_POST["recaptcha_challenge_field"],
									$_POST["recaptcha_response_field"]);

						if (!$resp->is_valid) {
							$_SESSION['error'] = $phrase[9]; 
							unset($_GET['action']);
						}else {
							$email = mysql_escape_string($_POST['email']);
							$query = mysql_query("SELECT username, password, email FROM users WHERE email='".$email."'") or die(mysql_error());
							if (mysql_num_rows($query) == 1) {
								$row = mysql_fetch_assoc($query);
								$subject = $phrase[57];  
								$message = $phrase[58];                       
								$headers = $phrase[10];  
								mail($_POST['email'], $subject, $message, $headers);
								$sOutput .= '<div class="statusmsg">' . $phrase[59] . ' '; 
							
								$sOutput .= '</div>';
							}else { 
								$_SESSION['error'] = $phrase[60]; 
								unset($_GET['action']); 
							} 
						}						
					}else { 
						$_SESSION['error'] = $phrase[12]; 
						unset($_GET['action']); 
					} 
				}else { 
					$_SESSION['error'] = $phrase[37]; 
					unset($_GET['action']); 
				}
			}else { 
				$_SESSION['error'] = $phrase[36]; 
				unset($_GET['action']); 
			} 
		}else { 
			$_SESSION['error'] = $phrase[38]; 
			unset($_GET['action']); 
		} 
	}
}
if (loggedIn(0)) { 
	echo"<script>top.location = 'index.php';</script>"; 
}elseif (empty($_GET['action'])) {  
	$sError = "";
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
	$sOutput .= '
	<form name="recover" method="post" action="recover.php?action=send">
		<table width="340" border="1" align="center" cellpadding="5" cellspacing="0">
			<tr> 
				<td><strong>' . $phrase[52] . '</strong></td>
				<td align="center"><input type="text" name="email" value=""></td>
			</tr>
			<tr> 
				<td colspan="2" align="center">' . recaptcha_get_html($publickey) . '</td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="submit" value=" ' . $phrase[61] . ' "></td>
			</tr>
		</table>
    </form> '; 
} 
 
$sOutput .= '</div>'; 
  
echo $sOutput;	 

include('include_content/html_bottom.php'); 
?>