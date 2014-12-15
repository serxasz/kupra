<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
	if (isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
		if ((strlen($_GET['email']) <= 50) && (strlen($_GET['hash']) <= 50)) {
			$email = mysql_escape_string($_GET['email']); 
			$hash = mysql_escape_string($_GET['hash']);
			$search = mysql_query("SELECT password FROM users WHERE email='".$email."' AND active='0'") or die(mysql_error());   
			$row = mysql_fetch_assoc($search); 
			if($hash == sha1($row['password'])){
				mysql_query("UPDATE users SET active='1' WHERE email='".$email."' AND active='0'") or die(mysql_error());  
				echo '<div class="statusmsg">' . $phrase[76] . '</div>';
			}else {
				echo"<script>top.location = 'index.php';</script>";
			}
		}else {  
			echo"<script>top.location = 'index.php';</script>"; 
		}	
	}else {  
		echo"<script>top.location = 'index.php';</script>"; 
	}  
include('include_content/html_bottom.php'); 
?>