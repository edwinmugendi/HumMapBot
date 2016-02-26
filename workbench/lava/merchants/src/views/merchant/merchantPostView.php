<?php if ($view_data['user']['role_id'] == 1): ?>
    <div class="row">
        <div class="col-md-12">
            <a href="<?php echo \URL::route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])); ?>" class="btn btn-default"><i class="glyphicon glyphicon-chevron-left"></i>&nbsp;<?php echo \Lang::get('common.back_to_list'); ?></a>
            <?php if ($view_data['crudId'] == 2): ?>
                &nbsp;&nbsp;<a href="<?php echo \URL::route(camel_case($view_data['package'] . '_detailed_' . $view_data['controller']), array($view_data['controller_model']['id'])); ?>" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i>&nbsp;<?php echo \Lang::get('common.detailed_view'); ?></a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<?php echo $view_data['form']; ?>
