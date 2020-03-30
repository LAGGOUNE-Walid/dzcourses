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
    <title><? echo $user->firstname; ?> <? echo $user->lastname; ?> - <? echo $page; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://www.fontstatic.com/f=sky-bold" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <script src="<?php echo $this->url('src/app/views/assets/js/require.min.js');?>"></script>
    <script src="<?php echo $this->url('src/app/views/assets/js/vendors/jquery-3.2.1.min.js');?>"></script>
    <script src="<?php echo $this->url('src/app/views/assets/js/vendors/bootstrap.bundle.min.js');?>"></script>
    <script>
      requirejs.config({
          baseUrl: '<? echo $this->url(""); ?>'
      });
      function copy() {
        var copyText = document.getElementById("link");
        copyText.select();
        document.execCommand("copy");
        alert("Copied the text: " + copyText.value);
      } 
    </script>
    <!-- Dashboard Core -->
    <link href="<?php echo $this->url('src/app/views/assets/css/dashboard.css');?>" rel="stylesheet" />
    <script src="<?php echo $this->url('src/app/views/assets/js/dashboard.js');?>"></script>
    <!-- c3.js Charts Plugin -->
    <link href="<?php echo $this->url('src/app/views/assets/plugins/charts-c3/plugin.css');?>" rel="stylesheet" />
    <script src="<?php echo $this->url('src/app/views/assets/plugins/charts-c3/plugin.js');?>"></script>
    <!-- Google Maps Plugin -->
    <link href="<?php echo $this->url('src/app/views/assets/plugins/maps-google/plugin.css');?>" rel="stylesheet" />
    <script src="<?php echo $this->url('src/app/views/assets/plugins/maps-google/plugin.js');?>"></script>
    <!-- Input Mask Plugin -->
    <script src="<?php echo $this->url('src/app/views/assets/plugins/input-mask/plugin.js');?>"></script>
    <script
        src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
  </head>
  <body class="" style="font-family: 'sky-bold'; direction: rtl;">
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
        <div  class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-lg order-lg-first">
                <ul style="width: 105%;" class="nav nav-tabs border-0 flex-column flex-lg-row">
                  <li class="nav-item">
                    <a href="<? echo $this->url('tPanel'); ?>" class="nav-link <? if($page == 'panel'){ echo 'active'; } ?>"><i class="fe fe-activity"></i>&nbsp;الإحصائيات</a>
                  </li>
                  <li class="nav-item">
                    <a href="<? echo $this->url('myCourses'); ?>" class="nav-link <? if($page == 'courses'){ echo 'active'; } ?>"><i class="fe fe-video"></i>&nbsp;دوراتي</a>
                  </li>
                  <li class="nav-item">
                    <a href="<? echo $this->url('addCourse'); ?>" class="nav-link <? if($page == 'addCourse'){ echo 'active'; } ?>"><i class="fe fe-edit"></i>&nbsp;أضف دورة</a>
                  </li>
                  <li class="nav-item">
                    <a href="<? echo $this->url('tAccount'); ?>" class="nav-link <? if($page == 'account'){ echo 'active'; } ?>"><i class="fe fe-user"></i>&nbsp;حسابي</a>
                  </li>
                  <li class="nav-item">
                    <a href="<? echo $this->url('chatroom'); ?>" class="nav-link <? if($page == 'chatroom'){ echo 'active'; } ?>"><i class="fe fe-message-square"></i>&nbsp;أنشئ غرفة دردشة</a>
                  </li>
                  <li class="nav-item">
                    <a href="<? echo $this->url('share'); ?>" class="nav-link <? if($page == 'share'){ echo 'active'; } ?>"><i class="fe fe-file"></i>&nbsp;مشاركة الملفات</a>
                  </li>
                  <li class="nav-item">
                    <a href="<? echo $this->url('tSettings'); ?>" class="nav-link <? if($page == 'settings'){ echo 'active'; } ?>"><i class="fe fe-settings"></i>&nbsp;الإعدادات</a>
                  </li>
                  <li class="nav-item">
                    <? if(is_int($messages) AND $messages == 0 OR isset($count) AND $count == 0): ?>
                      <a href="<? echo $this->url('messages/1'); ?>" class="nav-link <? if($page == 'messages'){ echo 'active'; } ?>" id="msg"><i class="fe fe-message-circle"></i>&nbsp;الرسائل&nbsp;<strong>(<span id="msgNumber"> 0 </span>)</strong></a>
                    <? else: ?>
                      <a href="<? echo $this->url('messages/1'); ?>" class="nav-link <? if($page == 'messages'){ echo 'active'; } ?>" id="msg" style="color:green;"><i class="fe fe-message-circle"></i>&nbsp;الرسائل&nbsp;<strong>(<span id="msgNumber"><? 
                      if (is_int($messages)) {
                        echo $messages;
                      }elseif(isset($count)) {
                        echo $count;
                      }
                     ?></span>)</strong></a>
                    <? endif; ?>
                  </li>
                  <li class="nav-item">
                    <? if(is_int($notifications) AND $notifications == 0 OR isset($countN) AND $countN == 0): ?>
                      <a href="<? echo $this->url('notifications/1'); ?>" class="nav-link <? if($page == 'notifications'){ echo 'active'; } ?>" id="notf"><i class="fe fe-bell"></i>&nbsp;الإشعارات&nbsp;<strong>(<span id="notfNumber"> 0 </span>)</strong></a>
                    <? else: ?>
                    <a href="<? echo $this->url('notifications/1'); ?>" class="nav-link <? if($page == 'notifications'){ echo 'active'; } ?>" id="msg" style="color:green;"><i class="fe fe-bell"></i>&nbsp;الإشعارات&nbsp;<strong>(<span id="msgNumber"><?if(is_int($notifications)) {echo $notifications;}elseif (isset($countN)) {echo $countN;}?></span>)</strong></a>
                    <?endif;?>  
                  </li>
                  <li class="nav-item">
                    <form method="POST" action="<? echo $this->url('logout'); ?>">
                      <input type="hidden" name="_token" value="<? echo $token; ?>">
                      <input type="hidden" name="id" value="<? echo $user->_id; ?>">
                      <button type="submit" class="btn btn-link"><i class="fe fe-log-out"></i> &nbsp; خروج</button>
                    </form>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>