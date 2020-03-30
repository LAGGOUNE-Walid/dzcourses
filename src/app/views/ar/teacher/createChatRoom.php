<? $page = "chatroom"; require "teacherArabicPanel.php"; ?>
<br/>
                    <div class="col-lg-10">
              <form method="POST" action="<? echo $this->url('postCreateChatRoom'); ?>" class="card" style="margin-right: 5%; margin-left: 5%;" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="<? echo $token; ?>">
                <div class="card-body">
          <? if(isset($errors)): ?>
            <div class="alert alert-danger" role="alert">
              <? foreach($errors as $input => $error): ?>
                - <? echo $error; ?> in <? echo $input; ?> !<br/>
            <? endforeach; ?>
            </div>
          <? endif; ?>
          <? if(isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                - <? echo $error; ?> <br/>
            </div>
          <? endif; ?>
          <? if(isset($suc)): ?>
            <div class="alert alert-success" role="alert">
             - <? echo $suc ?> !
             - <a href="<? echo $url; ?>"><? echo $url; ?></a>
            </div>
          <? endif; ?>

          <div style="display: none;" id="success-alert">
              <button type='button' class='btn btn-primary' id="clear">مسح</button><br/><br/>
            </div>
                <input type="hidden" name="_token" value="<? echo $token; ?>">
                  <div class="col-sm-6 col-md-6">
                      <div class="form-group">
                       <label style="float: right;" for="exampleInputEmail1">إسم الغرفة:</label>
                      <input type="text" class="form-control" name="title" placeholder="أدخل أسماً">
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                      <div class="form-group">
                       <label style="float: right;" for="exampleInputEmail1">رابط الدورة : (سيتم ربط الغرفة مع هذه الدورة)</label>
                      <input type="url" class="form-control" name="courseUrl" placeholder="أدخل الرابط ... مثال : www.dzcourses.com/course/XXXX">
                      </div>
                    </div>

                </div>
                <br/>
                                     <div class="card-footer text-right">
                          <button type="submit" class="btn btn-primary">إنشاء</button>
                        </div>
                        </form>
      </div>
      <div style="margin-right: 4%;">
        <div class="col-8">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">جميع الغُرف التي أنشأتها</h3>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                      <thead>
                        <tr>
                          <th>الرابط</th>
                          <th>العنوان</th>
                          <th>عدد المستخدمين</th>
                          <th>التاريخ</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      <? foreach($createdRooms as $createdRoom): ?>
                        <tr>
                          <td><span class="text-muted"><a href="<? echo $this->url('chat') ?>/<? echo (string)$createdRoom->id; ?>"><? echo $this->url('chat') ?>/<? echo (string)$createdRoom->id; ?></a></span></td>
                          <td><span class="text-muted"><? echo $createdRoom->title; ?></span></td>
                          <td><span class="text-muted"><? echo $createdRoom->users; ?></span></td>
                          <td><span class="text-muted"><? echo $createdRoom->created_at; ?></span></td>
                        </tr>
                       <? endforeach; ?> 
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
      </div>
<? require "teacherArabicFooter.php"; ?>