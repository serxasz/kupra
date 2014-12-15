<?php
/*******************/
function isAdministrator($username) {
    $sql = "SELECT type FROM users WHERE username = '$username'";
	$rs_result = mysql_query($sql); 
	$row = mysql_fetch_row($rs_result);

	if ($row[0] == 'Administratorius') {
		return true;
	} else {
		return false;
	}
}

function createAccount($pUsername, $pPassword, $email, $email_verification, $type, $name, $surname, $description, $private) { 
	include($_SESSION['lang']);
	if (!empty($pUsername) && !empty($pPassword)) { 
		$uLen = strlen($pUsername); 
		$pLen = strlen($pPassword);
		$eLen = strlen($email); 	
		$eUsername = mysql_real_escape_string($pUsername);
		$email = mysql_real_escape_string($email);
		$sql = "SELECT username FROM users WHERE username = '" . $eUsername . "' LIMIT 1";
		$sql1 = "SELECT email FROM users WHERE email = '" . $email . "' LIMIT 1";
		$query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error()); 
		$query1 = mysql_query($sql1) or trigger_error("Query Failed: " . mysql_error());
		if ($uLen <= 4 || $uLen > 15) { 
			$_SESSION['error'] = $phrase[7]; 
		}elseif ($pLen <= 6 || $pLen > 30) { 
			$_SESSION['error'] = $phrase[28]; 
		}elseif ($eLen <= 5 || $pLen > 60) { 
			$_SESSION['error'] = $phrase[36]; 
		}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
			$_SESSION['error'] = $phrase[37]; 
		}elseif (mysql_num_rows($query) == 1) { 
			$_SESSION['error'] = $phrase[85]; 
		}elseif (mysql_num_rows($query1) == 1) { 
			$_SESSION['error'] = $phrase[86]; 
		}else {
			if ($email_verification == 1) { $verification = 0; }
			elseif ($email_verification == 0) { $verification = 1; }
			$sql = "INSERT INTO users (`username`, `password`, `email`, `active`, `type`, `private`, `name`, `surname`, `description`) VALUES ('$eUsername', '". sha1($pPassword) . "', '$email', '$verification', '$type', '$private', '$name', '$surname', '$description');"; 
			$query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error()); 
			if ($query) { 
				return true;
			}   
		} 
	} 
   
	return false; 
}  

/*******************/

function loggedIn($place) {
	if ((isset($_COOKIE['username'], $_COOKIE['password'])) && (!isset($_SESSION['username']))) {
		if (validateUser($_COOKIE['username'], $_COOKIE['password'], 1)) {
		}
	}
	if (isset($_SESSION['loggedin']) && isset($_SESSION['username'])) {
		updateOnlineUsers($place);
		return true; 
	} 
   
	return false; 
} 

/*******************/

function logoutUser() {
	updateOnlineUsers("logout");
	unset($_SESSION['username']); 
	unset($_SESSION['loggedin']);
	
	if (isset($_COOKIE['username'], $_COOKIE['password'])) {
					setcookie('username', '', time());
					setcookie('password', '', time());
				}
   
	return true; 
} 

/*******************/

function validateUser($pUsername, $pPassword, $cookie) { 
	include($_SESSION['lang']);
	$sql = "SELECT username, password, active FROM users  
    WHERE username = '" . mysql_real_escape_string($pUsername) . "' AND password = '" . mysql_real_escape_string($pPassword) . "' LIMIT 1"; 
	$query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error()); 
	if (mysql_num_rows($query) == 1) {
		$row = mysql_fetch_assoc($query);
		If ($row['active'] == 1) {
			if ((isset($cookie)) && ($cookie == '1')) {
				setcookie('username', $row['username'], time() + 2419200);
				setcookie('password', $row['password'], time() + 2419200);
			}
			$_SESSION['username'] = $row['username']; 
			$_SESSION['loggedin'] = true; 
       
		return true;
		}else { $_SESSION['error'] = $phrase[87]; }
	}else { $_SESSION['error'] = $phrase[88]; } 
     
	return false; 
}

/*******************/

function updateOnlineUsers($place) {
	if ($place == "logout") { 
		$time = 0; 
	}else { 
		$time = time(); 
	}
	$sql0 = "SELECT id FROM users WHERE username='" . $_SESSION['username'] . "'";
	$result = mysql_query($sql0);
	$row = mysql_fetch_assoc($result);
	$uid = $row['id'];
	$sql = "SELECT uid FROM users_online WHERE uid='$uid'";
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);
	if($count == "0"){
		$sql1 = "INSERT INTO users_online(uid, time, place)VALUES('$uid', '$time', '$place')";
		$result1 = mysql_query($sql1);
	}else {
		$sql2="UPDATE users_online SET time='$time', place='$place' WHERE uid = '$uid'";
		$result2=mysql_query($sql2);
		}
   
	return true; 
} 

/*******************/

function countOnlineUsers() { 
	$sql = "SELECT * FROM users_online";
	$result = mysql_query($sql);
	$count_online_users = mysql_num_rows($result);
   
	return $count_online_users; 
} 

/*******************/

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); 
    $alphaLength = strlen($alphabet) - 1; 
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); 
}

/*******************/

?>