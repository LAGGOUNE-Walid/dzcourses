<!DOCTYPE html>
<html>
<head>
	<title>Dz-courses - <? echo $data["filename"]; ?></title>
	<link rel="shortcut icon" type="image/png" href="<? echo $this->url(""); ?>/src/app/views/images/logo2.jpg"/>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<style type="text/css">
		.header {
			padding: 0.2%;
			border-bottom: 1px solid black;
		}
		h5	{
			display: inline;
		}
		.content {
			margin-top: 5%;
			margin-left: 10%;
			margin-right: 10%;
		}
	</style>
</head>
<body>
	<div class="header">
 		<img style="width: 120px; height: 100px;" src="<? echo $this->url(""); ?>/src/app/views/images/logo2.jpg"> <h5><i>Powered by <a href="<? echo $this->url(''); ?>">dz-courses</a></i></h5>
	</div>
	<div class="content">
			<div class="card">
			  <div class="card-header">
			  	<? echo $data["filename"]; ?>
			  </div>
		  	<div class="card-body">
			    <blockquote class="blockquote mb-0">
			      <ul style="font-size: 16px;">
			      	<li>Uploaded by : <span class="badge badge-secondary"><? echo $data["user"]; ?></span></h1></li>
			      	<li>File title : <span class="badge badge-secondary"><? echo $data["filename"]; ?></span></h1></li>
			      	<li>Size : <span class="badge badge-secondary"><? echo $data["size"]; ?> MB</span></h1></li>
			      	<li>Extension : <span class="badge badge-secondary">ZIP</span></h1></li>
			      	<li>Downloads : <span class="badge badge-secondary"><? echo $data["downloads"]; ?></span></h1></li>
			      </ul>
			      <footer class="blockquote-footer">Uploaded at <cite title="Source Title"><? echo $data["created_at"]; ?></cite></footer>
			    </blockquote>
			  </div>
		</div>
		<br/>
		<form method="POST" action="<? echo $this->url('pfile') ?>/<? echo $data['id']; ?>">
			<button  type="submit" class="btn btn-outline-dark">Download</button>
		</form>
	</div>
</body>
</html>