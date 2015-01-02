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
</head>
<body>
	<nav class="navbar navbar-default">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">KuPRA</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="#contact">
                <form action="globali_paieska.php" method="post">
                	<input style="width: 500px" type="text" name="term"
                	placeholder ="Ieskoti recepto pagal pavadinima arba vartotojo varda"/>
                   <input type="submit" name="submit" value="Ieskoti" /><br/>
                </form></a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Kalba <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#Anglu">Anglų</a></li>
                  <li><a href="#Lietuviu">Lietuvių</a></li>
                </ul>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </nav>

<div class="container" role="main">
<?
      if (loggedIn($where)) {
        echo '
            <div class="container col-md-2">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Meniu</h3>
                        </div>
                        <div class="panel-body">
                            <a href="vnt_klasifikatorius.php">Matavimo vienetai</a><br />
                            <a href="produktu_klasifikatorius.php">Produktai</a><br />';

        if ($where == "produktai") {
            echo           '<a href="prideti_produkta.php">--- Pridėti produktą</a><br />';
        }

        echo '
                            <a href="visi_receptai.php">Receptai</a><br />';
        if ($where == "receptai") {
            echo           '<a href="prideti_recepta.php">--- Pridėti receptą</a><br />';
            echo           '<a href="mano_receptai.php">--- Mano receptai</a><br />';
        }

        echo '
                            <a href="fridge.php">Šaldytuvas</a><br />
                        </div>
                </div>
            </div>';
        }
?>
    <div class="container col-md-10">