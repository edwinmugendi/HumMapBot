<div class="x_panel">
    <?php if (!array_key_exists('export', $view_data['input'])): ?>    <div class="row">
        <div class="col-md-12">
            <div class="btn-group"> 
                <a href="<?php echo \URL::route(camel_case($view_data['package'] . '_list_' . $view_data['controller']));?>" type="button" class="btn btn-default" data-container="body" data-toggle="tooltip" data-placement="bottom" title="<?php echo \Lang::get('common.back_to_list');?>"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
                <a href="<?php echo \URL::route(camel_case($view_data['package'] . '_detailed_' . $view_data['controller']), array('id' => $view_data['controller_model']['id'])) . '?export=pdf';?>" type="button" class="btn btn-default" data-container="body" data-toggle="tooltip" data-placement="bottom" title="<?php echo \Lang::get('common.view.actions.pdf.pdf');?>"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
                <a href="<?php echo \URL::route(camel_case($view_data['package'] . '_detailed_' . $view_data['controller']), array('id' => $view_data['controller_model']['id'])) . '?export=print';?>" target="_blank" type="button" class="btn btn-default" data-container="body" data-toggle="tooltip" data-placement="bottom" title="<?php echo \Lang::get('common.view.actions.print.print');?>"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
                <a href="<?php echo \URL::route(camel_case($view_data['package'] . '_list_' . $view_data['controller']), array('id' => $view_data['controller_model']['id'])) . '&export=xls';?>" target="_blank" type="button" class="btn btn-default" data-container="body" data-toggle="tooltip" data-placement="bottom" title="<?php echo \Lang::get('common.view.actions.xls.xls');?>"><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
    <?php endif; ?>    <div class="row commonMarginTop20">
        <div class="col-md-6">
            <div class="commonBorderRadius commonBorderColor commonPadding5">
                <p class="commonFontWeightBold"><?php echo $view_data['title']; ?></p>
                <table class="table table-condensed table-striped table-hover table-responsive">
                    <tbody>
                        <?php foreach ($view_data['viewFields'] as $key => $single_field): ?>                        <tr>
                            <td>
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.' . $key); ?>                            </td>
                            <td>
                                <?php if (array_key_exists(1, $single_field) && ($single_field[1] == 'select')): ?>
                                    <?php $field = $key . '_text'; ?>
                                    <?php echo $view_data['controller_model'][$field]; ?>
                                <?php else: ?>
                                    <?php echo $view_data['controller_model'][$key]; ?>
                                <?php endif; ?>                            </td>
                        </tr>
                        <?php endforeach; ?>                    </tbody>
                </table>    
            </div>
                    </div>
    </div>
</div>