<header id="header" class="header navbar-fixed-top">  
    <div class="container">    
        <h1 class="logo pull-left"><a class="scrollto" href="#promo"></a></h1>   
        <nav class="main-nav navbar-right" role="navigation">
            <div class="navbar-header text-center">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="toggle-title">Menu</span>
                    <span class="icon-bar-wrapper">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </span><!--//icon-bar-wrapper-->
                </button><!--//nav-toggle-->
            </div><!--//navbar-header-->
            <div id="navbar-collapse" class="navbar-collapse collapse text-center">
                <ul class="nav navbar-nav center-block">
                    <li class="nav-item"><a class="scrollto" href="#about">About</a></li>
                    <li class="nav-item"><a class="scrollto" href="#video">Video</a></li>
                    <li class="nav-item"><a class="scrollto" href="#contact">Contact</a></li>  
                    <li class="nav-item"><a href="<?php echo \URL::route('userRegistration') ?>">Login</a></li>
                    <li class="nav-item"><a href="<?php echo \URL::route('userRegistration') ?>#toregister">Sign up</a></li>
                </ul><!--//nav-->
            </div><!--//navabr-collapse-->
        </nav><!--//main-nav-->
    </div><!--//container-->
</header><!--//header-->
<section id="promo" class="section promo-section bg-gradient">
    <div class="container">
        <h2 class="headline text-center">Create Surveys <br class="visible-sm-block"> & Get Answers via Telegram</h2>
        <div class="overview-wrapper row">
            <div class="product-holder col-xs-12 col-md-5 col-md-offset-2" style="margin-bottom: 40px;">
                <a class="btn btn-lg btn-primary col-md-offset-2" href="http://telegram.me/surveychatbot" target="_blank">Go to @surveychatbot</a>
            </div><!--//product-holder-->
        </div><!--//overview-wrapper-->
        <div class="overview-wrapper row">
            <div class="product-holder col-xs-12 col-md-5 col-md-offset-3">
                <img class="img-responsive product-image" src="<?php echo asset('img/homePage/surveybot.png'); ?>" alt="">
                <div class="control text-center">
                    <a id="video-play-triggger" class="video-play-trigger" data-toggle="modal" data-target="#modal-video"><i class="fa fa-play"></i></a>                   
                </div>
            </div><!--//product-holder-->

        </div><!--//overview-wrapper-->
    </div><!--//container-->
</section><!--//promo-section-->
<section id="about" class="section about-section">
    <div class="container">
        <h2 class="section-title text-center">What is <?php echo \Config::get('product.name'); ?>?</h2>
        <div class="item">
            <div class="row">
                <div class="desc-holder col-xs-12 col-sm-5">
                    <h3 class="item-title">Create surveys</h3>
                    <div class="item-desc">
                        <p>Easily design and publish surveys online</p>
                        <p>
                            Get contacts, fill applications and serve your customers better by asking simple questions via Telegram
                        </p>
                        <h4 class="item-title">You can collect the following:</h4>
                        <ul class="list-unstyled list-custom">
                            <li><i class="fa fa-check"></i>Text</li>
                            <li><i class="fa fa-check"></i>Integer</li>
                            <li><i class="fa fa-check"></i>Decimal</li>
                            <li><i class="fa fa-check"></i>Radio (Single Select)</li>
                            <li><i class="fa fa-check"></i>GPS co-ordinates</li>
                            <li><i class="fa fa-check"></i>Photos</li>
                            <li><i class="fa fa-check"></i>Get data from API</li>
                        </ul>
                    </div>
                </div><!--//desc-holder-->
                <div class="figure-holder col-xs-12 col-sm-7">
                    <div class="figure-holder-inner figure-right">
                        <img class="img-responsive" src="<?php echo asset('img/homePage/questions.png'); ?>" alt="<?php echo \Config::get('product.name'); ?> list of questions">
                    </div><!--//figure-holder-inner-->
                </div><!--//figure-holder-->
            </div><!--//row-->
        </div><!--//item-->
        <div class="item">
            <div class="row">
                <div class="desc-holder col-xs-12 col-sm-5 col-md-push-7 col-sm-push-7 col-xs-push-0">
                    <h3 class="item-title">Get answers via Telegram</h3>
                    <div class="item-desc">
                        <p>Quickly and easily get responses via Telegram</p>
                        <ul class="list-unstyled list-custom">
                            <li><i class="fa fa-check"></i>It's easy</li>
                            <li><i class="fa fa-check"></i>It's fast</li>
                            <li><i class="fa fa-check"></i>It's reliable</li>
                            <li><i class="fa fa-check"></i>It's realtime</li>
                            <li><i class="fa fa-check"></i>Chatting is what millennials are used to</li>
                        </ul>
                    </div>
                </div><!--//desc-holder-->
                <div class="figure-holder figure-holder-left col-md-7 col-sm-7 col-xs-12 col-md-pull-5 col-sm-pull-5 col-xs-pull-0">
                    <div class="figure-holder-inner figure-left">
                        <img class="img-responsive" src="<?php echo asset('img/homePage/surveybot.png'); ?>" alt="<?php echo \Config::get('product.name'); ?> screenshot">
                    </div><!--//figure-holder-inner-->
                </div><!--//figure-holder-->
            </div><!--//row-->
        </div><!--//item-->
        <div class="item">
            <div class="row">
                <div class="desc-holder col-xs-12 col-sm-5">
                    <h3 class="item-title">Get answers in real time</h3>
                    <div class="item-desc">
                        <p>Get information in real time</p>
                        <ul class="list-unstyled list-custom">
                            <li><i class="fa fa-check"></i>Export data to CSV, PDF or Excel</li>
                            <li><i class="fa fa-check"></i>Receive data to your API</li>
                            <li><i class="fa fa-check"></i>Analyse your data immediately</li>
                            <li><i class="fa fa-check"></i>Get notified via email or incoming data</li>
                        </ul>
                    </div>
                </div><!--//desc-holder-->
                <div class="figure-holder col-xs-12 col-sm-7">
                    <div class="figure-holder-inner figure-right">
                        <img class="img-responsive" src="<?php echo asset('img/homePage/data.png'); ?>" alt="<?php echo \Config::get('product.name'); ?> collected data">
                    </div><!--//figure-holder-inner-->
                </div><!--//figure-holder-->
            </div><!--//row-->
        </div><!--//item-->
    </div><!--//container-->
</section><!--//section-->
<section id="video" class="updates-section section">
    <div class="container text-center">
        <h2 class="section-title">Video Demo</h2>
        <div class="item">
            <div class="item-content">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/3cTBGAu-3nk?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                </div>
            </div><!--//item-content-->
        </div><!--//item-->
    </div><!--//container-->
</section><!--//updates-section-->

<section id="contact" class="contact-section section">
    <h2 class="section-title text-center">Want to contact us?</h2>
    <div class="contact-form-container">    
        <p class="text-center"><i class="fa fa-envelope"></i>&nbsp;<a href="mailto:chat@sapamatech.com">chat@sapamatech.com</a></p>
    </div><!--//contact-form-container-->

</section><!--//contact-container-->

<section id="faq" class="section faq-section">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <h2 class="text-center">Sign up today to use <?php echo \Config::get('product.name'); ?></h2>
                <h3 class="text-center">Sign up to create surveys and collect data via Telegram</h3> 
                <a class="button btn btn-lg btn-primary center-block" style="width: 200px;" href="<?php echo \URL::route('userRegistration') ?>#toregister">Sign up</a>
                <h3 class="text-center">Already designed a form?</h3> 
                <a class="btn btn-lg btn-primary  center-block" style="width: 450px;" target="_blank" href="http://telegram.me/surveychatbot">Go to @surveychatbot</a>
            </div>
        </div><!--//row-->
    </div><!--//container-->
</section><!--//section-->

<!-- ******FOOTER****** --> 
<footer class="footer">
    <div class="container">
        <div class="footer-content text-center">
            <div class="social-container">
                <ul class="list-inline social-list">
                    <li><a target="_blank" href="https://twitter.com/surveychat"><i class="fa fa-twitter"></i></a></li>
                </ul><!--//social-list-->
            </div><!--//social-container-->
            <div class="copyright">&copy; <?php echo date('Y'); ?>&nbsp;<?php echo \Config::get('product.name'); ?> | All rights reserved </div>  
        </div><!--//footer-content--> 
    </div><!--//container-->
</footer><!--//footer-->

<!-- Video Modal -->
<div class="modal modal-video" id="modal-video" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 id="videoModalLabel" class="modal-title sr-only">Product Video</h4>
            </div>
            <div class="modal-body">
                <div class="video-container">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/3cTBGAu-3nk?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div><!--//video-container-->
            </div><!--//modal-body-->
        </div><!--//modal-content-->
    </div><!--//modal-dialog-->
</div><!--//modal-->
