<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Khan Store</title>
		<!-- <link rel="stylesheet" href="css/bootstrap.min.css"/> -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
		<!-- <script src="<?php echo getStaticAssets("bootstrap.min.js"); ?>"></script> -->
		<script src="<?php echo getJSScript('common'); ?>"></script>
		<script src="<?php echo getJSScript('urlConfig'); ?>"></script>
		<script src="<?php echo getStaticAssets("main.js"); ?>"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo getStylesheet("style.css"); ?>" />
	</head>
<body loggedin="<?php echo isset($_SESSION['uid']) ? 'true' : 'false'; ?>">
<div id="toast-container"></div>

