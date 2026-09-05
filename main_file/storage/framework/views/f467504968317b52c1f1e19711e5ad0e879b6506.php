<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Credit Notes')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).on('change', '#invoice', function () {

            var id = $(this).val();
            var url = "<?php echo e(route('invoice.get')); ?>";

            $.ajax({
                url: url,
                type: 'get',
                cache: false,
                data: {
                    'id': id,

                },
                success: function (data) {
                    $('#amount').val(data)
                },

            });

        })
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('action-button'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create credit note')): ?>
        <div class="all-button-box row d-flex justify-content-end">
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="#" data-url="<?php echo e(route('invoice.custom.credit.note')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Credit Note')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto">
                    <i class="fas fa-plus"></i> <?php echo e(__('Create')); ?>

                </a>
            </div>
        </div>
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
                                <th> <?php echo e(__('Invoice')); ?></th>
                                <th> <?php echo e(__('Customer')); ?></th>
                                <th> <?php echo e(__('Date')); ?></th>
                                <th> <?php echo e(__('Amount')); ?></th>
                                <th> <?php echo e(__('Description')); ?></th>
                                <th> <?php echo e(__('Action')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!empty($invoice->creditNote)): ?>
                                    <?php $__currentLoopData = $invoice->creditNote; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $creditNote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="Id">
                                                <a href="<?php echo e(route('invoice.show',\Crypt::encrypt($creditNote->invoice))); ?>"><?php echo e(AUth::user()->invoiceNumberFormat($invoice->invoice_id)); ?></a>
                                            </td>
                                            <td><?php echo e((!empty($invoice->customer)?$invoice->customer->name:'-')); ?></td>
                                            <td><?php echo e(Auth::user()->dateFormat($creditNote->date)); ?></td>
                                            <td><?php echo e(Auth::user()->priceFormat($creditNote->amount)); ?></td>
                                            <td><?php echo e(!empty($creditNote->description)?$creditNote->description:'-'); ?></td>
                                            <td>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit credit note')): ?>
                                                    <a data-url="<?php echo e(route('invoice.edit.credit.note',[$creditNote->invoice,$creditNote->id])); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Credit Note')); ?>" href="#" class="edit-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit credit note')): ?>
                                                    <a href="#" class="delete-icon " data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($creditNote->id); ?>').submit();">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => array('invoice.delete.credit.note', $creditNote->invoice,$creditNote->id),'id'=>'delete-form-'.$creditNote->id]); ?>

                                                    <?php echo Form::close(); ?>

                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/creditNote/index.blade.php ENDPATH**/ ?>