<?php if (!array_key_exists('export', $view_data)): ?><div class="row">
    <div class="col-md-6">
        <?php echo \HTML::link(\URL::route(camel_case($view_data['package'] . '_post_' . $view_data['controller'])), \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.link.add'), array('class' => 'btn btn-primary')); ?>    </div>
    <div class="col-md-6">
        <p class="pull-right commonFontWeightBold commonColor">
            <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])); ?>">
                <?php echo \Lang::choice($view_data['package'] . '::' . $view_data['controller'] . '.view.link.found',$view_data['controller_model']->getTotal(),array('count'=>$view_data['controller_model']->getTotal())); ?>            </a>
        </p>
    </div>
</div>
<div class="row commonMarginTop5">
    <div class="col-md-12">
        <?php echo Form::button(\Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.actions.delete.delete'), array('class' => 'btn btn-danger', 'id' => 'idDeleteRow', 'disabled')); ?>        <div class="btn-group">
            <button type="button" class="btn btn-success"><?php echo \Lang::get('common.view.actions.export.export'); ?></button>
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><?php echo HTML::link(\URL::route(camel_case($view_data['package'] . '_list_' . $view_data['controller']), $view_data['paginationAppends']) . '&export=pdf', \Lang::get('common.view.actions.pdf.pdf'), array('id' => 'idPdf', 'title' => \Lang::get('common.view.actions.pdf.desc'))); ?></li>
                <li><?php echo HTML::link(\URL::route(camel_case($view_data['package'] . '_list_' . $view_data['controller']), $view_data['paginationAppends']) . '&export=xls', \Lang::get('common.view.actions.xls.xls'), array('id' => 'idXls', 'title' => \Lang::get('common.view.actions.xls.desc'))); ?></li>
                <li><?php echo HTML::link(\URL::route(camel_case($view_data['package'] . '_list_' . $view_data['controller']), $view_data['paginationAppends']) . '&export=csv', \Lang::get('common.view.actions.csv.csv'), array('id' => 'idCsv', 'title' => \Lang::get('common.view.actions.csv.desc'))); ?></li>
            </ul>
        </div>
        <?php echo HTML::link(\URL::route(camel_case($view_data['package'] . '_list_' . $view_data['controller']), $view_data['paginationAppends']) . '&export=print', \Lang::get('common.view.actions.print.print'), array('id' => 'idPrint', 'target' => '_blank', 'class' => 'btn btn-info', 'title' => \Lang::get('common.view.actions.print.desc'))); ?>    </div>
</div>
<?php endif; ?><div class="row commonMarginTop5">
    <div class="col-md-12 table-responsive">
        <table id="idListTable" class="table table-bordered table-condensed table-striped table-hover"> 
            <thead> 
                <tr>
                    <?php if (!array_key_exists('export', $view_data)): ?>                    <th><?php echo \Form::checkbox('check_all', 1, null, array('id' => 'idCheckUnCheckRow')); ?></th>  
                    <th></th>
                    <?php endif; ?>                    
                     <?php if ((!array_key_exists('export', $view_data)) || ((array_key_exists('export', $view_data) && in_array($view_data['export'],array('pdf','print')))) ): ?>                  
                                        <?php endif; ?>                                                                        <?php if (!array_key_exists('export', $view_data)): ?>                            <?php
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
                        <?php endif;?>                            <th>   
                                <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.id'); ?>                                    <?php if ($is_ordered): ?>                                    <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                    <?php endif; ?>                                </a>
                            </th>
                            <?php else: ?>                            <th>
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.id'); ?>                            </th>
                                <?php endif; ?>                                                                                                        <?php if (!array_key_exists('export', $view_data)): ?>                            <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'merchant_id'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=merchant_id'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=merchant_id';?>
                        <?php endif;?>                            <th>   
                                <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.merchant_id'); ?>                                    <?php if ($is_ordered): ?>                                    <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                    <?php endif; ?>                                </a>
                            </th>
                            <?php else: ?>                            <th>
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.merchant_id'); ?>                            </th>
                                <?php endif; ?>                                                                                                        <?php if (!array_key_exists('export', $view_data)): ?>                            <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'name'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=name'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=name';?>
                        <?php endif;?>                            <th>   
                                <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.name'); ?>                                    <?php if ($is_ordered): ?>                                    <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                    <?php endif; ?>                                </a>
                            </th>
                            <?php else: ?>                            <th>
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.name'); ?>                            </th>
                                <?php endif; ?>                                                                                                                                                        <?php if (!array_key_exists('export', $view_data)): ?>                            <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'location_id'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=location_id'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=location_id';?>
                        <?php endif;?>                            <th>   
                                <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.location_id'); ?>                                    <?php if ($is_ordered): ?>                                    <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                    <?php endif; ?>                                </a>
                            </th>
                            <?php else: ?>                            <th>
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.location_id'); ?>                            </th>
                                <?php endif; ?>                                                                                                        <?php if (!array_key_exists('export', $view_data)): ?>                            <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'price_1'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=price_1'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=price_1';?>
                        <?php endif;?>                            <th>   
                                <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.price_1'); ?>                                    <?php if ($is_ordered): ?>                                    <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                    <?php endif; ?>                                </a>
                            </th>
                            <?php else: ?>                            <th>
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.price_1'); ?>                            </th>
                                <?php endif; ?>                                                                                                        <?php if (!array_key_exists('export', $view_data)): ?>                            <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'price_2'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=price_2'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=price_2';?>
                        <?php endif;?>                            <th>   
                                <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.price_2'); ?>                                    <?php if ($is_ordered): ?>                                    <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                    <?php endif; ?>                                </a>
                            </th>
                            <?php else: ?>                            <th>
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.price_2'); ?>                            </th>
                                <?php endif; ?>                                                                                                        <?php if (!array_key_exists('export', $view_data)): ?>                            <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'loyable'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=loyable'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=loyable';?>
                        <?php endif;?>                            <th>   
                                <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.loyable'); ?>                                    <?php if ($is_ordered): ?>                                    <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                    <?php endif; ?>                                </a>
                            </th>
                            <?php else: ?>                            <th>
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.loyable'); ?>                            </th>
                                <?php endif; ?>                                                                            <?php if (!array_key_exists('export', $view_data)): ?>                    <th><?php echo \Lang::get('common.view.actions.actions'); ?></th>
                    <?php endif; ?>                </tr>
            <tbody>
                <?php if (!array_key_exists('export', $view_data)): ?>                <tr>
                    <?php echo \Form::open(array('route' => camel_case($view_data['package'] . '_list_' . $view_data['controller']), 'method' => 'get', 'id' => 'idSearchByForm')); ?>                    <td></td>
                    <td></td>
                                                                                            <td>
                                                                    <?php echo \Form::text('id', isset($view_data['input']['id']) ? $view_data['input']['id'] : '', array('class' => 'form-control')); ?>                                                            </td>
                            
                                                                        <td>
                                                                    <?php echo \Form::compositeSelect('merchant_id', $view_data['dataSource']['merchant_id'], isset($view_data['input']['merchant_id']) ? $view_data['input']['merchant_id'] : '', array('class' => 'form-control')); ?>                                                            </td>
                            
                                                                        <td>
                                                                    <?php echo \Form::text('name', isset($view_data['input']['name']) ? $view_data['input']['name'] : '', array('class' => 'form-control')); ?>                                                            </td>
                            
                                                
                                                                        <td>
                                                                    <?php echo \Form::compositeSelect('location_id', $view_data['dataSource']['location_id'], isset($view_data['input']['location_id']) ? $view_data['input']['location_id'] : '', array('class' => 'form-control')); ?>                                                            </td>
                            
                                                                        <td>
                                                                    <?php echo \Form::text('price_1', isset($view_data['input']['price_1']) ? $view_data['input']['price_1'] : '', array('class' => 'form-control')); ?>                                                            </td>
                            
                                                                        <td>
                                                                    <?php echo \Form::text('price_2', isset($view_data['input']['price_2']) ? $view_data['input']['price_2'] : '', array('class' => 'form-control')); ?>                                                            </td>
                            
                                                                        <td>
                                                                    <?php echo \Form::compositeSelect('loyable', $view_data['dataSource']['loyable'], isset($view_data['input']['loyable']) ? $view_data['input']['loyable'] : '', array('class' => 'form-control')); ?>                                                            </td>
                            
                                        <td>
                        <a title="<?php echo \Lang::get('common.view.actions.search.search'); ?>" class="pull-left searchSubmit"><span class="icon-data-search icon-data-2x text-danger"></span></a>
                        <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])); ?>" class="pull-left" title="<?php echo \Lang::get('common.view.actions.clear.clear'); ?>"><span class="icon-data-clear icon-data-2x text-danger"></span></a>
                    </td>
                    </form>                </tr>
                <?php endif; ?>                <?php echo $view_data['controllerList']; ?>            </tbody> 
        </table>
    </div>
</div>
<?php if (!array_key_exists('export', $view_data)): ?><div class="row">
    <div class="col-md-12">
        <?php
        if ($view_data['paginationAppends']) {
            echo $view_data['controller_model']->appends($view_data['paginationAppends'])->links();
        } else {
            echo $view_data['controller_model']->links();
        }//E# if else statement                   
        ?>    </div>
</div>
<?php endif; ?>