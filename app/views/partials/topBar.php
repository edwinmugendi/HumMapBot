<?php if ($view_data['logged']): ?>
    <?php if (($view_data['user']['role_id'] == 2) || ($view_data['user']['role_id'] == 1)): ?>
        <nav class="navbar navbar-default container topBar" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <?php echo \Session::get('merchant_selector_view'); ?>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <?php if ($view_data['user']['role_id'] == 1): ?>
                            <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'merchant') ? 'active' : '' ?>"><a href="<?php echo \URL::route('merchantsListMerchant'); ?>">Merchants</a></li>
                        <?php endif; ?>
                        <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'location') ? 'active' : '' ?>"><a href="<?php echo \URL::route('merchantsListLocation'); ?>">Locations</a></li>
                        <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'product') ? 'active' : '' ?>"><a href="<?php echo \URL::route('productsListProduct'); ?>">Products</a></li>
                        <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'promotion') ? 'active' : '' ?>"><a href="<?php echo \URL::route('productsListPromotion'); ?>">Promotions</a></li>
                        <li class="<?php echo (array_key_exists(2, $view_data['segments']) && $view_data['segments'][2] == 'transaction') ? 'active' : '' ?>"><a href="<?php echo \URL::route('paymentsListTransaction'); ?>">Transactions</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">

                        </li>
                        <li><a href="<?php echo \URL::route('userSignOut'); ?>">Signout</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    <?php elseif ($view_data['user']['role_id'] == 3): ?>
        <nav class="navbar navbar-default container topBar" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo \URL::to('/'); ?>"><span class="commonColorRed"><?php echo $view_data['merchant']['name']; ?></span></a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo \URL::route('userSignOut'); ?>">Signout</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    <?php endif; ?>
<?php else: ?>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo \URL::to('/'); ?>"><span class="commonColorRed"><?php echo $product_name = \Config::get('product.name'); ?></span></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="scroll active"><a href="<?php echo \URL::to('/'); ?>#slider">Home</a></li>
                    <li class="scroll"><a href="<?php echo \URL::to('/'); ?>#features">Modules / Features</a></li>
                    <li class="scroll"><a href="<?php echo \URL::to('/'); ?>#benefits">Benefits</a></li>
                    <li class="scroll"><a href="<?php echo \URL::to('/'); ?>#pricing">Pricing</a></li>
                    <li class="scroll"><a href="<?php echo \URL::to('/'); ?>#about">About us</a></li>
                    <li class="scroll"><a href="<?php echo \URL::to('/'); ?>#contact">Contact us</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="fancyButton" href="http://demo.sapamahrm.com" target="_blank">Demo</a></li>
                    <li><a href="<?php echo \URL::route('userRegistration', array('login')); ?>">Login</a></li>
                    <li><a class="fancyButton" href="<?php echo \URL::route('userRegistration', array('register')); ?>">Get started for free</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
<?php endif; ?>

<?php if (\Session::has('notification')): ?>
    <?php
    $notification = \Session::get('notification');
    $show = '';
    $type = 'alert-' . $notification['type'];
    $message = $notification['message'];
    ?>
<?php else: ?>
    <?php
    $show = 'hidden';
    $type = '';
    $message = '';
    ?>
<?php endif; ?>
<div class="row <?php echo $show; ?>">
    <div class="col-md-8  col-md-offset-2">
        <p id="notification" class="alert text-center <?php echo $type; ?>"><span id="notificationMessage"><?php echo $message; ?></span>
            <button type="button" class="close" id="closeNotification"><i class="glyphicon glyphicon-trash"></i></button></p>
    </div>
</div>
