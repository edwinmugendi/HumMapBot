<div id="userRegistration" class="commonContainer commonMaxWidth commonOverflowHidden">
    <div class="row">
        <div class="col-md-5 col-md-offset-3 userRegistrationForm" >
            <?php if ($viewData['registrationType'] == 'activate'): ?>
                <?php if (\Session::has('activateCode')): ?>
                    <p class="commonColor"><?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.activate.statusCode.' . \Session::get('activateCode')); ?></p>
                <?php endif; ?>
            <?php elseif ($viewData['registrationType'] == 'login'): ?>
                <div class="shadowPortlet commonBorderRadius commonBorderColor row-fluid">
                    <!--S# shadow portlet heading div-->
                    <div class="shadowPortletHeading">
                        <span class="userRegistrationActionHeading commonDisplayInlineBlock commonFontWeightBold"><?php echo $login = \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.login.heading'); ?></span>
                        <span class="userRegistrationSuggest commonDisplayInlineBlock commonFloatRight"><?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.login.suggest'); ?>&nbsp;<?php echo \HTML::link(\URL::route('userRegistration', array('register')), \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.register.submit')); ?></span>
                    </div>
                    <div class="shadowPortletContainer commonBorderRadius commonBorderColor">
                        <?php echo Form::open(array('route' => 'userLogin', 'class' => 'registrationForm')); ?>
                        <div>
                            <div>
                                <?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.login.field.email'); ?>:<br/>

                                <?php echo Form::prepend_append(Form::text('email', '', array('class' => 'validate[required,custom[email]]')), '<i class="glyphicon glyphicon-envelope"></i>', '<i class="glyphicon glyphicon-star commonColorRed" title="Required"></i>') ?>
                                <?php if ($errors->has('email')): ?>
                                    <p class="commonColorRed"><?php echo $errors->first('email'); ?></p>
                                <?php endif; ?>
                            </div>
                            <div>
                                <?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.login.field.password'); ?>:<br/>

                                <?php echo Form::prepend_append(Form::password('password', array('class' => 'validate[required,minSize[' . \Config::get('product.passwordMinCharacters') . ']]')), '<i class="glyphicon glyphicon-wrench"></i>', '<i class="glyphicon glyphicon-star commonColorRed" title="Required"></i>') ?>
                                <?php if ($errors->has('password')): ?>
                                    <p class="commonColorRed"><?php echo $errors->first('password'); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="commonMarginTop5">
                                <?php echo Form::submit($login, array('class' => 'btn-processing btn-primary btn-large', 'data-processing' => \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.login.processing'))); ?>
                            </div>
                            <a class="commonMarginTop5 commonDisplayInlineBlock" href="<?php echo \URL::route('userRegistration', array('forgot')); ?>"><?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.login.field.forgotPassword'); ?></a>
                            <?php Form::close(); ?>
                        </div>
                    </div>
                </div>
            <?php elseif ($viewData['registrationType'] == 'register'): ?>
                <div class="shadowPortlet commonBorderRadius commonBorderColor row-fluid">
                    <!--S# shadow portlet heading div-->
                    <div class="shadowPortletHeading">
                        <span class="userRegistrationActionHeading commonDisplayInlineBlock commonFontWeightBold"><?php echo $login = \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.register.heading'); ?></span>
                        <span class="userRegistrationSuggest commonDisplayInlineBlock commonFloatRight"><?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.register.suggest'); ?>&nbsp;<?php echo \HTML::link(\URL::route('userRegistration', array('login')), \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.login.submit')); ?></span>
                    </div>
                    <div class="shadowPortletContainer commonBorderRadius commonBorderColor">

                        <?php echo Form::open(array('route' => 'userRegister', 'class' => 'registrationForm')); ?>
                        <div class="row-fluid commonClearBoth commonOverflowHidden">
                            <div class="span6 commonFloatLeft">
                                <?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.register.field.firstName'); ?>:<br/>

                                <?php echo Form::prepend_append(Form::span8_text('first_name', '', array('class' => 'validate[required]')), '<i class="icon-data-user"></i>', '<i class="glyphicon glyphicon-star commonColorRed" title="Required"></i>') ?>
                                <?php if ($errors->has('first_name')): ?>
                                    <p class="commonColorRed"><?php echo $errors->first('first_name'); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="span6 secondNameDiv">
                                <?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.register.field.lastName'); ?>:<br/>

                                <?php echo Form::prepend_append(Form::span8_text('last_name', '', array('class' => 'validate[required]')), '<i class="icon-data-user"></i>', '<i class="glyphicon glyphicon-star commonColorRed" title="Required"></i>') ?>
                                <?php if ($errors->has('last_name')): ?>
                                    <p class="commonColorRed"><?php echo $errors->first('last_name'); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div>
                            <?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.register.field.email'); ?>:<br/>

                            <?php echo Form::prepend_append(Form::text('email', '', array('id' => 'email', 'class' => 'validate[required,custom[email],ajax[isEmailAvailable]]')), '<i class="icon-data-email"></i>', '<i class="glyphicon glyphicon-star commonColorRed" title="Required"></i>') ?>
                            <?php if ($errors->has('email')): ?>
                                <p class="commonColorRed"><?php echo $errors->first('email'); ?></p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.register.field.password'); ?>:<br/>

                            <?php echo Form::prepend_append(Form::password('password', array('id' => 'password', 'class' => 'validate[required,minSize[' . \Config::get('product.passwordMinCharacters') . ']]')), '<i class="icon-data-password"></i>', '<i class="glyphicon glyphicon-star commonColorRed" title="Required"></i>') ?>

                            <?php if ($errors->has('password')): ?>
                                <p class="commonColorRed"><?php echo $errors->first('password'); ?></p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.register.field.confirm_password'); ?>:<br/>

                            <?php echo Form::prepend_append(Form::password('confirm_password', array('class' => 'validate[required,equals[password],minSize[' . \Config::get('product.passwordMinCharacters') . ']]')), '<i class="icon-data-password"></i>', '<i class="glyphicon glyphicon-star commonColorRed" title="Required"></i>') ?>

                            <?php if ($errors->has('confirm_password')): ?>
                                <p class="commonColorRed"><?php echo $errors->first('confirm_password'); ?></p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <?php echo Form::submit(\Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.register.submit'), array('class' => 'btn-processing btn-primary btn-large', 'data-processing' => \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.register.processing'))); ?>
                        </div>
                        <?php Form::close(); ?>
                    </div>
                </div>
            <?php elseif ($viewData['registrationType'] == 'forgot'): ?>
                <?php $forgotStatusCode = \Session::has('forgotStatusCode') ? \Session::get('forgotStatusCode') : 0; ?>

                <?php if ($forgotStatusCode == 1): ?>
                    <h2><?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.forgot.statusCode.1'); ?></h2>
                <?php else: ?>           
                    <div class="shadowPortlet commonBorderRadius commonBorderColor row-fluid">
                        <!--S# shadow portlet heading div-->
                        <div class="shadowPortletHeading">
                            <span class="userRegistrationActionHeading commonDisplayInlineBlock commonFontWeightBold"><?php echo $forgot = \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.forgot.heading'); ?></span>
                            <span class="userRegistrationSuggest commonDisplayInlineBlock commonFloatRight"><?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.forgot.suggest', array('login' => \HTML::link(\URL::route('userRegistration', array('register')), \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.login.submit')), 'register' => \HTML::link(\URL::route('userRegistration', array('register')), \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.register.submit')))); ?></span>
                        </div>
                        <div class="shadowPortletContainer commonBorderRadius commonBorderColor">
                            <?php echo Form::open(array('route' => 'userForgotPassword', 'class' => 'registrationForm')); ?>

                            <?php if ($forgotStatusCode == 2): ?>
                                <p class="commonColorRed commonFontWeightBold"><?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.forgot.statusCode.2', array('register' => \HTML::link(\URL::route('userRegistration', array('register')), \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.register.submit')))); ?></p>
                            <?php endif; ?>

                            <div>
                                <?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.forgot.field.email'); ?>:<br/>

                                <?php echo Form::prepend_append(Form::text('email', '', array('id' => 'email', 'class' => 'validate[required,custom[email]]')), '<i class="glyphicon glyphicon-user"></i>', '<i class="glyphicon glyphicon-star commonColorRed" title="Required"></i>') ?>
                                <?php if ($errors->has('email')): ?>
                                    <p class="commonColorRed"><?php echo $errors->first('email'); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="commonMarginTop10">
                                <?php echo Form::submit($forgot, array('class' => 'btn-processing btn-primary btn-large', 'data-processing' => \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.forgot.processing'))); ?>
                            </div>
                            <?php Form::close(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php elseif ($viewData['registrationType'] == 'reset'): ?>
                <div class="shadowPortlet commonBorderRadius commonBorderColor row-fluid">
                    <!--S# shadow portlet heading div-->
                    <div class="shadowPortletHeading">
                        <span class="userRegistrationActionHeading commonDisplayInlineBlock commonFontWeightBold"><?php echo $resetPassword = \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.reset.heading'); ?></span>
                    </div>
                    <div class="shadowPortletContainer commonBorderRadius commonBorderColor">
                        <?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.reset.help', array('passwordMinCharacters' => \Config::get('product.passwordMinCharacters'))); ?>
                        <?php echo Form::open(array('route' => 'userResetPassword', 'class' => 'registrationForm')); ?>
                        <?php echo Form::hidden('reset_code', $viewData['input']['reset_code']); ?>
                        <?php echo Form::hidden('email', $viewData['input']['email']); ?>
                        <div>
                            <?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.reset.field.enterPassword'); ?>:<br/>

                            <?php echo Form::prepend_append(Form::password('password', array('id' => 'password', 'class' => 'validate[required,minSize[' . \Config::get('product.passwordMinCharacters') . ']]')), '<i class="glyphicon glyphicon-wrench"></i>', '<i class="glyphicon glyphicon-star commonColorRed" title="Required"></i>') ?>
                        </div>
                        <?php if ($errors->has('password')): ?>
                            <p class="commonColorRed"><?php echo $errors->first('password'); ?></p>
                        <?php endif; ?>
                        <div>
                            <?php echo \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.reset.field.confirmPassword'); ?>:<br/>

                            <?php echo Form::prepend_append(Form::password('confirm_password', array('class' => 'validate[required,equals[password],minSize[' . \Config::get('product.passwordMinCharacters') . ']]')), '<i class="glyphicon glyphicon-wrench"></i>', '<i class="glyphicon glyphicon-star commonColorRed" title="Required"></i>') ?>

                            <?php if ($errors->has('confirm_password')): ?>
                                <p class="commonColorRed"><?php echo $errors->first('confirm_password'); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="commonMarginTop10">
                            <?php echo Form::submit($resetPassword, array('class' => 'btn-processing btn-primary btn-large', 'data-processing' => \Lang::get($viewData['package'] . '::' . $viewData['controller'] . '.' . $viewData['page'] . '.' . $viewData['view'] . '.form.reset.processing'))); ?>
                        </div>
                        <?php Form::close(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>