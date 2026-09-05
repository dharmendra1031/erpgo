<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Ledger Summary')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/html2pdf.bundle.min.js')); ?>"></script>
    <script>
        var filename = $('#filename').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A2'}
            };
            html2pdf().set(opt).from(element).save();
        }

    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('action-button'); ?>
    <div class="row d-flex justify-content-end">
        <div class="col-auto">
            <?php echo e(Form::open(array('route' => array('report.ledger'),'method' => 'GET','id'=>'report_ledger'))); ?>

            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('start_date', __('Start Date'),['class'=>'text-type'])); ?>

                    <?php echo e(Form::date('start_date',$filter['startDateRange'], array('class' => 'month-btn form-control'))); ?>

                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('end_date', __('End Date'),['class'=>'text-type'])); ?>

                    <?php echo e(Form::date('end_date',$filter['endDateRange'], array('class' => 'month-btn form-control'))); ?>

                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('account', __('Account'),['class'=>'text-type'])); ?>

                    <?php echo e(Form::select('account',$accounts,isset($_GET['account'])?$_GET['account']:'', array('class' => 'form-control select2'))); ?>

                </div>
            </div>
        </div>
        <div class="col-auto my-custom">
            <a href="#" class="apply-btn" onclick="document.getElementById('report_ledger').submit(); return false;" data-toggle="tooltip" data-original-title="<?php echo e(__('apply')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
            </a>
            <a href="<?php echo e(route('report.ledger')); ?>" class="reset-btn" data-toggle="tooltip" data-original-title="<?php echo e(__('Reset')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-trash-restore-alt"></i></span>
            </a>
            <a href="#" class="action-btn" onclick="saveAsPDF()" data-toggle="tooltip" data-original-title="<?php echo e(__('Download')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-download"></i></span>
            </a>
        </div>
    </div>
    <?php echo e(Form::close()); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div id="printableArea">
        <div class="row mt-4">
            <div class="col">
                <input type="hidden" value="<?php echo e(__('Ledger').' '.'Report of'.' '.$filter['startDateRange'].' to '.$filter['endDateRange']); ?>" id="filename">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Report')); ?> :</h5>
                    <h5 class="report-text mb-0"><?php echo e(__('Ledger Summary')); ?></h5>
                </div>
            </div>

            <div class="col">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Duration')); ?> :</h5>
                    <h5 class="report-text mb-0"><?php echo e($filter['startDateRange'].' to '.$filter['endDateRange']); ?></h5>
                </div>
            </div>
        </div>
        <?php if(!empty($account)): ?>
            <div class="row mt-4">
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0"><?php echo e(__('Account Name')); ?> :</h5>
                        <h5 class="report-text mb-0"><?php echo e($account->name); ?></h5>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0"><?php echo e(__('Account Code')); ?> :</h5>
                        <h5 class="report-text mb-0"><?php echo e($account->code); ?></h5>
                    </div>
                </div>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0"><?php echo e(__('Total Debit')); ?> :</h5>
                        <h5 class="report-text mb-0"><?php echo e(\Auth::user()->priceFormat($filter['debit'])); ?></h5>
                    </div>
                </div>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0"><?php echo e(__('Total Credit')); ?> :</h5>
                        <h5 class="report-text mb-0"><?php echo e(\Auth::user()->priceFormat($filter['credit'])); ?></h5>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0"><?php echo e(__('Balance')); ?> :</h5>
                        <h5 class="report-text mb-0"><?php echo e(($filter['balance']>0)?__('Cr').'. '.\Auth::user()->priceFormat(abs($filter['balance'])):__('Dr').'. '.\Auth::user()->priceFormat(abs($filter['balance']))); ?></h5>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row mb-4">
            <div class="col-12 mb-4">
                <table class="table table-flush">
                    <thead>
                    <tr>
                        <th> #</th>
                        <th> <?php echo e(__('Transaction Date')); ?></th>
                        <th> <?php echo e(__('Create At')); ?></th>
                        <th> <?php echo e(__('Description')); ?></th>
                        <th> <?php echo e(__('Debit')); ?></th>
                        <th> <?php echo e(__('Credit')); ?></th>
                        <th> <?php echo e(__('Balance')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $balance=0;$debit=0;$credit=0; ?>
                    <?php $__currentLoopData = $journalItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="Id">
                                <a href="<?php echo e(route('journal-entry.show',$item->journal)); ?>"><?php echo e(AUth::user()->journalNumberFormat($item->journal_id)); ?></a>
                            </td>

                            <td><?php echo e(\Auth::user()->dateFormat($item->transaction_date)); ?></td>
                            <td><?php echo e(\Auth::user()->dateFormat($item->created_at)); ?></td>
                            <td><?php echo e(!empty($item->description)?$item->description:'-'); ?></td>
                            <td><?php echo e(\Auth::user()->priceFormat($item->debit)); ?></td>
                            <td><?php echo e(\Auth::user()->priceFormat($item->credit)); ?></td>
                            <td>
                                <?php if($item->debit>0): ?>
                                    <?php $debit+=$item->debit ?>
                                <?php else: ?>
                                    <?php $credit+=$item->credit ?>
                                <?php endif; ?>

                                <?php $balance= $credit-$debit ?>
                                <?php if($balance>0): ?>
                                    <?php echo e(__('Cr').'. '.\Auth::user()->priceFormat($balance)); ?>


                                <?php elseif($balance<0): ?>
                                    <?php echo e(__('Dr').'. '.\Auth::user()->priceFormat(abs($balance))); ?>

                                <?php else: ?>
                                    <?php echo e(\Auth::user()->priceFormat(0)); ?>

                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/report/ledger_summary.blade.php ENDPATH**/ ?>