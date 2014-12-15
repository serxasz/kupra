<?php 
include('config.php');
include('include_content/html_top.php');
include('include_content/language.php');
include($_SESSION['lang']);
$where=$phrase[89];
if (loggedIn($where)) {
	if (isset($_GET["page"])) {
		if ((is_numeric($_GET["page"])) && (0<=$_GET["page"]) && ($_GET["page"]<=1000)) {
			$page  = $_GET["page"];
		}else { $page=1; }	
	}else { $page=1; }; 
	$start_from = ($page-1) * 20;
	if (empty($_GET['action'])) { 
		$sOutput .="<a href='pm.php?action=write'>" . $phrase[90] . "</a><br>
        <a href='pm.php?action=inbox'>" . $phrase[91] . "</a><br>
        <a href='pm.php?action=sent'>" . $phrase[92] . "</a><br>";
	}
	$sql = "SELECT mid FROM messages WHERE deleted = '1' AND sender = '". mysql_real_escape_string($_SESSION['username']) . "' ORDER BY time DESC LIMIT ".$max_pm.", 18446744073709551615";
	$result = mysql_query($sql);
	while($row = mysql_fetch_assoc($result)){
		$sql = "DELETE from messages WHERE mid = '".$row['mid']."'";
		$res = mysql_query($sql);
	}
	if (isset($_GET['action'])) { 
		if  (strtolower($_GET['action']) == 'write2') {
			if (!empty($_POST['message']) && !empty($_POST['username']) ) {
				if ((strlen($_POST['message']) <= 2000)) {
					if ((strlen($_POST['username']) <= 20)) {
						if (strtolower($_POST['username']) <> strtolower($_SESSION['username'])) {
							$sql = "SELECT username FROM users WHERE username = '". mysql_real_escape_string($_POST['username']) . "'";
							$query = mysql_query($sql);
							if (mysql_num_rows($query) == 1) {
								$sql = "SELECT action FROM users WHERE username = '". $_SESSION['username'] . "'";
								$query = mysql_query($sql);
								$row = mysql_fetch_assoc($query);
								$time_left = $row['action']-time();
								if ($row['action'] < time()) {
									$sql = "SELECT COUNT(message) FROM messages WHERE deleted = '0' AND receiver = '". mysql_real_escape_string($_POST['username']) . "'";
									$rs_result = mysql_query($sql); 
									$row = mysql_fetch_row($rs_result); 
									if ($row[0] < $max_pm) {
										$sql = "INSERT INTO messages (`sender`, `receiver`, `time`, `message`) VALUES ('".$_SESSION['username']."',
										'". mysql_real_escape_string($_POST['username']) . "',
										now(),
										'". mysql_real_escape_string($_POST['message']) . "');"; 
										$query = mysql_query($sql) or die("Query Failed: " . mysql_error());
										$time = time() + $spam_time;
										$sql = "UPDATE users SET action='".$time."' WHERE username ='".$_SESSION['username']."'";
										$query = mysql_query($sql);
										$sOutput = '
											<table width="340" border="1" align="center" cellpadding="5" cellspacing="0">
												<tr>
													<td><div align="center">' . $phrase[95] . '</div></td>
												</tr>
											</table>';
									}else { $_SESSION['error'] = " ".$_POST['username']."".$phrase[105]." "; $_GET['action'] = 'write'; }
								}else { $_SESSION['error'] = " ".$phrase[96]." <b>".$time_left."</b> ".$phrase[97]." "; $_GET['action'] = 'write'; } 
							}else { $_SESSION['error'] = $phrase[55]; $_GET['action'] = 'write'; }
						}else { $_SESSION['error'] = $phrase[104]; $_GET['action'] = 'write'; }
					}else { $_SESSION['error'] = $phrase[55]; $_GET['action'] = 'write'; }
				}else { $_SESSION['error'] = $phrase[98]; $_GET['action'] = 'write'; }
			}else { $_SESSION['error'] = $phrase[99]; $_GET['action'] = 'write'; }
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
		if  (strtolower($_GET['action']) == 'write') {
			$sOutput .='<form name="write" method="post" action="pm.php?action=write2">
			<table width="500" border="1" align="center" cellpadding="5" cellspacing="0">
			<tr>';
			if ((!empty($_GET['message'])) && (strlen($_GET['message'])<=20)) { 
				$sOutput .='<td width="84%" align="center"><strong>' . $phrase[16] . '</strong> <input type="text" name="username" value="'.$_GET['message'].'"></td>';
			}else { $sOutput .='<td width="84%"  align="center"><strong>' . $phrase[16] . '</strong> <input type="text" name="username" value=""></td>'; }
			$sOutput .='
			</tr>
			<tr> 
				<td><textarea name="message" style="width: 100%; height: 100%; border: none" id="subject"></textarea></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="submit" value=" ' . $phrase[94] . ' "></td>
			</tr></table></form>';
		}
		if  (strtolower($_GET['action']) == 'read') {
			$message = $_GET['message'];
			$message = mysql_real_escape_string($message);
			if (!empty($message)) {
				if (is_numeric($message)) {
					$sql = "SELECT message,receiver,sender,new FROM messages WHERE mid = '".$message."'"; 
					$query = mysql_query($sql) or die("Query Failed: " . mysql_error());
					$row = mysql_fetch_assoc($query);
					if ((strtolower($row[receiver]) == strtolower($_SESSION['username']))  && ($row[deleted] == 0)) {
						if ($row['new'] == 1) {
							$sql = "UPDATE messages SET new = '0' WHERE mid= '".$message."'"; 
							$query = mysql_query($sql) or die("Query Failed: " . mysql_error());
						}
						$sOutput .='
						<table width="500" border="1" align="center" cellpadding="5" cellspacing="0">
						<tr> 
							<td align="center">' . $phrase[100] . ' <strong>' .$row[sender]. '</strong></td>
						</tr>
						<tr> 
							<td align="left"><div class="lauzyti"> ' . $row[message] . '</div></td>
						</tr>
						<tr> 
							<td align="center"><a href="pm.php?action=write&amp;message='.$row[sender].'">' . $phrase[106] . '</a></td>
						</tr></table>';
					}else { echo"<script>top.location = 'pm.php?action=inbox';</script>"; } 
				}else { echo"<script>top.location = 'pm.php?action=inbox';</script>"; } 
			}else { echo"<script>top.location = 'pm.php?action=inbox';</script>"; } 
		}
		if  (strtolower($_GET['action']) == 'sread') {
			$message = $_GET['message'];
			$message = mysql_real_escape_string($message);
			if (!empty($message)) {
				if (is_numeric($message)) {
					$sql = "SELECT message,receiver,sender,new,deleted FROM messages WHERE mid = '".$message."'"; 
					$query = mysql_query($sql) or die("Query Failed: " . mysql_error());
					$row = mysql_fetch_assoc($query);
					if (strtolower($row[sender]) == strtolower($_SESSION['username'])) {
						$sOutput .='
						<table width="500" border="1" align="center" cellpadding="5" cellspacing="0">
						<tr> 
							<td align="center">' . $phrase[107] . ' <strong>' .$row[receiver]. '</strong></td>
						</tr>
						<tr> 
							<td align="left"><div class="lauzyti"> ' . $row[message] . '</div></td>
						</tr></table>';
					}else { echo"<script>top.location = 'pm.php?action=sent';</script>"; } 
				}else { echo"<script>top.location = 'pm.php?action=sent';</script>"; } 
			}else { echo"<script>top.location = 'pm.php?action=sent';</script>"; } 
		}
		if  (strtolower($_GET['action']) == 'delete') {
			$message = $_GET['message'];
			$message = mysql_real_escape_string($message);
			if (!empty($message)) {
				if (is_numeric($message)) {
					$sql = "SELECT message,receiver,sender,new FROM messages WHERE mid = '".$message."'"; 
					$query = mysql_query($sql) or die("Query Failed: " . mysql_error());
					$row = mysql_fetch_assoc($query);
					if (strtolower($row[receiver]) == strtolower($_SESSION['username'])) {
						$sOutput .='<div class="statusmsg">'.$phrase[110].'<br>
						<a href="pm.php?action=del&amp;message='.$message.'">'.$phrase[111].'</a>&nbsp;&nbsp;
						<a href="pm.php?action=inbox">'.$phrase[112].'</a></div>';
					}else { echo"<script>top.location = 'pm.php?action=inbox';</script>"; } 
				}else { echo"<script>top.location = 'pm.php?action=inbox';</script>"; } 
			}else { echo"<script>top.location = 'pm.php?action=inbox';</script>"; } 
		}
		if  (strtolower($_GET['action']) == 'del') {
			$message = $_GET['message'];
			$message = mysql_real_escape_string($message);
			if (!empty($message)) {
				if (is_numeric($message)) {
					$sql = "SELECT message,receiver,sender,new FROM messages WHERE mid = '".$message."'"; 
					$query = mysql_query($sql) or die("Query Failed: " . mysql_error());
					$row = mysql_fetch_assoc($query);
					if (strtolower($row[receiver]) == strtolower($_SESSION['username'])) {
						$sql = "UPDATE messages SET deleted='1' WHERE mid='".$message."'"; 
						$query = mysql_query($sql) or die("Query Failed: " . mysql_error());
						echo"<script>top.location = 'pm.php?action=inbox';</script>";
					}else { echo"<script>top.location = 'pm.php?action=inbox';</script>"; } 
				}else { echo"<script>top.location = 'pm.php?action=inbox';</script>"; } 
			}else { echo"<script>top.location = 'pm.php?action=inbox';</script>"; } 
		}
		if  (strtolower($_GET['action']) == 'inbox') {
			$sql = "SELECT mid,message,time,sender,deleted,new,receiver FROM messages WHERE receiver = '".$_SESSION['username']."' AND deleted = '0' ORDER BY time DESC LIMIT $start_from, 20"; 
			$query = mysql_query($sql) or die("Query Failed: " . mysql_error());
			$sOutput = '<table width="720" border="1" align="center" cellpadding="5" cellspacing="0">
					<tr> 
						<td width="6%" align="center"> ' . $phrase[102] . ' </td>
						<td width="21%" align="center"> ' . $phrase[103] . ' </td>
						<td width="20%" align="center"> ' . $phrase[100] . ' </td>
						<td width="47%" align="center"> ' . $phrase[101] . ' </td>
						<td width="6%" align="center"></td>
					</tr>';
					$i=0;
			while ($row = mysql_fetch_assoc($query)) {
				$i++;
				$number = $i+($page-1)*20;
				$message = strip_tags($row[message]);
				if ($row['new'] == 1) { $strong = "<b>"; $strong2 = "</b>"; } else { $strong = ""; $strong2 = ""; }
				if (strlen($message) > 40) { $message = "".substr($message, 0, 40)."...";  }
				if (strlen($message) == 0) { $message = strip_tags($row[message], '<img>'); }
				$sOutput .= "<tr>
							 <td align='center'>".$strong."" . $number . "".$strong2."</td>
							 <td align='center'>".$strong."$row[time]".$strong2."</td>
							 <td align='center'><a href='m.php?user=$row[sender]'>".$strong."$row[sender]".$strong2."</a></td>
							 <td align='left'><div class='lauzyti2'><a href='pm.php?action=read&amp;message=$row[mid]'>".$strong."$message".$strong2."</a></div></td>
							 <td align='center'><a href='pm.php?action=delete&amp;message=$row[mid]'><font color='red'>".$strong."".$phrase[109]."".$strong2."</font></a></td></tr>";  
			}
			if ($i == 0) { $sOutput .='<tr><td colspan="5" align="center"> ' . $phrase[105] . ' </td></tr>'; }
			$sql = "SELECT COUNT(message) FROM messages WHERE receiver = '".$_SESSION['username']."'"; 
			$rs_result = mysql_query($sql); 
			$row = mysql_fetch_row($rs_result); 
			$total_records = $row[0];
			$total_pages = ceil($total_records / 20);
			$sOutput .= '<tr><td colspan="5" align="center">';
			for ($i=1; $i<=$total_pages; $i++) { 
			$sOutput .="<a href='pm.php?action=inbox&amp;page=$i'>$i</a> "; 
			};
			$sql = "SELECT COUNT(message) FROM messages WHERE deleted = '0' AND receiver = '".$_SESSION['username']."'";
			$rs_result = mysql_query($sql); 
			$row = mysql_fetch_row($rs_result);
			$sOutput .= " <br>" . $phrase[89] . " [".$row[0]."/".$max_pm."]"; 
			$sOutput .= "<br><a href='pm.php'> " . $phrase[89] . " </a>";
			$sOutput .= '</td></tr>';
			$sOutput .= '</table>';
		}
		if  (strtolower($_GET['action']) == 'sent') {
			$sql = "SELECT mid,message,time,sender,new,receiver FROM messages WHERE sender = '".$_SESSION['username']."' ORDER BY time DESC LIMIT $start_from, 20"; 
			$query = mysql_query($sql) or die("Query Failed: " . mysql_error());
			$sOutput = '<table width="700" border="1" align="center" cellpadding="5" cellspacing="0">
					<tr>
					<td align="center "colspan="4">'.$phrase[114].'</td>
					</tr>
					<tr>
						<td width="5%" align="center"> ' . $phrase[102] . ' </td>
						<td width="22%" align="center"> ' . $phrase[103] . ' </td>
						<td width="22%" align="center"> ' . $phrase[107] . ' </td>
						<td width="51%" align="center"> ' . $phrase[101] . ' </td>
					</tr>';
					$i=0;
			while ($row = mysql_fetch_assoc($query)) {
				$i++;
				$number = $i+($page-1)*20;
				$message = strip_tags($row[message]);
				if ($row['new'] == 1) { $strong = "<b>"; $strong2 = "</b>"; } else { $strong = ""; $strong2 = ""; }
				if (strlen($message) > 40) { $message = "".substr($message, 0, 40)."...";  }
				if (strlen($message) == 0) { $message = strip_tags($row[message], '<img>'); }
				$sOutput .= "<tr>
							 <td align='center'>".$strong."" . $number . "".$strong2."</td>
							 <td align='center'>".$strong."$row[time]".$strong2."</td>
							 <td align='center'><a href='m.php?user=$row[receiver]'>".$strong."$row[receiver]".$strong2."</a></td>
							 <td align='left'><div class='lauzyti2'><a href='pm.php?action=sread&amp;message=$row[mid]'>".$strong."$message".$strong2."</a></div></td></tr>";  
			}
			if ($i == 0) { $sOutput .='<tr><td colspan="4" align="center"> ' . $phrase[108] . ' </td></tr>'; }
			$sql = "SELECT COUNT(message) FROM messages WHERE sender = '".$_SESSION['username']."'"; 
			$rs_result = mysql_query($sql); 
			$row = mysql_fetch_row($rs_result); 
			$total_records = $row[0];
			$total_pages = ceil($total_records / 20);
			$sOutput .= '<tr><td colspan="4" align="center">';
			for ($i=1; $i<=$total_pages; $i++) { 
			$sOutput .="<a href='pm.php?action=sent&amp;page=$i'>$i</a> "; 
			};
			$sOutput .="<br><a href='pm.php'> " . $phrase[89] . " </a>";
			$sOutput .= '</td></tr>';
			$sOutput .= '</table>';
		}
	}
	echo $sOutput;
}else {
	include('include_content/not_registered.php');
}
include('include_content/html_bottom.php'); 
?>