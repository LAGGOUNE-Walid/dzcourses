<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" href="src/app/views/images/logo2.jpg"/>
     <title>Dz-courses تسجيل الدخول كمُلعم</title>
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/bootstrap/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Article-List.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Footer-Dark.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Navigation-Clean.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/mainstyle.css');?>">
    <link rel="stylesheet" type="text/css" href="https://www.fontstatic.com/f=sky-bold" />
    <script src="https://kit.fontawesome.com/a20f839145.js" crossorigin="anonymous"></script>
</head>

<body style="font-family: 'sky-bold';">
    <div style="padding-bottom: 16PX;">
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
    <div class="text-center" style="opacity: 0.50;padding-top: 10%;">
        <h1 style="padding-top: 10%;font-size: 56px;">تسجيل الدخول كمُعلم&nbsp;</h1>
    </div>
    <div class="text-left" id="form" style="margin: 0;opacity: 0.50;font-family: Arvo, serif;margin-left: 20%;margin-right: 20%;margin-top: 7%;">
    <? if(isset($errors)): ?>
        <div class="alert alert-danger" role="alert" style="background-color: rgb(190,136,141);"><span>
            <? if(is_array($errors)): ?>
                <?foreach($errors as $input => $error): ?>
                    - <? echo $error; ?> in <? echo $input; ?> !<br/>
                <? endforeach; ?></span>
            <? else: ?>
                    - <? echo $errors; ?>
            <? endif; ?>    
        </div>
    <? endif; ?>
        <form method="POST" action="<? echo $this->url('postTeacherLogin'); ?>"><input type="hidden" name="_token" value="<? echo $token; ?>"><label style="float: right;">الإيميل</label>
            <input
                class="form-control" type="text" name="email" required="" autofocus="" inputmode="email" style="margin-bottom: 2%;">
                <label style="float: right;">رقم الهاتف</label><input class="form-control" type="tel" name="phone" required="" autofocus="" style="margin-bottom: 2%;">
                    <label style="float: right;">كملة السر<br></label><input class="form-control" type="password" name="password" autofocus="" style="margin-bottom: 2%;"><button class="btn btn-primary" type="submit">دخول</button></form>
    </div>
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
</body>

</html>