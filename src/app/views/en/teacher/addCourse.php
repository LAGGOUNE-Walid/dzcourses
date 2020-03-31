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
    <script src="src/app/views/assets/js/vendors/jquery-3.2.1.min.js"></script>
    <script src="src/app/views/assets/js/vendors/bootstrap.bundle.min.js"></script>

    <script>
      function copy() {
        var copyText = document.getElementById("link");
        copyText.select();
        document.execCommand("copy");
        alert("Copied the text: " + copyText.value);
      } 
    </script>
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
                    <a href="<? echo $this->url('tPanel'); ?>" class="nav-link"><i class="fe fe-activity"></i>Statistics</a>
                  </li>
                  <li class="nav-item">
                    <a href="<? echo $this->url('myCourses'); ?>" class="nav-link"><i class="fe fe-video"></i>My courses</a>
                  </li>
                  <li class="nav-item">
                    <a href="<? echo $this->url('addCourse'); ?>" class="nav-link active"><i class="fe fe-edit"></i>Add course</a>
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
                      <input type="hidden" name="id" value="<? echo $user->_id; ?>">
                      <input type="hidden" name="_token" value="<? echo $token; ?>">
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
            
            <form id="form" method="POST" enctype="multipart/form-data">
            <? if(isset($errors)): ?>
            <div style="border: 2px solid red;" class="alert alert-icon alert-danger" role="alert">
              <? foreach($errors as $input => $error): ?>
                  - <? echo $error; ?> in <? echo $input; ?> !<br/>
              <? endforeach; ?>
            </div>
          <? endif; ?>
          <? if(isset($err)): ?>
            <div style="border: 2px solid red;" class="alert alert-icon alert-danger" role="alert">
                <? echo $err; ?>
            </div>
          <? endif; ?>
          <? if(isset($suc)): ?>
            <div class="alert alert-success" role="alert">
              <? echo $suc; ?>
            </div>
          <? endif; ?>
            <div class="alert alert-icon alert-danger" role="alert">
              <p>
                <i><b>You must read this before you upload your course :</b></i>
                <a href="<? echo $this->url('terms#courses'); ?>" target="_blank">Terms of use</a> (Courses)
              </p>
            </div>
              <fieldset class="form-fieldset">

                <div class="form-group">
                  <label class="form-label">Course title<span class="form-required">*</span></label>
                  <input id="title" name="title" type="text" class="form-control" />
                </div>
                <div class="form-group">
                  <label class="form-label">Description of course<span class="form-required">*</span></label>
                  <textarea id="description" name="description" class="form-control"></textarea>
                </div>
                <div class="form-group">
                  <label class="form-label">Skills that the learner will gain<span class="form-required">*</span></label>
                  <textarea id="skillsToGain" name="skillsToGain" class="form-control"></textarea>
                </div>
                <div class="form-group">
                  <label class="form-label">Skills needed from the learner<span class="form-required">*</span></label>
                  <textarea id="skillsNeeded" name="skillsNeeded" class="form-control"></textarea>
                </div>
                <div class="form-group">
                  <label class="form-label">Course videos number<span class="form-required">*</span></label>
                  <input id="videosNumber" name="videosNumber" type="number" min="3" class="form-control" />
                </div>
                <div class="form-group mb-0">
                  <label class="form-label">tags (write tag and click ENTER or Add)</label>
                    <div class="input-group-prepend">
                    <input id="tag" type="text" class="form-control" placeholder="write tags here ..." >
                    <span class="input-group-append" id="basic-addon2">
                      <span class="input-group-text">
                        <a id="addTag" class="btn btn-outline-secondary">Add</a>
                      </span>
                    </span>
                  </div>
                </div>
                <br>
                <div class="form-group mb-0">
                  <input name="tags" id="tags" type="text" class="form-control"/>
                </div>
                <br/>
                <div class="form-group">
                    <div class="form-label">Upload your courses <strong style="color:red">(Do not zip your videos folder . Zip all your videos and upload it) (Allowed videos formats : mp4, webm)</strong></div>
                    <br/>
                    <div id="courseLabel"></div>
                    <div class="custom-file">
                      <input id="courseFolder" onchange="imageName(this, 'courseLabel')" type="file" class="custom-file-input" name="coursesFile">
                    <label class="custom-file-label">Upload</label>
                  </div>
                </div>
                <div class="form-group">
                    <div class="form-label">Upload a cover </div>
                    <br/>
                    <div id="coverLabel"></div>
                    <div class="custom-file">
                      <input id="courseCover" onchange="imageName(this, 'coverLabel')" type="file" class="custom-file-input" name="cover">
                    <label class="custom-file-label">Upload</label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="form-label">Category</label>
                    <select id="category" name="category" id="select-beast" class="form-control custom-select">
                      <option value="IT">Computer science</option>
                      <option value="Math_and_logic">Math and logic</option>
                      <option value="Physics">Physics</option>
                      <option value="Languages">Languages</option>
                      <option value="Science">Science </option>
                      <option value="Health">Health</option>
                      <option value="Arts_and_Humanities">Arts and Humanities</option>
                      <option value="Business">Business</option>
                      <option value="Lifestyle">Lifestyle</option>
                      <option value="Personal_Development">Personal Development</option>
                      <option value="Skills">Skills</option>
                      <option value="Other">Other ...</option>
                    </select>
                </div>
                <input name="_token" value="<? echo $token; ?>" type="hidden">
                 <div class="form-group">
                  <label class="form-label">Attached files <span class="">*</span></label>
                  <input id="filesLink" placeholder="If there is no attached files, leave it empty." name="filesLink" type="text" class="form-control" />
                </div>
              <div id="progressDiv" style="display: none;" class="alert alert-secondary" role="alert">
                  <div class="progress">
                   <progress id="bar" value="0" max="100" style="width:100%;"></progress>
                  </div>
                <h3 id="status"></h3>
                <p id="loaded"></p>
              </div>
                <input id="send" type="button" value="Send"  onclick="upload()" class="btn btn-outline-success">
              </fieldset>

            </form>

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
    <? require "teacherFooter.php"; ?>
    <script type="text/javascript">

      function upload() {
        var progressDiv     =   document.getElementById("progressDiv");
        progressDiv.style.display = "block";
        var courseFolder    =   document.getElementById("courseFolder").files[0];
        var courseCover     =   document.getElementById("courseCover").files[0];
        var formData        =    new FormData(form);
        formData.append("coursesFile", courseFolder);
        formData.append("title",  document.getElementById("title").value);
        formData.append("description",  document.getElementById("description").value);
        formData.append("skillsToGain",  document.getElementById("skillsToGain").value);
        formData.append("skillsNeeded",  document.getElementById("skillsNeeded").value);
        formData.append("videosNumber",  document.getElementById("videosNumber").value);
        formData.append("filesLink",  document.getElementById("filesLink").value);
        formData.append("tags",  document.getElementById("tags").value);
        formData.append("category",  document.getElementById("category").value);
        formData.append("courseCover", courseCover);

        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "<? echo $this->url('postCourse'); ?>");
        ajax.send(formData);
	 document.getElementById("send").disabled = true; 
      }

      function progressHandler(event){
          document.getElementById("loaded").innerHTML = "Uploaded "+event.loaded/1000000+" megabytes of "+event.total/1000000;
          var percent = (event.loaded / event.total) * 100;
          document.getElementById("bar").value = Math.round(percent);
          document.getElementById("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
          if (Math.round(percent) == 100) {
            document.getElementById("status").innerHTML = Math.round(percent)+"% uploaded, just one more step ... ";
          }
        }
        function completeHandler(event){
          document.getElementById("status").innerHTML = event.target.responseText;
          document.getElementById("bar").value = 0;
	 document.getElementById("send").disabled = false; 
        }
        function errorHandler(event){
          document.getElementById("status").innerHTML = "Upload Failed";
        }
        function abortHandler(event){
          document.getElementById("status").innerHTML = "Upload Aborted";
        }
      
      document.getElementById("addTag").addEventListener("click", function(e) { 
          document.getElementById("tags").value += document.getElementById("tag").value+",";
          document.getElementById("tag").value = "";
      }); 

      document.getElementById('tag').onkeypress = function(e){
        if (!e) e = window.event;
        var keyCode = e.keyCode || e.which;
        if (keyCode == '13'){
            document.getElementById("tags").value += document.getElementById("tag").value+",";
          document.getElementById("tag").value = "";
        }
      }
      document.getElementById('form').onkeypress = function(e){
            var keyCode = e.keyCode || e.which;
            if (keyCode == '13'){
              return false;
            }
      }
      function imageName(fileInput, label) {
        var filename = fileInput.files[0].name;
        document.getElementById(label).innerHTML = filename;
      }
    </script>
    </div>
  </body>
</html>
