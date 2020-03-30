<? $page = "courses"; require "teacherArabicPanel.php"; ?>
        <div class="my-3 my-md-5">
          <div class="container">
            <div style="display: none;" id="success-alert">
              <button type='button' class='btn btn-primary' id="clear">مسح</button><br/><br/>
            </div>
            <div class="row row-cards row-deck">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">دوراتي</h3>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                      <thead>
                        <tr>
                          <th class="w-1">#ID</th>
                          <th>العنوان</th>
                          <th>عدد مقاطع الفيديو</th>
                          <th>المدة</th>
                          <th>تاريخ الرفع</th>
                          <th>التقييم</th>
                          <th>الحالة</th>
                          <th>المشتركين</th>
                          <th>الأرباح</th>
                        </tr>
                      </thead>
                      <tbody>
                      <? foreach($courses as $course): ?>
                        <tr>
                          <td><span class="text-muted"><? echo (string)$course->_id; ?></span></td>
                          <td><a href="<? echo $this->url('course'); ?>/<? echo str_replace(' ', '-', $course->title); ?>" class="text-inherit"><? echo $course->title; ?></a></td>
                          <td><? echo $course->videosNumber; ?></td>
                          <td><? echo round($course->courseTime / 60); ?>دقيقة.</td>
                          <td><? echo $course->created_at; ?></td>
                          <td>
                          <? echo $courseController->getCourseRate((string)$course->_id, $collection); ?>/10
                          </td>
                          <td>
                            <? if($course->activated == 1): ?>
                              <span class="status-icon bg-success"></span> مُفعل
                            <? else: ?>  
                              <span class="status-icon bg-danger"></span> بانتظار الموافقة
                            <? endif; ?>
                          </td>
                          <td>
                            <? echo $learner = $helper->getTotalCourseLearners($collection, (string) $course->_id); ?>
                          </td>
                          <td>
                          <? echo $learner*$profitFromOneCourse; ?> DA
                          </td>
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
<? require "teacherArabicFooter.php"; ?>