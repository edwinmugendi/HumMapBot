<!DOCTYPE html>
<html lang="{{ \Config::get('app.locale') }}">
    <head>
        <!-- Force latest IE rendering engine or ChromeFrame if installed -->
        <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
        <title><?php echo $title . ' - ' . \Config::get('product.name'); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="google-site-verification" content="C7nwk7Yj3r08X2fbjJa6HCFIBd652_Ja5YhwkrrpoLU" /><meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?php echo \Config::get('product.meta.description'); ?>"/>
        <meta name="keywords" content="<?php echo \Config::get('product.meta.keywords'); ?>"/>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo \URL::to('/') . '/img/favicon.ico'; ?>" />
        <?php echo $inlineJs; ?>
        <?php foreach ($assets['css'] as $singleCss): ?>
            <?php echo $singleCss; ?>
        <?php endforeach ?>
        <!--[if IE 7]>
        <![endif]-->
        <?php if (App::environment('prod') && !$logged): ?>
            <script>
                (function (i, s, o, g, r, a, m) {
                    i['GoogleAnalyticsObject'] = r;
                    i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
                    a = s.createElement(o),
                            m = s.getElementsByTagName(o)[0];
                    a.async = 1;
                    a.src = g;
                    m.parentNode.insertBefore(a, m)
                })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

                ga('create', 'UA-70326656-1', 'auto');
                ga('send', 'pageview');
            </script>
        <?php endif; ?>
    </head>
    <body>
        <?php echo $topBarPartial; ?>
        <?php echo $containerView; ?>
        <?php echo $footerBarPartial; ?>
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