<div class="x_panel">
    <?php if (!array_key_exists('export', $view_data)): ?>    <div class="row">
        <div class="col-md-6">
            <a href="<?php echo \URL::route(camel_case($view_data['package'] . '_post_' . $view_data['controller']));?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;<?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.link.add');?></a>
        </div>
        <div class="col-md-6">
            <p class="pull-right commonFontWeightBold commonColor">
                <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])); ?>">
                    <?php echo \Lang::choice($view_data['package'] . '::' . $view_data['controller'] . '.view.link.found',$view_data['controller_model']->getTotal(),array('count'=>$view_data['controller_model']->getTotal())); ?>                </a>
            </p>
        </div>
    </div>
    <div class="row commonMarginTop5">
        <div class="col-md-12">
            <div class="btn-group"> 
                <button id="idDeleteRow" disabled type="button" class="btn btn-default" data-container="body" data-toggle="tooltip" data-placement="bottom" title="<?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.actions.delete.delete');?>"><i class="fa fa-trash fa-2x" aria-hidden="true"></i></button>
                <a href="<?php echo \URL::route(camel_case($view_data['package'] . '_list_' . $view_data['controller']), $view_data['paginationAppends']) . '&export=print';?>" target="_blank" type="button" class="btn btn-default" data-container="body" data-toggle="tooltip" data-placement="bottom" title="<?php echo \Lang::get('common.view.actions.print.print');?>"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                <a href="<?php echo \URL::route(camel_case($view_data['package'] . '_list_' . $view_data['controller']), $view_data['paginationAppends']) . '&export=pdf'?>" target="_blank" type="button" class="btn btn-default" data-container="body" data-toggle="tooltip" data-placement="bottom" title="<?php echo \Lang::get('common.view.actions.pdf.pdf');?>"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                <a href="<?php echo \URL::route(camel_case($view_data['package'] . '_list_' . $view_data['controller']), $view_data['paginationAppends']) . '&export=xls'?>" target="_blank" type="button" class="btn btn-default" data-container="body" data-toggle="tooltip" data-placement="bottom" title="<?php echo \Lang::get('common.view.actions.xls.xls');?>"><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
    <?php endif; ?>    <div class="row commonMarginTop10">
        <div class="col-md-12 table-responsive">
            <table id="idListTable" class="table table-bordered table-condensed table-striped table-hover"> 
                <thead> 
                    <tr>
                        <?php if (!array_key_exists('export', $view_data)): ?>                        <th><?php echo \Form::checkbox('check_all', 1, null, array('id' => 'idCheckUnCheckRow')); ?></th>  
                        <th></th>
                        <?php endif; ?>
                        <?php if ((!array_key_exists('export', $view_data)) || ((array_key_exists('export', $view_data) && in_array($view_data['export'],array('pdf','print')))) ): ?>                  
                                                <?php endif; ?>                                                                                    <?php if (!array_key_exists('export', $view_data)): ?>                                <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'id'): ?>
                             <?php $is_ordered = true;?>
                                <?php if (array_key_exists('order', $view_data['input']) && $view_data['input']['order'] == 'desc'): ?>
                                <?php
                                $order = 'asc';
                                ?>
                            <?php else: ?>
                                <?php
                                $order = 'desc';
                                ?>
                            <?php endif; ?>
                        <?php endif ?>

                        <?php if ($view_data['paginationAppends']): ?>
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=id'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=id';?>
                        <?php endif;?>                                <th>   
                                    <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.id'); ?>                                        <?php if ($is_ordered): ?>                                        <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                        <?php endif; ?>                                    </a>
                                </th>
                                <?php else: ?>                                <th>
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.id'); ?>                                </th>
                                <?php endif; ?>                                                                                                                <?php if (!array_key_exists('export', $view_data)): ?>                                <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'user_id'): ?>
                             <?php $is_ordered = true;?>
                                <?php if (array_key_exists('order', $view_data['input']) && $view_data['input']['order'] == 'desc'): ?>
                                <?php
                                $order = 'asc';
                                ?>
                            <?php else: ?>
                                <?php
                                $order = 'desc';
                                ?>
                            <?php endif; ?>
                        <?php endif ?>

                        <?php if ($view_data['paginationAppends']): ?>
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=user_id'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=user_id';?>
                        <?php endif;?>                                <th>   
                                    <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.user_id'); ?>                                        <?php if ($is_ordered): ?>                                        <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                        <?php endif; ?>                                    </a>
                                </th>
                                <?php else: ?>                                <th>
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.user_id'); ?>                                </th>
                                <?php endif; ?>                                                                                                                <?php if (!array_key_exists('export', $view_data)): ?>                                <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'plan_id'): ?>
                             <?php $is_ordered = true;?>
                                <?php if (array_key_exists('order', $view_data['input']) && $view_data['input']['order'] == 'desc'): ?>
                                <?php
                                $order = 'asc';
                                ?>
                            <?php else: ?>
                                <?php
                                $order = 'desc';
                                ?>
                            <?php endif; ?>
                        <?php endif ?>

                        <?php if ($view_data['paginationAppends']): ?>
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=plan_id'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=plan_id';?>
                        <?php endif;?>                                <th>   
                                    <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.plan_id'); ?>                                        <?php if ($is_ordered): ?>                                        <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                        <?php endif; ?>                                    </a>
                                </th>
                                <?php else: ?>                                <th>
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.plan_id'); ?>                                </th>
                                <?php endif; ?>                                                                                                                <?php if (!array_key_exists('export', $view_data)): ?>                                <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'currency'): ?>
                             <?php $is_ordered = true;?>
                                <?php if (array_key_exists('order', $view_data['input']) && $view_data['input']['order'] == 'desc'): ?>
                                <?php
                                $order = 'asc';
                                ?>
                            <?php else: ?>
                                <?php
                                $order = 'desc';
                                ?>
                            <?php endif; ?>
                        <?php endif ?>

                        <?php if ($view_data['paginationAppends']): ?>
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=currency'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=currency';?>
                        <?php endif;?>                                <th>   
                                    <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.currency'); ?>                                        <?php if ($is_ordered): ?>                                        <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                        <?php endif; ?>                                    </a>
                                </th>
                                <?php else: ?>                                <th>
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.currency'); ?>                                </th>
                                <?php endif; ?>                                                                                                                <?php if (!array_key_exists('export', $view_data)): ?>                                <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'principal'): ?>
                             <?php $is_ordered = true;?>
                                <?php if (array_key_exists('order', $view_data['input']) && $view_data['input']['order'] == 'desc'): ?>
                                <?php
                                $order = 'asc';
                                ?>
                            <?php else: ?>
                                <?php
                                $order = 'desc';
                                ?>
                            <?php endif; ?>
                        <?php endif ?>

                        <?php if ($view_data['paginationAppends']): ?>
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=principal'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=principal';?>
                        <?php endif;?>                                <th>   
                                    <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.principal'); ?>                                        <?php if ($is_ordered): ?>                                        <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                        <?php endif; ?>                                    </a>
                                </th>
                                <?php else: ?>                                <th>
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.principal'); ?>                                </th>
                                <?php endif; ?>                                                                                                                <?php if (!array_key_exists('export', $view_data)): ?>                                <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'interest'): ?>
                             <?php $is_ordered = true;?>
                                <?php if (array_key_exists('order', $view_data['input']) && $view_data['input']['order'] == 'desc'): ?>
                                <?php
                                $order = 'asc';
                                ?>
                            <?php else: ?>
                                <?php
                                $order = 'desc';
                                ?>
                            <?php endif; ?>
                        <?php endif ?>

                        <?php if ($view_data['paginationAppends']): ?>
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=interest'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=interest';?>
                        <?php endif;?>                                <th>   
                                    <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.interest'); ?>                                        <?php if ($is_ordered): ?>                                        <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                        <?php endif; ?>                                    </a>
                                </th>
                                <?php else: ?>                                <th>
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.interest'); ?>                                </th>
                                <?php endif; ?>                                                                                                                <?php if (!array_key_exists('export', $view_data)): ?>                                <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'workflow'): ?>
                             <?php $is_ordered = true;?>
                                <?php if (array_key_exists('order', $view_data['input']) && $view_data['input']['order'] == 'desc'): ?>
                                <?php
                                $order = 'asc';
                                ?>
                            <?php else: ?>
                                <?php
                                $order = 'desc';
                                ?>
                            <?php endif; ?>
                        <?php endif ?>

                        <?php if ($view_data['paginationAppends']): ?>
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=workflow'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=workflow';?>
                        <?php endif;?>                                <th>   
                                    <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.workflow'); ?>                                        <?php if ($is_ordered): ?>                                        <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                        <?php endif; ?>                                    </a>
                                </th>
                                <?php else: ?>                                <th>
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.workflow'); ?>                                </th>
                                <?php endif; ?>                                                                                                                <?php if (!array_key_exists('export', $view_data)): ?>                                <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'balance'): ?>
                             <?php $is_ordered = true;?>
                                <?php if (array_key_exists('order', $view_data['input']) && $view_data['input']['order'] == 'desc'): ?>
                                <?php
                                $order = 'asc';
                                ?>
                            <?php else: ?>
                                <?php
                                $order = 'desc';
                                ?>
                            <?php endif; ?>
                        <?php endif ?>

                        <?php if ($view_data['paginationAppends']): ?>
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=balance'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=balance';?>
                        <?php endif;?>                                <th>   
                                    <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.balance'); ?>                                        <?php if ($is_ordered): ?>                                        <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                        <?php endif; ?>                                    </a>
                                </th>
                                <?php else: ?>                                <th>
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.balance'); ?>                                </th>
                                <?php endif; ?>                                                                                                                <?php if (!array_key_exists('export', $view_data)): ?>                                <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'on_schedule'): ?>
                             <?php $is_ordered = true;?>
                                <?php if (array_key_exists('order', $view_data['input']) && $view_data['input']['order'] == 'desc'): ?>
                                <?php
                                $order = 'asc';
                                ?>
                            <?php else: ?>
                                <?php
                                $order = 'desc';
                                ?>
                            <?php endif; ?>
                        <?php endif ?>

                        <?php if ($view_data['paginationAppends']): ?>
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=on_schedule'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=on_schedule';?>
                        <?php endif;?>                                <th>   
                                    <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.on_schedule'); ?>                                        <?php if ($is_ordered): ?>                                        <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                        <?php endif; ?>                                    </a>
                                </th>
                                <?php else: ?>                                <th>
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.on_schedule'); ?>                                </th>
                                <?php endif; ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php if (!array_key_exists('export', $view_data)): ?>                        <th><?php echo \Lang::get('common.view.actions.actions'); ?></th>
                        <?php endif; ?>                    </tr>
                <tbody>
                    <?php if (!array_key_exists('export', $view_data)): ?>                    <tr>
                        <?php echo \Form::open(array('route' => camel_case($view_data['package'] . '_list_' . $view_data['controller']), 'method' => 'get', 'id' => 'idSearchByForm')); ?>                        <td></td>
                        <td></td>
                                                                                                            <td>
                                                                            <?php echo \Form::text('id', isset($view_data['input']['id']) ? $view_data['input']['id'] : '', array('class' => 'form-control')); ?>                                                                    </td>
                                
                                                                                    <td>
                                                                            <?php echo \Form::compositeSelect('user_id', $view_data['dataSource']['user_id'], isset($view_data['input']['user_id']) ? $view_data['input']['user_id'] : '', array('class' => 'form-control')); ?>                                                                    </td>
                                
                                                                                    <td>
                                                                            <?php echo \Form::compositeSelect('plan_id', $view_data['dataSource']['plan_id'], isset($view_data['input']['plan_id']) ? $view_data['input']['plan_id'] : '', array('class' => 'form-control')); ?>                                                                    </td>
                                
                                                                                    <td>
                                                                            <?php echo \Form::compositeSelect('currency', $view_data['dataSource']['currency'], isset($view_data['input']['currency']) ? $view_data['input']['currency'] : '', array('class' => 'form-control')); ?>                                                                    </td>
                                
                                                                                    <td>
                                                                            <?php echo \Form::text('principal', isset($view_data['input']['principal']) ? $view_data['input']['principal'] : '', array('class' => 'form-control')); ?>                                                                    </td>
                                
                                                                                    <td>
                                                                            <?php echo \Form::text('interest', isset($view_data['input']['interest']) ? $view_data['input']['interest'] : '', array('class' => 'form-control')); ?>                                                                    </td>
                                
                                                                                    <td>
                                                                            <?php echo \Form::compositeSelect('workflow', $view_data['dataSource']['workflow'], isset($view_data['input']['workflow']) ? $view_data['input']['workflow'] : '', array('class' => 'form-control')); ?>                                                                    </td>
                                
                                                                                    <td>
                                                                            <?php echo \Form::text('balance', isset($view_data['input']['balance']) ? $view_data['input']['balance'] : '', array('class' => 'form-control')); ?>                                                                    </td>
                                
                                                                                    <td>
                                                                            <?php echo \Form::compositeSelect('on_schedule', $view_data['dataSource']['on_schedule'], isset($view_data['input']['on_schedule']) ? $view_data['input']['on_schedule'] : '', array('class' => 'form-control')); ?>                                                                    </td>
                                
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                <td>
                            <a title="<?php echo \Lang::get('common.view.actions.search.search'); ?>" class="pull-left searchSubmit"><span class="icon-data-search icon-data-2x text-danger"></span></a>
                            <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])); ?>" class="pull-left" title="<?php echo \Lang::get('common.view.actions.clear.clear'); ?>"><span class="icon-data-clear icon-data-2x text-danger"></span></a>
                        </td>
                        </form>                    </tr>
                    <?php endif; ?>                    <?php echo $view_data['controllerList']; ?>                </tbody> 
            </table>
        </div>
    </div>
    <?php if (!array_key_exists('export', $view_data)): ?>    <div class="row">
        <div class="col-md-12">
            <?php
        if ($view_data['paginationAppends']) {
            echo $view_data['controller_model']->appends($view_data['paginationAppends'])->links();
        } else {
            echo $view_data['controller_model']->links();
        }//E# if else statement                   
        ?>        </div>
    </div>
    <?php endif; ?></div>