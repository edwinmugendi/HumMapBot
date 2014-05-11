<?php if ($viewData['logged']): ?>
    <div class="topBar commonMaxWidth commonOverflowHidden">
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="<?php echo $viewData['firstSegment'] == 'list' ? 'active' : '' ?>"><a href="<?php echo \URL::route('transactionList'); ?>"><?php echo Lang::get('transactions::transaction.view.transactions'); ?></a></li>
                        <li class="<?php echo $viewData['firstSegment'] == 'form' ? 'active' : '' ?>"><a href="<?php echo \URL::route('paymentGetForm'); ?>">API Docs</a></li>
                    </ul>
                    <p class="navbar-right">
                        <?php echo Lang::get('transactions::transaction.view.merchantNo'); ?>: <span class="commonFontWeightBold"><?php echo $viewData['user']['id']; ?></span> | 
                        <?php echo Lang::get('transactions::transaction.view.loggedInAs'); ?>: <span class="commonFontWeightBold"><?php echo $viewData['user']['first_name'] . ' ' . $viewData['user']['last_name']; ?></span> | 
                        <?php echo HTML::link(URL::route('userProfile'), \Lang::get('transactions::transaction.view.editProfile')); ?>
                        <?php echo HTML::link(URL::route('userSignOut'), \Lang::get('transactions::transaction.view.signOut'), array('class' => 'btn btn-danger')); ?>

                    </p>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </div>
    <p id="notification" class="text text-info commonTextAlignCenter"></p>
<?php endif; ?>
<?php if (!empty($viewData['topBarPartial'])): ?>
    <? echo$viewData['topBarPartial']; ?>
<?php endif; ?>
