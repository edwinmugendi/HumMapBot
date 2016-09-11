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
                        <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][0] == 'dashboard') ? 'active' : '' ?>">
                            <a href="<?php echo \URL::route('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                        </li>
                        <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'organization') ? 'active' : '' ?>">
                            <a href="<?php echo \URL::route('organizationsListOrganization'); ?>"><i class="fa fa-building"></i> Merchants</a>
                        </li>
                        <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'form') ? 'active' : '' ?>"><a href="<?php echo \URL::route('surveysListForm'); ?>"><i class="fa fa-map-marker"></i> Form</a></li>
                        <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'question') ? 'active' : '' ?>"><a href="<?php echo \URL::route('surveysListQuestion'); ?>"><i class="fa fa-map-marker"></i> Question</a></li>
                        <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'option') ? 'active' : '' ?>"><a href="<?php echo \URL::route('surveysListOption'); ?>"><i class="fa fa-map-marker"></i> Option</a></li>
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