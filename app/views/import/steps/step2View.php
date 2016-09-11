<div id="idStepView" data-step="2" class="row">
    <div class="col-md-4 commonMarginLeft10">
        <h4 class="commonFontWeightBold"><?php echo \Lang::get('common.importView.map_your_fields', array('product' => \Config::get('product.name'))); ?></h4>
        <table id="idImportMapTable" class="table table-bordered table-condensed table-responsive table-striped table-hover">
            <thead>
            <th><?php echo \Lang::get('common.importView.product_fields', array('product' => \Config::get('product.name'))); ?></th>
            <th><?php echo \Lang::get('common.importView.imported_field_header'); ?>
            </th>
            </thead> 
            <tbody>
                <?php if (is_array($view_data['your_fields_select'])): ?>
                    <?php foreach ($view_data['view_fields'] as $key => $single_view_field): ?>
                        <?php if ($key != 'id'): ?>
                            <tr class="singleImportRow">
                                <td data-system-field="<?php echo $key; ?>"><?php echo \Str::title(str_replace('_', ' ', $key)); ?></td>
                                <td><?php echo \Form::compositeSelect($key, $view_data['your_fields_select'], $key, array('class' => 'form-control ')); ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>