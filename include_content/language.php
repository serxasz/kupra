<?php
// Reikia perdaryti.
/*
if (empty($_SESSION['lang'])) { $_SESSION['lang'] = $default_language; }
$lang_array = (glob("locale/*.php"));
$lang_count = count($lang_array);
echo"<div class=\"container col-sm-1\"><form action='' method='get'><select name='lang' onchange='this.form.submit()'>";
echo"<option value=''>" . basename($_SESSION['lang'], '.php') . "</option>";
for ($i=0; $i<$lang_count; $i++) {
	if($_SESSION['lang'] <> $lang_array[$i]) { echo " <option value='$i'>" .basename($lang_array[$i], '.php') . "</option>"; }
}
echo"</select>";
if (!empty($_GET['action'])) { echo"<input type='hidden' name='action' value='" .$_GET['action']. "'>"; }
if (!empty($_GET['user'])) { echo"<input type='hidden' name='user' value='" .$_GET['user']. "'>"; }
if (!empty($_GET['page'])) { echo"<input type='hidden' name='page' value='" .$_GET['page']. "'>"; }
if (!empty($_GET['message'])) { echo"<input type='hidden' name='message' value='" .$_GET['message']. "'>"; }
echo "</form></div>";
*/
?>