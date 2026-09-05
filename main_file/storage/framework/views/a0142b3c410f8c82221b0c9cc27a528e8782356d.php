<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Chart of Accounts')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).on('change', '#type', function () {
            var type = $(this).val();
            $.ajax({
                url: '<?php echo e(route('charofAccount.subType')); ?>',
                type: 'POST',
                data: {
                    "type": type, "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function (data) {
                    $('#sub_type').empty();
                    $.each(data, function (key, value) {
                        $('#sub_type').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        });

    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create chart of account')): ?>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="#" data-url="<?php echo e(route('chart-of-account.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Account')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto">
                    <i class="fas fa-plus"></i> <?php echo e(__('Create')); ?>

                </a>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>


    <div class="row">
        <?php $__currentLoopData = $chartAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type=>$accounts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h6><?php echo e($type); ?></h6>
                    </div>
                    <div class="card-body py-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th> <?php echo e(__('Code')); ?></th>
                                    <th> <?php echo e(__('Name')); ?></th>
                                    <th> <?php echo e(__('Type')); ?></th>
                                    <th> <?php echo e(__('Balance')); ?></th>
                                    <th> <?php echo e(__('Status')); ?></th>
                                    <th> <?php echo e(__('Action')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <tr>
                                        <td><?php echo e($account->code); ?></td>
                                        <td><a href="<?php echo e(route('report.ledger')); ?>?account=<?php echo e($account->id); ?>"><?php echo e($account->name); ?></a></td>
                                        <td><?php echo e(!empty($account->subType)?$account->subType->name:'-'); ?></td>
                                        <td>
                                            <?php if(!empty($account->balance()) && $account->balance()['netAmount']<0): ?>
                                                <?php echo e(__('Dr').'. '.\Auth::user()->priceFormat(abs($account->balance()['netAmount']))); ?>

                                            <?php elseif(!empty($account->balance()) && $account->balance()['netAmount']>0): ?>
                                                <?php echo e(__('Cr').'. '.\Auth::user()->priceFormat($account->balance()['netAmount'])); ?>

                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($account->is_enabled==1): ?>
                                                <span class="badge badge-success"><?php echo e(__('Enabled')); ?></span>
                                            <?php else: ?>
                                                <span class="badge badge-danger"><?php echo e(__('Disabled')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="Action">
                                            <a href="<?php echo e(route('report.ledger')); ?>?account=<?php echo e($account->id); ?>" class="edit-icon bg-info" data-toggle="tooltip" data-original-title="<?php echo e(__('Ledger Summary')); ?>">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit chart of account')): ?>
                                                <a href="#" class="edit-icon" data-url="<?php echo e(route('chart-of-account.edit',$account->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Unit')); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete chart of account')): ?>
                                                <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($account->id); ?>').submit();">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['chart-of-account.destroy', $account->id],'id'=>'delete-form-'.$account->id]); ?>

                                                <?php echo Form::close(); ?>

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
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/chartOfAccount/index.blade.php ENDPATH**/ ?>