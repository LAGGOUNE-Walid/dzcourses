<!DOCTYPE html>
<html>
<head>
	<title>Admin - Today to pay</title>
</head>
<style type="text/css">
		body {
		font-family: Courier;
	}
	ul {
		background-color: #f3f3f3;
		padding: 1%; 
		overflow-x:hidden;
		white-space:nowrap; 
		height: 1em;
		width: 80%;
	} 
	li { 
		display:inline; 
	}
	a {
		color:black;
	}
	#body {
		margin-left: 10%;
		margin-right: 10%;
	}
	#course {
		border: 1px solid black;
		padding: 2%;
	} 
</style>
<body>
	<? $date = Carbon\Carbon::now(); ?>
	<?php foreach ($allUsers as $user): ?>
		<?php if ($date->diffInDays($user->created_at) > 31 AND !$user->paid): ?>
			<div id="course">
				<p>- <? echo strip_tags($user->money); $sum = $user->money; ?>DA</p>
				<p>- <strong><? echo strip_tags($user->created_at); ?></strong></p>
				<? $user_id = ($user->user_id); ?>
				<? $userMoneyId =  (string)$user->_id; ?>
				<? $user = $collection->users->findOne(["_id" => new MongoDB\BSON\ObjectId($user_id)]); ?>
				<p>- <a href="<? echo $this->url('p').'/'.$user_id; ?>"><? echo $user->firstname." ".$user->lastname; ?></a></p>
				<p>- <? echo $user->email; ?></p>
				<p>- <? echo $user->phone; ?></p>
				<p>- <? echo $user->ccp; ?> key : 57</p>
				<p>- <? echo $user->address; ?></p>
				<form method="post" action="<? echo $this->url('postCreateInvoice'); ?>" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="<? echo $token; ?>">
					<input type="file" name="image1">
					<input type="file" name="image2">
					<input type="file" name="image3">
					<input type="hidden" name="to" value="<? echo $user_id; ?>">
					<input type="hidden" name="id" value="<? echo $userMoneyId; ?>">
					<input type="hidden" name="sum" value="<? echo $sum; ?>">
					<button type="submit">Paid</button>
				</form>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
	<hr/>
	<? foreach($todayUsers as $user): ?>
		<? if(!$user->paid): ?>
			<div id="course">
				<p>- <? echo strip_tags($user->money); ?>DA</p>
				<p>- <strong><? echo strip_tags($user->created_at); $sum = $user->money; ?></strong></p>
				<? $user_id = ($user->user_id); ?>
				<? $userMoneyId = (string) $user->_id; ?>
				<? $user = $collection->users->findOne(["_id" => new MongoDB\BSON\ObjectId($user_id)]); ?>
				<p>- <a href="<? echo $this->url('p').'/'.$user_id; ?>"><? echo $user->firstname." ".$user->lastname; ?></a></p>
				<p>- <? echo $user->email; ?></p>
				<p>- <? echo $user->phone; ?></p>
				<p>- <? echo $user->ccp; ?> key : 57</p>
				<p>- <? echo $user->address; ?></p>
				<form method="post" action="<? echo $this->url('postCreateInvoice'); ?>" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="<? echo $token; ?>">
					<input type="file" name="image1">
					<input type="file" name="image2">
					<input type="file" name="image3">
					<input type="hidden" name="to" value="<? echo $user_id; ?>">
					<input type="hidden" name="id" value="<? echo $userMoneyId; ?>">
					<input type="hidden" name="sum" value="<? echo $sum; ?>">
					<button type="submit">Paid</button>
				</form>
			</div>
		<? endif; ?>
		<br/>
	<? endforeach; ?>			
</body>
</html>