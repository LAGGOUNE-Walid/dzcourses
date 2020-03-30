<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="google-site-verification" content="YFEV7wY7tisoM8UG6JIghdFWlUbvps3oM5fWiDxiaY0"/>
    <meta name="description" content="Algerian online eLearning and money making platform, Do you have a skill or a knowledge and you want to teach it and earn money ? Dz-courses is your choice. You want to learn something new to improve your skills ? learn anything anywhere from your computer ? just click sign up ."/>
       <meta name="keywords" content="DZcourses,dzcourses,dz courses,algeria, algerian,online,online learning,make money,make money online,teaching,courses,algerian courses,الجزائر,دورات تعليمية,دورات تعليمية جزائرية,ربح لمال في الجزائر,تعليم,تعلم">
    <meta property="og:title" content="DZcourses"/>
    <meta property="og:description" content="Algerian online eLearning and money making platform."/>
    <meta property="og:type" content="Website"/>
    <meta property="og:url" content="<? echo $this->url(''); ?>"/>
    <meta property="og:image" content="<? echo $this->url('src/app/views/images/logo2.jpg'); ?>"/>
    <title>Dz-courses تصفح جميع الدورات</title>
    <link rel="shortcut icon" type="image/png" href="<? echo $this->url('src/app/views/images/logo2.jpg'); ?>" />
    <link rel="stylesheet" type="text/css" href="https://www.fontstatic.com/f=sky-bold" />
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/bootstrap/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Article-List.css')?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Footer-Dark.css')?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Navigation-Clean.css')?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/mainstyle.css')?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/styles.css');?>">
</head>

<body style="width: 100%; font-family: 'sky-bold';">
    <div>
        <nav class="navbar navbar-light navbar-expand-md fixed-top navigation-clean">
            <div class="container-fluid">
              <a class="navbar-brand" href="<? echo $this->url(''); ?>">Dz courses<img src="<?php echo $this->url('src/app/views/assets/img/logo2.jpg');?>" style="width: 77px;">&nbsp;</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div
                    class="collapse navbar-collapse" id="navcol-1" style="opacity: 0.54; direction: rtl;">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item" role="presentation"><a class="nav-link" href="<? echo $this->url(''); ?>">الرئيسية <i class="fas fa-home"></i></a></li>
                        <? if(!$container->get("Session")->has("loggedIn")): ?>
                            <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">التسجيل <i class="fas fa-user-plus"></i></a>
                                <div class="dropdown-menu dropdown-menu-left" role="menu"><a class="dropdown-item" role="presentation" href="<? echo $this->url('teacherSignup'); ?>">التسجيل كمُعلم</a>
                                    <div class="dropdown-divider" role="presentation"></div><a class="dropdown-item" role="presentation" href="<? echo $this->url('learnerSignup'); ?>">التسجيل كمتَعلم</a></div>
                            </li>
                            <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">دخول <i class="fas fa-sign-in-alt"></i></a>
                                <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="<? echo $this->url('teacherLogin'); ?>">الدخول كمٌعلم</a>
                                    <div class="dropdown-divider" role="presentation"></div><a class="dropdown-item" role="presentation" href="<? echo $this->url('learnerLogin'); ?>">الدخول كمتَعلم</a></div>
                            </li>
                        <? else: ?>
                            <? if($container->get("Session")->get("type") == "teacher"): ?>
                                <li class="nav-item" role="presentation"><a class="nav-link" href="<? echo $this->url('tPanel'); ?>">لوحة التحكم <i class="fas fa-cogs"></i></a></li>
                            <? elseif($container->get("Session")->get("type") == "learner"): ?>     
                                 <li class="nav-item" role="presentation"><a class="nav-link" href="<? echo $this->url('lPanel'); ?>">لوحة التحكم <i class="fas fa-cogs"></i></a></li>
                            <? endif; ?>     
                    <? endif; ?>
                        <li class="nav-item" role="presentation"><a class="nav-link active" href="<? echo $this->url('courses/1'); ?>">الدورات <i class="fas fa-video"></i></a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" href="#footer">تواصل معنا <i class="fas fa-envelope"></i></a></li>
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
    <div style="margin-top: 10%;">
        <h1 class="display-4 text-center" style="padding-top: 10%;opacity: 0.50;">الدورات</h1>
    </div>
    <div style="opacity: 1;">
        <form class="form-inline" style=" margin-top: 7%;margin-right: 10%;opacity: 0.50;margin-left: 25%";><input class="form-control" id="searchbar" type="text" name="search" placeholder="إبحث هنا" style="width: 70%;"></form><br/>
        <div id="matchList"></div>
    </div>
    <div>
        <div class="container" style="padding-top: 5%;opacity: 0.75;">
            <? if(is_null($courses) or $courses === 0):?> <br/> 
            <center><h4 style="opacity: 0.5;">لاتوجد دورات لحد الأن , <a href="<? echo $this->url('teacherSignup'); ?>">سجل</a> و أنشر دورتك !</h4></center> <? $courses = []; endif; ?> 
            <div class="row">
            <? foreach($courses as $course): ?>
                <div class="col-md-4" style="margin-bottom: 3%;border: 0px;">
                    <div class="card"> <a href="<? echo $this->url('course'); ?>/<? echo str_replace(' ', '-', $course->title); ?>"><img class="card-img-top w-100 d-block" src="<? echo $this->url($course->cover); ?>" data-bs-hover-animate="bounce" style="height: 232px;"></a>
                        <div class="card-body">
                            <a href="<? echo $this->url('course'); ?>/<? echo str_replace(' ', '-', $course->title); ?>"><h4 class="card-title"><? echo strip_tags($course->title); ?></h4></a>
                            <p class="card-text"><? echo strip_tags(mb_strimwidth($course->description , 0, 250, " ...")); ?></p><small><br><strong>Tags : <? $tags = explode(",", $course->tags); ?>
                <? foreach($tags as $tag): ?>
                  <span class="badge badge-dark"><? echo strip_tags($tag); ?></span>
                <? endforeach; ?> </strong><br><strong>By :<? 
                $user = $collection->users->findOne(["_id" =>  new MongoDB\BSON\ObjectId($course->user_id)]);
                ?> <a href="<? echo $this->url('p').'/'.$user->_id; ?>"></a> &nbsp;<? echo $user->firstname; ?> <? echo $user->lastname; ?> , at : <? echo $course->created_at; ?> &nbsp;</strong><br><strong>Posted in : <? echo $course->category; ?></strong><br><strong>Rate : <? $rate = $courseController->getCourseRate((string)$course->_id, $collection); if(is_null($rate)) { echo "not rated yet"; }else { echo $rate."/10"; } ?></strong><br><br></small></div>
                    </div>
                </div>
            <? endforeach; ?>
            </div>
        </div>
    </div>
    <? if(!empty($courses)): ?>
        <div style="width: 10%;margin-right: 50%;margin-left: 50%;">
            <nav>
                <? if($currentPage == 1): ?>
              <a href="<? echo $currentPage; ?>"><button type="button" class="btn btn-outline-dark" disabled="true">&laquo;</button></a>
              <? if($currentPage == end($pages)): ?>
                <a href="<? echo $currentPage; ?>"><button type="button" class="btn btn-outline-dark" disabled>&raquo;</button></a>
              <?else:?>
                <a href="<? echo $currentPage+1; ?>"><button type="button" class="btn btn-outline-dark">&raquo;</button></a>
              <? endif; ?> 
          <? else: ?>
              <a href="<? echo $currentPage-1; ?>"><button type="button" class="btn btn-outline-dark">&laquo;</button></a>
              <? if($currentPage == end($pages)): ?>
              <a href="<? echo $currentPage; ?>"><button type="button" class="btn btn-outline-dark" disabled>&raquo;</button></a>
            <?else:?>
              <a href="<? echo $currentPage+1; ?>"><button type="button" class="btn btn-outline-dark">&raquo;</button></a>
            <? endif; ?> 
          <? endif; ?>
            </nav>
        </div>
    <? endif; ?>    
    <div class="footer-dark" style="margin-top: 20%;background-color: rgb(4,4,4);opacity: 1;filter: blur(0px) brightness(49%) grayscale(0%) hue-rotate(0deg) invert(0%) saturate(100%);">
        <footer id="footer" style="direction: rtl;">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-3 item">
                        <h3><strong>Dz-courses</strong><br></h3>
                        <p><br>مهمتنا هي تحسين الويب الجزائري. نحن نؤمن بأن المعرفة سلاح قوي ، لذا أنشأنا هذا الموقع لتقريبها إليك.<br><br></p>
                        <ul></ul>
                    </div>
                    <div class="col">
                        <h3>Links</h3>
                        <ul>
                            <li><a href="<? echo $this->url('terms'); ?>">القواعد العامة</a></li>
                        </ul>
                    </div>
                    <div class="col">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25562.10922224244!2d3.2361998588980136!3d36.78822852972369!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x128e4f68ab3c1f27%3A0xa72190b28651040b!2sBordj%20El%20Bahri!5e0!3m2!1sen!2sdz!4v1584903818153!5m2!1sen!2sdz" width="400" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                    <div class="col">
                      <ul>
                        <li><a href="mailto:contact@dzcourses.tech">contact@dzcourses.tech</a></li>
                        <li style="direction: ltr;">+213 557 14 00 39</li>
                      </ul>
                    </div>
                </div>
                <p class="copyright">Dz-courses © 2019-2020 | Made in Algeria</p>
            </div>
        </footer>
    </div>
    <script src="<?php echo $this->url('src/app/views/assets/js/jquery.min.js');?>"></script>
    <script src="<?php echo $this->url('src/app/views/assets/bootstrap/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo $this->url('src/app/views/assets/js/bs-animation.js');?>"></script>
    <script src="<?php echo $this->url('src/app/views/assets/js/search.js');?>"></script>
    <script src="<?php echo $this->url("src/app/views/fonts/icons.js"); ?>"></script>
</body>

</html>
