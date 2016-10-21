<div class="">
    <div class="row top_tiles">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-edit"></i>
                </div>
                <div class="count"><?php echo $view_data['form_count']; ?></div>
                <h3><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.forms') ?></h3>
            </div>
        </div>
        <?php foreach ($view_data['forms'] as $single_form): ?>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-edit"></i>
                    </div>
                    <div class="count"><?php echo $single_form['count']; ?></div>
                    <h3><?php echo $single_form['name']; ?></h3>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>