<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="./favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />
    <!-- Generated: 2018-04-16 09:29:05 +0200 -->
    <title><? echo $user->firstname ?> <? echo $user->lastname; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <script src="<?php echo $this->url('src/app/views/assets/js/require.min.js'); ?>"></script>
    <script>
      requirejs.config({
          baseUrl: '.'
      });
    </script>
    <!-- Dashboard Core -->
    <link href="<?php echo $this->url('src/app/views/assets/css/dashboard.css'); ?>" rel="stylesheet" />
    <script src="<?php echo $this->url('src/app/views/assets/js/dashboard.js'); ?>"></script>
    <!-- c3.js Charts Plugin -->
    <link href="<?php echo $this->url('src/app/views/assets/plugins/charts-c3/plugin.css'); ?>" rel="stylesheet" />
    <script src="<?php echo $this->url('src/app/views/assets/plugins/charts-c3/plugin.js'); ?>"></script>
    <!-- Google Maps Plugin -->
    <link href="<?php echo $this->url('src/app/views/assets/plugins/maps-google/plugin.css'); ?>" rel="stylesheet" />
    <script src="<?php echo $this->url('src/app/views/assets/plugins/maps-google/plugin.js'); ?>"></script>
    <!-- Input Mask Plugin -->
    <script src="<?php echo $this->url('src/app/views/assets/plugins/input-mask/plugin.js'); ?>"></script>
  </head>
  <body class="">
  <a href="<? echo $this->url(""); ?>">
          <button style="margin-left: 0.5%; margin-top: 0.5%;" class="btn btn-outline-primary btn-sm">
          <span class="fa fa-arrow-left"></span>
      </button>
          </a>
                    <br/>
    <div class="page">

      <div class="page-content">
                    <br/>
        <div class="container text-center">
              <div class="page">
      <div class="page-main">
        <div class="header py-8">
          <div class="container">
              <div class="col-lg-8" style="margin-left: 15%; margin-right: 15%;"> 
                <div class="card card-profile">
                  <div class="card-body text-center">
                  <? if($user->role == "teacher") { $cover = "src/app/views/images/teacher.jpg"; }else { $cover = "src/app/views/images/student.jpg"; } ?>
                  <div class="card-header" style="background-image: url(<?echo $this->url('');?><? echo $cover; ?>); height: 300px;" ></div>
                    <img style="width: 150px; height: 150px; position: relative; margin-top: -8%;  border-radius: 10px;" src="<?echo $this->url('');?><? echo $user->photo; ?>">

                    <h3 class="mb-3" style="margin-top: 5%;"><? echo $user->firstname; ?> <? echo $user->lastname; ?></h3>
                    <p class="mb-4">
                      <? echo $user->description; ?>
                      <hr/>

                      <ul style="list-style-type: none;  margin: 0; padding: 0;overflow: hidden;">
                        <style type="text/css">
                          li {
                            display: block;
                            float: left;
                            text-align: center;
                            padding: 10px;
                            text-decoration: none;
                          }
                        </style>
                        <li><small>Address : <? echo $user->address; ?> </small></li>
                        <li><small>Phone : <? echo $user->phone; ?> </small></li>
                        <li><small>Email : <? echo $user->email; ?> </small></li>
                        <li><small>Role : <? echo $user->role; ?></small></li>
                        <? if(isset($courses)): ?>
                          <li><small>Courses : <? echo $courses; ?> </small></li>
                        <? elseif(isset($coursesTaken)): ?>
                        
                          <li><small>Token Courses :  </small></li>
                          <br/>
                          <? $count = 0; foreach($coursesTaken as $course): ?>
                          <br/>
                            <? $title = @$courseCollection->findOne(["_id" => new MongoDB\BSON\ObjectId($course->course_id)])->title; ?>
                            <small><a href="<? echo $this->url('course'); ?>/<? echo str_replace(' ', '-', $title); ?>"><h4 class="card-title"><? echo strip_tags($title); ?></h4></a></small>
                          <? $count++; endforeach; ?>
                          <br/>
                           <li><small><strong><? echo "Total : $count"; ?></strong></small></li>  
                      <? endif; ?>
                        <li>
                        <span class="badge badge-secondary">Registred at : <? echo $user->created_at; ?></span>
                        </li>
                      </ul>
                    </p>
                    <br/>
                    <a href="<? echo $this->url(""); ?>message/<? echo (string)$user->_id;  ?>">
                      <button class="btn btn-outline-primary btn-sm">
                        <span class="fa fa-send"></span> Send message
                      </button>
                    </a>
                  </div>
                </div>
              </div>
          </div>

        </div>
        <br/>
       </div>
      </div> 
        </div>
      </div>
    </div>
  </body>
</html>