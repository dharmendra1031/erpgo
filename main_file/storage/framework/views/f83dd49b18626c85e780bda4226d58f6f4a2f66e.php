<!DOCTYPE html>
<?php
    $logo=asset(Storage::url('uploads/logo/'));
    $company_favicon=Utility::getValByName('company_favicon');

    $SITE_RTL = Cookie::get('SITE_RTL');

?>
<html lang="en" dir="<?php echo e($SITE_RTL == 'on'?'rtl':''); ?>">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?php echo e((Utility::getValByName('title_text')) ? Utility::getValByName('title_text') : config('app.name', 'ERPGO')); ?> - <?php echo $__env->yieldContent('page-title'); ?></title>
    <link rel="icon" href="<?php echo e($logo.'/'.(isset($company_favicon) && !empty($company_favicon)?$company_favicon:'favicon.png')); ?>" type="image" sizes="16x16">

    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/libs/@fortawesome/fontawesome-free/css/all.min.css')); ?>">





    <link rel="stylesheet" href="<?php echo e(asset('assets/libs/select2/dist/css/select2.min.css')); ?>">


    <link rel="stylesheet" href="<?php echo e(asset('assets/css/site.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/ac.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/stylesheet.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/custom.css')); ?>">
    <?php if($SITE_RTL=='on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap-rtl.css')); ?>">
    <?php endif; ?>
</head>

<body>
<?php echo $__env->yieldContent('content'); ?>

<!-- General JS Scripts -->
<script src="<?php echo e(asset('assets/libs/jquery/dist/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/libs/nicescroll/jquery.nicescroll.min.js')); ?> "></script>
<?php echo $__env->yieldPushContent('custom-scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/layouts/auth.blade.php ENDPATH**/ ?>