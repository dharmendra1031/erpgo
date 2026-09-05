<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Plan-Request')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Plan Request')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" width="100%">
                            <tbody>
                            <?php if($plan_requests->count() > 0): ?>
                                <?php $__currentLoopData = $plan_requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prequest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="font-style font-weight-bold"><?php echo e($prequest->user->name); ?></div>
                                        </td>
                                        <td>
                                            <div class="font-style font-weight-bold"><?php echo e($prequest->plan->name); ?></div>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold"><?php echo e($prequest->plan->max_users); ?></div>
                                            <div><?php echo e(__('Users')); ?></div>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold"><?php echo e($prequest->plan->max_clients); ?></div>
                                            <div><?php echo e(__('Clients')); ?></div>
                                        </td>
                                        <td>
                                            <div class="font-style font-weight-bold"><?php echo e(($prequest->duration == 'monthly') ? __('One Month') : __('One Year')); ?></div>
                                        </td>
                                        <td><?php echo e(Utility::getDateFormated($prequest->created_at,true)); ?></td>
                                        <td>
                                            <div>
                                                <form method="POST" action="<?php echo e(route('response.request',[$prequest->id,1])); ?>" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-success btn-xs"><i class="fas fa-check"></i></button>
                                                </form>
                                                <form method="POST" action="<?php echo e(route('response.request',[$prequest->id,0])); ?>" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-times"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tr>
                                    <th scope="col" colspan="7"><h6 class="text-center"><?php echo e(__('No Manually Plan Request Found.')); ?></h6></th>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/plan_request/index.blade.php ENDPATH**/ ?>