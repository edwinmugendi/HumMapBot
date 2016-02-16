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
                                            <th><?php echo \Lang::get('media::media.view.image'); ?></th>
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
                                <?php endif; ?>                                                                                                        <?php if (!array_key_exists('export', $view_data)): ?>                            <?php
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
                        <?php endif;?>                            <th>   
                                <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.workflow'); ?>                                    <?php if ($is_ordered): ?>                                    <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                    <?php endif; ?>                                </a>
                            </th>
                            <?php else: ?>                            <th>
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.workflow'); ?>                            </th>
                                <?php endif; ?>                                                                                                        <?php if (!array_key_exists('export', $view_data)): ?>                            <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'reg_no'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=reg_no'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=reg_no';?>
                        <?php endif;?>                            <th>   
                                <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.reg_no'); ?>                                    <?php if ($is_ordered): ?>                                    <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                    <?php endif; ?>                                </a>
                            </th>
                            <?php else: ?>                            <th>
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.reg_no'); ?>                            </th>
                                <?php endif; ?>                                                                                                        <?php if (!array_key_exists('export', $view_data)): ?>                            <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'tax_id'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=tax_id'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=tax_id';?>
                        <?php endif;?>                            <th>   
                                <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.tax_id'); ?>                                    <?php if ($is_ordered): ?>                                    <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                    <?php endif; ?>                                </a>
                            </th>
                            <?php else: ?>                            <th>
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.tax_id'); ?>                            </th>
                                <?php endif; ?>                                                                                                                                                                                                                                                        <?php if (!array_key_exists('export', $view_data)): ?>                            <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'phone_1'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=phone_1'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=phone_1';?>
                        <?php endif;?>                            <th>   
                                <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.phone_1'); ?>                                    <?php if ($is_ordered): ?>                                    <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                    <?php endif; ?>                                </a>
                            </th>
                            <?php else: ?>                            <th>
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.phone_1'); ?>                            </th>
                                <?php endif; ?>                                                                                                        <?php if (!array_key_exists('export', $view_data)): ?>                            <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'phone_2'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=phone_2'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=phone_2';?>
                        <?php endif;?>                            <th>   
                                <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.phone_2'); ?>                                    <?php if ($is_ordered): ?>                                    <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                    <?php endif; ?>                                </a>
                            </th>
                            <?php else: ?>                            <th>
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.phone_2'); ?>                            </th>
                                <?php endif; ?>                                                                                                        <?php if (!array_key_exists('export', $view_data)): ?>                            <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'email'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=email'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=email';?>
                        <?php endif;?>                            <th>   
                                <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.email'); ?>                                    <?php if ($is_ordered): ?>                                    <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                    <?php endif; ?>                                </a>
                            </th>
                            <?php else: ?>                            <th>
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.email'); ?>                            </th>
                                <?php endif; ?>                                                                                                                                                        <?php if (!array_key_exists('export', $view_data)): ?>                            <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'country_id'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=country_id'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=country_id';?>
                        <?php endif;?>                            <th>   
                                <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.country_id'); ?>                                    <?php if ($is_ordered): ?>                                    <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                    <?php endif; ?>                                </a>
                            </th>
                            <?php else: ?>                            <th>
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.country_id'); ?>                            </th>
                                <?php endif; ?>                                                                                                        <?php if (!array_key_exists('export', $view_data)): ?>                            <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'province'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=province'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=province';?>
                        <?php endif;?>                            <th>   
                                <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.province'); ?>                                    <?php if ($is_ordered): ?>                                    <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                    <?php endif; ?>                                </a>
                            </th>
                            <?php else: ?>                            <th>
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.province'); ?>                            </th>
                                <?php endif; ?>                                                                                                        <?php if (!array_key_exists('export', $view_data)): ?>                            <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'city'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=city'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=city';?>
                        <?php endif;?>                            <th>   
                                <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.city'); ?>                                    <?php if ($is_ordered): ?>                                    <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                    <?php endif; ?>                                </a>
                            </th>
                            <?php else: ?>                            <th>
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.city'); ?>                            </th>
                                <?php endif; ?>                                                                                                        <?php if (!array_key_exists('export', $view_data)): ?>                            <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'street'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=street'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=street';?>
                        <?php endif;?>                            <th>   
                                <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.street'); ?>                                    <?php if ($is_ordered): ?>                                    <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                    <?php endif; ?>                                </a>
                            </th>
                            <?php else: ?>                            <th>
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.street'); ?>                            </th>
                                <?php endif; ?>                                                                                                        <?php if (!array_key_exists('export', $view_data)): ?>                            <?php
                        $order = 'asc';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists('sort', $view_data['input']) && $view_data['input']['sort'] == 'postal_code'): ?>
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
                            <?php $url = http_build_query($view_data['paginationAppends']) . '&order=' . $order . '&sort=postal_code'; ?>
                        <?php else: ?>
                            <?php $url = 'order=' . $order . '&sort=postal_code';?>
                        <?php endif;?>                            <th>   
                                <a href="<?php echo \Route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])) . '?' . $url ?>">
                                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.postal_code'); ?>                                    <?php if ($is_ordered): ?>                                    <span class="<?php echo ($order == 'asc') ? 'dropdown':'dropup';?>"><span class="caret"></span></span>
                                    <?php endif; ?>                                </a>
                            </th>
                            <?php else: ?>                            <th>
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.postal_code'); ?>                            </th>
                                <?php endif; ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php if (!array_key_exists('export', $view_data)): ?>                    <th><?php echo \Lang::get('common.view.actions.actions'); ?></th>
                    <?php endif; ?>                </tr>
            <tbody>
                <?php if (!array_key_exists('export', $view_data)): ?>                <tr>
                    <?php echo \Form::open(array('route' => camel_case($view_data['package'] . '_list_' . $view_data['controller']), 'method' => 'get', 'id' => 'idSearchByForm')); ?>                    <td></td>
                    <td></td>
                                            <td></td>
                                                                                            <td>
                                                                    <?php echo \Form::text('id', isset($view_data['input']['id']) ? $view_data['input']['id'] : '', array('class' => 'form-control')); ?>                                                            </td>
                            
                                                                        <td>
                                                                    <?php echo \Form::text('name', isset($view_data['input']['name']) ? $view_data['input']['name'] : '', array('class' => 'form-control')); ?>                                                            </td>
                            
                                                                        <td>
                                                                    <?php echo \Form::compositeSelect('workflow', $view_data['dataSource']['workflow'], isset($view_data['input']['workflow']) ? $view_data['input']['workflow'] : '', array('class' => 'form-control')); ?>                                                            </td>
                            
                                                                        <td>
                                                                    <?php echo \Form::text('reg_no', isset($view_data['input']['reg_no']) ? $view_data['input']['reg_no'] : '', array('class' => 'form-control')); ?>                                                            </td>
                            
                                                                        <td>
                                                                    <?php echo \Form::text('tax_id', isset($view_data['input']['tax_id']) ? $view_data['input']['tax_id'] : '', array('class' => 'form-control')); ?>                                                            </td>
                            
                                                
                                                
                                                
                                                                        <td>
                                                                    <?php echo \Form::text('phone_1', isset($view_data['input']['phone_1']) ? $view_data['input']['phone_1'] : '', array('class' => 'form-control')); ?>                                                            </td>
                            
                                                                        <td>
                                                                    <?php echo \Form::text('phone_2', isset($view_data['input']['phone_2']) ? $view_data['input']['phone_2'] : '', array('class' => 'form-control')); ?>                                                            </td>
                            
                                                                        <td>
                                                                    <?php echo \Form::text('email', isset($view_data['input']['email']) ? $view_data['input']['email'] : '', array('class' => 'form-control')); ?>                                                            </td>
                            
                                                
                                                                        <td>
                                                                    <?php echo \Form::compositeSelect('country_id', $view_data['dataSource']['country_id'], isset($view_data['input']['country_id']) ? $view_data['input']['country_id'] : '', array('class' => 'form-control')); ?>                                                            </td>
                            
                                                                        <td>
                                                                    <?php echo \Form::text('province', isset($view_data['input']['province']) ? $view_data['input']['province'] : '', array('class' => 'form-control')); ?>                                                            </td>
                            
                                                                        <td>
                                                                    <?php echo \Form::text('city', isset($view_data['input']['city']) ? $view_data['input']['city'] : '', array('class' => 'form-control')); ?>                                                            </td>
                            
                                                                        <td>
                                                                    <?php echo \Form::text('street', isset($view_data['input']['street']) ? $view_data['input']['street'] : '', array('class' => 'form-control')); ?>                                                            </td>
                            
                                                                        <td>
                                                                    <?php echo \Form::text('postal_code', isset($view_data['input']['postal_code']) ? $view_data['input']['postal_code'] : '', array('class' => 'form-control')); ?>                                                            </td>
                            
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
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