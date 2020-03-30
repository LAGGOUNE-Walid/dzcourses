<!DOCTYPE html>
<html >
<head prefix="og: http://ogp.me/ns#">
    <meta charset="utf-8">
    <meta name =”robots” content="nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dz-courses <? echo $course->title; ?></title>
    <link rel="shortcut icon" type="image/png" href="../src/app/views/images/logo2.jpg"/>
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/bootstrap/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arvo">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Article-List.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Footer-Dark.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/ml-video-1.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/ml-video.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Navigation-Clean.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Paralax-Hero-Banner-1.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Paralax-Hero-Banner.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/styles.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Video-Responsive.css');?>">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="viewport" content="width=device-width" />
     <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="viewport" content="width=device-width" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="google-site-verification" content="YFEV7wY7tisoM8UG6JIghdFWlUbvps3oM5fWiDxiaY0" />
    <meta name="description" content="<? echo  $course->description; ?> | Algerian online eLearning and money making platform, Do you have a skill or a knowledge and you want to teach it and earn money ? Dz-courses is your choice. You want to learn something new to improve your skills ? learn anything anywhere from your computer ? just click sign up . "/>
    <meta name="keywords" content="<? echo $course->tags; ?>, DZcourses,dzcourses,dz courses,algeria, algerian,online,online learning,make money,make money online,teaching,courses,algerian courses,الجزائر,دورات تعليمية,دورات تعليمية جزائرية,ربح لمال في الجزائر,تعليم,تعلم"/>
    <meta property="og:title" content="<? echo $course->title; ?>" />
    <meta property="og:description" content="<? echo $course->description; ?>" />
    <meta property="og:type" content="Website" />
    <meta property="og:url" content="<? echo $this->url('course'); ?>/<? echo str_replace(' ', '-', $course->title); ?>" />
    <meta property="og:image" content="<?php echo $this->url($course->cover);  ?>" />

</head>

<body style="font-family: Arvo, serif;">
    <div>
<nav class="navbar navbar-light navbar-expand-md fixed-top navigation-clean">
            <div class="container-fluid"><a class="navbar-brand" href="<? echo $this->url(''); ?>">Dz courses<img src="<?php echo $this->url('src/app/views/assets/img/logo2.jpg');?>" style="width: 77px;">&nbsp;</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div
                    class="collapse navbar-collapse" id="navcol-1" style="opacity: 0.54;font-family: Arvo, serif;">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item" role="presentation"><a class="nav-link" href="<? echo $this->url(''); ?>">Homepage <i class="fas fa-home"></i></a></li>
                        <? if(!$container->get("Session")->has("loggedIn")): ?>
                            <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Join <i class="fas fa-user-plus"></i></a>
                                <div class="dropdown-menu dropdown-menu-left" role="menu"><a class="dropdown-item" role="presentation" href="<? echo $this->url('teacherSignup'); ?>">Join as teacher</a>
                                    <div class="dropdown-divider" role="presentation"></div><a class="dropdown-item" role="presentation" href="<? echo $this->url('learnerSignup'); ?>">Join as learner</a></div>
                            </li>
                            <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Login <i class="fas fa-sign-in-alt"></i></a>
                                <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="<? echo $this->url('teacherLogin'); ?>">Login as teacher</a>
                                    <div class="dropdown-divider" role="presentation"></div><a class="dropdown-item" role="presentation" href="<? echo $this->url('learnerLogin'); ?>">Login as learner</a></div>
                            </li>
                        <? else: ?>
                            <? if($container->get("Session")->get("type") == "teacher"): ?>
                                <li class="nav-item" role="presentation"><a class="nav-link" href="<? echo $this->url('tPanel'); ?>">Panel <i class="fas fa-cogs"></i></a></li>
                            <? elseif($container->get("Session")->get("type") == "learner"): ?>     
                                 <li class="nav-item" role="presentation"><a class="nav-link" href="<? echo $this->url('lPanel'); ?>">Panel <i class="fas fa-cogs"></i></a></li>
                            <? endif; ?>     
                    <? endif; ?>
                        <li class="nav-item" role="presentation"><a class="nav-link" href="<? echo $this->url('courses/1'); ?>">Browse courses <i class="fas fa-video"></i></a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" href="#footer">Contact <i class="fas fa-envelope"></i></a></li>
                        <li class="nav-item" role="presentation">
                          <? if($container->get("Session")->get("lang") == "eng"): ?>
                            <form method="POST" action="<? echo $this->url("changeLanguage"); ?>">
                                <input type="hidden" name="to" value="ar">
                                <a class="nav-link" href="#" onclick="this.parentNode.submit();">العربية</a>
                            </form>
                          <? else: ?>
                            <form method="POST" action="<? echo $this->url("changeLanguage"); ?>">
                              <input type="hidden" name="to" value="eng">
                              <a class="nav-link" href="#" onclick="this.parentNode.submit();">English</a>
                              </form>
                          <? endif; ?>
                        </li>
                    </ul>
            </div>
    </div>
    </nav>
    </div>
    <div id="header" style="padding-top: 10%; margin-top: 20%;">
        <h1 class="display-4 text-center" style="padding-top: 10%;opacity: 0.50;"><? echo strip_tags($course->title); ?></h1>
    </div>
    <div style="padding-top: 7%;margin-right: 5%;margin-left: 5%;">
        <img style="width: 100%;" src="../<?php echo $course->cover;  ?>" class="img-fluid" alt="">
        <div style="padding-top: 5%;opacity: 0.50;">
            <h1><? echo strip_tags($course->title); ?></h1>
            <p style="padding-bottom: 5%;"><? echo $course->description; ?>&nbsp;<br></p>
            <h1>Skills needed</h1>
            <p style="padding-bottom: 5%;"><? echo strip_tags($course->skillsNeeded); ?>&nbsp;<br></p>
            <h1>What you will learn</h1>
            <p style="padding-bottom: 5%;"><? echo strip_tags($course->skillsToGain); ?>&nbsp;<br></p>
            <h1>Course statistics</h1>
            <p>&nbsp;- <? echo $courseTakes; ?> learners .<br>- ratring : <? echo $rate; ?>/10 | <a href="<? echo $this->url('rate').'/'.(string)$course->_id; ?>">See more details</a> .<br>- Videos number : <? echo $course->videosNumber; ?>.&nbsp;<br>- total minutes : <? echo round($courseTime / 60); ?>Minutes.</p>
            <h1 style="padding-top: 5%;">Course teacher</h1>
        </div>
        <? $user = $collection->users->findOne(["_id" => new \MongoDB\BSON\ObjectId($course->user_id)]); ?>
        <div class="row" style="margin: 0px;padding: 20px;">
            <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4" style="padding: 0px;">
                <div style="background-image: url(&quot;../<? echo $user->photo; ?>&quot;);height: 50vh;background-repeat: no-repeat;background-size: 100% 100%;background-position: center;"></div>
            </div>
            <div class="w-100 d-sm-block d-md-none d-lg-none d-xl-none"></div>
            <div class="col" style="padding:0px;">
                <div class="card">
                    <div class="card-body" style="height:50vh;">
                        <h4 class="card-title" style="opacity: 0.50;"><? echo strip_tags($user->firstname." ".$user->lastname); ?></h4>
                        <h6 class="text-muted card-subtitle mb-2"></h6>
                        <p class="card-text" style="opacity: 0.50;"><? echo strip_tags($user->description); ?></p><a class="card-link" href="<? echo $this->url('p').'/'.$course->user_id; ?>" style="opacity: 0.50;color: rgb(0,0,0);">View profile</a>
                        <a
                            class="card-link" href="<? echo $this->url('message')."/".$course->user_id; ?>" style="opacity: 0.50;color: rgb(0,0,0);">Send message</a>
                    </div>
                </div>
            </div>
        </div><a href="<? echo $this->url('watch')."/".str_replace(' ', '-', $course->title)."/1"; ?>"><button class="btn btn-light btn-lg" type="button" id="enroll" style="margin-top: 7%;margin-right: 45%;margin-left: 45%;background-color: rgb(255,255,255);color: rgb(0,0,0); border: 1px solid black;">Enroll</button></a><div style="border:1px solid red; margin-top: 5%; opacity: 0.50;" class="alert alert-danger" role="alert">
  Note : The introduction and the second videos are free to watch . After / In the third video you will use your plan to continue watching.
</div></div>
    <div class="footer-dark" style="margin-top: 20%;background-color: rgb(4,4,4);opacity: 1;filter: blur(0px) brightness(49%) grayscale(0%) hue-rotate(0deg) invert(0%) saturate(100%);">
        <footer id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-3 item">
                        <h3><strong>Dz-courses</strong><br></h3>
                        <p><br>Our mission is to improve the Algerian web. we believe that knowledge is a powerful weapon so we created Dz-courses for getting it closer to you.<br><br></p>
                        <ul></ul>
                    </div>
                    <div class="col">
                        <h3>Links</h3>
                        <ul>
                            <li><a href="<? echo $this->url('terms'); ?>">Terms</a></li>
                        </ul>
                    </div>
                    <div class="col">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25562.10922224244!2d3.2361998588980136!3d36.78822852972369!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x128e4f68ab3c1f27%3A0xa72190b28651040b!2sBordj%20El%20Bahri!5e0!3m2!1sen!2sdz!4v1584903818153!5m2!1sen!2sdz" width="400" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                    <div class="col">
                      <ul>
                        <li><a href="mailto:contact@dzcourses.tech">contact@dzcourses.tech</a></li>
                        <li>+213 557 14 00 39</li>
                      </ul>
                    </div>
                </div>
                <p class="copyright">Dz-courses © 2019-2020 | Made in Algeria</p>
            </div>
        </footer>
    </div>
    <script src="<?php echo $this->url('src/app/views/assets/js/jquery.min.js');?>"></script>
    <script src="<?php echo $this->url('src/app/views/assets/bootstrap/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo $this->url('src/app/views/assets/js/Paralax-Hero-Banner.js');?>"></script>    
    <script src="<?php echo $this->url('src/app/views/assets/js/ml-video.js');?>"></script>
    <script src="https://kit.fontawesome.com/a20f839145.js" crossorigin="anonymous"></script>
</body>

</html>
