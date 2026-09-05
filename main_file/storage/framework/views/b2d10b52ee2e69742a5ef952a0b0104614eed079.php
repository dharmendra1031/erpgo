<div class="card card-box">
<?php echo e(Form::open(array('url'=>'roles','method'=>'post'))); ?>

  <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                <?php echo e(Form::label('name',__('Name'),['class'=>'form-control-label'])); ?>

                <?php echo e(Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Role Name')))); ?>

                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <small class="invalid-name" role="alert">
                    <strong class="text-danger"><?php echo e($message); ?></strong>
                </small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12">
            <ul class="nav nav-tabs my-3">
              <li class="nav-item">
                <a class="active" data-toggle="tab" href="#staff" role="tab" aria-controls="home" aria-selected="true"><?php echo e(__('Staff')); ?></a>
              </li>
              <li class="nav-item">
                <a class="" data-toggle="tab" href="#crm" role="tab" aria-controls="home" aria-selected="true"><?php echo e(__('CRM')); ?></a>
              </li>
              <li class="nav-item">
                <a class="" data-toggle="tab" href="#project" role="tab" aria-controls="home" aria-selected="true"><?php echo e(__('Project')); ?></a>
              </li>
              <li class="nav-item">
                <a class="" data-toggle="tab" href="#hrmpermission" role="tab" aria-controls="home" aria-selected="true"><?php echo e(__('HRM')); ?></a>
              </li>
              <li class="nav-item">
                <a class="" data-toggle="tab" href="#account" role="tab" aria-controls="home" aria-selected="true"><?php echo e(__('Account')); ?></a>
              </li>
            </ul>
        </div>

        <div class="col-md-12">
            <div class="">
                <div class="">
                    <div class="tab-content tab-bordered">
                        <div class="tab-pane fade show  active " id="staff" role="tabpanel">
                          <?php
                              $modules=['user','role','client','product & service','constant unit','constant tax','constant category','company settings'];
                             if(\Auth::user()->type == 'company'){
                               /*  $modules[] = 'language';*/
                                 $modules[] = 'permission';
                             }
                          ?>
                          <div class="col-md-12">
                              <div class="form-group">
                                  <?php if(!empty($permissions)): ?>
                                      <h6 class="my-3"><?php echo e(__('Assign General Permission to Roles')); ?></h6>
                                      <table class="table table-striped mb-0" id="dataTable-1">
                                          <thead>
                                          <tr>
                                              <th>
                                                  <input type="checkbox" class="align-middle custom_align_middle" name="staff_checkall"  id="staff_checkall" ><?php echo e(__('Select All')); ?>

                                              </th>
                                              <th><?php echo e(__('Module')); ?> </th>
                                              <th><?php echo e(__('Permissions')); ?> </th>
                                          </tr>
                                          </thead>
                                          <tbody>

                                          <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <tr>
                                                  <td><input type="checkbox" class="align-middle ischeck staff_checkall"  data-id="<?php echo e(str_replace(' ', '', str_replace('&', '', $module))); ?>" ></td>
                                                  <td><label class="ischeck staff_checkall" data-id="<?php echo e(str_replace(' ', '', str_replace('&', '', $module))); ?>"><?php echo e(ucfirst($module)); ?></label></td>
                                                  <td>
                                                      <div class="row ">
                                                        <?php if(in_array('view '.$module,(array) $permissions)): ?>
                                                            <?php if($key = array_search('view '.$module,$permissions)): ?>
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '',  str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                    <?php echo e(Form::label('permission'.$key,'View',['class'=>'custom-control-label'])); ?><br>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                        <?php if(in_array('add '.$module,(array) $permissions)): ?>
                                                            <?php if($key = array_search('add '.$module,$permissions)): ?>
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '', str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                    <?php echo e(Form::label('permission'.$key,'Add',['class'=>'custom-control-label'])); ?><br>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                        <?php if(in_array('move '.$module,(array) $permissions)): ?>
                                                            <?php if($key = array_search('move '.$module,$permissions)): ?>
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '', str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                    <?php echo e(Form::label('permission'.$key,'Move',['class'=>'custom-control-label'])); ?><br>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                          <?php if(in_array('manage '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('manage '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '', str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Manage',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('create '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('create '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '', str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Create',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('edit '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('edit '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '', str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Edit',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('delete '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('delete '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '', str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Delete',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('show '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('show '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '', str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Show',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>


                                                          <?php if(in_array('send '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('send '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '', str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Send',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>

                                                          <?php if(in_array('create payment '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('create payment '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '', str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Create Payment',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('delete payment '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('delete payment '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '', str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Delete Payment',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('income '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('income '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '', str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Income',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('expense '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('expense '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '', str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Expense',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('income vs expense '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('income vs expense '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '', str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Income VS Expense',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('loss & profit '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('loss & profit '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '', str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Loss & Profit',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('tax '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('tax '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '', str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Tax',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>

                                                          <?php if(in_array('invoice '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('invoice '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '', str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Invoice',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('bill '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('bill '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '', str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Bill',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('duplicate '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('duplicate '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '', str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Duplicate',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                              <?php if(in_array('balance sheet '.$module,(array) $permissions)): ?>
                                                                  <?php if($key = array_search('balance sheet '.$module,$permissions)): ?>
                                                                      <div class="col-md-3 custom-control custom-checkbox">
                                                                          <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '', str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                          <?php echo e(Form::label('permission'.$key,'Balance Sheet',['class'=>'custom-control-label'])); ?><br>
                                                                      </div>
                                                                  <?php endif; ?>
                                                              <?php endif; ?>
                                                              <?php if(in_array('ledger '.$module,(array) $permissions)): ?>
                                                                  <?php if($key = array_search('ledger '.$module,$permissions)): ?>
                                                                      <div class="col-md-3 custom-control custom-checkbox">
                                                                          <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '', str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                          <?php echo e(Form::label('permission'.$key,'Ledger',['class'=>'custom-control-label'])); ?><br>
                                                                      </div>
                                                                  <?php endif; ?>
                                                              <?php endif; ?>
                                                              <?php if(in_array('trial balance '.$module,(array) $permissions)): ?>
                                                                  <?php if($key = array_search('trial balance '.$module,$permissions)): ?>
                                                                      <div class="col-md-3 custom-control custom-checkbox">
                                                                          <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck staff_checkall isscheck_'.str_replace(' ', '', str_replace('&', '', $module)),'id' =>'permission'.$key])); ?>

                                                                          <?php echo e(Form::label('permission'.$key,'Trial Balance',['class'=>'custom-control-label'])); ?><br>
                                                                      </div>
                                                                  <?php endif; ?>
                                                              <?php endif; ?>
                                                      </div>
                                                  </td>
                                              </tr>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          </tbody>
                                      </table>
                                  <?php endif; ?>
                              </div>
                          </div>
                        </div>
                        <div class="tab-pane fade show " id="crm" role="tabpanel">
                          <?php
                             $modules=['lead','pipeline','lead stage','source','label','deal','task','stage','form builder','form response'];
                          ?>
                          <div class="col-md-12">
                              <div class="form-group">
                                  <?php if(!empty($permissions)): ?>
                                      <h6 class="my-3"><?php echo e(__('Assign CRM related Permission to Roles')); ?></h6>
                                      <table class="table table-striped mb-0" id="dataTable-1">
                                          <thead>
                                          <tr>
                                              <th>
                                                  <input type="checkbox" class="align-middle custom_align_middle" name="crm_heckall"  id="crm_checkall" ><?php echo e(__('Select All')); ?>

                                              </th>
                                              <th><?php echo e(__('Module')); ?> </th>
                                              <th><?php echo e(__('Permissions')); ?> </th>
                                          </tr>
                                          </thead>
                                          <tbody>

                                          <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <tr>
                                                  <td><input type="checkbox" class="align-middle ischeck crm_checkall"  data-id="<?php echo e(str_replace(' ', '', $module)); ?>" ></td>
                                                  <td><label class="ischeck crm_checkall" data-id="<?php echo e(str_replace(' ', '', $module)); ?>"><?php echo e(ucfirst($module)); ?></label></td>
                                                  <td>
                                                      <div class="row ">
                                                        <?php if(in_array('view '.$module,(array) $permissions)): ?>
                                                            <?php if($key = array_search('view '.$module,$permissions)): ?>
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                    <?php echo e(Form::label('permission'.$key,'View',['class'=>'custom-control-label'])); ?><br>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                        <?php if(in_array('add '.$module,(array) $permissions)): ?>
                                                            <?php if($key = array_search('add '.$module,$permissions)): ?>
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                    <?php echo e(Form::label('permission'.$key,'Add',['class'=>'custom-control-label'])); ?><br>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                        <?php if(in_array('move '.$module,(array) $permissions)): ?>
                                                            <?php if($key = array_search('move '.$module,$permissions)): ?>
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                    <?php echo e(Form::label('permission'.$key,'Move',['class'=>'custom-control-label'])); ?><br>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                          <?php if(in_array('manage '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('manage '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Manage',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('create '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('create '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Create',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('edit '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('edit '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Edit',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('delete '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('delete '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Delete',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('show '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('show '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Show',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>


                                                          <?php if(in_array('send '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('send '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Send',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>

                                                          <?php if(in_array('create payment '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('create payment '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Create Payment',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('delete payment '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('delete payment '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Delete Payment',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('income '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('income '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Income',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('expense '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('expense '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Expense',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('income vs expense '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('income vs expense '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Income VS Expense',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('loss & profit '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('loss & profit '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Loss & Profit',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('tax '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('tax '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Tax',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>

                                                          <?php if(in_array('invoice '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('invoice '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Invoice',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('bill '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('bill '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Bill',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('duplicate '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('duplicate '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Duplicate',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                              <?php if(in_array('balance sheet '.$module,(array) $permissions)): ?>
                                                                  <?php if($key = array_search('balance sheet '.$module,$permissions)): ?>
                                                                      <div class="col-md-3 custom-control custom-checkbox">
                                                                          <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                          <?php echo e(Form::label('permission'.$key,'Balance Sheet',['class'=>'custom-control-label'])); ?><br>
                                                                      </div>
                                                                  <?php endif; ?>
                                                              <?php endif; ?>
                                                              <?php if(in_array('ledger '.$module,(array) $permissions)): ?>
                                                                  <?php if($key = array_search('ledger '.$module,$permissions)): ?>
                                                                      <div class="col-md-3 custom-control custom-checkbox">
                                                                          <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                          <?php echo e(Form::label('permission'.$key,'Ledger',['class'=>'custom-control-label'])); ?><br>
                                                                      </div>
                                                                  <?php endif; ?>
                                                              <?php endif; ?>
                                                              <?php if(in_array('trial balance '.$module,(array) $permissions)): ?>
                                                                  <?php if($key = array_search('trial balance '.$module,$permissions)): ?>
                                                                      <div class="col-md-3 custom-control custom-checkbox">
                                                                          <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck crm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                          <?php echo e(Form::label('permission'.$key,'Trial Balance',['class'=>'custom-control-label'])); ?><br>
                                                                      </div>
                                                                  <?php endif; ?>
                                                              <?php endif; ?>
                                                      </div>
                                                  </td>
                                              </tr>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          </tbody>
                                      </table>
                                  <?php endif; ?>
                              </div>
                          </div>
                        </div>
                        <div class="tab-pane fade show " id="project" role="tabpanel">
                          <?php
                              $modules=['project dashboard','project','milestone','grant chart','project stage','timesheet','expense','project task','activity','CRM activity','project task stage','bug report','bug status'];
                          ?>
                          <div class="col-md-12">
                              <div class="form-group">
                                  <?php if(!empty($permissions)): ?>
                                      <h6 class="my-3"><?php echo e(__('Assign Project related Permission to Roles')); ?></h6>
                                      <table class="table table-striped mb-0" id="dataTable-1">
                                          <thead>
                                          <tr>
                                              <th>
                                                  <input type="checkbox" class="align-middle custom_align_middle" name="project_checkall"  id="project_checkall" ><?php echo e(__('Select All')); ?>

                                              </th>
                                              <th><?php echo e(__('Module')); ?> </th>
                                              <th><?php echo e(__('Permissions')); ?> </th>
                                          </tr>
                                          </thead>
                                          <tbody>

                                          <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <tr>
                                                  <td><input type="checkbox" class="align-middle ischeck project_checkall"  data-id="<?php echo e(str_replace(' ', '', $module)); ?>" ></td>
                                                  <td><label class="ischeck project_checkall" data-id="<?php echo e(str_replace(' ', '', $module)); ?>"><?php echo e(ucfirst($module)); ?></label></td>
                                                  <td>
                                                      <div class="row ">
                                                        <?php if(in_array('view '.$module,(array) $permissions)): ?>
                                                            <?php if($key = array_search('view '.$module,$permissions)): ?>
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input  isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                    <?php echo e(Form::label('permission'.$key,'View',['class'=>'custom-control-label'])); ?><br>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                        <?php if(in_array('add '.$module,(array) $permissions)): ?>
                                                            <?php if($key = array_search('add '.$module,$permissions)): ?>
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                    <?php echo e(Form::label('permission'.$key,'Add',['class'=>'custom-control-label'])); ?><br>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                        <?php if(in_array('move '.$module,(array) $permissions)): ?>
                                                            <?php if($key = array_search('move '.$module,$permissions)): ?>
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                    <?php echo e(Form::label('permission'.$key,'Move',['class'=>'custom-control-label'])); ?><br>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                          <?php if(in_array('manage '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('manage '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Manage',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('create '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('create '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Create',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('edit '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('edit '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Edit',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('delete '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('delete '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Delete',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('show '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('show '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Show',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>


                                                          <?php if(in_array('send '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('send '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Send',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>

                                                          <?php if(in_array('create payment '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('create payment '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Create Payment',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('delete payment '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('delete payment '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Delete Payment',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('income '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('income '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Income',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('expense '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('expense '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Expense',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('income vs expense '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('income vs expense '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Income VS Expense',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('loss & profit '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('loss & profit '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Loss & Profit',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('tax '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('tax '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Tax',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>

                                                          <?php if(in_array('invoice '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('invoice '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Invoice',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('bill '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('bill '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Bill',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('duplicate '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('duplicate '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Duplicate',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                              <?php if(in_array('balance sheet '.$module,(array) $permissions)): ?>
                                                                  <?php if($key = array_search('balance sheet '.$module,$permissions)): ?>
                                                                      <div class="col-md-3 custom-control custom-checkbox">
                                                                          <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                          <?php echo e(Form::label('permission'.$key,'Balance Sheet',['class'=>'custom-control-label'])); ?><br>
                                                                      </div>
                                                                  <?php endif; ?>
                                                              <?php endif; ?>
                                                              <?php if(in_array('ledger '.$module,(array) $permissions)): ?>
                                                                  <?php if($key = array_search('ledger '.$module,$permissions)): ?>
                                                                      <div class="col-md-3 custom-control custom-checkbox">
                                                                          <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                          <?php echo e(Form::label('permission'.$key,'Ledger',['class'=>'custom-control-label'])); ?><br>
                                                                      </div>
                                                                  <?php endif; ?>
                                                              <?php endif; ?>
                                                              <?php if(in_array('trial balance '.$module,(array) $permissions)): ?>
                                                                  <?php if($key = array_search('trial balance '.$module,$permissions)): ?>
                                                                      <div class="col-md-3 custom-control custom-checkbox">
                                                                          <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck project_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                          <?php echo e(Form::label('permission'.$key,'Trial Balance',['class'=>'custom-control-label'])); ?><br>
                                                                      </div>
                                                                  <?php endif; ?>
                                                              <?php endif; ?>
                                                      </div>
                                                  </td>
                                              </tr>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          </tbody>
                                      </table>
                                  <?php endif; ?>
                              </div>
                          </div>
                        </div>
                        <div class="tab-pane fade show" id="hrmpermission" role="tabpanel">
                          <?php
                              $modules=['hrm dashboard','employee','employee profile','department','designation','branch','document type','document','payslip type','allowance','commission','allowance option','loan option','deduction option','loan','saturation deduction','other payment','overtime','set salary','pay slip','company policy','appraisal','goal tracking','goal type','indicator','event','meeting','training','trainer','training type','award','award type','resignation','travel','promotion','complaint','warning','termination','termination type','job application','job application note','job onBoard','job category','job','job stage','custom question','interview schedule','estimation','holiday','transfer','announcement','leave','leave type','attendance'];
                          ?>

                          <div class="col-md-12">
                              <div class="form-group">
                                  <?php if(!empty($permissions)): ?>
                                      <h6 class="my-3"><?php echo e(__('Assign HRM related Permission to Roles')); ?>

                                      </h6>

                                      <table class="table table-striped mb-0" id="dataTable-1">
                                          <thead>
                                          <tr>
                                              <th>
                                                  <input type="checkbox" class="align-middle custom_align_middle" name="hrm_checkall"  id="hrm_checkall" ><?php echo e(__('Select All')); ?>

                                              </th>
                                              <th><?php echo e(__('Module')); ?> </th>
                                              <th><?php echo e(__('Permissions')); ?> </th>
                                          </tr>
                                          </thead>
                                          <tbody>
                                          <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <tr>
                                                  <td><input type="checkbox" class="align-middle ischeck hrm_checkall"  data-id="<?php echo e(str_replace(' ', '', $module)); ?>" ></td>
                                                  <td><label class="ischeck hrm_checkall" data-id="<?php echo e(str_replace(' ', '', $module)); ?>"><?php echo e(ucfirst($module)); ?></label></td>
                                                  <td>
                                                      <div class="row ">

                                                        <?php if(in_array('view '.$module,(array) $permissions)): ?>
                                                            <?php if($key = array_search('view '.$module,$permissions)): ?>
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                    <?php echo e(Form::label('permission'.$key,'View',['class'=>'custom-control-label'])); ?><br>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                        <?php if(in_array('add '.$module,(array) $permissions)): ?>
                                                            <?php if($key = array_search('add '.$module,$permissions)): ?>
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                    <?php echo e(Form::label('permission'.$key,'Add',['class'=>'custom-control-label'])); ?><br>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                        <?php if(in_array('move '.$module,(array) $permissions)): ?>
                                                            <?php if($key = array_search('move '.$module,$permissions)): ?>
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                    <?php echo e(Form::label('permission'.$key,'Move',['class'=>'custom-control-label'])); ?><br>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                          <?php if(in_array('manage '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('manage '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Manage',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('create '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('create '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Create',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('edit '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('edit '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Edit',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('delete '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('delete '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Delete',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('show '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('show '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Show',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>


                                                          <?php if(in_array('send '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('send '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Send',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>

                                                          <?php if(in_array('create payment '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('create payment '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Create Payment',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('delete payment '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('delete payment '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Delete Payment',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('income '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('income '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Income',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('expense '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('expense '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Expense',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('income vs expense '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('income vs expense '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Income VS Expense',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('loss & profit '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('loss & profit '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Loss & Profit',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('tax '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('tax '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Tax',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>

                                                          <?php if(in_array('invoice '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('invoice '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Invoice',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('bill '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('bill '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Bill',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('duplicate '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('duplicate '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Duplicate',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                              <?php if(in_array('balance sheet '.$module,(array) $permissions)): ?>
                                                                  <?php if($key = array_search('balance sheet '.$module,$permissions)): ?>
                                                                      <div class="col-md-3 custom-control custom-checkbox">
                                                                          <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                          <?php echo e(Form::label('permission'.$key,'Balance Sheet',['class'=>'custom-control-label'])); ?><br>
                                                                      </div>
                                                                  <?php endif; ?>
                                                              <?php endif; ?>
                                                              <?php if(in_array('ledger '.$module,(array) $permissions)): ?>
                                                                  <?php if($key = array_search('ledger '.$module,$permissions)): ?>
                                                                      <div class="col-md-3 custom-control custom-checkbox">
                                                                          <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                          <?php echo e(Form::label('permission'.$key,'Ledger',['class'=>'custom-control-label'])); ?><br>
                                                                      </div>
                                                                  <?php endif; ?>
                                                              <?php endif; ?>
                                                              <?php if(in_array('trial balance '.$module,(array) $permissions)): ?>
                                                                  <?php if($key = array_search('trial balance '.$module,$permissions)): ?>
                                                                      <div class="col-md-3 custom-control custom-checkbox">
                                                                          <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck hrm_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                          <?php echo e(Form::label('permission'.$key,'Trial Balance',['class'=>'custom-control-label'])); ?><br>
                                                                      </div>
                                                                  <?php endif; ?>
                                                              <?php endif; ?>
                                                      </div>
                                                  </td>
                                              </tr>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          </tbody>
                                      </table>
                                  <?php endif; ?>
                              </div>
                          </div>
                        </div>
                        <div class="tab-pane fade show " id="account" role="tabpanel">
                          <?php
                            $modules=['account dashboard','proposal','invoice','bill','revenue','payment','proposal product','invoice product','bill product','goal','credit note','debit note','bank account','bank transfer','transaction','customer','vender','constant custom field','assets','chart of account','journal entry','report'];
                          ?>
                          <div class="col-md-12">
                              <div class="form-group">
                                  <?php if(!empty($permissions)): ?>
                                      <h6 class="my-3"><?php echo e(__('Assign Account related Permission to Roles')); ?></h6>
                                      <table class="table table-striped mb-0" id="dataTable-1">
                                          <thead>
                                          <tr>
                                              <th>
                                                  <input type="checkbox" class="align-middle custom_align_middle" name="account_checkall"  id="account_checkall" ><?php echo e(__('Select All')); ?>

                                              </th>
                                              <th><?php echo e(__('Module')); ?> </th>
                                              <th><?php echo e(__('Permissions')); ?> </th>
                                          </tr>
                                          </thead>
                                          <tbody>

                                          <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <tr>
                                                  <td><input type="checkbox" class="align-middle ischeck"  data-id="<?php echo e(str_replace(' ', '', $module)); ?>" ></td>
                                                  <td><label class="ischeck" data-id="<?php echo e(str_replace(' ', '', $module)); ?>"><?php echo e(ucfirst($module)); ?></label></td>
                                                  <td>
                                                      <div class="row ">
                                                        <?php if(in_array('view '.$module,(array) $permissions)): ?>
                                                            <?php if($key = array_search('view '.$module,$permissions)): ?>
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                    <?php echo e(Form::label('permission'.$key,'View',['class'=>'custom-control-label'])); ?><br>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                        <?php if(in_array('add '.$module,(array) $permissions)): ?>
                                                            <?php if($key = array_search('add '.$module,$permissions)): ?>
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                    <?php echo e(Form::label('permission'.$key,'Add',['class'=>'custom-control-label'])); ?><br>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                        <?php if(in_array('move '.$module,(array) $permissions)): ?>
                                                            <?php if($key = array_search('move '.$module,$permissions)): ?>
                                                                <div class="col-md-3 custom-control custom-checkbox">
                                                                    <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                    <?php echo e(Form::label('permission'.$key,'Move',['class'=>'custom-control-label'])); ?><br>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                          <?php if(in_array('manage '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('manage '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Manage',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('create '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('create '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Create',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('edit '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('edit '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Edit',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('delete '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('delete '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Delete',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('show '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('show '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Show',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>


                                                          <?php if(in_array('send '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('send '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Send',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>

                                                          <?php if(in_array('create payment '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('create payment '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Create Payment',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('delete payment '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('delete payment '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Delete Payment',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('income '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('income '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Income',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('expense '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('expense '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Expense',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('income vs expense '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('income vs expense '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Income VS Expense',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('loss & profit '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('loss & profit '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Loss & Profit',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('tax '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('tax '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Tax',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>

                                                          <?php if(in_array('invoice '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('invoice '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Invoice',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('bill '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('bill '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Bill',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                          <?php if(in_array('duplicate '.$module,(array) $permissions)): ?>
                                                              <?php if($key = array_search('duplicate '.$module,$permissions)): ?>
                                                                  <div class="col-md-3 custom-control custom-checkbox">
                                                                      <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                      <?php echo e(Form::label('permission'.$key,'Duplicate',['class'=>'custom-control-label'])); ?><br>
                                                                  </div>
                                                              <?php endif; ?>
                                                          <?php endif; ?>
                                                              <?php if(in_array('balance sheet '.$module,(array) $permissions)): ?>
                                                                  <?php if($key = array_search('balance sheet '.$module,$permissions)): ?>
                                                                      <div class="col-md-3 custom-control custom-checkbox">
                                                                          <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                          <?php echo e(Form::label('permission'.$key,'Balance Sheet',['class'=>'custom-control-label'])); ?><br>
                                                                      </div>
                                                                  <?php endif; ?>
                                                              <?php endif; ?>
                                                              <?php if(in_array('ledger '.$module,(array) $permissions)): ?>
                                                                  <?php if($key = array_search('ledger '.$module,$permissions)): ?>
                                                                      <div class="col-md-3 custom-control custom-checkbox">
                                                                          <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                          <?php echo e(Form::label('permission'.$key,'Ledger',['class'=>'custom-control-label'])); ?><br>
                                                                      </div>
                                                                  <?php endif; ?>
                                                              <?php endif; ?>
                                                              <?php if(in_array('trial balance '.$module,(array) $permissions)): ?>
                                                                  <?php if($key = array_search('trial balance '.$module,$permissions)): ?>
                                                                      <div class="col-md-3 custom-control custom-checkbox">
                                                                          <?php echo e(Form::checkbox('permissions[]',$key,false, ['class'=>'custom-control-input isscheck account_checkall isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])); ?>

                                                                          <?php echo e(Form::label('permission'.$key,'Trial Balance',['class'=>'custom-control-label'])); ?><br>
                                                                      </div>
                                                                  <?php endif; ?>
                                                              <?php endif; ?>
                                                      </div>
                                                  </td>
                                              </tr>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          </tbody>
                                      </table>
                                  <?php endif; ?>
                              </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <div class="col-12 pt-5 text-right">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
  <?php echo e(Form::close()); ?>

</div>


<script>
    $(document).ready(function () {
        $("#staff_checkall").click(function(){
            $('.staff_checkall').not(this).prop('checked', this.checked);
        });
        $("#crm_checkall").click(function(){
            $('.crm_checkall').not(this).prop('checked', this.checked);
        });
        $("#project_checkall").click(function(){
            $('.project_checkall').not(this).prop('checked', this.checked);
        });
        $("#hrm_checkall").click(function(){
            $('.hrm_checkall').not(this).prop('checked', this.checked);
        });
        $("#account_checkall").click(function(){
            $('.account_checkall').not(this).prop('checked', this.checked);
        });
        $(".ischeck").click(function(){
            var ischeck = $(this).data('id');
            $('.isscheck_'+ ischeck).prop('checked', this.checked);
        });
    });
</script>


<?php /**PATH C:\Users\win10\Downloads\codecanyon_33263426_erpgo_saas_all_in_one_business_erp_with_project\codecanyon-33263426-erpgo-saas-all-in-one-business-erp-with-project-account-hrm-crm\main_file\resources\views/role/create.blade.php ENDPATH**/ ?>