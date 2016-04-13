<?php echo '<?php if (!array_key_exists(\'export\', $view_data)): ?>'; ?>
<div class="row">
    <div class="col-md-6">
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
        <?php echo '<?php echo Form::button(\Lang::get($view_data[\'package\'] . \'::\' . $view_data[\'controller\'] . \'.view.actions.delete.delete\'), array(\'class\' => \'btn btn-danger\', \'id\' => \'idDeleteRow\', \'disabled\')); ?>'; ?>
        <div class="btn-group">
            <button type="button" class="btn btn-success"><?php echo '<?php echo \Lang::get(\'common.view.actions.export.export\'); ?>'; ?></button>
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><?php echo '<?php echo HTML::link(\URL::route(camel_case($view_data[\'package\'] . \'_list_\' . $view_data[\'controller\']), $view_data[\'paginationAppends\']) . \'&export=pdf\', \Lang::get(\'common.view.actions.pdf.pdf\'), array(\'id\' => \'idPdf\', \'title\' => \Lang::get(\'common.view.actions.pdf.desc\'))); ?>'; ?></li>
                <li><?php echo '<?php echo HTML::link(\URL::route(camel_case($view_data[\'package\'] . \'_list_\' . $view_data[\'controller\']), $view_data[\'paginationAppends\']) . \'&export=xls\', \Lang::get(\'common.view.actions.xls.xls\'), array(\'id\' => \'idXls\', \'title\' => \Lang::get(\'common.view.actions.xls.desc\'))); ?>'; ?></li>
                <li><?php echo '<?php echo HTML::link(\URL::route(camel_case($view_data[\'package\'] . \'_list_\' . $view_data[\'controller\']), $view_data[\'paginationAppends\']) . \'&export=csv\', \Lang::get(\'common.view.actions.csv.csv\'), array(\'id\' => \'idCsv\', \'title\' => \Lang::get(\'common.view.actions.csv.desc\'))); ?>'; ?></li>
            </ul>
        </div>
        <?php echo '<?php echo HTML::link(\URL::route(camel_case($view_data[\'package\'] . \'_list_\' . $view_data[\'controller\']), $view_data[\'paginationAppends\']) . \'&export=print\', \Lang::get(\'common.view.actions.print.print\'), array(\'id\' => \'idPrint\', \'target\' => \'_blank\', \'class\' => \'btn btn-info\', \'title\' => \Lang::get(\'common.view.actions.print.desc\'))); ?>'; ?>
    </div>
</div>
<?php echo '<?php endif; ?>'; ?>
<div class="row commonMarginTop5">
    <div class="col-md-12 table-responsive">
        <div class="x_panel">
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
