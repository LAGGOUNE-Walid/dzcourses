<? $page = "messages"; require "teacherArabicPanel.php"; ?>
        <br/>
              <input type="hidden" id="to" value="<? echo (string) $user->_id; ?>">

    <div class="page">
      <div class="page-main">
        <div class="header py-8">
          <div class="container">

            <? if($allMsgsCount != 0): ?>
              <span class="badge badge-primary">الكل : <? echo $allMsgsCount; ?></span>
              <divc lass="col-lg-16" style=" padding:5%;"> 
              <div style="display: none;" id="success-alert">
                <button type='button' class='btn btn-primary' id="clear">مسح</button><br/><br/>
              </div>
              <div id="messages">
              </div>
                <? foreach($messages as $message): ?>
                  <div style="direction: ltr;" class="alert alert-dark" role="alert">
                    <strong><? echo strip_tags($message->from); ?></strong> :<p><? echo strip_tags($message->message); ?></p> <br/><strong><a href="mailto:<? echo $message->email; ?>"><? echo strip_tags($message->email); ?></a></strong> <span class="badge badge-secondary"><? echo $message->date; ?></span>
                  </div><br/>
                <? endforeach; ?> 
              <? else: ?>
              <div class="alert alert-dark" role="alert">
                <strong>DZ-COURSES bot :</strong><p> ليست هناك رسائل :( </p>
              </div>
              <? endif; ?>   
                  <ul class="pagination pagination-sm">
                    <? foreach($pages as $page): ?>
                      <li class="page-item"><a class="page-link" href="<? echo $this->url("messages");?>/<? echo $page; ?>"><? echo $page; ?></a></li>
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
