<li class="media event">
    <a class="pull-left border-<?php echo $view_data['color']; ?> profile_thumb">
        <i class="fa fa-user <?php echo $view_data['color']; ?>"></i>
    </a>
    <div class="media-body">
        <a class="title" href="#"><?php echo $view_data['single_customer']['name']; ?></a>
        <p><strong>£ <?php echo number_format($view_data['single_customer']['amount'], 2); ?> </strong> | <?php echo \Lang::choice($view_data['package'] . '::' . $view_data['controller'] . '.view.top_customers_transactions', $view_data['single_customer']['count'], array('count' => $view_data['single_customer']['count'])); ?> </p>
    </div>
</li>