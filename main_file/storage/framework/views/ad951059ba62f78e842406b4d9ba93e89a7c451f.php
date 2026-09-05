<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Zoom Meeting')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css-page'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/daterangepicker.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(url('assets/js/daterangepicker.js')); ?>"></script>
    <script type="text/javascript">

        $(document).on("click", '.member_remove', function () {
            var rid = $(this).attr('data-id');
            $('.confirm_yes').addClass('m_remove');
            $('.confirm_yes').attr('uid', rid);
            $('#cModal').modal('show');
        });
        $(document).on('click', '.m_remove', function (e) {
            var id = $(this).attr('uid');
            var p_url = "<?php echo e(url('zoom-meeting')); ?>"+'/'+id;
            var data = {id: id};
            deleteAjax(p_url, data, function (res) {
                toastrs(res.flag, res.msg);
                if(res.flag == 1){
                    location.reload();
                }
                $('#cModal').modal('hide');
            });
        });
    </script>
<?php $__env->stopPush(); ?>


<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create constant category')): ?>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="<?php echo e(route('zoom-meeting.calender')); ?>"  data-original-title="<?php echo e(__('Calender View')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto">
                    <i class="fas fa-calendar"></i> <?php echo e(__('Calender View')); ?>

                </a>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="#" data-url="<?php echo e(route('zoom-meeting.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Meeting')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto">
                    <i class="fas fa-plus"></i> <?php echo e(__('Create')); ?>

                </a>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 dataTable">
                            <thead>
                            <tr>
                                <th> <?php echo e(__('Title')); ?> </th>
                                <th> <?php echo e(__('Project')); ?>  </th>
                                <th> <?php echo e(__('User')); ?>  </th>
                                <th> <?php echo e(__('Client')); ?>  </th>
                                <th ><?php echo e(__('Meeting Time')); ?></th>
                                <th ><?php echo e(__('Duration')); ?></th>
                                <th ><?php echo e(__('Join URL')); ?></th>
                                <th ><?php echo e(__('Status')); ?></th>
                                <th class="text-right"> <?php echo e(__('Action')); ?></th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php $__empty_1 = true; $__currentLoopData = $meetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                                <tr>
                                    <td><?php echo e($item->title); ?></td>
                                    <td><?php echo e(!empty($item->projectName)?$item->projectName:''); ?></td>

                                <td>
                                    <div class="avatar-group">
                                        <?php $__currentLoopData = $item->users($item->user_id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projectUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="#" class="avatar rounded-circle avatar-sm avatar-group">
                                                <img alt="" <?php if(!empty($users->avatar)): ?> src="<?php echo e($profile.'/'.$projectUser->avatar); ?>" <?php else: ?>  avatar="<?php echo e((!empty($projectUser)?$projectUser->name:'')); ?>" <?php endif; ?> data-original-title="<?php echo e((!empty($projectUser)?$projectUser->name:'')); ?>" data-toggle="tooltip" data-original-title="<?php echo e((!empty($projectUser)?$projectUser->name:'')); ?>" class="">
                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>

                                </td>


                                <?php if(\Auth::user()->type == 'company'): ?>
                                        <td><?php echo e($item->client_name); ?></td>
                                    <?php endif; ?>
                                    <td><?php echo e($item->start_date); ?></td>
                                    <td><?php echo e($item->duration); ?> <?php echo e(__("Minutes")); ?></td>

                                    <td>
                                        <?php if($item->created_by == \Auth::user()->id && $item->checkDateTime()): ?>

                                            <a href="<?php echo e($item->start_url); ?>" target="_blank"> <?php echo e(__('Start meeting')); ?> <i class="fas fa-external-link-square-alt "></i></a>
                                        <?php elseif($item->checkDateTime()): ?>
                                            <a href="<?php echo e($item->join_url); ?>" target="_blank"> <?php echo e(__('Join meeting')); ?> <i class="fas fa-external-link-square-alt "></i></a>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>

                                    </td>
                                    <td>
                                        <?php if($item->checkDateTime()): ?>
                                            <?php if($item->status == 'waiting'): ?>
                                                <span class="badge badge-info"><?php echo e(ucfirst($item->status)); ?></span>
                                            <?php else: ?>
                                                <span class="badge badge-success"><?php echo e(ucfirst($item->status)); ?></span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge badge-danger"><?php echo e(__("End")); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <?php if(\Auth::user()->type == 'company'): ?>
                                        <td class="text-right">
                                            <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($item->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['zoom-meeting.destroy', $item->id],'id'=>'delete-form-'.$item->id]); ?>

                                            <?php echo Form::close(); ?>


                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/zoom-meeting/index.blade.php ENDPATH**/ ?>