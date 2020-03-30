<!DOCTYPE html>
<html>
<head>
	<title><? echo $data->firstname ?> <? echo $data->lastname ?> حساب </title>
	<link rel="shortcut icon" type="image/png" href="<?php echo $this->url('src/app/views/images/logo2.jpg');?>"/>
	<link rel="stylesheet" type="text/css" href="https://www.fontstatic.com/f=sky-bold" />
	<style type="text/css">
		body {
			background-color: #f3f3f3;
			font-family: 'sky-bold';
			direction: rtl;
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
		<h3>عزيزي السيد / السيدة <? echo $data->firstname ?> <? echo $data->lastname ?>,
حسابك في Dz-courses لم يتم تفعيله بعد ، أو انتهت صلاحية خطة التعلم الخاصة بك.</h3>
			<div class="danger">
				<h4>
					&larr; لتفعيل حسابك في dz-courses ، راجع خططنا <a href="<? echo $this->url('#plans'); ?>">هنا</a> ، تأكد من إرسال الأموال إلى حساب CCP (انقر <a href="<? echo $this->url('ccp'); ?>">هنا</a> للحصول على معلومات CCP).
					<br/>
					<br/>
					&larr; بعد ذلك ، قم برفع (<a href="<? echo $this->url('uploadInvoices'); ?>">هنا</a>) 3 صور لفاتورة الدفع وصورة واحدة لبطاقة الهوية الخاصة بك.
					<? if($data->activated == 0): ?>
						<br/>
						<br/>
						&larr; إذا لم يتم تفعيل حسابك خلال 168 ساعة ، فسيتم حذفه.
					<? endif; ?>	
					<br/>
					<br/>
					&larr; أي محاولة احتيالية ستقودك إلى عقوبات صارمة مع الأمن.
					<br/>
					<br/>
					&larr; إذا قمت بالدفع ، فسيتم تنشيط حسابك في غضون 24 ساعة على الأقل.<br/>
					<br/>
					<br/>
				</h4>
			</div>
			<br/>
			<br/>
		<? endif; ?>	
		<small>سُجل في : <? echo $data->created_at; ?></small><br/>
	</div>
</body>
</html>