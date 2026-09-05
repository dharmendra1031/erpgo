<?php $__env->startPush('css-page'); ?>
<?php echo $__env->make('Chatify::layouts.headLinks', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Chats')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="messenger">

    
    <div class="messenger-listView">
        
        <div class="m-header">
            <nav>
               <nav class="m-header-right">
                    <a href="#" class="listView-x"><i class="fas fa-times"></i></a>
                </nav>
            </nav>
            
            <input type="text" class="messenger-search" placeholder="Search" />
            
            <div class="messenger-listView-tabs">
                    <a href="#" <?php if($route == 'user'): ?> class="active-tab" <?php endif; ?> data-view="users">
                         <span class="fas fa-clock" title="<?php echo e(__('Recent')); ?>"></span>
                     </a>
                    <a href="#" <?php if($route == 'group'): ?> class="active-tab" <?php endif; ?> data-view="groups">
                        <span class="fas fa-users" title="<?php echo e(__('Members')); ?>"></span></a>
                </div>
        </div>
        
        <div class="m-body">
           
           
           <div class="<?php if($route == 'user'): ?> show <?php endif; ?> messenger-tab app-scroll" data-view="users">

               
               <div class="favorites-section">
                <p class="messenger-title">Favorites</p>
                <div class="messenger-favorites app-scroll-thin"></div>
               </div>

               
               <?php echo view('Chatify::layouts.listItem', ['get' => 'saved','id' => $id])->render(); ?>


               
               <div class="listOfContacts" style="width: 100%;height: calc(100% - 200px);position: relative;"></div>


           </div>

           

             <div class="all_members <?php if($route == 'group'): ?> show <?php endif; ?> messenger-tab app-scroll" data-view="groups">
                
                <p style="text-align: center;color:grey;"><?php echo e(__('Soon will be available')); ?></p>
            </div>
             
           <div class=" messenger-tab app-scroll" data-view="search">
                
                <p class="messenger-title">Search</p>
                <div class="search-records">
                    <p class="message-hint center-el"><span>Type to search..</span></p>
                </div>
             </div>
        </div>
    </div>

    
    <div class="messenger-messagingView">
        
        <div class="m-header m-header-messaging">
            <nav>
                
                <div style="display: inline-flex;">
                    <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i></a>
                    <?php if(!empty(Auth::user()->avatar)): ?>
                    <div class="avatar av-s header-avatar" style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px; background-image: url('<?php echo e(asset('/storage/avatars/'.Auth::user()->avatar)); ?>');">
                    </div>
                     <?php else: ?>
                     <div class="avatar av-s header-avatar" style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px;background-image: url('<?php echo e(asset('/storage/avatars/avatar.png')); ?>');"></div>
                     <?php endif; ?>
                    <a href="#" class="user-name"><?php echo e(config('chatify.name')); ?></a>
                </div>
                
                <nav class="m-header-right">
                    <a href="#" class="add-to-favorite"><i class="fas fa-star"></i></a>
                    <a href="/"><i class="fas fa-home"></i></a>
                    <a href="#" class="show-infoSide"><i class="fas fa-info-circle"></i></a>
                </nav>
            </nav>
        </div>
        
        <div class="internet-connection">
            <span class="ic-connected">Connected</span>
            <span class="ic-connecting">Connecting...</span>
            <span class="ic-noInternet">No internet access</span>
        </div>
        
        <div class="m-body app-scroll">
            <div class="messages">
                <p class="message-hint" style="margin-top: calc(30% - 126.2px);"><span>Please select a chat to start messaging</span></p>
            </div>
            
            <div class="typing-indicator">
                <div class="message-card typing">
                    <p>
                        <span class="typing-dots">
                            <span class="dot dot-1"></span>
                            <span class="dot dot-2"></span>
                            <span class="dot dot-3"></span>
                        </span>
                    </p>
                </div>
            </div>
            
            <?php echo $__env->make('Chatify::layouts.sendForm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
    
    <div class="messenger-infoView app-scroll text-center1">
        
        <nav>
            <a href="#"><i class="fas fa-times"></i></a>
        </nav>
        <?php echo view('Chatify::layouts.info')->render(); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
<?php echo $__env->make('Chatify::layouts.modals', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('Chatify::layouts.footerLinks', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/vendor/Chatify/pages/app.blade.php ENDPATH**/ ?>