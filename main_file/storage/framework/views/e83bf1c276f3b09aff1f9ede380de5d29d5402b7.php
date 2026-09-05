<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Job Application')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(asset('assets/libs/dragula/dist/dragula.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/libs/autosize/dist/autosize.min.js')); ?>"></script>
    <script>

        $(document).on('change', '#jobs', function () {
            var id = $(this).val();

            $.ajax({
                url: "<?php echo e(route('get.job.application')); ?>",
                type: 'POST',
                data: {
                    "id": id, "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function (data) {
                    var job = JSON.parse(data);
                    var applicant = job.applicant;
                    var visibility = job.visibility;
                    var question = job.custom_question;

                    (applicant.indexOf("gender") != -1) ? $('.gender').removeClass('d-none') : $('.gender').addClass('d-none');
                    (applicant.indexOf("dob") != -1) ? $('.dob').removeClass('d-none') : $('.dob').addClass('d-none');
                    (applicant.indexOf("country") != -1) ? $('.country').removeClass('d-none') : $('.country').addClass('d-none');

                    (visibility.indexOf("profile") != -1) ? $('.profile').removeClass('d-none') : $('.profile').addClass('d-none');
                    (visibility.indexOf("resume") != -1) ? $('.resume').removeClass('d-none') : $('.resume').addClass('d-none');
                    (visibility.indexOf("letter") != -1) ? $('.letter').removeClass('d-none') : $('.letter').addClass('d-none');

                    $('.question').addClass('d-none');

                    if (question.length > 0) {
                        question.forEach(function (id) {
                            $('.question_' + id + '').removeClass('d-none');
                        });
                    }


                }
            });
        });

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('move job application')): ?>
            !function (a) {
            "use strict";
            var t = function () {
                this.$body = a("body")
            };
            t.prototype.init = function () {
                a('[data-toggle="dragula"]').each(function () {

                    var t = a(this).data("containers"), n = [];
                    if (t) for (var i = 0; i < t.length; i++) n.push(a("#" + t[i])[0]); else n = [a(this)[0]];
                    var r = a(this).data("handleclass");
                    r ? dragula(n, {
                        moves: function (a, t, n) {
                            return n.classList.contains(r)
                        }
                    }) : dragula(n).on('drop', function (el, target, source, sibling) {
                        var order = [];
                        $("#" + target.id + " > div").each(function () {
                            order[$(this).index()] = $(this).attr('data-id');
                        });

                        var id = $(el).attr('data-id');

                        var old_status = $("#" + source.id).data('status');
                        var new_status = $("#" + target.id).data('status');
                        var stage_id = $(target).attr('data-id');


                        $("#" + source.id).parent().find('.count').text($("#" + source.id + " > div").length);
                        $("#" + target.id).parent().find('.count').text($("#" + target.id + " > div").length);
                        $.ajax({
                            url: '<?php echo e(route('job.application.order')); ?>',
                            type: 'POST',
                            data: {application_id: id, stage_id: stage_id, order: order, new_status: new_status, old_status: old_status, "_token": $('meta[name="csrf-token"]').attr('content')},
                            success: function (data) {
                                show_toastr('Success', 'Lead successfully updated', 'success');
                            },
                            error: function (data) {
                                data = data.responseJSON;
                                show_toastr('Error', data.error, 'error')
                            }
                        });
                    });
                })
            }, a.Dragula = new t, a.Dragula.Constructor = t
        }(window.jQuery), function (a) {
            "use strict";

            a.Dragula.init()

        }(window.jQuery);
        <?php endif; ?>

    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('action-button'); ?>
    <div class="row d-flex justify-content-end">
        <div class="col-auto">
            <?php echo e(Form::open(array('route' => array('job-application.index'),'method'=>'get','id'=>'applicarion_filter'))); ?>

            <?php echo e(Form::label('start_date',__('Start Date'),['class'=>'text-type'])); ?>

            <?php echo e(Form::text('start_date',$filter['start_date'],array('class'=>'month-btn form-control datepicker'))); ?>

        </div>
        <div class="col-auto">
            <?php echo e(Form::label('end_date',__('End Date'),['class'=>'text-type'])); ?>

            <?php echo e(Form::text('end_date',$filter['end_date'],array('class'=>'month-btn form-control datepicker'))); ?>

        </div>
        <div class="col-auto">
            <?php echo e(Form::label('job', __('Job'),['class'=>'text-type'])); ?>

            <?php echo e(Form::select('job', $jobs,$filter['job'], array('class' => 'form-control select2'))); ?>

        </div>

        <div class="col-auto my-custom">
            <a href="#" class="apply-btn" onclick="document.getElementById('applicarion_filter').submit(); return false;" data-toggle="tooltip" data-original-title="<?php echo e(__('apply')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
            </a>
            <a href="<?php echo e(route('job-application.index')); ?>" class="reset-btn" data-toggle="tooltip" data-original-title="<?php echo e(__('Reset')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-trash-restore-alt"></i></span>
            </a>

        </div>
        <div class="col-auto  my-custom-btn">
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create job application')): ?>
              <a href="#" data-url="<?php echo e(route('job-application.create')); ?>" data-ajax-popup="true" class="btn btn-xs btn-white btn-icon-only width-auto" data-title="<?php echo e(__('Create New Job Application')); ?>">
                  <i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

              </a>
          <?php endif; ?>
        </div>
    </div>
    <?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="card overflow-hidden mt-0">
        <div class="container-kanban">
            <?php

                $json = [];
                foreach ($stages as $stage){
                    $json[] = 'kanban-blacklist-'.$stage->id;
                }
            ?>
            <div class="kanban-board" data-toggle="dragula" data-containers='<?php echo json_encode($json); ?>'>
                <?php $__currentLoopData = $stages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $applications = $stage->applications($filter) ?>

                    <div class="kanban-col px-0">
                        <div class="card-list card-list-flush">
                            <div class="card-list-title row align-items-center mb-3">
                                <div class="col">
                                    <h6 class="mb-0 text-white"><?php echo e($stage->title); ?></h6>
                                </div>
                                <div class="col text-right">
                                    <span class="badge badge-secondary rounded-pill"><?php echo e(count($applications)); ?></span>
                                </div>
                            </div>

                            <div class="card-list-body" id="kanban-blacklist-<?php echo e($stage->id); ?>" data-id="<?php echo e($stage->id); ?>">
                                <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $application): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="card card-progress draggable-item border shadow-none" data-id="<?php echo e($application->id); ?>">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <h6 class="text-sm"><a href="<?php echo e(route('job-application.show',\Crypt::encrypt($application->id))); ?>"><?php echo e($application->name); ?></a></h6>
                                                </div>
                                                <div class="col-auto text-right">
                                                    <div class="actions">
                                                        <div class="dropdown">
                                                            <a href="#" class="action-item" data-toggle="dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fas fa-ellipsis-h"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(22px, 31px, 0px);">
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show job application')): ?>
                                                                    <a class="dropdown-item" href="<?php echo e(route('job-application.show',\Crypt::encrypt($application->id))); ?>"> <?php echo e(__('Show')); ?></a>
                                                                <?php endif; ?>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete job application')): ?>
                                                                    <a class="dropdown-item" href="#" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-<?php echo e($application->id); ?>').submit();"> <?php echo e(__('Delete')); ?></a>

                                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['job-application.destroy', $application->id],'id'=>'delete-form-'.$application->id]); ?>

                                                                    <?php echo Form::close(); ?>

                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row align-items-center">
                                                <div class="col-md-12">
                                                    <span class="static-rating static-rating-sm d-block">
                                                    <?php for($i=1; $i<=5; $i++): ?>
                                                            <?php if($i <= $application->rating): ?>
                                                                <i class="star fas fa-star voted"></i>
                                                            <?php else: ?>
                                                                <i class="star fas fa-star"></i>
                                                            <?php endif; ?>
                                                        <?php endfor; ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <small><?php echo e(!empty($application->jobs)?$application->jobs->title:''); ?></small>
                                            <div class="row align-items-center">
                                                <div class="col-auto text-sm">
                                                    <div class="actions d-inline-block">
                                                        <i class="fas fa-clock mr-2" data-ajax-popup="true" data-title="<?php echo e(__('Applied at')); ?>"></i><?php echo e(\Auth::user()->dateFormat($application->created_at)); ?>

                                                    </div>
                                                </div>
                                                <div class="col text-right">
                                                    <div class="avatar-group hover-avatar-ungroup">
                                                        <a href="#" class="avatar rounded-circle avatar-sm">
                                                            <img src="<?php echo e(!empty($application->profile)? asset('/storage/uploads/job/profile/'.$application->profile):asset('/storage/uploads/avatar/avatar.png')); ?>" class="hweb">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <span class="empty-container" data-placeholder="Empty"></span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/jobApplication/index.blade.php ENDPATH**/ ?>