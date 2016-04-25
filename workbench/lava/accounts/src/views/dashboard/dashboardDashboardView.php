<div class="">

    <div class="row top_tiles">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-cc"></i>
                </div>
                <div class="count" id="idTransactions">111</div>
                <h3><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.transactions') ?></h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-users"></i>
                </div>
                <div class="count" id="idNewUsers">200</div>
                <h3><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.new_users') ?></h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-users"></i>
                </div>
                <div class="count" id="idUsers">300</div>
                <h3><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.users') ?></h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-tint"></i>
                </div>
                <div class="count" id="idProducts">322</div>
                <h3><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.products') ?></h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.revenue_summary') ?></h2>
                    <div class="filter">
                        <button class="btn btn-flat btn-default pull-right" id="daterange">
                            <span class="glyphicon glyphicon-calendar"></span>
                            <span class="text-date"><?php echo $view_data['start_date']->format('M d Y') . ' - ' . $view_data['end_date']->format('M d Y'); ?></span> 
                            <b class="caret"></b>
                        </button>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-9 col-sm-12 col-xs-12">
                        <div class="demo-container" style="height:280px">
                            <div id="placeholder33x" class="demo-placeholder"></div>
                        </div>
                        <div class="tiles">
                            <div class="col-md-4 tile">
                                <span><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.total_revenue') ?></span>
                                <h2>$231,809</h2>
                                <span class="sparkline22 graph" style="height: 160px;"><canvas width="200" height="40" style="display: inline-block; width: 200px; height: 40px; vertical-align: top;"></canvas></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div>
                            <div class="x_title">
                                <h2><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.top_customers') ?></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a href="#"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#">Settings 1</a>
                                            </li>
                                            <li><a href="#">Settings 2</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="#"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <ul class="list-unstyled top_profiles scroll-view" tabindex="5001" style="overflow: hidden; outline: none; cursor: -webkit-grab;">
                                <li class="media event">
                                    <a class="pull-left border-aero profile_thumb">
                                        <i class="fa fa-user aero"></i>
                                    </a>
                                    <div class="media-body">
                                        <a class="title" href="#">Ms. Mary Jane</a>
                                        <p><strong>$2300. </strong> Agent Avarage Sales </p>
                                        <p> <small>12 Sales Today</small>
                                        </p>
                                    </div>
                                </li>
                                <li class="media event">
                                    <a class="pull-left border-green profile_thumb">
                                        <i class="fa fa-user green"></i>
                                    </a>
                                    <div class="media-body">
                                        <a class="title" href="#">Ms. Mary Jane</a>
                                        <p><strong>$2300. </strong> Agent Avarage Sales </p>
                                        <p> <small>12 Sales Today</small>
                                        </p>
                                    </div>
                                </li>
                                <li class="media event">
                                    <a class="pull-left border-blue profile_thumb">
                                        <i class="fa fa-user blue"></i>
                                    </a>
                                    <div class="media-body">
                                        <a class="title" href="#">Ms. Mary Jane</a>
                                        <p><strong>$2300. </strong> Agent Avarage Sales </p>
                                        <p> <small>12 Sales Today</small>
                                        </p>
                                    </div>
                                </li>
                                <li class="media event">
                                    <a class="pull-left border-aero profile_thumb">
                                        <i class="fa fa-user aero"></i>
                                    </a>
                                    <div class="media-body">
                                        <a class="title" href="#">Ms. Mary Jane</a>
                                        <p><strong>$2300. </strong> Agent Avarage Sales </p>
                                        <p> <small>12 Sales Today</small>
                                        </p>
                                    </div>
                                </li>
                                <li class="media event">
                                    <a class="pull-left border-green profile_thumb">
                                        <i class="fa fa-user green"></i>
                                    </a>
                                    <div class="media-body">
                                        <a class="title" href="#">Ms. Mary Jane</a>
                                        <p><strong>$2300. </strong> Agent Avarage Sales </p>
                                        <p> <small>12 Sales Today</small>
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>