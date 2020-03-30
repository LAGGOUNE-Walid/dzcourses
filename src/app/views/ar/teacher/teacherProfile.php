<? $page = "account"; require "teacherArabicPanel.php"; ?>
              <input type="hidden" id="to" value="<? echo (string) $user->_id; ?>">

    <div class="page">
      <div class="page-main">
        <div class="header py-8">
          <div class="container">
              <div class="col-lg-8" style="margin-left: 15%; margin-right: 15%;"> 
              <div style="display: none;" id="success-alert">
              <button type='button' class='btn btn-primary' id="clear">مسح</button><br/><br/>
            </div>
                <div class="card card-profile">
                  <div class="card-body text-center">
                  <div class="card-header" style="background-image: url(src/app/views/images/teacher.jpg); height: 300px;" ></div>
                    <img style="width: 150px; height: 150px; position: relative; margin-top: -8%;  border-radius: 10px;" src="<? echo $user->photo; ?>">

                    <h3 class="mb-3" style="margin-top: 5%;"><? echo $user->firstname; ?> <? echo $user->lastname; ?></h3>
                    <p class="mb-4">
                      <? echo $user->description; ?>
                      <hr/>

                      <ul style="list-style-type: none;  margin: 0; padding: 0;overflow: hidden;">
                        <style type="text/css">
                          li {
                            display: block;
                            float: left;
                            text-align: center;
                            padding: 10px;
                            text-decoration: none;
                          }
                        </style>
                        <li><small>عنون السكن : <? echo $user->address; ?> </small></li>
                        <li><small>الهاتف : <? echo $user->phone; ?> </small></li>
                        <li><small>الإيميل : <? echo $user->email; ?> </small></li>
                        <li><small>نوع الحساب : <? echo $user->role; ?></small></li>
                        <li><small>عدد الدورات : 5 </small></li>
                        <li>
                        <span class="badge badge-secondary">سجل في : <? echo $user->created_at; ?></span>
                        </li>
                      </ul>
                    </p>
                    <br/>
                    <hr>
                    <center>
                      <div class="col-md-10">
                        <div class="form-group">
                          <label class="form-label">رابط المشاكرة <button class="btn btn-primary" onclick="copy()">نسخ <i class="fa fa-copy"></i></button>  </label>
                          <input id="link" type="text" name="phone" class="form-control" value="<? echo $this->url(''); ?>p/<? echo (string)$user->_id; ?>">
                        </div>
                      </div>
                     </center> 
                  </div>
                </div>
              </div>
          </div>
        </div>

<? require "teacherArabicFooter.php"; ?>