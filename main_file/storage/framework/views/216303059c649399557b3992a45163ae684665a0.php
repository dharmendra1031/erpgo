<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Settings')); ?>

<?php $__env->stopSection(); ?>
<?php
    $logo=asset(Storage::url('uploads/logo/'));
    $company_logo=Utility::getValByName('company_logo');
    $company_favicon=Utility::getValByName('company_favicon');
 $lang=Utility::getValByName('default_language');
?>
<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).on("change", "select[name='invoice_template'], input[name='invoice_color']", function () {
            var template = $("select[name='invoice_template']").val();
            var color = $("input[name='invoice_color']:checked").val();
            $('#invoice_frame').attr('src', '<?php echo e(url('/invoices/preview')); ?>/' + template + '/' + color);
        });

        $(document).on("change", "select[name='proposal_template'], input[name='proposal_color']", function () {
            var template = $("select[name='proposal_template']").val();
            var color = $("input[name='proposal_color']:checked").val();
            $('#proposal_frame').attr('src', '<?php echo e(url('/proposal/preview')); ?>/' + template + '/' + color);
        });

        $(document).on("change", "select[name='bill_template'], input[name='bill_color']", function () {
            var template = $("select[name='bill_template']").val();
            var color = $("input[name='bill_color']:checked").val();
            $('#bill_frame').attr('src', '<?php echo e(url('/bill/preview')); ?>/' + template + '/' + color);
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <section class="nav-tabs">
                <div class="col-lg-12 our-system">
                    <div class="row">
                        <ul class="nav nav-tabs my-4">
                            <li class="">
                                <a data-toggle="tab" href="#proposal-template-setting" class="active"><?php echo e(__('Proposal Print Setting')); ?> </a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#invoice-template-setting" class=""><?php echo e(__('Invoice Print Setting')); ?> </a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#bill-template-setting" class=""><?php echo e(__('Bill Print Setting')); ?> </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="proposal-template-setting" class="tab-pane in active">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                <h4 class="h4 font-weight-400 float-left pb-2"><?php echo e(__('Proposal Print Settings')); ?></h4>
                            </div>
                        </div>
                        <div class="card">
                            <form id="setting-form" method="post" action="<?php echo e(route('proposal.template.setting')); ?>">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <form id="setting-form" method="post" action="<?php echo e(route('proposal.template.setting')); ?>">
                                                <?php echo csrf_field(); ?>
                                                <div class="form-group">
                                                    <label for="address" class="form-control-label"><?php echo e(__('Proposal Template')); ?></label>
                                                    <select class="form-control select2" name="proposal_template">
                                                        <?php $__currentLoopData = Utility::templateData()['templates']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($key); ?>" <?php echo e((isset($settings['proposal_template']) && $settings['proposal_template'] == $key) ? 'selected' : ''); ?>><?php echo e($template); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label form-control-label"><?php echo e(__('Color Input')); ?></label>
                                                    <div class="row gutters-xs">
                                                        <?php $__currentLoopData = Utility::templateData()['colors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="col-auto">
                                                                <label class="colorinput">
                                                                    <input name="proposal_color" type="radio" value="<?php echo e($color); ?>" class="colorinput-input" <?php echo e((isset($settings['proposal_color']) && $settings['proposal_color'] == $color) ? 'checked' : ''); ?>>
                                                                    <span class="colorinput-color" style="background: #<?php echo e($color); ?>"></span>
                                                                </label>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                                <button class="btn btn-sm btn-primary rounded-pill">
                                                    <?php echo e(__('Save')); ?>

                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-10">
                                            <?php if(isset($settings['proposal_template']) && isset($settings['proposal_color'])): ?>
                                                <iframe id="proposal_frame" class="w-100 h-1300" frameborder="0" src="<?php echo e(route('proposal.preview',[$settings['proposal_template'],$settings['proposal_color']])); ?>"></iframe>
                                            <?php else: ?>
                                                <iframe id="proposal_frame" class="w-100 h-1300" frameborder="0" src="<?php echo e(route('proposal.preview',['template1','fffff'])); ?>"></iframe>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div id="invoice-template-setting" class="tab-pane">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                <h4 class="h4 font-weight-400 float-left pb-2"><?php echo e(__('Invoice Print Settings')); ?></h4>
                            </div>
                        </div>
                        <div class="card">
                            <form id="setting-form" method="post" action="<?php echo e(route('proposal.template.setting')); ?>">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <form id="setting-form" method="post" action="<?php echo e(route('template.setting')); ?>">
                                                <?php echo csrf_field(); ?>
                                                <div class="form-group">
                                                    <label for="address" class="form-control-label"><?php echo e(__('Invoice Template')); ?></label>
                                                    <select class="form-control select2" name="invoice_template">
                                                        <?php $__currentLoopData = Utility::templateData()['templates']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($key); ?>" <?php echo e((isset($settings['invoice_template']) && $settings['invoice_template'] == $key) ? 'selected' : ''); ?>><?php echo e($template); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label form-control-label"><?php echo e(__('Color Input')); ?></label>
                                                    <div class="row gutters-xs">
                                                        <?php $__currentLoopData = Utility::templateData()['colors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="col-auto">
                                                                <label class="colorinput">
                                                                    <input name="invoice_color" type="radio" value="<?php echo e($color); ?>" class="colorinput-input" <?php echo e((isset($settings['invoice_color']) && $settings['invoice_color'] == $color) ? 'checked' : ''); ?>>
                                                                    <span class="colorinput-color" style="background: #<?php echo e($color); ?>"></span>
                                                                </label>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                                <button class="btn btn-sm btn-primary rounded-pill">
                                                    <?php echo e(__('Save')); ?>

                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-10">
                                            <?php if(isset($settings['invoice_template']) && isset($settings['invoice_color'])): ?>
                                                <iframe id="invoice_frame" class="w-100 h-1450" frameborder="0" src="<?php echo e(route('invoice.preview',[$settings['invoice_template'],$settings['invoice_color']])); ?>"></iframe>
                                            <?php else: ?>
                                                <iframe id="invoice_frame" class="w-100 h-1450" frameborder="0" src="<?php echo e(route('invoice.preview',['template1','fffff'])); ?>"></iframe>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div id="bill-template-setting" class="tab-pane">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                <h4 class="h4 font-weight-400 float-left pb-2"><?php echo e(__('Bill Print Settings')); ?></h4>
                            </div>
                        </div>
                        <div class="card">
                            <form id="setting-form" method="post" action="<?php echo e(route('proposal.template.setting')); ?>">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <form id="setting-form" method="post" action="<?php echo e(route('bill.template.setting')); ?>">
                                                <?php echo csrf_field(); ?>
                                                <div class="form-group">
                                                    <label for="address" class="form-control-label "><?php echo e(__('Bill Template')); ?></label>
                                                    <select class="form-control select2" name="bill_template">
                                                        <?php $__currentLoopData = Utility::templateData()['templates']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($key); ?>" <?php echo e((isset($settings['bill_template']) && $settings['bill_template'] == $key) ? 'selected' : ''); ?>><?php echo e($template); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                                <div class="form-group form-control-label">
                                                    <label class="form-label"><?php echo e(__('Color Input')); ?></label>
                                                    <div class="row gutters-xs">
                                                        <?php $__currentLoopData = Utility::templateData()['colors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="col-auto">
                                                                <label class="colorinput">
                                                                    <input name="bill_color" type="radio" value="<?php echo e($color); ?>" class="colorinput-input" <?php echo e((isset($settings['bill_color']) && $settings['bill_color'] == $color) ? 'checked' : ''); ?>>
                                                                    <span class="colorinput-color" style="background: #<?php echo e($color); ?>"></span>
                                                                </label>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                                <button class="btn btn-sm btn-primary rounded-pill">
                                                    <?php echo e(__('Save')); ?>

                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-10">
                                            <?php if(isset($settings['bill_template']) && isset($settings['bill_color'])): ?>
                                                <iframe id="bill_frame" class="w-100 h-1450" frameborder="0" src="<?php echo e(route('bill.preview',[$settings['bill_template'],$settings['bill_color']])); ?>"></iframe>
                                            <?php else: ?>
                                                <iframe id="bill_frame" class="w-100 h-1450" frameborder="0" src="<?php echo e(route('bill.preview',['template1','fffff'])); ?>"></iframe>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/settings/print.blade.php ENDPATH**/ ?>