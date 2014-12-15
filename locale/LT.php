<?php 
$phrase[1] = "Ištrinti vartotoją";
$phrase[2] = "Siųsti email visiems vartotojams";
$phrase[3] = "Uždirbta";
$phrase[4] = "Pagrindinis puslapis";
$phrase[5] = '<strong><font color="green">Baigta!</font></strong><br>
													<strong>Vartotojas "' . $_POST['user'] . '" buvo ištrintas.</strong><br>
													<a href="admin.php">Administracijos pultas</a>';
$phrase[6] = "Vartotojas neegzistuoja, arba negali būti ištrintas.";
$phrase[7] = "Slapyvardis turi būti ne trumpesnis už 5, bei ne ilgesnis už 15 simbolių.";
$phrase[8] = "Slapyvardžio laukelis tuščias.";
$phrase[9] = "Neteisingai įvestas patvirtinimo kodas.";
$phrase[10] = "Nuo: neatsakyti@$adress";
$phrase[11] = '<strong><font color="green">Baigta!</font></strong><br>
				<strong>' . $total_records . ' </strong>emailai buvo išsiųsti.<br>
				<a href="admin.php">Administracijos pultas</a>';
$phrase[12] = "Patvirtinimo kodas tuščias.";
$phrase[13] = "Tema turi būti ne trumpesnė nei 15 simbolių.";
$phrase[14] = "Emailo turinys privalo viršyti 50 simbolių.";
$phrase[15] = "Negalima siųsti tuščio emailo.";
$phrase[16] = "Slapyvardis:";
$phrase[17] = "Administracijos pultas";
$phrase[18] = "Siųsti emailą visiems registruotiems nariams";
$phrase[19] = "Neįvestas Slapyvardis/Slaptažodis.";
$phrase[20] = "<h2>Prisijungti</h2>";
$phrase[21] = "Slaptažodis:";
$phrase[22] = "Prisiminti mane:";
$phrase[23] = "Prisijungti";
$phrase[24] = "Pamiršai slaptažodį?";
$phrase[25] = '<h4><a href="login.php">Prisijungti</a></h4> 
				<h4><a href="register.php">Registruotis</a></h4>';
$phrase[26] = '<strong><font color="green">Slaptažodis pakeistas sėkmingai!</font></strong><br>
												<strong><font color="green">Jūsų naujas slaptažodis yra: </font>' . $_POST['password2'] . '</strong><br>
												<a href="index.php">Pagrindinis puslapis</a>';
$phrase[27] = "Dabartinis slaptažodis neteisingas.";
$phrase[28] = "Slaptažodis privalo būti ne trumpesnis nei 7, bei ne ilgesnis nei 30 simbolių.";
$phrase[29] = "Naujas slaptažodis turi skirtis nuo senojo.";
$phrase[30] = "Nesutampa slaptažodžiai.";
$phrase[31] = "Neįvestas slaptažodis/slaptažodžiai.";
$phrase[32] = '<strong><font color="green">Emailas pakeistas sėkmingai!</font></strong><br>
													<strong><font color="green">Tavo naujas emailas yra: </font>' . $_POST['email'] . '</strong><br>
													<a href="index.php">Pagrindinis puslapis</a>';
$phrase[33] = "Šis emailo adresas jau naudojamas.";
$phrase[34] = "Naujas emailas privalo skirtis nuo senojo.";
$phrase[35] = "Šis emailas nerastas duomenų bazėje.";
$phrase[36] = "Emailas privalo būti ne trumpesnis nei 6, bei ne ilgesnis nei 60 simbolių.";
$phrase[37] = "Klaidingas emailas.";
$phrase[38] = "Neįvestas emailas.";
$phrase[39] = "Dabartinis slaptažodis:";
$phrase[40] = "Naujas slaptažodis:";
$phrase[41] = "Pakartoti naują slaptažodį:";
$phrase[42] = "Keisti";
$phrase[43] = "Naujas emailas:";
$phrase[44] = "<h2>Sveiki atvykę!</h2>";
$phrase[45] = "Labas, " . $_SESSION['username'] . ".";
$phrase[46] = "Prisijungę:";
$phrase[47] = "Redaguoti profilį";
$phrase[48] = "<h4><a href=\"login.php?action=logout\">Atsijungti</a></h4>";
$phrase[49] = "<font color='green'><b>PRISIJUNGĘS</b></font>";
$phrase[50] = "<font color='red'><b>ATSIJUNGĘS</b></font>";
$phrase[51] = "ID:";
$phrase[52] = "Emailas:";
$phrase[53] = "Keisti slaptažodį";
$phrase[54] = "Keisti emailą";
$phrase[55] = "Toks vartotojas neegzistuoja!";
$phrase[56] = "&lt;Atgal";
$phrase[57] = 'Slaptažodžio atstatymas';
$phrase[58] = ' 
 
								Brangus '.$row['username'].',
								Gavome prašymą atstatyti Jūsų slaptažodį!
								Prašau paspausti šią nuorodą, jei norite atstatyti slaptažodį:
								
								
								----------------------------------------
								http://www.'.$adress.'/reset.php?email='.$email.'&hash='.sha1($row['password']).'
								----------------------------------------

								
								Jei neprašėte atstatyti slaptažodio, tiesiog ignoruokite šį laišką.
								
								www.'.$adress.' komanda.
								';
$phrase[59] = 'Slaptažodžio atstatymo emailas išsiųstas sėkmingai!<br><a href="index.php">Pagrindinis puslapis</a>';
$phrase[60] = "Emailas neegzistuoja.";
$phrase[61] = "Atstatyti";
$phrase[62] = 'Registracija | Patvirtinimas';
$phrase[63] = ' 
 
								Ačiū, kad užsiregistravote! 
								Jūsų paskyra sukurta, tačiau norėdami prisijungti pirmiausia turėsite patvirtinti savo emailą, paspausdami nuorodą esančią apačioje.   
 
								---------------------------------------- 
								Slapyvardis: '.$_POST['username'].' 
								Slaptažodis: '.$_POST['password'].' 
								----------------------------------------
 
								Prašau paspausti šią nuorodą, jei norite aktyvuoti savo paskyrą: 
 
								http://www.'.$adress.'/verify.php?email='.$_POST['email'].'&hash='.sha1(sha1($_POST['password'])).'

								----------------------------------------
								www.'.$adress.' komanda.
								';
$phrase[64] = "Paskyra sukurta sėkmingai!";
$phrase[65] = 'Patvirtinimo laiškas buvo nusiųstas į '.$_POST['email'].'.<br>
				Norėdami prisijungti, turite sekti nurodymus išsiųstus į Jūsų emailą. <a href="index.php"><br>Pagrindinis puslapis</a>';
$phrase[66] = 'Dabar galite prisijungti <a href="login.php">čia</a>';
$phrase[67] = "Neįvestas Slapyvardis/Slaptažodis.";
$phrase[68] = '<h2>Registruotis</h2>';
$phrase[69] = "Pakartokite slaptažodį:";
$phrase[70] = "Registruotis";
$phrase[71] = '<h4><a href="login.php">Prisijungti</a></h4>';
$phrase[72] = 'Naujas slaptažodis';
$phrase[73] = ' 
 
				Brangus '.$row['username'].', 
				Kaip ir prašėte, mes Jums sugeneravome naują slaptažodį:
 
				---------------------------------------- 
				Slapyvardis: '.$row['username'].' 
				Slaptažodis: '.$newPass.' 
				----------------------------------------
 
				Prisijungti galite čia: 
 
				http://www.'.$adress.'/login.php

				----------------------------------------
				www.'.$adress.' komanda.
				';
$phrase[74] = 'Laiškas su nauju slaptažodžiu buvo nusiųstas į '.$email.'.<br><a href="login.php">Prisijungti</a>';
$phrase[75] = "Prisijungę vartotojai:";
$phrase[76] = 'Jūsų paskyra aktyvuota. Dabar galite<br><a href="login.php">Prisijungti.</a>';
$phrase[77] = "Keisti Slaptažodį/Emailą";
$phrase[78] = "Peržiūrėti profilį";
$phrase[79] = "Prisijungę vartotojai";
$phrase[80] = "Administracijos pultas";
$phrase[81] = "Pagrindinis puslapis";
$phrase[82] = "<h2>Sveiki atvykę</h2>";
$phrase[83] = "<h4><a href=\"login.php\">Prisijungti</a></h4>";
$phrase[84] = "<h4><a href=\"register.php\">Registruotis</a></h4>";
$phrase[85] = "Toks vartotojas jau egzistuoja.";
$phrase[86] = "Šis emailas jau yra naudojamas.";
$phrase[87] = "Paskyra neaktyvuota. Patikrinkite savo emailą.";
$phrase[88] = "Neteisingas Slapyvardis/Slaptažodis.";
$phrase[89] = "Žinutės";
$phrase[90] = "Rašyti žinutę";
$phrase[91] = "Gauta";
$phrase[92] = "Išsiųsta";
$phrase[93] = "Žinutė:";
$phrase[94] = "Siųsti";
$phrase[95] = 'Žinutė išsiųsta sėkmingai.<br><a href="pm.php">Žinutės</a>';
$phrase[96] = 'Privalote palaukti ';
$phrase[97] = ' sekundes, kad išsiųstumėte šią žinutę.';
$phrase[98] = 'Žinutė negali būti ilgesnė nei 2000 simbolių. 1 šypsenėlė laikoma kaip ~50 simbolių.';
$phrase[99] = 'Kažkuris laukelis paliktas tuščias.';
$phrase[100] = 'Nuo:';
$phrase[101] = 'Ištrauka:';
$phrase[102] = 'Nr.:';
$phrase[103] = 'Data:';
$phrase[104] = "Deja, sau žinučių siųsti negalima.";
$phrase[105] = " pranešimų dėžutė yra pilna. Vartotojas negali gauti naujų žinučių.";
$phrase[105] = "Tuščia.";
$phrase[106] = "Atsakyti";
$phrase[107] = "Kam:";
$phrase[108] = "Išsiųstų žinučių nėra.";
$phrase[109] = "[X]"; //delete sign
$phrase[110] = "Ištrinti šią žinutę?";
$phrase[111] = "TAIP";
$phrase[112] = "NE";
$phrase[113] = "Tema:";
$phrase[114] = "Saugomas tik paskutinis ".$max_pm." jau ištrintų žinučių!";
$phrase[115] = "Vartotojo tipas:";
?>