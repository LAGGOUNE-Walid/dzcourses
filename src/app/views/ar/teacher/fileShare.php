<? $page = "share"; require "teacherArabicPanel.php"; ?>
<br/>
                    <div class="col-lg-10">
              <form method="POST" action="<? echo $this->url('postFile'); ?>" class="card" style="margin-right: 5%; margin-left: 5%;" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="<? echo $token; ?>">
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
            </div>
          <? endif; ?>
          <? if(isset($fileLink)): ?>
            <div class="alert alert-success" role="alert">
             - رابط ملفك : <a href="<? echo $fileLink; ?>"><? echo $fileLink; ?></a>
            </div>
          <? endif; ?>

          <div style="display: none;" id="success-alert">
              <button type='button' class='btn btn-primary' id="clear">مسح</button><br/><br/>
            </div>
                <input type="hidden" name="_token" value="<? echo $token; ?>">
                  <h3 style="float: right;" class="card-title">مشاركة ملف:</h3>
                  <br/>
                  <div class="col-sm-6 col-md-6">
                      <div class="form-group">
                        <label class="form-label" style="color:red; float: right;">- إرفع ملفك بصيغة ZIP</label>
                        <label class="form-label" style="color:red;">- أقصى حجم مسموع هو 100 ميجابايت</label>
                        <input type="file" name="file">
                      </div>
                    </div>

                </div>
                <br/>
                                     <div class="card-footer text-right">
                          <button type="submit" class="btn btn-primary">رفع</button>
                        </div>
                        </form>
      </div>
      <div style="margin-right: 4%;">
        <div class="col-10">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">جميع ملفاتك</h3>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>الرابط</th>
                          <th>التحميلات</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      <? foreach($files as $file): ?>
                        <tr>
                          <td><span class="text-muted"><? echo $file->_id; ?>.zip</span></td>
                          <td><span class="text-muted"><a href='<? echo $this->url("file") ?>/<? echo $file->_id; ?>'><? echo $this->url("file") ?>/<? echo $file->_id; ?></a></span></td>
                          <td><a href="invoice.html" class="text-inherit"><? echo $file->downloads; ?></a></td>
                          <td class="text-right">
                           <form method="POST" action="<? echo $this->url('deleteFile') ?>">
                              <input type="hidden" name="_token" value="<? echo $token; ?>">
                              <input type="hidden" name="fileId" value="<? echo $file->_id; ?>">
                              <input type="hidden" name="filePath" value="<? echo $file->path; ?>">
                              <button type="submit" class="btn btn-outline-danger">حذف الملف</button>
                           </form>
                          </td>
                        </tr>
                      <? endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
      </div>
<? require "teacherArabicFooter.php"; ?>