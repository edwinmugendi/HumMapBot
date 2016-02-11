<div id="userRecoverPassword" class="commonContainer commonMinWidth commonOverflowHidden">
    <div class="row-fluid">
        <div class="span6 offset3">
            <div class="shadowPortlet commonBorderRadius commonBorderColor row-fluid">
                <!--S# shadow portlet heading div-->
                <div class="shadowPortletHeading">
                    <h1><?php echo $resetPassword = \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.resetPassword'); ?></h1>
                </div>
                <div class="shadowPortletContainer commonBorderRadius commonBorderColor">

                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.resetPasswordHelp', array('passwordMinCharacters' => \Config::get($view_data['package'] . '::account.passwordMinCharacters'))); ?>
                    <?php echo \FormLibrary::open(array('route' => 'userResetPassword')); ?>
                    <?php echo \FormLibrary::hidden('reset_code', $view_data['reset_code']); ?>
                    <div>
                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.field.enterPassword'); ?>:<br/>

                        <?php echo \FormLibrary::prepend_append(\FormLibrary::password('password', '', array()), '<i class="icon-data-user"></i>', '<i class="icon-data-star commonColorRed" title="Required"></i>') ?>
                    </div>
                    <div>
                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.field.confirmPassword'); ?>:<br/>

                        <?php echo \FormLibrary::prepend_append(\FormLibrary::password('conf_password', '', array()), '<i class="icon-data-user"></i>', '<i class="icon-data-star commonColorRed" title="Required"></i>') ?>
                    </div>
                    <div>
                        <?php echo \FormLibrary::submit($resetPassword, array('class' => 'btn-primary btn-large')); ?>
                    </div>
                    <?php \FormLibrary::close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>