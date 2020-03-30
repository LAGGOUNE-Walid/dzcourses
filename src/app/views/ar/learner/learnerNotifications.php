<? $page = "notifications"; require "learnerArabicPanel.php"; ?>
              <input type="hidden" id="to" value="<? echo (string) $user->_id; ?>">

    <div class="page">
      <div class="page-main">
        <div class="header py-8">
          <div class="container">
            <? if($notifications !== 0): ?>
              <span class="badge badge-primary">Total : <? echo $allNotfsCount; ?></span>
              <divclass="col-lg-16" style=" padding:5%;"> 
              <div style="display: none;" id="success-alert">
                <button type='button' class='btn btn-primary' id="clear">Clear all</button><br/><br/>
              </div>
              <div id="messages">
              </div>
                <? foreach($notifications as $notification): ?>
                  <div class="alert alert-dark" role="alert"><p><? echo ($notification->notification); ?>
                  <? if(isset($notification->code)):  ?>
                      click <a href="<? echo $this->url('cobone'); ?>">here</a> to use it.
                  <? endif; ?>
                  </p> <br/><span class="badge badge-secondary"><? echo $notification->created_at; ?></span>
                  </div><br/>
                <? endforeach; ?> 
              <? else: ?>
              <div class="alert alert-dark" role="alert">
                <strong>DZ-COURSES bot :</strong><p> No notifications yet :( </p>
              </div>
              <? endif; ?>   
                  <ul class="pagination pagination-sm">
                    <? foreach($pages as $page): ?>
                      <li class="page-item"><a class="page-link" href="<? echo $this->url("lNotifications");?>/<? echo $page; ?>"><? echo $page; ?></a></li>
                    <? endforeach; ?>
                  </ul>
              </div>

          </div>
        </div>
       </div>
      </div> 
<? require "learnerArabicFooter.php"; ?>