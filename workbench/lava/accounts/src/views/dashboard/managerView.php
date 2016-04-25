<div class="row">
    <div class="col-md-8 commonBorderColor commonBorderRadius">
        <h4 class="text-center" title="<?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.managerView.employee.users.help');?>"><a href="<?php echo \URL::route(camel_case('accounts_list_user')); ?>"><?php echo \Lang::choice($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.managerView.employee.users.link', count($view_data['org_structure']['employees']), array('count' => count($view_data['org_structure']['employees']))); ?></a></h4>
        <div class="row">
            <?php foreach (\Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.managerView.employee.employees_per') as $key => $single_pie): ?>
                <div class="col-md-6">
                    <?php $count = count($view_data['org_structure'][$key]); ?>
                    <p class="pieChartHeading commonColor" title="<?php echo $single_pie['help'];?>"> <a href="<?php echo \URL::route(camel_case('organizations_list_' . $single_pie['controller'])); ?>"><?php echo \Lang::choice($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.managerView.employee.employees_per.' . $key . '.heading', $count, array('count' => $count)); ?></a><p>    
                    <div id="<?php echo $single_pie['id'] ?>" class="pieChart"></div>
                </div>       
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-md-3">
        
    </div>
    <div class="col-md-3">
        
    </div>
</div>