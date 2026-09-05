<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(asset('js/jquery-ui.min.js')); ?>"></script>
    <?php if(\Auth::user()->type=='company'): ?>
        <script>
            $(function () {
                $(".sortable").sortable();
                $(".sortable").disableSelection();
                $(".sortable").sortable({
                    stop: function () {
                        var order = [];
                        $(this).find('li').each(function (index, data) {
                            order[index] = $(data).attr('data-id');
                        });

                        $.ajax({
                            url: "<?php echo e(route('bugstatus.order')); ?>",
                            data: {order: order, _token: $('meta[name="csrf-token"]').attr('content')},
                            type: 'POST',
                            success: function (data) {
                            },
                            error: function (data) {
                                data = data.responseJSON;
                                toastr('Error', data.error, 'error')
                            }
                        })
                    }
                });
            });
        </script>
    <?php endif; ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Project Bug Status')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-button'); ?>
<div class="all-button-box row d-flex justify-content-end">
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create bug status')): ?>
        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
            <a href="#" class="btn btn-xs btn-white btn-icon-only width-auto" data-url="<?php echo e(route('bugstatus.create')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Create Bug Status')); ?>">
              <i class="fas fa-plus"></i><?php echo e(__(' Create')); ?></a>
        </div>
<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <div class="tab-content tab-bordered">
                <div class="tab-pane fade show active" role="tabpanel">
                    <ul class="list-group sortable">
                        <?php $__currentLoopData = $bugStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bug): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item" data-id="<?php echo e($bug->id); ?>">
                                <?php echo e($bug->title); ?>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit bug status')): ?>
                                    <span class="float-right">
                                      <a href="#" data-url="<?php echo e(URL::to('bugstatus/'.$bug->id.'/edit')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Bug Status')); ?>" class="edit-icon">
                                          <i class="fas fa-pencil-alt"></i>
                                      </a>
                                         <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete bug status')): ?>
                                            <a href="#!" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?" data-confirm-yes="document.getElementById('delete-form-<?php echo e($bug->id); ?>').submit();">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                            <?php echo Form::open(['method' => 'DELETE', 'route' => ['bugstatus.destroy', $bug->id],'id'=>'delete-form-'.$bug->id]); ?>

                                            <?php echo Form::close(); ?>

                                        </span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
            <p class="text-muted mt-4"><strong><?php echo e(__('Note')); ?> : </strong><?php echo e(__('You can easily change order of bug status using drag & drop.')); ?></p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/bugstatus/index.blade.php ENDPATH**/ ?>