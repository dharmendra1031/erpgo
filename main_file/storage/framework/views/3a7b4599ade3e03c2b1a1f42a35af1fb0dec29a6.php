<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Interview Schedule')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/libs/fullcalendar/dist/fullcalendar.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(asset('assets/libs/moment/min/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/libs/fullcalendar/dist/fullcalendar.min.js')); ?>"></script>
    <script>
        var Fullcalendar = function () {
            var e, t, a = $('[data-toggle="schedule_calendar"]');
            a.length && (t = {
                header: {right: "", center: "", left: ""},
                buttonIcons: {prev: "calendar--prev", next: "calendar--next"},
                theme: !1,
                selectable: !0,
                selectHelper: !0,
                editable: !1,
                events:<?php echo $arrSchedule; ?>,
                dayClick: function (e) {
                    var t = moment(e).toISOString();
                    $("#new-event").modal("show"), $(".new-event--title").val(""), $(".new-event--start").val(t), $(".new-event--end").val(t)
                },
                viewRender: function (t) {
                    e.fullCalendar("getDate").month(), $(".fullcalendar-title").html(t.title)
                },
                eventClick: function (e, t) {
                    var title = e.title;
                    var url = e.url;


                    if (typeof url != 'undefined') {
                        $("#commonModal .modal-title").html('Interview Schedule Details');
                        $("#commonModal .modal-dialog").addClass('modal-md');
                        $("#commonModal").modal('show');
                        $.get(url, {}, function (data) {

                            $('#commonModal .modal-body').html(data);
                        });
                        return false;
                    }
                }
            }, (e = a).fullCalendar(t), $("body").on("click", ".new-event--add", function () {
                var t = $(".new-event--title").val(), a = {
                    Stored: [], Job: function () {
                        var e = Date.now().toString().substr(6);
                        return this.Check(e) ? this.Job() : (this.Stored.push(e), e)
                    }, Check: function (e) {
                        for (var t = 0; t < this.Stored.length; t++) if (this.Stored[t] == e) return !0;
                        return !1
                    }
                };
                "" != t ? (e.fullCalendar("renderEvent", {id: a.Job(), title: t, start: $(".new-event--start").val(), end: $(".new-event--end").val(), allDay: !0, className: $(".event-tag input:checked").val()}, !0), $(".new-event--form")[0].reset(), $(".new-event--title").closest(".form-group").removeClass("has-danger"), $("#new-event").modal("hide")) : ($(".new-event--title").closest(".form-group").addClass("has-danger"), $(".new-event--title").focus())
            }), $("body").on("click", "[data-calendar]", function () {
                var t = $(this).data("calendar"), a = $(".edit-event--id").val(), n = $(".edit-event--title").val(), o = $(".edit-event--description").val(), i = $("#edit-event .event-tag input:checked").val(), s = e.fullCalendar("clientEvents", a);
                "update" === t && ("" != n ? (s[0].title = n, s[0].description = o, s[0].className = [i], console.log(i), e.fullCalendar("updateEvent", s[0]), $("#edit-event").modal("hide")) : ($(".edit-event--title").closest(".form-group").addClass("has-error"), $(".edit-event--title").focus())), "delete" === t && ($("#edit-event").modal("hide"), setTimeout(function () {
                    swal({title: "Are you sure?", text: "You won't be able to revert this!", type: "warning", showCancelButton: !0, buttonsStyling: !1, confirmButtonClass: "btn btn-danger", confirmButtonText: "Yes, delete it!", cancelButtonClass: "btn btn-secondary"}).then(function (t) {
                        t.value && (e.fullCalendar("removeEvents", a), swal({title: "Deleted!", text: "The event has been deleted.", type: "success", buttonsStyling: !1, confirmButtonClass: "btn btn-primary"}))
                    })
                }, 200))
            }), $("body").on("click", "[data-calendar-view]", function (t) {
                t.preventDefault(), $("[data-calendar-view]").removeClass("active"), $(this).addClass("active");
                var a = $(this).attr("data-calendar-view");
                e.fullCalendar("changeView", a)
            }), $("body").on("click", ".fullcalendar-btn-next", function (t) {
                t.preventDefault(), e.fullCalendar("next")
            }), $("body").on("click", ".fullcalendar-btn-prev", function (t) {
                t.preventDefault(), e.fullCalendar("prev")
            }))
        }()

        $(document).on('change', '.stages', function () {
            var id = $(this).val();
            var schedule_id = $(this).attr('data-scheduleid');

            $.ajax({
                url: "<?php echo e(route('job.application.stage.change')); ?>",
                type: 'POST',
                data: {
                    "stage": id, "schedule_id": schedule_id, "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function (data) {
                    show_toastr('Suceess', data.success, 'success');
                }
            });
        });

    </script>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create interview schedule')): ?>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="#" data-url="<?php echo e(route('interview-schedule.create')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto" data-ajax-popup="true" data-title="<?php echo e(__('Create New Interview Schedule')); ?>">
                    <i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

                </a>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="card">
                    <div class="card-header  pt-1">
                        <div class="page-title">
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
                                        <a href="#" class="btn btn-sm btn-neutral" data-calendar-view="month"><?php echo e(__('Month')); ?></a>
                                        <a href="#" class="btn btn-sm btn-neutral" data-calendar-view="basicWeek"><?php echo e(__('Week')); ?></a>
                                        <a href="#" class="btn btn-sm btn-neutral" data-calendar-view="basicDay"><?php echo e(__('Day')); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="overflow-hidden widget-calendar">
                            <div class="calendar e-height" data-toggle="schedule_calendar" id="schedule_calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0"><?php echo e(__('Schedule List')); ?></h6>
                        </div>
                    </div>
                </div>
                <div class="card-wrapper p-3 schedule-box">
                  <?php if(!$schedules->isEmpty()): ?>
                    <?php $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="card mb-3 border shadow-none">
                            <div class="px-3 py-3">
                                <div class="row align-items-center">
                                    <div class="col ml-n2">
                                        <h5 class="text-sm mb-0">
                                            <a href="#!"><?php echo e(!empty($schedule->applications) ? !empty($schedule->applications->jobs) ? $schedule->applications->jobs->title : '' : ''); ?></a>
                                        </h5>
                                        <p class="card-text small text-muted mt-2">
                                            <?php echo e(!empty($schedule->applications)?$schedule->applications->name:''); ?>

                                        </p>
                                        <p class="card-text small text-muted">
                                            <?php echo e(\Auth::user()->dateFormat($schedule->date).' '. \Auth::user()->timeFormat($schedule->time)); ?>

                                        </p>
                                    </div>
                                    <div class="col-auto text-right">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit interview schedule')): ?>
                                            <a href="#" data-url="<?php echo e(route('interview-schedule.edit',$schedule->id)); ?>" data-title="<?php echo e(__('Edit Interview Schedule')); ?>" data-ajax-popup="true" class="edit-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"><i class="fas fa-pencil-alt"></i></a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete interview schedule')): ?>
                                            <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($schedule->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['interview-schedule.destroy', $schedule->id],'id'=>'delete-form-'.$schedule->id]); ?>

                                            <?php echo Form::close(); ?>

                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                    <div class="text-center">
                      No Interview Scheduled!
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/interviewSchedule/index.blade.php ENDPATH**/ ?>