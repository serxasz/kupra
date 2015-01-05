<?php

/*******************/

$time = time();
$time_check = $time-600;
$sql="DELETE FROM users_online WHERE time<$time_check";
$result=mysql_query($sql);

/*******************/

$lang_array = (glob("locale/*.php"));
$lang_count = count($lang_array);
if (isset($_COOKIE['lang'])) {
	if ((0 <= $_COOKIE['lang']) && ($lang_count >= $_COOKIE['lang'])) {
		if (strlen($_COOKIE['lang']) < 2) {
			$_SESSION['lang'] = $lang_array[$_COOKIE['lang']];	
		}else { setcookie('lang', '', time()); }
	}else { setcookie('lang', '', time()); }
} else {
    setcookie('lang', 1, time() + (10 * 365 * 24 * 60 * 60));
}
if (isset($_GET['lang'])) {
	if ((0 <= $_GET['lang']) && ($lang_count >= $_GET['lang']) && (is_numeric($_GET['lang']))) {
		if (strlen($_GET['lang']) < 2) {
				setcookie('lang', $_GET['lang'], time() + (10 * 365 * 24 * 60 * 60));
				$_SESSION['lang'] = $lang_array[$_GET['lang']];
				unset($_GET['lang']);
		}else { unset($_GET['lang']);  }
	}else { unset($_GET['lang']);  }
}

/*******************/
?>