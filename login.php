<?php 
include('config.php');
$sOutput="";
  
if (isset($_GET['action'])) { 
	switch (strtolower($_GET['action'])) {
		case 'logout': 
			if (loggedIn(0)) {
				logoutUser();
				echo"<script>top.location = 'index.php';</script>";
				exit;
			}else { 
				unset($_GET['action']); 
			} 
			break; 
		case 'login': 
			if (isset($_POST['username']) && isset($_POST['password'])) {  
				if (!validateUser($_POST['username'], sha1($_POST['password']), $_POST['set_cookie'])) {   
					unset($_GET['action']); 
				} 
			}else { 
				$_SESSION['error'] = $phrase[19]; 
				unset($_GET['action']); 
			}       
			break; 
	} 
}
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
 
$sOutput .= '<div id="index-body">'; 
if (loggedIn(0)) { 
echo"<script>top.location = 'index.php';</script>";
}elseif (empty($_GET['action'])) { 
	$sUsername = ""; 
	if (isset($_POST['username'])) { 
		$sUsername = $_POST['username']; 
	} 
	$sError = "";
$sOutput .= ' ' . $phrase[20] . '<br>';	
	if (!empty($_SESSION['error'])) { 
		$sError = '<span id="error">' . $_SESSION['error'] . '</span><br>';
		$sOutput .= '
		<table width="280"  border="0" align="center" cellpadding="3" cellspacing="5" bgcolor="#FFCCCC">
			<tr>
				<td><div align="center"><strong><font color="#FF0000">' . $sError . '</font></strong></div></td>
			</tr>
		</table>';
		unset($_SESSION['error']);
	} 
	$sOutput .= ' 
    <form name="login" method="post" action="login.php?action=login">
		<table width="280" border="1" align="center" cellpadding="5" cellspacing="0">
			<tr> 
				<td width="40%"><strong>' . $phrase[16] . '</strong></td>
				<td width="60%" align="center"><input type="text" name="username" value="' . $sUsername . '"></td>
			</tr>
			<tr> 
				<td><strong>' . $phrase[21] . '</strong></td>
				<td align="center"><input type="password" name="password" value=""></td>
			</tr>
			<tr>
				<td colspan="2" align="center">' . $phrase[22] . '
				<input type="checkbox" name="set_cookie" id="set_cookie" value="1"><br>
				<input type="submit" name="submit" value=" ' . $phrase[23] . ' "><br>
				<a href="recover.php">' . $phrase[24] . '</a></td>
			</tr>
		</table> 
    </form> 
    ' . $phrase[25] . ' '; 
} 
 
$sOutput .= '</div>'; 
  
echo $sOutput;
include('include_content/html_bottom.php'); 
?>