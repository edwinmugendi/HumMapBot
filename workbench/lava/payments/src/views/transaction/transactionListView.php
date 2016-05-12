<div class="x_panel">
    <?php if (!array_key_exists('export', $view_data)): ?>    <div class="row">
        <div class="col-md-6">
            <?php if ($view_data['user']['role_id'] == 1): ?>            <a href="<?php echo \URL::route(camel_case($view_data['package'] . '_post_' . $view_data['controller']));?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;<?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.link.add');?></a>
            <?php endif; ?>        </div>

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
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'loan_id'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=loan_id'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=loan_id';?>
                        <?php endif;?>                                <th>   
                                    <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.loan_id'); ?>                                        <?php if ($is_ordered): ?>                                        <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                        <?php endif; ?>                                    </a>
                                </th>
                                <?php else: ?>                                <th>
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.loan_id'); ?>                                </th>
                                <?php endif; ?>                                                                                                                <?php if (!array_key_exists('export', $view_data)): ?>                                <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'phone'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=phone'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=phone';?>
                        <?php endif;?>                                <th>   
                                    <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.phone'); ?>                                        <?php if ($is_ordered): ?>                                        <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                        <?php endif; ?>                                    </a>
                                </th>
                                <?php else: ?>                                <th>
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.phone'); ?>                                </th>
                                <?php endif; ?>                                                                                                                <?php if (!array_key_exists('export', $view_data)): ?>                                <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'type'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=type'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=type';?>
                        <?php endif;?>                                <th>   
                                    <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.type'); ?>                                        <?php if ($is_ordered): ?>                                        <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                        <?php endif; ?>                                    </a>
                                </th>
                                <?php else: ?>                                <th>
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.type'); ?>                                </th>
                                <?php endif; ?>                                                                                                                <?php if (!array_key_exists('export', $view_data)): ?>                                <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'transaction_date'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=transaction_date'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=transaction_date';?>
                        <?php endif;?>                                <th>   
                                    <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.transaction_date'); ?>                                        <?php if ($is_ordered): ?>                                        <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                        <?php endif; ?>                                    </a>
                                </th>
                                <?php else: ?>                                <th>
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.transaction_date'); ?>                                </th>
                                <?php endif; ?>                                                                                                                <?php if (!array_key_exists('export', $view_data)): ?>                                <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'amount'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=amount'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=amount';?>
                        <?php endif;?>                                <th>   
                                    <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.amount'); ?>                                        <?php if ($is_ordered): ?>                                        <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                        <?php endif; ?>                                    </a>
                                </th>
                                <?php else: ?>                                <th>
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.amount'); ?>                                </th>
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
                                <?php endif; ?>                                                                                                                                                                    <?php if (!array_key_exists('export', $view_data)): ?>                                <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'gateway'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=gateway'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=gateway';?>
                        <?php endif;?>                                <th>   
                                    <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.gateway'); ?>                                        <?php if ($is_ordered): ?>                                        <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                        <?php endif; ?>                                    </a>
                                </th>
                                <?php else: ?>                                <th>
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.gateway'); ?>                                </th>
                                <?php endif; ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php if (!array_key_exists('export', $view_data)): ?>                        <th><?php echo \Lang::get('common.view.actions.actions'); ?></th>
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
                                                                            <?php echo \Form::compositeSelect('loan_id', $view_data['dataSource']['loan_id'], isset($view_data['input']['loan_id']) ? $view_data['input']['loan_id'] : '', array('class' => 'form-control')); ?>                                                                    </td>
                                
                                                                                    <td>
                                                                            <?php echo \Form::text('phone', isset($view_data['input']['phone']) ? $view_data['input']['phone'] : '', array('class' => 'form-control')); ?>                                                                    </td>
                                
                                                                                    <td>
                                                                            <?php echo \Form::compositeSelect('type', $view_data['dataSource']['type'], isset($view_data['input']['type']) ? $view_data['input']['type'] : '', array('class' => 'form-control')); ?>                                                                    </td>
                                
                                                                                    <td>
                                                                            <?php echo \Form::text('transaction_date', isset($view_data['input']['transaction_date']) ? $view_data['input']['transaction_date'] : '', array('class' => 'form-control')); ?>                                                                    </td>
                                
                                                                                    <td>
                                                                            <?php echo \Form::text('amount', isset($view_data['input']['amount']) ? $view_data['input']['amount'] : '', array('class' => 'form-control')); ?>                                                                    </td>
                                
                                                                                    <td>
                                                                            <?php echo \Form::text('currency', isset($view_data['input']['currency']) ? $view_data['input']['currency'] : '', array('class' => 'form-control')); ?>                                                                    </td>
                                
                                                        
                                                                                    <td>
                                                                            <?php echo \Form::compositeSelect('gateway', $view_data['dataSource']['gateway'], isset($view_data['input']['gateway']) ? $view_data['input']['gateway'] : '', array('class' => 'form-control')); ?>                                                                    </td>
                                
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
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