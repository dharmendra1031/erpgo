<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Custom Field')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create constant custom field')): ?>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="#" data-url="<?php echo e(route('custom-field.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Custom Field')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto">
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
                                <th> <?php echo e(__('Custom Field')); ?></th>
                                <th> <?php echo e(__('Type')); ?></th>
                                <th> <?php echo e(__('Module')); ?></th>
                                <th> <?php echo e(__('Action')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $custom_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($field->name); ?></td>
                                    <td><?php echo e($field->type); ?></td>
                                    <td><?php echo e($field->module); ?></td>
                                    <?php if(Gate::check('edit constant custom field') || Gate::check('delete constant custom field')): ?>
                                        <td class="Action">
                                            <span>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit constant custom field')): ?>
                                                    <a href="#" class="edit-icon" data-url="<?php echo e(route('custom-field.edit',$field->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Custom Field')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete constant custom field')): ?>
                                                    <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($field->id); ?>').submit();">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['custom-field.destroy', $field->id],'id'=>'delete-form-'.$field->id]); ?>

                                                    <?php echo Form::close(); ?>

                                                <?php endif; ?>
                                            </span>
                                        </td>

                                    <?php endif; ?>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/customFields/index.blade.php ENDPATH**/ ?>