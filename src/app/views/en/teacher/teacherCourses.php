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
    <title><? echo $user->firstname; ?> <? echo $user->lastname; ?> - courses</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <script src="src/app/views/assets/js/require.min.js"></script>
    <script src="src/app/views/assets/js/vendors/jquery-3.2.1.min.js"></script>
    <script src="src/app/views/assets/js/vendors/bootstrap.bundle.min.js"></script>
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
        src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
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
                    <a href="<? echo $this->url('tPanel'); ?>" class="nav-link"><i class="fe fe-activity"></i>Statistics</a>
                  </li>
                  <li class="nav-item">
                    <a href="<? echo $this->url('myCourses'); ?>" class="nav-link active"><i class="fe fe-video"></i>My courses</a>
                  </li>
                  <li class="nav-item">
                    <a href="<? echo $this->url('addCourse'); ?>" class="nav-link"><i class="fe fe-edit"></i>Add course</a>
                  </li>
                  <li class="nav-item">
                    <a href="<? echo $this->url('tAccount'); ?>" class="nav-link"><i class="fe fe-user"></i>My account</a>
                  </li>
                  <li class="nav-item">
                    <a href="<? echo $this->url('chatroom'); ?>" class="nav-link"><i class="fe fe-message-square"></i>Create chat room</a>
                  </li>
                  <li class="nav-item">
                    <a href="<? echo $this->url('share'); ?>" class="nav-link"><i class="fe fe-file"></i>Files share</a>
                  </li>
                  <li class="nav-item">
                    <a href="<? echo $this->url('tSettings'); ?>" class="nav-link"><i class="fe fe-settings"></i>Settings</a>
                  </li>
                  <li class="nav-item">
                    <? if($messages == 0): ?>
                      <a href="<? echo $this->url('messages/1'); ?>" class="nav-link" id="msg"><i class="fe fe-message-circle"></i>Messages&nbsp;<strong>(<span id="msgNumber"> 0 </span>)</strong></a>
                    <? else: ?>
                      <a href="<? echo $this->url('messages/1'); ?>" class="nav-link" id="msg" style="color:green;"><i class="fe fe-message-circle"></i>Messages&nbsp;<strong>(<span id="msgNumber"><? echo $messages; ?></span>)</strong></a>
                    <? endif; ?>
                  </li>
                  <li class="nav-item">
                    <? if($notifications == 0): ?>
                      <a href="<? echo $this->url('notifications/1'); ?>" class="nav-link" id="notf"><i class="fe fe-bell"></i>Notifications&nbsp;<strong>(<span id="notfNumber"> 0 </span>)</strong></a>
                    <? else: ?>
                    <a href="<? echo $this->url('notifications/1'); ?>" class="nav-link" id="msg" style="color:green;"><i class="fe fe-bell"></i>Notifications&nbsp;<strong>(<span id="msgNumber"><? echo $notifications; ?></span>)</strong></a>
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
            <div class="row row-cards row-deck">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">My courses</h3>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                      <thead>
                        <tr>
                          <th class="w-1">#ID</th>
                          <th>Title</th>
                          <th>Videos number</th>
                          <th>Course time</th>
                          <th>Created At</th>
                          <th>Rate</th>
                          <th>Status</th>
                          <th>Takes</th>
                          <th>Profit</th>
                        </tr>
                      </thead>
                      <tbody>
                      <? foreach($courses as $course): ?>
                        <tr>
                          <td><span class="text-muted"><? echo (string)$course->_id; ?></span></td>
                          <td><a href="<? echo $this->url('course'); ?>/<? echo str_replace(' ', '-', $course->title); ?>" class="text-inherit"><? echo $course->title; ?></a></td>
                          <td><? echo $course->videosNumber; ?></td>
                          <td><? echo round($course->courseTime / 60); ?>Minutes.</td>
                          <td><? echo $course->created_at; ?></td>
                          <td>
                          <? echo $courseController->getCourseRate((string)$course->_id, $collection); ?>/10
                          </td>
                          <td>
                            <? if($course->activated == 1): ?>
                              <span class="status-icon bg-success"></span> Activated
                            <? else: ?>  
                              <span class="status-icon bg-danger"></span> Not activated yet
                            <? endif; ?>
                          </td>
                          <td>
                            <? echo $learner = $helper->getTotalCourseLearners($collection, (string) $course->_id); ?>
                          </td>
                          <td>
                          <? echo $learner*$profitFromOneCourse; ?> DA
                          </td>
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
    <? require "teacherFooter.php"; ?>
  </body>
</html>