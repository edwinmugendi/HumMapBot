<!DOCTYPE html>
<html lang="{{ \Config::get('app.locale') }}">
    <head>
        <!-- Force latest IE rendering engine or ChromeFrame if installed -->
        <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
        <title><?php echo $title . ' - ' . \Config::get('product.name'); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <meta name="description" content="<?php echo \Lang::get('product.meta.description'); ?>"/>
        <meta name="keywords" content="<?php echo \Lang::get('product.meta.keywords'); ?>"/>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo \URL::to('/') . '/img/favicon.ico'; ?>" />
        <?php echo $inlineJs; ?>
        <?php foreach ($assets['css'] as $singleCss): ?>
            <?php echo $singleCss; ?>
        <?php endforeach ?>
        <!--[if IE 7]>
        <![endif]-->
    </head>
    <body>
        <div id="wrap" class="commonClearBoth">
            <?php echo $topBarPartial; ?>
            <?php echo $sideBarPartial; ?>
            <?php echo $contentView; ?>
        </div>
        <?php echo $footerBarPartial; ?>

        <!--Load jQuery form CDN-->
        <!--1: Grab Google CDN's jQuery, if the CMS/Framework hasn't loaded it-->
    <!--UNCOMMENT    <script>window.jQuery || document.write('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"><\/script>')</script>  
        <!--2: ...fall back to local if offline-->
        <script>window.jQuery || document.write('<script type="text/javascript" src="<?php echo \URL::to('/'); ?>/js/jquery-1.9.0.min.js"><\/script>')</script>
        @foreach($assets['js'] as $singleJs)
        {{ $singleJs }}
        @endforeach        
    </body>
</html>