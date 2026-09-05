<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Income Summary')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('theme-script'); ?>
    <script src="<?php echo e(asset('assets/libs/apexcharts/dist/apexcharts.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        var e = $("#chart-sales");
        !function (e) {
            var t = {
                chart: {width: "100%", zoom: {enabled: !1}, toolbar: {show: !1}, shadow: {enabled: !1}},
                stroke: {width: 6, curve: "smooth"},
                series: [{name: "<?php echo e(__('Income')); ?>", data: <?php echo json_encode($chartIncomeArr); ?>}],
                xaxis: {labels: {format: "MMM", style: {colors: PurposeStyle.colors.gray[600], fontSize: "14px", fontFamily: PurposeStyle.fonts.base, cssClass: "apexcharts-xaxis-label"}}, axisBorder: {show: !1}, axisTicks: {show: !0, borderType: "solid", color: PurposeStyle.colors.gray[300], height: 6, offsetX: 0, offsetY: 0}, type: "text", categories: <?php echo json_encode($monthList); ?>},
                yaxis: {labels: {style: {color: PurposeStyle.colors.gray[600], fontSize: "12px", fontFamily: PurposeStyle.fonts.base}}, axisBorder: {show: !1}, axisTicks: {show: !0, borderType: "solid", color: PurposeStyle.colors.gray[300], height: 6, offsetX: 0, offsetY: 0}},
                fill: {type: "solid"},
                markers: {size: 4, opacity: .7, strokeColor: "#fff", strokeWidth: 3, hover: {size: 7}},
                grid: {borderColor: PurposeStyle.colors.gray[300], strokeDashArray: 5},
                dataLabels: {enabled: !1}
            }, a = (e.data().dataset, e.data().labels, e.data().color), n = e.data().height, o = e.data().type;
            t.colors = [PurposeStyle.colors.theme[a]], t.markers.colors = [PurposeStyle.colors.theme[a]], t.chart.height = n || 350, t.chart.type = o || "line";
            var i = new ApexCharts(e[0], t);
            setTimeout(function () {
                i.render()
            }, 400)
        }($("#chart-sales"));
    </script>
    <script type="text/javascript" src="<?php echo e(asset('js/html2pdf.bundle.min.js')); ?>"></script>
    <script>
        var year = '<?php echo e($currentYear); ?>';
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
        <div class="col">
            <?php echo e(Form::open(array('route' => array('report.income.summary'),'method' => 'GET','id'=>'report_income_summary'))); ?>

            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('year', __('Year'),['class'=>'text-type'])); ?>

                    <?php echo e(Form::select('year',$yearList,isset($_GET['year'])?$_GET['year']:'', array('class' => 'form-control select2'))); ?>

                </div>
            </div>
        </div>
        <div class="col">
            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('category', __('Category'),['class'=>'text-type'])); ?>

                    <?php echo e(Form::select('category',$category,isset($_GET['category'])?$_GET['category']:'', array('class' => 'form-control select2'))); ?>

                </div>
            </div>
        </div>
        <div class="col">
            <div class="all-select-box">
                <div class="btn-box">
                    <?php echo e(Form::label('customer', __('Customer'),['class'=>'text-type'])); ?>

                    <?php echo e(Form::select('customer',$customer,isset($_GET['customer'])?$_GET['customer']:'', array('class' => 'form-control select2'))); ?>

                </div>
            </div>
        </div>
        <div class="col-auto my-custom">
            <a href="#" class="apply-btn" onclick="document.getElementById('report_income_summary').submit(); return false;" data-toggle="tooltip" data-original-title="<?php echo e(__('apply')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
            </a>
            <a href="<?php echo e(route('report.income.summary')); ?>" class="reset-btn" data-toggle="tooltip" data-original-title="<?php echo e(__('Reset')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-trash-restore-alt"></i></span>
            </a>
            <a href="#" class="action-btn" onclick="saveAsPDF()" data-toggle="tooltip" data-original-title="<?php echo e(__('Download')); ?>">
                <span class="btn-inner--icon"><i class="fas fa-download"></i></span>
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div id="printableArea">
        <div class="row mt-3">
            <div class="col">
                <input type="hidden" value="<?php echo e($filter['category'].' '.__('Income Summary').' '.'Report of'.' '.$filter['startDateRange'].' to '.$filter['endDateRange']); ?>" id="filename">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Report')); ?> :</h5>
                    <h5 class="report-text mb-0"><?php echo e(__('Income Summary')); ?></h5>
                </div>
            </div>
            <?php if($filter['category']!= __('All')): ?>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0"><?php echo e(__('Category')); ?> :</h5>
                        <h5 class="report-text mb-0"><?php echo e($filter['category']); ?></h5>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($filter['customer']!= __('All')): ?>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0"><?php echo e(__('Customer')); ?> :</h5>
                        <h5 class="report-text mb-0"><?php echo e($filter['customer']); ?></h5>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0"><?php echo e(__('Duration')); ?> :</h5>
                    <h5 class="report-text mb-0"><?php echo e($filter['startDateRange'].' to '.$filter['endDateRange']); ?></h5>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12" id="chart-container">
                <div class="card">
                    <div class="scrollbar-inner">
                        <div id="chart-sales" data-color="primary" data-height="300"></div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0" id="dataTable-manual">
                                <thead>
                                <tr>
                                    <th><?php echo e(__('Category')); ?></th>
                                    <?php $__currentLoopData = $monthList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th><?php echo e($month); ?></th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="13" class="text-dark"><span><?php echo e(__('Revenue :')); ?></span></td>
                                </tr>
                                <?php $__currentLoopData = $incomeArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$income): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($income['category']); ?></td>
                                        <?php $__currentLoopData = $income['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j=>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td><?php echo e(\Auth::user()->priceFormat($data)); ?></td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td colspan="13" class="text-dark"><span><?php echo e(__('Invoice :')); ?></span></td>
                                </tr>
                                <?php $__currentLoopData = $invoiceArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($invoice['category']); ?></td>
                                        <?php $__currentLoopData = $invoice['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j=>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td><?php echo e(\Auth::user()->priceFormat($data)); ?></td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td colspan="13" class="text-dark"><span><?php echo e(__('Income = Revenue + Invoice :')); ?></span></td>
                                </tr>
                                <tr>
                                    <td class="text-dark"><?php echo e(__('Total')); ?></td>
                                    <?php $__currentLoopData = $chartIncomeArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$income): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td><?php echo e(\Auth::user()->priceFormat($income)); ?></td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/report/income_summary.blade.php ENDPATH**/ ?>