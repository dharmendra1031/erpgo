<?php
    $dir = asset(Storage::url('uploads/plan'));
?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Plan')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create plan')): ?>
            <?php if(isset($admin_payment_setting) && !empty($admin_payment_setting)): ?>
                <?php if($admin_payment_setting['is_stripe_enabled'] == 'on' || $admin_payment_setting['is_paypal_enabled'] == 'on' || $admin_payment_setting['is_paystack_enabled'] == 'on' || $admin_payment_setting['is_flutterwave_enabled'] == 'on'|| $admin_payment_setting['is_razorpay_enabled'] == 'on' || $admin_payment_setting['is_mercado_enabled'] == 'on'|| $admin_payment_setting['is_paytm_enabled'] == 'on'  || $admin_payment_setting['is_mollie_enabled'] == 'on'||
                $admin_payment_setting['is_skrill_enabled'] == 'on' || $admin_payment_setting['is_coingate_enabled'] == 'on'): ?>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                        <a href="#" data-url="<?php echo e(route('plans.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Plan')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto">
                            <i class="fas fa-plus"></i> <?php echo e(__('Create')); ?>

                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 mb-4">
                <div class="plan-3">
                    <h6><?php echo e($plan->name); ?></h6>
                    <p class="price">
                        <sup><?php echo e((env('CURRENCY_SYMBOL')) ? env('CURRENCY_SYMBOL') : '$'); ?></sup>
                        <?php echo e($plan->price); ?>

                        <sub><?php echo e(__('Duration : ').ucfirst($plan->duration)); ?></sub>
                    </p>
                    <p class="price-text"></p>
                    <div class="row">
                        <div class="col-6">
                            <ul class="plan-detail">
                                <li><?php echo e(($plan->max_users==-1)?__('Unlimited'):$plan->max_users); ?> <?php echo e(__('Users')); ?></li>
                                <li><?php echo e(($plan->max_customers==-1)?__('Unlimited'):$plan->max_customers); ?> <?php echo e(__('Customers')); ?></li>
                                <li><?php echo e(($plan->max_venders==-1)?__('Unlimited'):$plan->max_venders); ?> <?php echo e(__('Vendors')); ?></li>
                                <li><?php echo e(($plan->max_clients==-1)?__('Unlimited'):$plan->max_clients); ?> <?php echo e(__('Clients')); ?></li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul class="plan-detail">
                                <li><?php echo e(($plan->account==1)?__('Enable'):__('Disable')); ?> <?php echo e(__('Account')); ?></li>
                                <li><?php echo e(($plan->crm==1)?__('Enable'):__('Disable')); ?> <?php echo e(__('CRM')); ?></li>
                                <li><?php echo e(($plan->hrm==1)?__('Enable'):__('Disable')); ?> <?php echo e(__('HRM')); ?></li>
                                <li><?php echo e(($plan->project==1)?__('Enable'):__('Disable')); ?> <?php echo e(__('Project')); ?></li>
                            </ul>
                        </div>
                    </div>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit plan')): ?>
                        <a title="<?php echo e(__('Edit Plan')); ?>" href="#" class="button text-xs" data-url="<?php echo e(route('plans.edit',$plan->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Plan')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                            <i class="far fa-edit"></i>
                        </a>
                    <?php endif; ?>
                    <?php if(isset($admin_payment_setting) && !empty($admin_payment_setting)): ?>
                        <?php if($admin_payment_setting['is_stripe_enabled'] == 'on' || $admin_payment_setting['is_paypal_enabled'] == 'on' || $admin_payment_setting['is_paystack_enabled'] == 'on' || $admin_payment_setting['is_flutterwave_enabled'] == 'on'|| $admin_payment_setting['is_razorpay_enabled'] == 'on' || $admin_payment_setting['is_mercado_enabled'] == 'on'|| $admin_payment_setting['is_paytm_enabled'] == 'on'  || $admin_payment_setting['is_mollie_enabled'] == 'on'||
                        $admin_payment_setting['is_skrill_enabled'] == 'on' || $admin_payment_setting['is_coingate_enabled'] == 'on'): ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('buy plan')): ?>
                                <?php if($plan->id != \Auth::user()->plan): ?>
                                    <?php if($plan->price > 0): ?>
                                        <a href="<?php echo e(route('stripe',\Illuminate\Support\Facades\Crypt::encrypt($plan->id))); ?>" class="button text-xs mr-1"><?php echo e(__('Buy Plan')); ?></a>
                                    <?php else: ?>
                                        <a href="#" class="button text-xs mr-1"><?php echo e(__('Free')); ?></a>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if($plan->id != 1 && $plan->id != \Auth::user()->plan): ?>
                                    <?php if(\Auth::user()->requested_plan != $plan->id): ?>
                                        <form method="POST" action="<?php echo e(route('send.request',[\Illuminate\Support\Facades\Crypt::encrypt($plan->id)])); ?>" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="button text-xs badge-success border-0" data-title="<?php echo e(__('Send Request')); ?>" data-toggle="tooltip">
                                                <span class="btn-inner--icon"><i class="fas fa-share"></i></span>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form method="POST" action="<?php echo e(route('request.cancel')); ?>" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="button text-xs bg-danger border-0" data-title="<?php echo e(__('Cancel Request')); ?>" data-toggle="tooltip">
                                                <span class="btn-inner--icon"><i class="fas fa-times"></i></span>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if(\Auth::user()->type=='company' && \Auth::user()->plan == $plan->id): ?>
                        <p class="server-plan text-white">
                            <?php echo e(__('Plan Expired : ')); ?> <?php echo e(!empty(\Auth::user()->plan_expire_date) ? \Auth::user()->dateFormat(\Auth::user()->plan_expire_date):'Unlimited'); ?>

                        </p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/plan/index.blade.php ENDPATH**/ ?>