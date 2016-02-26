<?php if (count($view_data['merchants']) == 1): ?>
    <a class="navbar-brand" href="<?php echo \URL::to('/'); ?>"><span class="commonColorRed"><?php echo $view_data['merchant']['name']; ?></span></a>
/*
        <?php else: ?>
    <ul class="nav navbar-nav">
        <li class="dropdown  commonColorRed">
            <?php foreach ($view_data['merchants'] as $single_merchant): ?>
                <?php if ($single_merchant['id'] == $view_data['merchant_id']): ?>
                    <a href="#" class="dropdown-toggle commonColorRed" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="commonColorRed"><?php echo $single_merchant['name']; ?></span> <span class="caret"></span></a>
                <?php endif; ?>
            <?php endforeach; ?>
            <ul class="dropdown-menu">
                <?php foreach ($view_data['merchants'] as $single_merchant): ?>
                    <?php if ($single_merchant['id'] != $view_data['merchant_id']): ?>
                        <li><a href="#" class="changeOrg" data-merchant-id="<?php echo $single_merchant['id']; ?>"><span class="commonColorRed"><?php echo $single_merchant['name']; ?></span></a></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
            </ul>
        </li>
    </ul>
*/    
    <?php echo \Form::open(array('id' => 'idChangeOrgForm', 'route' => 'merchantsChangeMerchant')); ?>
    <?php echo \Form::hidden('merchant_id', '', array('id' => 'idChangeOrgId')); ?>
    <?php echo \Form::close(); ?>
<?php endif; ?>