<div class="x_panel">
    <?php echo '<?php if (!array_key_exists(\'export\', $view_data)): ?>'; ?>
    <div class="row">
        <div class="col-md-6">
            <?php echo '<?php if ($view_data[\'user\'][\'role_id\'] == 1): ?>'; ?>
            <a href="<?php echo '<?php echo \URL::route(camel_case($view_data[\'package\'] . \'_post_\' . $view_data[\'controller\']));?>' ?>" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;<?php echo '<?php echo \Lang::get($view_data[\'package\'] . \'::\' . $view_data[\'controller\'] . \'.view.link.add\');?>' ?></a>
            <?php echo '<?php endif; ?>'; ?>
        </div>

        <div class="col-md-6">
            <p class="pull-right commonFontWeightBold commonColor">
                <a href="<?php echo '<?php echo \Route(camel_case($view_data[\'package\'] . \'_list_\' . $view_data[\'controller\'])); ?>'; ?>">
                    <?php echo '<?php echo \Lang::choice($view_data[\'package\'] . \'::\' . $view_data[\'controller\'] . \'.view.link.found\',$view_data[\'controller_model\']->getTotal(),array(\'count\'=>$view_data[\'controller_model\']->getTotal())); ?>'; ?>
                </a>
            </p>
        </div>
    </div>
    <div class="row commonMarginTop5">
        <div class="col-md-12">
            <div class="btn-group"> 
                <button id="idDeleteRow" disabled type="button" class="btn btn-default" data-container="body" data-toggle="tooltip" data-placement="bottom" title="<?php echo '<?php echo \Lang::get($view_data[\'package\'] . \'::\' . $view_data[\'controller\'] . \'.view.actions.delete.delete\');?>' ?>"><i class="fa fa-trash fa-2x" aria-hidden="true"></i></button>
                <a href="<?php echo '<?php echo \URL::route(camel_case($view_data[\'package\'] . \'_list_\' . $view_data[\'controller\']), $view_data[\'paginationAppends\']) . \'&export=print\';?>'; ?>" target="_blank" type="button" class="btn btn-default" data-container="body" data-toggle="tooltip" data-placement="bottom" title="<?php echo '<?php echo \Lang::get(\'common.view.actions.print.print\');?>' ?>"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                <a href="<?php echo '<?php echo \URL::route(camel_case($view_data[\'package\'] . \'_list_\' . $view_data[\'controller\']), $view_data[\'paginationAppends\']) . \'&export=pdf\'?>'; ?>" target="_blank" type="button" class="btn btn-default" data-container="body" data-toggle="tooltip" data-placement="bottom" title="<?php echo '<?php echo \Lang::get(\'common.view.actions.pdf.pdf\');?>' ?>"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                <a href="<?php echo '<?php echo \URL::route(camel_case($view_data[\'package\'] . \'_list_\' . $view_data[\'controller\']), $view_data[\'paginationAppends\']) . \'&export=xls\'?>'; ?>" target="_blank" type="button" class="btn btn-default" data-container="body" data-toggle="tooltip" data-placement="bottom" title="<?php echo '<?php echo \Lang::get(\'common.view.actions.xls.xls\');?>' ?>"><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
    <?php echo '<?php endif; ?>'; ?>
    <div class="row commonMarginTop10">
        <div class="col-md-12 table-responsive">
            <table id="idListTable" class="table table-bordered table-condensed table-striped table-hover"> 
                <thead> 
                    <tr>
                        <?php echo '<?php if (!array_key_exists(\'export\', $view_data)): ?>'; ?>
                        <th><?php echo '<?php echo \Form::checkbox(\'check_all\', 1, null, array(\'id\' => \'idCheckUnCheckRow\')); ?>'; ?></th>  
                        <th></th>
                        <?php echo '<?php endif; ?>'; ?>

                        <?php echo '<?php if ((!array_key_exists(\'export\', $view_data)) || ((array_key_exists(\'export\', $view_data) && in_array($view_data[\'export\'],array(\'pdf\',\'print\')))) ): ?>'; ?>                  
                        <?php if ($imageable): ?>
                            <th><?php echo '<?php echo \Lang::get(\'media::media.view.image\'); ?>'; ?></th>
                        <?php endif; ?>
                        <?php echo '<?php endif; ?>'; ?>
                        <?php foreach ($fields as $field => $field_info): ?>
                            <?php if ($field_info[0]): ?>
                                <?php echo '<?php if (!array_key_exists(\'export\', $view_data)): ?>'; ?>
                                <?php echo '<?php
                        $order = \'asc\';
                        $is_ordered = false;
                        ?>
                        <?php if (array_key_exists(\'sort\', $view_data[\'input\']) && $view_data[\'input\'][\'sort\'] == \'' . $field . '\'): ?>
                             <?php $is_ordered = true;?>
                                <?php if (array_key_exists(\'order\', $view_data[\'input\']) && $view_data[\'input\'][\'order\'] == \'desc\'): ?>
                                <?php
                                $order = \'asc\';
                                ?>
                            <?php else: ?>
                                <?php
                                $order = \'desc\';
                                ?>
                            <?php endif; ?>
                        <?php endif ?>

                        <?php if ($view_data[\'paginationAppends\']): ?>
                            <?php $url = http_build_query($view_data[\'paginationAppends\']) . \'&order=\' . $order . \'&sort=' . $field . '\'; ?>
                        <?php else: ?>
                            <?php $url = \'order=\' . $order . \'&sort=' . $field . '\';?>
                        <?php endif;?>'; ?>
                                <th>   
                                    <a href="<?php echo '<?php echo \Route(camel_case($view_data[\'package\'] . \'_list_\' . $view_data[\'controller\'])) . \'?\' . $url ?>'; ?>">
                                        <?php echo '<?php echo \Lang::get($view_data[\'package\'] . \'::\' . $view_data[\'controller\'] . \'.view.field.' . $field . '\'); ?>'; ?>
                                        <?php echo '<?php if ($is_ordered): ?>'; ?>
                                        <span class="<?php echo '<?php echo ($order == \'asc\') ? \'dropdown\':\'dropup\';?>'; ?>"><span class="caret"></span></span>
                                        <?php echo '<?php endif; ?>'; ?>
                                    </a>
                                </th>
                                <?php echo '<?php else: ?>'; ?>
                                <th>
                                    <?php echo '<?php echo \Lang::get($view_data[\'package\'] . \'::\' . $view_data[\'controller\'] . \'.view.field.' . $field . '\'); ?>'; ?>
                                </th>
                                <?php echo '<?php endif; ?>'; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php echo '<?php if (!array_key_exists(\'export\', $view_data)): ?>'; ?>
                        <th><?php echo '<?php echo \Lang::get(\'common.view.actions.actions\'); ?>'; ?></th>
                        <?php echo '<?php endif; ?>'; ?>
                    </tr>
                <tbody>
                    <?php echo '<?php if (!array_key_exists(\'export\', $view_data)): ?>'; ?>
                    <tr>
                        <?php echo '<?php echo \Form::open(array(\'route\' => camel_case($view_data[\'package\'] . \'_list_\' . $view_data[\'controller\']), \'method\' => \'get\', \'id\' => \'idSearchByForm\')); ?>'; ?>
                        <td></td>
                        <td></td>
                        <?php if ($imageable): ?>
                            <td></td>
                        <?php endif; ?>
                        <?php foreach ($fields as $field => $field_info): ?>
                            <?php if ($field_info[0]): ?>
                                <td>
                                    <?php if (($field_info[1] == 'text')): ?>
                                        <?php echo '<?php echo \Form::text(\'' . $field . '\', isset($view_data[\'input\'][\'' . $field . '\']) ? $view_data[\'input\'][\'' . $field . '\'] : \'\', array(\'class\' => \'form-control\')); ?>'; ?>
                                    <?php elseif ($field_info[1] == 'select'): ?>
                                        <?php echo '<?php echo \Form::compositeSelect(\'' . $field . '\', $view_data[\'dataSource\'][\'' . $field . '\'], isset($view_data[\'input\'][\'' . $field . '\']) ? $view_data[\'input\'][\'' . $field . '\'] : \'\', array(\'class\' => \'form-control\')); ?>'; ?>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>    
                        <?php endforeach; ?>
                        <td>
                            <a title="<?php echo '<?php echo \Lang::get(\'common.view.actions.search.search\'); ?>'; ?>" class="pull-left searchSubmit"><span class="icon-data-search icon-data-2x text-danger"></span></a>
                            <a href="<?php echo '<?php echo \Route(camel_case($view_data[\'package\'] . \'_list_\' . $view_data[\'controller\'])); ?>'; ?>" class="pull-left" title="<?php echo '<?php echo \Lang::get(\'common.view.actions.clear.clear\'); ?>'; ?>"><span class="icon-data-clear icon-data-2x text-danger"></span></a>
                        </td>
                        <?php echo \Form::close(); ?>
                    </tr>
                    <?php echo '<?php endif; ?>'; ?>
                    <?php echo '<?php echo $view_data[\'controllerList\']; ?>'; ?>
                </tbody> 
            </table>
        </div>
    </div>
    <?php echo '<?php if (!array_key_exists(\'export\', $view_data)): ?>'; ?>
    <div class="row">
        <div class="col-md-12">
            <?php echo '<?php
        if ($view_data[\'paginationAppends\']) {
            echo $view_data[\'controller_model\']->appends($view_data[\'paginationAppends\'])->links();
        } else {
            echo $view_data[\'controller_model\']->links();
        }//E# if else statement                   
        ?>'
            ?>
        </div>
    </div>
    <?php echo '<?php endif; ?>'; ?>
</div>