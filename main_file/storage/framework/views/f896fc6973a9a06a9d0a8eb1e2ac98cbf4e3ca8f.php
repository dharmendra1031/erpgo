<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Orders')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped dataTable" width="100%">
                            <thead>
                            <tr>
                                <th><?php echo e(__('Order Id')); ?></th>
                                <th><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Plan Name')); ?></th>
                                <th><?php echo e(__('Price')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Payment Type')); ?></th>
                                <th><?php echo e(__('Date')); ?></th>
                                <th><?php echo e(__('Coupon')); ?></th>
                                <th><?php echo e(__('Invoice')); ?></th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($order->order_id); ?></td>
                                    <td><?php echo e($order->user_name); ?></td>
                                    <td><?php echo e($order->plan_name); ?></td>
                                    <td>$ <?php echo e(number_format($order->price)); ?></td>
                                    <td>
                                        <?php if($order->payment_status == 'succeeded'): ?>
                                            <span class="badge badge-pill badge-success"><?php echo e(ucfirst($order->payment_status)); ?></span>
                                        <?php else: ?>
                                            <span class="badge badge-pill badge-danger"><?php echo e(ucfirst($order->payment_status)); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($order->payment_type); ?></td>
                                    <td><?php echo e($order->created_at->format('d M Y')); ?></td>
                                    <td><?php echo e(!empty($order->use_coupon)?$order->use_coupon->coupon_detail->name:'-'); ?></td>
                                    <td class="Id">
                                        <?php if(empty($order->receipt)): ?>
                                            <p><?php echo e(__('Manually plan upgraded by Super Admin')); ?></p>
                                        <?php elseif($order->receipt =='free coupon'): ?>
                                            <p><?php echo e(__('Used 100 % discount coupon code.')); ?></p>
                                        <?php else: ?>
                                            <a href="<?php echo e($order->receipt); ?>" target="_blank"><i class="fas fa-file-invoice"></i> <?php echo e(__('Invoice')); ?></a>
                                        <?php endif; ?>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/order/index.blade.php ENDPATH**/ ?>