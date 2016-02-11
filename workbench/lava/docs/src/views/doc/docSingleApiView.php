
<h2 class="text <?php echo $view_data['api']['filtered'] ? 'text-danger' : 'text-success'; ?>"><?php echo $view_data['api']['name'] ?></h2>
<?php if ($view_data['api']['note']): ?>
    <p><?php echo $view_data['api']['note']; ?> </p>
<?php endif; ?>
<dl class="dl-horizontal">
    <dt>Link:</dt>
    <dd><?php echo $view_data['api']['endpoint']; ?></dd>
    <dt>HTTP TYPE:</dt>
    <dd><?php echo $view_data['api']['httpVerb']; ?></dd>
</dl>
