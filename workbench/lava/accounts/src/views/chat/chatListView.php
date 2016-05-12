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
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'sender_id'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=sender_id'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=sender_id';?>
                        <?php endif;?>                                <th>   
                                    <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.sender_id'); ?>                                        <?php if ($is_ordered): ?>                                        <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                        <?php endif; ?>                                    </a>
                                </th>
                                <?php else: ?>                                <th>
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.sender_id'); ?>                                </th>
                                <?php endif; ?>                                                                                                                <?php if (!array_key_exists('export', $view_data)): ?>                                <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'recipient_id'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=recipient_id'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=recipient_id';?>
                        <?php endif;?>                                <th>   
                                    <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.recipient_id'); ?>                                        <?php if ($is_ordered): ?>                                        <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                        <?php endif; ?>                                    </a>
                                </th>
                                <?php else: ?>                                <th>
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.recipient_id'); ?>                                </th>
                                <?php endif; ?>                                                                                                                <?php if (!array_key_exists('export', $view_data)): ?>                                <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'message'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=message'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=message';?>
                        <?php endif;?>                                <th>   
                                    <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.message'); ?>                                        <?php if ($is_ordered): ?>                                        <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                        <?php endif; ?>                                    </a>
                                </th>
                                <?php else: ?>                                <th>
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.message'); ?>                                </th>
                                <?php endif; ?>                                                                                                                <?php if (!array_key_exists('export', $view_data)): ?>                                <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'in_out'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=in_out'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=in_out';?>
                        <?php endif;?>                                <th>   
                                    <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.in_out'); ?>                                        <?php if ($is_ordered): ?>                                        <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                        <?php endif; ?>                                    </a>
                                </th>
                                <?php else: ?>                                <th>
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.in_out'); ?>                                </th>
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
                                <?php endif; ?>                                                                            <?php if (!array_key_exists('export', $view_data)): ?>                        <th><?php echo \Lang::get('common.view.actions.actions'); ?></th>
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
                                                                            <?php echo \Form::compositeSelect('sender_id', $view_data['dataSource']['sender_id'], isset($view_data['input']['sender_id']) ? $view_data['input']['sender_id'] : '', array('class' => 'form-control')); ?>                                                                    </td>
                                
                                                                                    <td>
                                                                            <?php echo \Form::compositeSelect('recipient_id', $view_data['dataSource']['recipient_id'], isset($view_data['input']['recipient_id']) ? $view_data['input']['recipient_id'] : '', array('class' => 'form-control')); ?>                                                                    </td>
                                
                                                                                    <td>
                                                                            <?php echo \Form::text('message', isset($view_data['input']['message']) ? $view_data['input']['message'] : '', array('class' => 'form-control')); ?>                                                                    </td>
                                
                                                                                    <td>
                                                                            <?php echo \Form::compositeSelect('in_out', $view_data['dataSource']['in_out'], isset($view_data['input']['in_out']) ? $view_data['input']['in_out'] : '', array('class' => 'form-control')); ?>                                                                    </td>
                                
                                                                                    <td>
                                                                            <?php echo \Form::compositeSelect('workflow', $view_data['dataSource']['workflow'], isset($view_data['input']['workflow']) ? $view_data['input']['workflow'] : '', array('class' => 'form-control')); ?>                                                                    </td>
                                
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