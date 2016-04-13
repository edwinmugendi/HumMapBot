<?php if ($view_data['user']['role_id'] == 1): ?>
    <div class="row">
        <div class="col-md-12">
            <?php echo \HTML::link(\URL::route(camel_case($view_data['package'] . '_list_' . $view_data['controller'])), \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.link.list'),array('class'=>'btn btn-default')); ?>
        </div>
    </div>
<?php endif; ?>
<?php echo $view_data['form']; ?>
