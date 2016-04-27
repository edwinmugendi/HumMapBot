<div class="">

    <div class="row top_tiles">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-cc spin"></i>
                </div>
                <div class="count" id="idTransactionCount">200</div>
                <h3><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.transactions') ?></h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-users spin"></i>
                </div>
                <div class="count" id="idNewCustomers">30</div>
                <h3><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.new_users') ?></h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-users"></i>
                </div>
                <div class="count" id="idUsers">250</div>
                <h3><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.users') ?></h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-tint"></i>
                </div>
                <div class="count" id="idProducts">20</div>
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
                                <h2>£ <span id="idTransactionTotal">5,500</span></h2>
                                <span class="sparkline22 graph" style="height: 160px;"><canvas width="200" height="40" style="display: inline-block; width: 200px; height: 40px; vertical-align: top;"></canvas></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div>
                            <div class="x_title">
                                <h2><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.top_customers') ?></h2>

                                <div class="clearfix"></div>
                            </div>
                            <ul id="idTopCustomers"class="list-unstyled top_profiles scroll-view" tabindex="5001" style="overflow: hidden; outline: none; cursor: -webkit-grab;">
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>