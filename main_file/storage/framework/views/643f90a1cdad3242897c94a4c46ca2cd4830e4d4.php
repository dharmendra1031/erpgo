<?php
    $users=\Auth::user();
    $profile=asset(Storage::url('uploads/avatar/'));
    //$currantLang = $users->currentLanguage();
    $languages=\App\Models\Utility::languages();
    $lang = !is_null(\Cookie::get('lang')) ? \Cookie::get('lang') : 'en';

    $unseenCounter=App\Models\ChMessage::where('to_id', Auth::user()->id)->where('seen', 0)->count();
?>
<nav class="navbar navbar-main navbar-expand-lg navbar-border n-top-header" id="navbar-main">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-main-collapse" aria-controls="navbar-main-collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- User's navbar -->
        <div class="navbar-user d-lg-none ml-auto">
            <ul class="navbar-nav flex-row align-items-center">

                <li class="nav-item">
                    <a href="#" class="nav-link nav-link-icon sidenav-toggler" data-action="sidenav-pin" data-target="#sidenav-main"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item">
                    <div class="dropdown global-icon" data-toggle="tooltip" data-original-titla="<?php echo e(__('Choose Language')); ?>">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-globe-europe"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <?php if(\Auth::user()->type=='super admin'): ?>
                                <a class="dropdown-item" href="<?php echo e(route('manage.language',[isset($lang)?$lang:'en'])); ?>"><?php echo e(__('Create & Customize')); ?></a>
                            <?php endif; ?>
                            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a class="dropdown-item <?php if($language == $lang): ?> text-danger <?php endif; ?>" href="<?php echo e(route('change.language',$language)); ?>"><?php echo e(Str::upper($language)); ?></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('change.mode')); ?>"><?php echo e((Auth::user()->mode == 'light') ? __('Dark Mode') : __('Light Mode')); ?></a>
                </li>
                <li class="nav-item dropdown dropdown-animate">
                    <a class="nav-link pr-lg-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="avatar avatar-sm rounded-circle">
                          <img src="<?php echo e((!empty($users->avatar)? $profile.'/'.$users->avatar : $profile.'/avatar.png')); ?>" class="hweb"/>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right dropdown-menu-arrow">
                        <h6 class="dropdown-header px-0"><?php echo e(__('Hi')); ?>, <?php echo e(\Auth::user()->name); ?></h6>
                        <?php if(\Auth::guard('customer')->check()): ?>
                            <a href="<?php echo e(route('customer.profile')); ?>" class="dropdown-item">
                                <i class="fas fa-user"></i> <span><?php echo e(__('My Profile')); ?></span>
                            </a>
                        <?php elseif(\Auth::guard('vender')->check()): ?>
                            <a href="<?php echo e(route('vender.profile')); ?>" class="dropdown-item">
                                <i class="fa fa-user"></i> <span><?php echo e(__('My Profile')); ?></span>
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('profile')); ?>" class="dropdown-item has-icon">
                                <i class="fa fa-user"></i> <span><?php echo e(__('My Profile')); ?></span>
                            </a>
                        <?php endif; ?>
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('frm-logout-mobile').submit();" class="dropdown-item">
                            <i class="fas fa-sign-out-alt"></i>
                            <span><?php echo e(__('Logout')); ?></span>
                        </a>
                        <?php if(\Auth::guard('customer')->check()): ?>
                            <form id="frm-logout-mobile" action="<?php echo e(route('customer.logout')); ?>" method="POST" class="d-none">
                                <?php echo e(csrf_field()); ?>

                            </form>
                        <?php else: ?>
                            <form id="frm-logout-mobile" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                <?php echo e(csrf_field()); ?>

                            </form>
                        <?php endif; ?>
                    </div>
                </li>



            </ul>


        </div>

        <div class="collapse navbar-collapse navbar-collapse-fade" id="navbar-main-collapse">
            <ul class="navbar-nav align-items-center d-none d-lg-flex">
                <li class="nav-item mr-4">
                    <a href="#" class="nav-link nav-link-icon sidenav-toggler" data-action="sidenav-pin" data-target="#sidenav-main"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item dropdown dropdown-animate">
                    <a class="nav-link pr-lg-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media media-pill align-items-center">
                          <span class="avatar rounded-circle">
                            <img src="<?php echo e((!empty($users->avatar)? $profile.'/'.$users->avatar : $profile.'/avatar.png')); ?>" class="hweb"/>
                          </span>
                            <div class="ml-2 d-none d-lg-block">
                                <span class="mb-0 text-sm font-weight-bold"><?php echo e(\Auth::user()->name); ?></span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right dropdown-menu-arrow">
                        <h6 class="dropdown-header px-0"><?php echo e(__('Hi')); ?>, <?php echo e(\Auth::user()->name); ?></h6>
                        <?php if(\Auth::guard('customer')->check()): ?>
                            <a href="<?php echo e(route('customer.profile')); ?>" class="dropdown-item">
                                <i class="fas fa-user"></i> <span><?php echo e(__('My Profile')); ?></span>
                            </a>
                        <?php elseif(\Auth::guard('vender')->check()): ?>
                            <a href="<?php echo e(route('vender.profile')); ?>" class="dropdown-item">
                                <i class="fa fa-user"></i> <span><?php echo e(__('My Profile')); ?></span>
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('profile')); ?>" class="dropdown-item has-icon">
                                <i class="fa fa-user"></i> <span><?php echo e(__('My Profile')); ?></span>
                            </a>
                        <?php endif; ?>
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo e(route('logout')); ?>" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('frm-logout-desktop').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <span><?php echo e(__('Logout')); ?></span>
                        </a>
                        <?php if(\Auth::guard('customer')->check()): ?>
                            <form id="frm-logout-desktop" action="<?php echo e(route('customer.logout')); ?>" method="POST" class="d-none">
                                <?php echo e(csrf_field()); ?>

                            </form>
                        <?php else: ?>
                            <form id="frm-logout-desktop" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                <?php echo e(csrf_field()); ?>

                            </form>
                        <?php endif; ?>
                    </div>
                </li>

                <?php if( \Auth::user()->type !='client' && \Auth::user()->type !='super admin' ): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(url('chats')); ?>" class="">
                            <span><i class="fas fa-comment comment_css" style="font-size: 21px"></i></span>
                            <span class="badge badge-danger badge-circle badge-btn custom_messanger_counter">
                                <?php echo e($unseenCounter); ?>

                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if( Gate::check('create product & service') ||  Gate::check('create customer') ||  Gate::check('create vender')||  Gate::check('create proposal')||  Gate::check('create invoice')||  Gate::check('create bill') ||  Gate::check('create goal') ||  Gate::check('create bank account')): ?>
                    <li class="nav-item">
                        <div class="dropdown notification-icon">
                            <button class="dropdown-toggle bookmark_css" type="button" id="dropdownBookmark" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bookmark text-primary"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownBookmark">
                                <?php if(Gate::check('create product & service')): ?>
                                    <a class="dropdown-item" href="#" data-url="<?php echo e(route('productservice.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Product')); ?>"><i class="fas fa-shopping-cart"></i><?php echo e(__('Create New Product')); ?></a>
                                <?php endif; ?>
                                <?php if(Gate::check('create customer')): ?>
                                    <a class="dropdown-item" href="#" data-url="<?php echo e(route('customer.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Customer')); ?>"><i class="fas fa-user"></i><?php echo e(__('Create New Customer')); ?></a>
                                <?php endif; ?>
                                <?php if(Gate::check('create vender')): ?>
                                    <a class="dropdown-item" href="#" data-url="<?php echo e(route('vender.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Vendor')); ?>"><i class="fas fa-sticky-note"></i><?php echo e(__('Create New Vendor')); ?></a>
                                <?php endif; ?>
                                <?php if(Gate::check('create proposal')): ?>
                                    <a class="dropdown-item" href="<?php echo e(route('proposal.create',0)); ?>"><i class="fas fa-file"></i><?php echo e(__('Create New Proposal')); ?></a>
                                <?php endif; ?>
                                <?php if(Gate::check('create invoice')): ?>
                                    <a class="dropdown-item" href="<?php echo e(route('invoice.create',0)); ?>"><i class="fas fa-money-bill-alt"></i><?php echo e(__('Create New Invoice')); ?></a>
                                <?php endif; ?>
                                <?php if(Gate::check('create bill')): ?>
                                    <a class="dropdown-item" href="<?php echo e(route('bill.create',0)); ?>"><i class="fas fa-money-bill-wave-alt"></i><?php echo e(__('Create New Bill')); ?></a>
                                <?php endif; ?>
                                <?php if(Gate::check('create bank account')): ?>
                                    <a class="dropdown-item" href="#" data-url="<?php echo e(route('bank-account.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Account')); ?>"><i class="fas fa-university"></i><?php echo e(__('Create New Account')); ?></a>
                                <?php endif; ?>
                                <?php if(Gate::check('create goal')): ?>
                                    <a class="dropdown-item" href="#" data-url="<?php echo e(route('goal.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create New Goal')); ?>"><i class="fas fa-bullseye"></i><?php echo e(__('Create New Goal')); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ml-lg-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('change.mode')); ?>"><?php echo e((Auth::user()->mode == 'light') ? __('Dark Mode') : __('Light Mode')); ?></a>
                </li>

                <li class="nav-item">
                    <div class="dropdown global-icon" data-toggle="tooltip" data-original-titla="<?php echo e(__('Choose Language')); ?>">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-globe-europe ml-0"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <?php if(\Auth::user()->type=='super admin'): ?>
                                <a class="dropdown-item" href="<?php echo e(route('manage.language',[isset($lang)?$lang:'en'])); ?>"><?php echo e(__('Create & Customize')); ?></a>
                            <?php endif; ?>
                            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a class="dropdown-item <?php if($language == $lang): ?> text-danger <?php endif; ?>" href="<?php echo e(route('change.language',$language)); ?>"><?php echo e(Str::upper($language)); ?></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</nav>
<?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/partials/admin/header.blade.php ENDPATH**/ ?>