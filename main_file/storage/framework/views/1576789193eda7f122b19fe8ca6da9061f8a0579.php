<div class="card bg-none card-box">
    <?php echo e(Form::open(array('route' => ['leads.emails.store',$lead->id]))); ?>

    <div class="row">
        <div class="col-6 form-group">
            <?php echo e(Form::label('to', __('Mail To'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::email('to', null, array('class' => 'form-control','required'=>'required'))); ?>

        </div>
        <div class="col-6 form-group">
            <?php echo e(Form::label('subject', __('Subject'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('subject', null, array('class' => 'form-control','required'=>'required'))); ?>

        </div>
        <div class="col-12 form-group">
            <?php echo e(Form::label('description', __('Description'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::textarea('description', null, array('class' => 'summernote-simple','id'=>'emails-summernote'))); ?>

        </div>
        <script>
          $('#emails-summernote').summernote();
        </script>
        <div class="form-group col-12 text-right">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>
<?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/leads/emails.blade.php ENDPATH**/ ?>