<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <script src="https://unpkg.com/feather-icons"></script>
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
    <link rel="icon" href="<? echo $user->photo; ?>" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/png" href="<? echo $user->photo; ?>"/>
    <title><? echo $user->firstname; ?> <? echo $user->lastname; ?> - Profile</title>
    <link rel="stylesheet" href="src/app/views/css/font-awesome.min.css">
    <script src="src/app/views/assets/js/require.min.js"></script>
    <script src="src/app/views/assets/js/vendors/jquery-3.2.1.min.js"></script>
    <script src="src/app/views/assets/js/vendors/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="src/app/views/css/fontAwsall.css">
    <!-- Dashboard Core -->
    <link href="src/app/views/assets/css/dashboard.css" rel="stylesheet" />
    <script src="src/app/views/assets/js/dashboard.js"></script>
    <!-- c3.js Charts Plugin -->
    <link href="src/app/views/assets/plugins/charts-c3/plugin.css" rel="stylesheet" />
    <script src="src/app/views/assets/plugins/charts-c3/plugin.js"></script>
    <!-- Google Maps Plugin -->
    <link href="src/app/views/assets/plugins/maps-google/plugin.css" rel="stylesheet" />
    <script src="src/app/views/assets/plugins/maps-google/plugin.js"></script>
    <!-- Input Mask Plugin -->
    <script src="src/app/views/assets/plugins/input-mask/plugin.js"></script>
    <script
        src="src/app/views/assets/js/jquery.min.js"></script>
  </head>
  <body class="">
    <div class="page">
      <div class="page-main">
        <div class="header py-4">
          <div class="container">
            <div class="d-flex">
              <a class="header-brand" href="<? echo $this->url(''); ?>">
                Dz-courses
              </a>
              <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
              </a>
            </div>
          </div>
        </div>
        <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                  <li class="nav-item">
                    <a href="<? echo $this->url('lPanel'); ?>" class="nav-link"  ><i class="fe fe-video"></i>My courses</a>
                  </li>
                  <li class="nav-item">
                    <a href="<? echo $this->url('lAccount'); ?>" class="nav-link active"><i class="fe fe-user"></i>My account</a>
                  </li>
                  <li class="nav-item">
                    <a href="<? echo $this->url('lSettings'); ?>" class="nav-link"><i class="fe fe-settings"></i>Settings</a>
                  </li>
                  <li class="nav-item">
                    <? if($messages == 0): ?>
                      <a href="<? echo $this->url('lmessages/1'); ?>" class="nav-link" id="msg"><i class="fe fe-message-circle"></i>Messages&nbsp;<strong>(<span id="msgNumber"> 0 </span>)</strong></a>
                    <? else: ?>
                      <a href="<? echo $this->url('lmessages/1'); ?>" class="nav-link" id="msg" style="color:green;"><i class="fe fe-message-circle"></i>Messages&nbsp;<strong>(<span id="msgNumber"><? echo $messages; ?></span>)</strong></a>
                    <? endif; ?>
                  </li>
                  <li class="nav-item">
                    <? if($notifications == 0): ?>
                      <a href="<? echo $this->url('lNotifications/1'); ?>" class="nav-link" id="notf"><i class="fe fe-bell"></i>Notifications&nbsp;<strong>(<span id="notfNumber"> 0 </span>)</strong></a>
                    <? else: ?>
                    <a href="<? echo $this->url('lNotifications/1'); ?>" class="nav-link" id="msg" style="color:green;"><i class="fe fe-bell"></i>Notifications&nbsp;<strong>(<span id="msgNumber"><? echo $notifications; ?></span>)</strong></a>
                    <?endif;?> 
                  </li>
                  <li class="nav-item">
                    <form method="POST" action="<? echo $this->url('logout'); ?>">
                      <input type="hidden" name="_token" value="<? echo $token; ?>">
                      <input type="hidden" name="id" value="<? echo $user->_id; ?>">
                      <button type="submit" class="btn btn-link"><i class="fe fe-log-out"></i> Logout</button>
                    </form>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <br/>
          <body class="">
              <input type="hidden" id="to" value="<? echo (string) $user->_id; ?>">

    <div class="page">
      <div class="page-main">
        <div class="header py-8">
          <div class="container">
              <div class="col-lg-8" style="margin-left: 15%; margin-right: 15%;"> 
              <div style="display: none;" id="success-alert">
              <button type='button' class='btn btn-primary' id="clear">Clear all</button><br/><br/>
            </div>
                <div class="card card-profile">
                  <div class="card-body text-center">
                  <div class="card-header" style="background-image: url(src/app/views/images/student.jpg); height: 300px;" ></div>
                    <img style="width: 150px; height: 150px; position: relative; margin-top: -8%;  border-radius: 10px;" src="<? echo $user->photo; ?>">

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
                        <li><small>Taken Courses : <? echo $courses; ?> </small></li>
                        <li>
                        <span class="badge badge-secondary">Registred at : <? echo $user->created_at; ?></span>
                        </li>
                      </ul>
                    </p>
                    <br/>
                    <hr>
                    <center>
                      <div class="col-md-10">
                        <div class="form-group">
                          <label class="form-label">Share link <button class="btn btn-primary" onclick="copy()">Copy <i class="fa fa-copy"></i></button>  </label>
                          <input id="link" type="text" name="phone" class="form-control" value="<? echo $this->url(''); ?>p/<? echo (string)$user->_id; ?>">
                        </div>
                      </div>
                     </center> 
                  </div>
                </div>
              </div>
          </div>
        </div>


      <footer class="footer">
        <div class="container">
            <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
              Copyrights © <script>document.write(new Date().getFullYear());</script> panel by : Tabler</a>
            </div>
          </div>
        </div>
      </footer>
      <script>
      feather.replace()
    </script>
    <? require "learnerFooter.php"; ?>
    </div>
  </body>
</html>
