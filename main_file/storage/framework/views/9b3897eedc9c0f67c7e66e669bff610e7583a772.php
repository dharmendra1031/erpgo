<?php $__env->startSection('page-title'); ?>
    <?php echo e($lead->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css-page'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/libs/summernote/summernote-bs4.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/libs/dropzonejs/dropzone.css')); ?>">
    <style>
        .nav-tabs .nav-link-tabs.active {
            background: none;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(asset('assets/libs/summernote/summernote-bs4.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/libs/dropzonejs/min/dropzone.min.js')); ?>"></script>
    <script>
        <?php if(Auth::user()->type != 'client'): ?>
            Dropzone.autoDiscover = false;
        myDropzone = new Dropzone("#dropzonewidget", {
            maxFiles: 20,
            maxFilesize: 20,
            parallelUploads: 1,
            filename: false,
            acceptedFiles: ".jpeg,.jpg,.png,.pdf,.doc,.txt",
            url: "<?php echo e(route('leads.file.upload',$lead->id)); ?>",
            success: function (file, response) {
                if (response.is_success) {
                    dropzoneBtn(file, response);
                } else {
                    myDropzone.removeFile(file);
                    show_toastr('Error', response.error, 'error');
                }
            },
            error: function (file, response) {
                myDropzone.removeFile(file);
                if (response.error) {
                    show_toastr('Error', response.error, 'error');
                } else {
                    show_toastr('Error', response, 'error');
                }
            }
        });
        myDropzone.on("sending", function (file, xhr, formData) {
            formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
            formData.append("lead_id", <?php echo e($lead->id); ?>);
        });

        myDropzone2 = new Dropzone("#dropzonewidget2", {
            maxFiles: 20,
            maxFilesize: 20,
            parallelUploads: 1,
            acceptedFiles: ".jpeg,.jpg,.png,.pdf,.doc,.txt",
            url: "<?php echo e(route('leads.file.upload',$lead->id)); ?>",
            success: function (file, response) {
                if (response.is_success) {
                    dropzoneBtn(file, response);
                } else {
                    myDropzone2.removeFile(file);
                    show_toastr('Error', response.error, 'error');
                }
            },
            error: function (file, response) {
                myDropzone2.removeFile(file);
                if (response.error) {
                    show_toastr('Error', response.error, 'error');
                } else {
                    show_toastr('Error', response, 'error');
                }
            }
        });
        myDropzone2.on("sending", function (file, xhr, formData) {
            formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
            formData.append("lead_id", <?php echo e($lead->id); ?>);
        });

        function dropzoneBtn(file, response) {
            var download = document.createElement('a');
            download.setAttribute('href', response.download);
            download.setAttribute('class', "badge badge-pill badge-blue mx-1");
            download.setAttribute('data-toggle', "tooltip");
            download.setAttribute('data-original-title', "<?php echo e(__('Download')); ?>");
            download.innerHTML = "<i class='fas fa-download'></i>";

            var del = document.createElement('a');
            del.setAttribute('href', response.delete);
            del.setAttribute('class', "badge badge-pill badge-danger mx-1");
            del.setAttribute('data-toggle', "tooltip");
            del.setAttribute('data-original-title', "<?php echo e(__('Delete')); ?>");
            del.innerHTML = "<i class='fas fa-trash'></i>";

            del.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopPropagation();
                if (confirm("Are you sure ?")) {
                    var btn = $(this);
                    $.ajax({
                        url: btn.attr('href'),
                        data: {_token: $('meta[name="csrf-token"]').attr('content')},
                        type: 'DELETE',
                        success: function (response) {
                            if (response.is_success) {
                                btn.closest('.dz-image-preview').remove();
                            } else {
                                show_toastr('Error', response.error, 'error');
                            }
                        },
                        error: function (response) {
                            response = response.responseJSON;
                            if (response.is_success) {
                                show_toastr('Error', response.error, 'error');
                            } else {
                                show_toastr('Error', response, 'error');
                            }
                        }
                    })
                }
            });

            var html = document.createElement('div');
            html.appendChild(download);
            <?php if(Auth::user()->type != 'client'): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit lead')): ?>
            html.appendChild(del);
            <?php endif; ?>
            <?php endif; ?>

            file.previewTemplate.appendChild(html);
        }

        <?php $__currentLoopData = $lead->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(file_exists(storage_path('lead_files/'.$file->file_path))): ?>
        // Create the mock file:
        var mockFile = {name: "<?php echo e($file->file_name); ?>", size: <?php echo e(\File::size(storage_path('lead_files/'.$file->file_path))); ?> };
        // Call the default addedfile event handler
        myDropzone.emit("addedfile", mockFile);
        // And optionally show the thumbnail of the file:
        myDropzone.emit("thumbnail", mockFile, "<?php echo e(asset(Storage::url('lead_files/'.$file->file_path))); ?>");
        myDropzone.emit("complete", mockFile);

        dropzoneBtn(mockFile, {download: "<?php echo e(route('leads.file.download',[$lead->id,$file->id])); ?>", delete: "<?php echo e(route('leads.file.delete',[$lead->id,$file->id])); ?>"});

        // Create the mock file:
        var mockFile2 = {name: "<?php echo e($file->file_name); ?>", size: <?php echo e(\File::size(storage_path('lead_files/'.$file->file_path))); ?> };
        // Call the default addedfile event handler
        myDropzone2.emit("addedfile", mockFile2);
        // And optionally show the thumbnail of the file:
        myDropzone2.emit("thumbnail", mockFile2, "<?php echo e(asset(Storage::url('lead_files/'.$file->file_path))); ?>");
        myDropzone2.emit("complete", mockFile2);

        dropzoneBtn(mockFile2, {download: "<?php echo e(route('leads.file.download',[$lead->id,$file->id])); ?>", delete: "<?php echo e(route('leads.file.delete',[$lead->id,$file->id])); ?>"});
        <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit lead')): ?>
        $('.summernote-simple').on('summernote.blur', function () {
            $.ajax({
                url: "<?php echo e(route('leads.note.store',$lead->id)); ?>",
                data: {_token: $('meta[name="csrf-token"]').attr('content'), notes: $(this).val()},
                type: 'POST',
                success: function (response) {
                    if (response.is_success) {
                        // show_toastr('Success', response.success,'success');
                    } else {
                        show_toastr('Error', response.error, 'error');
                    }
                },
                error: function (response) {
                    response = response.responseJSON;
                    if (response.is_success) {
                        show_toastr('Error', response.error, 'error');
                    } else {
                        show_toastr('Error', response, 'error');
                    }
                }
            })
        });
        <?php else: ?>
        $('.summernote-simple').summernote('disable');
        <?php endif; ?>

        $(document).ready(function () {
            var tab = 'general';
                <?php if($tab = Session::get('status')): ?>
            var tab = '<?php echo e($tab); ?>';
            <?php endif; ?>
            $("#myTab2 .nav-link-text[href='#" + tab + "']").trigger("click");
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('action-button'); ?>
    <div class="all-button-box row d-flex justify-content-end">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit lead')): ?>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="#" data-url="<?php echo e(URL::to('leads/'.$lead->id.'/labels')); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Labels')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto"><i class="fas fa-tags"></i> <?php echo e(__('Label')); ?></a>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="#" data-url="<?php echo e(URL::to('leads/'.$lead->id.'/edit')); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Edit Lead')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto"><i class="fas fa-pencil-alt"></i> <?php echo e(__('Edit')); ?></a>
            </div>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('convert lead to deal')): ?>
            <?php if(!empty($deal)): ?>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-6">
                    <a href="<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('View Deal')): ?> <?php if($deal->is_active): ?> <?php echo e(route('deals.show',$deal->id)); ?> <?php else: ?> # <?php endif; ?> <?php else: ?> # <?php endif; ?>" class="btn btn-xs btn-white btn-icon-only width-auto"><i class="fas fa-exchange-alt"></i> <?php echo e(__('Already Converted To Deal')); ?></a>
                </div>
            <?php else: ?>
                <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                    <a href="#" data-url="<?php echo e(URL::to('leads/'.$lead->id.'/show_convert')); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Convert ['.$lead->subject.'] To Deal')); ?>" class="btn btn-xs btn-white btn-icon-only width-auto"><i class="fas fa-exchange-alt"></i> <?php echo e(__('Convert To Deal')); ?></a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12 mb-3">
            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                <li>
                    <a class="nav-link-text" data-toggle="tab" href="#general" role="tab" aria-controls="home" aria-selected="true"><?php echo e(__('General')); ?></a>
                </li>
                <?php if(Auth::user()->type != 'client'): ?>
                    <li>
                        <a class="nav-link-text" data-toggle="tab" href="#products" role="tab" aria-controls="contact" aria-selected="false"><?php echo e(__('Products')); ?></a>
                    </li>
                <?php endif; ?>
                <?php if(Auth::user()->type != 'client'): ?>
                    <li>
                        <a class="nav-link-text" data-toggle="tab" href="#sources" role="tab" aria-controls="contact" aria-selected="false"><?php echo e(__('Sources')); ?></a>
                    </li>
                <?php endif; ?>
                <?php if(Auth::user()->type != 'client'): ?>
                    <li>
                        <a class="nav-link-text" data-toggle="tab" href="#files" role="tab" aria-controls="contact" aria-selected="false"><?php echo e(__('Files')); ?></a>
                    </li>
                <?php endif; ?>
                <li>
                    <a class="nav-link-text" data-toggle="tab" href="#discussion" role="tab" aria-controls="contact" aria-selected="false"><?php echo e(__('Discussion')); ?></a>
                </li>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit lead')): ?>
                    <li>
                        <a class="nav-link-text" data-toggle="tab" href="#notes" role="tab" aria-controls="contact" aria-selected="false"><?php echo e(__('Notes')); ?></a>
                    </li>
                <?php endif; ?>
                <?php if(Auth::user()->type != 'client'): ?>
                    <li>
                        <a class="nav-link-text" data-toggle="tab" href="#calls" role="tab" aria-controls="contact" aria-selected="false"><?php echo e(__('Calls')); ?></a>
                    </li>
                <?php endif; ?>
                <?php if(Auth::user()->type != 'client'): ?>
                    <li>
                        <a class="nav-link-text" data-toggle="tab" href="#emails" role="tab" aria-controls="contact" aria-selected="false"><?php echo e(__('Emails')); ?></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="col-12">
            <div class="tab-content tab-bordered">
                <div class="tab-pane fade show active" id="general" role="tabpanel">
                    <div class="card py-2 text-sm">
                      <div class="row">


                          <div class="col-8">
                            <ul class="nav nav-pills p-1">
                            <li class="nav-item">
                                <a class="nav-link text-success" href="#"><?php echo e(__('Pipeline')); ?> <span class="badge badge-pill badge-success"><?php echo e($lead->pipeline->name); ?></span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-warning" href="#"><?php echo e(__('Stage')); ?> <span class="badge badge-pill badge-warning"><?php echo e($lead->stage->name); ?></span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="#"><?php echo e(__('Created')); ?> <span class="badge badge-pill badge-secondary"><?php echo e(\Auth::user()->dateFormat($lead->created_at)); ?></span></a>
                            </li>
                            <li class="nav-item w-10">
                                <div class="progress-wrapper pt-1">
                                    <span class="progress-tooltip" style="left: <?php echo e($precentage); ?>%;"><?php echo e($precentage); ?>%</span>
                                    <div class="progress" style="height: 3px;">
                                        <div class="progress-bar" role="progressbar" style="width: <?php echo e($precentage); ?>%;" aria-valuenow="<?php echo e($precentage); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </li>
                          </ul>
                          </div>
                          <?php ($labels = $lead->labels()); ?>
                          <?php if($labels): ?>
                          <div class="col-4">
                            <ul class="nav nav-pills p-1 float-right m-2">
                              <li class="nav-item">
                                <?php $__currentLoopData = $labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge badge-pill badge-<?php echo e($label->color); ?>"><?php echo e($label->name); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </li>
                            </ul>
                          </div>
                          <?php endif; ?>
                          </div>
                    </div>

                    <?php
                    $products = $lead->products();
                    $sources = $lead->sources();
                    $calls = $lead->calls;
                    $emails = $lead->emails;
                    ?>
                    <div class="row">
                        <div class="col-4">
                            <div class="card card-box">
                                <div class="left-card">
                                    <div class="icon-box"><i class="fas fa-dolly"></i></div>
                                    <h4 class="pt-3"><?php echo e(__('Product')); ?></h4>
                                </div>
                                <div class="number-icon"><?php echo e(count($products)); ?></div>
                                <img src="<?php echo e(asset('assets/img/dot-icon.png')); ?>" class="dotted-icon">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card card-box">
                                <div class="left-card">
                                    <div class="icon-box yellow-bg"><i class="fas fa-eye"></i></div>
                                    <h4 class="pt-3"><?php echo e(__('Source')); ?></h4>
                                </div>
                                <div class="number-icon"><?php echo e(count($sources)); ?></div>
                                <img src="<?php echo e(asset('assets/img/dot-icon.png')); ?>" class="dotted-icon">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card card-box">
                                <div class="left-card">
                                    <div class="icon-box red-bg"><i class="fas fa-file-alt"></i></div>
                                    <h4 class="pt-3"><?php echo e(__('Files')); ?></h4>
                                </div>
                                <div class="number-icon"><?php echo e(count($lead->files)); ?></div>
                                <img src="<?php echo e(asset('assets/img/dot-icon.png')); ?>" class="dotted-icon">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php if(Auth::user()->type != 'client'): ?>
                            <div class="col-xl-4 col-lg-4 col-sm-6 col-md-6">
                                <div class="justify-content-between align-items-center d-flex">
                                    <h4 class="h4 font-weight-400 float-left"><?php echo e(__('Users')); ?></h4>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit lead')): ?>
                                        <a href="#" class="btn btn-sm btn-white float-right add-small" data-url="<?php echo e(route('leads.users.edit',$lead->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Add User')); ?>">
                                            <i class="fas fa-plus"></i> <?php echo e(__('Add')); ?>

                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="card bg-none height-450 top-5-scroll">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <tbody class="list">
                                            <?php $__currentLoopData = $lead->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <img <?php if($user->avatar): ?> src="<?php echo e(asset('/storage/uploads/avatar/'.$user->avatar)); ?>" <?php else: ?> src="<?php echo e(asset('assets/img/avatar/avatar-1.png')); ?>" <?php endif; ?> width="30" class="avatar-sm rounded-circle">
                                                    </td>
                                                    <td>
                                                        <span class="number-id"><?php echo e($user->name); ?></span>
                                                    </td>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit lead')): ?>
                                                        <td>
                                                            <?php if($lead->created_by == \Auth::user()->id): ?>
                                                                <a href="#" class="delete-icon float-right" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($user->id); ?>').submit();">
                                                                    <i class="fas fa-trash"></i>
                                                                </a>
                                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['leads.users.destroy',$lead->id,$user->id],'id'=>'delete-form-'.$user->id]); ?>

                                                                <?php echo Form::close(); ?>

                                                            <?php endif; ?>
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(Auth::user()->type != 'client'): ?>
                            <div class="col-xl-4 col-lg-4 col-sm-6 col-md-6">
                                <div class="justify-content-between align-items-center d-flex">
                                    <h4 class="h4 font-weight-400 float-left"><?php echo e(__('Products')); ?></h4>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit lead')): ?>
                                        <a href="#" class="btn btn-sm btn-white float-right add-small" data-url="<?php echo e(route('leads.products.edit',$lead->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Add Products')); ?>">
                                            <i class="fas fa-plus"></i> <?php echo e(__('Add')); ?>

                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="card bg-none height-450 top-5-scroll">
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <tbody class="list">
                                            <?php ($products = $lead->products()); ?>
                                            <?php if($products): ?>
                                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td>
                                                            <img width="30" <?php if($product->avatar): ?> src="<?php echo e(asset('/storage/product/'.$product->avatar)); ?>" <?php else: ?> src="<?php echo e(asset('assets/img/news/img01.jpg')); ?>" <?php endif; ?>>
                                                        </td>
                                                        <td>
                                                            <span class="number-id"><?php echo e($product->name); ?> </span> (<span class="text-muted"><?php echo e(\Auth::user()->priceFormat($product->sale_price)); ?></span>)
                                                        </td>
                                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit lead')): ?>
                                                            <td>
                                                                <a href="#" class="delete-icon float-right" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('product-delete-form-<?php echo e($product->id); ?>').submit();">
                                                                    <i class="fas fa-trash"></i>
                                                                </a>
                                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['leads.products.destroy',$lead->id,$product->id],'id'=>'product-delete-form-'.$product->id]); ?>

                                                                <?php echo Form::close(); ?>

                                                            </td>
                                                        <?php endif; ?>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td><?php echo e(__('No Product Found.!')); ?></td>
                                                </tr>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(Auth::user()->type != 'client'): ?>
                            <div class="col-lg-4">
                                <div class="justify-content-between align-items-center d-flex">
                                    <h4 class="h4 font-weight-400 float-left"><?php echo e(__('Files')); ?></h4>
                                </div>
                                <div class="card height-450">
                                    <div class="card-body bg-none top-5-scroll">
                                        <div class="col-md-12 dropzone browse-file" id="dropzonewidget"></div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit lead')): ?>
                            <div class="col-6">
                                <div class="justify-content-between align-items-center d-flex">
                                    <h4 class="h4 font-weight-400 float-left"><?php echo e(__('Notes')); ?></h4>
                                </div>
                                <div class="card">
                                    <div class="card-body pb-0">
                                        <textarea class="summernote-simple"><?php echo $lead->notes; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(Auth::user()->type != 'client'): ?>
                            <div class="col-6">
                              <div class="justify-content-between align-items-center d-flex">
                                  <h4 class="h4 font-weight-400 float-left"><?php echo e(__('Activity')); ?></h4>
                              </div>
                              <div class="card">
                                  <div class="card-body">
                                      <div class="scrollbar-inner">
                                          <div class="mh-500 min-h-500">
                                              <div class="timeline timeline-one-side" data-timeline-content="axis" data-timeline-axis-style="dashed">
                                                <?php if(!$lead->activities->isEmpty()): ?>
                                                  <?php $__currentLoopData = $lead->activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                      <div class="timeline-block">
                                                          <span class="timeline-step timeline-step-sm bg-dark border-dark text-white">
                                                              <i class="fas fas <?php echo e($activity->logIcon()); ?>"></i>
                                                          </span>
                                                          <div class="timeline-content">
                                                              <span class="text-dark text-sm"><?php echo e(__($activity->log_type)); ?></span>
                                                              <a class="d-block h6 text-sm mb-0"><?php echo $activity->getLeadRemark(); ?></a>
                                                              <small><i class="fas fa-clock mr-1"></i><?php echo e($activity->created_at->diffForHumans()); ?></small>
                                                          </div>
                                                      </div>
                                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                  No activity found yet.
                                                <?php endif; ?>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if(Auth::user()->type != 'client'): ?>
                    <div class="tab-pane fade show" id="products" role="tabpanel">
                        <div class="row pt-2">
                            <div class="col-12">
                                <div class="justify-content-between align-items-center d-flex">
                                    <h4 class="h4 font-weight-400 float-left"><?php echo e(__('Products')); ?></h4>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit lead')): ?>
                                        <a href="#" class="btn btn-sm btn-white float-right add-small" data-url="<?php echo e(route('leads.products.edit',$lead->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Add Products')); ?>"><i class="fas fa-plus"></i> <?php echo e(__('Add')); ?></a>
                                    <?php endif; ?>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table align-items-center mb-0">
                                                <tbody class="list">
                                                <?php if($products): ?>
                                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td>
                                                                <img width="50" <?php if($product->avatar): ?> src="<?php echo e(asset('/storage/product/'.$product->avatar)); ?>" <?php else: ?> src="<?php echo e(asset('assets/img/news/img01.jpg')); ?>" <?php endif; ?>>
                                                            </td>
                                                            <td>
                                                                <span class="number-id"><?php echo e($product->name); ?> </span> (<span class="text-muted"><?php echo e(\Auth::user()->priceFormat($product->sale_price)); ?></span>)
                                                            </td>
                                                            <td>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit lead')): ?>
                                                                    <a href="#" class="delete-icon float-right" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('product-delete-form-<?php echo e($product->id); ?>').submit();">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['leads.products.destroy',$lead->id,$product->id],'id'=>'product-delete-form-'.$product->id]); ?>

                                                                    <?php echo Form::close(); ?>

                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                <div class="text-center">
                                                  No Product Found.!
                                                </div>
                                                <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(Auth::user()->type != 'client'): ?>
                    <div class="tab-pane fade show" id="sources" role="tabpanel">
                        <div class="row pt-2">
                            <div class="col-12">
                                <div class="justify-content-between align-items-center d-flex">
                                    <h4 class="h4 font-weight-400 float-left"><?php echo e(__('Sources')); ?></h4>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit lead')): ?>
                                        <a href="#" class="btn btn-sm btn-white float-right add-small" data-url="<?php echo e(route('leads.sources.edit',$lead->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Sources')); ?>"><i class="fas fa-pen"></i> <?php echo e(__('Edit')); ?></a>
                                    <?php endif; ?>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table align-items-center mb-0">
                                                <tbody class="list">
                                                <?php if($sources): ?>
                                                    <?php $__currentLoopData = $sources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td>
                                                                <span class="text-dark"><?php echo e($source->name); ?></span>
                                                            </td>
                                                            <td>
                                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit lead')): ?>
                                                                    <a href="#" class="delete-icon float-right" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('source-delete-form-<?php echo e($source->id); ?>').submit();">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['leads.sources.destroy',$lead->id,$source->id],'id'=>'source-delete-form-'.$source->id]); ?>

                                                                    <?php echo Form::close(); ?>

                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                <div class="text-center">
                                                  No Source Added.!
                                                </div>
                                                <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(Auth::user()->type != 'client'): ?>
                    <div class="tab-pane fade show" id="files" role="tabpanel">
                        <div class="row pt-2">
                            <div class="col-12">
                                <div class="justify-content-between align-items-center d-flex">
                                    <h4 class="h4 font-weight-400 float-left"><?php echo e(__('Files')); ?></h4>
                                </div>
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="col-md-12 dropzone top-5-scroll browse-file" id="dropzonewidget2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="tab-pane fade show" id="discussion" role="tabpanel">
                    <div class="row pt-2">
                        <div class="col-12">
                            <div class="justify-content-between align-items-center d-flex">
                                <h4 class="h4 font-weight-400 float-left"><?php echo e(__('Discussion')); ?></h4>
                                <a href="#" class="btn btn-sm btn-white float-right add-small" data-url="<?php echo e(route('leads.discussions.create',$lead->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Add Message')); ?>"><i class="fas fa-plus"></i> <?php echo e(__('Add Message')); ?></a>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <ul class="list-unstyled list-unstyled-border">
                                      <?php if(!$lead->discussions->isEmpty()): ?>
                                        <?php $__currentLoopData = $lead->discussions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discussion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="media mb-3">
                                                <img alt="image" class="mr-3 rounded-circle" width="50" height="50" src="<?php if($discussion->user->avatar): ?> <?php echo e(asset('/storage/uploads/avatar/'.$discussion->user->avatar)); ?> <?php else: ?> <?php echo e(asset('assets/img/avatar/avatar-1.png')); ?> <?php endif; ?>">
                                                <div class="media-body">
                                                    <div class="mt-0 mb-1 font-weight-bold text-sm"><?php echo e($discussion->user->name); ?> <small><?php echo e($discussion->user->type); ?></small> <small class="float-right"><?php echo e($discussion->created_at->diffForHumans()); ?></small></div>
                                                    <div class="text-xs"> <?php echo e($discussion->comment); ?></div>
                                                </div>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      <?php else: ?>
                                      <div class="text-center">
                                        No Discussion Available.!
                                      </div>
                                      <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade show" id="notes" role="tabpanel">
                    <div class="row pt-2">
                        <div class="col-12">
                            <div class="justify-content-between align-items-center d-flex">
                                <h4 class="h4 font-weight-400 float-left"><?php echo e(__('Notes')); ?></h4>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <textarea class="summernote-simple"><?php echo $lead->notes; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if(Auth::user()->type != 'client'): ?>
                    <div class="tab-pane fade show" id="calls" role="tabpanel">
                        <div class="row pt-2">
                            <div class="col-12">
                                <div class="justify-content-between align-items-center d-flex">
                                    <h4 class="h4 font-weight-400 float-left"><?php echo e(__('Calls')); ?></h4>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create lead call')): ?>
                                        <a href="#" class="btn btn-sm btn-white float-right add-small" data-url="<?php echo e(route('leads.calls.create',$lead->id)); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Add Call')); ?>"><i class="fas fa-plus"></i> <?php echo e(__('Add Call')); ?></a>
                                    <?php endif; ?>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped mb-0 dataTable">
                                                <thead>
                                                <tr>
                                                    <th width=""><?php echo e(__('Subject')); ?></th>
                                                    <th><?php echo e(__('Call Type')); ?></th>
                                                    <th><?php echo e(__('Duration')); ?></th>
                                                    <th><?php echo e(__('User')); ?></th>
                                                    <th width="14%"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $__currentLoopData = $calls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $call): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($call->subject); ?></td>
                                                        <td><?php echo e(ucfirst($call->call_type)); ?></td>
                                                        <td><?php echo e($call->duration); ?></td>
                                                        <td><?php echo e(isset($call->getLeadCallUser) ? $call->getLeadCallUser->name : '-'); ?></td>
                                                        <td>
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit lead call')): ?>
                                                                <a href="#" data-url="<?php echo e(URL::to('leads/'.$lead->id.'/call/'.$call->id.'/edit')); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Edit Lead Call')); ?>" class="edit-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Edit')); ?>"><i class="fas fa-pencil-alt"></i></a>
                                                            <?php endif; ?>
                                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete lead call')): ?>
                                                                <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="<?php echo e(__('Delete')); ?>" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($call->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['leads.calls.destroy',$lead->id ,$call->id],'id'=>'delete-form-'.$call->id]); ?>

                                                                <?php echo Form::close(); ?>

                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(Auth::user()->type != 'client'): ?>
                    <div class="tab-pane fade show" id="emails" role="tabpanel">
                        <div class="row pt-2">
                            <div class="col-12">
                                <div class="justify-content-between align-items-center d-flex">
                                    <h4 class="h4 font-weight-400 float-left"><?php echo e(__('Emails')); ?></h4>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create lead email')): ?>
                                        <a href="#" class="btn btn-sm btn-white float-right add-small" data-url="<?php echo e(route('leads.emails.create',$lead->id)); ?>" data-size="lg" data-ajax-popup="true" data-title="<?php echo e(__('Add Email')); ?>"><i class="fas fa-plus"></i> <?php echo e(__('Add Email')); ?></a>
                                    <?php endif; ?>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <ul class="list-unstyled list-unstyled-border">
                                          <?php if(!$emails->isEmpty()): ?>
                                            <?php $__currentLoopData = $emails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $email): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="media mb-3">
                                                    <img alt="image" class="mr-3 rounded-circle" width="50" height="50" src="<?php echo e(asset('assets/img/avatar/avatar-1.png')); ?>">
                                                    <div class="media-body">
                                                        <div class="mt-0 mb-1 font-weight-bold text-sm"><?php echo e($email->subject); ?> <small class="float-right"><?php echo e($email->created_at->diffForHumans()); ?></small></div>
                                                        <div class="text-xs"> <?php echo e($email->to); ?></div>
                                                    </div>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          <?php else: ?>
                                          <div class="text-center">
                                            No Emails Available.!
                                          </div>
                                          <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/leads/show.blade.php ENDPATH**/ ?>