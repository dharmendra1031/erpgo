<?php $__env->startSection('title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css-page'); ?>
    <?php if($calenderTasks): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/libs/fullcalendar/dist/fullcalendar.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/stylesheet-client-dashboard.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/site-client.css')); ?>">
    <?php endif; ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(asset('assets/js/chart.min.js')); ?>"></script>
    <?php if($calenderTasks): ?>
        <script src="<?php echo e(asset('assets/libs/fullcalendar/dist/fullcalendar.min.js')); ?>"></script>
    <?php endif; ?>
    <script>
            <?php if($calenderTasks): ?>
        var e, t, a = $('[data-toggle="event_calendar"]');
        a.length && (t = {
            header: {right: "", center: "", left: ""},
            buttonIcons: {prev: "calendar--prev", next: "calendar--next"},
            theme: !1,
            selectable: !0,
            selectHelper: !0,
            editable: false,
            events: <?php echo json_encode($calenderTasks); ?>,
            eventStartEditable: !1,
            locale: '<?php echo e(basename(App::getLocale())); ?>',
            viewRender: function (t) {
                e.fullCalendar("getDate").month(), $(".fullcalendar-title").html(t.title)
            },
        }, (e = a).fullCalendar(t),
            $("body").on("click", "[data-calendar-view]", function (t) {
                t.preventDefault(), $("[data-calendar-view]").removeClass("active"), $(this).addClass("active");
                var a = $(this).attr("data-calendar-view");
                e.fullCalendar("changeView", a)
            }), $("body").on("click", ".fullcalendar-btn-next", function (t) {
            t.preventDefault(), e.fullCalendar("next")
        }), $("body").on("click", ".fullcalendar-btn-prev", function (t) {
            t.preventDefault(), e.fullCalendar("prev")
        }), $("body").on("click", ".fc-today-button", function (t) {
            t.preventDefault(), e.fullCalendar("today")
        }));
        <?php endif; ?>

        $(document).on('click', '.fc-day-grid-event', function (e) {
            if (!$(this).hasClass('deal')) {
                e.preventDefault();
                var event = $(this);
                var title = $(this).find('.fc-content .fc-title').html();
                var size = 'md';
                var url = $(this).attr('href');
                $("#commonModal .modal-title").html(title);
                $("#commonModal .modal-dialog").addClass('modal-' + size);

                $.ajax({
                    url: url,
                    success: function (data) {
                        $('#commonModal .modal-body').html(data);
                        $("#commonModal").modal('show');
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        show_toastr('Error', data.error, 'error')
                    }
                });
            }
        });



    </script>
    <script>
        var SalesChart = (function () {
            var $chart = $('#chart-sales');

            function init($this) {
                var salesChart = new Chart($this, {
                    type: 'line',
                    options: {
                        scales: {
                            yAxes: [{
                                gridLines: {
                                    color: Charts.colors.gray[200],
                                    zeroLineColor: Charts.colors.gray[200]
                                },
                            }]
                        }
                    },
                    data: {
                        labels:<?php echo json_encode($taskData['label']); ?>,
                        datasets: <?php echo json_encode($taskData['dataset']); ?>

                    }
                });
                $this.data('chart', salesChart);
            };
            if ($chart.length) {
                init($chart);
            }
        })();
        var DoughnutChart = (function () {
            var $chart = $('#chart-doughnut');

            function init($this) {
                var randomScalingFactor = function () {
                    return Math.round(Math.random() * 100);
                };
                var doughnutChart = new Chart($this, {
                    type: 'doughnut',
                    data: {
                        labels: <?php echo json_encode($project_status); ?>,
                        datasets: [{
                            data: <?php echo json_encode(array_values($projectData)); ?>,
                            backgroundColor: ["#40c5d2", "#f36a5b", "#67b7dc"],
                            // label: 'Dataset 1'
                        }],
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'top',
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        }
                    }
                });

                $this.data('chart', doughnutChart);

            };
            if ($chart.length) {
                init($chart);
            }
        })();
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php

  $project_task_percentage = $project['project_task_percentage'];
  $label='';
        if($project_task_percentage<=15){
            $label='bg-danger';
        }else if ($project_task_percentage > 15 && $project_task_percentage <= 33) {
            $label='bg-warning';
        } else if ($project_task_percentage > 33 && $project_task_percentage <= 70) {
            $label='bg-primary';
        } else {
            $label='bg-success';
        }


  $project_percentage = $project['project_percentage'];
  $label1='';
        if($project_percentage<=15){
            $label1='bg-danger';
        }else if ($project_percentage > 15 && $project_percentage <= 33) {
            $label1='bg-warning';
        } else if ($project_percentage > 33 && $project_percentage <= 70) {
            $label1='bg-primary';
        } else {
            $label1='bg-success';
        }

  $project_bug_percentage = $project['project_bug_percentage'];
  $label2='';
      if($project_bug_percentage<=15){
        $label2='bg-danger';
      }else if ($project_bug_percentage > 15 && $project_bug_percentage <= 33) {
        $label2='bg-warning';
      } else if ($project_bug_percentage > 33 && $project_bug_percentage <= 70) {
        $label2='bg-primary';
      } else {
        $label2='bg-success';
      }
?>

    <div class="row">
        <?php if(!empty($arrErr)): ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php if(!empty($arrErr['system'])): ?>
                    <div class="alert alert-danger text-xs">
                         <?php echo e(__('are required in')); ?> <a href="<?php echo e(route('settings')); ?>" class=""><u> <?php echo e(__('System Setting')); ?></u></a>
                    </div>
                <?php endif; ?>
                <?php if(!empty($arrErr['user'])): ?>
                    <div class="alert alert-danger text-xs">
                         <a href="<?php echo e(route('users')); ?>" class=""><u><?php echo e(__('here')); ?></u></a>
                    </div>
                <?php endif; ?>
                <?php if(!empty($arrErr['role'])): ?>
                    <div class="alert alert-danger text-xs">
                         <a href="<?php echo e(route('roles.index')); ?>" class=""><u><?php echo e(__('here')); ?></u></a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="row">

        <?php if(isset($arrCount['deal'])): ?>
            <div class=" col-sm-6">
                <div class="card card-box">
                    <div class="left-card">
                        <div class="icon-box bg-warning"><i class="fas fa-handshake"></i></div>
                        <h4><?php echo e(__('Total Deal')); ?></h4>
                    </div>
                    <div class="number-icon"><?php echo e($arrCount['deal']); ?></div>
                    <img src="<?php echo e(('assets/img/dot-icon.png')); ?>" class="dotted-icon-c">
                </div>
            </div>
        <?php endif; ?>

        <?php if(isset($arrCount['task'])): ?>
            <div class=" col-sm-6">
                <div class="card card-box">
                    <div class="left-card">
                        <div class="icon-box bg-danger"><i class="fas fa-tasks"></i></div>
                        <h4><?php echo e(__('Total Deal Task')); ?></h4>
                    </div>
                    <div class="number-icon"><?php echo e($arrCount['task']); ?></div>
                    <img src="<?php echo e(('assets/img/dot-icon.png')); ?>" class="dotted-icon-c">
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <div class="card card-box height-95">
                <div class="icon-box <?php echo e($label1); ?>"><?php echo e($project['projects_count']); ?></div>
                <div class="number-icon w-100">
                    <div class="card-right-title">
                        <h4 class="float-left"><?php echo e(__('Total Project')); ?></h4>
                        <h5 class="float-right"><?php echo e($project['project_percentage']); ?>%</h5>
                    </div>
                    <div class="border-progress">
                        <div class="border-inner-progress <?php echo e($label1); ?>" style="width:<?php echo e($project['project_percentage']); ?>%"></div>
                    </div>
                </div>
                <img src="<?php echo e(asset('assets/img/dot-icon.png')); ?>" alt="" class="dotted-icon-c">
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <div class="card card-box height-95">
                <div class="icon-box <?php echo e($label); ?>"><?php echo e($project['projects_tasks_count']); ?></div>
                <div class="number-icon w-100">
                    <div class="card-right-title">
                        <h4 class="float-left"><?php echo e(__('Total Project Tasks')); ?></h4>
                        <h5 class="float-right"><?php echo e($project['project_task_percentage']); ?>%</h5>
                    </div>
                    <div class="border-progress">
                        <div class="border-inner-progress <?php echo e($label); ?>" style="width:<?php echo e($project['project_task_percentage']); ?>%"></div>
                    </div>
                </div>
                <img src="<?php echo e(asset('assets/img/dot-icon.png')); ?>" alt="" class="dotted-icon-c">
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                <div class="card card-box height-95">
                    <div class="icon-box <?php echo e($label2); ?>"><?php echo e($project['projects_bugs_count']); ?></div>
                    <div class="number-icon w-100">
                        <div class="card-right-title">
                            <h4 class="float-left"><?php echo e(__('Total Bugs')); ?></h4>
                            <h5 class="float-right"><?php echo e($project['project_bug_percentage']); ?>%</h5>
                        </div>
                        <div class="border-progress">
                            <div class="border-inner-progress <?php echo e($label2); ?>" style="width:<?php echo e($project['project_bug_percentage']); ?>%"></div>
                        </div>
                    </div>
                    <img src="<?php echo e(asset('assets/img/dot-icon.png')); ?>" alt="" class="dotted-icon-c">
                </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div>
                <h4 class="h4 font-weight-400 float-left"><?php echo e(__('Tasks Overview')); ?></h4>
                <h6 class="last-day-text"><?php echo e(__('Last 7 Days')); ?></h6>
            </div>
            <div class="card bg-none">
                <canvas id="chart-sales" height="300" class="p-3"></canvas>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="<?php echo e((Auth::user()->type =='company' || Auth::user()->type =='client') ? 'col-xl-6 col-lg-6 col-md-6' : 'col-xl-8 col-lg-8 col-md-8'); ?> col-sm-12">
            <div>
                <h4 class="h4 font-weight-400 float-left"><?php echo e(__('Top Due Project')); ?></h4>
            </div>
            <div class="card bg-none min-410 mx-410">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                        <tr>
                            <th><?php echo e(__('Task Name')); ?></th>
                            <th><?php echo e(__('Remain Task')); ?></th>
                            <th><?php echo e(__('Due Date')); ?></th>
                            <th><?php echo e(__('Action')); ?></th>
                        </tr>
                        </thead>
                        <tbody class="list">
                        <?php $__empty_1 = true; $__currentLoopData = $project['projects']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $datetime1 = new DateTime($project->due_date);
                                $datetime2 = new DateTime(date('Y-m-d'));
                                $interval = $datetime1->diff($datetime2);
                                $days = $interval->format('%a');

                                 $project_last_stage = ($project->project_last_stage($project->id))?$project->project_last_stage($project->id)->id:'';
                                $total_task = $project->project_total_task($project->id);
                                $completed_task=$project->project_complete_task($project->id,$project_last_stage);
                                $remain_task=$total_task-$completed_task;
                            ?>
                            <tr>
                                <td class="id-web">
                                    <?php echo e($project->project_name); ?>

                                </td>
                                <td><?php echo e($remain_task); ?></td>
                                <td><?php echo e(Auth::user()->dateFormat($project->end_date)); ?></td>
                                <td>
                                    <a href="<?php echo e(route('projects.show',$project->id)); ?>" class="edit-icon"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr class="text-center">
                                <td colspan="4"><?php echo e(__('No Data Found.!')); ?></td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <div>
                <h4 class="h4 font-weight-400 float-left"><?php echo e(__('Top Due Task')); ?></h4>
            </div>
            <div class="card bg-none min-410 mx-410">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                        <tr>
                            <th><?php echo e(__('Task Name')); ?></th>
                            <th><?php echo e(__('Assign To')); ?></th>
                            <th><?php echo e(__('Task Stage')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $top_tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $top_task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="id-web">
                                    <?php echo e($top_task->name); ?>

                                </td>
                                <td>
                                    <div class="avatar-group">
                                        <?php if($top_task->users()->count() > 0): ?>
                                            <?php if($users = $top_task->users()): ?>
                                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($key<3): ?>
                                                        <a href="#" class="avatar rounded-circle avatar-sm">
                                                            <img data-original-title="<?php echo e((!empty($user)?$user->name:'')); ?>" <?php if($user->avatar): ?> src="<?php echo e(asset('/storage/uploads/avatar/'.$user->avatar)); ?>" <?php else: ?> src="<?php echo e(asset('assets/img/avatar/avatar-1.png')); ?>" <?php endif; ?> title="<?php echo e($user->name); ?>" class="hweb">
                                                        </a>
                                                    <?php else: ?>
                                                        <?php break; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                            <?php if(count($users) > 3): ?>
                                                <a href="#" class="avatar rounded-circle avatar-sm">
                                                    <img  data-original-title="<?php echo e((!empty($user)?$user->name:'')); ?>" <?php if($user->avatar): ?> src="<?php echo e(asset('/storage/uploads/avatar/'.$user->avatar)); ?>" <?php else: ?> src="<?php echo e(asset('assets/img/avatar/avatar-1.png')); ?>" <?php endif; ?> class="hweb">
                                                </a>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php echo e(__('-')); ?>

                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td><span class="badge badge-pill blue-bg"><?php echo e($top_task->stage->name); ?></span></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr class="text-center">
                                <td colspan="4"><?php echo e(__('No Data Found.!')); ?></td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <?php if($calenderTasks): ?>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <div>
                  <h4 class="h4 font-weight-400 float-left"><?php echo e(__('Deal Calender')); ?></h4>
              </div>
                <div class="card author-box card-primary">
                    <div class="card-header">
                        <div class="row justify-content-between align-items-center full-calender">
                            <div class="col d-flex align-items-center">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="#" class="fullcalendar-btn-prev btn btn-sm btn-neutral">
                                        <i class="fas fa-angle-left"></i>
                                    </a>
                                    <a href="#" class="fullcalendar-btn-next btn btn-sm btn-neutral">
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </div>
                                <h5 class="fullcalendar-title h4 d-inline-block font-weight-400 mb-0"></h5>
                            </div>
                            <div class="col-lg-6 mt-3 mt-lg-0 text-lg-right">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button class="fc-today-button btn btn-sm btn-neutral" type="button"><?php echo e(__('Today')); ?></button>
                                </div>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="#" class="btn btn-sm btn-neutral" data-calendar-view="month"><?php echo e(__('Month')); ?></a>
                                    <a href="#" class="btn btn-sm btn-neutral" data-calendar-view="basicWeek"><?php echo e(__('Week')); ?></a>
                                    <a href="#" class="btn btn-sm btn-neutral" data-calendar-view="basicDay"><?php echo e(__('Day')); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id='calendar-container'>
                            <div id='calendar' data-toggle="event_calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div>
                    <h4 class="h4 font-weight-400 float-left"><?php echo e(__('Project Status')); ?></h4>
                </div>
                <div class="card bg-none py-4 min-410 mx-410">
                    <div class="chart">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="chart-doughnut" class="chart-canvas chartjs-render-monitor" width="734" height="350" style="display: block; width: 734px; height: 350px;"></canvas>
                    </div>
                    <div class="project-details" style="margin-top: 15px;">
                        <div class="row">
                            <div class="col text-center">
                                <div class="tx-gray-500 small"><?php echo e(__('On Going')); ?></div>
                                <div class="font-weight-bold"><?php echo e(number_format($projectData['on_going'],2)); ?>%</div>
                            </div>
                            <div class="col text-center">
                                <div class="tx-gray-500 small"><?php echo e(__('On Hold')); ?></div>
                                <div class="font-weight-bold"><?php echo e(number_format($projectData['on_hold'],2)); ?> %</div>
                            </div>
                            <div class="col text-center">
                                <div class="tx-gray-500 small"><?php echo e(__('Completed')); ?></div>
                                <div class="font-weight-bold"><?php echo e(number_format($projectData['completed'],2)); ?> %</div>
                            </div>
                            <div class="col text-center">
                                <div class="tx-gray-500 small"><?php echo e(__('Canceled')); ?></div>
                                <div class="font-weight-bold"><?php echo e(number_format($projectData['canceled'],2)); ?> %</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/dashboard/clientView.blade.php ENDPATH**/ ?>