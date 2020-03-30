<noscript><h3> You must have JavaScript enabled in order to use this order form. Please 
      enable JavaScript and then reload this page in order to continue. </h3> 
      <meta HTTP-EQUIV="refresh" content=0;url="<? echo $this->url('javascript'); ?>">
  </noscript>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" href="<?php echo $this->url('src/app/views/images/logo2.jpg'); ?>"/>
    <title>Dz-courses <? echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/bootstrap/css/bootstrap.min.css');?>">
    <link rel="stylesheet" type="text/css" href="https://www.fontstatic.com/f=sky-bold" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Article-List.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Comment.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Footer-Dark.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Navigation-Clean.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/mainstyle.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/untitled.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Vertical-scroll-box-1.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Vertical-scroll-box.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Video-Responsive.css');?>">
    <script src="//cdn.jsdelivr.net/npm/afterglowplayer@1.x"></script>
   <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/styles.css');?>">
   <script src="<? echo $this->url("src/app/views/fonts/icons.js"); ?>"></script>
  <script type="text/javascript">
     //document.addEventListener('contextmenu', event => event.preventDefault());
  </script>
  <style type="text/css">
      .video-js-responsive-container.vjs-hd {
    padding-top: 56.25%;
}
.video-js-responsive-container.vjs-sd {
    padding-top: 75%;
}
.video-js-responsive-container {
    width: 100%;
    position: relative;
}
.video-js-responsive-container .video-js {
    height: 100% !important; 
    width: 100% !important;
    position: absolute;
    top: 0;
    left: 0;
}

  </style>
</head>

<body style="font-family: 'sky-bold'; width: 100%;">
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
                        <li class="nav-item" role="presentation"><a class="nav-link" href="<? echo $this->url('courses/1'); ?>">الدورات <i class="fas fa-video"></i></a></li>
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
    <div style="margin-top: 20%;">
        <h1 class="display-4 text-center" style="padding-top: 15%;opacity: 0.50;"><? echo $videoName; ?></h1>
    </div>
    <div style="">
        <div class="container" style="padding-top: 5%;opacity: 1;">
        <? if($showFiles === true): ?>
                <div class="alert alert-light" role="alert" style="border: 1px solid black;">
                    <? if(! is_null($attachedFiles)): ?>
                        الملفات المرفقة: <a class="alert-link" href="<? echo $attachedFiles; ?>"><? echo $attachedFiles; ?></a>
                    <? else: ?>
                        لاتوجد أي ملفات مرفقة.
                    <?endif;?>    
                </div>
            <? endif; ?>
            <? if($showChatRoom === true): ?>
                <div class="alert alert-light" role="alert" style="border: 1px solid black;">
                    <? if(!empty($chatRoomLink)): ?>
                        رابط غرفة الدردشة: <a class="alert-link" href="<? echo $chatRoomLink; ?>"><? echo $chatRoomLink; ?></a>
                    <? else: ?>
                        لاتوجد غرفة دردشة لهذه الدورة
                    <?endif;?>    
                </div>
            <? endif;?>
            <? if($getCertificate === true): ?>
                <div class="alert alert-light" role="alert">
                    <form method="post" action="<? echo $this->url('generateCertificate'); ?>">
                        
                        <input type="hidden" name="course_id" value="<? echo $course_id; ?>">
                        <button type="submit" class="btn btn-secondary btn-lg btn-block">أحصل على شهادة إتمام</button>
                    </form>    
                </div>
            <? endif;?>
            <div class="video-js-responsive-container vjs-hd">
            <center>
                <video id='my-video' class='video-js' controls preload='auto' width='50' height='600'
                       data-setup='{}' controls controlsList="nodownload">
                        <source src='<? echo $this->url('getVideo')."/".$video->md5; ?>' type='video/mp4'>
                        <p class='vjs-no-js'>
                          To view this video please enable JavaScript, and consider upgrading to a web browser that
                          <a href='https://videojs.com/html5-video-support/' target='_blank'>supports HTML5 video</a>
                        </p>
                      </video>
                </center>      
            </div>
            <div class="alert alert-light" role="alert" style="margin-top: 7%;opacity: 0.50;margin-bottom: 7%; border:1px solid black;">
                <h2 style="float: right;">التقدم&nbsp;</h2>
                <br/>
                <br/>
                <div class="progress bg-white border rounded-0 border-dark d-xl-flex justify-content-xl-start align-items-xl-center">
                    <div class="progress-bar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: <?echo $percentage;?>%;"><? echo $percentage; ?>%</div>
                </div>
            </div>
            <div id="course-title" style="margin-top: 0%;margin-bottom: 10%;opacity: 0.75;height: 300px;">
                <? foreach($otherVideos as $video): ?>
                    <div class="alert alert-dark" role="alert" style="margin-top: 1%;background-color: rgb(255,255,255);"><a class="alert-link" href="<? echo $video->number; ?>" style="color: rgb(0,115,164);"><? $videoData = explode("/", $video->origin); echo $videoData[1]; ?>&nbsp;</a>
                   <? if($completedVideos > 0): ?> 
                        <span class="badge badge-success">تمت المشاهدة</span>
                        <? $completedVideos = $completedVideos-1; ?>
                    <? else: ?>
                        <span class="badge badge-warning">لم تتم المشاهدة</span>
                    <? endif; ?>    
                    </div>
               <? endforeach; ?> 
            </div>
            <center>
                <a href="<? echo $this->url('rate').'/'.$course_id; ?>"><button style="margin-bottom: 5%; margin-top: 5%;" type="button" class="btn btn-outline-dark">قييم هذه الدورة</button></a>
            </center>

            <div style="margin-top: 10%;">
                <? if(isset($erros)): ?>
                    <div class="alert alert-danger" role="alert">
                      <? foreach($erros as $error): ?>
                        <? echo $error; ?>
                      <?  endforeach;?>
                    </div>
                <? endif; ?>
                <h1 class="display-4 text-center" style="padding-top: 10%;opacity: 0.50;">التعليقات</h1>
                <form method="POST" action="<? echo $this->url('postComment'); ?>">
                    <input type="hidden" name="user_id" value="<? echo $session->get("id"); ?>">
                    <input type="hidden" name="course_id" value="<? echo $course_id;?>">
                    <textarea name="comment" class="form-control" name="comment" placeholder="أكتب تعليقك هنا ..." style="margin-top: 5%;margin-right: 0;opacity: 0.75;width: 100%;"></textarea><button class="btn btn-light border-dark" type="submit"
                        style="margin-top: 1%;">علق</button></form>
                <div id="comments" style="margin-top: 5%; margin-bottom: 5%; height: 1200px; overflow-y: scroll; border-left: 1px solid rgba(0,0,0,.125); ">
                    <? if(!$comments->isDead()): ?>
                        <? foreach($comments as $comment): ?>
                            <? $user = $collection->learners->findOne(["_id" => new MongoDB\BSON\ObjectId($comment->user_id)]); ?>
                            <? if (is_null($user)) : $user = $collection->users->findOne(["_id" => new MongoDB\BSON\ObjectId($comment->user_id)]); endif; ?>
                            <div class="card-group" style="width: 80%;margin-right: 10%;margin-left: 10%;opacity: 0.75;margin-top: 5%;">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title"><a href="<? echo $this->url('p')."/".$comment->user_id; ?>" target="_blank"><? echo $user->firstname." ".$user->lastname; ?></a> <small>at <? echo $comment->created_at; ?></small></h4>
                                        <p class="card-text"><? echo $comment->comment; ?></p>
                                    </div>
                                </div>
                            </div>
                        <? endforeach; ?>    
                    <? else: ?>
                        <center>
                            <h3>لاتوجد أي تعليقات.</h3>
                        </center>
                    <? endif; ?>    
                </div>

            </div>
        </div>
    </div>
    <div class="footer-dark" style="margin-left: -1%; margin-right: -1%; padding-top: 20%; background-color: rgb(4,4,4);opacity: 1;filter: blur(0px) brightness(49%) grayscale(0%) hue-rotate(0deg) invert(0%) saturate(100%);">
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
       <script src="<?php echo $this->url('src/app/views/js/video.js');?>"></script>
      <script type="text/javascript">
        document.addEventListener('contextmenu', event => event.preventDefault());
          window.addEventListener('click', function(e){   
              if (document.getElementById('my-video').contains(e.target)){
                // Clicked in box
              } else{
                 var vid = videojs("my-video"); 
                 vid.pause();
                /**
                     **/
              }
            });
      </script>
</body>

</html>