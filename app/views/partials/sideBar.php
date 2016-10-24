<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="<?php echo \URL::route('dashboard'); ?>" class="site_title"><i class="fa fa-paw"></i> <span><?php echo $view_data['logged'] ? \Session::get('organization_selector_view') : \Config::get('product.name'); ?></span></a>
        </div>
        <div class="clearfix"></div>
        <?php if ($view_data['logged']): ?>
            <!-- menu prile quick info -->
            <div class="profile">
                <div class="profile_pic">
                    <img src="<?php echo asset('img/user.png'); ?>" alt="..." class="img-circle profile_img">
                </div>
                <div class="profile_info">
                    <span><?php echo \Lang::get('accounts::user.view.welcome'); ?>,</span>
                    <h2><?php echo $view_data['user']['full_name']; ?></h2>
                </div>
            </div>
            <!-- /menu prile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                <div class="menu_section">
                    <p>&nbsp;</p>
                    <ul class="nav side-menu">
                        <li class="<?php echo (array_key_exists(0, $view_data['segments']) && $view_data['segments'][0] == 'dashboard') ? 'current-page' : '' ?>"><a href="<?php echo \URL::route('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'form') ? 'current-page' : '' ?>"><a href="<?php echo \URL::route('surveysListForm'); ?>"><i class="fa fa-edit"></i> <?php echo \Lang::get('surveys::form.view.menu'); ?></a></li>
                        <?php foreach ($view_data['user_form_model'] as $single_form): ?>
                            <?php $snake_case_form_name = snake_case(\Str::lower($single_form['name'])); ?>
                            <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == $snake_case_form_name) ? 'current-page' : '' ?>"><a href="<?php echo \URL::route(camel_case('formsList_' . $snake_case_form_name)); ?>"><i class="fa fa-map-marker"></i>  <?php echo \Lang::get('forms::' . camel_case($snake_case_form_name) . '.view.menu'); ?></a></li>
                        <?php endforeach; ?>
                        <?php if ($view_data['user']['id'] == 1): ?> 
                            <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'question') ? 'current-page' : '' ?>"><a href="<?php echo \URL::route('surveysListQuestion'); ?>"><i class="fa fa-map-marker"></i>  <?php echo \Lang::get('surveys::question.view.menu'); ?></a></li>
                            <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'option') ? 'current-page' : '' ?>"><a href="<?php echo \URL::route('surveysListOption'); ?>"><i class="fa fa-map-marker"></i>  <?php echo \Lang::get('surveys::option.view.menu'); ?></a></li>
                            <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'session') ? 'current-page' : '' ?>"><a href="<?php echo \URL::route('surveysListSession'); ?>"><i class="fa fa-map-marker"></i>  <?php echo \Lang::get('surveys::session.view.menu'); ?></a></li>
                            <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'update') ? 'current-page' : '' ?>"><a href="<?php echo \URL::route('surveysListUpdate'); ?>"><i class="fa fa-map-marker"></i>  <?php echo \Lang::get('surveys::update.view.menu'); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <!-- /sidebar menu -->
            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
                <a data-toggle="tooltip" data-placement="top" title="<?php echo \Lang::get('accounts::user.view.signout'); ?>" href="<?php echo \URL::route('userSignOut'); ?>">
                    <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                </a>
            </div>
            <!-- /menu footer buttons -->
        <?php endif; ?>
    </div>
</div>