 <!DOCTYPE html>
<html lang="en">
  <head>
    <title>Dz &mdash; courses</title>
    <link rel="shortcut icon" type="image/png" href="src/app/views/images/logo2.jpg"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="src/app/views/fonts/icomoon/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="src/app/views/css/magnific-popup.css">
    <link rel="stylesheet" href="src/app/views/css/jquery-ui.css">
    <link rel="stylesheet" href="src/app/views/css/owl.carousel.min.css">
    <link rel="stylesheet" href="src/app/views/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="src/app/views/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="src/app/views/fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="src/app/views/css/aos.css">

    <link rel="stylesheet" href="src/app/views/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,700|Playfair+Display:400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  </head>
  <body>
  <div class="site-wrap">

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="js-menu-toggle"><i class="fas fa-window-close"></i></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>
    
    <header class="site-navbar pt-3" role="banner">
      <div class="container-fluid">
        <div class="row align-items-center">

          <div class="col-6 col-xl-6 logo">
            <img style="width: 120px; height: 100px;" src="src/app/views/images/logo2.jpg">
            <br/>
            <h1 class="mb-0"><a href="<? echo $this->url('home'); ?>" class="text-black h2 mb-0">Dz - courses</a></h1>
            <p>Online learning platform.</p>
            <p></p>
          </div>
          <div class="col-6 mr-auto py-3 text-right" style="position: relative; top: 3px;">
            <a href="#" class="site-menu-toggle js-menu-toggle text-black d-inline-block d-xl-none"><span class="icon-menu h3"></span></a></div>
          </div>
        
          
          <div class="col-12 d-none d-xl-block border-top">
            <nav class="site-navigation text-center " role="navigation">
                  <script type="text/javascript">
      function redirectT() {
        Swal.fire({
            position: 'bottom',
            title: '<strong><u>You need to choose</u></strong>',
            type: 'info',
            html:
              '<a href="<? echo $this->url('learnerSignup'); ?>">Learner</a> OR ' +
              '<a href="<? echo $this->url('teacherSignup'); ?>">Teacher</a> '
          })
      }
      function redirectS() {
        Swal.fire({
            position: 'bottom',
            title: '<strong><u>You need to choose</u></strong>',
            type: 'info',
            html:
              '<a href="<? echo $this->url('learnerLogin'); ?>">Learner</a> OR ' +
              '<a href="<? echo $this->url('teacherLogin'); ?>">Teacher</a> '
          })
      }
    </script>
              <ul class="site-menu js-clone-nav mx-auto d-none d-lg-block mb-0">
                <li class="active"><a href="">Homepage</a></li>
                <? if(!$container->get("Session")->has("loggedIn")): ?>
                  <li><span><a href="#" style="color:black;" onclick="redirectT()">Join</a></span></li>
                   <li><span><a href="#" style="color:black;" onclick="redirectS()">Login</a></span></li>
                 <? else: ?>
                    <? if($container->get("Session")->get("type") == "teacher"): ?>
                      <li><span><a style="color:black;" href="<? echo $this->url('tPanel'); ?>">Panel</a></span></li>
                    <? elseif($container->get("Session")->get("type") == "learner"): ?> 
                      <li><span><a style="color:black;" href="<? echo $this->url('lPanel'); ?>">Panel</a></span></li>
                    <? endif; ?> 
                 <? endif; ?>  
                <li><span><a style="color:black;" href="<? echo $this->url('courses/1'); ?>">Browse all the courses</a></span></li>
                <li><span><a style="color:black;" href="">Contact</a></span></li>
              </ul>
            </nav>
          </div>
        </div>

      </div>
    </header>
    <div class="site-section" style="background-color: #fafafa;">
      <div class="container">
    <? if(!$courses->isDead()): ?>
    <h1>Latest courses : </h1>
        <div class="row">

          <? foreach($courses as $course): ?>
            <div class="col-lg-4 mb-5 mb-lg-0">
            <div class="section-heading mb-5 d-flex align-items-center">
              </div>
              <div class="entry2 mb-5">
                <a href="single.html"><img src="<? echo $course->cover; ?>" alt="Image" class="img-fluid rounded"></a>
                <br/>
                <span class="post-category text-white bg-primary mb-3"><? echo $course->category; ?></span>
                <h2><a href="single.html"><? echo $course->title; ?></a></h2>
                <div class="post-meta align-items-center text-left clearfix">
                <? 
                $user = $collection->users->findOne(["_id" =>  new MongoDB\BSON\ObjectId($course->user_id)]);
                ?>
                  <figure class="author-figure mb-0 mr-3 float-left"><img src="<? echo $user->photo; ?>" alt="Image" class="img-fluid"></figure>
                  <span class="d-inline-block mt-1">By <a href="<? echo $this->url('p').'/'.$user->_id; ?>"><? echo $user->firstname; ?> <? echo $user->lastname; ?></a></span>
                  <span>&nbsp;-&nbsp; <? echo $course->created_at; ?></span>
                </div>
                <p><? echo mb_strimwidth($course->description , 0, 250, "..."); ?></p>
                <? $tags = explode(",", $course->tags); ?>
                <? foreach($tags as $tag): ?>
                  <span class="badge badge-dark"><? echo $tag; ?></span>
                <? endforeach; ?> 
              </div>
            </div>
          <? endforeach; ?>
        </div>
          <center>
            <a href="<? echo $this->url('courses/1'); ?>"><button type="button" class="btn btn-outline-info">See all courses </button></a>
          </center>
      <? endif; ?>
      </div>
    </div>

    <div class="site-section" style="padding: 5%; max-height: 1200px;">
      <div class="card-group">
          <div class="card">
              <img class="card-img-top" src="src/app/views/images/student.jpg" alt="Card image cap">
              <div class="card-body">
                <h5 class="card-title">Be the learner !</h5>
                <p class="card-text">You want to learn something new to improve your skills ? learn anything anywhere from your computer ? just click sign up .</p>
                <a href=""><button type="button" class="btn btn-outline-dark">Sign up as learner</button></a>
              </div>

          </div>
          <div style="padding: 1%;" ><h3>OR</h3></div>
          <div class="card">
              <img class="card-img-top" src="src/app/views/images/teacher.jpg" alt="Card image cap">
              <div class="card-body">
                <h5 class="card-title">Be the online teacher !</h5>
                <p class="card-text">Do you have a skill or a knowledge and you want to teach it and earn money ? Dz-courses is your choice.</p>
                <a href="<? echo $this->url('teacherSignup'); ?>"><button type="button" class="btn btn-outline-dark">Sign up as teacher for free</button></a>
            </div>
          </div>
      </div>
    </div>

<div class="site-section" style="margin-top:10%;  padding: 5%; max-height: 9999999999999px; background-color: #fafafa; " >
      <h1>How Dz-courses work ?</h1>
      <div class="card" style="margin-top: 5%;">
            <h5 class="card-header" style=" color: white; background: #757575;">For the learners :</h5>
            <div class="card-body">
              <p class="card-text">
                  <ul>
                    <strong><li>Signup with your real informations to Dz-courses.</li></strong>
                    <strong><li>Activate your account with learner plans : </li></strong>
                      <strong> 
                        <ul>
                          <li>1000Da Get access to 1 course per month.</li>
                          <li>2000Da Get access to 2 courses per month.</li>
                          <li>3000Da Get access to 3 courses per month.</li>
                        </ul>
                    </strong>
                <strong><li>Your account will be activated manually in few hours or days .</li></strong>
                <div class="alert alert-danger" role="alert">
                  <strong><li>Once you get access to the course you can't get back your money or leave the course !</li></strong>
                </div>
              </ul>
            </p>
          </div>
    </div>
    <div class="card" style="margin-top: 10%; margin-bottom: 10%;">
      <h5 class="card-header" style=" color: white; background: #757575; ">For the online teachers :</h5>
      <div class="card-body">
        <ul>
            <strong><li>Signup with your real informations to Dz-courses.</li></strong>
            <strong><li>Upload your course to the website.</li></strong>
            <strong><li>Wait until the administration accept your course.</li></strong>
            <strong><li>You will get 500da for each new learner joined your course .</li></strong>
            <strong><li>In the end of the month you will receive your money.</li></strong>
            <div class="alert alert-danger" role="alert">
              <strong><li>Once you post the course you can't get back your money or remove the course !</li></strong>
            </div>
          </ul>
      </div>
</div>
</div>

    <div class="site-footer">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-4">
            <h3 class="footer-heading mb-4">About Us</h3>
            <p>Our mission is to improve the Algerian web . we believe that the knowledge is a powerful weapon so we created Dz-courses for getting it closer to you .</p>
            <br/>
            <a href="<? echo $this->url('terms'); ?>">Terms of use</a>
          </div>
        </div>
        <div class="row">
          <div class="col-12 text-center">
            <p>
              Copyright &copy; <script>document.write(new Date().getFullYear());</script> All rights reserved | Made in <i style="color: green;">AL</i><i style="color: red;">GE</i><i style="color:white;">RIA</i> <i style="color: red;" class="fas fa-heart" aria-hidden="true"></i>
              </p>
          </div>
        </div>
      </div>
    </div>

  <script src="src/app/views/js/jquery-3.3.1.min.js"></script>
  <script src="src/app/views/js/jquery-migrate-3.0.1.min.js"></script>
  <script src="src/app/views/js/jquery-ui.js"></script>
  <script src="src/app/views/js/popper.min.js"></script>
  <script src="src/app/views/js/bootstrap.min.js"></script>
  <script src="src/app/views/js/owl.carousel.min.js"></script>
  <script src="src/app/views/js/jquery.stellar.min.js"></script>
  <script src="src/app/views/js/jquery.countdown.min.js"></script>
  <script src="src/app/views/js/jquery.magnific-popup.min.js"></script>
  <script src="src/app/views/js/bootstrap-datepicker.min.js"></script>
  <script src="src/app/views/js/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
  <script src="src/app/views/js/main.js"></script>
    
  </body>
</html>
