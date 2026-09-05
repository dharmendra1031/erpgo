<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo e(!empty($companySettings['title_text']) ? $companySettings['title_text']->value : config('app.name', 'ERPGO')); ?> - <?php echo e(__('Career')); ?></title>

    <link rel="icon" href="<?php echo e(asset(Storage::url('uploads/logo/')).'/'.(isset($companySettings['company_favicon']) && !empty($companySettings['company_favicon'])?$companySettings['company_favicon']->value:'favicon.png')); ?>" type="image" sizes="16x16">

    <link rel="stylesheet" href="<?php echo e(asset('assets/libs/@fortawesome/fontawesome-free/css/all.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/job/css/site.css')); ?>" id="stylesheet">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>

<body>
<header class="header header-transparent" id="header-main">

    <nav class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light bg-white" id="navbar-main">
        <div class="container px-lg-0">
            <a class="navbar-brand mr-lg-5" href="#">
                <img class="hweb" alt="Image placeholder" src="<?php echo e(asset(Storage::url('uploads/logo/')).'/'.(isset($companySettings['company_logo']) && !empty($companySettings['company_logo'])?$companySettings['company_logo']->value:'logo.png')); ?>" id="navbar-logo" style="height: 50px;">
            </a>
            <button class="navbar-toggler pr-0" type="button" data-toggle="collapse" data-target="#navbar-main-collapse" aria-controls="navbar-main-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar-main-collapse">

                <ul class="navbar-nav align-items-lg-center ml-lg-auto">
                    <li class="nav-item">
                        <div class="dropdown global-icon" data-toggle="tooltip" data-original-titla="<?php echo e(__('Choose Language')); ?>">
                            <a class="nav-link px-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="0,10">
                                <i class="fas fa-globe-europe"></i>
                                <span class="d-none d-lg-inline-block"><?php echo e(\Str::upper($currantLang)); ?></span>
                            </a>

                            <div class="dropdown-menu  dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="dropdown-item <?php if($language == $currantLang): ?> text-danger <?php endif; ?>" href="<?php echo e(route('career',[$id,$language])); ?>"><?php echo e(\Str::upper($language)); ?></a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="main-content">
    <!-- Header (v16) -->
    <section class="slice slice-xl pb-6" data-offset-top="#header-main">
        <div class="container pt-5">
            <div class="row row-grid justify-content-center">
                <div class="col-lg-8 text-center">
                    <h6 class="text-sm text-uppercase ls-2 text-muted font-weight-700"><?php echo e(__('Careers')); ?></h6>
                    <h2 class="h1 mb-4"><?php echo e(__('Job openings')); ?></h2>
                    <p class="lead lh-180"><?php echo e(__('Work there. Find the dream job you’ve always wanted..')); ?></p>

                </div>
            </div>

        </div>
    </section>
    <!-- Table (v1) -->
    <section class="slice slice-lg bg-section-secondary">
        <span class="tongue tongue-top"><i class="fas fa-angle-up"></i></span>
        <div class="container">
            <div class="mb-5 text-center">
                <h3 class=" mt-4"><?php echo e(__('We help businesses grow')); ?></h3>
                <div class="fluid-paragraph mt-3">
                    <p class="lead lh-180 "><?php echo e(__('Always looking for better ways to do things, innovate and help people achieve their goals.')); ?></p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <div class="table-responsive-lg">
                        <table class="table table-hover table-scale--hover table-cards align-items-center">
                            <tbody>
                            <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div>
                                                <span class="avatar bg-dark text-white mr-4" title="<?php echo e(__('Job Position')); ?>"><?php echo e($job->position); ?></span>
                                            </div>
                                            <div class="media-body">
                                                <a href="<?php echo e(route('job.requirement',[$job->code,!empty($job)?$job->createdBy->lang:'en'])); ?>" class="h5 mb-0"><?php echo e($job->title); ?></a>
                                            </div>
                                        </div>
                                    </th>
                                    <td>
                                        <?php $__currentLoopData = explode(',',$job->skill); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge badge-soft-dark"><?php echo e($skill); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td><i class="fas fa-map-marker mr-3"></i><span class="h6"><?php echo e(!empty($job->branches)?$job->branches->name:'-'); ?></span></td>
                                </tr>
                                <tr class="table-divider"></tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<footer id="footer-main">
    <div class="footer-dark">
        <div class="container">
            <div class="row align-items-center justify-content-md-between py-4 mt-4 delimiter-top">
                <div class="col-md-6">
                    <div class="copyright text-sm font-weight-bold text-center text-md-left">
                        <?php echo e(!empty($companySettings['footer_text']) ? $companySettings['footer_text']->value : ''); ?>

                    </div>
                </div>
                <div class="col-md-6">
                    <ul class="nav justify-content-center justify-content-md-end mt-3 mt-md-0">
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="fab fa-dribbble"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="fab fa-github"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="fab fa-facebook"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="<?php echo e(asset('assets/js/site.core.js')); ?>"></script>
<script src="<?php echo e(asset('assets/libs/autosize/dist/autosize.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/site.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/demo.js')); ?> "></script>
</body>

</html>
<?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/job/career.blade.php ENDPATH**/ ?>