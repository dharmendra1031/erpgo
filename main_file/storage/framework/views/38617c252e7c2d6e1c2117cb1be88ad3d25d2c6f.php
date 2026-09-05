<div class="card bg-none card-box">
    <?php echo e(Form::model($lead, array('route' => array('leads.convert.to.deal', $lead->id), 'method' => 'POST'))); ?>

    <div class="row">
        <div class="col-6 form-group">
            <?php echo e(Form::label('name', __('Deal Name'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('name', $lead->subject, array('class' => 'form-control','required'=>'required'))); ?>

        </div>
        <div class="col-6 form-group">
            <?php echo e(Form::label('price', __('Price'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::number('price', 0, array('class' => 'form-control','min'=>0))); ?>

        </div>
        <div class="col-sm-12 col-md-12">
            <div class="d-flex radio-check">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="client_check" value="new" id="new_client" class="custom-control-input" <?php if(empty($exist_client)): ?> checked <?php endif; ?>/>
                    <label class="custom-control-label form-control-label" for="new_client"><?php echo e(__('New Client')); ?></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" name="client_check" value="exist" id="existing_client" class="custom-control-input" <?php if(!empty($exist_client)): ?> checked <?php endif; ?>/>
                    <label class="custom-control-label form-control-label" for="existing_client"><?php echo e(__('Existing Client')); ?></label>
                </div>
            </div>
        </div>
        <div class="col-6 exist_client d-none form-group">
            <?php echo e(Form::label('clients', __('Client'),['class'=>'form-control-label'])); ?>

            <select name="clients" id="clients" class="form-control select2">
                <option value=""><?php echo e(__('Select Client')); ?></option>
                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($client->email); ?>" <?php if($lead->email == $client->email): ?> selected <?php endif; ?>><?php echo e($client->name); ?> (<?php echo e($client->email); ?>)</option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-6 new_client form-group">
            <?php echo e(Form::label('client_name', __('Client Name'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('client_name', $lead->name, array('class' => 'form-control','required'=>'required'))); ?>

        </div>
        <div class="col-6 new_client form-group">
            <?php echo e(Form::label('client_email', __('Client Email'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('client_email', $lead->email, array('class' => 'form-control','required'=>'required'))); ?>

        </div>
        <div class="col-6 new_client form-group">
            <?php echo e(Form::label('client_password', __('Client Password'),['class'=>'form-control-label'])); ?>

            <?php echo e(Form::text('client_password',null, array('class' => 'form-control','required'=>'required'))); ?>

        </div>
    </div>
    <div class="row px-3 text-sm">
        <div class="col-12 pl-0 pb-2 font-weight-bold text-dark"><?php echo e(__('Copy To')); ?></div>
        <div class="col-3 custom-control custom-checkbox">
            <?php echo e(Form::checkbox('is_transfer[]','products',false,['class' => 'custom-control-input','id'=>'is_transfer_products','checked'=>'checked'])); ?>

            <?php echo e(Form::label('is_transfer_products', __('Products'),['class'=>'custom-control-label'])); ?>

        </div>
        <div class="col-3 custom-control custom-checkbox">
            <?php echo e(Form::checkbox('is_transfer[]','sources',false,['class' => 'custom-control-input','id'=>'is_transfer_sources','checked'=>'checked'])); ?>

            <?php echo e(Form::label('is_transfer_sources', __('Sources'),['class'=>'custom-control-label'])); ?>

        </div>
        <div class="col-3 custom-control custom-checkbox">
            <?php echo e(Form::checkbox('is_transfer[]','files',false,['class' => 'custom-control-input','id'=>'is_transfer_files','checked'=>'checked'])); ?>

            <?php echo e(Form::label('is_transfer_files', __('Files'),['class'=>'custom-control-label'])); ?>

        </div>
        <div class="col-3 custom-control custom-checkbox">
            <?php echo e(Form::checkbox('is_transfer[]','discussion',false,['class' => 'custom-control-input','id'=>'is_transfer_discussion','checked'=>'checked'])); ?>

            <?php echo e(Form::label('is_transfer_discussion', __('Discussion'),['class'=>'custom-control-label'])); ?>

        </div>
        <div class="col-3 custom-control custom-checkbox">
            <?php echo e(Form::checkbox('is_transfer[]','notes',false,['class' => 'custom-control-input','id'=>'is_transfer_notes','checked'=>'checked'])); ?>

            <?php echo e(Form::label('is_transfer_notes', __('Notes'),['class'=>'custom-control-label'])); ?>

        </div>
        <div class="col-3 custom-control custom-checkbox">
            <?php echo e(Form::checkbox('is_transfer[]','calls',false,['class' => 'custom-control-input','id'=>'is_transfer_calls','checked'=>'checked'])); ?>

            <?php echo e(Form::label('is_transfer_calls', __('Calls'),['class'=>'custom-control-label'])); ?>

        </div>
        <div class="col-3 custom-control custom-checkbox">
            <?php echo e(Form::checkbox('is_transfer[]','emails',false,['class' => 'custom-control-input','id'=>'is_transfer_emails','checked'=>'checked'])); ?>

            <?php echo e(Form::label('is_transfer_emails', __('Emails'),['class'=>'custom-control-label'])); ?>

        </div>
    </div>
    <div class="row">
        <div class="form-group col-12 text-right">
            <input type="submit" value="<?php echo e(__('Convert')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    <?php echo e(Form::close()); ?>

</div>

<script>
    $(document).ready(function () {
        var is_client = $("input[name='client_check']:checked").val();
        $("input[name='client_check']").click(function () {
            is_client = $(this).val();

            if (is_client == "exist") {
                $('.exist_client').removeClass('d-none');
                $('#client_name').removeAttr('required');
                $('#client_email').removeAttr('required');
                $('#client_password').removeAttr('required');
                $('.new_client').addClass('d-none');
            } else {
                $('.new_client').removeClass('d-none');
                $('#client_name').attr('required', 'required');
                $('#client_email').attr('required', 'required');
                $('#client_password').attr('required', 'required');
                $('.exist_client').addClass('d-none');
            }
        });
        if (is_client == "exist") {
            $('.exist_client').removeClass('d-none');
            $('#client_name').removeAttr('required');
            $('#client_email').removeAttr('required');
            $('#client_password').removeAttr('required');
            $('.new_client').addClass('d-none');
        } else {
            $('.new_client').removeClass('d-none');
            $('#client_name').attr('required', 'required');
            $('#client_email').attr('required', 'required');
            $('#client_password').attr('required', 'required');
            $('.exist_client').addClass('d-none');
        }
    })

</script>
<?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/leads/convert.blade.php ENDPATH**/ ?>