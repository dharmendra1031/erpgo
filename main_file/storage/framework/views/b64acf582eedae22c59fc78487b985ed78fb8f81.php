<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Product & Services')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>

    <div class="all-button-box row d-flex justify-content-end">

        <div class="col-3">
            <?php echo e(Form::open(array('route' => array('productservice.index'),'method' => 'GET','id'=>'product_service'))); ?>

            <?php echo e(Form::select('category', $category,null, array('class' => 'form-control select2','required'=>'required'))); ?>

        </div>
        <div class="col-auto">
            <a href="#" class="apply-btn" onclick="document.getElementById('product_service').submit(); return false;" data-toggle="tooltip" data-original-title="<?php echo e(__('apply')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
            </a>
            <a href="<?php echo e(route('productservice.index')); ?>" class="reset-btn" data-toggle="tooltip" data-original-title="<?php echo e(__('Reset')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-trash-restore-alt"></i></span>
            </a>
        </div>
        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
            <a href="#" data-url="<?php echo e(route('productservice.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Product')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto">
                <i class="fa fa-plus"></i> <?php echo e(__('Create')); ?>

            </a>
        </div>
        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
            <div class="all-button-box">
                <a href="<?php echo e(route('productservice.export')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto">
                    <i class="fa fa-file-excel"></i> <?php echo e(__('Export')); ?>

                </a>
            </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
            <div class="all-button-box">
                <a href="#" class="btn btn-xs btn-white btn-icon-only width-auto" data-url="<?php echo e(route('productservice.file.import')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Import product CSV file')); ?>">
                    <i class="fa fa-file-csv"></i> <?php echo e(__('Import')); ?>

                </a>
            </div>
        </div>
    </div>
    <?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="">
        <div class="col-12">
            <div class="card">
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 dataTable">
                            <thead>
                            <tr role="row">
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Sku')); ?></th>
                                <th><?php echo e(__('Sale Price')); ?></th>
                                <th><?php echo e(__('Purchase Price')); ?></th>
                                <th><?php echo e(__('Tax')); ?></th>
                                <th><?php echo e(__('Category')); ?></th>
                                <th><?php echo e(__('Unit')); ?></th>
                                <th><?php echo e(__('Quantity')); ?></th>
                                <th><?php echo e(__('Type')); ?></th>
                            <!-- <th><?php echo e(__('Description')); ?></th> -->
                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php $__currentLoopData = $productServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="font-style">
                                    <td><?php echo e($productService->name); ?></td>
                                    <td><?php echo e($productService->sku); ?></td>
                                    <td><?php echo e(\Auth::user()->priceFormat($productService->sale_price)); ?></td>
                                    <td><?php echo e(\Auth::user()->priceFormat($productService->purchase_price )); ?></td>
                                    <td>
                                        <?php if(!empty($productService->tax_id)): ?>
                                            <?php
                                                $taxes=\Utility::tax($productService->tax_id);
                                            ?>

                                            <?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e(!empty($tax)?$tax->name:''); ?><br>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e(!empty($productService->category)?$productService->category->name:''); ?></td>
                                    <td><?php echo e(!empty($productService->unit())?$productService->unit()->name:''); ?></td>
                                    <td><?php echo e($productService->quantity); ?></td>
                                    <td><?php echo e($productService->type); ?></td>
                                <!-- <td><?php echo e($productService->description); ?></td> -->

                                    <?php if(Gate::check('edit product & service') || Gate::check('delete product & service')): ?>
                                        <td class="Action">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit product & service')): ?>
                                                <a href="#" class="edit-icon" data-url="<?php echo e(route('productservice.edit',$productService->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Product Service')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete product & service')): ?>
                                                <a href="#" class="delete-icon " data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($productService->id); ?>').submit();">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['productservice.destroy', $productService->id],'id'=>'delete-form-'.$productService->id]); ?>

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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/productservice/index.blade.php ENDPATH**/ ?>