<!DOCTYPE html>
<html>
<head>
	<title>Admin - show all learners</title>
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
	table, td, th {
		border: 1px solid black;
	}
</style>
<body>
	<table style="width: 100%;">
		<tr>
			<td>Name</td>
			<td>Email</td>
			<td>Address</td>
			<td>Phone</td>
			<td>Description</td>
			<td>Activated</td>
			<td>Plan (Guard)</td>
			<td>Image</td>
			<td>Created at</td>
			<td>Courses taken</td>
		</tr>
		<? foreach($learners as $learner): ?>
		<tr>
			<td>- <? echo strip_tags($learner->firstname." ".$learner->lastname); ?></td>
			<td>- <? echo strip_tags($learner->email); ?></td>
			<td>- <? echo strip_tags($learner->address); ?></td>
			<td>- <? echo strip_tags($learner->phone); ?></td>
			<td>- <? echo strip_tags($learner->description); ?></td>
			<td>- Activated : <? echo strip_tags($learner->activated); ?></td>
			<td>- Guard : <? echo strip_tags($learner->guard); ?></td>
			<td>- <a href="<? echo $this->url($learner->photo); ?>">Image</a></td>
			<td>- Created at : <? echo strip_tags($learner->created_at); ?></td>
			<td>- Courses taken : 
			<?php
			$registredUsersInCourses = $collection->registredUsersInCourses->find(["user_id" => (string)$learner->_id], ['projection' => ['course_id' => 1]]);
			if (!$registredUsersInCourses->isDead()) {
				foreach ($registredUsersInCourses as $registredUsersInCourse) {
					$course = $collection->courses->findOne(["_id" => new MongoDB\BSON\ObjectId($registredUsersInCourse->course_id)]);
					if (is_null($course)) {
						echo "0</td>";
					}else {
						?>
						 <a href="<? echo $this->url('course'); ?>/<? echo str_replace(' ', '-', $course->title); ?>"><? echo $course->title; ?></a><br/><
						<?
					}
				}
			}else {
				echo "0";
			}
			?>
			</td>
			</tr>
	<? endforeach; ?>	
	</table>		
</body>
</html>