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
    <link rel="icon" href="<? echo $this->url('').$user->photo; ?>" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/png" href="<? echo $this->url('').$user->photo; ?>"/>
    <title><? echo $user->firstname; ?> <? echo $user->lastname; ?> - messages</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <script src="<?php echo $this->url('src/app/views/assets/js/require.min.js');?>"></script>
    <script src="<?php echo $this->url('src/app/views/assets/js/vendors/jquery-3.2.1.min.js');?>"></script>
    <script src="<?php echo $this->url('src/app/views/assets/js/vendors/jquery-3.2.1.min.js');?>"></script>
    <script src="<?php echo $this->url('src/app/views/assets/js/vendors/bootstrap.bundle.min.js');?>"></script>

    <script>
      function copy() {
        var copyText = document.getElementById("link");
        copyText.select();
        document.execCommand("copy");
        alert("Copied the text: " + copyText.value);
      } 
    </script>
    <!-- Dashboard Core -->
    <link href="<?php echo $this->url('src/app/views/assets/css/dashboard.css')?>" rel="stylesheet" />
    <script src="<?php echo $this->url('src/app/views/assets/js/dashboard.js')?>"></script>
    <!-- c3.js Charts Plugin -->
    <link href="<?php echo $this->url('src/app/views/assets/plugins/charts-c3/plugin.css')?>" rel="stylesheet" />
    <script src="<?php echo $this->url('src/app/views/assets/plugins/charts-c3/plugin.js')?>"></script>
    <!-- Google Maps Plugin -->
    <link href="<?php echo $this->url('src/app/views/assets/plugins/maps-google/plugin.css')?>" rel="stylesheet" />
    <script src="<?php echo $this->url('src/app/views/assets/plugins/maps-google/plugin.js')?>"></script>
    <!-- Input Mask Plugin -->
    <script src="<?php echo $this->url('src/app/views/assets/plugins/input-mask/plugin.js')?>"></script>
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
                    <a href="<? echo $this->url('lAccount'); ?>" class="nav-link"><i class="fe fe-user"></i>My account</a>
                  </li>
                  <li class="nav-item">
                    <a href="<? echo $this->url('lSettings'); ?>" class="nav-link"><i class="fe fe-settings"></i>Settings</a>
                  </li>
                  <li class="nav-item">
                    <? if($count == 0): ?>
                      <a href="<? echo $this->url('lmessages/1'); ?>" class="nav-link active" id="msg"><i class="fe fe-message-circle"></i>Messages&nbsp;<strong>(<span id="msgNumber"> 0 </span>)</strong></a>
                    <? else: ?>
                      <a href="<? echo $this->url('lmessages/1'); ?>" class="nav-link active" id="msg" style="color:green;"><i class="fe fe-message-circle"></i>Messages&nbsp;<strong>(<span id="msgNumber"><? echo $count; ?></span>)</strong></a>
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
            <? if($messages !== 0): ?>
              <span class="badge badge-primary">Total : <? echo $allMsgsCount; ?></span>
              <divclass="col-lg-16" style=" padding:5%;"> 
              <div style="display: none;" id="success-alert">
                <button type='button' class='btn btn-primary' id="clear">Clear all</button><br/><br/>
              </div>
              <div id="messages">
              </div>
                <? foreach($messages as $message): ?>
                  <div class="alert alert-dark" role="alert">
                    <strong><? echo strip_tags($message->from); ?></strong> :<p><? echo strip_tags($message->message); ?></p> <br/><strong><a href="mailto:<? echo $message->email; ?>"><? echo strip_tags($message->email); ?></a></strong> <span class="badge badge-secondary"><? echo $message->date; ?></span>
                  </div><br/>
                <? endforeach; ?> 
              <? else: ?>
              <div class="alert alert-dark" role="alert">
                <strong>DZ-COURSES bot :</strong><p> No messages yet :( </p>
              </div>
              <? endif; ?>   
                  <ul class="pagination pagination-sm">
                    <? foreach($pages as $page): ?>
                      <li class="page-item"><a class="page-link" href="<? echo $this->url("lmessages");?>/<? echo $page; ?>"><? echo $page; ?></a></li>
                    <? endforeach; ?>
                  </ul>
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
    <script type="text/javascript">
      var id        =   document.getElementById("to").value;
      var conn = new WebSocket('ws://127.0.0.1:5784');
      conn.onopen = function(e) {
          console.log("Connection established!");
          conn.send(JSON.stringify({
            client : id,
            type : "MessageClient"
          }));
      };
      conn.onmessage = function(event) {
        var divMsg    =   document.getElementById("success-alert");
        var messages   =  document.getElementById("messages");
        divMsg.style.display = "block";
        var msg = JSON.parse(event.data);
        divMsg.innerHTML += "<br/><div class='alert alert-warning'>You have new message from <strong>"+msg.name+"</strong> !</div><br/>";
        messages.innerHTML += "<br/><div style='border:1px solid green;' id='messages' class='alert alert-dark' role='alert'><strong>"+msg.name+"</strong> :<p>"+msg.message+"</p> <br/><strong><a href='mailto:"+msg.email+"'>"+msg.email+"</a></strong> <span class='badge badge-secondary'>now</span></div><br/>";

        document.title = "You have new messages !";
        var lastMsgsNumber = document.getElementById("msgNumber").innerHTML;
        document.getElementById("msgNumber").innerHTML = parseInt(document.getElementById("msgNumber").innerHTML,10)+1;
        document.getElementById("msg").style.color = "green";

        document.getElementById("clear").addEventListener("click", function(e) {  
          document.getElementById("success-alert").innerHTML = "";
          document.getElementById("success-alert").innerHTML = "<button type='button' class='btn btn-primary' id='clear'>Clear all</button><br/><br/>";
          divMsg.style.display = "none";
          document.title = '<? echo $user->firstname; echo " "; echo $user->lastname; echo "- panel";?>';
        });

      };
    </script>
    </div>
  </body>
</html>
