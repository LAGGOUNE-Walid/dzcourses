<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="google-site-verification" content="YFEV7wY7tisoM8UG6JIghdFWlUbvps3oM5fWiDxiaY0" />
    <title>Dz - courses</title>
    <meta name="description" content="Algerian online eLearning and money making platform, Do you have a skill or a knowledge and you want to teach it and earn money ? Dz-courses is your choice. You want to learn something new to improve your skills ? learn anything anywhere from your computer ? just click sign up . "/>
    <meta name="keywords" content="DZcourses,dzcourses,dz courses,algeria, algerian,online,online learning,make money,make money online,teaching,courses,algerian courses,الجزائر,دورات تعليمية,دورات تعليمية جزائرية,ربح لمال في الجزائر,تعليم,تعلم">
    <meta property="og:title" content="DZcourses" />
    <meta property="og:description" content="Algerian online eLearning and money making platform." />
    <meta property="og:type" content="Website" />
    <meta property="og:url" content="<? echo $this->url(''); ?>" />
    <meta property="og:image" content="<? echo $this->url('src/app/views/images/logo2.jpg'); ?>" />
    <link rel="shortcut icon" type="image/png" href="src/app/views/images/logo2.jpg"/>
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/styles.css');?>">
    <link rel="stylesheet" type="text/css" href="https://www.fontstatic.com/f=sky-bold" />
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/bootstrap/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Article-List.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Footer-Dark.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Navigation-Clean.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Paralax-Hero-Banner-1.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Paralax-Hero-Banner.css');?>">
    <script src="https://kit.fontawesome.com/a20f839145.js" crossorigin="anonymous"></script>
    
</head>

<body style="font-family: 'sky-bold';">
    <div>
        <nav class="navbar navbar-light navbar-expand-md fixed-top navigation-clean">
            <div class="container-fluid">
              <a class="navbar-brand" href="<? echo $this->url(''); ?>">Dz courses<img src="<?php echo $this->url('src/app/views/assets/img/logo2.jpg');?>" style="width: 77px;">&nbsp;</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div
                    class="collapse navbar-collapse" id="navcol-1" style="opacity: 0.54; direction: rtl;">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item" role="presentation"><a class="nav-link active" href="<? echo $this->url(''); ?>">الرئيسية <i class="fas fa-home"></i></a></li>
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
                        <li class="nav-item" role="presentation"><a class="nav-link" href="<? echo $this->url('#footer'); ?>">تواصل معنا <i class="fas fa-envelope"></i></a></li>
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
    <div style="margin-top: 20%;">
      <img src="src/app/views/images/17947.png" class="img-fluid" alt="Responsive image">
    </div>
    </div>
    <div style="direction: rtl; margin-top: 5%;">
        <h1 class="display-4 text-center" style="padding-top: 10%;opacity: 0.50;">آخر الدورات <i class="fas fa-video"></i></h1>
    </div>
    <? if(!$courses->isDead()): ?>
        <div class="card-group" style="margin: 5%;">
            <? foreach($courses as $course): ?>
                <div class="card"><a href="<? echo $this->url('course'); ?>/<? echo str_replace(' ', '-', $course->title); ?>"><img class="img-fluid card-img-top w-100 d-block" src="<? echo $course->cover; ?>"></a>
                    <div class="card-body">
                        <h4 class="card-title"><a href="<? echo $this->url('course'); ?>/<? echo str_replace(' ', '-', $course->title); ?>"><?php echo $course->title; ?></a>&nbsp;</h4>
                        <p class="card-text"><? echo mb_strimwidth($course->description , 0, 250, "..."); ?><br></p><small><strong>Tags : <? $tags = explode(",", $course->tags); ?>
                <? foreach($tags as $tag): ?>
                  <span class="badge badge-dark"><? echo $tag; ?></span>
                <? endforeach; ?> &nbsp;</strong><br><strong>By : &nbsp;<?$user = $collection->users->findOne(["_id" =>  new MongoDB\BSON\ObjectId($course->user_id)]);?><a href="<? echo $this->url('p').'/'.$user->_id; ?>"><?
                 echo $user->firstname." ".$user->lastname;?></a> , at : <? echo $course->created_at; ?> &nbsp;</strong><br><strong>Posted in : <?php echo $course->category;  ?></strong></small></div>
                </div>
            <? endforeach; ?>    
        </div>
            <div class="text-center border-white" style="direction: rtl; margin-bottom: 5%;padding-left: 10px;"><a class="btn btn-dark btn-sm text-center border-dark" role="button" href="<? echo $this->url('courses/1'); ?>" style="background-color: rgb(255,255,255);color: rgb(0,0,0);opacity: 0.75;">جميع الدورات <i class="fas fa-video"></i></a></div>
            <? if(is_null($highRatedCourseInThisMonth) OR method_exists($highRatedCourseInThisMonth, "isDead") AND $highRatedCourseInThisMonth->isDead()) : ?>
             <br/> <center><h3 style="opacity: 0.5;">ليس هناك الدورة الأعلى تقييما لهذا الشهر .</h3></center>
            
                </div>
            <? else: ?>
            <div style="margin-top: 7%;margin-bottom: 7%;margin-right: 1%;margin-left: 1%;height: 700px;padding-bottom: 7%;">

                <h1 class="text-center" style="direction: rtl; opacity: 0.50;padding-top: 5%;padding-bottom: 5%;">الأعلى تقييما لهذا الشهر <i class="fas fa-video"></i></h1>
                <div class="jumbotron hero-technology" style="background-image: url(<?php echo $this->url($highRatedCourseInThisMonth->cover);  ?>);opacity: 1;height: 100%;">
                    <h1 class="hero-title" style="opacity: 0.50;background-color: #c5c5c5;color: rgb(4,4,4);"><? echo $highRatedCourseInThisMonth->title;  ?> by <? $user = $collection->users->findOne(["_id" =>  new MongoDB\BSON\ObjectId($highRatedCourseInThisMonth->user_id)]); echo $user->firstname." ".$user->lastname; ?></h1>
                    <p style="padding-top: 5%;"><a class="btn btn-link btn-lg hero-button" role="button" href="<? echo $this->url('course'); ?>/<? echo str_replace(' ', '-', $course->title); ?>" style="background-color: rgb(255,255,255);color: rgb(0,0,0);opacity: 0.75;border: 1px solid black;">سجل في هذه الدورة</a></p>
    </div>
            <? endif; ?>    
    <? else: ?>
       <br/> <center><h4 style="direction: rtl; opacity: 0.5;">لاتوجد دورات لحد الأن , <a href="<? echo $this->url('teacherSignup'); ?>">سجل</a> و أنشر دورتك !</h4></center>
    <? endif; ?>    
    <div style="padding-bottom: 1%;padding-top: 10%;">
        <div class="container" style="padding-right: 8px;padding-left: 8px;">
            <div class="row" style="direction: rtl;">
                <div class="col-md-6" style="background-image: url(<?php echo $this->url('src/app/views/images/teacher.jpg'); ?>);background-repeat: no-repeat;background-size: cover;height: 700px;background-position: center;margin-right: -10px;">
                    <h1 class="text-left" style="padding-top: 308px;color: rgb(255,255,255);"><br><br>كن <strong><em><span style="text-decoration: underline;">المدرب</span></em></strong> الإلكتروني</h1>
                    <h4 style="color: rgb(255,255,255);"><br>هل لديك مهارة أو معرفة وتريد تعليمها وكسب المال ؟ Dz-courses هو إختيارك.<br><br><a class="btn btn-primary border rounded-0 border-white" role="button" href="<?php echo $this->url('teacherSignup'); ?>" style="background-color: #262632;opacity: 0.60;">سجل كمُعلم</a><br></h4>
                </div>
                <div class="col-md-6" style="background-image: url(<?php echo $this->url('src/app/views/images/student.jpg'); ?>);background-repeat: no-repeat;background-size: cover;height: 700px;background-position: center;">
                    <h1 class="text-left" style="padding-top: 308px;color: rgb(255,255,255);"><br><br>كن <strong><em><span style="text-decoration: underline;">المتعلم</span></em></strong></h1>
                    <h4 style="color: rgb(255,255,255);"><br>تريد تعلم شيء جديد لتحسين مهاراتك؟ تعلم أي شيء في أي مكان من جهاز الكمبيوتر الخاص بك؟ فقط انقر فوق تسجيل .<br><br><a class="btn btn-primary border-white" role="button" href="<?php echo $this->url('learnerSignup'); ?>" style="opacity: 0.60;background-color: rgb(35,37,49);">تسجيل كمتَعلم</a><br></h4>
                </div>
            </div>
        </div>
        <h1 class="text-center" style="opacity: 0.50;padding-top: 10%;">كيف يعمل الموقع <i class="fab fa-phoenix-framework"></i></h1>
        <div class="card-group" style="padding-top: 5%;margin-left: 10%;margin-right: 10%;">
            <div class="card">
                <div class="card-body" style=" opacity: 0.50; ">
                    <h4 style="direction: rtl;" class="card-title">للمدرب الإلكتروني <i class="fas fa-chalkboard-teacher"></i></h4>
                    <ul style="">
                        <li>سجل بمعلوماتك الحقيقية.<br></li>
                        <li>قم بتحميل دورتك على الموقع.<br></li>
                        <li>انتظر حتى تقبل الإدارة دورتك.<br></li>
                        <li>ستحصل على 300 دينار جزائري لكل طالب جديد انضم إلى لدورتك.<br></li>
                        <li>في نهاية الشهر ستتلقى أموالك.<br></li>
                        <li>بمجرد نشر الدورة التدريبية ، لا يمكنك إزالتها.<br></li>
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-body" style=" opacity: 0.50;">
                    <h4 style="direction: rtl;" class="card-title">للمتعلمين عبر الإنترنت <i class="fas fa-user-graduate"></i></h4>
                    <ul>
                        <li>سجل بمعلوماتك الحقيقية.<br></li>
                        <li>فَعِل حسابك <a href="#plans">بخطط المتعلم</a>  <br>
                        </li>
                        <li>سيتم تنشيط حسابك يدويًا في غضون ساعات أو أيام قليلة.<br></li>
                        <li>بمجرد الإلتحاق بدورة تدريبية لا يمكنك الخروج منها !<br></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div style="margin-top: 20%;">
      <img src="src/app/views/images/2286871.jpg" class="img-fluid" alt="Responsive image">
    </div>
        <h1 id="plans" class="display-4 text-center" style="direction: rtl; padding-top: 10%;opacity: 0.50;">شاهد خططنا للمتعلمين <i class="fas fa-box-open"></i></h1>
        <div>
      <section style="margin-left: -1%; margin-right: -1%; margin-top: 5%;" class="pricing py-5">
          <div class="container">
            <div class="row">
              <!-- Free Tier -->
              <div class="col-lg-4">
                <div class="card mb-5 mb-lg-0">
                  <div class="card-body">
                    <h5 class="card-title text-muted text-uppercase text-center">Basic</h5>
                    <h6 class="card-price text-center">500<span class="period">DA</span></h6>
                    <hr>
                    <ul class="fa-ul">
                      <li><span class="fa-li"><i class="fas fa-check"></i></span>الوصول إلى دورة واحدة</li>
                      <li><span class="fa-li"><i class="fas fa-check"></i></span>الوصول إلى غرف الدردشة</li>
                      <li><span class="fa-li"><i class="fas fa-check"></i></span>الوصول إلى ملفات الدورة التدريبية المرفقة</li>
                      <li><span class="fa-li"><i class="fas fa-check"></i></span>يمكنك مشاهدة مقاطع الفيديو الأولى والثانية من أي دورة مجانًا</li>
                      <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>قد تتاح لك الفرصة لتلقي كوبون شهري لمشاهدة دورة مجانية واحدة</li>
                      <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>احصل على شهادة إتمام عند الانتهاء من الدورة</li>
                    </ul>   
                  </div>
                </div>
              </div>
              <!-- Plus Tier -->
                <div class="col-lg-4">
                <div class="card mb-5 mb-lg-0">
                  <div class="card-body">
                    <h5 class="card-title text-muted text-uppercase text-center">Plus</h5>
                    <h6 class="card-price text-center">900<span class="period">DA</span></h6>
                    <hr>
                    <ul class="fa-ul">
                      <li><span class="fa-li"><i class="fas fa-check"></i></span>الوصول إلى دورتين</li>
                      <li><span class="fa-li"><i class="fas fa-check"></i></span>الوصول إلى غرف الدردشة</li>
                      <li><span class="fa-li"><i class="fas fa-check"></i></span>الوصول إلى ملفات الدورة التدريبية المرفقة</li>
                      <li><span class="fa-li"><i class="fas fa-check"></i></span>يمكنك مشاهدة مقاطع الفيديو الأولى والثانية من أي دورة مجانًا</li>
                      <li><span class="fa-li"><i class="fas fa-check"></i></span>قد تتاح لك الفرصة لتلقي كوبون شهري لمشاهدة دورة مجانية واحدة</li>
                      <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>احصل على شهادة إتمام عند الانتهاء من الدورة</li>
                    </ul>     
                  </div>
                </div>
              </div>
              <!-- Pro Tier -->
              <div class="col-lg-4">
                <div class="card mb-5 mb-lg-0">
                  <div class="card-body">
                    <h5 class="card-title text-muted text-uppercase text-center">Pro</h5>
                    <h6 class="card-price text-center">1300<span class="period">DA</span></h6>
                    <hr>
                   <ul class="fa-ul">
                      <li><span class="fa-li"><i class="fas fa-check"></i></span>الوصول إلى 3 دورات</li>
                      <li><span class="fa-li"><i class="fas fa-check"></i></span>الوصول إلى غرف الدردشة</li>
                      <li><span class="fa-li"><i class="fas fa-check"></i></span>الوصول إلى ملفات الدورة التدريبية المرفقة</li>
                      <li><span class="fa-li"><i class="fas fa-check"></i></span>يمكنك مشاهدة مقاطع الفيديو الأولى والثانية من أي دورة مجانًا</li>
                      <li><span class="fa-li"><i class="fas fa-check"></i></span>قد تتاح لك الفرصة لتلقي كوبون شهري لمشاهدة دورة مجانية واحدة</li>
                      <li><span class="fa-li"><i class="fas fa-check"></i></span>احصل على شهادة إتمام عند الانتهاء من الدورة</li>
                    </ul>     
                  </div>
                </div>
              </div>
            </div>
          </div>
            </section>
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
    <script src="<?php echo $this->url('src/app/views/assets/js/Paralax-Hero-Banner.js');?>"></script>
</body>

</html>
