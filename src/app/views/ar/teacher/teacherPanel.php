<? $page = "panel"; require "teacherArabicPanel.php"; ?>
        <div class="my-3 my-md-5">
          <div class="container">
            <div class="page-header">
              <h1 class="page-title">
                لوحة التحكم
              </h1>
            </div>
            <div style="display: none;" id="success-alert">
              <button type='button' class='btn btn-primary' id="clear">مسح</button><br/><br/>
            </div>
            <div class="row row-cards">
              <div class="col-6 col-sm-4 col-lg-2">

                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="h1 m-0"><? echo $courses; ?></div>
                    <div class="text-muted mb-4">دوراتك</div>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <?
                    $total = 0;
                    foreach($money as $mo) { 
                      $month = explode("/", $mo->created_at);
                      $month = $month[1];
                        if ($month == $date->month) {
                          $total = $mo->money;
                        }
                    }
                    ?>
                    <div class="h1 m-0"><? echo $total; ?> دينار</div>
                    <div class="text-muted mb-4">أرباح لهذا الشهر</div>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="card">
                      <div class="card-header">
                      <? if($visits !== null): ?>
                        <? $date = explode("/", $visits->created_at); ?>
                          <h3 class="card-title">محموع الزوار في <? echo $date[0]; ?> </h3>
                        <? else: ?>  
                        <h3 class="card-title">لاتوجد زيارات بعد. </h3>
                      <? endif; ?>
                      </div>
                      <div class="card-body" style="direction: ltr;">
                        <div id="chart-donut" style="height: 20rem;"></div>
                      </div>
                    </div>
                    <script>
                      require(['c3', 'jquery'], function(c3, $) {
                        $(document).ready(function(){
                          var chart = c3.generate({
                            bindto: '#chart-donut', // id of chart wrapper
                            data: {
                              columns: [
                                ['data1', <? echo ($visits===null) ? 0 : $visits->profileVisits; ?>],
                                ['data2',  <? echo ($visits===null) ? 0 : $visits->coursesVisits; ?>],
                                ['data3',  <? echo ($takes==0) ? 0 : $takes; ?>],
                              ],
                              type: 'donut', // default type of chart
                              colors: {
                                'data1': tabler.colors["blue"],
                                'data2': 'green',
                                'data3': tabler.colors["red"],
                              },
                              names: {
                                'data1': 'زوار البروفايل',
                                'data2': 'زوار الدورات',
                                'data3': 'الدورات المأخوذة',
                              }
                            },
                            axis: {
                            },
                            legend: {
                                      show: true, //hide legend
                                      position: 'right'

                            },
                            padding: {

                            },
                          });
                        });
                      });
                    </script>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-6">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-green mr-3">
                      <i class="fe fe-video"></i>
                    </span>
                    &nbsp;
                    <div>
                      <h4 class="m-0"><a href="javascript:void(0)"><? echo ($visits === null) ? "0" : $visits->coursesVisits; ?> <small>&nbsp;زوار الدورات</small></a></h4>
                    </div>
                  </div>
                </div>
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-red mr-3">
                      <i class="fe fe-book"></i>
                    </span>
                    &nbsp;
                    <div>
                      <h4 class="m-0"><a href="javascript:void(0)"><? echo ($takes == 0) ? "0" : $takes ; ?> <small>&nbsp;الدورات المأخوذة</small></a></h4>
                    </div>
                  </div>
                </div>
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-blue mr-3">
                      <i class="fe fe-user"></i>
                    </span>
                    &nbsp;
                    <div>
                      <h4 class="m-0"><a href="javascript:void(0)"><? echo ($visits === null) ? "0" : $visits->profileVisits ; ?><small>&nbsp;زوار البروفايل</small></a></h4>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="card">
                      <div class="card-header">
                      <? if($visits !== null): ?>
                        <? $date = explode("/", $visits->created_at); ?>
                          <h3 class="card-title">تتبع أموالك في سنة <? echo $date[0]; ?> </h3>
                          <hr/> 
                        <? else: ?>  
                        <h3 class="card-title">ليس هناك أموال بعد. </h3>
                      <? endif; ?>
                      </div>
                      <div class="card-body">
                        <div id="chart-spline" style="height: 20rem;"></div>
                      </div>
                    </div>
                    <script>
                      require(['c3', 'jquery'], function(c3, $) {
                        $(document).ready(function(){
                          var chart = c3.generate({
                            bindto: '#chart-spline', // id of chart wrapper
                            data: {
                              columns: [
                                ['Total', <? foreach($money as $m) { echo $m->money.","; } ?> ],
                              ],
                              type: 'line', // default type of chart
                              colors: {
                                'Total': tabler.colors["orange"],
                              },
                            },
                            axis: {
                              y: {
                                  label: 'DA'
                              },
                              x: {
                                    type: 'category',
                                    categories: [<? foreach($money as $m) { echo "'".$m->created_at."',"; } ?>]
                                }
                            },
                            legend: {
                                      show: false, //hide legend

                            },
                            padding: {

                            },
                          });
                        });
                      });
                    </script>
                  </div>

                </div>
              </div>
              <div class="col-sm-6 col-lg-6">
                <div class="card p-3">
                  <div class="d-flex align-items-center">
                    <span class="stamp stamp-md bg-orange mr-3">
                      <i class="fe fe-dollar-sign"></i>
                    </span>
                    &nbsp;
                    <div>
                      <h4 class="m-0"><a href="javascript:void(0)"><? echo $allMoney; ?>دينار <small>جمعتها من dzcourses</small></a></h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <h3 style="float: right;">اخر التعلقات على دوراتك</h3>
            <br/>
            <br/>
              <div class="row row-cards row-deck">
                <? if(!$comments->isDead()): ?>
                  <? foreach($comments as $comment): ?>
                  <? $user = $collection->learners->findOne(["_id" =>  new MongoDB\BSON\ObjectId($comment->user_id)]); ?>
                   <? if (is_null($user)) : $user = $collection->users->findOne(["_id" => new MongoDB\BSON\ObjectId($comment->user_id)]); endif; ?>
                  <? $course  = $collection->courses->findOne(["_id" => new MongoDB\BSON\ObjectId($comment->course_id)]); ?>
                    <div class="col-lg-6">
                      <div class="card card-aside">
                        <a href="#" class="card-aside-column" style="background-image: url(<? echo $user->photo; ?>)"></a>
                        <div class="card-body d-flex flex-column">
                          <div class="text-muted" style="direction: ltr;"><? echo substr($comment->comment, 0, 400); if(strlen($comment->comment) > 400) { echo "..."; } ?></div>
                          <div class="d-flex align-items-center pt-5 mt-auto">
                            <div>
                              <a href="<? echo $this->url('p').'/'.$comment->user_id; ?>" class="text-default"><? echo $user->firstname." ".$user->lastname; ?></a> in <a href="<? echo $this->url('course'); ?>/<? echo str_replace(' ', '-', $course->title); ?>"><? echo $course->title; ?></a>
                              <small class="d-block text-muted"><? echo $comment->created_at; ?></small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <? endforeach; ?>  
                <? else: ?>
                    <p>ليس هناك أي تعليقات !</p>
                <? endif; ?>  
              </div>
            <div class="row row-cards row-deck">
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
                          <th>المجموع</th>
                          <th>من</th>
                          <th>إلى</th>
                          <th>إلى (CCP)</th>
                          <th>الصور</th>
                          <th>التاريخ</th>
                        </tr>
                      </thead>
                      <tbody>
                      <? foreach($invoices as $invoice): ?>
                          <tr>
                            <td><span class="text-muted"><? echo (string)$invoice->_id ?></span></td>
                            <td><? echo $invoice->sum; ?>دينار</td>
                            <td><? echo $dzcoursesCCP; ?></td>
                            <? $user = $collection->users->findOne(["_id" =>  new MongoDB\BSON\ObjectId($invoice->to)]); ?>
                            <td><? echo $user->firstname." ".$user->lastname; ?></td>
                            <td><? echo $user->ccp; ?></td>
                            <td>
                            <a href="<? echo $this->url('getImage/').$invoice->image1; ?>">Image1</a>
                            /
                            <a href="<? echo $this->url('getImage/').$invoice->image2; ?>">Image2</a>
                            /
                            <a href="<? echo $this->url('getImage/').$invoice->image3; ?>">Image3</a>
                            </td>
                            <td><? echo $invoice->created_at; ?></td>
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