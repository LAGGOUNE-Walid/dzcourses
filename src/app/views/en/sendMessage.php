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
    <script>
      var conn = new WebSocket('ws://127.0.0.1:5784');
      conn.onopen = function(e) {
          console.log("Connection established!");
      };
      function send() {
        var name      =  document.getElementById("name").value;
        var email     =   document.getElementById("email").value;
        var message   =   document.getElementById("message").value;
        var id        =   document.getElementById("to").value;
        var d = new Date();
        var date = d.getFullYear()+"/"+d.getMonth()+"/"+d.getDate()+" "+d.getHours()+":"+d.getMinutes()+":"+d.getSeconds();
        conn.send(JSON.stringify({
          type: "Message" , 
          to : id, 
          name : name,
          email : email,
          message : message,
          date : date
        }));
        document.getElementById("suc").style.display = "block";
      }
      conn.onmessage = function(e) {
          console.log(e.data);    
        };
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
                  <? if($user->role == "teacher"): ?>
                  <div class="card-header" style="background-image: url(<?echo $this->url('');?>src/app/views/images/teacher.jpg); height: 300px;" ></div>
                <? elseif($user->role == "learner"): ?>
                  <div class="card-header" style="background-image: url(<?echo $this->url('');?>src/app/views/images/student.jpg); height: 300px;" ></div>
              <? endif; ?>
                    <img style="width: 150px; height: 150px; position: relative; margin-top: -8%;  border-radius: 10px;" src="<?echo $this->url('');?><? echo $user->photo; ?>">

                    <h3 class="mb-3" style="margin-top: 5%;"><? echo $user->firstname; ?> <? echo $user->lastname; ?></h3>
                    <br/>
                    <div class="col-lg-11">
                        <div style="width: 110%;">
                        <div id="suc" class="alert alert-success" role="alert" style="display: none;">
                    Message sended !
                  </div>
                          <div class="form-group">
                            <input id="to" type="hidden" name="to" value="<? echo (string) $user->_id; ?>">
                            <label class="form-label">Your name</label>
                            <input required="true" id="name" name="name" type="text" class="form-control" placeholder="Name">
                          </div>
                        </div>
                        <div style="width: 110%;">
                          <div class="form-group">
                            <label class="form-label">Your Email</label>
                            <input required="true" id="email" name="email" type="email" class="form-control" placeholder="email">
                          </div>
                        </div>
                        <div style="width: 110%;">
                      <div class="form-group mb-0">
                        <label class="form-label">Message</label>
                        <textarea id="message" required="true" name="message" rows="5" class="form-control" placeholder="Message"></textarea>
                      </div>
                    </div>
                    <hr/>
                      <button onclick="send()" class="btn btn-primary">Send <i class="fe fe-send"></i></button>
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
