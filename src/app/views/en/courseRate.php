<?
$data 	= 	[0 => 0, 1 => 0, 2 =>0, 3=>0];
$times	=	0;
$rates 	= 	0;
foreach($courseRates as $courseRate) {
	if ($courseRate->rate <= 3) {
    	$data[0] = $data[0] + 1;
    }elseif($courseRate->rate > 3 and $courseRate->rate <= 5) {
    	$data[1] = $data[1] + 1;
    }elseif($courseRate->rate > 5 and $courseRate->rate <= 8) {
    	$data[2] = $data[2] + 1;
    }elseif($courseRate->rate > 8 and $courseRate->rate <= 10) {
    	$data[3] = $data[3] + 1;
    }
    $times++;
    $rates = $rates + $courseRate->rate;
}
if ($times == 0) {
	$times = 1;
}
?>
<!DOCTYPE html>
<html style="font-family: Arvo, serif;">
<head>
	<title><? echo $course->title; ?> - Rating</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" href="<?php echo $this->url('src/app/views/images/logo2.jpg'); ?>"/>
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/bootstrap/css/bootstrap.min.css');?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.10/css/mdb.min.css" rel="stylesheet">
	
</head>
<body>
	<div class="container" style="border: 1px solid black; margin-top: 5%; margin-bottom: 5%; padding: 3%; border-radius: 5px;">
		<center>
			<? if(isset($suc)): ?>
				<div class="alert alert-success" role="alert">
				  <? echo $suc; ?>
				</div>
			<? elseif(isset($errors)): ?>
				<div class="alert alert-danger" role="alert">
				  <? echo $errors; ?>
				</div>
			<? endif; ?>
			<br/>
			<h3><? echo $course->title; ?></h3>
			<br/>
	  		<canvas id="myChart" style="max-width: 90%;"></canvas>
	  	</center>
	  	<br/>
	  		<center>
	  			<h3>Total rate : <? echo round($rates/$times, 1);?>/10</h3>
	  		</center>
	  	<br/>
	  		<? if($session->has("loggedIn")): ?>
	  			<? if($session->has("type")): ?>
	  				<? if($session->get("type") === "learner"): ?>
	  					<? if(!$hasRated AND !$thisCourseBelongsToThisTeacher AND $checkIfUserRegisterdInCourse): ?>
						  	<form method="POST" action="<? echo $this->url('postRate'); ?>" id="form">
						  		<div class="input-group mb-3">
									  <input name="rate" type="number" min="0" max="10" class="form-control" placeholder="Rate with a number between 0 and 10" aria-describedby="basic-addon2">
									  <div class="input-group-append">
									    <span class="input-group-text" id="basic-addon2"><a href="javascript:{}" onclick="document.getElementById('form').submit(); return false;">Rate</a></span>
									  </div>
								</div>
						  			<input type="hidden" name="_token" value="<? echo $token; ?>">
						  			<input type="hidden" name="course_id" value="<? echo (string)$course->_id; ?>">
						  			<input type="hidden" name="user_id" value="<? echo (string)$session->get('id'); ?>">
						  	</form>
						<? endif; ?>  	
					<? endif; ?>  	
				 <? endif; ?> 	
			<? endif; ?>  	
	  	
	</div>
</body>
<script src="<?php echo $this->url('src/app/views/assets/js/jquery.min.js');?>"></script>
    <script src="<?php echo $this->url('src/app/views/assets/bootstrap/js/bootstrap.min.js');?>"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.10/js/mdb.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>

    <script type="text/javascript">
    	var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
		type: 'bar',
		data: {
		labels: ["<= 3", "> 3 and <= 5", "> 5 and <= 8", "< 8 and >= 10"],
		datasets: [{
		label: 'Rates',
		data: [<?php echo $data[0];?>, <?php echo $data[1];?>, <?php echo $data[2];?>, <?php echo $data[3];?>],
		backgroundColor: [
		'rgba(255, 99, 132, 0.2)',
		'rgba(54, 162, 235, 0.2)',
		'rgba(255, 206, 86, 0.2)',
		'rgba(75, 192, 192, 0.2)',
		'rgba(153, 102, 255, 0.2)',
		'rgba(255, 159, 64, 0.2)'
		],
		borderColor: [
		'rgba(255,99,132,1)',
		'rgba(54, 162, 235, 1)',
		'rgba(255, 206, 86, 1)',
		'rgba(75, 192, 192, 1)',
		'rgba(153, 102, 255, 1)',
		'rgba(255, 159, 64, 1)'
		],
		borderWidth: 1
		}]
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
					beginAtZero: true
					}
				}]
			},
		}
		});
    </script>
</html>