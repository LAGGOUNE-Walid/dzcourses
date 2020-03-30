<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="image/png" href="<?php echo $this->url('src/app/views/images/logo2.jpg');?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><? echo $roomName; ?></title>
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/css/chatroomstyle.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('src/app/views/assets/bootstrap/css/bootstrap.min.css');?>">
</head>

<body>
	<input id="userId" type="hidden" name="userId" value="<? echo $userId; ?>">
    <input id="cryptedToken" type="hidden" name="cryptedToken" value="<? echo $cryptedToken; ?>">
    <input id="roomId" type="hidden" name="roomId" value="<? echo $roomId; ?>">
    <input id="firstname" type="hidden" name="firstname" value="<? echo $user->firstname; ?>">
    <input id="lastname" type="hidden" name="lastname" value="<? echo $user->lastname; ?>">
    <input id="image" type="hidden" name="image" value="<? echo $this->url("").$user->photo; ?>">
    <script type="text/javascript">
        var conn            =   new WebSocket('ws://127.0.0.1:5785');
        var userId          =   document.getElementById("userId").value;
        var cryptedToken    =   document.getElementById("cryptedToken").value;
        var roomId          =   document.getElementById("roomId").value;
        conn.onopen = function(e) {
            conn.send(JSON.stringify({
                type          : "checkIdentity", 
                cryptedToken  : cryptedToken,
                roomId         : roomId,
                userId        : userId
            }));
            conn.send(JSON.stringify({
                type          :     "getInfo", 
                cryptedToken  :     cryptedToken,
                roomId        :     roomId,
                userId        :     userId
            }));

        };
        conn.onmessage = function(event) {
            var data             =   JSON.parse(event.data);
            if ("onlineUsers" in data) {
                document.getElementById("number").innerHTML = "Online : "+data.onlineUsers;
            }else {
                document.title      =   "New message";
                var messages        =   document.getElementById("messages");
                var audio = new Audio('<?echo $this->url("");?>src/app/views/en/message.mp3');
                audio.play();
                messages.innerHTML +=  '<div id="reciver" style="padding: 1%;margin-top: 1%;width: 80%;"><h3>'+data.firstname+' '+data.lastname+'<img class="rounded-circle img-fluid" src="'+data.image+'" style="width: 30px;">&nbsp;:</h3><p>'+data.message+'</p></div>';
                    var objDiv = document.getElementById("main");
                    objDiv.scrollTop = objDiv.scrollHeight;
                
                document.onmousemove = function(){
                    var title = "<? echo $roomName; ?>";
                    document.title = title;
                }
            }    
      };
        conn.onclose = function (event) {
            alert("Please try to refresh the page, or try again another time ... It maybe : error when connecting to our server OR You are not allowed to see this chatroom");
            window.location.href="about:blank";
        };

        function send() {
            var firstname       =   document.getElementById("firstname").value;
            var lastname        =   document.getElementById("lastname").value;
            var image           =   document.getElementById("image").value;
            var message         =   document.getElementById("message").value
            conn.send(JSON.stringify({
              type          : "message" , 
              roomId        : roomId,
              userId        :  userId, 
              firstname     : firstname,
              lastname      : lastname,
              image         : image,
              message       : message
            }));
            messages.innerHTML +=  '<div id="sender" style="padding: 1%;margin-top: 1%;width: 80%;margin-left: 20%;"><h3>'+firstname+' '+lastname+' <img class="rounded-circle img-fluid" src="'+image+'" style="width: 30px;">&nbsp;:</h3><p>'+message+'</p></div>';
                var objDiv = document.getElementById("main");
                objDiv.scrollTop = objDiv.scrollHeight;
            var message         =   document.getElementById("message");
            message.value = "";
      }

    </script>
    <div class="border-dark flex-column" style="padding: 2%;">
        <ul class="list-inline text-center">
           <a href="<? echo $this->url(""); ?>"><li class="list-inline-item float-left">Dz-courses</li></a>
            <li class="list-inline-item"><? echo $roomName; ?></li>
            <a href="<? echo $this->url('p').'/'.(string)$createdBy->_id; ?>"><li class="list-inline-item float-right">Created By : <? echo $createdBy->firstname." ".$createdBy->lastname ?></li></a>
        </ul>
    </div>
    <div id="main" style="margin-top: 1%;padding: 0;height: 600px;">
        <div class="float-left" id="onlineUsers" style="padding: 1%;height: 100%;width: 20%;min-width: 20%;max-width: 20%;">
            <h3 id="number">Online : 0</h3>
            
        </div>
        <div class="float-right" id="messages" style="width: 80%;height: 100%;">
        <? foreach($messages as $message): ?>
            <? if($message->userId == $userId): ?>
                <div class="border-dark d-block" id="sender" style="padding: 1%;margin-top: 1%;width: 80%;margin-left: 20%;">
                    <h3><? echo $message->firstname; ?> <? echo $message->lastname; ?><img class="rounded-circle img-fluid" src="<? echo $message->image; ?>" style="width: 30px;">&nbsp;:</h3>
                    <p><strong><? echo $message->message; ?></strong></p>
                </div>
            <? else: ?>
                <div id="reciver" style="padding: 1%;margin-top: 1%;width: 80%;"><h3><? echo $message->firstname; ?> <? echo $message->lastname; ?><img class="rounded-circle img-fluid" src="<? echo $message->image; ?>" style="width: 30px;">&nbsp;:</h3><p><? echo $message->message; ?></p></div>
            <? endif; ?>
        <? endforeach; ?>
            </div>
        </div>
    </div>
    <div style="margin-bottom: 5%;   margin-top: 1%; width: 80%; margin-left: 10%; margin-right: 10%;">
        <div class="form-group">
          <textarea id="message" class="form-control" id="exampleFormControlTextarea3" rows="7"></textarea>
          <br/>
          <button id="button" onclick="send()" type="button" class="btn btn-dark">send</button>
        </div>
    </div>
    <script src="<?php echo $this->url('src/app/views/assets/js/jquery.min.js');?>"></script>
    <script src="<?php echo $this->url('src/app/views/assets/bootstrap/js/bootstrap.min.js');?>"></script>
    <script type="text/javascript">
        window.onload=function () {
             var objDiv = document.getElementById("main");
             objDiv.scrollTop = objDiv.scrollHeight;
        }
    </script>
</body>

</html>
