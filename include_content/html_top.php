<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<head>
	<meta charset="utf-8">
	<form action="globali_paieska.php" method="post">
	<input style="width: 500px" type="text" name="term"
	placeholder ="Ieskoti recepto pagal pavadinima arba vartotojo varda"/>
    <input type="submit" name="submit" value="Ieskoti" /><br/>
    </form>
	<br>
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