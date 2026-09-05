<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Bug Report')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
      <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
        <?php if($view == 'grid'): ?>
            <a href="<?php echo e(route('bugs.view', 'list')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto">
                <span class="btn-inner--text"><i class="fas fa-list"></i><?php echo e(__('List View')); ?></span>
            </a>
        <?php else: ?>
            <a href="<?php echo e(route('bugs.view', 'grid')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto">
                <span class="btn-inner--text"><i class="fas fa-table"></i><?php echo e(__('Card View')); ?></span>
            </a>
        <?php endif; ?>
      </div>
      <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage project')): ?>

            <a href="<?php echo e(route('projects.index')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto">
                <span class="btn-inner--icon"><i class="fas fa-arrow-left"></i><?php echo e(__('Back')); ?></span>
            </a>
        <?php endif; ?>
      </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
<div class="col-12">
    <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center">
                <thead>
                <tr>
                    <th scope="col"><?php echo e(__('Name')); ?></th>
                    <th scope="col"><?php echo e(__('Bug Status')); ?></th>
                    <th scope="col"><?php echo e(__('Priority')); ?></th>
                    <th scope="col"><?php echo e(__('End Date')); ?></th>
                    <th scope="col"><?php echo e(__('created By')); ?></th>
                    <th scope="col"><?php echo e(__('Assigned To')); ?></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody class="list">
                <?php if(count($bugs) > 0): ?>
                    <?php $__currentLoopData = $bugs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bug): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <span class="h6 text-sm font-weight-bold mb-0"><a href="<?php echo e(route('task.bug',$bug->project_id)); ?>"><?php echo e($bug->title); ?></a></span>
                                <span class="d-block text-sm text-muted"><?php echo e(!empty($bug->project)?$bug->project->project_name:''); ?>

                                    <span class="badge badge-xs badge-<?php echo e((\Auth::user()->checkProject($bug->project_id) == 'Owner') ? 'success' : 'warning'); ?>"><?php echo e(__(\Auth::user()->checkProject($bug->project_id))); ?></span>
                                </span>
                            </td>
                            <td><?php echo e($bug->bug_status->title); ?></td>
                            <td>
                                <span class="badge badge-pill badge-sm badge-<?php echo e(__(\App\Models\ProjectTask::$priority_color[$bug->priority])); ?>"><?php echo e(__(\App\Models\ProjectTask::$priority[$bug->priority])); ?></span>
                            </td>
                            <td class="<?php echo e((strtotime($bug->due_date) < time()) ? 'text-danger' : ''); ?>"><?php echo e(Utility::getDateFormated($bug->due_date)); ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php echo e($bug->createdBy->name); ?>

                                </div>
                            </td>
                            <td>
                                <div class="avatar-group">
                                    <?php if($bug->users()->count() > 0): ?>
                                    <?php $user = $bug->users(); ?>

                                    <a href="#" class="avatar rounded-circle avatar-sm">
                                        <img data-original-title="<?php echo e((!empty($user[0])?$user[0]->name:'')); ?>" <?php if($user[0]->avatar): ?> src="<?php echo e(asset('/storage/uploads/avatar/'.$user[0]->avatar)); ?>" <?php else: ?> src="<?php echo e(asset('assets/img/avatar/avatar-1.png')); ?>" <?php endif; ?> title="<?php echo e($user[0]->name); ?>" class="hweb">
                                    </a>
                                        <?php if($users = $bug->users()): ?>
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($key<3): ?>

                                                <?php else: ?>
                                                    <?php break; ?>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        <?php if(count($users) > 3): ?>
                                            <a href="#" class="avatar rounded-circle avatar-sm">
                                                <img  src="<?php echo e($user->getImgImageAttribute()); ?>">
                                            </a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php echo e(__('-')); ?>

                                    <?php endif; ?>
                                </div>
                            </td>

                            <td class="text-right w-15">
                                <div class="actions">
                                    <a class="action-item px-1" data-toggle="tooltip" data-original-title="<?php echo e(__('Attachment')); ?>">
                                        <i class="fas fa-paperclip mr-2"></i><?php echo e(count($bug->bugFiles)); ?>

                                    </a>
                                    <a class="action-item px-1" data-toggle="tooltip" data-original-title="<?php echo e(__('Comment')); ?>">
                                        <i class="fas fa-comment-alt mr-2"></i><?php echo e(count($bug->comments)); ?>

                                    </a>
                                    <a class="action-item px-1" data-toggle="tooltip" data-original-title="<?php echo e(__('Checklist')); ?>">
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <tr>
                        <th scope="col" colspan="7"><h6 class="text-center"><?php echo e(__('No tasks found')); ?></h6></th>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/projects/allBugListView.blade.php ENDPATH**/ ?>