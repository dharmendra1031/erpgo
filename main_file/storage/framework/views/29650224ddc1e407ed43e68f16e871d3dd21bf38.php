<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Training')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create training')): ?>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
            <a href="#" data-url="<?php echo e(route('training.create')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto" data-ajax-popup="true" data-title="<?php echo e(__('Create New Training')); ?>">
                <i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

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
                        <table class="table table-striped mb-0 dataTable" >
                            <thead>
                            <tr>
                                <th><?php echo e(__('Branch')); ?></th>
                                <th><?php echo e(__('Training Type')); ?></th>
                                <th><?php echo e(__('Employee')); ?></th>
                                <th><?php echo e(__('Trainer')); ?></th>
                                <th><?php echo e(__('Training Duration')); ?></th>
                                <th><?php echo e(__('Cost')); ?></th>
                                <?php if( Gate::check('Edit Training') ||Gate::check('Delete Training') ||Gate::check('Show Training')): ?>
                                    <th width="200px"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            <?php $__currentLoopData = $trainings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(!empty($training->branches)?$training->branches->name:''); ?></td>
                                    <td><?php echo e(!empty($training->types)?$training->types->name:''); ?> <br>
                                        <?php if($training->status == 0): ?>
                                            <span class="text-warning"><?php echo e(__($status[$training->status])); ?></span>
                                        <?php elseif($training->status == 1): ?>
                                            <span class="text-primary"><?php echo e(__($status[$training->status])); ?></span>
                                        <?php elseif($training->status == 2): ?>
                                            <span class="text-success"><?php echo e(__($status[$training->status])); ?></span>
                                        <?php elseif($training->status == 3): ?>
                                            <span class="text-info"><?php echo e(__($status[$training->status])); ?></span>
                                        <?php endif; ?>

                                    </td>
                                    <td><?php echo e(!empty($training->employees)?$training->employees->name:''); ?> </td>
                                    <td><?php echo e(!empty($training->trainers)?$training->trainers->firstname:''); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($training->start_date) .' to '.\Auth::user()->dateFormat($training->end_date)); ?></td>
                                    <td><?php echo e(\Auth::user()->priceFormat($training->training_cost)); ?></td>
                                    <?php if( Gate::check('edit training') ||Gate::check('delete training') || Gate::check('show training')): ?>
                                        <td>

                                                <a href="<?php echo e(route('training.show',\Illuminate\Support\Facades\Crypt::encrypt($training->id))); ?>" class="edit-icon bg-success" data-toggle="tooltip" data-original-title="<?php echo e(__('View Detail')); ?>"><i class="fas fa-eye"></i></a>
                                              <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show training')): ?> -->
                                            <!-- <?php endif; ?> -->
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit training')): ?>
                                                <a href="#" data-url="<?php echo e(route('training.edit',$training->id)); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Edit Training')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit ')); ?>" class="edit-icon"><i class="fas fa-pencil-alt"></i></a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete training')): ?>
                                                <a href="#" class="delete-icon" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($training->id); ?>').submit();" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>"><i class="fas fa-trash"></i></a>
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['training.destroy', $training->id],'id'=>'delete-form-'.$training->id]); ?>

                                                <?php echo Form::close(); ?>

                                            <?php endif; ?>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/training/index.blade.php ENDPATH**/ ?>