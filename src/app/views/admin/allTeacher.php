<!DOCTYPE html>
<html>
<head>
	<title>Admin - show all teachers</title>
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
			<td>Image</td>
			<td>CCP</td>
			<td>Key</td>
			<td>Created at</td>
			<td>Courses</td>
		</tr>
		
		<? foreach($teachers as $teacher): ?>
		<tr>	
			<td><? echo strip_tags($teacher->firstname." ".$teacher->lastname); ?></td>
			<td><? echo strip_tags($teacher->email); ?></td>
			<td><? echo strip_tags($teacher->address); ?></td>
			<td><? echo strip_tags($teacher->phone); ?></td>
			<td><? echo strip_tags($teacher->description); ?></td>
			<td><a href="<? echo $this->url($teacher->photo); ?>"><? echo $teacher->photo; ?></a></td>
			<td><? echo strip_tags($teacher->ccp); ?></td>
			<td><? echo strip_tags($teacher->key); ?></td>
			<td><? echo strip_tags($teacher->created_at); ?></td>
			<? $courses = $collection->courses->find(["user_id" => (string)$teacher->_id]); ?>
			<td>
				<? foreach($courses as $course): ?>
					- <a href="<? echo $this->url('course'); ?>/<? echo str_replace(' ', '-', $course->title); ?>"><? echo $course->title; ?></a>
				<? endforeach; ?>
			</td>
</tr>		
<? endforeach; ?>
	</table>		
</body>
