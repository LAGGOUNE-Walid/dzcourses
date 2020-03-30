<!DOCTYPE html>
<html>
<head>
	<title><? echo $data->firstname ?> <? echo $data->lastname ?> Account </title>
	<link rel="shortcut icon" type="image/png" href="<?php echo $this->url('src/app/views/images/logo2.jpg');?>"/>
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
			margin-bottom: 5%;
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
		<? if($type === "plan"): ?>
			<small>Your teaching plan allows you to add only 
			<? echo $data->plan; ?> 
			<? if($data->plan == 1) { echo "course"; }else {echo "courses";} ?>
			per month, and we count that you have  <? echo $data->plan; ?>
			<? if($data->plan == 1) { echo "course"; }else {echo "courses";} ?>
			in this month .</small>
			<br/>
			<small>Click <a href="">here</a> to purchase a plan .</small>
			<br/>
		<? else: ?>
		<h4>Dear Mr/Ms <? echo $data->firstname ?> <? echo $data->lastname ?> ,<br/> your Dz-courses account is not activated yet, or your learning plan expired.</h4> 
			<div class="danger">
				<small>
					&rarr; In order to activate your dz-courses account , see our plans <a href="<? echo $this->url('#plans'); ?>">here</a>,  make sure you send money to our CCP account(click <a href="<? echo $this->url('ccp'); ?>">here</a> for our CCP informations).
					<br/>
					<br/>
					&rarr; After that, upload (<a href="<? echo $this->url('uploadInvoices'); ?>">here</a>) 3 photos of the payment invoice and 1 photo of your identity card.
					<? if($data->activated == 0): ?>
						<br/>
						<br/>
						&rarr; If your account is not activated in 168h, it will will be deleted .
					<? endif; ?>	
					<br/>
					<br/>
					&rarr; Any fraudulent attempt will lead you to severe penalties with security 
					<br/>
					<br/>
					&rarr; If you do the payment , your account will be activated at least in 24h .<br/>
					<br/>
					<br/>
				</small>
			</div>
			<br/>
			<br/>
		<? endif; ?>	
		<small>Registred at : <? echo $data->created_at; ?></small><br/>
	</div>
</body>
</html>