<!DOCTYPE html>
<html>
<head>
	<title>Admin - show all courses</title>
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
	 table, th, td {
  border: 1px solid black;
}
</style>
<body>
 <table style="width:100%">
  <tr>
    <td>User</td>
    <td>Title</td>
    <td>Descriptin</td>
    <td>skillsNeeded</td>
    <td>skillsToGain</td>
    <td>videosNumber</td>
    <td>tags</td>
    <td>category</td>
    <td>cover</td>
    <td>created_at</td>
    <td>courseTime</td>
    <td>filesLink</td>
    <td>Videos</td>
    <td>Rate</td>
    <td>Delete</td>
  </tr>
  <? foreach($courses as $course): ?>
	  <tr>
	  	<? $user = $collection->users->findOne(["_id" => new MongoDB\BSON\ObjectId($course->user_id)]); ?>
	    <td><a href="<? echo $this->url('p'); ?>/<? echo $course->user_id; ?>"><? echo $user->firstname." ".$user->lastname; ?></a></td>
	    <td><a href="<? echo $this->url('course'); ?>/<? echo str_replace(' ', '-', $course->title); ?>"><? echo strip_tags($course->title); ?></a></td>
	    <td><? echo strip_tags($course->description); ?></td>
	    <td><? echo strip_tags($course->skillsNeeded); ?></td>
	    <td><? echo strip_tags($course->skillsToGain); ?></td>
	    <td><? echo strip_tags($course->videosNumber); ?></td>
	    <td><? echo strip_tags($course->tags); ?></td>
	    <td><? echo strip_tags($course->category); ?></td>
	    <td><a href="<? echo $this->url($course->cover); ?>">Cover</a></td>
	    <td><? echo strip_tags($course->created_at); ?></td>
	    <td><? echo strip_tags($course->courseTime)/60; ?></td>
	    <td><a href="<? echo strip_tags($course->filesLink); ?>">Files</a></td>
	    <?php 
			$videos = $collection->coursesVideos->find(["course_id" => (string)$course->_id]);
		?>
	    <td><?  foreach($videos as $video): ?>
						<a href="<? echo $this->url('getVideo/'.$video->md5); ?>"><? echo $video->origin; ?></a><hr/>
					<? endforeach; ?></td>
	    <td><? echo $CourseController->getCourseRate((string)$course->_id, $collection); ?>/10 <a href="<? echo $this->url('rate').'/'.(string)$course->_id; ?>">See more details</a></td>
	    <td>
		    <form method="POST" action="<? echo $this->url('deleteCourse'); ?>">
						<input type="hidden" name="_token" value="<? echo $token; ?>">
						<input type="hidden" name="id" value="<? echo(string)$course->_id; ?>">
						<input type="hidden" name="userId" value="<? echo $course->user_id; ?>">
						<input type="hidden" name="courseTitle" value="<? echo $course->title; ?>">
						
						
		    			<textarea name="reason" style="width: 300%; height: 500px;" placeholder="Reason to deleted"></textarea>
						<br/>
						<br/><button type="submit">Delete</button>
			</form>
		</td>
	  </tr>
	 <? endforeach; ?>	
</table> 
</body>
</html>