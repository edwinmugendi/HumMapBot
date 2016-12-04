<div>
    <div id="idDashboardView" class="row top_tiles">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-users"></i>
                </div>
                <div class="count"><?php echo count($view_data['org_model']['messages']); ?></div>
                <h3>Messages</h3>
            </div>
        </div>

        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-university"></i>
                </div>
                <div class="count"><?php echo count($view_data['org_model']['sessions']); ?></div>
                <h3>Sessions</h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-cart-plus"></i>
                </div>
                <div class="count"><?php echo count($view_data['org_model']['updates']); ?></div>
                <h3>Updates</h3>
            </div>
        </div>
    </div>
</div>