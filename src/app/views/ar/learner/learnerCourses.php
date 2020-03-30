<? $page = "course"; require "learnerArabicPanel.php"; ?>
        <div class="my-3 my-md-5">
          <div class="container">
            <div style="display: none;" id="success-alert">
              <button type='button' class='btn btn-primary' id="clear">Clear all</button><br/><br/>
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
                          <th class="text-center"><i class="icon-settings"></i></th>
                        </tr>
                      </thead>
                      <tbody>
                      <? foreach($userCourses as $courseProgress): ?>
                        <tr>
                        <? $course = $collection->courses->findOne(["_id" => new \MongoDB\BSON\ObjectId($courseProgress->course_id)]); ?>
                          <td class="text-center">
                            <div class="avatar d-block" style="background-image: url(<? echo $course->cover; ?>)">
                            </div>
                          </td>
                          <td>
                            <div><a href="<? echo $this->url('watch')."/".str_replace(' ', '-', $course->title)."/1"; ?>"><? echo $course->title; ?></a></div>
                            <div class="small text-muted">
                              مُسجل: <? echo $courseProgress->created_at; ?>
                            </div>
                          </td>
                          <td>
                            <div class="clearfix">
                              <div class="float-left">
                                <strong><? echo $courseProgress->percentage; ?>%</strong>
                              </div>
                            </div>
                            <div class="progress progress-xs">
                              <div class="progress-bar" role="progressbar" style="width: <? echo $courseProgress->percentage; ?>%" aria-valuenow="<? echo $courseProgress->percentage; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </td>
                          <td>
                            <? $userStatusInCourse = is_null($collection->registredUsersInCourses->findOne(["course_id" => $courseProgress->course_id , "user_id" => $courseProgress->user_id])); ?>
                            <div><? echo ($userStatusInCourse === true) ? "لست مُسجل." : "مُسجل."; ?></div>
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
<? require "learnerArabicFooter.php"; ?>