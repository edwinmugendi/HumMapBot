<div id="userListView" class="commonMaxWidth commonPositionCenter">
    <div class="commonFloatLeft">
        <h1><i class="icon-data-user icon-data-2x commonColorRed"></i><?php echo $heading = \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.heading'); ?></h1>
    </div>
    <div class="commonClearBoth">
        <table class="table-bordered table table-condensed table-hover">
            <caption><?php echo $heading;?></caption>
            <thead>
                <tr>
                    <th><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.name'); ?></th>
                    <th><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.email'); ?></th>
                    <th><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.phone'); ?></th>
                    <th><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.organization'); ?></th>
                    <th><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.lastLogin'); ?></th>
                    <th><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.verified'); ?></th>
                    <th><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.country'); ?></th>
                    <th><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.memberSince'); ?></th>
                    
                </tr>
            </thead>
            <tbody>
                <?php echo $view_data['controllerList']; ?> 
            </tbody>
        </table>
    </div>
    <div class="commonClearBoth">
        <?php echo $view_data['controller_model']->links(); ?>
    </div>
</div>
