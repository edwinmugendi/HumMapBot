<div class="top_nav">
    <div class="nav_menu">
        <nav class="" role="navigation">
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <?php if ($view_data['logged']): ?>
                <ul class="nav navbar-nav navbar-right">
                    <li class="">
                        <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo asset('img/user.png'); ?>" alt=""><?php echo $view_data['user']['first_name'] . ' ' . $view_data['user']['last_name']; ?>
                            <span class=" fa fa-angle-down"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                            <li><a href="javascript:;">  Profile</a>
                            </li>
                            <li><a href="<?php echo \URL::route('userSignOut'); ?>"><i class="fa fa-sign-out pull-right"></i><?php echo \Lang::get('accounts::user.view.signout'); ?></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
        </nav>
    </div>

</div>