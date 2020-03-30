<!DOCTYPE html>
<html>
<head>
	<title>Admin panel login</title>
	<link rel="shortcut icon" type="image/png" href="src/app/views/images/logo2.jpg"/>
</head>
<body>
	<form method="POST" action="<? echo $this->url('postAdminLogin'); ?>">
		<input type="text" name="username" placeholder="User name">
		<input type="password" name="password" placeholder="Password">
		<input type="submit" name="submit" value="Go">
	</form>
</body>
</html>