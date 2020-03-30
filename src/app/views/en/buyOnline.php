<!DOCTYPE html>
<html>
<head>
	<title>Dz-courses</title>
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
			  	Purchase a plan : 
			  </div>
		  	<div class="card-body">
		  	<? if(isset($err)): ?>
		  	<div class="alert alert-danger" role="alert">
			 	<strong><? echo $err; ?></strong>
			</div>
		  <? endif; ?>
		  	<div class="alert alert-warning" role="alert">
			 	<strong>Read this carefully : </strong>
			 	<br/>
			 	<small>1 - This feature allow you to purchase a dz-courses teacher plan from your home.</small>
			 	<br/>
			 	<small>2- In the end of the month , you will not receive your profits from your courses. First you must send the required amount of money to this CCP account : 44545 . And follow this <a href="">steps</a> </small>
			 	<br/>
			 	<small>3- In conclusion, this feature allows you to buy a plan from your home, and add courses. but without receiving profits until you send the required money to our CCP account: 454554</small>
			</div>
				<form method="POST" action="<? echo $this->url('postBuyPlan'); ?>">
					<input type="hidden" name="_token" value="<? echo $token; ?>">
					<div class="input-group">
				 	 	<select name="plan" class="custom-select" id="inputGroupSelect04" aria-label="Example select with button addon">
				    		<option selected value="1">500Da = 1 cours per month</option>
				    		<option value="2">1000Da = 2 courses per month</option>
				    		<option value="3">1500Da = 3 courses per month</option>
				  		</select>
				  		<div class="input-group-append">
				    		<button class="btn btn-outline-secondary" type="submit">Activate your account</button>
				  		</div>
					</div>
				</form>	
				<br/>
					<strong>Custom plans starts from 4 courses per month to 10 , and there is some reductions!</strong>
					<form method="POST" action="<? echo $this->url('postBuyCustomPlan'); ?>">
					<input type="hidden" name="_token" value="<? echo $token; ?>">
				  		<div class="input-group mb-3">
						  <input name="cplan" id="custom" type="text" class="form-control" placeholder="Custom plan : Enter number of courses " aria-label="Custom plan" aria-describedby="button-addon2">
						  <div class="input-group-append">
						    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Activate with this plan</button>
						  </div>
						</div>
					</form>	
					<small id="total"></small>
			  </div>
			  <script type="text/javascript">
			  	document.getElementById("custom").oninput = function() {
			  		if (document.getElementById("custom").value >= 4 && document.getElementById("custom").value <= 10) {
			  			var S = (document.getElementById("custom").value*5*100);
			  			var P = ((document.getElementById("custom").value-3)*100)
			  			var total = S-P;
			  			document.getElementById("total").innerHTML = "Total : "+total+"DA";
			  		}
			  	};
			  </script>
		</div>
		<br/>
	</div>
</body>
</html>