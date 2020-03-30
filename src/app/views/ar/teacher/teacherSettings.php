<? $page = "settings"; require "teacherArabicPanel.php"; ?>
        <br/>
                    <div class="col-lg-10">
              <form method="POST" action="<? echo $this->url('postTsettings'); ?>" class="card" style="margin-right: 5%; margin-left: 5%;" enctype="multipart/form-data">
                <div class="card-body">
          <? if(isset($errors)): ?>
            <div class="alert alert-danger" role="alert">
              <? foreach($errors as $input => $error): ?>
                - <? echo $error; ?> in <? echo $input; ?> !<br/>
            <? endforeach; ?>
            </div>
          <? endif; ?>
          <? if(isset($suc)): ?>
            <div class="alert alert-success" role="alert">
             - <? echo $suc ?> !
             <small>إضغط <a href="<? echo $this->url('tSettings'); ?>">هنا</a> لرؤية التحديثات </small>
            </div>
          <? endif; ?>
          <div style="display: none;" id="success-alert">
              <button type='button' class='btn btn-primary' id="clear">مسح</button><br/><br/>
            </div>
                <input type="hidden" name="_token" value="<? echo $token; ?>">
                  <h3 style="float: right;" class="card-title">الإعدادات:</h3>
                    <br/>
                    <br/>
                  <div class="row">
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label style="float: right;" class="form-label">اللقب</label>
                        <input required="true" name="firstname" type="text" class="form-control" placeholder="اللقب" value="<? echo $user->firstname; ?>">
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                      <div class="form-group">
                        <label style="float: right;" class="form-label">الإسم</label>
                        <input required="true" name="lastname" type="text" class="form-control" placeholder="الإسم" value="<? echo $user->lastname; ?>">
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                      <div class="form-group">
                        <label style="float: right;" class="form-label">الإيميل</label>
                        <input required="true" name="email" type="email" class="form-control" value="<? echo $user->email; ?>" placeholder="الإيميل">
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label style="float: right;" class="form-label">عنوان السكن</label>
                        <input required="true" name="address" type="text" class="form-control" placeholder="عنون السكن" value="<? echo $user->address; ?>">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label style="float: right;" class="form-label">CCP</label>
                        <input required="true" name="ccp" type="text" class="form-control" placeholder="CCP" value="<? echo $user->ccp; ?>">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label style="float: right;" class="form-label">CCP مفتاح</label>
                        <input required="true" name="key" type="text" class="form-control" placeholder="CCP key" value="<? echo $user->key; ?>">
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                      <div class="form-group">
                        <label style="float: right;" class="form-label">الهاتف</label>
                        <input required="true" type="text" pattern="[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}-[0-9]{2}" name="phone" class="form-control" placeholder="الهاتف" value="<? echo $user->phone; ?>">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group mb-0">
                        <label style="float: right;" class="form-label">وصف عنك</label>
                        <textarea required="true" name="description" rows="5" class="form-control" placeholder="وصف عنك"><? echo $user->description; ?></textarea>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label style="float: right;" class="form-label">كلمة السر الجديدة (أتركها فارغة اذا لم تريد أن تغير كلمة السر الخاص بك)</label>
                        <input name="password" type="password" class="form-control" placeholder="password">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-6">
                      <div class="form-group">
                        <label class="form-label">الصورة</label>
                        <input type="file" name="photo">
                      </div>
                      <img style="width: 250px; height: 250px;" src="<? echo $user->photo; ?>">
                    </div>

                </div>
                <br/>
                                     <div class="card-footer text-right">
                          <button type="submit" class="btn btn-primary">تعديل</button>
                        </div>

      </div>
<? require "teacherArabicFooter.php"; ?>