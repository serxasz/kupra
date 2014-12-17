<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<head>
	<form action="search.php" method="post">
     Recepto paieska: <input type="text" name="term" />
    <input type="submit" name="submit" value="Ieskoti" /><br/>
    </form>
	<br>
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="icon" type="image/png" href="images/favicon.png">
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
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