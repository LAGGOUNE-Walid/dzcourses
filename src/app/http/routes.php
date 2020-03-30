<?php
$this->add("/map:GET", function($p, $c) {
	echo nl2br("http://www.dzcourses.tech/nhttp://www.dzcourses.tech/courses/1\nhttp://www.dzcourses.tech/teacherSignup\nhttp://www.dzcourses.tech/learnerSignup");
});
$this->add("/:GET", function($params, $container) {
	$this->controller("HomeController", "home", $params, $container);
});
$this->add("/home:GET", function($params, $container) {
	$this->controller("HomeController", "home", $params, $container);
});
$this->add("/javascript:GET", function($params, $container) {
	echo "Please activate javascript !";
	exit;
});
$this->add("/changeLanguage:POST", function($params, $container) {
	$session = $container->get("Session");
	$session->destroy("lang"); 
	$session->set("lang", $container->get("Request")->get("to"));
	header("Location: ".$_SERVER["HTTP_REFERER"]);
	exit;
});
$this->add("/courses/page:GET", function($params, $container) {
	$this->controller("HomeController", "showCourses", $params, $container);
});
$this->add("/course/title:GET", function($params, $container) {
	$this->controller("HomeController", "showCourse", $params, $container);
});
$this->add("/watch/title/video:GET", function($params, $container) {
	$session = $container->get("Session");
	if((int)$params["video"] <= 2) {
		$session->set("watchFree", "yes");
		$session->set("video", (int)$params["video"]);
		$this->controller("HomeController", "watchFree", $params, $container);
		exit;
	}
	$session->set("watchFree", "null");
	$session->set("video", "null");

	$this->middleware("BEFORE", "LAuthMiddleware", $container);
	if(!$this->middleware("BEFORE", "CourseOwnerMiddleware", $container)) :
		$this->middleware("BEFORE", "ActivatedMiddleware", $container); 
		$this->middleware("BEFORE", "LearnerMiddleware", $container);
	endif;
	$this->controller("HomeController", "watch", $params, $container);
});
$this->add("/coursesapi:GET", function($params, $container) {
	$this->controller("HomeController", "showCoursesApi", $params, $container);
});
$this->add("/terms:GET", function($params, $container) {
	$this->controller("HomeController", "terms", $params, $container);
});
$this->add("/p/id:GET", function($params, $container) { 	
	$this->controller("UserController", "showProfile", $params, $container);
});
$this->add("/message/id:GET", function($params, $container) { 	
	$this->controller("UserController", "sendMessage", $params, $container);
});

$this->add("/teacherSignup:GET", function($params, $container) {
	$this->middleware("BEFORE", "NotAuthMiddleware", $container);
	$this->controller("UserController", "teacherSignup", $params, $container);
});
$this->add("/postTeacherSignup:POST", function($params, $container) {
	$this->middleware("BEFORE", "NotAuthMiddleware", $container);
	$this->middleware("BEFORE", "VerifyTokenMiddleware", $container); 	
	$this->controller("UserController", "postTeacherSignup", $params, $container);
});
$this->add("/teacherLogin:GET", function($params, $container) {
	$this->middleware("BEFORE", "NotAuthMiddleware", $container); 
	$this->controller("UserController", "teacherLogin", $params, $container);
});
$this->add("/postTeacherLogin:POST", function($params, $container) {
	$this->middleware("BEFORE", "NotAuthMiddleware", $container); 
	$this->middleware("BEFORE", "VerifyTokenMiddleware", $container); 
	$this->controller("UserController", "postTeacherLogin", $params, $container);
});
$this->add("/tPanel:GET", function($params, $container) {
	$this->middleware("BEFORE", "AuthMiddleware", $container); 	
	$this->middleware("BEFORE", "TeacherMiddleware", $container); 	 	
	$this->controller("UserController", "teacherPanel", $params, $container);
});
$this->add("/tSettings:GET", function($params, $container) {
	$this->middleware("BEFORE", "AuthMiddleware", $container); 	
	$this->middleware("BEFORE", "TeacherMiddleware", $container); 	 	
	$this->controller("UserController", "teacherSettings", $params, $container);
});
$this->add("/chatroom:GET", function($params, $container) {
	$this->middleware("BEFORE", "AuthMiddleware", $container); 	
	$this->middleware("BEFORE", "TeacherMiddleware", $container); 	 	
	$this->controller("UserController", "chatRoom", $params, $container);
});
$this->add("/postCreateChatRoom:POST", function($params, $container) {
	$this->middleware("BEFORE", "AuthMiddleware", $container); 	
	$this->middleware("BEFORE", "TeacherMiddleware", $container);
	$this->middleware("BEFORE", "VerifyTokenMiddleware", $container); 	 	 	
	$this->controller("UserController", "postCreateChatRoom", $params, $container);
});
$this->add("/postTsettings:POST", function($params, $container) {
	$this->middleware("BEFORE", "AuthMiddleware", $container); 	
	$this->middleware("BEFORE", "TeacherMiddleware", $container); 	
	$this->middleware("BEFORE", "VerifyTokenMiddleware", $container); 	 	
	$this->controller("UserController", "postTeacherSettings", $params, $container);
});
$this->add("/tAccount:GET", function($params, $container) {
	$this->middleware("BEFORE", "AuthMiddleware", $container); 	
	$this->middleware("BEFORE", "TeacherMiddleware", $container); 	 	
	$this->controller("UserController", "teacherAccount", $params, $container);
});
$this->add("/messages/page:GET", function($params, $container) {
	$this->middleware("BEFORE", "AuthMiddleware", $container); 	
	$this->middleware("BEFORE", "TeacherMiddleware", $container); 	 	
	$this->controller("UserController", "messages", $params, $container);
});
$this->add("/notifications/page:GET", function($params, $container) {
	$this->middleware("BEFORE", "AuthMiddleware", $container); 	
	$this->middleware("BEFORE", "TeacherMiddleware", $container); 	 	
	$this->controller("UserController", "notifications", $params, $container);
});
$this->add("/addCourse:GET", function($params, $container) {
	$this->middleware("BEFORE", "AuthMiddleware", $container); 	
	$this->middleware("BEFORE", "TeacherMiddleware", $container); 	 	
	$this->controller("UserController", "addCourse", $params, $container);
});
$this->add("/postCourse:POST", function($params, $container) {
	$this->middleware("BEFORE", "AuthMiddleware", $container); 	
	$this->middleware("BEFORE", "TeacherMiddleware", $container); 	
	#$this->middleware("BEFORE", "VerifyTokenMiddleware", $container); 	 	 	
	$this->controller("UserController", "postCourse", $params, $container);
});
$this->add("/myCourses:GET", function($params, $container) {
	$this->middleware("BEFORE", "AuthMiddleware", $container); 	
	$this->middleware("BEFORE", "TeacherMiddleware", $container); 	 
	$this->controller("UserController", "showTeacherCourses", $params, $container);
});
$this->add("/invoiceImage/name:GET", function($params, $container) {
	$this->middleware("BEFORE", "AuthMiddleware", $container); 	
	$this->middleware("BEFORE", "TeacherMiddleware", $container); 	 
	$this->controller("UserController", "getInvoiceImage", $params, $container);
});
$this->add("/share:GET", function($params, $container) {
	$this->middleware("BEFORE", "AuthMiddleware", $container); 	
	$this->middleware("BEFORE", "TeacherMiddleware", $container); 	
	$this->middleware("BEFORE", "VerifyTokenMiddleware", $container); 	 	 	
	$this->controller("UserController", "share", $params, $container);
});
$this->add("/postFile:POST", function($params, $container) {
	$this->middleware("BEFORE", "AuthMiddleware", $container); 	
	$this->middleware("BEFORE", "TeacherMiddleware", $container); 	
	$this->middleware("BEFORE", "VerifyTokenMiddleware", $container); 	 	 	
	$this->controller("UserController", "postFile", $params, $container);
});
$this->add("/deleteFile:POST", function($params, $container) {
	$this->middleware("BEFORE", "AuthMiddleware", $container); 	
	$this->middleware("BEFORE", "TeacherMiddleware", $container); 	
	$this->middleware("BEFORE", "VerifyTokenMiddleware", $container); 	 	 	
	$this->controller("UserController", "deleteFile", $params, $container);
});
$this->add("/file/id:GET", function($params, $container) { 	
	$this->controller("HomeController", "getFile", $params, $container);
});
$this->add("/pfile/id:POST", function($params, $container) { 	
	$this->controller("HomeController", "fetchFile", $params, $container);
});
$this->add("/logout:POST", function($params, $container) {
	$this->middleware("BEFORE", "AuthMiddleware", $container); 	
	#$this->middleware("BEFORE", "VerifyTokenMiddleware", $container);  	
	$this->controller("UserController", "logout", $params, $container);
});
/**
$this->add("/buyOnline:GET", function($params, $container) {
	$this->middleware("BEFORE", "AuthMiddleware", $container); 	
	$this->middleware("BEFORE", "TeacherMiddleware", $container); 	
	$this->controller("UserController", "buyOnline", $params, $container);
});
$this->add("/postBuyPlan:POST", function($params, $container) {
	$this->middleware("BEFORE", "AuthMiddleware", $container); 	
	$this->middleware("BEFORE", "TeacherMiddleware", $container);
	$this->middleware("BEFORE", "VerifyTokenMiddleware", $container); 	 
	$this->controller("UserController", "postBuyPlan", $params, $container);
});
$this->add("/postBuyCustomPlan:POST", function($params, $container) {
	$this->middleware("BEFORE", "AuthMiddleware", $container); 	
	$this->middleware("BEFORE", "TeacherMiddleware", $container);
	$this->middleware("BEFORE", "VerifyTokenMiddleware", $container); 	 
	$this->controller("UserController", "postBuyCustomPlan", $params, $container);
});
**/
$this->add("/learnerSignup:GET", function($params, $container) {
	$this->middleware("BEFORE", "NotAuthMiddleware", $container);
	$this->controller("UserController", "learnerSignup", $params, $container);
});
$this->add("/postLearnerSignup:POST", function($params, $container) {
	$this->middleware("BEFORE", "NotAuthMiddleware", $container);
	$this->middleware("BEFORE", "VerifyTokenMiddleware", $container); 	
	$this->controller("UserController", "postLearnerSignup", $params, $container);
});
$this->add("/learnerLogin:GET", function($params, $container) {
	$this->middleware("BEFORE", "NotAuthMiddleware", $container);
	$this->controller("UserController", "learnerLogin", $params, $container);
});
$this->add("/postLearnerLogin:POST", function($params, $container) {
	$this->middleware("BEFORE", "NotAuthMiddleware", $container); 
	$this->middleware("BEFORE", "VerifyTokenMiddleware", $container); 
	$this->controller("UserController", "postLearnerLogin", $params, $container);
});
$this->add("/lPanel:GET", function($params, $container) {
	$this->middleware("BEFORE", "LAuthMiddleware", $container); 	
	$this->middleware("BEFORE", "ActivatedMiddleware", $container); 	
	$this->middleware("BEFORE", "LearnerMiddleware", $container); 	 	
	$this->controller("UserController", "learnerPanel", $params, $container);
});
$this->add("/lAccount:GET", function($params, $container) {
	$this->middleware("BEFORE", "LAuthMiddleware", $container); 	
	$this->middleware("BEFORE", "ActivatedMiddleware", $container); 
	$this->middleware("BEFORE", "LearnerMiddleware", $container); 	 	
	$this->controller("UserController", "learnerAccount", $params, $container);
});
$this->add("/lSettings:GET", function($params, $container) {
	$this->middleware("BEFORE", "LAuthMiddleware", $container); 	
	$this->middleware("BEFORE", "ActivatedMiddleware", $container); 
	$this->middleware("BEFORE", "LearnerMiddleware", $container); 	 	
	$this->controller("UserController", "learnerSettings", $params, $container);
});
$this->add("/postLsettings:POST", function($params, $container) {
	$this->middleware("BEFORE", "LAuthMiddleware", $container);
	$this->middleware("BEFORE", "ActivatedMiddleware", $container);  	
	$this->middleware("BEFORE", "LearnerMiddleware", $container);
	$this->middleware("BEFORE", "VerifyTokenMiddleware", $container); 	 	 	
	$this->controller("UserController", "postLearnerSettings", $params, $container);
});
$this->add("/lNotifications/page:GET", function($params, $container) {
	$this->middleware("BEFORE", "LAuthMiddleware", $container);
	$this->middleware("BEFORE", "ActivatedMiddleware", $container);  	
	$this->middleware("BEFORE", "LearnerMiddleware", $container); 	 	
	$this->controller("UserController", "notifications", $params, $container);
});
$this->add("/lmessages/page:GET", function($params, $container) {
	$this->middleware("BEFORE", "LAuthMiddleware", $container);
	$this->middleware("BEFORE", "ActivatedMiddleware", $container);  	
	$this->middleware("BEFORE", "LearnerMiddleware", $container); 	 	
	$this->controller("UserController", "messages", $params, $container);
});
$this->add("/lcourses:GET", function($params, $container) {
	$this->middleware("BEFORE", "LAuthMiddleware", $container);
	$this->middleware("BEFORE", "ActivatedMiddleware", $container);  	
	$this->middleware("BEFORE", "LearnerMiddleware", $container); 	 	
	$this->controller("UserController", "courses", $params, $container);
});
$this->add("/cobone:GET", function($params, $container) {
	$this->middleware("BEFORE", "LAuthMiddleware", $container);
	$this->middleware("BEFORE", "ActivatedMiddleware", $container);  	
	$this->middleware("BEFORE", "LearnerMiddleware", $container); 	 	
	$this->controller("HomeController", "cobone", $params, $container);
});
$this->add("/postCobone:POST", function($params, $container) {
	$this->middleware("BEFORE", "LAuthMiddleware", $container);
	$this->middleware("BEFORE", "ActivatedMiddleware", $container);  	
	$this->middleware("BEFORE", "LearnerMiddleware", $container); 	 	
	$this->controller("HomeController", "postCobone", $params, $container);
});
$this->add("/uploadInvoices:GET", function($params, $container) {
	$this->middleware("BEFORE", "LAuthMiddleware", $container);
	$this->middleware("BEFORE", "UploadInvoiceMiddleware", $container);  	
	$this->middleware("BEFORE", "LearnerMiddleware", $container); 	 	
	$this->controller("UserController", "uploadInvoices", $params, $container);
});
$this->add("/postUploadedInvoices:POST", function($params, $container) {
	$this->middleware("BEFORE", "LAuthMiddleware", $container);
	$this->middleware("BEFORE", "UploadInvoiceMiddleware", $container);  	
	$this->middleware("BEFORE", "LearnerMiddleware", $container); 	 	
	$this->controller("UserController", "postUploadedInvoices", $params, $container);
});
$this->add("/rate/id:GET", function($params, $container) {
	$this->controller("HomeController", "rate", $params, $container);
});
$this->add("/postRate:POST", function($params, $container) {
	$this->middleware("BEFORE", "VerifyTokenMiddleware", $container); 	
	$this->middleware("BEFORE", "LearnerMiddleware", $container); 	 	
	$this->middleware("BEFORE", "LAuthMiddleware", $container);
	$this->middleware("BEFORE", "ActivatedMiddleware", $container);  	
	$this->controller("HomeController", "postRate", $params, $container);
});
$this->add("/getVideo/folder/video:GET", function($params, $container) {
	$session = $container->get("Session");
	if (!is_null($session->get("watchFree")) AND $session->get("watchFree") === "yes" AND !is_null($session->get("video")) AND $session->get("video") <= 2) {
		$this->controller("HomeController", "displayVideo", $params, $container);
		exit;
	}
	if (is_null($session->get("watchFree"))) {
		$session->destroy("watchFree");
		$session->destroy("video");
	}
	if($session->get("type") !== "admin"):
		$this->middleware("BEFORE", "LAuthMiddleware", $container);
		if(!$this->middleware("BEFORE", "CourseOwnerMiddleware", $container)) :
			$this->middleware("BEFORE", "ActivatedMiddleware", $container); 
			$this->middleware("BEFORE", "LearnerMiddleware", $container);
		endif;
	endif;	 
	$this->controller("HomeController", "displayVideo", $params, $container);
});
$this->add("/videoFetcher/course/videoTitle/id:GET", function($params, $container) {
	$this->middleware("BEFORE", "LAuthMiddleware", $container);
	if(!$this->middleware("BEFORE", "CourseOwnerMiddleware", $container)) :
		$this->middleware("BEFORE", "ActivatedMiddleware", $container); 
		$this->middleware("BEFORE", "LearnerMiddleware", $container);
	endif;
	$this->controller("HomeController", "videoFetcher", $params, $container);
});
$this->add("/postComment:POST", function($params, $container) {
	$this->middleware("BEFORE", "LAuthMiddleware", $container);
	if(!$this->middleware("BEFORE", "CourseOwnerMiddleware", $container)) :
		$this->middleware("BEFORE", "ActivatedMiddleware", $container); 
		$this->middleware("BEFORE", "LearnerMiddleware", $container);
	endif;
	$this->controller("HomeController", "postComment", $params, $container);
});
$this->add("/generateCertificate:POST", function($params, $container) {
	$this->middleware("BEFORE", "LearnerMiddleware", $container); 	 	
	$this->middleware("BEFORE", "LAuthMiddleware", $container);
	$this->middleware("BEFORE", "ActivatedMiddleware", $container);  	
	$this->controller("HomeController", "generateCertificate", $params, $container);
});
$this->add("/certificates/id:GET", function($params, $container) {
	$this->controller("HomeController", "getCertificate", $params, $container);
});
$this->add("/chat/id:GET", function($params, $container) {
	$this->middleware("BEFORE", "ChatRoomMiddleware", $container);  
	$this->controller("HomeController", "showChatRoom", $params, $container);
});

$this->add("/adminLogin:GET", function($params, $container) {
	$this->controller("AdminController", "login", $params, $container);
});
$this->add("/postAdminLogin:POST", function($params, $container) {
	$this->controller("AdminController", "postAdminLogin", $params, $container);
});
$this->add("/adminPanel:GET", function($params, $container) {
	$this->middleware("BEFORE", "AdminMiddleware", $container);
	$this->controller("AdminController", "panel", $params, $container);  
});
$this->add("/submitedCourses:GET", function($params, $container) {
	$this->middleware("BEFORE", "AdminMiddleware", $container);
	$this->controller("AdminController", "getSubmitedCourses", $params, $container);  
});
$this->add("/rejectCourse:POST", function($params, $container) {
	$this->middleware("BEFORE", "VerifyTokenMiddleware", $container);
	$this->middleware("BEFORE", "AdminMiddleware", $container);
	$this->controller("AdminController", "rejectCourse", $params, $container);  
});
$this->add("/acceptCourse:POST", function($params, $container) {
	$this->middleware("BEFORE", "VerifyTokenMiddleware", $container);
	$this->middleware("BEFORE", "AdminMiddleware", $container);
	$this->controller("AdminController", "acceptCourse", $params, $container);  
});
$this->add("/allCourses:GET", function($params, $container) {
	$this->middleware("BEFORE", "AdminMiddleware", $container);
	$this->controller("AdminController", "allCourses", $params, $container);  
});
$this->add("/deleteCourse:POST", function($params, $container) {
	$this->middleware("BEFORE", "VerifyTokenMiddleware", $container);
	$this->middleware("BEFORE", "AdminMiddleware", $container);
	$this->controller("AdminController", "deleteCourse", $params, $container);  
});
$this->add("/allTeachers:GET", function($params, $container) {
	$this->middleware("BEFORE", "AdminMiddleware", $container);
	$this->controller("AdminController", "allTeachers", $params, $container);  
});
$this->add("/allLearners:GET", function($params, $container) {
	$this->middleware("BEFORE", "AdminMiddleware", $container);
	$this->controller("AdminController", "allLearners", $params, $container);  
});
$this->add("/newSubmitedLearnersPayments:GET", function($params, $container) {
	$this->middleware("BEFORE", "AdminMiddleware", $container);
	$this->controller("AdminController", "newSubmitedLearnersPayments", $params, $container);  
});
$this->add("/acceptLearnerInvoice:POST", function($params, $container) {
	$this->middleware("BEFORE", "AdminMiddleware", $container);
	$this->middleware("BEFORE", "VerifyTokenMiddleware", $container);
	$this->controller("AdminController", "acceptLearnerInvoice", $params, $container);  
});
$this->add("/getImage/imageName:GET", function($params, $container) {
	$this->controller("HomeController", "getImage", $params, $container); 
});
$this->add("/allSubmitedLearnersPayments:GET", function($params, $container) {
	$this->middleware("BEFORE", "AdminMiddleware", $container);
	$this->controller("AdminController", "allSubmitedLearnersPayments", $params, $container);  
});
$this->add("/createPayment:GET", function($params, $container) {
	$this->middleware("BEFORE", "AdminMiddleware", $container);
	$this->controller("AdminController", "createPayment", $params, $container);  
});
$this->add("/postCreateInvoice:POST", function($params, $container) {
	$this->middleware("BEFORE", "VerifyTokenMiddleware", $container);
	$this->middleware("BEFORE", "AdminMiddleware", $container);
	$this->controller("AdminController", "postCreateInvoice", $params, $container);  
});
$this->add("/logs:GET", function($params, $container) {
	$this->middleware("BEFORE", "VerifyTokenMiddleware", $container);
	$this->middleware("BEFORE", "AdminMiddleware", $container);
	$this->controller("AdminController", "showLogs", $params, $container);  
});
$this->add("/adminLogout:POST", function($params, $container) {
	$this->middleware("BEFORE", "AdminMiddleware", $container);
	$this->controller("AdminController", "adminLogout", $params, $container);  
});

$this->run();
