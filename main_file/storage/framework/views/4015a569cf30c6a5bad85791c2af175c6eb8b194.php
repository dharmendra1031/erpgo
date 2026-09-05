<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Job OnBoard')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-button'); ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create interview schedule')): ?>
        <a href="#" data-url="<?php echo e(route('job.on.board.create',0)); ?>" data-ajax-popup="true" class="btn btn-xs btn-white btn-icon-only width-auto" data-title="<?php echo e(__('Create New Job OnBoard')); ?>">
            <i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

        </a>
    <?php endif; ?>

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
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Job')); ?></th>
                                <th><?php echo e(__('Branch')); ?></th>
                                <th><?php echo e(__('Applied at')); ?></th>
                                <th><?php echo e(__('Joining at')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            <?php $__currentLoopData = $jobOnBoards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(!empty($job->applications)?$job->applications->name:'-'); ?></td>
                                    <td><?php echo e(!empty($job->applications)?!empty($job->applications->jobs)?$job->applications->jobs->title:'-':'-'); ?></td>
                                    <td><?php echo e(!empty($job->applications)?!empty($job->applications->jobs)?!empty($job->applications->jobs)?!empty($job->applications->jobs->branches)?$job->applications->jobs->branches->name:'-':'-':'-':'-'); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat(!empty($job->applications)?$job->applications->created_at:'-' )); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($job->joining_date)); ?></td>
                                    <td>
                                        <?php if($job->status=='pending'): ?>
                                            <span class="badge badge-soft-warning"><?php echo e(\App\Models\JobOnBoard::$status[$job->status]); ?></span>
                                        <?php elseif($job->status=='cancel'): ?>
                                            <span class="badge badge-soft-danger"><?php echo e(\App\Models\JobOnBoard::$status[$job->status]); ?></span>
                                        <?php else: ?>
                                            <span class="badge badge-soft-success"><?php echo e(\App\Models\JobOnBoard::$status[$job->status]); ?></span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if($job->status=='confirm' && $job->convert_to_employee==0): ?>
                                            <a href="<?php echo e(route('job.on.board.convert', $job->id)); ?>" class="edit-icon bg-info" data-toggle="tooltip" data-original-title="<?php echo e(__('Convert to Employee')); ?>"><i class="fas fa-exchange-alt"></i></a>
                                        <?php elseif($job->status=='confirm' && $job->convert_to_employee!=0): ?>
                                            <a href="<?php echo e(route('employee.show', \Crypt::encrypt($job->convert_to_employee))); ?>" class="edit-icon bg-info" data-toggle="tooltip" data-original-title="<?php echo e(__('Employee Detail')); ?>"><i class="fas fa-eye"></i></a>
                                        <?php endif; ?>

                                        <a href="#" data-url="<?php echo e(route('job.on.board.edit', $job->id)); ?>" data-ajax-popup="true" class="edit-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"><i class="fas fa-pencil-alt"></i></a>

                                        <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($job->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['job.on.board.delete', $job->id],'id'=>'delete-form-'.$job->id]); ?>

                                        <?php echo Form::close(); ?>


                                    </td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/jobApplication/onboard.blade.php ENDPATH**/ ?>