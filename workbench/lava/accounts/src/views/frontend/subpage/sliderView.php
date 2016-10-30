<!-- ******HEADER****** --> 
<header id="header" class="header navbar-fixed-top">  
    <div class="container ">    
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
                    <li class="nav-item"><a class="scrollto" href="#v">Video</a></li>
                    <li class="nav-item"><a class="scrollto" href="#updates">Updates</a></li>  
                    <li class="nav-item"><a class="scrollto" href="#timeline">Timeline</a></li> 
                    <li class="nav-item"><a class="scrollto" href="#team">Team</a></li>                                              
                    <li class="nav-item"><a class="scrollto" href="#faq">FAQ</a></li>
                </ul><!--//nav-->
            </div><!--//navabr-collapse-->
        </nav><!--//main-nav-->
    </div><!--//container-->
</header><!--//header-->



<section class="signup-wrapper">
    <div class="container">
        <form class="signup-form form-inline">
            <h4 class="form-title">Sign up to our updates for the chance to win a free product</h4>
            <label class="sr-only" for="semail">Your Email</label>
            <input type="text" id="semail" class="form-control email-field" placeholder="Enter your email address" name="email" required><button type="submit" class="btn"><i class="fa fa-paper-plane"></i></button>
        </form><!--//signup-form-->
    </div><!--//container-->
</section><!--//signup-wrapper-->

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

<section id="rewards" class="rewards-section section bg-gradient">
    <div class="container text-center">
        <h2 class="section-title">Rewards</h2>
        <div class="row">
            <div class="item item-1 col-md-4 col-sm-6 col-xs-12">
                <div class="item-inner">
                    <div class="upper-wrapper">
                        <h3 class="item-title"><span class="price">$20</span><span class="offer-name">Early Bird Bundle</span></h3>
                        <div class="item-details">
                            Vestibulum fringilla pede sit amet augue. In turpis. Pellentesque posuere. Praesent turpis. Aenean posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin.
                        </div><!--//item-details-->

                    </div><!--//upper-wrapper-->
                    <div class="backers"><span class="pe-7s-users icon pe-icon"></span> 120 backers</div>
                    <a class="btn btn-primary btn-oval" href="#">Get this Now</a>
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item item-2 col-md-4 col-sm-6 col-xs-12">
                <div class="item-inner">
                    <div class="upper-wrapper">
                        <h3 class="item-title"><span class="price">$50</span><span class="offer-name">Early Bird Bundle</span><span class="label label-featured">Featured</span></h3>
                        <div class="item-details">
                            Vestibulum fringilla pede sit amet augue. In turpis. Pellentesque posuere. Praesent turpis. Aenean posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin.
                        </div><!--//item-details-->
                    </div><!--//upper-wrapper-->
                    <div class="backers"><span class="pe-7s-users icon pe-icon"></span> 320 backers</div>
                    <a class="btn btn-primary btn-oval" href="#">Get this Now</a>
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item item-3 col-md-4 col-sm-6 col-xs-12">
                <div class="item-inner">
                    <div class="upper-wrapper">
                        <h3 class="item-title"><span class="price">$100</span><span class="offer-name">Special Bundle</span></h3>
                        <div class="item-details">
                            Vestibulum fringilla pede sit amet augue. In turpis. Pellentesque posuere. Praesent turpis. Aenean posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin.
                        </div><!--//item-details-->
                    </div><!--//upper-wrapper-->
                    <div class="backers"><span class="pe-7s-users icon pe-icon"></span> 30 backers</div>
                    <a class="btn btn-primary btn-oval" href="#">Get this Now</a>
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item item-4 col-md-4 col-sm-6 col-xs-12">
                <div class="item-inner">
                    <div class="upper-wrapper">
                        <h3 class="item-title"><span class="price">$500</span><span class="offer-name">Special Bundle</span></h3>
                        <div class="item-details">
                            Vestibulum fringilla pede sit amet augue. In turpis. Pellentesque posuere. Praesent turpis. Aenean posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin.
                        </div><!--//item-details-->

                    </div><!--//upper-wrapper-->
                    <div class="backers"><span class="pe-7s-users icon pe-icon"></span> 200 backers</div>
                    <a class="btn btn-primary btn-oval" href="#">Get this Now</a>
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item item-5 col-md-4 col-sm-6 col-xs-12">
                <div class="item-inner">
                    <div class="upper-wrapper">
                        <h3 class="item-title"><span class="price">$1,000</span><span class="offer-name">Special Bundle</span></h3>
                        <div class="item-details">
                            Vestibulum fringilla pede sit amet augue. In turpis. Pellentesque posuere. Praesent turpis. Aenean posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin.
                        </div><!--//item-details-->
                    </div><!--//upper-wrapper-->
                    <div class="backers"><span class="pe-7s-users icon pe-icon"></span> 15 backers</div>
                    <a class="btn btn-primary btn-oval" href="#">Get this Now</a>
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item item-6 col-md-4 col-sm-6 col-xs-12">
                <div class="item-inner">
                    <div class="upper-wrapper">
                        <h3 class="item-title"><span class="price">$3,000</span><span class="offer-name">Special Bundle</span></h3>
                        <div class="item-details">
                            Vestibulum fringilla pede sit amet augue. In turpis. Pellentesque posuere. Praesent turpis. Aenean posuere, tortor sed cursus feugiat, nunc augue blandit nunc, eu sollicitudin.
                        </div><!--//item-details-->
                    </div><!--//upper-wrapper-->
                    <div class="backers"><span class="pe-7s-users icon pe-icon"></span> 8 backers</div>
                    <a class="btn btn-primary btn-oval" href="#">Get this Now</a>
                </div><!--//item-inner-->
            </div><!--//item-->
        </div><!--//row-->
    </div><!--//container-->
</section><!--//rewards-section-->

<section id="updates" class="updates-section section">
    <div class="container text-center">
        <h2 class="section-title">Updates</h2>
        <div class="item">
            <h3 class="item-title">We are now manufacturing our product!</h3>
            <div class="item-meta">Posted 1 day ago</div>
            <div class="item-content">
                <p>Fusce id purus. Ut varius tincidunt libero. Phasellus dolor. Maecenas vestibulum mollis diam. Pellentesque ut neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In dui magna, posuere eget, vestibulum et, tempor auctor, justo. In ac felis quis tortor malesuada pretium. Pellentesque auctor neque nec urna. Proin sapien <a href="#">link example</a>, porta a, auctor quis, euismod ut, mi. Aenean viverra rhoncus pede. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut non enim eleifend felis pretium feugiat. Vivamus quis mi.</p>
                <div class="img-holder center-block">
                    <img class="img-responsive" src="assets/images/update-3.jpg" alt="">
                </div>
            </div><!--//item-content-->
        </div><!--//item-->
        <div class="item">
            <h3 class="item-title">We've improved the design</h3>
            <div class="item-meta">Posted 23 days ago</div>
            <div class="item-content">
                <p>Fusce id purus. Ut varius tincidunt libero. Phasellus dolor. Maecenas vestibulum mollis diam. Pellentesque ut neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In dui magna, posuere eget, vestibulum et, tempor auctor, justo. In ac felis quis tortor malesuada pretium. Pellentesque auctor neque nec urna. Proin sapien ipsum, porta a, auctor quis, euismod ut, mi. Aenean viverra rhoncus pede. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut non enim eleifend felis pretium feugiat. Vivamus quis mi.</p>
                <div class="img-holder center-block">
                    <img class="img-responsive" src="assets/images/update-1.jpg" alt="">
                </div>
            </div><!--//item-content-->
        </div><!--//item-->
        <div class="item">
            <h3 class="item-title">Help us to make it happen</h3>
            <div class="item-meta">Posted 1 month ago</div>
            <div class="item-content">
                <p>Fusce id purus. Ut varius tincidunt libero. Phasellus dolor. Maecenas vestibulum mollis diam. Pellentesque ut neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In dui magna, posuere eget, vestibulum et, tempor auctor, justo. In ac felis quis tortor malesuada pretium. Pellentesque auctor neque nec urna. Proin sapien ipsum, porta a, auctor quis, euismod ut, mi. Aenean viverra rhoncus pede. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut non enim eleifend felis pretium feugiat. Vivamus quis mi.</p>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/NkV0RHA9GKo?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                </div>
            </div><!--//item-content-->
        </div><!--//item-->
        <a class="btn btn-secondary btn-oval" href="#">Load More</a>
    </div><!--//container-->
</section><!--//updates-section-->

<section id="timeline" class="section timeline-section bg-gradient">
    <div class="container">
        <h2 class="section-title text-center">Production Timeline</h2>

        <div class="timeline-container">
            <div class="timeline-item clearfix">
                <div class="timeline-icon">
                    <i class="fa fa-flask icon"></i>
                </div>
                <div class="timeline-content">
                    <div class="time">May 2016</div>
                    <h4 class="title">1st Generation Prototype</h4>
                    <div class="desc">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.  					              
                    </div>
                </div><!--//timeline-content-->
            </div><!--//timeline-item-->

            <div class="timeline-item clearfix">
                <div class="timeline-icon">
                    <i class="fa fa-hourglass-end icon"></i>
                </div>
                <div class="timeline-content right">
                    <div class="time">June 2016</div>
                    <h4 class="title">2nd Generation Prototype</h4>
                    <div class="desc">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.   					              
                    </div>
                </div><!--//timeline-content-->
            </div><!--//timeline-item-->

            <div class="timeline-item clearfix">
                <div class="timeline-icon">
                    <i class="fa fa-bug icon"></i>
                </div>
                <div class="timeline-content">
                    <div class="time">July 2016</div>
                    <h4 class="title">Beta Tests</h4>
                    <div class="desc">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.    					              
                    </div>
                </div><!--//timeline-content-->
            </div><!--//timeline-item-->

            <div class="timeline-item clearfix">
                <div class="timeline-icon">
                    <i class="fa fa-bullseye icon"></i>
                </div>
                <div class="timeline-content right">
                    <div class="time">August 2016</div>
                    <h4 class="title">Sample Manufacturing</h4>
                    <div class="desc">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.   					              
                    </div>
                </div><!--//timeline-content-->
            </div><!--//timeline-item-->

            <div class="timeline-item clearfix">
                <div class="timeline-icon">
                    <i class="fa fa-users icon"></i>
                </div>
                <div class="timeline-content">
                    <div class="time">Sep 2016</div>
                    <h4 class="title">Collecting Feedback</h4>
                    <div class="desc">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.   					              
                    </div>
                </div><!--//timeline-content-->
            </div><!--//timeline-item-->

            <div class="timeline-item clearfix">
                <div class="timeline-icon">
                    <i class="fa fa-gift icon"></i>
                </div>
                <div class="timeline-content right">
                    <div class="time">Oct 2016</div>
                    <h4 class="title">Launch Party</h4>
                    <div class="desc">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.   					              
                    </div>
                </div><!--//timeline-content-->
            </div><!--//timeline-item-->

            <div class="timeline-item clearfix">
                <div class="timeline-icon">
                    <i class="fa fa-rocket icon"></i>
                </div>
                <div class="timeline-content">
                    <div class="time">Nov 2016</div>
                    <h4 class="title">Shipping First Product Samples</h4>
                    <div class="desc">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.   					              
                    </div>
                </div><!--//timeline-content-->
            </div><!--//timeline-item-->

            <div class="timeline-item">
                <div class="timeline-icon complete">
                    <i class="fa fa-check icon"></i>
                </div>
            </div><!--//timeline-item-->

        </div><!--//timeline-container-->

    </div><!--//container-->
</section><!--//timeline-section-->

<section id="team" class="section team-section">
    <div class="container text-center">
        <h2 class="section-title">Our Team</h2>
        <div class="members-container row">
            <div class="item col-xs-6">
                <div class="item-inner">
                    <div class="profile-holder">
                        <img src="assets/images/team/member-1.png" alt="">
                    </div><!--//profile-holder-->
                    <div class="content-holder">
                        <h4 class="name">Jim Cheng</h4>
                        <div class="role">Co-founder</div>
                        <div class="desc">
                            Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius.
                        </div>
                    </div><!--//content-holder-->
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item col-xs-6">
                <div class="item-inner">
                    <div class="profile-holder">
                        <img src="assets/images/team/member-3.png" alt="">
                    </div><!--//profile-holder-->
                    <div class="content-holder">
                        <h4 class="name">Roger Shaw</h4>
                        <div class="role">Co-founder</div>
                        <div class="desc">
                            Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius.
                        </div>
                    </div><!--//content-holder-->
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item col-xs-6">
                <div class="item-inner">
                    <div class="profile-holder">
                        <img src="assets/images/team/member-2.png" alt="">
                    </div><!--//profile-holder-->
                    <div class="content-holder">
                        <h4 class="name">Nancy Graham</h4>
                        <div class="role">Product Designer</div>
                        <div class="desc">
                            Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius.
                        </div>
                    </div><!--//content-holder-->
                </div><!--//item-inner-->
            </div><!--//item-->
            <div class="item col-xs-6">
                <div class="item-inner">
                    <div class="profile-holder">
                        <img src="assets/images/team/member-4.png" alt="">
                    </div><!--//profile-holder-->
                    <div class="content-holder">
                        <h4 class="name">Sean Wells</h4>
                        <div class="role">Product Engineer</div>
                        <div class="desc">
                            Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius.
                        </div>
                    </div><!--//content-holder-->
                </div><!--//item-inner-->
            </div><!--//item-->
        </div><!--//row-->
    </div><!--//container-->
</section><!--//team-section-->

<section id="contact" class="contact-section section">
    <h2 class="section-title text-center">Want to contact us?</h2>
    <div class="contact-form-container">    
        <div class="contact-form-intro">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes.</div>                       
        <form class="contact-form">   
            <div class="row">           
                <div class="form-group col-xs-12 col-sm-6 ">
                    <label class="sr-only" for="name">Name</label>
                    <input id="name" name="name" type="text" class="form-control" placeholder="Your Name" minlength="2" required>
                </div><!--//form-group-->
                <div class="form-group col-xs-12 col-sm-6 ">
                    <label class="sr-only" for="email">Email</label>
                    <input id="email" name="email" type="email" class="form-control" placeholder="Your Email" required>
                </div><!--//form-group-->
            </div><!--//row-->
            <div class="form-group">
                <label class="sr-only" for="message">Message</label>
                <textarea id="message" name="message" class="form-control" rows="10" placeholder="Enter your message" required></textarea>
            </div><!--//form-group-->
            <div class="text-center">
                <button type="submit" class="btn btn-secondary btn-oval btn-cta">Send Message</button>
            </div>
        </form><!--//contact-form-->                 
    </div><!--//contact-form-container-->

</section><!--//contact-container-->

<section id="faq" class="section faq-section">
    <div class="container">
        <h2 class="section-title text-center">Frequently Asked Questions</h2>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title"><a data-parent="#accordion"
                                                   data-toggle="collapse" class="panel-toggle" href="#faq1"><i class="fa fa-question-circle"></i>Can I viverra sit amet quam eget lacinia?</a></h4>
                    </div>

                    <div class="panel-collapse collapse" id="faq1">
                        <div class="panel-body">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam rutrum ut erat a ultricies. Phasellus non auctor nisi, id aliquet lectus. Vestibulum libero eros, aliquet at tempus ut, scelerisque sit amet nunc. Vivamus id porta neque, in pulvinar ipsum. Vestibulum sit amet quam sem. Pellentesque accumsan consequat venenatis. Pellentesque sit amet justo dictum, interdum odio non, dictum nisi. Fusce sit amet turpis eget nibh elementum sagittis. Nunc consequat lacinia purus, in consequat neque consequat id.
                        </div>
                    </div>
                </div><!--//panel-->

                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title"><a data-parent="#accordion"
                                                   data-toggle="collapse" class="panel-toggle" href="#faq2"><i class="fa fa-question-circle"></i>What is the ipsum dolor sit amet quam tortor?</a></h4>
                    </div>

                    <div class="panel-collapse collapse" id="faq2">
                        <div class="panel-body">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam rutrum ut erat a ultricies. Phasellus non auctor nisi, id aliquet lectus. Vestibulum libero eros, aliquet at tempus ut, scelerisque sit amet nunc. Vivamus id porta neque, in pulvinar ipsum. Vestibulum sit amet quam sem. Pellentesque accumsan consequat venenatis. Pellentesque sit amet justo dictum, interdum odio non, dictum nisi. Fusce sit amet turpis eget nibh elementum sagittis. Nunc consequat lacinia purus, in consequat neque consequat id.
                        </div>
                    </div>
                </div><!--//panel-->

                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title"><a data-parent="#accordion"
                                                   data-toggle="collapse" class="panel-toggle" href="#faq3"><i class="fa fa-question-circle"></i>How does lorem ipsum work?</a></h4>
                    </div>

                    <div class="panel-collapse collapse" id="faq3">
                        <div class="panel-body">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam rutrum ut erat a ultricies. Phasellus non auctor nisi, id aliquet lectus. Vestibulum libero eros, aliquet at tempus ut, scelerisque sit amet nunc. Vivamus id porta neque, in pulvinar ipsum. Vestibulum sit amet quam sem. Pellentesque accumsan consequat venenatis. Pellentesque sit amet justo dictum, interdum odio non, dictum nisi. Fusce sit amet turpis eget nibh elementum sagittis. Nunc consequat lacinia purus, in consequat neque consequat id.
                        </div>
                    </div>
                </div><!--//panel-->

                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title"><a data-parent="#accordion"
                                                   data-toggle="collapse" class="panel-toggle" href="#faq4"><i class="fa fa-question-circle"></i>Can I ipsum dolor sit amet nascetur ridiculus?</a></h4>
                    </div>

                    <div class="panel-collapse collapse" id="faq4">
                        <div class="panel-body">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam rutrum ut erat a ultricies. Phasellus non auctor nisi, id aliquet lectus. Vestibulum libero eros, aliquet at tempus ut, scelerisque sit amet nunc. Vivamus id porta neque, in pulvinar ipsum. Vestibulum sit amet quam sem. Pellentesque accumsan consequat venenatis. Pellentesque sit amet justo dictum, interdum odio non, dictum nisi. Fusce sit amet turpis eget nibh elementum sagittis. Nunc consequat lacinia purus, in consequat neque consequat id.
                        </div>
                    </div>
                </div><!--//panel--> 
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title"><a data-parent="#accordion"
                                                   data-toggle="collapse" class="panel-toggle" href="#faq5"><i class="fa fa-question-circle"></i>Is it possible to tellus eget auctor condimentum?</a></h4>
                    </div>

                    <div class="panel-collapse collapse" id="faq5">
                        <div class="panel-body">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam rutrum ut erat a ultricies. Phasellus non auctor nisi, id aliquet lectus. Vestibulum libero eros, aliquet at tempus ut, scelerisque sit amet nunc. Vivamus id porta neque, in pulvinar ipsum. Vestibulum sit amet quam sem. Pellentesque accumsan consequat venenatis. Pellentesque sit amet justo dictum, interdum odio non, dictum nisi. Fusce sit amet turpis eget nibh elementum sagittis. Nunc consequat lacinia purus, in consequat neque consequat id.
                        </div>
                    </div>
                </div><!--//panel-->

                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title"><a data-parent="#accordion"
                                                   data-toggle="collapse" class="panel-toggle" href="#faq6"><i class="fa fa-question-circle"></i>Would it elementum turpis semper imperdiet?</a></h4>
                    </div>

                    <div class="panel-collapse collapse" id="faq6">
                        <div class="panel-body">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam rutrum ut erat a ultricies. Phasellus non auctor nisi, id aliquet lectus. Vestibulum libero eros, aliquet at tempus ut, scelerisque sit amet nunc. Vivamus id porta neque, in pulvinar ipsum. Vestibulum sit amet quam sem. Pellentesque accumsan consequat venenatis. Pellentesque sit amet justo dictum, interdum odio non, dictum nisi. Fusce sit amet turpis eget nibh elementum sagittis. Nunc consequat lacinia purus, in consequat neque consequat id.
                        </div>
                    </div>
                </div><!--//panel-->

                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title"><a data-parent="#accordion"
                                                   data-toggle="collapse" class="panel-toggle" href="#faq7"><i class="fa fa-question-circle"></i>How can I imperdiet lorem sem non nisl?</a></h4>
                    </div>

                    <div class="panel-collapse collapse" id="faq7">
                        <div class="panel-body">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam rutrum ut erat a ultricies. Phasellus non auctor nisi, id aliquet lectus. Vestibulum libero eros, aliquet at tempus ut, scelerisque sit amet nunc. Vivamus id porta neque, in pulvinar ipsum. Vestibulum sit amet quam sem. Pellentesque accumsan consequat venenatis. Pellentesque sit amet justo dictum, interdum odio non, dictum nisi. Fusce sit amet turpis eget nibh elementum sagittis. Nunc consequat lacinia purus, in consequat neque consequat id.
                        </div>
                    </div>
                </div><!--//panel-->

                <div class="panel">
                    <div class="panel-heading">
                        <h4 class="panel-title"><a data-parent="#accordion"
                                                   data-toggle="collapse" class="panel-toggle" href="#faq8"><i class="fa fa-question-circle"></i>Can I imperdiet massa ut?</a></h4>
                    </div>

                    <div class="panel-collapse collapse" id="faq8">
                        <div class="panel-body">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam rutrum ut erat a ultricies. Phasellus non auctor nisi, id aliquet lectus. Vestibulum libero eros, aliquet at tempus ut, scelerisque sit amet nunc. Vivamus id porta neque, in pulvinar ipsum. Vestibulum sit amet quam sem. Pellentesque accumsan consequat venenatis. Pellentesque sit amet justo dictum, interdum odio non, dictum nisi. Fusce sit amet turpis eget nibh elementum sagittis. Nunc consequat lacinia purus, in consequat neque consequat id.
                        </div>
                    </div>
                </div><!--//panel--> 
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
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                </ul><!--//social-list-->
            </div><!--//social-container-->
            <div class="copyright">Template Copyright @ <a href="http://themes.3rdwavemedia.com/" target="_blank">3rd Wave Media</a></div>  
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
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/NkV0RHA9GKo?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div><!--//video-container-->
            </div><!--//modal-body-->
        </div><!--//modal-content-->
    </div><!--//modal-dialog-->
</div><!--//modal-->

<!-- *****CONFIGURE STYLE (REMOVE ON YOUR PRODUCTION SITE)****** -->  
<div id="config-panel" class="config-panel hidden-xs">
    <div class="panel-inner">
        <a id="config-trigger" class="config-trigger config-panel-hide" href="#"><i class="fa fa-cog"></i></a>
        <h5 class="panel-title">Colours</h5>
        <ul id="color-options" class="list-unstyled list-inline">
            <li class="theme-1 active"><a data-style="assets/css/styles.css" href="#"></a></li>
            <li class="theme-2"><a data-style="assets/css/styles-2.css" href="#"></a></li>
        </ul>
        <a id="config-close" class="close" href="#"><i class="fa fa-times-circle"></i></a>
    </div><!--//panel-inner-->
</div><!--//configure-panel-->
