<? $page =  "addCourse"; require "teacherArabicPanel.php"; ?>
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
            <div  class="alert alert-icon alert-danger" role="alert">
              <p >
                <i><b>يتوجب عليك قرائة شروط و الأحكام الخاصة للدورات :</b></i>
                <a href="<? echo $this->url('terms#courses'); ?>" target="_blank">شروط الإستخدام</a> (الدورات)
              </p>
            </div>
              <fieldset class="form-fieldset">

                <div class="form-group">
                  <label style="float: right;" class="form-label">عنوان الدورة<span class="form-required">*</span></label>
                  <input id="title" name="title" type="text" class="form-control" />
                </div>
                <div class="form-group">
                  <label style="float: right;" class="form-label">وصف شامل للدورة<span class="form-required">*</span></label>
                  <textarea id="description" name="description" class="form-control"></textarea>
                </div>
                <div class="form-group">
                  <label style="float: right;" class="form-label">المهارات التي سيتحصل عليها المٌتعلم<span class="form-required">*</span></label>
                  <textarea id="skillsToGain" name="skillsToGain" class="form-control"></textarea>
                </div>
                <div class="form-group">
                  <label style="float: right;" class="form-label">المهارات المطلوبة من المٌتعلم<span class="form-required">*</span></label>
                  <textarea id="skillsNeeded" name="skillsNeeded" class="form-control"></textarea>
                </div>
                <div class="form-group">
                  <label style="float: right;" class="form-label">عدد مقاطع الفيديو في دورتك<span class="form-required">*</span></label>
                  <input id="videosNumber" name="videosNumber" type="number" min="3" class="form-control" />
                </div>
                <div class="form-group mb-0">
                  <label style="" class="form-label">كلمات مفتاحية (write tag and click ENTER or Add)</label>
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
                    <div style="float: right;" class="form-label">إرفع الدورة <strong style="color:red;" >(لاتقم بضغط مجلد الدورة بل قم بضغط فيديوهات الدورة) (ZIP file) (إمتداد الفيديوهات المسموح : mp4, webm)</strong></div>
                    <div class="custom-file">
                      <input id="courseFolder" type="file" class="custom-file-input" name="coursesFile">
                    <label class="custom-file-label">تصفح</label>
                  </div>
                </div>
                <div class="form-group">
                    <div style="float: right;" class="form-label">إرفع صورة للدورة</div>
                    <div class="custom-file">
                      <input id="courseCover" type="file" class="custom-file-input" name="cover">
                    <label class="custom-file-label">تصفح</label>
                  </div>
                </div>
                <div class="form-group">
                  <label style="float: right;" class="form-label">المجال</label>
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
                  <label style="float: right;" class="form-label">الملفات المرفقة <span class="">*</span></label>
                  <input id="filesLink" placeholder="إذا لم تكن هناك ملفات مرفقة أتركها فارغة" name="filesLink" type="text" class="form-control" />
                </div>
              <div id="progressDiv" style="display: none;" class="alert alert-secondary" role="alert">
                  <div class="progress">
                   <progress id="bar" value="0" max="100" style="width:100%;"></progress>
                  </div>
                <h3 id="status"></h3>
                <p id="loaded"></p>
              </div>
                <input id="send" type="button" value="إضافة"  onclick="upload()" class="btn btn-outline-success">
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
          document.getElementById("loaded").innerHTML = "تم رفعُ "+event.loaded/1000000+" ميجابايت من أصل "+event.total/1000000;
          var percent = (event.loaded / event.total) * 100;
          document.getElementById("bar").value = Math.round(percent);
          document.getElementById("status").innerHTML = Math.round(percent)+"% تم الرفع... الرجاء الإنتضار";
          if (Math.round(percent) == 100) {
            document.getElementById("status").innerHTML = Math.round(percent)+"% تم الرفع, فقط مرحلة أخيرة... ";
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
        var divNotf   =   document.getElementById("success-alert"); 
        divNotf.style.display = "block";
        var msg = JSON.parse(event.data);
        divNotf.innerHTML += "<br/><div class='alert alert-warning'>You have new message from <strong>"+msg.name+"</strong> !</div><br/>";
        document.title = "You have new messages !";
        var lastMsgsNumber = document.getElementById("msgNumber").innerHTML;
        document.getElementById("msgNumber").innerHTML = parseInt(document.getElementById("msgNumber").innerHTML,10)+1;
        document.getElementById("msg").style.color = "green";
        document.getElementById("clear").addEventListener("click", function(e) {  
          document.getElementById("success-alert").innerHTML = "";
          document.getElementById("success-alert").innerHTML = "<button type='button' class='btn btn-primary' id='clear'>Clear all</button><br/><br/>";
          divNotf.style.display = "none";
          document.title = '<? echo $user->firstname; echo " "; echo $user->lastname; echo "- panel";?>';
        });
      };
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
    </script>
    </div>
  </body>
</html>
