<!DOCTYPE html>
<html>
<head>
	<title><? echo $user->firstname ?> <? echo $user->lastname ?> Account </title>
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
		<h4>Mr/Ms <? echo $user->firstname ?> <? echo $user->lastname ?> , your dz-courses account not expired yet.</h4> 
			<div class="danger">
				Last activation : <? echo $user->activated_at; ?> , <? echo 31-$expirat; ?> days left.
			</div>
			<br/>
			<br/>
		<small>Registred at : <? echo $user->created_at; ?></small>
	</div>
</body>
</html>