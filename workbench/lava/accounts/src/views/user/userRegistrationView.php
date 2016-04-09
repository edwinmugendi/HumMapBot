<div id="userRegistration" class="commonContainer commonMaxWidth commonOverflowHidden homePageSection">
    <div class="row">
        <div class="col-md-5 col-md-offset-3 userRegistrationForm" >
            <?php if ($view_data['registrationType'] == 'verify'): ?>
                <?php if (\Session::has('verifyCode')): ?>
                    <h4>
                        <?php if (\Session::get('verifyCode') == 1): ?>
                            <p class="commonColorRed"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.verify.statusCode.1'); ?></p>
                        <?php elseif (\Session::get('verifyCode') == 2): ?>
                            <p class="commonColorRed"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.verify.statusCode.2'); ?></p>
                        <?php endif; ?>
                    </h4>
                <?php endif; ?>

            <?php elseif ($view_data['registrationType'] == 'login'): ?>
                <?php if ($view_data['env'] == 'demo'): ?>        
                    <div>
                        <h4>Login to Demo company with:</h4>
                        <p>Email: info@sapamahrm.com</p>
                        <p>Password: demo123</p>
                    </div>
                <?php endif; ?>
                <div class="shadowPortlet commonBorderRadius commonBorderColor row-fluid">
                    <!--S# shadow portlet heading div-->
                    <div class="shadowPortletHeading">
                        <span class="userRegistrationActionHeading commonDisplayInlineBlock commonFontWeightBold"><?php echo $login = \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.heading'); ?></span>
                        <span class="userRegistrationSuggest commonDisplayInlineBlock commonFloatRight"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.suggest'); ?>&nbsp;<?php echo \HTML::link(\URL::route('userRegistration', array('register')), \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.submit')); ?></span>
                    </div>
                    <div class="shadowPortletContainer commonBorderRadius commonBorderColor">
                        <div class="row">
                            <?php echo \Form::open(array('route' => 'userLogin', 'id' => 'userPost')); ?>
                            <div class="col-md-12">
                                <?php echo \Form::hidden('force', array_key_exists('force', $view_data['input']) && $view_data['input']['force'] == 'login' ? 1 : 0); ?>
                                <?php if (\Session::has('loginErrorCode')): ?>
                                    <h4>
                                        <?php if (\Session::get('loginErrorCode') == 1): ?>
                                            <p class="commonColorRed"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.statusCode.1'); ?></p>
                                        <?php elseif (\Session::get('loginErrorCode') == 2): ?>
                                            <p class="commonColorRed"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.statusCode.2', array('register' => \HTML::link(\URL::route('userRegistration', array('register')), \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.submit')))); ?></p>
                                        <?php elseif (\Session::get('loginErrorCode') == 3): ?>
                                            <p class="commonColorRed"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.statusCode.3', array('lockOut' => \Config::get('product.lockOut'))); ?></p>
                                        <?php elseif (\Session::get('loginErrorCode') == 4): ?>
                                            <p class="commonColor"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.statusCode.4'); ?></p>
                                        <?php elseif (\Session::get('loginErrorCode') == 5): ?>
                                            <p class="commonColor"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.statusCode.5'); ?></p>
                                        <?php elseif (\Session::get('loginErrorCode') == 6): ?>
                                            <p class="commonColorRed"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.statusCode.6'); ?></p>
                                        <?php elseif (\Session::get('loginErrorCode') == 7): ?>
                                            <p class="commonColor"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.statusCode.7'); ?></p>
                                        <?php endif; ?>
                                    </h4>
                                <?php endif; ?>
                            </div>
                            <div  class="col-md-12">
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.field.email'); ?>:<br/>
                                <?php echo \InputGroup::withContents(\Form::text('email', '', array('class' => 'validate[required,custom[email]]')))->prepend('<i class = "glyphicon glyphicon-envelope"></i>')->append('<i class = "glyphicon glyphicon-star commonColorRed" title = "' . \Lang::get('common.required') . '"></i>'); ?>
                                <?php if ($errors->has('email')): ?>
                                    <p class="commonColorRed"><?php echo $errors->first('email'); ?></p>
                                <?php endif; ?>
                            </div>
                            <div  class="col-md-12">
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.field.password'); ?>:<br/>
                                <?php echo \InputGroup::withContents(\Form::password('password', array('class' => 'validate[required, minSize[' . \Config::get('product.passwordMinCharacters') . ']]')))->prepend('<i class = "glyphicon glyphicon-wrench"></i>')->append('<i class = "glyphicon glyphicon-star commonColorRed" title = "' . \Lang::get('common.required') . '"></i>'); ?>
                                <?php if ($errors->has('password')): ?>
                                    <p class="commonColorRed"><?php echo $errors->first('password'); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-12 commonMarginTop10">
                                <?php echo \Form::submit($login, array('class' => 'btn-processing btn btn-primary btn-large', 'data-processing' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.processing'))); ?>
                            </div>
                            <div class="col-md-12 commonMarginTop10">
                                <a class="commonMarginTop5 commonDisplayInlineBlock" href="<?php echo \URL::route('userRegistration', array('forgot')); ?>"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.field.forgotPassword'); ?></a>
                            </div>
                            <?php \Form::close(); ?>
                        </div>
                    </div>
                </div>
            <?php elseif ($view_data['registrationType'] == 'register'): ?>
                <?php if (\Session::has('registerCode')): ?>
                    <h2><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.received', array('productName' => \Config::get('product.name'))); ?></h2>
                <?php else: ?>
                    <h1 class="text-center"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.trial'); ?></h1>             
                    <div class="shadowPortlet commonBorderRadius commonBorderColor row-fluid">
                        <!--S# shadow portlet heading div-->
                        <div class="shadowPortletHeading">
                            <span class="userRegistrationActionHeading commonDisplayInlineBlock commonFontWeightBold"><?php echo $login = \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.heading'); ?></span>
                            <span class="userRegistrationSuggest commonDisplayInlineBlock commonFloatRight"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.suggest'); ?>&nbsp;<?php echo \HTML::link(\URL::route('userRegistration', array('login')), \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.submit')); ?></span>
                        </div>
                        <div class="shadowPortletContainer commonBorderRadius commonBorderColor">
                            <?php echo \Form::open(array('route' => 'userRegister', 'id' => 'userPost')); ?>

                            <div class="row commonClearBoth commonOverflowHidden">
                                <div class="col-md-12 commonMarginTop10">
                                    <?php echo \InputGroup::withContents(\Form::text('full_name', '', array('placeholder' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.field.fullName'), 'class' => 'validate[required, minSize[2]]')))->prepend('<i class = "glyphicon glyphicon-user"></i>')->append('<i class = "glyphicon glyphicon-star commonColorRed" title = "' . \Lang::get('common.required') . '"></i>'); ?>
                                    <?php if ($errors->has('full_name')): ?>
                                        <p class="commonColorRed"><?php echo $errors->first('full_name'); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-12 commonMarginTop10">
                                    <?php echo \InputGroup::withContents(\Form::text('email', '', array('placeholder' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.field.email'), 'id' => 'email', 'class' => 'validate[required, custom[email]')))->prepend('<i class = "icon-data-email"></i>')->append('<i class = "glyphicon glyphicon-star commonColorRed" title = "' . \Lang::get('common.required') . '"></i>'); ?>
                                    <?php if ($errors->has('email')): ?>
                                        <p class="commonColorRed"><?php echo $errors->first('email'); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-12 commonMarginTop10">
                                    <?php echo \InputGroup::withContents(\Form::text('organization', '', array('placeholder' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.field.organization'), 'class' => 'validate[required, minSize[2]]')))->prepend('<i class = "icon-data-org"></i>')->append('<i class = "glyphicon glyphicon-star commonColorRed" title = "' . \Lang::get('common.required') . '"></i>'); ?>
                                    <?php if ($errors->has('organization')): ?>
                                        <p class="commonColorRed"><?php echo $errors->first('organization'); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-12 commonMarginTop10">
                                    <?php echo \InputGroup::withContents(\Form::text('phone', '', array('placeholder' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.field.phone'), 'class' => 'validate[required,, custom[phone]')))->prepend('<i class = "icon-data-phone"></i>')->append('<i class = "glyphicon glyphicon-star commonColorRed" title = "' . \Lang::get('common.required') . '"></i>'); ?>
                                    <?php if ($errors->has('phone')): ?>
                                        <p class="commonColorRed"><?php echo $errors->first('phone'); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-12 commonMarginTop10">
                                    <?php echo \InputGroup::withContents(\Form::text('number', '', array('placeholder' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.field.number'), 'class' => 'validate[required,, custom[integer]')))->prepend('<i class = "icon-data-users"></i>')->append('<i class = "glyphicon glyphicon-star commonColorRed" title = "' . \Lang::get('common.required') . '"></i>'); ?>
                                    <?php if ($errors->has('number')): ?>
                                        <p class="commonColorRed"><?php echo $errors->first('number'); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-12 commonMarginTop10">
                                    <?php echo \InputGroup::withContents(\Form::compositeSelect('country_id', $view_data['data_source']['country_id'], '', array('class' => 'form-control validate[required]')))->prepend('<i class = "icon-data-location"></i>')->append('<i class = "glyphicon glyphicon-star commonColorRed" title = "' . \Lang::get('common.required') . '"></i>'); ?>
                                    <?php if ($errors->has('country_id')): ?>
                                        <p class="commonColorRed"><?php echo $errors->first('country_id'); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-12 commonMarginTop10">
                                    <?php echo \Form::submit(\Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.submit'), array('class' => 'btn-processing btn btn-primary btn-large', 'data-processing' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.processing'))); ?>
                                </div>
                            </div>
                            <?php echo \Form::close(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php elseif ($view_data['registrationType'] == 'forgot'): ?>
                    
                <?php $forgotStatusCode = \Session::has('forgotStatusCode') ? \Session::get('forgotStatusCode') : 0; ?>

                <?php if ($forgotStatusCode == 1): ?>
                    <h2><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.forgot.statusCode.1'); ?></h2>
                <?php else: ?>           
                    <div class="shadowPortlet commonBorderRadius commonBorderColor row-fluid">
                        <!--S# shadow portlet heading div-->
                        <div class="shadowPortletHeading">
                            <span class="userRegistrationActionHeading commonDisplayInlineBlock commonFontWeightBold"><?php echo $forgot = \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.forgot.heading'); ?></span>
                            <span class="userRegistrationSuggest commonDisplayInlineBlock commonFloatRight"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.forgot.suggest', array('login' => \HTML::link(\URL::route('userRegistration', array('login')), \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.submit')), 'register' => \HTML::link(\URL::route('userRegistration', array('register')), \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.submit')))); ?></span>
                        </div>
                        <div class="shadowPortletContainer commonBorderRadius commonBorderColor">
                            <?php echo \Form::open(array('route' => 'userForgotPassword', 'id' => 'userPost')); ?>

                            <?php if ($forgotStatusCode == 2): ?>
                                <p class="commonColorRed commonFontWeightBold"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.forgot.statusCode.2', array('register' => \HTML::link(\URL::route('userRegistration', array('register')), \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.submit')))); ?></p>
                            <?php endif; ?>

                            <div>
                                <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.forgot.field.email'); ?>:<br/>

                                <?php echo \InputGroup::withContents(\Form::text('send_to', '', array('id' => 'email', 'class' => 'validate[required, custom[email]]')))->prepend('<i class = "icon-data-email"></i>')->append('<i class = "glyphicon glyphicon-star commonColorRed" title = "' . \Lang::get('common.required') . '"></i>'); ?>
                                <?php if ($errors->has('send_to')): ?>
                                    <p class="commonColorRed"><?php echo $errors->first('send_to'); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="commonMarginTop10">
                                <?php echo \Form::submit($forgot, array('class' => 'btn-processing btn-primary btn-large', 'data-processing' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.forgot.processing'))); ?>
                            </div>
                            <?php echo \Form::close(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php elseif ($view_data['registrationType'] == 'reset'): ?>
                <div class="shadowPortlet commonBorderRadius commonBorderColor row-fluid">
                    <!--S# shadow portlet heading div-->
                    <div class="shadowPortletHeading">
                        <span class="userRegistrationActionHeading commonDisplayInlineBlock commonFontWeightBold"><?php echo $resetPassword = \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.reset.heading'); ?></span>
                    </div>
                    <div class="shadowPortletContainer commonBorderRadius commonBorderColor">
                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.reset.help', array('passwordMinCharacters' => \Config::get($view_data['package'] . '::account.passwordMinCharacters'))); ?>
                        <?php echo \Form::open(array('route' => 'userResetPassword', 'id' => 'userPost')); ?>
                        <?php echo \Form::hidden('reset_code', $view_data['input']['reset_code']); ?>
                        <?php echo \Form::hidden('send_to', $view_data['input']['email']); ?>
                        <?php echo \Form::hidden('form', 'reset'); ?>
                        <div>
                            <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.reset.field.enterPassword'); ?>:<br/>

                            <?php echo \InputGroup::withContents(\Form::password('password', array('id' => 'password', 'class' => 'validate[required, minSize[' . \Config::get('product.passwordMinCharacters') . ']]')))->prepend('<i class = "glyphicon glyphicon-wrench"></i>')->append('<i class = "glyphicon glyphicon-star commonColorRed" title = "' . \Lang::get('common.required') . '"></i>'); ?>
                        </div>
                        <?php if ($errors->has('password')): ?>
                            <p class="commonColorRed"><?php echo $errors->first('password'); ?></p>
                        <?php endif; ?>
                        <div>
                            <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.reset.field.confirmPassword'); ?>:<br/>

                            <?php echo \InputGroup::withContents(\Form::password('confirm_password', array('class' => 'validate[required, equals[password], minSize[' . \Config::get('product.passwordMinCharacters') . ']]')))->prepend('<i class = "glyphicon glyphicon-wrench"></i>')->append('<i class = "glyphicon glyphicon-star commonColorRed" title = "' . \Lang::get('common.required') . '"></i>'); ?>

                            <?php if ($errors->has('confirm_password')): ?>
                                <p class="commonColorRed"><?php echo $errors->first('confirm_password'); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="commonMarginTop10">
                            <?php echo \Form::submit($resetPassword, array('class' => 'btn-processing btn-primary btn-large', 'data-processing' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.reset.processing'))); ?>
                        </div>
                        <?php echo \Form::close(); ?>
                    </div>
                </div>
            <?php elseif ($view_data['registrationType'] == 'activate'): ?>
                <div class="shadowPortlet commonBorderRadius commonBorderColor row-fluid">
                    <!--S# shadow portlet heading div-->
                    <div class="shadowPortletHeading">
                        <span class="userRegistrationActionHeading commonDisplayInlineBlock commonFontWeightBold"><?php echo $activatePassword = \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.activate.heading'); ?></span>
                    </div>
                    <div class="shadowPortletContainer commonBorderRadius commonBorderColor">
                        <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.activate.help', array('passwordMinCharacters' => \Config::get($view_data['package'] . '::' . $view_data['package'] . '.passwordMinCharacters'))); ?>
                        <?php echo \Form::open(array('route' => 'userResetPassword', 'id' => 'userPost')); ?>
                        <?php echo \Form::hidden('form', 'activate'); ?>
                        <?php echo \Form::hidden('reset_code', $view_data['reset_code']); ?>
                        <div>
                            <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.activate.field.enterPassword'); ?>:<br/>

                            <?php echo \InputGroup::withContents(\Form::password('password', array('id' => 'password', 'class' => 'validate[required, minSize[' . \Config::get('product.passwordMinCharacters') . ']]')))->prepend('<i class = "glyphicon glyphicon-wrench"></i>')->append('<i class = "glyphicon glyphicon-star commonColorRed" title = "' . \Lang::get('common.required') . '"></i>'); ?>
                        </div>
                        <?php if ($errors->has('password')): ?>
                            <p class="commonColorRed"><?php echo $errors->first('password'); ?></p>
                        <?php endif; ?>
                        <div>
                            <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.activate.field.confirmPassword'); ?>:<br/>

                            <?php echo \InputGroup::withContents(\Form::password('confirm_password', array('class' => 'validate[required, equals[password], minSize[' . \Config::get('product.passwordMinCharacters') . ']]')))->prepend('<i class = "glyphicon glyphicon-wrench"></i>')->append('<i class = "glyphicon glyphicon-star commonColorRed" title = "' . \Lang::get('common.required') . '"></i>'); ?>

                            <?php if ($errors->has('confirm_password')): ?>
                                <p class="commonColorRed"><?php echo $errors->first('confirm_password'); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="commonMarginTop10">
                            <?php echo \Form::submit($activatePassword, array('class' => 'btn-processing btn-primary btn-large', 'data-processing' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.activate.processing'))); ?>
                        </div>
                        <?php echo \Form::close(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>