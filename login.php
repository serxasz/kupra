<?php 
include('config.php');
$sOutput="";
$where="login";
  
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
	$sOutput .= '<div class="container" align="center">
    <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
    <form name="login" method="post" action="login.php?action=login">
    <table  style="background: rgba(255,255,255,0.7);" class="table table-bordered" align="center">';
    if (!empty($_SESSION['error'])) { 
		$sOutput .= '<tr><td colspan="2"><div class="alert alert-danger" role="alert" align="center">'.$_SESSION['error'].'</div></td></tr>';
		unset($_SESSION['error']);
	} 
			$sOutput .= '<tr> 
				<td width="40%"><strong>' . $phrase[16] . '</strong></td>
				<td width="60%" align="center"><input type="text" class="form-control" placeholder="Enter username" name="username" value="' . $sUsername . '"></td>
			</tr>
			<tr> 
				<td><strong>' . $phrase[21] . '</strong></td>
				<td align="center"><input type="password" class="form-control" placeholder="Enter password" name="password" value=""></td>
			</tr>
			<tr>
				<td colspan="2" align="center">' . $phrase[22] . '
				<input type="checkbox" name="set_cookie" id="set_cookie" value="1"><br>
                <button type="submit" class="btn btn-default">' . $phrase[23] . '</button>
                </td>
			</tr>
		</table> 
    </form>
    </div>
    <div class="col-md-4"></div>
    </div>
    </div>
    <div class="container" align="center">
    <br><a class="btn btn-default" href="recover.php" role="button">' . $phrase[24] . '</a>
    <a class="btn btn-default" href="register.php" role="button">Dar neužsiregistravęs?</a>
    </div>'; 
} 
 
$sOutput .= '</div>'; 
  
echo $sOutput;
include('include_content/html_bottom.php'); 
?>