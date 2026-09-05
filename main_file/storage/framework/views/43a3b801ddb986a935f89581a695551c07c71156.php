<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Settings')); ?>

<?php $__env->stopSection(); ?>
<?php
    $logo=asset(Storage::url('uploads/logo/'));
    $company_logo=Utility::getValByName('company_logo');
    $company_favicon=Utility::getValByName('company_favicon');
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
                            <li>
                                <a data-toggle="tab" href="#business-setting" class="active"><?php echo e(__('Business Setting')); ?></a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#system-setting" class=""><?php echo e(__('System Setting')); ?> </a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#company-setting" class=""><?php echo e(__('Company Setting')); ?> </a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#payment-setting" class=""><?php echo e(__('Payment Setting')); ?> </a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#zoom-meeting-setting" class=""><?php echo e(__('Zoom-Meeting Setting')); ?> </a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#slack-setting" class=""><?php echo e(__('Slack Setting')); ?></a>
                            </li>

                            <li class="annual-billing">
                                <a data-toggle="tab" href="#telegram-setting" class=""><?php echo e(__('Telegram Setting')); ?></a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#twilio-setting" class=""><?php echo e(__('Twilio Setting')); ?> </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="business-setting" class="tab-pane in active">
                        <?php echo e(Form::model($settings,array('route'=>'business.setting','method'=>'POST','enctype' => "multipart/form-data"))); ?>

                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                <h4 class="h4 font-weight-400 float-left pb-2"><?php echo e(__('Business settings')); ?></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-sm-6 col-md-6">
                                <h4 class="small-title"><?php echo e(__('Logo')); ?></h4>
                                <div class="card setting-card setting-logo-box">
                                    <div class="logo-content">
                                        <img src="<?php echo e($logo.'/'.(isset($company_logo) && !empty($company_logo)?$company_logo:'logo.png')); ?>" class="big-logo" alt=""/>
                                    </div>
                                    <div class="choose-file mt-4">
                                        <label for="company_logo">
                                            <div><?php echo e(__('Choose file here')); ?></div>
                                            <input type="file" class="form-control" name="company_logo" id="company_logo" data-filename="edit-company_logo">
                                        </label>
                                        <p class="edit-company_logo"></p>
                                    </div>
                                    <p class="mt-3 text-primary"> <?php echo e(__('These Logo will appear on Bill and Invoice as well.')); ?></p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-md-6">
                                <h4 class="small-title"><?php echo e(__('Favicon')); ?></h4>
                                <div class="card setting-card setting-logo-box">
                                    <div class="logo-content">
                                        <img src="<?php echo e($logo.'/'.(isset($company_favicon) && !empty($company_favicon)?$company_favicon:'favicon.png')); ?>" class="small-logo" alt=""/>
                                    </div>
                                    <div class="choose-file mt-5">
                                        <label for="company_favicon">
                                            <div><?php echo e(__('Choose file here')); ?></div>
                                            <input type="file" class="form-control" name="company_favicon" id="company_favicon" data-filename="edit-company-favicon">
                                        </label>
                                        <p class="edit-company-favicon"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-md-6">
                                <h4 class="small-title"><?php echo e(__('Settings')); ?></h4>
                                <div class="card setting-card setting-logo-box">
                                    <div class="form-group">
                                        <?php echo e(Form::label('title_text',__('Title Text'),array('class'=>'form-control-label'),array('class'=>'form-control-label'))); ?>

                                        <?php echo e(Form::text('title_text',null,array('class'=>'form-control','placeholder'=>__('Title Text')))); ?>

                                        <?php $__errorArgs = ['title_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-title_text" role="alert">
                                             <strong class="text-danger"><?php echo e($message); ?></strong>
                                             </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-12 text-right">
                                <input type="submit" value="<?php echo e(__('Save Changes')); ?>" class="btn-submit">
                            </div>
                        </div>
                        <?php echo e(Form::close()); ?>

                    </div>
                    <div id="system-setting" class="tab-pane">
                        <div class="col-md-12">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                    <h4 class="h4 font-weight-400 float-left pb-2"><?php echo e(__('System Settings')); ?></h4>
                                </div>
                            </div>
                            <div class="card bg-none">
                                <?php echo e(Form::model($settings,array('route'=>'system.settings','method'=>'post'))); ?>

                                <div class="card-body pd-0">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('site_currency',__('Currency *'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('site_currency',null,array('class'=>'form-control font-style'))); ?>

                                            <small> <?php echo e(__('Note: Add currency code as per three-letter ISO code.')); ?><br> <a href="https://stripe.com/docs/currencies" target="_blank"><?php echo e(__('you can find out here..')); ?></a></small> <br>
                                            <?php $__errorArgs = ['site_currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-site_currency" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('site_currency_symbol',__('Currency Symbol *'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('site_currency_symbol',null,array('class'=>'form-control'))); ?>

                                            <?php $__errorArgs = ['site_currency_symbol'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-site_currency_symbol" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="example3cols3Input"><?php echo e(__('Currency Symbol Position')); ?></label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="custom-control custom-radio mb-3">

                                                            <input type="radio" id="customRadio5" name="site_currency_symbol_position" value="pre" class="custom-control-input" <?php if(@$settings['site_currency_symbol_position'] == 'pre'): ?> checked <?php endif; ?>>
                                                            <label class="custom-control-label" for="customRadio5"><?php echo e(__('Pre')); ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input type="radio" id="customRadio6" name="site_currency_symbol_position" value="post" class="custom-control-input" <?php if(@$settings['site_currency_symbol_position'] == 'post'): ?> checked <?php endif; ?>>
                                                            <label class="custom-control-label" for="customRadio6"><?php echo e(__('Post')); ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="site_date_format" class="form-control-label"><?php echo e(__('Date Format')); ?></label>
                                            <select type="text" name="site_date_format" class="form-control select2" id="site_date_format">
                                                <option value="M j, Y" <?php if(@$settings['site_date_format'] == 'M j, Y'): ?> selected="selected" <?php endif; ?>>Jan 1,2015</option>
                                                <option value="d-m-Y" <?php if(@$settings['site_date_format'] == 'd-m-Y'): ?> selected="selected" <?php endif; ?>>d-m-y</option>
                                                <option value="m-d-Y" <?php if(@$settings['site_date_format'] == 'm-d-Y'): ?> selected="selected" <?php endif; ?>>m-d-y</option>
                                                <option value="Y-m-d" <?php if(@$settings['site_date_format'] == 'Y-m-d'): ?> selected="selected" <?php endif; ?>>y-m-d</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="site_time_format" class="form-control-label"><?php echo e(__('Time Format')); ?></label>
                                            <select type="text" name="site_time_format" class="form-control select2" id="site_time_format">
                                                <option value="g:i A" <?php if(@$settings['site_time_format'] == 'g:i A'): ?> selected="selected" <?php endif; ?>>10:30 PM</option>
                                                <option value="g:i a" <?php if(@$settings['site_time_format'] == 'g:i a'): ?> selected="selected" <?php endif; ?>>10:30 pm</option>
                                                <option value="H:i" <?php if(@$settings['site_time_format'] == 'H:i'): ?> selected="selected" <?php endif; ?>>22:30</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('invoice_prefix',__('Invoice Prefix'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('invoice_prefix',null,array('class'=>'form-control'))); ?>

                                            <?php $__errorArgs = ['invoice_prefix'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-invoice_prefix" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('proposal_prefix',__('Proposal Prefix'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('proposal_prefix',null,array('class'=>'form-control'))); ?>

                                            <?php $__errorArgs = ['proposal_prefix'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-proposal_prefix" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('bill_prefix',__('Bill Prefix'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('bill_prefix',null,array('class'=>'form-control'))); ?>

                                            <?php $__errorArgs = ['bill_prefix'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-bill_prefix" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('customer_prefix',__('Customer Prefix'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('customer_prefix',null,array('class'=>'form-control'))); ?>

                                            <?php $__errorArgs = ['customer_prefix'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-customer_prefix" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('vender_prefix',__('Vender Prefix'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('vender_prefix',null,array('class'=>'form-control'))); ?>

                                            <?php $__errorArgs = ['vender_prefix'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-vender_prefix" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('footer_title',__('Invoice/Bill Footer Title'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('footer_title',null,array('class'=>'form-control'))); ?>

                                            <?php $__errorArgs = ['footer_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-footer_title" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('decimal_number',__('Decimal Number Format'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::number('decimal_number', null, ['class'=>'form-control'])); ?>

                                            <?php $__errorArgs = ['decimal_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-decimal_number" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('journal_prefix',__('Journal Prefix'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('journal_prefix',null,array('class'=>'form-control'))); ?>

                                            <?php $__errorArgs = ['journal_prefix'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-journal_prefix" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('shipping_display',__('Shipping Display in Proposal / Invoice / Bill ?'),array('class'=>'form-control-label'))); ?>

                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="email-template-checkbox custom-control-input" name="shipping_display" id="email_tempalte_13" <?php echo e(($settings['shipping_display']=='on')?'checked':''); ?> >
                                                <label class="custom-control-label form-control-label" for="email_tempalte_13"></label>
                                            </div>

                                            <?php $__errorArgs = ['shipping_display'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-shipping_display" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>


                                        <div class="form-group col-md-6">
                                            <label class="form-control-label mb-0"><?php echo e(__('App Site URL')); ?></label> <br>
                                            <small><?php echo e(__("App Site URL to login app.")); ?></small>
                                            <?php echo e(Form::text('currency',URL::to('/'), ['class' => 'form-control', 'placeholder' => __('Enter Currency'),'disabled'=>'true'])); ?>

                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="form-control-label mb-0"><?php echo e(__('Tracking Interval')); ?></label> <br>
                                            <small><?php echo e(__("Image Screenshort Take Interval time ( 1 = 1 min)")); ?></small>
                                            <?php echo e(Form::number('interval_time',isset($settings['interval_time'])?$settings['interval_time']:'10', ['class' => 'form-control', 'placeholder' => __('Enter Tracking Interval')])); ?>

                                        </div>

                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('footer_notes',__('Invoice/Bill Footer Notes'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::textarea('footer_notes', null, ['class'=>'form-control','rows'=>'3'])); ?>

                                            <?php $__errorArgs = ['footer_notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-footer_notes" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>





                                    </div>
                                </div>
                                <div class="col-lg-12  text-right">
                                    <input type="submit" value="<?php echo e(__('Save Changes')); ?>" class="btn-submit text-white">
                                </div>
                                <?php echo e(Form::close()); ?>

                            </div>
                        </div>
                    </div>
                    <div id="company-setting" class="tab-pane">
                        <div class="col-md-12">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                    <h4 class="h4 font-weight-400 float-left pb-2"><?php echo e(__('Company Settings')); ?></h4>
                                </div>
                            </div>
                            <div class="card bg-none">
                                <?php echo e(Form::model($settings,array('route'=>'company.settings','method'=>'post'))); ?>

                                <div class="card-body pd-0">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('company_name *',__('Company Name *'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('company_name',null,array('class'=>'form-control font-style'))); ?>

                                            <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-company_name" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('company_address',__('Address'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('company_address',null,array('class'=>'form-control font-style'))); ?>

                                            <?php $__errorArgs = ['company_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-company_address" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('company_city',__('City'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('company_city',null,array('class'=>'form-control font-style'))); ?>

                                            <?php $__errorArgs = ['company_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-company_city" role="alert">
                                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('company_state',__('State'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('company_state',null,array('class'=>'form-control font-style'))); ?>

                                            <?php $__errorArgs = ['company_state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-company_state" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('company_zipcode',__('Zip/Post Code'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('company_zipcode',null,array('class'=>'form-control'))); ?>

                                            <?php $__errorArgs = ['company_zipcode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-company_zipcode" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group  col-md-6">
                                            <?php echo e(Form::label('company_country',__('Country'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('company_country',null,array('class'=>'form-control font-style'))); ?>

                                            <?php $__errorArgs = ['company_country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-company_country" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('company_telephone',__('Telephone'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('company_telephone',null,array('class'=>'form-control'))); ?>

                                            <?php $__errorArgs = ['company_telephone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-company_telephone" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('company_email',__('System Email *'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('company_email',null,array('class'=>'form-control'))); ?>

                                            <?php $__errorArgs = ['company_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-company_email" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('company_email_from_name',__('Email (From Name) *'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('company_email_from_name',null,array('class'=>'form-control font-style'))); ?>

                                            <?php $__errorArgs = ['company_email_from_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-company_email_from_name" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('registration_number',__('Company Registration Number *'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('registration_number',null,array('class'=>'form-control'))); ?>


                                        </div>

                                        <div class="form-group col-md-6">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input type="radio" id="customRadio8" name="tax_type" value="VAT" class="custom-control-input" <?php echo e(($settings['tax_type'] == 'VAT')?'checked':''); ?> >
                                                            <label class="custom-control-label" for="customRadio8"><?php echo e(__('VAT Number')); ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input type="radio" id="customRadio7" name="tax_type" value="GST" class="custom-control-input" <?php echo e(($settings['tax_type'] == 'GST')?'checked':''); ?>>
                                                            <label class="custom-control-label" for="customRadio7"><?php echo e(__('GST Number')); ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php echo e(Form::text('vat_number',null,array('class'=>'form-control','placeholder'=>__('Enter VAT / GST Number')))); ?>


                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <?php echo e(Form::label('timezone',__('Timezone'))); ?>

                                            <select type="text" name="timezone" class="form-control custom-select" id="timezone">
                                                <option value=""><?php echo e(__('Select Timezone')); ?></option>
                                                <?php $__currentLoopData = $timezones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$timezone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($k); ?>" <?php echo e((env('TIMEZONE')==$k)?'selected':''); ?>><?php echo e($timezone); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('company_start_time',__('Company Start Time *'))); ?>

                                            <?php echo e(Form::time('company_start_time',null,array('class'=>'form-control'))); ?>

                                            <?php $__errorArgs = ['company_start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-company_start_time" role="alert">
                                                        <strong class="text-danger"><?php echo e($message); ?></strong>
                                                    </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('company_end_time',__('Company End Time *'))); ?>

                                            <?php echo e(Form::time('company_end_time',null,array('class'=>'form-control'))); ?>

                                            <?php $__errorArgs = ['company_end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-company_end_time" role="alert">
                                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-12  text-right">
                                    <input type="submit" value="<?php echo e(__('Save Changes')); ?>" class="btn-submit text-white">
                                </div>
                                <?php echo e(Form::close()); ?>

                            </div>
                        </div>
                    </div>
                    <div id="payment-setting" class="tab-pane">
                        <div class="col-md-12">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                    <h4 class="h4 font-weight-400 float-left pb-2"><?php echo e(__('Payment settings')); ?></h4>
                                </div>
                            </div>
                            <div class="card bg-none company-setting">
                                <?php echo e(Form::model($settings,['route'=>'company.payment.settings', 'method'=>'POST'])); ?>

                                <div id="accordion-2" class="accordion accordion-spaced">
                                    <!-- Strip -->
                                    <div class="card">
                                        <div class="card-header py-4" id="heading-2-2" data-toggle="collapse" role="button" data-target="#collapse-2-2" aria-expanded="false" aria-controls="collapse-2-2">
                                            <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i><?php echo e(__('Stripe')); ?></h6>
                                        </div>
                                        <div id="collapse-2-2" class="collapse" aria-labelledby="heading-2-2" data-parent="#accordion-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 py-2">

                                                        <small class=""> <?php echo e(__('Note: This detail will use for invoice payment.')); ?></small>
                                                    </div>
                                                    <div class="col-6 py-2 text-right">
                                                        <div class="custom-control custom-switch">
                                                            <input type="hidden" name="is_stripe_enabled" value="off">
                                                            <input type="checkbox" class="custom-control-input" name="is_stripe_enabled" id="is_stripe_enabled" <?php echo e(isset($company_payment_setting['is_stripe_enabled']) && $company_payment_setting['is_stripe_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                            <label class="custom-control-label form-control-label" for="is_stripe_enabled"><?php echo e(__('Enable Stripe')); ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php echo e(Form::label('stripe_key',__('Stripe Key'),array('class'=>'form-control-label'))); ?>

                                                            <?php echo e(Form::text('stripe_key',isset($company_payment_setting['stripe_key'])?$company_payment_setting['stripe_key']:'',['class'=>'form-control','placeholder'=>__('Enter Stripe Key')])); ?>

                                                            <?php if($errors->has('stripe_key')): ?>
                                                                <span class="invalid-feedback d-block">
                                                                        <?php echo e($errors->first('stripe_key')); ?>

                                                                    </span>
                                                            <?php endif; ?>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <?php echo e(Form::label('stripe_secret',__('Stripe Secret'),array('class'=>'form-control-label'))); ?>

                                                            <?php echo e(Form::text('stripe_secret',isset($company_payment_setting['stripe_secret'])?$company_payment_setting['stripe_secret']:'',['class'=>'form-control ','placeholder'=>__('Enter Stripe Secret')])); ?>

                                                            <?php if($errors->has('stripe_secret')): ?>
                                                                <span class="invalid-feedback d-block">
                                                                        <?php echo e($errors->first('stripe_secret')); ?>

                                                                    </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Paypal -->
                                    <div class="card">
                                        <div class="card-header py-4" id="heading-2-3" data-toggle="collapse" role="button" data-target="#collapse-2-3" aria-expanded="false" aria-controls="collapse-2-3">
                                            <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i><?php echo e(__('PayPal')); ?></h6>
                                        </div>
                                        <div id="collapse-2-3" class="collapse" aria-labelledby="heading-2-3" data-parent="#accordion-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 py-2">

                                                        <small class=""> <?php echo e(__('Note: This detail will use for invoice payment.')); ?></small>
                                                    </div>
                                                    <div class="col-6 py-2 text-right">
                                                        <div class="custom-control custom-switch">
                                                            <input type="hidden" name="is_paypal_enabled" value="off">
                                                            <input type="checkbox" class="custom-control-input" name="is_paypal_enabled" id="is_paypal_enabled" <?php echo e(isset($company_payment_setting['is_paypal_enabled']) && $company_payment_setting['is_paypal_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                            <label class="custom-control-label form-control-label" for="is_paypal_enabled"><?php echo e(__('Enable Paypal')); ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto pb-4">
                                                        <label class="paypal-label form-control-label" for="paypal_mode"><?php echo e(__('Paypal Mode')); ?></label> <br>
                                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                            <label class="btn btn-primary btn-sm <?php echo e(isset($company_payment_setting['paypal_mode']) && $company_payment_setting['paypal_mode'] == 'sandbox' ? 'active' : ''); ?>">
                                                                <input type="radio" name="paypal_mode" value="sandbox" <?php echo e(isset($company_payment_setting['paypal_mode']) && $company_payment_setting['paypal_mode'] == '' || isset($company_payment_setting['paypal_mode']) && $company_payment_setting['paypal_mode'] == 'sandbox' ? 'checked="checked"' : ''); ?>><?php echo e(__('Sandbox')); ?>

                                                            </label>
                                                            <label class="btn btn-primary btn-sm <?php echo e(isset($company_payment_setting['paypal_mode']) && $company_payment_setting['paypal_mode'] == 'live' ? 'active' : ''); ?>">
                                                                <input type="radio" name="paypal_mode" value="live" <?php echo e(isset($company_payment_setting['paypal_mode']) && $company_payment_setting['paypal_mode'] == 'live' ? 'checked="checked"' : ''); ?>><?php echo e(__('Live')); ?>

                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="paypal_client_id" class="form-control-label"><?php echo e(__('Client ID')); ?></label>
                                                            <input type="text" name="paypal_client_id" id="paypal_client_id" class="form-control" value="<?php echo e(isset($company_payment_setting['paypal_client_id'])?$company_payment_setting['paypal_client_id']:''); ?>" placeholder="<?php echo e(__('Client ID')); ?>"/>
                                                            <?php if($errors->has('paypal_client_id')): ?>
                                                                <span class="invalid-feedback d-block">
                                                                        <?php echo e($errors->first('paypal_client_id')); ?>

                                                                    </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label for="paypal_secret_key" class="form-control-label"><?php echo e(__('Secret Key')); ?></label>
                                                            <input type="text" name="paypal_secret_key" id="paypal_secret_key" class="form-control" value="<?php echo e(isset($company_payment_setting['paypal_secret_key'])?$company_payment_setting['paypal_secret_key']:''); ?>" placeholder="<?php echo e(__('Secret Key')); ?>"/>
                                                            <?php if($errors->has('paypal_secret_key')): ?>
                                                                <span class="invalid-feedback d-block">
                                                                        <?php echo e($errors->first('paypal_secret_key')); ?>

                                                                    </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Paystack -->
                                    <div class="card">
                                        <div class="card-header py-4" id="heading-2-6" data-toggle="collapse" role="button" data-target="#collapse-2-6" aria-expanded="false" aria-controls="collapse-2-6">
                                            <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i><?php echo e(__('Paystack')); ?></h6>
                                        </div>
                                        <div id="collapse-2-6" class="collapse" aria-labelledby="heading-2-6" data-parent="#accordion-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 py-2">

                                                        <small> <?php echo e(__('Note: This detail will use for invoice payment.')); ?></small>
                                                    </div>
                                                    <div class="col-6 py-2 text-right">
                                                        <div class="custom-control custom-switch">
                                                            <input type="hidden" name="is_paystack_enabled" value="off">
                                                            <input type="checkbox" class="custom-control-input" name="is_paystack_enabled" id="is_paystack_enabled" <?php echo e(isset($company_payment_setting['is_paystack_enabled']) && $company_payment_setting['is_paystack_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                            <label class="custom-control-label form-control-label" for="is_paystack_enabled"><?php echo e(__('Enable Paystack')); ?></label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paypal_client_id" class="form-control-label"><?php echo e(__('Public Key')); ?></label>
                                                            <input type="text" name="paystack_public_key" id="paystack_public_key" class="form-control form-control-label" value="<?php echo e(isset($company_payment_setting['paystack_public_key']) ? $company_payment_setting['paystack_public_key']:''); ?>" placeholder="<?php echo e(__('Public Key')); ?>"/>
                                                            <?php if($errors->has('paystack_public_key')): ?>
                                                                <span class="invalid-feedback d-block">
                                                                        <?php echo e($errors->first('paystack_public_key')); ?>

                                                                    </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paystack_secret_key" class="form-control-label"><?php echo e(__('Secret Key')); ?></label>
                                                            <input type="text" name="paystack_secret_key" id="paystack_secret_key" class="form-control form-control-label" value="<?php echo e(isset($company_payment_setting['paystack_secret_key']) ? $company_payment_setting['paystack_secret_key']:''); ?>" placeholder="<?php echo e(__('Secret Key')); ?>"/>
                                                            <?php if($errors->has('paystack_secret_key')): ?>
                                                                <span class="invalid-feedback d-block">
                                                                        <?php echo e($errors->first('paystack_secret_key')); ?>

                                                                    </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- FLUTTERWAVE -->
                                    <div class="card">
                                        <div class="card-header py-4" id="heading-2-7" data-toggle="collapse" role="button" data-target="#collapse-2-7" aria-expanded="false" aria-controls="collapse-2-7">
                                            <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i><?php echo e(__('Flutterwave')); ?></h6>
                                        </div>
                                        <div id="collapse-2-7" class="collapse" aria-labelledby="heading-2-7" data-parent="#accordion-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 py-2">

                                                        <small> <?php echo e(__('Note: This detail will use for invoice payment.')); ?></small>
                                                    </div>
                                                    <div class="col-6 py-2 text-right">
                                                        <div class="custom-control custom-switch">
                                                            <input type="hidden" name="is_flutterwave_enabled" value="off">
                                                            <input type="checkbox" class="custom-control-input" name="is_flutterwave_enabled" id="is_flutterwave_enabled" <?php echo e(isset($company_payment_setting['is_flutterwave_enabled'])  && $company_payment_setting['is_flutterwave_enabled']== 'on' ? 'checked="checked"' : ''); ?>>
                                                            <label class="custom-control-label form-control-label" for="is_flutterwave_enabled"><?php echo e(__('Enable Flutterwave')); ?></label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paypal_client_id" class="form-control-label"><?php echo e(__('Public Key')); ?></label>
                                                            <input type="text" name="flutterwave_public_key" id="flutterwave_public_key" class="form-control" value="<?php echo e(isset($company_payment_setting['flutterwave_public_key'])?$company_payment_setting['flutterwave_public_key']:''); ?>" placeholder="<?php echo e(__('Public Key')); ?>"/>
                                                            <?php if($errors->has('flutterwave_public_key')): ?>
                                                                <span class="invalid-feedback d-block">
                                                                        <?php echo e($errors->first('flutterwave_public_key')); ?>

                                                                    </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paystack_secret_key" class="form-control-label"><?php echo e(__('Secret Key')); ?></label>
                                                            <input type="text" name="flutterwave_secret_key" id="flutterwave_secret_key" class="form-control form-control-label" value="<?php echo e(isset($company_payment_setting['flutterwave_secret_key'])?$company_payment_setting['flutterwave_secret_key']:''); ?>" placeholder="<?php echo e(__('Secret Key')); ?>"/>
                                                            <?php if($errors->has('flutterwave_secret_key')): ?>
                                                                <span class="invalid-feedback d-block">
                                                                        <?php echo e($errors->first('flutterwave_secret_key')); ?>

                                                                    </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Razorpay -->
                                    <div class="card">
                                        <div class="card-header py-4" id="heading-2-8" data-toggle="collapse" role="button" data-target="#collapse-2-8" aria-expanded="false" aria-controls="collapse-2-8">
                                            <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i><?php echo e(__('Razorpay')); ?></h6>
                                        </div>
                                        <div id="collapse-2-8" class="collapse" aria-labelledby="heading-2-7" data-parent="#accordion-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 py-2">

                                                        <small> <?php echo e(__('Note: This detail will use for invoice payment.')); ?></small>
                                                    </div>
                                                    <div class="col-6 py-2 text-right">
                                                        <div class="custom-control custom-switch">
                                                            <input type="hidden" name="is_razorpay_enabled" value="off">
                                                            <input type="checkbox" class="custom-control-input " name="is_razorpay_enabled" id="is_razorpay_enabled" <?php echo e(isset($company_payment_setting['is_razorpay_enabled']) && $company_payment_setting['is_razorpay_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                            <label class="custom-control-label form-control-label" for="is_razorpay_enabled"><?php echo e(__('Enable Razorpay')); ?></label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paypal_client_id" class="form-control-label"><?php echo e(__('Public Key')); ?></label>

                                                            <input type="text" name="razorpay_public_key" id="razorpay_public_key" class="form-control" value="<?php echo e(isset($company_payment_setting['razorpay_public_key'])?$company_payment_setting['razorpay_public_key']:''); ?>" placeholder="<?php echo e(__('Public Key')); ?>"/>
                                                            <?php if($errors->has('razorpay_public_key')): ?>
                                                                <span class="invalid-feedback d-block">
                                                                        <?php echo e($errors->first('razorpay_public_key')); ?>

                                                                    </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paystack_secret_key" class="form-control-label"><?php echo e(__('Secret Key')); ?></label>
                                                            <input type="text" name="razorpay_secret_key" id="razorpay_secret_key" class="form-control" value="<?php echo e(isset($company_payment_setting['razorpay_secret_key'])?$company_payment_setting['razorpay_secret_key']:''); ?>" placeholder="<?php echo e(__('Secret Key')); ?>"/>
                                                            <?php if($errors->has('razorpay_secret_key')): ?>
                                                                <span class="invalid-feedback d-block">
                                                                        <?php echo e($errors->first('razorpay_secret_key')); ?>

                                                                    </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mercado Pago-->
                                    <div class="card">
                                        <div class="card-header py-4" id="heading-2-12" data-toggle="collapse" role="button" data-target="#collapse-2-12" aria-expanded="false" aria-controls="collapse-2-12">
                                            <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i><?php echo e(__('Mercado Pago')); ?></h6>
                                        </div>
                                        <div id="collapse-2-12" class="collapse" aria-labelledby="heading-2-12" data-parent="#accordion-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 py-2">
                                                        <h5 class="h5"><?php echo e(__('Mercado Pago')); ?></h5>
                                                        <small> <?php echo e(__('Note: This detail will use for make checkout of plan.')); ?></small>
                                                    </div>
                                                    <div class="col-6 py-2 text-right">
                                                        <div class="custom-control custom-switch">
                                                            <input type="hidden" name="is_mercado_enabled" value="off">
                                                            <input type="checkbox" class="custom-control-input" name="is_mercado_enabled" id="is_mercado_enabled" <?php echo e(isset($company_payment_setting['is_mercado_enabled']) &&  $company_payment_setting['is_mercado_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                            <label class="custom-control-label form-control-label" for="is_mercado_enabled"><?php echo e(__('Enable Mercado Pago')); ?></label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-4 pb-4">
                                                        <label class="coingate-label form-control-label" for="mercado_mode"><?php echo e(__('Mercado Mode')); ?></label> <br>
                                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                            <label class="btn btn-primary btn-sm <?php echo e(isset($company_payment_setting['mercado_mode']) && $company_payment_setting['mercado_mode'] == 'sandbox' ? 'active' : ''); ?>">
                                                                <input type="radio" name="mercado_mode" value="sandbox" <?php echo e(isset($company_payment_setting['mercado_mode']) && $company_payment_setting['mercado_mode'] == '' || isset($company_payment_setting['mercado_mode']) && $company_payment_setting['mercado_mode'] == 'sandbox' ? 'checked="checked"' : ''); ?>><?php echo e(__('Sandbox')); ?>

                                                            </label>
                                                            <label class="btn btn-primary btn-sm <?php echo e(isset($company_payment_setting['mercado_mode']) && $company_payment_setting['mercado_mode'] == 'live' ? 'active' : ''); ?>">
                                                                <input type="radio" name="mercado_mode" value="live" <?php echo e(isset($company_payment_setting['mercado_mode']) && $company_payment_setting['mercado_mode'] == 'live' ? 'checked="checked"' : ''); ?>><?php echo e(__('Live')); ?>

                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="form-group">
                                                            <label for="mercado_access_token"><?php echo e(__('Access Token')); ?></label>
                                                            <input type="text" name="mercado_access_token" id="mercado_access_token" class="form-control" value="<?php echo e(isset($company_payment_setting['mercado_access_token']) ? $company_payment_setting['mercado_access_token']:''); ?>" placeholder="<?php echo e(__('Access Token')); ?>"/>
                                                            <?php if($errors->has('mercado_secret_key')): ?>
                                                                <span class="invalid-feedback d-block">
                                <?php echo e($errors->first('mercado_access_token')); ?>

                            </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Paytm -->
                                    <div class="card">
                                        <div class="card-header py-4" id="heading-2-8" data-toggle="collapse" role="button" data-target="#collapse-2-9" aria-expanded="false" aria-controls="collapse-2-9">
                                            <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i><?php echo e(__('Paytm')); ?></h6>
                                        </div>
                                        <div id="collapse-2-9" class="collapse" aria-labelledby="heading-2-7" data-parent="#accordion-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 py-2">

                                                        <small> <?php echo e(__('Note: This detail will use for invoice payment.')); ?></small>
                                                    </div>
                                                    <div class="col-6 py-2 text-right">
                                                        <div class="custom-control custom-switch">
                                                            <input type="hidden" name="is_paytm_enabled" value="off">
                                                            <input type="checkbox" class="custom-control-input" name="is_paytm_enabled" id="is_paytm_enabled" <?php echo e(isset($company_payment_setting['is_paytm_enabled']) && $company_payment_setting['is_paytm_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                            <label class="custom-control-label form-control-label" for="is_paytm_enabled"><?php echo e(__('Enable Paytm')); ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 pb-4">
                                                        <label class="paypal-label form-control-label" for="paypal_mode"><?php echo e(__('Paytm Environment')); ?></label> <br>
                                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                            <label class="btn btn-primary btn-sm <?php echo e(isset($company_payment_setting['paytm_mode']) && $company_payment_setting['paytm_mode'] == 'local' ? 'active' : ''); ?>">
                                                                <input type="radio" name="paytm_mode" value="local" <?php echo e(isset($company_payment_setting['paytm_mode']) && $company_payment_setting['paytm_mode'] == '' || isset($company_payment_setting['paytm_mode']) && $company_payment_setting['paytm_mode'] == 'local' ? 'checked="checked"' : ''); ?>><?php echo e(__('Local')); ?>

                                                            </label>
                                                            <label class="btn btn-primary btn-sm <?php echo e(isset($company_payment_setting['paytm_mode']) && $company_payment_setting['paytm_mode'] == 'live' ? 'active' : ''); ?>">
                                                                <input type="radio" name="paytm_mode" value="production" <?php echo e(isset($company_payment_setting['paytm_mode']) && $company_payment_setting['paytm_mode'] == 'production' ? 'checked="checked"' : ''); ?>><?php echo e(__('Production')); ?>

                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="paytm_public_key" class="form-control-label"><?php echo e(__('Merchant ID')); ?></label>
                                                            <input type="text" name="paytm_merchant_id" id="paytm_merchant_id" class="form-control" value="<?php echo e(isset($company_payment_setting['paytm_merchant_id'])? $company_payment_setting['paytm_merchant_id']:''); ?>" placeholder="<?php echo e(__('Merchant ID')); ?>"/>
                                                            <?php if($errors->has('paytm_merchant_id')): ?>
                                                                <span class="invalid-feedback d-block">
                                                                    <?php echo e($errors->first('paytm_merchant_id')); ?>

                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="paytm_secret_key" class="form-control-label"><?php echo e(__('Merchant Key')); ?></label>
                                                            <input type="text" name="paytm_merchant_key" id="paytm_merchant_key" class="form-control" value="<?php echo e(isset($company_payment_setting['paytm_merchant_key']) ? $company_payment_setting['paytm_merchant_key']:''); ?>" placeholder="<?php echo e(__('Merchant Key')); ?>"/>
                                                            <?php if($errors->has('paytm_merchant_key')): ?>
                                                                <span class="invalid-feedback d-block">
                                                                    <?php echo e($errors->first('paytm_merchant_key')); ?>

                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="paytm_industry_type" class="form-control-label"> <?php echo e(__('Industry Type')); ?></label>
                                                            <input type="text" name="paytm_industry_type" id="paytm_industry_type" class="form-control" value="<?php echo e(isset($company_payment_setting['paytm_industry_type']) ?$company_payment_setting['paytm_industry_type']:''); ?>" placeholder="<?php echo e(__('Industry Type')); ?>"/>
                                                            <?php if($errors->has('paytm_industry_type')): ?>
                                                                <span class="invalid-feedback d-block">
                                                                    <?php echo e($errors->first('paytm_industry_type')); ?>

                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mollie -->
                                    <div class="card">
                                        <div class="card-header py-4" id="heading-2-8" data-toggle="collapse" role="button" data-target="#collapse-2-10" aria-expanded="false" aria-controls="collapse-2-10">
                                            <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i><?php echo e(__('Mollie')); ?></h6>
                                        </div>
                                        <div id="collapse-2-10" class="collapse" aria-labelledby="heading-2-7" data-parent="#accordion-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 py-2">

                                                        <small> <?php echo e(__('Note: This detail will use for invoice payment.')); ?></small>
                                                    </div>
                                                    <div class="col-6 py-2 text-right">
                                                        <div class="custom-control custom-switch">
                                                            <input type="hidden" name="is_mollie_enabled" value="off">
                                                            <input type="checkbox" class="custom-control-input" name="is_mollie_enabled" id="is_mollie_enabled" <?php echo e(isset($company_payment_setting['is_mollie_enabled']) && $company_payment_setting['is_mollie_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                            <label class="custom-control-label form-control-label" for="is_mollie_enabled"><?php echo e(__('Enable Mollie')); ?></label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="mollie_api_key" class="form-control-label"><?php echo e(__('Mollie Api Key')); ?></label>
                                                            <input type="text" name="mollie_api_key" id="mollie_api_key" class="form-control" value="<?php echo e(isset($company_payment_setting['mollie_api_key'])?$company_payment_setting['mollie_api_key']:''); ?>" placeholder="<?php echo e(__('Mollie Api Key')); ?>"/>
                                                            <?php if($errors->has('mollie_api_key')): ?>
                                                                <span class="invalid-feedback d-block">
                                                                        <?php echo e($errors->first('mollie_api_key')); ?>

                                                                    </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="mollie_profile_id" class="form-control-label"><?php echo e(__('Mollie Profile Id')); ?></label>
                                                            <input type="text" name="mollie_profile_id" id="mollie_profile_id" class="form-control" value="<?php echo e(isset($company_payment_setting['mollie_profile_id'])?$company_payment_setting['mollie_profile_id']:''); ?>" placeholder="<?php echo e(__('Mollie Profile Id')); ?>"/>
                                                            <?php if($errors->has('mollie_profile_id')): ?>
                                                                <span class="invalid-feedback d-block">
                                                                        <?php echo e($errors->first('mollie_profile_id')); ?>

                                                                    </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="mollie_partner_id" class="form-control-label"><?php echo e(__('Mollie Partner Id')); ?></label>
                                                            <input type="text" name="mollie_partner_id" id="mollie_partner_id" class="form-control" value="<?php echo e(isset($company_payment_setting['mollie_partner_id'])?$company_payment_setting['mollie_partner_id']:''); ?>" placeholder="<?php echo e(__('Mollie Partner Id')); ?>"/>
                                                            <?php if($errors->has('mollie_partner_id')): ?>
                                                                <span class="invalid-feedback d-block">
                                                                        <?php echo e($errors->first('mollie_partner_id')); ?>

                                                                    </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Skrill -->
                                    <div class="card">
                                        <div class="card-header py-4" id="heading-2-8" data-toggle="collapse" role="button" data-target="#collapse-2-13" aria-expanded="false" aria-controls="collapse-2-10">
                                            <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i><?php echo e(__('Skrill')); ?></h6>
                                        </div>
                                        <div id="collapse-2-13" class="collapse" aria-labelledby="heading-2-7" data-parent="#accordion-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 py-2">

                                                        <small> <?php echo e(__('Note: This detail will use for invoice payment.')); ?></small>
                                                    </div>
                                                    <div class="col-6 py-2 text-right">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" name="is_skrill_enabled" id="is_skrill_enabled" <?php echo e(isset($company_payment_setting['is_skrill_enabled']) && $company_payment_setting['is_skrill_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                            <label class="custom-control-label form-control-label" for="is_skrill_enabled"><?php echo e(__('Enable Skrill')); ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="mollie_api_key" class="form-control-label"><?php echo e(__('Skrill Email')); ?></label>
                                                            <input type="email" name="skrill_email" id="skrill_email" class="form-control" value="<?php echo e(isset($company_payment_setting['skrill_email'])?$company_payment_setting['skrill_email']:''); ?>" placeholder="<?php echo e(__('Mollie Api Key')); ?>"/>
                                                            <?php if($errors->has('skrill_email')): ?>
                                                                <span class="invalid-feedback d-block">
                                                                        <?php echo e($errors->first('skrill_email')); ?>

                                                                    </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                        <!-- CoinGate -->
                                    <div class="card">
                                        <div class="card-header py-4" id="heading-2-8" data-toggle="collapse" role="button" data-target="#collapse-2-15" aria-expanded="false" aria-controls="collapse-2-10">
                                            <h6 class="mb-0"><i class="far fa-credit-card mr-3"></i><?php echo e(__('CoinGate')); ?></h6>
                                        </div>
                                        <div id="collapse-2-15" class="collapse" aria-labelledby="heading-2-7" data-parent="#accordion-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 py-2">

                                                        <small> <?php echo e(__('Note: This detail will use for invoice payment.')); ?></small>
                                                    </div>
                                                    <div class="col-6 py-2 text-right">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" name="is_coingate_enabled" id="is_coingate_enabled" <?php echo e(isset($company_payment_setting['is_coingate_enabled']) && $company_payment_setting['is_coingate_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                            <label class="custom-control-label form-control-label" for="is_coingate_enabled"><?php echo e(__('Enable CoinGate')); ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 pb-4">
                                                        <label class="coingate-label form-control-label" for="coingate_mode"><?php echo e(__('CoinGate Mode')); ?></label> <br>
                                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                            <label class="btn btn-primary btn-sm <?php echo e(isset($company_payment_setting['coingate_mode']) && $company_payment_setting['coingate_mode'] == 'sandbox' ? 'active' : ''); ?>">
                                                                <input type="radio" name="coingate_mode" value="sandbox" <?php echo e(isset($company_payment_setting['coingate_mode']) && $company_payment_setting['coingate_mode'] == '' || isset($company_payment_setting['coingate_mode']) && $company_payment_setting['coingate_mode'] == 'sandbox' ? 'checked="checked"' : ''); ?>><?php echo e(__('Sandbox')); ?>

                                                            </label>
                                                            <label class="btn btn-primary btn-sm <?php echo e(isset($company_payment_setting['coingate_mode']) && $company_payment_setting['coingate_mode'] == 'live' ? 'active' : ''); ?>">
                                                                <input type="radio" name="coingate_mode" value="live" <?php echo e(isset($company_payment_setting['coingate_mode']) && $company_payment_setting['coingate_mode'] == 'live' ? 'checked="checked"' : ''); ?>><?php echo e(__('Live')); ?>

                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="coingate_auth_token" class="form-control-label"><?php echo e(__('CoinGate Auth Token')); ?></label>
                                                            <input type="text" name="coingate_auth_token" id="coingate_auth_token" class="form-control" value="<?php echo e(isset($company_payment_setting['coingate_auth_token'])?$company_payment_setting['coingate_auth_token']:''); ?>" placeholder="<?php echo e(__('CoinGate Auth Token')); ?>"/>
                                                            <?php if($errors->has('coingate_auth_token')): ?>
                                                                <span class="invalid-feedback d-block">
                                                                    <?php echo e($errors->first('coingate_auth_token')); ?>

                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- PaymentWall -->
                                    <div class="card">
                                        <div class="card-header py-4" id="heading-2-11" data-toggle="collapse" role="button"
                                             data-target="#collapse-2-11" aria-expanded="false" aria-controls="collapse-2-11">
                                            <h6 class="mb-0"><i
                                                    class="far fa-credit-card mr-3"></i><?php echo e(__('PaymentWall')); ?></h6>
                                        </div>
                                        <div id="collapse-2-11" class="collapse" aria-labelledby="heading-2-11"
                                             data-parent="#accordion-2">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6 py-2">

                                                        <small>
                                                            <?php echo e(__('Note: This detail will use for make checkout of plan.')); ?></small>
                                                    </div>
                                                    <div class="col-6 py-2 text-right">
                                                        <div class="custom-control custom-switch">
                                                            <input type="hidden" name="is_paymentwall_enabled" value="off">
                                                            <input type="checkbox" class="custom-control-input"
                                                                   name="is_paymentwall_enabled" id="is_paymentwall_enabled"
                                                                <?php echo e(isset($company_payment_setting['is_paymentwall_enabled']) && $company_payment_setting['is_paymentwall_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                            <label class="custom-control-label form-control-label"
                                                                   for="is_paymentwall_enabled"><?php echo e(__('Enable PaymentWall')); ?></label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paymentwall_public_key"
                                                                   class="form-control-label"><?php echo e(__('Public Key')); ?></label>
                                                            <input type="text" name="paymentwall_public_key"
                                                                   id="paymentwall_public_key"
                                                                   class="form-control form-control-label"
                                                                   value="<?php echo e(isset($company_payment_setting['paymentwall_public_key']) ? $company_payment_setting['paymentwall_public_key'] : ''); ?>"
                                                                   placeholder="<?php echo e(__('Public Key')); ?>" />
                                                            <?php if($errors->has('paymentwall_public_key')): ?>
                                                                <span class="invalid-feedback d-block">
                                                                    <?php echo e($errors->first('paymentwall_public_key')); ?>

                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="paymentwall_secret_key"
                                                                   class="form-control-label"><?php echo e(__('Secret Key')); ?></label>
                                                            <input type="text" name="paymentwall_secret_key"
                                                                   id="paymentwall_secret_key"
                                                                   class="form-control form-control-label"
                                                                   value="<?php echo e(isset($company_payment_setting['paymentwall_secret_key']) ? $company_payment_setting['paymentwall_secret_key'] : ''); ?>"
                                                                   placeholder="<?php echo e(__('Secret Key')); ?>" />
                                                            <?php if($errors->has('paymentwall_secret_key')): ?>
                                                                <span class="invalid-feedback d-block">
                                                                    <?php echo e($errors->first('paymentwall_secret_key')); ?>

                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-lg-12  text-right">
                                    <input type="submit" value="<?php echo e(__('Save Changes')); ?>" class="btn-submit text-white">
                                </div>
                                <?php echo e(Form::close()); ?>

                            </div>
                        </div>
                    </div>
                    <div id="zoom-meeting-setting" class="tab-pane">
                        <div class="col-md-12">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                    <h4 class="h4 font-weight-400 float-left pb-2"><?php echo e(__('Zoom-Meeting Setting')); ?></h4>
                                </div>
                            </div>
                            <div class="card bg-none">
                                <?php echo e(Form::model($settings,array('route'=>'zoom.settings','method'=>'post'))); ?>

                                <div class="card-body pd-0">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-control-label mb-0"><?php echo e(__('Zoom API Key')); ?></label> <br>
                                            <small><?php echo e(__("Zoom API Key.")); ?></small>
                                            <?php echo e(Form::text('zoom_apikey',isset($settings['zoom_apikey'])?$settings['zoom_apikey']:'', ['class' => 'form-control', 'placeholder' => __('Enter Zoom API Key')])); ?>

                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="form-control-label mb-0"><?php echo e(__('Zoom API Secret')); ?></label> <br>
                                            <small><?php echo e(__("Zoom API Secret.")); ?></small>
                                            <?php echo e(Form::text('zoom_apisecret',isset($settings['zoom_apisecret'])?$settings['zoom_apisecret']:'', ['class' => 'form-control', 'placeholder' => __('Enter Zoom API Secret')])); ?>

                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-12  text-right">
                                    <input type="submit" value="<?php echo e(__('Save Changes')); ?>" class="btn-submit text-white">
                                </div>
                                <?php echo e(Form::close()); ?>

                            </div>
                        </div>
                    </div>
                    <div id="slack-setting" class="tab-pane" >
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                <h4 class="h4 font-weight-400 float-left pb-2"><?php echo e(__('Slack Setting')); ?></h4>
                            </div>
                        </div>
                        <div class="card bg-none">
                            <?php echo e(Form::open(['route' => 'slack.settings','id'=>'slack-setting','method'=>'post' ,'class'=>'d-contents'])); ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="small-title"><?php echo e(__('Slack Webhook URL')); ?></h4>
                                    <div class="col-md-8">
                                        <?php echo e(Form::text('slack_webhook', isset($settings['slack_webhook']) ?$settings['slack_webhook'] :'', ['class' => 'form-control w-100', 'placeholder' => __('Enter Slack Webhook URL'), 'required' => 'required'])); ?>

                                    </div>
                                </div>

                                <div class="col-md-12 mt-4 mb-2">
                                    <h4 class="small-title"><?php echo e(__('Module Setting')); ?></h4>
                                </div>

                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Lead create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('lead_notification', '1',isset($settings['lead_notification']) && $settings['lead_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'lead_notification'))); ?>

                                                <label class="custom-control-label" for="lead_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Deal create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('deal_notification', '1',isset($settings['deal_notification']) && $settings['deal_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'deal_notification'))); ?>

                                                <label class="custom-control-label" for="deal_notification"></label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Lead To Deal convert')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('leadtodeal_notification', '1',isset($settings['leadtodeal_notification']) && $settings['leadtodeal_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'leadtodeal_notification'))); ?>

                                                <label class="custom-control-label" for="leadtodeal_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Contract create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('contract_notification', '1',isset($settings['contract_notification']) && $settings['contract_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'contract_notification'))); ?>

                                                <label class="custom-control-label" for="contract_notification"></label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Project create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('project_notification', '1',isset($settings['project_notification']) && $settings['project_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'project_notification'))); ?>

                                                <label class="custom-control-label" for="project_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Task create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('task_notification', '1',isset($settings['task_notification']) && $settings['task_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'task_notification'))); ?>

                                                <label class="custom-control-label" for="task_notification"></label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Task Move create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('taskmove_notification', '1',isset($settings['taskmove_notification']) && $settings['taskmove_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'taskmove_notification'))); ?>

                                                <label class="custom-control-label" for="taskmove_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Task Comment')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('taskcomment_notification', '1',isset($settings['taskcomment_notification']) && $settings['taskcomment_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'taskcomment_notification'))); ?>

                                                <label class="custom-control-label" for="taskcomment_notification"></label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Monthly Payslip Generate')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('payslip_notification', '1',isset($settings['payslip_notification']) && $settings['payslip_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'payslip_notification'))); ?>

                                                <label class="custom-control-label" for="payslip_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Award create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('award_notification', '1',isset($settings['award_notification']) && $settings['award_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'award_notification'))); ?>

                                                <label class="custom-control-label" for="award_notification"></label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Announcement create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('announcement_notification', '1',isset($settings['announcement_notification']) && $settings['announcement_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'announcement_notification'))); ?>

                                                <label class="custom-control-label" for="announcement_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Holiday create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('holiday_notification', '1',isset($settings['holiday_notification']) && $settings['holiday_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'holiday_notification'))); ?>

                                                <label class="custom-control-label" for="holiday_notification"></label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Support create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('support_notification', '1',isset($settings['support_notification']) && $settings['support_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'support_notification'))); ?>

                                                <label class="custom-control-label" for="support_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Event create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('event_notification', '1',isset($settings['event_notification']) && $settings['event_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'event_notification'))); ?>

                                                <label class="custom-control-label" for="event_notification"></label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Meeting create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('meeting_notification', '1',isset($settings['meeting_notification']) && $settings['meeting_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'meeting_notification'))); ?>

                                                <label class="custom-control-label" for="meeting_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Company Policy create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('policy_notification', '1',isset($settings['policy_notification']) && $settings['policy_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'policy_notification'))); ?>

                                                <label class="custom-control-label" for="policy_notification"></label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Invoice create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('invoice_notification', '1',isset($settings['invoice_notification']) && $settings['invoice_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'invoice_notification'))); ?>

                                                <label class="custom-control-label" for="invoice_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Revenue create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('revenue_notification', '1',isset($settings['revenue_notification']) && $settings['revenue_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'revenue_notification'))); ?>

                                                <label class="custom-control-label" for="revenue_notification"></label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Bill create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('bill_notification', '1',isset($settings['bill_notification']) && $settings['bill_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'bill_notification'))); ?>

                                                <label class="custom-control-label" for="bill_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Payment create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('payment_notification', '1',isset($settings['payment_notification']) && $settings['payment_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'payment_notification'))); ?>

                                                <label class="custom-control-label" for="payment_notification"></label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Budget create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('budget_notification', '1',isset($settings['budget_notification']) && $settings['budget_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'budget_notification'))); ?>

                                                <label class="custom-control-label" for="budget_notification"></label>
                                            </div>
                                        </li>


                                    </ul>
                                </div>

                            </div>

                            <div class="col-lg-12  text-right">
                                <input type="submit" value="<?php echo e(__('Save Changes')); ?>" class="btn-submit text-white">
                            </div>
                            <?php echo e(Form::close()); ?>

                        </div>
                    </div>
                    <div id="telegram-setting" class="tab-pane" >
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                <h4 class="h4 font-weight-400 float-left pb-2"><?php echo e(__('Telegram Setting')); ?></h4>
                            </div>
                        </div>
                        <div class="card bg-none">
                            <?php echo e(Form::open(['route' => 'telegram.settings','id'=>'telegram-setting','method'=>'post' ,'class'=>'d-contents'])); ?>

                            <div class="row">

                                <div class="card-body pd-0">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-control-label mb-0"><?php echo e(__('Telegram AccessToken')); ?></label> <br>
                                            <?php echo e(Form::text('telegram_accestoken',isset($setting['telegram_accestoken'])?$settings['telegram_accestoken']:'', ['class' => 'form-control', 'placeholder' => __('Enter Telegram AccessToken')])); ?>

                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="form-control-label mb-0"><?php echo e(__('Telegram ChatID')); ?></label> <br>
                                            <?php echo e(Form::text('telegram_chatid',isset($setting['telegram_chatid'])?$setting['telegram_chatid']:'', ['class' => 'form-control', 'placeholder' => __('Enter Telegram ChatID')])); ?>

                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-12 mt-0 mb-0">
                                    <h4 class="small-title"><?php echo e(__('Module Setting')); ?></h4>
                                </div>

                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Lead create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('telegram_lead_notification', '1',isset($settings['telegram_lead_notification']) && $settings['telegram_lead_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_lead_notification'))); ?>

                                                <label class="custom-control-label" for="telegram_lead_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Deal create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('telegram_deal_notification', '1',isset($settings['telegram_deal_notification']) && $settings['telegram_deal_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_deal_notification'))); ?>

                                                <label class="custom-control-label" for="telegram_deal_notification"></label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Lead To Deal convert')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('telegram_leadtodeal_notification', '1',isset($settings['telegram_leadtodeal_notification']) && $settings['telegram_leadtodeal_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_leadtodeal_notification'))); ?>

                                                <label class="custom-control-label" for="telegram_leadtodeal_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Contract create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('telegram_contract_notification', '1',isset($settings['telegram_contract_notification']) && $settings['telegram_contract_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_contract_notification'))); ?>

                                                <label class="custom-control-label" for="telegram_contract_notification"></label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Project create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('telegram_project_notification', '1',isset($settings['telegram_project_notification']) && $settings['telegram_project_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_project_notification'))); ?>

                                                <label class="custom-control-label" for="telegram_project_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Task create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('telegram_task_notification', '1',isset($settings['telegram_task_notification']) && $settings['telegram_task_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_task_notification'))); ?>

                                                <label class="custom-control-label" for="telegram_task_notification"></label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Task Move create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('telegram_taskmove_notification', '1',isset($settings['telegram_taskmove_notification']) && $settings['telegram_taskmove_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_taskmove_notification'))); ?>

                                                <label class="custom-control-label" for="telegram_taskmove_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Task Comment')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('telegram_taskcomment_notification', '1',isset($settings['telegram_taskcomment_notification']) && $settings['telegram_taskcomment_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_taskcomment_notification'))); ?>

                                                <label class="custom-control-label" for="telegram_taskcomment_notification"></label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Monthly Payslip Generate')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('telegram_payslip_notification', '1',isset($settings['telegram_payslip_notification']) && $settings['telegram_payslip_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_payslip_notification'))); ?>

                                                <label class="custom-control-label" for="telegram_payslip_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Award create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('telegram_award_notification', '1',isset($settings['telegram_award_notification']) && $settings['telegram_award_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_award_notification'))); ?>

                                                <label class="custom-control-label" for="telegram_award_notification"></label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Announcement create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('telegram_announcement_notification', '1',isset($settings['telegram_announcement_notification']) && $settings['telegram_announcement_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_announcement_notification'))); ?>

                                                <label class="custom-control-label" for="telegram_announcement_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Holiday create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('telegram_holiday_notification', '1',isset($settings['telegram_holiday_notification']) && $settings['telegram_holiday_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_holiday_notification'))); ?>

                                                <label class="custom-control-label" for="telegram_holiday_notification"></label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Support create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('telegram_support_notification', '1',isset($settings['telegram_support_notification']) && $settings['telegram_support_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_support_notification'))); ?>

                                                <label class="custom-control-label" for="telegram_support_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Event create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('telegram_event_notification', '1',isset($settings['telegram_event_notification']) && $settings['telegram_event_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_event_notification'))); ?>

                                                <label class="custom-control-label" for="telegram_event_notification"></label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Meeting create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('telegram_meeting_notification', '1',isset($settings['telegram_meeting_notification']) && $settings['telegram_meeting_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_meeting_notification'))); ?>

                                                <label class="custom-control-label" for="telegram_meeting_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Company Policy create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('telegram_policy_notification', '1',isset($settings['telegram_policy_notification']) && $settings['telegram_policy_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_policy_notification'))); ?>

                                                <label class="custom-control-label" for="telegram_policy_notification"></label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Invoice create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('telegram_invoice_notification', '1',isset($settings['telegram_invoice_notification']) && $settings['telegram_invoice_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_invoice_notification'))); ?>

                                                <label class="custom-control-label" for="telegram_invoice_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Revenue create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('telegram_revenue_notification', '1',isset($settings['telegram_revenue_notification']) && $settings['telegram_revenue_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_revenue_notification'))); ?>

                                                <label class="custom-control-label" for="telegram_revenue_notification"></label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Bill create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('telegram_bill_notification', '1',isset($settings['telegram_bill_notification']) && $settings['telegram_bill_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_bill_notification'))); ?>

                                                <label class="custom-control-label" for="telegram_bill_notification"></label>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Payment create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('telegram_payment_notification', '1',isset($settings['telegram_payment_notification']) && $settings['telegram_payment_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_payment_notification'))); ?>

                                                <label class="custom-control-label" for="telegram_payment_notification"></label>
                                            </div>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span><?php echo e(__('Budget create')); ?></span>
                                            <div class="custom-control custom-switch float-right">
                                                <?php echo e(Form::checkbox('telegram_budget_notification', '1',isset($settings['telegram_budget_notification']) && $settings['telegram_budget_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'telegram_budget_notification'))); ?>

                                                <label class="custom-control-label" for="telegram_budget_notification"></label>
                                            </div>
                                        </li>


                                    </ul>
                                </div>



                            </div>

                            <div class="col-lg-12  text-right">
                                <input type="submit" value="<?php echo e(__('Save Changes')); ?>" class="btn-submit text-white">
                            </div>
                            <?php echo e(Form::close()); ?>

                        </div>
                    </div>
                    <div id="twilio-setting" class="tab-pane">
                        <div class="col-md-12">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-6 col-sm-6 mb-3 mb-md-0">
                                    <h4 class="h4 font-weight-400 float-left pb-2"><?php echo e(__('Twilio Settings')); ?></h4>
                                </div>
                            </div>
                            <div class="card bg-none">
                                <?php echo e(Form::model($settings,array('route'=>'twilio.setting','method'=>'post'))); ?>

                                <div class="card-body pd-0">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('twilio_sid',__('Twilio SID '),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('twilio_sid', isset($settings['twilio_sid']) ?$settings['twilio_sid'] :'', ['class' => 'form-control w-100', 'placeholder' => __('Enter Twilio SID'), 'required' => 'required'])); ?>

                                            <?php $__errorArgs = ['twilio_sid'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-twilio_sid" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('twilio_token',__('Twilio Token'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('twilio_token', isset($settings['twilio_token']) ?$settings['twilio_token'] :'', ['class' => 'form-control w-100', 'placeholder' => __('Enter Twilio Token'), 'required' => 'required'])); ?>

                                            <?php $__errorArgs = ['twilio_token'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-twilio_token" role="alert">
                                                            <strong class="text-danger"><?php echo e($message); ?></strong>
                                                        </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('twilio_from',__('Twilio From'),array('class'=>'form-control-label'))); ?>

                                            <?php echo e(Form::text('twilio_from', isset($settings['twilio_from']) ?$settings['twilio_from'] :'', ['class' => 'form-control w-100', 'placeholder' => __('Enter Twilio From'), 'required' => 'required'])); ?>

                                            <?php $__errorArgs = ['twilio_from'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-twilio_from" role="alert">
                                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <div class="col-md-12 mt-4 mb-2">
                                            <h4 class="small-title"><?php echo e(__('Module Setting')); ?></h4>
                                        </div>

                                        <div class="col-md-6">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <span><?php echo e(__('Customer create')); ?></span>
                                                    <div class="custom-control custom-switch float-right">
                                                        <?php echo e(Form::checkbox('twilio_customer_notification', '1',isset($settings['twilio_customer_notification']) && $settings['twilio_customer_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'twilio_customer_notification'))); ?>

                                                        <label class="custom-control-label" for="twilio_customer_notification"></label>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <span><?php echo e(__('Vendor create')); ?></span>
                                                    <div class="custom-control custom-switch float-right">
                                                        <?php echo e(Form::checkbox('twilio_vender_notification', '1',isset($settings['twilio_vender_notification']) && $settings['twilio_vender_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'twilio_vender_notification'))); ?>

                                                        <label class="custom-control-label" for="twilio_vender_notification"></label>
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>

                                        <div class="col-md-6">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <span><?php echo e(__('Invoice Create')); ?></span>
                                                    <div class="custom-control custom-switch float-right">
                                                        <?php echo e(Form::checkbox('twilio_invoice_notification', '1',isset($settings['twilio_invoice_notification']) && $settings['twilio_invoice_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'twilio_invoice_notification'))); ?>

                                                        <label class="custom-control-label" for="twilio_invoice_notification"></label>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <span><?php echo e(__('Revenue create')); ?></span>
                                                    <div class="custom-control custom-switch float-right">
                                                        <?php echo e(Form::checkbox('twilio_revenue_notification', '1',isset($settings['twilio_revenue_notification']) && $settings['twilio_revenue_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'twilio_revenue_notification'))); ?>

                                                        <label class="custom-control-label" for="twilio_revenue_notification"></label>
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>

                                        <div class="col-md-6">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <span><?php echo e(__('Bill Create')); ?></span>
                                                    <div class="custom-control custom-switch float-right">
                                                        <?php echo e(Form::checkbox('twilio_bill_notification', '1',isset($settings['twilio_bill_notification']) && $settings['twilio_bill_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'twilio_bill_notification'))); ?>

                                                        <label class="custom-control-label" for="twilio_bill_notification"></label>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <span><?php echo e(__('Proposal create')); ?></span>
                                                    <div class="custom-control custom-switch float-right">
                                                        <?php echo e(Form::checkbox('twilio_proposal_notification', '1',isset($settings['twilio_proposal_notification']) && $settings['twilio_proposal_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'twilio_proposal_notification'))); ?>

                                                        <label class="custom-control-label" for="twilio_proposal_notification"></label>
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>

                                        <div class="col-md-6">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <span><?php echo e(__('Payment Create')); ?></span>
                                                    <div class="custom-control custom-switch float-right">
                                                        <?php echo e(Form::checkbox('twilio_payment_notification', '1',isset($settings['twilio_payment_notification']) && $settings['twilio_payment_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'twilio_payment_notification'))); ?>

                                                        <label class="custom-control-label" for="twilio_payment_notification"></label>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <span><?php echo e(__('Invoice Reminder')); ?></span>
                                                    <div class="custom-control custom-switch float-right">
                                                        <?php echo e(Form::checkbox('twilio_reminder_notification', '1',isset($settings['twilio_reminder_notification']) && $settings['twilio_reminder_notification'] == '1' ?'checked':'',array('class'=>'custom-control-input','id'=>'twilio_reminder_notification'))); ?>

                                                        <label class="custom-control-label" for="twilio_reminder_notification"></label>
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>


                                    </div>
                                </div>
                                <div class="col-lg-12  text-right">
                                    <input type="submit" value="<?php echo e(__('Save Changes')); ?>" class="btn-submit text-white">
                                </div>
                                <?php echo e(Form::close()); ?>

                            </div>
                        </div>
                    </div>




                </div>
            </section>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/settings/company.blade.php ENDPATH**/ ?>