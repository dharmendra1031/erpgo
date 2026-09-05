<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Task Calendar')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/libs/fullcalendar/dist/fullcalendar.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('theme-script'); ?>
    <script src="<?php echo e(asset('assets/libs/fullcalendar/dist/fullcalendar.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
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
<div class="row">
    <div class="col">
        <!-- Fullcalendar -->
        <div class="card overflow-hidden widget-calendar">
            <div class="calendar e-height" data-toggle="event_calendar" id="event_calendar"></div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script-page'); ?>
    <script>
    var e, t, a = $('[data-toggle="event_calendar"]');
       a.length && (t = {
           header: {right: "", center: "", left: ""},
           buttonIcons: {prev: "calendar--prev", next: "calendar--next"},
           theme: !1,
           selectable: !0,
           selectHelper: !0,
           editable: !0,
           events:  <?php echo json_encode($arrTasks); ?>,
           eventStartEditable: !1,
           locale: '<?php echo e(basename(App::getLocale())); ?>',

           eventResize: function (event) {
               var eventObj = {
                   start: event.start.format(),
                   end: event.end.format(),
               };

               $.ajax({
                   url: event.resize_url,
                   method: 'PUT',
                   data: eventObj,
                   success: function (response) {

                   },
                   error: function (data) {
                       data = data.responseJSON;
                   }
               });
           },
           viewRender: function (t) {

               e.fullCalendar("getDate").month(), $(".fullcalendar-title").html(t.title)
           },
           eventClick: function (e, t) {
               var title = e.title;
               var url = e.url;


               if (typeof url != 'undefined') {
                   $("#commonModal .modal-title").html(title);
                   $("#commonModal .modal-dialog").addClass('modal-md');
                   $("#commonModal").modal('show');
                   $.get(url, {}, function (data) {

                       $('#commonModal .modal-body').html(data);
                   });
                   return false;
               }
           }
       }, (e = a).fullCalendar(t),
           $("body").on("click", "[data-calendar-view]", function (t) {
               t.preventDefault(), $("[data-calendar-view]").removeClass("active"), $(this).addClass("active");
               var a = $(this).attr("data-calendar-view");
               e.fullCalendar("changeView", a)
           }), $("body").on("click", ".fullcalendar-btn-next", function (t) {
           t.preventDefault(), e.fullCalendar("next")
       }), $("body").on("click", ".fullcalendar-btn-prev", function (t) {
           t.preventDefault(), e.fullCalendar("prev")
       }));



    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/tasks/calendar.blade.php ENDPATH**/ ?>