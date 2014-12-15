<?php 
$phrase[1] = "Delete user";
$phrase[2] = "Send group email";
$phrase[3] = "Earnings";
$phrase[4] = "Main page";
$phrase[5] = '<strong><font color="green">Done!</font></strong><br>
													<strong>User "' . $_POST['user'] . '" was deleted.</strong><br>
													<a href="admin.php">Admin panel</a>';
$phrase[6] = "User doesn't exist, or cannot be deleted.";
$phrase[7] = "Username must be between 5 and 15 characters.";
$phrase[8] = "Username field is empty.";
$phrase[9] = "Verification code wasn't entered correctly.";
$phrase[10] = "From: noreply@$adress";
$phrase[11] = '<strong><font color="green">Done!</font></strong><br>
				<strong>' . $total_records . ' </strong>emails were sent.<br>
				<a href="admin.php">Admin panel</a>';
$phrase[12] = "Verification code is empty.";
$phrase[13] = "Subject must contain at least 15 characters.";
$phrase[14] = "Email must contain at least 50 characters.";
$phrase[15] = "Cannot send empty email.";
$phrase[16] = "Username:";
$phrase[17] = "Admin panel";
$phrase[18] = "Send email to all registered members";
$phrase[19] = "Username and Password are required to login.";
$phrase[20] = "<h2>Login to our site</h2>";
$phrase[21] = "Password:";
$phrase[22] = "Remember Me:";
$phrase[23] = "Login";
$phrase[24] = "Forgot password?";
$phrase[25] = '<h4>Would you like to <a href="login.php">login</a>?</h4> 
				<h4>Create a new <a href="register.php">account</a>?</h4>';
$phrase[26] = '<strong><font color="green">Password changed successfully!</font></strong><br>
												<strong><font color="green">Your new password is: </font>' . $_POST['password2'] . '</strong><br>
												<a href="index.php">Home</a>';
$phrase[27] = "Current password is not correct.";
$phrase[28] = "Password must be between 7 and 30 characters.";
$phrase[29] = "New password must differ from old one.";
$phrase[30] = "Passwords don't match.";
$phrase[31] = "One or more passwords were not supplied.";
$phrase[32] = '<strong><font color="green">Email changed successfully!</font></strong><br>
													<strong><font color="green">Your new email is: </font>' . $_POST['email'] . '</strong><br>
													<a href="index.php">Home</a>';
$phrase[33] = "This email is already in use.";
$phrase[34] = "New email must differ from previous email.";
$phrase[35] = "Email not found in database.";
$phrase[36] = "Email must be between 6 and 60 characters.";
$phrase[37] = "Invalid email.";
$phrase[38] = "Email was not supplied.";
$phrase[39] = "Current password:";
$phrase[40] = "New password:";
$phrase[41] = "Repeat new password:";
$phrase[42] = "Change";
$phrase[43] = "New email:";
$phrase[44] = "<h2>Welcome!</h2>";
$phrase[45] = "Hello, " . $_SESSION['username'] . " how are you today?";
$phrase[46] = "Online:";
$phrase[47] = "Edit profile";
$phrase[48] = "<h4>Would you like to <a href=\"login.php?action=logout\">Logout?</a></h4>";
$phrase[49] = "<font color='green'><b>ONLINE</b></font>";
$phrase[50] = "<font color='red'><b>OFFLINE</b></font>";
$phrase[51] = "ID:";
$phrase[52] = "Email:";
$phrase[53] = "Change pass";
$phrase[54] = "Change email";
$phrase[55] = "User doesn't exist!";
$phrase[56] = "&lt;back";
$phrase[57] = 'Password recovery';
$phrase[58] = ' 
 
								Dear '.$row['username'].',
								We got a request to recover your password!
								Please click this link to reset your password:
								
								
								----------------------------------------
								http://www.'.$adress.'/reset.php?email='.$email.'&hash='.sha1($row['password']).'
								----------------------------------------

								
								If you did not request this forgotten password email, just ignore it.
								
								www.'.$adress.' team.
								';
$phrase[59] = 'Recovery email sent successfully!<br><a href="index.php">Main page</a>';
$phrase[60] = "Email doesn't exist.";
$phrase[61] = "Recover";
$phrase[62] = 'Signup | Verification';
$phrase[63] = ' 
 
								Thanks for signing up! 
								Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below. 
 
								---------------------------------------- 
								Username: '.$_POST['username'].' 
								Password: '.$_POST['password'].' 
								----------------------------------------
 
								Please click this link to activate your account: 
 
								http://www.'.$adress.'/verify.php?email='.$_POST['email'].'&hash='.sha1(sha1($_POST['password'])).'

								----------------------------------------
								www.'.$adress.' team.
								';
$phrase[64] = "Your account has been created!";
$phrase[65] = 'A validation e-mail has been sent to '.$_POST['email'].'.<br>
				In order to log in, you will need to follow the instructions in that message. <a href="index.php"><br>Main page</a>';
$phrase[66] = 'You can now login <a href="login.php">here</a>';
$phrase[67] = "Username and/or Password was not supplied.";
$phrase[68] = '<h2>Register for this site</h2>';
$phrase[69] = "Repeat password:";
$phrase[70] = "Register";
$phrase[71] = '<h4>Would you like to <a href="login.php">login</a>?</h4>';
$phrase[72] = 'New password';
$phrase[73] = ' 
 
				Dear '.$row['username'].', 
				As you requested, we generated a new password for you:
 
				---------------------------------------- 
				Username: '.$row['username'].' 
				Password: '.$newPass.' 
				----------------------------------------
 
				You can sign in here: 
 
				http://www.'.$adress.'/login.php

				----------------------------------------
				www.'.$adress.' team.
				';
$phrase[74] = 'Email with a new password was sent to '.$email.'.<br><a href="login.php">Login</a>';
$phrase[75] = "Users Online:";
$phrase[76] = 'Your account has been activated, you can now login<br><a href="login.php">login</a>';
$phrase[77] = "Change email/password";
$phrase[78] = "View profile";
$phrase[79] = "Online users";
$phrase[80] = "Admin Panel";
$phrase[81] = "Main page";
$phrase[82] = "<h2>Welcome to our site</h2>";
$phrase[83] = "<h4>Would you like to <a href=\"login.php\">login</a>?</h4>";
$phrase[84] = "<h4>Create a new <a href=\"register.php\">account</a>?</h4>";
$phrase[85] = "Username already exists.";
$phrase[86] = "This email is already in use.";
$phrase[87] = "Account is not activated. Check your email.";
$phrase[88] = "Bad username or password supplied.";
$phrase[89] = "Messages";
$phrase[90] = "Write message";
$phrase[91] = "Inbox";
$phrase[92] = "Sent messages";
$phrase[93] = "Message:";
$phrase[94] = "Send";
$phrase[95] = 'Message sent successfully.<br><a href="pm.php">Messages</a>';
$phrase[96] = 'You need to wait ';
$phrase[97] = ' seconds, to send this message.';
$phrase[98] = 'Message cannot be longer than 2000 characters. 1 smiley counts as ~50 characters.';
$phrase[99] = 'One or more fields are empty.';
$phrase[100] = 'From:';
$phrase[101] = 'Fragment:';
$phrase[102] = 'No.:';
$phrase[103] = 'Date:';
$phrase[104] = "Unfortunately, you can't send messages to yourself.";
$phrase[105] = "'s inbox is full. User cannot receive any messages.";
$phrase[105] = "Inbox is empty.";
$phrase[106] = "Reply";
$phrase[107] = "To:";
$phrase[108] = "There are no sent messages.";
$phrase[109] = "[X]"; //delete sign
$phrase[110] = "Delete this message?";
$phrase[111] = "YES";
$phrase[112] = "NO";
$phrase[113] = "Subject:";
$phrase[114] = "Only last ".$max_pm." of already deleted messages are saved!";
$phrase[115] = "User type:";
?>