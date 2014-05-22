
<h2 class="text <?php echo $viewData['api']['filtered'] ? 'text-danger' : 'text-success'; ?>"><?php echo $viewData['api']['name'] ?></h2>
<?php if ($viewData['api']['note']): ?>
    <p><?php echo $viewData['api']['note']; ?> </p>
<?php endif; ?>
<dl class="dl-horizontal">
    <dt>Link:</dt>
    <dd><?php echo $viewData['api']['endpoint']; ?></dd>
    <dt>HTTP TYPE:</dt>
    <dd><?php echo $viewData['api']['httpVerb']; ?></dd>
</dl>
