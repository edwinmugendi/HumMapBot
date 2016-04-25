<div class="x_panel">
    <div class="row">
        <div class="col-md-12">
            <div class="btn-group"> 
                <a href="<?php echo '<?php echo \URL::route(camel_case($view_data[\'package\'] . \'_list_\' . $view_data[\'controller\']));?>'; ?>" type="button" class="btn btn-default" data-container="body" data-toggle="tooltip" data-placement="bottom" title="<?php echo '<?php echo \Lang::get(\'common.back_to_list\');?>' ?>"><i class="fa fa-chevron-left fa-2x" aria-hidden="true"></i></a>
                <?php echo '<?php if ($view_data[\'crudId\'] == 2): ?>'; ?>
                <a href="<?php echo '<?php echo \URL::route(camel_case($view_data[\'package\'] . \'_post_\' . $view_data[\'controller\']), array($view_data[\'controller_model\'][\'id\']));?>'; ?>" type="button" class="btn btn-default" data-container="body" data-toggle="tooltip" data-placement="bottom" title="<?php echo '<?php echo \Lang::get(\'common.edit\');?>' ?>"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></a>
                <?php echo '<?php endif; ?>'; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php echo '<?php echo $view_data[\'form\']; ?>'; ?>
        </div>
    </div>
</div>