
<?php if($get == 'saved'): ?>
    <table class="messenger-list-item m-li-divider <?php if('user_'.Auth::user()->id == $id && $id != "0"): ?> m-list-active <?php endif; ?>">
        <tr data-action="0">
            
            <td>
            <div class="avatar av-m" style="background-color: #d9efff; text-align: center;">
                <span class="far fa-bookmark" style="font-size: 22px; color: #68a5ff;"></span>
            </div>
            </td>
            
            <td>
                <p data-id="<?php echo e('user_'.Auth::user()->id); ?>">Saved Messages <span>You</span></p>
                <span>Save messages secretly</span>
            </td>
        </tr>
    </table>
<?php endif; ?>


<?php if($get == 'users'): ?>
<table class="messenger-list-item <?php if($user->id == $id && $id != "0"): ?> m-list-active <?php endif; ?>" data-contact="<?php echo e($user->id); ?>">
    <tr data-action="0">
        
        <td style="position: relative">
            <?php if($user->active_status): ?>
                <span class="activeStatus"></span>
            <?php endif; ?>
        <?php if(!empty($user->avatar)): ?>
        <div class="avatar av-m"
        style="background-image: url('<?php echo e(asset('/storage/'.config('chatify.user_avatar.folder').'/'.$user->avatar)); ?>');">
        </div>
         <?php else: ?>
         <div class="avatar av-m"
                         style="background-image: url('<?php echo e(asset('/storage/'.config('chatify.user_avatar.folder').'/avatar.png')); ?>');">
                    </div>
                <?php endif; ?>
        </td>
        
        <td>
        <p data-id="<?php echo e($type.'_'.$user->id); ?>">
            <?php echo e(strlen($user->name) > 12 ? trim(substr($user->name,0,12)).'..' : $user->name); ?>

            <span><?php echo e($lastMessage->created_at->diffForHumans()); ?></span></p>
        <span>
            
            <?php echo $lastMessage->from_id == Auth::user()->id
                ? '<span class="lastMessageIndicator">You :</span>'
                : ''; ?>

            
            <?php if($lastMessage->attachment == null): ?>
            <?php echo e(strlen($lastMessage->body) > 30
                ? trim(substr($lastMessage->body, 0, 30)).'..'
                : $lastMessage->body); ?>

            <?php else: ?>
            <span class="fas fa-file"></span> Attachment
            <?php endif; ?>
        </span>
        
            <?php echo $unseenCounter > 0 ? "<b>".$unseenCounter."</b>" : ''; ?>

        </td>

    </tr>
</table>
<?php endif; ?>


<?php if($get == 'search_item'): ?>
<table class="messenger-list-item" data-contact="<?php echo e($user->id); ?>">
    <tr data-action="0">
        
       <td style="position: relative">
             <?php if($user->active_status): ?>
                    <span class="activeStatus"></span>
                <?php endif; ?>

          <?php if(!empty($user->avatar)): ?>
        <div class="avatar av-m"
        style="background-image: url('<?php echo e(asset('/storage/'.config('chatify.user_avatar.folder').'/'.$user->avatar)); ?>');">
        </div>
        <?php else: ?>
         <div class="avatar av-m"
                         style="background-image: url('<?php echo e(asset('/storage/'.config('chatify.user_avatar.folder').'/avatar.png')); ?>');">
                    </div>
                <?php endif; ?>
        </td>
        
        <td>
        <p data-id="<?php echo e($type.'_'.$user->id); ?>">
            <?php echo e(strlen($user->name) > 12 ? trim(substr($user->name,0,12)).'..' : $user->name); ?>

        </td>

    </tr>
</table>
<?php endif; ?>




<?php if($get == 'all_members'): ?>
    <table class="messenger-list-item" data-contact="<?php echo e($user->id); ?>">
        <tr data-action="0">
            
            <td style="position: relative">
                <?php if($user->active_status): ?>
                    <span class="activeStatus"></span>
                <?php endif; ?>
                <?php if(!empty($user->avatar)): ?>
                    <div class="avatar av-m"
                         style="background-image: url('<?php echo e(asset('/storage/'.config('chatify.user_avatar.folder').'/'.$user->avatar)); ?>');">
                    </div>
                <?php else: ?>
                    <div class="avatar av-m"
                         style="background-image: url('<?php echo e(asset('/storage/'.config('chatify.user_avatar.folder').'/avatar.png')); ?>');">
                    </div>
                <?php endif; ?>
            </td>
            
            <td>
                <p data-id="<?php echo e($type.'_'.$user->id); ?>">
                <?php echo e(strlen($user->name) > 12 ? trim(substr($user->name,0,12)).'..' : $user->name); ?>

            </td>

        </tr>
    </table>
<?php endif; ?>








<?php if($get == 'sharedPhoto'): ?>
<div class="shared-photo chat-image" style="background-image: url('<?php echo e($image); ?>')"></div>
<?php endif; ?>


<?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/vendor/Chatify/layouts/listItem.blade.php ENDPATH**/ ?>