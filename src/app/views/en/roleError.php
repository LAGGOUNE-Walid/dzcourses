<!DOCTYPE html>
<html>
<head>
	<title>Role error</title>
	<link rel="shortcut icon" type="image/png" href="src/app/views/images/logo2.jpg"/>
	<style type="text/css">
		body {
			background-color: #f3f3f3;
			font-family: "Courier New";
		}
		.content {
			background-color: white;
			border-left: 5px solid black;
			width: 50%;
			margin-right: 20%;
			margin-left: 20%;
			margin-top: 5%;
			padding: 5%;
		}
		.danger {
			background-color: #ff9b9b;
			padding: 5%;
		}
		.faqs {
			background-color: #f7c399;
			padding: 5%;
		}
	</style>
</head>
<body>
	<div class="content">
		<div class="danger">
			<small>
			<? echo $error; ?>
			</small>
		</div>
		<br/>
		<br/>
	</div>
</body>
</html>