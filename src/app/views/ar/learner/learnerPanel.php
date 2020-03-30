<? $page = 'panel'; require "learnerArabicPanel.php"; ?>
        <div class="my-3 my-md-5">
          <div class="container">
            <div style="display: none;" id="success-alert">
              <button type='button' class='btn btn-primary' id="clear">مسح</button><br/><br/>
            </div>
            <div style="border:1px solid #d6d6d6;" class="alert alert-light" role="alert">

              خطتط هي :
              <?php if (is_null($user->guard)): ?>
                  ولا واحدة
              <?php else: ?>
                  <? echo $user->guard; ?>
                  <? if($user->plan == 1): ?>
                      يمكنك مشاهدة دورة واحد
                  <? elseif($user->plan > 1): ?>
                      يمكنك مشاهدة <? echo $user->plan;  ?> دورات.
                  <? elseif($user->plan == 0): ?>
                      لايمكن مشاهدة أي دورة , خطتك 0
                  <? endif; ?>
              <? endif; ?>
            
        <?php if (is_null($user->guard) AND $user->plan == 0): ?>
         , يمكنك شراء خطة و الدفع <a href="<? echo $this->url('uploadInvoices'); ?>">هنا</a>. 
        <?php endif; ?>
          </div>
            <div class="row row-cards row-deck">
              <div class="col-12">
                <div class="card">
                  <div class="table-responsive">
                    <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                      <thead>
                        <tr>
                          <th class="text-center w-1"><i class="icon-people"></i></th>
                          <th>الدورة</th>
                          <th>التقدم</th>
                          <th>الحالة</th>
                        </tr>
                      </thead>
                      <tbody>
                      <? foreach($userCourses as $courseProgress): ?>
                        <? $course = $collection->courses->findOne(["_id" => new \MongoDB\BSON\ObjectId($courseProgress->course_id)]); ?>
                        <? if(!is_null($course)): ?>
                        <tr>
                          <td class="text-center">
                            <div class="avatar d-block" style="background-image: url(<? echo $course->cover; ?>)">
                            </div>
                          </td>
                          <td>
                            <div><a href="<? echo $this->url('watch')."/".str_replace(' ', '-', $course->title)."/1"; ?>"><? echo $course->title; ?></a></div>
                            <div class="small text-muted">
                              سُجل في: <? echo $courseProgress->created_at; ?>
                            </div>
                          </td>
                          <td>
                            <div class="clearfix">
                              <div class="float-left">
                                <strong><? echo round($courseProgress->percentage); ?>%</strong>
                              </div>
                            </div>
                            <div class="progress progress-xs">
                              <div class="progress-bar" role="progressbar" style="width: <? echo $courseProgress->percentage; ?>%" aria-valuenow="<? echo $courseProgress->percentage; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </td>
                          <td>
                            <? $userStatusInCourse = is_null($collection->registredUsersInCourses->findOne(["course_id" => $courseProgress->course_id , "user_id" => $courseProgress->user_id])); ?>
                            <div><? echo ($userStatusInCourse === true) ? "لست مُسجل" : "مُسجل."; ?></div>
                          </td>
                        </tr>
                      <? endif; ?>
                      <? endforeach; ?>
                      </tbody>
                    </table>

                  </div>
                </div>
                <center>
                <a style="margin-top: 2%; margin-bottom: 3%;" href="<? echo $this->url('lcourses'); ?>" class="btn btn-secondary">إستعراض الكٌل</a>
                  </center>
              </div>
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">الفواتير</h3>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                      <thead>
                        <tr>
                          <th class="w-1">#ID</th>
                          <th>نوع الفاتورة</th>
                          <th>المُرسل</th>
                          <th>التاريخ</th>
                          <th>الحالة</th>
                          <th>السعر</th>
                        </tr>
                      </thead>
                      <tbody>
                      <? foreach($invoices as $invoice): ?>
                          <tr>
                            <td><span class="text-muted"><? echo (string)$invoice->_id;?></span></td>
                            <td><? echo $invoice->subject; ?></td>
                            <td>
                              <? echo $invoice->firstname." ".$invoice->lastname; ?>
                            </td>
                            <td>
                              <? echo $invoice->created_at; ?>
                            </td>
                            <td>
                              <? if($invoice->status == "Pending"): ?>
                                <span class="status-icon bg-warning"></span>&nbsp;بانتظار الموافقة
                              <? elseif($invoice->status == "Done"): ?>
                                <span class="status-icon bg-success"></span>&nbsp;تم
                              <? endif; ?>  
                            </td>
                            <td><? echo $invoice->sended; ?>DA</td>
                          </tr>
                      <? endforeach; ?>  
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<? require "learnerArabicFooter.php" ?>