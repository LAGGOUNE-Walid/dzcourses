 <!DOCTYPE html>
<html lang="en">
  <head>
    <title>Dz &mdash; courses - Teacher signup</title>
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
        
          
          <div class="col-12 d-none d-xl-block border-top">
            <nav class="site-navigation text-center " role="navigation">
                  <script type="text/javascript">
      function redirect() {
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
                <li><span><a style="color: black;" href="<? echo $this->url('home'); ?>">Homepage</a></span></li>
                <li class="active"><span><a href="#" onclick="redirect()">Join</a></span></li>
                <li><span><a href="#" style="color:black;" onclick="redirectS()">Login</a></span></li>
                <li><span><a style="color:black;" href="<? echo $this->url('courses/1'); ?>">Browse all the courses</a></span></li>
                <li><span><a style="color:black;" href="">Contact</a></span></li>
              </ul>
            </nav>
          </div>
        </div>

      </div>
    </header>
    <div class="site-section" style="background-color: #fafafa;">
    <div class="site-section bg-light">
      <div class="container">
        <div class="row">
          <div style="width: 100%; max-width: 100%; margin-left: 10%; margin-right: 10%;">
            <form  method="POST" action="<? echo $this->url('postTeacherSignup'); ?>" class="p-5 bg-white" enctype='multipart/form-data'>
            <? if(isset($errors)): ?>
            <div class="alert alert-danger" role="alert">
              <? foreach($errors as $input => $error): ?>
                - <? echo $error; ?> in <? echo $input; ?> !<br/>
            <? endforeach; ?>
            </div>
          <? endif; ?>
          <? if(isset($succ)): ?>
          <div class="alert alert-success" role="alert">
            <? foreach($succ as $s): ?>
              - <? echo $s; ?> ! <br/>
          <? endforeach; ?>
          </div>
        <? endif; ?>
                            <div class="card" style="margin-top: 10%; margin-bottom: 10%;">
      <h5 class="card-header" style=" color: white; background: #757575; ">For the online teachers :</h5>
      <div class="card-body">
      <strong>You must to read this  <a href="<? echo $this->url('terms'); ?>">Terms of use</a> Chapter 2</strong>
      </div>
</div>
             <input type="hidden" name="_token" value="<? echo $token; ?>">
              <div class="row form-group">
                <div class="col-md-6 mb-3 mb-md-0">
                  <label class="text-black" for="fname">First Name</label>
                  <input type="text" id="fname" name="firstname" class="form-control" required="true">
                </div>
                <div class="col-md-6">
                  <label class="text-black" for="lname">Last Name</label>
                  <input type="text" id="lname" name="lastname" class="form-control" required="true">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-md-12">
                  <label class="text-black" for="email">Email</label> 
                  <input type="email" id="email" name="email" class="form-control" required="true">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-12">
                  <label class="text-black" for="Address">Address</label> 
                  <input type="address" name="address" id="Address" class="form-control" required="true">
                </div>
              </div>

              <div class="row form-group">
                  <div class="col-md-12">                   
                  <label class="text-black" for="Address">Phone number</label>                    
                  <input type="tel" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}-[0-9]{2}" required="true" id="Phone" class="form-control" value="Example : 213-xxx-xx-xx-xx" name="phone">
                  </div>
                </div>
              <div class="row form-group">
                <div class="col-md-12">
                  <label class="text-black" for="photo">Photo</label> 
                  <br/>
                  <input type="file" name="photo" required="true">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-md-12">
                  <label class="text-black" for="description">Description</label> 
                  <textarea name="description" id="description" cols="30" rows="7" class="form-control" placeholder="Write your description and skills here..." required="true"></textarea>
                </div>
              </div>
              <div class="row form-group">
                  <div class="col-md-12">                   
                  <label class="text-black" for="Address">CCP informations </label>                    
                  <input type="text" name="ccp" required="true" id="Phone" class="form-control" style="border: 1px solid red;">
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-12">                   
                  <label class="text-black" for="Address">Password </label>                    
                  <input type="password" name="password" required="true" id="Password" class="form-control" >
                  </div>
                </div>
              <div class="row form-group">
                <div class="col-md-12">
                  <input size="max-width:10%;" type="submit" value="Create account " class="btn btn-primary py-2 px-4 text-white">
                </div>
              </div>

  
            </form>
          </div>
        </div>
      </div>
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