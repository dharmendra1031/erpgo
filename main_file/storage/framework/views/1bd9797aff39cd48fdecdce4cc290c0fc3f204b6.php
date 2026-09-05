<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Labels')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create label')): ?>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="#" data-url="<?php echo e(route('labels.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create Label')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto"><i class="fas fa-plus"></i> <?php echo e(__('Create')); ?> </a>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <?php if($pipelines): ?>
                <ul class="nav nav-tabs my-3">
                    <?php ($i=0); ?>
                    <?php $__currentLoopData = $pipelines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $pipeline): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="nav-item">
                            <a class="<?php if($i==0): ?> active <?php endif; ?>" data-toggle="tab" href="#tab<?php echo e($key); ?>" role="tab" aria-controls="home" aria-selected="true"><?php echo e($pipeline['name']); ?></a>
                        </li>
                        <?php ($i++); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        </div>
        <div class="col-md-12">
            <?php if($pipelines): ?>
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content tab-bordered">
                            <?php ($i=0); ?>
                            <?php $__currentLoopData = $pipelines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $pipeline): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="tab-pane fade show <?php if($i==0): ?> active <?php endif; ?>" id="tab<?php echo e($key); ?>" role="tabpanel">
                                    <ul class="list-group sortable">
                                        <?php $__currentLoopData = $pipeline['labels']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="list-group-item" data-id="<?php echo e($label->id); ?>">
                                                <div class="badge badge-pill badge-<?php echo e($label->color); ?>"><?php echo e($label->name); ?></div>
                                                <span class="float-right">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit label')): ?>
                                                        <a href="#" data-url="<?php echo e(URL::to('labels/'.$label->id.'/edit')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Labels')); ?>" class="edit-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"><i class="fas fa-pencil-alt"></i></a>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete label')): ?>
                                                        <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($label->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['labels.destroy', $label->id],'id'=>'delete-form-'.$label->id]); ?>

                                                        <?php echo Form::close(); ?>

                                                    <?php endif; ?>
                                        </span>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                                <?php ($i++); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/labels/index.blade.php ENDPATH**/ ?>