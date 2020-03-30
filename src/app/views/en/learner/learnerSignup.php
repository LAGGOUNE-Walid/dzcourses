<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/png" href="src/app/views/images/logo2.jpg"/>
    <title>Dz-courses Sign up for learners</title>
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/bootstrap/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arvo">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Article-List.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Footer-Dark.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/Navigation-Clean.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/mainstyle.css');?>">
</head>

<body style="font-family: Arvo, serif;">
    <div style="padding-bottom: 16PX;">
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
                        <li class="nav-item" role="presentation"><a class="nav-link" href="<? echo $this->url('#footer'); ?>">Contact <i class="fas fa-envelope"></i></a></li>
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
        <h1 style="padding-top: 10%;font-size: 56px;">Sign up as learner&nbsp;</h1>
    </div>
    <div class="text-left" id="form" style="margin: 0;opacity: 0.50;font-family: Arvo, serif;margin-left: 20%;margin-right: 20%;margin-top: 7%;">
    <? if(isset($errors)): ?>
        <div class="alert alert-danger" role="alert" style="background-color: rgb(190,136,141);"><span><? foreach($errors as $input => $error): ?>
                - <? echo $error; ?> in <? echo $input; ?> !<br/>
            <? endforeach; ?></span></div>
    <? endif; ?>
        <form method="POST" action="<? echo $this->url('postLearnerSignup'); ?>" enctype='multipart/form-data'><input type="hidden" name="_token" value="<? echo $token; ?>"><label>First name</label><input class="form-control" type="text" name="firstname" required="" autofocus="" style="margin-bottom: 2%;"><label>Last name</label><input class="form-control" type="text" name="lastname" required="" autofocus="" style="margin-bottom: 2%;"><label>Email</label>
            <input
                class="form-control" type="text" name="email" required="" autofocus="" inputmode="email" style="margin-bottom: 2%;"><label>Address<br></label><input class="form-control" type="text" name="address" required="" autofocus="" style="margin-bottom: 2%;">
                <label>Phone number <br></label><input class="form-control" type="tel" name="phone" placeholder="Phone number" required=""
                    autofocus="" style="margin-bottom: 2%;">
                <label>Photo&nbsp;<br></label><input type="file" accept="image/*" name="photo" required="" style="margin-bottom: 2%;width: 100%;"><label>Description of you<br></label><textarea class="form-control"
                    name="description" autofocus="" style="margin-bottom: 2%;"></textarea>
                    <label class="text-black" for="Address">Plans</label>                    
                  <select name="plan">
                    <option value="1">500da</option>
                    <option value="2">900da</option>
                    <option value="3">1300da</option>
                  </select>
                  <br/><label>Password<br></label><input class="form-control" type="password" name="password" autofocus="" style="margin-bottom: 2%;"><button class="btn btn-primary" type="submit">Join</button></form>
    </div>
    <div class="footer-dark" style="margin-top: 20%;background-color: rgb(4,4,4);opacity: 1;filter: blur(0px) brightness(49%) grayscale(0%) hue-rotate(0deg) invert(0%) saturate(100%);">
        <footer>
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
                            <li><a href="terms">Terms</a></li>
                        </ul>
                    </div>
                </div>
                <p class="copyright">Dz-courses © 2019 | Made in Algeria</p>
            </div>
        </footer>
    </div>
    <script src="<?php echo $this->url('src/app/views/assets/js/jquery.min.js');?>"></script>
    <script src="<?php echo $this->url('src/app/views/assets/bootstrap/js/bootstrap.min.js');?>"></script>
    <script src="<? echo $this->url("src/app/views/fonts/icons.js"); ?>"></script>
</body>

</html>