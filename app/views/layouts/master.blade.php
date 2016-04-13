<!DOCTYPE html>
<html lang="{{ \Config::get('app.locale') }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title . ' - ' . \Config::get('product.name'); ?></title>
        <meta name="description" content="<?php echo \Config::get('product.meta.description'); ?>"/>
        <meta name="keywords" content="<?php echo \Config::get('product.meta.keywords'); ?>"/>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo \URL::to('/') . '/img/favicon.ico'; ?>" />
        <?php echo $inlineJs; ?>
        <?php foreach ($assets['css'] as $singleCss): ?>
            <?php echo $singleCss; ?>
        <?php endforeach ?>
        <?php if (App::environment('prod') && !$logged): ?>
        <?php endif; ?>
        <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <?php if (trim($sideBarPartial)): ?>
                    <?php echo $sideBarPartial; ?>
                <?php endif; ?>
                <?php echo $topBarPartial; ?>
                <?php echo $containerView; ?>
            </div>
        </div>
        <div id="custom_notifications" class="custom-notifications dsp_none">
            <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
            </ul>
            <div class="clearfix"></div>
            <div id="notif-group" class="tabbed_notifications"></div>
        </div>
        <!--Load jQuery form CDN-->
        <!--1: Grab Google CDN's jQuery, if the CMS/Framework hasn't loaded it-->
    <!--UNCOMMENT    <script>window.jQuery || document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"><\/script>')</script>  
        <!--2: ...fall back to local if offline-->
        <script>window.jQuery || document.write('<script type="text/javascript" src="<?php echo \URL::to('/'); ?>/js/jquery-1.9.0.min.js"><\/script>')</script>
        @foreach($assets['js'] as $singleJs)
        {{ $singleJs }}
        @endforeach        
    </body>
</html>