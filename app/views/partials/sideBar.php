<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="<?php echo \URL::route('paymentsListTransaction'); ?>" class="site_title"><i class="fa fa-paw"></i> <span><?php echo $view_data['logged'] ? \Session::get('merchant_selector_view') : \Config::get('product.name'); ?></span></a>
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
                    <h2><?php echo $view_data['user']['first_name'] . ' ' . $view_data['user']['last_name']; ?></h2>
                </div>
            </div>
            <!-- /menu prile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                <div class="menu_section">
                    <p>&nbsp;</p>
                    <ul class="nav side-menu">
                        <?php if ($view_data['user']['role_id'] == 1): ?>
                            <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'merchant') ? 'active' : '' ?>">
                                <a href="<?php echo \URL::route('merchantsListMerchant'); ?>"><i class="fa fa-laptop"></i> Merchants</a>
                            </li>
                        <?php endif; ?>
                        <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'location') ? 'active' : '' ?>"><a href="<?php echo \URL::route('merchantsListLocation'); ?>"><i class="fa fa-laptop"></i> Locations</a></li>
                        <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'product') ? 'active' : '' ?>"><a href="<?php echo \URL::route('productsListProduct'); ?>"><i class="fa fa-laptop"></i> Products</a></li>
                        <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'promotion') ? 'active' : '' ?>"><a href="<?php echo \URL::route('productsListPromotion'); ?>"><i class="fa fa-laptop"></i> Promotions</a></li>
                        <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'transaction') ? 'active' : '' ?>"><a href="<?php echo \URL::route('paymentsListTransaction'); ?>"><i class="fa fa-laptop"></i> Transactions</a></li>
                        <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'user') ? 'active' : '' ?>"><a href="<?php echo \URL::route('accountsListUser'); ?>"><i class="fa fa-laptop"></i> Users</a></li>
                        <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'vehicle') ? 'active' : '' ?>"><a href="<?php echo \URL::route('accountsListVehicle'); ?>"><i class="fa fa-laptop"></i> Vehicles</a></li>
                        <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'card') ? 'active' : '' ?>"><a href="<?php echo \URL::route('paymentsListCard'); ?>"><i class="fa fa-laptop"></i> Cards</a></li>
                        <?php if ($view_data['user']['role_id'] == 1): ?>
                            <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'referral') ? 'active' : '' ?>"><a href="<?php echo \URL::route('productsListReferral'); ?>"><i class="fa fa-laptop"></i> Referrals</a></li>
                            <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'lead') ? 'active' : '' ?>"><a href="<?php echo \URL::route('accountsListLead'); ?>"><i class="fa fa-laptop"></i> Leads</a></li>
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