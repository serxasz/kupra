<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<!-- old Style -->
	<!-- <link rel="stylesheet" type="text/css" href="style.css"> -->

	<!-- Bootstrap -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<link rel="icon" type="image/png" href="images/favicon.png">
	<!-- 
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	-->
	<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
	
	tinymce.init({
    selector: "textarea",
	menubar:false,
	statusbar: false,
	plugins: "emoticons paste textcolor",
    toolbar: "emoticons forecolor bold italic underline alignleft aligncenter alignright undo redo",
	paste_data_images: false,
	paste_as_text: true,
	object_resizing : false,
	skin : 'lightgray',
	theme : 'modern'
	});
	</script>

    <?php 
    if ($where == "naujas_receptas") {
    echo'   <script>
            function showUser(str, rcpID) {
                if (str == "") {
                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function() {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                        }
                    }
                    xmlhttp.open("GET","produktai.php?rcpid="+rcpID,true);
                    xmlhttp.send();
                } else { 
                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function() {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                        }
                    }
                    xmlhttp.open("GET","produktai.php?q="+str+"&rcpid="+rcpID,true);
                    xmlhttp.send();
                }
            }
            </script>';
    }

    ?>

    <?php 
    if ($where == "naujas_receptas") {
    echo'   <script>
            function productAddition(str, id, rcpID) {
                if (str == "") {
                    document.getElementById("addProduct").innerHTML = "";
                    return;
                } else { 
                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function() {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            document.getElementById("addProduct").innerHTML = xmlhttp.responseText;
                        }
                    }
                    xmlhttp.open("GET","produktai2.php?add="+str+"&id="+id+"&rcpid="+rcpID,true);
                    xmlhttp.send();
                }
            }
            </script>';
    }

    ?>
</head>
<body>
<div class="container" role="main">
	<nav class="navbar navbar-default">
        <div class="container">
          <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            <a class="navbar-brand" href="/">KuPRA <span class="glyphicon glyphicon-cutlery"></span> </a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-center">
                    <li>
                    <?php if (loggedIn($where)) {
                        echo '
                        <form class="navbar-form navbar-header" role="search" action="globali_paieska.php" method="post">
                            <input style="width: 380px" type="text" name="term"
                        	placeholder ="Receptų paieška pagal pavadinimą arba vartotojo vardą"/>
                            <button type="submit" name="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
                        </form>';
                        } else {
                            echo 'Čia turi būti prisijungimo langai Čia turi būti prisijungimo langai';
                        } ?>
                    </li>
                </ul>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-globe"></span> Kalba <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="<? echo $_SERVER['PHP_SELF']; ?>?lang=0">Anglų</a></li>
                          <li><a href="<? echo $_SERVER['PHP_SELF']; ?>?lang=1">Lietuvių</a></li>
                        </ul>
                    </li>
                      <li>
                        <?php if (loggedIn(null)) { $username = $_SESSION['username']; echo "<a href=\"/m.php?user=$username\"><span class=\"glyphicon glyphicon-user\"></span> $username</a>"; } ?>
                      </li>
                      <li>
                        <?php if (loggedIn(null)) { 
                            $sql = "SELECT COUNT(message) FROM messages WHERE deleted = '0' AND receiver = '".$_SESSION['username']."'";
                            $rs_result = mysql_query($sql); 
                            $row = mysql_fetch_row($rs_result);
                            $sql = "SELECT COUNT(new) FROM messages WHERE deleted = '0' AND receiver = '".$_SESSION['username']."' AND new='1'";
                            $rs_result = mysql_query($sql); 
                            $row1 = mysql_fetch_row($rs_result);
                            if ($row1[0] > 0) { $strong1 = "<b>"; $strong2 = "</b>"; }else { $strong1 = ""; $strong2 = ""; }
                            echo"<a href=\"pm.php\"><span class=\"glyphicon glyphicon-envelope\"></span>".$strong1." [".$row[0]."/".$max_pm."]".$strong2."</a>";
                            } 
                        ?>
                      </li>
                      <li>
                        <?php if (loggedIn(null)) { echo"<a href=\"users_online.php\"><span class=\"glyphicon glyphicon-globe\"></span> Prisijungę:  <b>" . countOnlineUsers() . "</b></a>"; } ?>
                      </li>
                      <li>
                        <?php if (loggedIn(null)) { echo '<a href="login.php?action=logout"><span class="glyphicon glyphicon-off"></span> Atsijungti</a>'; } ?>
                    </li>
                </ul>
          </div><!--/.nav-collapse -->
        </div>
      </nav>
      <div class="row">
<?
    // Meniu
      if (loggedIn($where)) {
        echo '
            <div class="col-md-2">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Meniu</h3>
                        </div>
                        <div class="panel-body">
                            <a href="vnt_klasifikatorius.php">Matavimo vienetai</a><br />';

        if ($where == "vienetai" or $where == "naujas_vienetas") {
            if ($where == "vienetai") {
                $listStart = '<div class="bg-info">';
                $listEnd = '</div>';
            } else {
                $createStart = '<div class="bg-info">';
                $createEnd = '</div>';
            }

            echo           "$listStart<a href=\"vnt_klasifikatorius.php\">--- Vienetų sąrašas</a><br />$listEnd";
            echo           "$createStart<a href=\"prideti_vieneta.php\">--- Pridėti vienetą</a><br />$createEnd";
        }

        echo '
                            <a href="produktu_klasifikatorius.php">Produktai</a><br />';

        if ($where == "produktai" or $where == "naujas_produktas") {
            if ($where == "produktai") {
                $listStart = '<div class="bg-info">';
                $listEnd = '</div>';
            } else {
                $createStart = '<div class="bg-info">';
                $createEnd = '</div>';
            }

            echo           "$listStart<a href=\"produktu_klasifikatorius.php\">--- Produktų sąrašas</a><br />$listEnd";
            echo           "$createStart<a href=\"prideti_produkta.php\">--- Pridėti produktą</a><br />$createEnd";
        }

        echo '
                            <a href="visi_receptai.php">Receptai</a><br />';
        if ($where == "receptai" or $where == "mano_receptai" or $where == "naujas_receptas" or $where == "redaguoti_recepta") {
            if ($where == "receptai") {
                $listStart = '<div class="bg-info">';
                $listEnd = '</div>';
            } elseif ($where == "mano_receptai" or $where == "redaguoti_recepta") {
                $myStart = '<div class="bg-info">';
                $myEnd = '</div>';
            } elseif ($where == "naujas_receptas") {
                $createStart = '<div class="bg-info">';
                $createEnd = '</div>';    
            }

            echo           "$listStart<a href=\"visi_receptai.php\">--- Receptų sąrašas</a><br />$listEnd";
            echo           "$myStart<a href=\"mano_receptai.php\">--- Mano receptai</a><br />$myEnd";
            echo           "$createStart<a href=\"prideti_recepta.php\">--- Pridėti receptą</a><br />$createEnd";
        }


        if ($where == "saldytuvas") {
            $listStart = '<div class="bg-info">';
            $listEnd = '</div>';

            echo "$listStart<a href=\"fridge.php\">Šaldytuvas</a><br />$listEnd";
		
        } else {
            echo "<a href=\"fridge.php\">Šaldytuvas</a><br />";	
	
        }



		
		 echo '
                            <a href="valgiarastis.php">Valgiaraštis</a><br />';

        if ($where == "valgiarastis" or $where == "naujas_valgiarastis") {
            if ($where == "valgiarastis") {
                $listStart = '<div class="bg-info">';
                $listEnd = '</div>';
            } else {
                $createStart = '<div class="bg-info">';
                $createEnd = '</div>';
            }

            echo           "$listStart<a href=\"valgiarastis.php\">--- Valgiaraščiai</a><br />$listEnd";
            echo           "$createStart<a href=\"sukurti_valgiarasti.php\">--- Sukurti Valgiarašti</a><br />$createEnd";
        }
		
		


        echo '         </div>';
         echo'       </div>';
         // Admin menu
        $sql = "SELECT type FROM users where username='".$_SESSION['username']."' LIMIT 1";
        $query = mysql_query($sql) or trigger_error("Query Failed: " . mysql_error());
        $row = mysql_fetch_array($query);
        if ($row[type]=="Administratorius") { 
            echo'<div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Admin Menu</h3>
                        </div>
                        <div class="panel-body">
                            <a href="admin.php?action=member_list">Narių sąrašas</a><br>
                            <a href="admin.php?action=delete_user">Ištrinti vartotoją</a><br>
                            <a href="admin.php?action=group_email">Siųsti masinį email</a><br>
                            <a href="edit_clasificator.php">Matavimo vienetai</a><br>
                            <a href="edit_products.php">Produktai</a>
                 </div>
                 </div>';
        }
           echo' </div>';
        echo '<div class="container col-md-10">';

    } else {
            echo '<div class=\"container col-md-12\">';
    }
?>