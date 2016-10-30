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
        <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Lato:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
        <?php echo $inlineJs; ?>
        <?php foreach ($assets['css'] as $singleCss): ?>
            <?php echo $singleCss; ?>
        <?php endforeach ?>
        <?php if (App::environment('prod') && !$logged): ?>
        <?php endif; ?>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body data-spy="scroll">
        <?php echo $containerView; ?>
        <!--Load jQuery form CDN-->
        <!--1: Grab Google CDN's jQuery, if the CMS/Framework hasn't loaded it-->
    <!--UNCOMMENT    <script>window.jQuery || document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"><\/script>')</script>  
        <!--2: ...fall back to local if offline-->
        <script>window.jQuery || document.write('<script type="text/javascript" src="<?php echo \URL::to('/'); ?>/frontend/js/jquery-1.12.3.min.js"><\/script>')</script>
        @foreach($assets['js'] as $singleJs)
        {{ $singleJs }}
        @endforeach
    </body>
</html>