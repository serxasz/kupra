<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
require_once('includes/recaptchalib.php');
$sOutput="";
$sOutput .= '<div id="register-body">';
?>
<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'white'
 };</script>
<?php
if (isset($_GET['action'])) { 
	if  (strtolower($_GET['action']) == 'register') {  
		if (!empty($_POST['username']) && !empty($_POST['password'])) {
			if ($_POST["recaptcha_response_field"]) { 
				$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

				if (!$resp->is_valid) {
					$_SESSION['error'] = $phrase[9]; 
					unset($_GET['action']);
				}else {
					if ($_POST['password'] == $_POST['password2']) {
                    
                        $target_dir = "uploads/";
                        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                        $uploadOk = 1;
                        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                        $file_full_path = $target_dir . $_POST['username'] . "." . $imageFileType; 
                        if(isset($_POST["fileToUpload"]) ) {
                            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                            if($check == false) {
                                $uploadOk = 0;
                                $_SESSION['error'] = "Pasirinktas failas nėra paveikslėlis"; 
                                unset($_GET['action']);
                            }
                        }
                        if (file_exists($target_file)) {
                            $uploadOk = 0;
                            $_SESSION['error'] = "Toks failas jau egzistuoja"; 
                            unset($_GET['action']);
                        }
                        if ($_FILES["fileToUpload"]["size"] > 500000) {
                            $uploadOk = 0;
                            $_SESSION['error'] = "Failas uzima per daug vietos"; 
                            unset($_GET['action']);
                        }
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                        && $imageFileType != "gif" ) {
                            $uploadOk = 0;
                            $_SESSION['error'] = "Leidziami tik jpg, png ir gif failai"; 
                            unset($_GET['action']);
                        }
                        if ($uploadOk == 1 or !isset($_POST["fileToUpload"])) {
                            $_GET['action'] = "register";
                            $_SESSION['error'] = ""; 
                            $sql = "SELECT username FROM users WHERE username = '" . $_POST['username'] . "' LIMIT 1";
                            $query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
                            if (mysql_num_rows($query) !== 1) {
                                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file_full_path);
                            }
                            if (createAccount($_POST['username'], $_POST['password'], $_POST['email'], $email_verification, $_POST['type'], $_POST['name'], $_POST['surname'], $_POST['description'], $_POST['private'])) {
                            
							if ($email_verification == 1) {
								$subject = $phrase[62];  
								$message = $phrase[63];                     
								$headers = $phrase[10];  
								mail($_POST['email'], $subject, $message, $headers);
							}
							$sOutput .= '<div class="statusmsg">' . $phrase[64] . '<br>'; 
							if ($email_verification == 1) { $sOutput .= $phrase[65]; }
							if ($email_verification == 0) { $sOutput .= $phrase[66];  }
								$sOutput .= '</div>';
						}else {  
							unset($_GET['action']); 
						} 
                            
                        } else {
                            unset($_GET['action']); 
                        }
					}else {
						$_SESSION['error'] = $phrase[30]; 
						unset($_GET['action']);
					}
				} 
			}else { 
				$_SESSION['error'] = $phrase[12]; 
				unset($_GET['action']); 
			}        
		}else { 
			$_SESSION['error'] = $phrase[67]; 
			unset($_GET['action']); 
		} 
	} 
} 
  
if (loggedIn(0)) { 
	echo"<script>top.location = 'index.php';</script>"; 
}elseif (empty($_GET['action'])) {  
	$sUsername = ""; 
	if (isset($_POST['username'])) { 
		$sUsername = $_POST['username']; 
	} 
	$sError = "";
	$sOutput .= $phrase[68];
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
	<form name="register" method="post" action="register.php?action=register" enctype="multipart/form-data">
		<table width="340" border="1" align="center" cellpadding="5" cellspacing="0">
			<tr> 
				<td width="40%"><strong>' . $phrase[16] . '</strong></td>
				<td width="60%" align="center"><input type="text" name="username" value="' . $sUsername . '"></td>
			</tr>
			<tr> 
				<td><strong>' . $phrase[21] . '</strong></td>
				<td align="center"><input type="password" name="password" value=""></td>
			</tr>
			<tr> 
				<td><strong>' . $phrase[69] . '</strong></td>
				<td align="center"><input type="password" name="password2" value=""></td>
			</tr>
            <tr> 
				<td><strong>' . $phrase[115] . '</strong></td>
				<td align="center">
                <select name="type">
                <option value="Paprastas" selected="selected">   Paprastas   </option>
                <option value="Kulinaras"> Kulinaras </option>
                </select>
                </td>
			</tr>
			<tr> 
				<td><strong>' . $phrase[52] . '</strong></td>
				<td align="center"><input type="text" name="email" value=""></td>
			</tr>
            <tr> 
				<td><strong>Vardas:</strong></td>
				<td align="center"><input type="text" name="name" value=""></td>
			</tr>
            <tr> 
				<td><strong>Pavarde:</strong></td>
				<td align="center"><input type="text" name="surname" value=""></td>
			</tr>
            <tr> 
				<td><strong>Aprašymas:</strong></td>
				<td align="center"><input type="text" name="description" value=""></td>
			</tr>
            <tr> 
				<td><strong>Avataras:</strong></td>
				<td align="center"><input type="file" name="fileToUpload" id="fileToUpload"></td>
			</tr>
            <tr> 
				<td colspan="2" align="center"><input type="checkbox" name="private" value="1"> Paskyra privati<br></td>
			</tr>
			<tr> 
				<td colspan="2" align="center">' . recaptcha_get_html($publickey) . '</td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="submit" value=" ' . $phrase[70] . ' "></td>
			</tr>
		</table>
    </form> 
    <br> 
    ' . $phrase[71] . ' '; 
} 
 
$sOutput .= '</div>'; 
  
echo $sOutput;
include('include_content/html_bottom.php'); 
?>
