<script type="text/javascript">
requirejs.config({
          baseUrl: '<? echo $this->url(""); ?>'
      });
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
    </script>