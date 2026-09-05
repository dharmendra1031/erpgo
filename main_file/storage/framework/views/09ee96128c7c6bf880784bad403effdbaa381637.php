<div class="card bg-none card-box">
    <?php echo e(Form::open(array('url' => 'coupons','method' =>'post'))); ?>

    <div class="row">
        <div class="form-group col-md-12">
            <?php echo e(Form::label('name',__('Name'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('name',null,array('class'=>'form-control font-style','required'=>'required'))); ?>

        </div>

        <div class="form-group col-md-6">
            <?php echo e(Form::label('discount',__('Discount'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::number('discount',null,array('class'=>'form-control','required'=>'required','step'=>'0.01'))); ?>

            <span class="small"><?php echo e(__('Note: Discount in Percentage')); ?></span>
        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('limit',__('Limit'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::number('limit',null,array('class'=>'form-control','required'=>'required'))); ?>

        </div>

        <div class="form-group col-md-12">
            <?php echo e(Form::label('code',__('Code'),['class'=>'form-control-label'])); ?>

            <div class="d-flex radio-check">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="manual_code" value="manual" name="icon-input" class="custom-control-input code" checked="checked">
                    <label class="custom-control-label form-control-label" for="manual_code"><?php echo e(__('Manual')); ?></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="auto_code" value="auto" name="icon-input" class="custom-control-input code">
                    <label class="custom-control-label form-control-label" for="auto_code"><?php echo e(__('Auto Generate')); ?></label>
                </div>
            </div>
        </div>
        <div class="form-group col-md-12 d-block" id="manual">
            <input class="form-control font-uppercase" name="manualCode" type="text">
        </div>
        <div class="form-group col-md-12 d-none" id="auto">
            <div class="row">
                <div class="col-md-10">
                    <input class="form-control" name="autoCode" type="text" id="auto-code">
                </div>
                <div class="col-md-2">
                    <a href="#" class="btn badge-blue btn-xs rounded-pill my-auto text-white" id="code-generate"><i class="fas fa-history"></i></a>
                </div>
            </div>
        </div>
        <div class="col-12 pt-5 text-right">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/coupon/create.blade.php ENDPATH**/ ?>