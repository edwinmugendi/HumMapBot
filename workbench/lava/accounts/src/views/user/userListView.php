<div id="userListView" class="commonMaxWidth commonPositionCenter">
    <div class="commonFloatLeft">
        <h1><i class="icon-data-user icon-data-2x commonColorRed"></i><?php echo $heading = \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.heading'); ?></h1>
    </div>
    <div class="commonClearBoth">
        <table class="table-bordered table table-condensed table-hover">
            <caption><?php echo $heading;?></caption>
            <thead>
                <tr>
                    <th><?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.view.name'); ?></th>
                    <th><?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.view.email'); ?></th>
                    <th><?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.view.phone'); ?></th>
                    <th><?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.view.organization'); ?></th>
                    <th><?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.view.lastLogin'); ?></th>
                    <th><?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.view.verified'); ?></th>
                    <th><?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.view.country'); ?></th>
                    <th><?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.view.memberSince'); ?></th>
                    
                </tr>
            </thead>
            <tbody>
                <?php echo $viewData['controllerList']; ?> 
            </tbody>
        </table>
    </div>
    <div class="commonClearBoth">
        <?php echo $viewData['controllerModel']->links(); ?>
    </div>
</div>
