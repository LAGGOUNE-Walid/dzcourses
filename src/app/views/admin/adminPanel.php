<!DOCTYPE html>
<html>
<head>
	<title>Admin panel</title>
</head>
<style type="text/css">
	body {
		font-family: Courier;
	}
	a {
		color:black;
	} 
</style>
<body>
		<ul>
			<li><a href="<? echo $this->url('submitedCourses'); ?>">Submited courses [<? echo $submitedCourses; ?>]</a></li>
			<li><a href="<? echo $this->url("allCourses"); ?>">All courses [<? echo $activatedCourses; ?>]</a></li>
			<li><a href="<? echo $this->url("allTeachers"); ?>">All teachers [<? echo $teachers; ?>]</a></li>
			<li><a href="<? echo $this->url("allLearners"); ?>">All learners [<? echo $learner; ?>]</a></li>
			<li><a href="<? echo $this->url("newSubmitedLearnersPayments"); ?>">new Submited learners payments [<? echo $newInvoices; ?>]</a></li>
			<li><a href="<? echo $this->url("allSubmitedLearnersPayments"); ?>">All Submited learners payments [<? echo $learnersInvoices; ?>]</a></li>
			<li><a href="<? echo $this->url("createPayment"); ?>">Today teachers to pay</a></li>
			<li><a href="<? echo $this->url("logs"); ?>">Logs</a></li>
				<form method="POST" action="<? echo $this->url("adminLogout"); ?>">
					<input type="hidden" name="_token" value="<? echo $token; ?>">
					<button type="submit">Logout</button>
				</form>
		</ul>
</body>
</html>