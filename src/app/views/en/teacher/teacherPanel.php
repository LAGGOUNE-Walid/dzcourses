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
                    <a href="<? echo $this->url('tPanel'); ?>" class="nav-link active"><i class="fe fe-activity"></i>Statistics</a>
                  </li>
                  <li class="nav-item">
                    <a href="<? echo $this->url('myCourses'); ?>" class="nav-link"><i class="fe fe-video"></i>My courses</a>
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
            <div class="page-header">
              <h1 class="page-title">
                Dashboard
              </h1>
            </div>
            <div style="display: none;" id="success-alert">
              <button type='button' class='btn btn-primary' id="clear">Clear all</button><br/><br/>
            </div>
            <div class="row row-cards">
              <div class="col-6 col-sm-4 col-lg-2">

                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="h1 m-0"><? echo $courses; ?></div>
                    <div class="text-muted mb-4">Your courses</div>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <?
                    $total = 0;
                    foreach($money as $mo) { 
                      $month = explode("/", $mo->created_at);
                      $month = $month[1];
                        if ($month == $date->month) {
                          $total = $mo->money;
                        }
                    }
                    ?>
                    <div class="h1 m-0"><? echo $total; ?> Da</div>
                    <div class="text-muted mb-4">Profit in this month</div>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="card">
                      <div class="card-header">
                      <? if($visits !== null): ?>
                        <? $date = explode("/", $visits->created_at); ?>
                          <h3 class="card-title">Total visits in <? echo $date[0]; ?> </h3>
                        <? else: ?>  
                        <h3 class="card-title">No visits yet. </h3>
                      <? endif; ?>
                      </div>
                      <div class="card-body">
                        <div id="chart-donut" style="height: 20rem;"></div>
                      </div>
                    </div>
                    <script>
                      require(['c3', 'jquery'], function(c3, $) {
                        $(document).ready(function(){
                          var chart = c3.generate({
                            bindto: '#chart-donut', // id of chart wrapper
                            data: {
                              columns: [
                                ['data1', <? echo ($visits===null) ? 0 : $visits->profileVisits; ?>],
                                ['data2',  <? echo ($visits===null) ? 0 : $visits->coursesVisits; ?>],
                                ['data3',  <? echo ($takes==0) ? 0 : $takes; ?>],
                              ],
                              type: 'donut', // default type of chart
                              colors: {
                                'data1': tabler.colors["blue"],
                                'data2': 'green',
                                'data3': tabler.colors["red"],
                              },
                              names: {
                                'data1': 'Profile page visits',
                                'data2': 'Courses pages visits',
                                'data3': 'Courses taken',
                              }
                            },
                            axis: {
                            },
                            legend: {
                                      show: true, //hide legend
                                      position: 'right'

                            },
                            padding: {

                            },
                          });
                        });
                      });
                    </script>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-6">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-green mr-3">
                      <i class="fe fe-video"></i>
                    </span>
                    <div>
                      <h4 class="m-0"><a href="javascript:void(0)"><? echo ($visits === null) ? "0" : $visits->coursesVisits; ?> <small>Courses Visits</small></a></h4>
                    </div>
                  </div>
                </div>
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-red mr-3">
                      <i class="fe fe-book"></i>
                    </span>
                    <div>
                      <h4 class="m-0"><a href="javascript:void(0)"><? echo ($takes == 0) ? "0" : $takes ; ?> <small>Courses taken</small></a></h4>
                    </div>
                  </div>
                </div>
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-blue mr-3">
                      <i class="fe fe-user"></i>
                    </span>
                    <div>
                      <h4 class="m-0"><a href="javascript:void(0)"><? echo ($visits === null) ? "0" : $visits->profileVisits ; ?><small> Profile page visits</small></a></h4>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="card">
                      <div class="card-header">
                      <? if($visits !== null): ?>
                        <? $date = explode("/", $visits->created_at); ?>
                          <h3 class="card-title">Money tracker in <? echo $date[0]; ?> </h3>
                          <hr/> 
                        <? else: ?>  
                        <h3 class="card-title">No Money yet. </h3>
                      <? endif; ?>
                      </div>
                      <div class="card-body">
                        <div id="chart-spline" style="height: 20rem;"></div>
                      </div>
                    </div>
                    <script>
                      require(['c3', 'jquery'], function(c3, $) {
                        $(document).ready(function(){
                          var chart = c3.generate({
                            bindto: '#chart-spline', // id of chart wrapper
                            data: {
                              columns: [
                                ['Total', <? foreach($money as $m) { echo $m->money.","; } ?> ],
                              ],
                              type: 'line', // default type of chart
                              colors: {
                                'Total': tabler.colors["orange"],
                              },
                            },
                            axis: {
                              y: {
                                  label: 'DA'
                              },
                              x: {
                                    type: 'category',
                                    categories: [<? foreach($money as $m) { echo "'".$m->created_at."',"; } ?>]
                                }
                            },
                            legend: {
                                      show: false, //hide legend

                            },
                            padding: {

                            },
                          });
                        });
                      });
                    </script>
                  </div>

                </div>
              </div>
              <div class="col-sm-6 col-lg-6">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-orange mr-3">
                      <i class="fe fe-dollar-sign"></i>
                    </span>
                    <div>
                      <h4 class="m-0"><a href="javascript:void(0)"><? echo $allMoney; ?> DA <small>you collected from your courses !</small></a></h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <h3>Latest comments in your courses : </h3>
              <div class="row row-cards row-deck">
                <? if(!$comments->isDead()): ?>
                  <? foreach($comments as $comment): ?>
                  <? $user = $collection->learners->findOne(["_id" =>  new MongoDB\BSON\ObjectId($comment->user_id)]); ?>
                   <? if (is_null($user)) : $user = $collection->users->findOne(["_id" => new MongoDB\BSON\ObjectId($comment->user_id)]); endif; ?>
                  <? $course  = $collection->courses->findOne(["_id" => new MongoDB\BSON\ObjectId($comment->course_id)]); ?>
                    <div class="col-lg-6">
                      <div class="card card-aside">
                        <a href="#" class="card-aside-column" style="background-image: url(<? echo $user->photo; ?>)"></a>
                        <div class="card-body d-flex flex-column">
                          <div class="text-muted"><? echo $comment->comment; ?></div>
                          <div class="d-flex align-items-center pt-5 mt-auto">
                            <div>
                              <a href="<? echo $this->url('p').'/'.$comment->user_id; ?>" class="text-default"><? echo $user->firstname." ".$user->lastname; ?></a> in <a href="<? echo $this->url('course'); ?>/<? echo str_replace(' ', '-', $course->title); ?>"><? echo $course->title; ?></a>
                              <small class="d-block text-muted"><? echo $comment->created_at; ?></small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <? endforeach; ?>  
                <? else: ?>
                    <p>There is no comments yet</p>
                <? endif; ?>  
              </div>
            <div class="row row-cards row-deck">
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
                          <th>Total</th>
                          <th>From</th>
                          <th>To</th>
                          <th>To (CCP)</th>
                          <th>Images</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                      <? foreach($invoices as $invoice): ?>
                          <tr>
                            <td><span class="text-muted"><? echo (string)$invoice->_id ?></span></td>
                            <td><? echo $invoice->sum; ?>DA</td>
                            <td><? echo $dzcoursesCCP; ?></td>
                            <? $user = $collection->users->findOne(["_id" =>  new MongoDB\BSON\ObjectId($invoice->to)]); ?>
                            <td><? echo $user->firstname." ".$user->lastname; ?></td>
                            <td><? echo $user->ccp; ?></td>
                            <td>
                            <a href="<? echo $this->url('getImage/').$invoice->image1; ?>">Image1</a>
                            /
                            <a href="<? echo $this->url('getImage/').$invoice->image2; ?>">Image2</a>
                            /
                            <a href="<? echo $this->url('getImage/').$invoice->image3; ?>">Image3</a>
                            </td>
                            <td><? echo $invoice->created_at; ?></td>
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