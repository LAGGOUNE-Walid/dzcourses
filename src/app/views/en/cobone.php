<!DOCTYPE html>
<html>
<head>
	<title>Use cobone </title>
	<link rel="shortcut icon" type="image/png" href="src/app/views/images/logo2.jpg"/>
	    <script src="https://kit.fontawesome.com/a20f839145.js" crossorigin="anonymous"></script>
	        <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/bootstrap/css/bootstrap.min.css');?>">

	<style type="text/css">
		body {
			background-color: #f3f3f3;
			font-family: "Courier New";
		}
		.content {
			background-color: white;
			border-left: 5px solid black;
			width: 80%;
			margin-right: 10%;
			margin-left: 10%;
			margin-top: 5%;
			padding: 5%;
		}
		input{
			width: 80%;
			padding: 2%;
			border: 1px solid #d6d6d6;
		}
		form{
			display: inline;
		}
		button	{
			width: 10%;
			padding: 2%;
			border: 1px solid #d6d6d6;
		}
	</style>
</head>
<body>
	<div class="content">
	<?php if (isset($error)): ?>
		<div class="alert alert-danger" role="alert">
		 	<? echo $error; ?>
		</div>
	<?php endif; ?>
		<h3 style="color:#a1a1a1;">Congratulation <i class="fas fa-gift"></i> ! just one more step.</h3>
		<form method="POST" action="<? echo $this->url('postCobone'); ?>">
			<input type="text" name="cobone" placeholder="Copy and past here your cobone code">
			<button type="submit">Go</button>
		</form>
	</div>
</body>
</html>