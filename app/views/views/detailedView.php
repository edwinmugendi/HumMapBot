<?php echo '<?php if (!array_key_exists(\'export\', $view_data[\'input\'])): ?>'; ?>
<div class="row">
    <div class="col-md-12">
        <a href="<?php echo '<?php echo \URL::route(camel_case($view_data[\'package\'] . \'_list_\' . $view_data[\'controller\'])); ?>'; ?>" class="btn btn-default"><i class="glyphicon glyphicon-chevron-left"></i>&nbsp;<?php echo '<?php echo \Lang::get(\'common.back_to_list\'); ?>'; ?></a>
        &nbsp;&nbsp;<a href="<?php echo '<?php echo \URL::route(camel_case($view_data[\'package\'] . \'_post_\' . $view_data[\'controller\']), array($view_data[\'controller_model\'][\'id\'])); ?>'; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-plus-sign"></i>&nbsp;<?php echo '<?php echo \Lang::get(\'common.edit\'); ?>'; ?></a>
        &nbsp;&nbsp;<button class="deleteRow btn btn-danger" type="button" data-ids="<?php echo '<?php echo $view_data[\'controller_model\'][\'id\']; ?>'; ?>"><i class="glyphicon glyphicon-trash"></i>&nbsp;<?php echo '<?php echo \Lang::get($view_data[\'package\'] . \'::\' . $view_data[\'controller\'] . \'.view.actions.delete.delete\'); ?>'; ?></button>
        &nbsp;&nbsp;<div class="btn-group">
            <button type="button" class="btn btn-success"><i class="glyphicon glyphicon-share"></i>&nbsp;<?php echo '<?php echo \Lang::get(\'common.view.actions.export.export\'); ?>'; ?></button>
            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><?php echo '<?php echo HTML::link(\URL::route(camel_case($view_data[\'package\'] . \'_detailed_\' . $view_data[\'controller\']), array(\'id\' => $view_data[\'controller_model\'][\'id\'])) . \'?export=pdf\', \Lang::get(\'common.view.actions.pdf.pdf\'), array(\'id\' => \'idPdf\', \'title\' => \Lang::get(\'common.view.actions.pdf.desc\'))); ?>'; ?></li>
                <li><?php echo '<?php echo HTML::link(\URL::route(camel_case($view_data[\'package\'] . \'_list_\' . $view_data[\'controller\']), array(\'id\' => $view_data[\'controller_model\'][\'id\'])) . \'&export=xls\', \Lang::get(\'common.view.actions.xls.xls\'), array(\'id\' => \'idXls\', \'title\' => \Lang::get(\'common.view.actions.xls.desc\'))); ?>'; ?></li>
                <li><?php echo '<?php echo HTML::link(\URL::route(camel_case($view_data[\'package\'] . \'_list_\' . $view_data[\'controller\']), array(\'id\' => $view_data[\'controller_model\'][\'id\'])) . \'&export=csv\', \Lang::get(\'common.view.actions.csv.csv\'), array(\'id\' => \'idCsv\', \'title\' => \Lang::get(\'common.view.actions.csv.desc\'))); ?>'; ?></li>
            </ul>
        </div>
        &nbsp;&nbsp;<a href="<?php echo '<?php echo \URL::route(camel_case($view_data[\'package\'] . \'_detailed_\' . $view_data[\'controller\']), array(\'id\' => $view_data[\'controller_model\'][\'id\'])) . \'?export=print\'; ?>'; ?>" class="btn btn-info" id="idPrint" target="_blank"><i class="glyphicon glyphicon-share"></i>&nbsp;<?php echo '<?php echo \Lang::get(\'common.view.actions.print.print\'); ?>'; ?></a>
    </div>
</div>
<?php echo '<?php endif; ?>'; ?>
<div class="row commonMarginTop20">
    <div class="x_panel">
        <div class="col-md-6">
            <div class="commonBorderRadius commonBorderColor commonPadding5">
                <p class="commonFontWeightBold"><?php echo '<?php echo $view_data[\'title\']; ?>'; ?></p>
                <table class="table table-condensed table-striped table-hover table-responsive">
                    <tbody>
                        <?php echo '<?php foreach ($view_data[\'viewFields\'] as $key => $single_field): ?>'; ?>
                        <tr>
                            <td>
                                <?php echo '<?php echo \Lang::get($view_data[\'package\'] . \'::\' . $view_data[\'controller\'] . \'.view.field.\' . $key); ?>'; ?>
                            </td>
                            <td>
                                <?php echo '<?php if (array_key_exists(1, $single_field) && ($single_field[1] == \'select\')): ?>
                                    <?php $field = $key . \'_text\'; ?>
                                    <?php echo $view_data[\'controller_model\'][$field]; ?>
                                <?php else: ?>
                                    <?php echo $view_data[\'controller_model\'][$key]; ?>
                                <?php endif; ?>'; ?>
                            </td>
                        </tr>
                        <?php echo '<?php endforeach; ?>'; ?>
                    </tbody>
                </table>    
            </div>
        </div>
        <?php if ($imageable): ?>
            <div class="col-md-6">
                <div class="commonBorderRadius commonBorderColor commonPadding5">
                    <p class="commonFontWeightBold"><?php echo '<?php echo \Lang::get(\'media::media.view.attached_documents\'); ?>'; ?></p>
                    <div class="commonBorderTop">
                        <?php echo '<?php echo $view_data[\'dataSource\'][\'mediaView\']; ?>'; ?>  
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>