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
    <title><? echo $user->firstname; ?> <? echo $user->lastname; ?> - panel</title>
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
    <input type="hidden" id="to" value="<? echo (string) $user->_id; ?>">
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
                    <a href="<? echo $this->url('lPanel'); ?>" class="nav-link active"  ><i class="fe fe-video"></i>My courses</a>
                  </li>
                  <li class="nav-item">
                    <a href="<? echo $this->url('lAccount'); ?>" class="nav-link"><i class="fe fe-user"></i>My account</a>
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
        <div class="my-3 my-md-5">
          <div class="container">
            <div style="display: none;" id="success-alert">
              <button type='button' class='btn btn-primary' id="clear">Clear all</button><br/><br/>
            </div>
            <div style="border:1px solid #d6d6d6;" class="alert alert-light" role="alert">
            <span><i class="fas fa-exclamation-circle"></i></span>
              Your plan is :
              <?php if (is_null($user->guard)): ?>
                  Nothing
              <?php else: ?>
                  <? echo $user->guard; ?>
              <? endif; ?>
              ,
              <? if($user->plan == 1): ?>
                You can watch 1 course.
            <? elseif($user->plan > 1): ?>
              You can watch <? echo $user->plan;  ?> courses.
          <? elseif($user->plan == 0): ?>
            You cant watch a course , your plan is 0 .
        <? endif; ?>
        <?php if (is_null($user->guard) AND $user->plan == 0): ?>
          You can buy new learning plan from <a href="<? echo $this->url('uploadInvoices'); ?>">here</a>. 
        <?php endif ?>
          </div>
            <div class="row row-cards row-deck">
              <div class="col-12">
                <div class="card">
                  <div class="table-responsive">
                    <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                      <thead>
                        <tr>
                          <th class="text-center w-1"><i class="icon-people"></i></th>
                          <th>Course</th>
                          <th>Progress</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                      <? foreach($userCourses as $courseProgress): ?>
                        <? $course = $collection->courses->findOne(["_id" => new \MongoDB\BSON\ObjectId($courseProgress->course_id)]); ?>
                        <? if(!is_null($course)): ?>
                        <tr>
                          <td class="text-center">
                            <div class="avatar d-block" style="background-image: url(<? echo $course->cover; ?>)">
                            </div>
                          </td>
                          <td>
                            <div><a href="<? echo $this->url('watch')."/".str_replace(' ', '-', $course->title)."/1"; ?>"><? echo $course->title; ?></a></div>
                            <div class="small text-muted">
                              Registered: <? echo $courseProgress->created_at; ?>
                            </div>
                          </td>
                          <td>
                            <div class="clearfix">
                              <div class="float-left">
                                <strong><? echo round($courseProgress->percentage); ?>%</strong>
                              </div>
                            </div>
                            <div class="progress progress-xs">
                              <div class="progress-bar" role="progressbar" style="width: <? echo $courseProgress->percentage; ?>%" aria-valuenow="<? echo $courseProgress->percentage; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </td>
                          <td>
                            <? $userStatusInCourse = is_null($collection->registredUsersInCourses->findOne(["course_id" => $courseProgress->course_id , "user_id" => $courseProgress->user_id])); ?>
                            <div><? echo ($userStatusInCourse === true) ? "Not registerd in course." : "Registred in course."; ?></div>
                          </td>
                        </tr>
                      <? endif; ?>
                      <? endforeach; ?>
                      </tbody>
                    </table>

                  </div>
                </div>
                <center>
                <a style="margin-top: 2%; margin-bottom: 3%;" href="<? echo $this->url('lcourses'); ?>" class="btn btn-secondary">See all</a>
                  </center>
              </div>
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Invoices</h3>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                      <thead>
                        <tr>
                          <th class="w-1">#ID</th>
                          <th>Invoice Subject</th>
                          <th>Sender</th>
                          <th>Created at</th>
                          <th>Status</th>
                          <th>Price</th>
                        </tr>
                      </thead>
                      <tbody>
                      <? foreach($invoices as $invoice): ?>
                          <tr>
                            <td><span class="text-muted"><? echo (string)$invoice->_id;?></span></td>
                            <td><? echo $invoice->subject; ?></td>
                            <td>
                              <? echo $invoice->firstname." ".$invoice->lastname; ?>
                            </td>
                            <td>
                              <? echo $invoice->created_at; ?>
                            </td>
                            <td>
                              <? if($invoice->status == "Pending"): ?>
                                <span class="status-icon bg-warning"></span>Pending
                              <? elseif($invoice->status == "Done"): ?>
                                <span class="status-icon bg-success"></span>Done
                              <? endif; ?>  
                            </td>
                            <td><? echo $invoice->sended; ?>DA</td>
                          </tr>
                      <? endforeach; ?>  
                      </tbody>
                    </table>
                  </div>
                </div>
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
    </div>
    <? require "learnerFooter.php"; ?>
  </body>
</html>
