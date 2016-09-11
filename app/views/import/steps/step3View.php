<div id="idStepView" data-step="3" class="row">
    <div class="col-md-12 commonMarginLeft10">
        <h4 class="commonFontWeightBold"><?php echo \Lang::choice('common.importView.records_found', $data_count = count($view_data['data_to_import']), array('count' => $data_count)); ?></h4>
        <table id="idTableRowsToImport" class="table table-bordered table-condensed table-responsive table-striped table-hover">
            <thead>
            <th><input type="checkbox" id="idImportSelectAll" value="1" checked></th>
            <th>#</th>
            <?php foreach ($view_data['view_fields'] as $key => $single_view_field): ?>
                <?php if ($key != 'id'): ?>
                    <th>
                        <?php echo \Str::title(str_replace('_', ' ', $key)); ?>
                        <?php echo \Form::hidden($key, $key, array('class' => 'classImportFields')); ?>
                    </th>
                <?php endif; ?>
            <?php endforeach; ?>
            <th><?php echo \Lang::get('common.view.actions.actions'); ?></th>
            </thead> 
            <tbody>
                <?php $index = 0; ?>
                <?php foreach ($view_data['data_to_import'] as $key => $single_row): ?>
                    <tr class="classImportRow" data-id="<?php echo $index; ?>">
                        <td><input type="checkbox" class="classImportSingleSelect" value="1" checked=""></td>
                        <td class="classImportRowNumber"><?php echo $index + 1; ?></td>
                        <?php foreach ($view_data['view_fields'] as $key => $single_view_field): ?>
                            <?php if ($key != 'id'): ?>
                                <?php if ($single_view_field[1] == 'select'): ?>
                                    <td><?php echo \Form::compositeSelect($key . '[]', $view_data['data_source'][$key], $single_row[$key], array('class' => 'form-control')); ?></td>
                                <?php else: ?>
                                    <td><?php echo \Form::text($key . '[]', $single_row[$key]); ?></td>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <td><a href="#" data-id="<?php echo $index; ?>" class="classImportDeleteRow"><span class="icon-data-delete icon-data-2x text-danger"></span></a></td>
                    </tr>
                    <?php $index++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>