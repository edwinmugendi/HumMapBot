<div class="">
    <a class="hiddenanchor" id="toregister"></a>
    <a class="hiddenanchor" id="tologin"></a>
    <a class="hiddenanchor" id="toforgot"></a>
    <a class="hiddenanchor" id="toreset"></a>
    <div id="wrapper">
        <div id="login" class="animate form">
            <section class="login_content">
                <?php echo \Form::open(array('route' => 'userLogin', 'id' => 'userPost')); ?>
                <?php echo \Form::hidden('force', array_key_exists('force', $view_data['input']) && $view_data['input']['force'] == 'login' ? 1 : 0); ?>
                <h1><?php echo $login = \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.heading'); ?></h1>
                <?php if (\Session::has('loginErrorCode')): ?>
                    <div>
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
                    </div>
                <?php endif; ?>
                <div>
                    <?php echo \Form::text('email', '', array('placeholder' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.field.email'), 'class' => 'validate[required,custom[email]]')); ?>
                    <?php if ($errors->has('email')): ?>
                        <p class="commonColorRed"><?php echo $errors->first('email'); ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <?php echo \Form::password('password', array('placeholder' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.field.password'), 'class' => 'validate[required, minSize[' . \Config::get('product.passwordMinCharacters') . ']]')); ?>
                    <?php if ($errors->has('password')): ?>
                        <p class="commonColorRed"><?php echo $errors->first('password'); ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <?php echo \Form::submit($login, array('class' => 'btn-processing btn btn-default', 'data-processing' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.processing'))); ?>
                    <a class="reset_pass to_forgot" href="#toforgot"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.field.forgotPassword'); ?></a>
                </div>
                <div class="clearfix"></div>
                <div class="separator">
                    <p class="change_link">Have a car wash?
                        <a href="#toregister" class="to_register"> <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.submit'); ?> </a>
                    </p>
                    <div class="clearfix"></div>
                    <br />
                    <div>
                        <p> © <?php echo date('Y'); ?> <?php echo \Config::get('product.name'); ?></p>
                    </div>
                </div>
                <?php echo \Form::close(); ?>
                <!-- form -->
            </section>
            <!-- content -->
        </div>
        <div id="register" class="animate form">
            <section class="login_content">
                <?php if (\Session::has('registerCode')): ?>
                    <h2><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.received', array('productName' => \Config::get('product.name'))); ?></h2>
                <?php else: ?>
                    <?php echo \Form::open(array('route' => 'userRegister', 'id' => 'userPost')); ?>
                    <h1><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.trial'); ?></h1>
                    <div>
                        <?php echo \Form::text('full_name', '', array('placeholder' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.field.fullName'), 'class' => 'validate[required, minSize[2]]')); ?>
                        <?php if ($errors->has('full_name')): ?>
                            <p class="commonColorRed"><?php echo $errors->first('full_name'); ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <?php echo \Form::text('reg_email', '', array('placeholder' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.field.email'), 'id' => 'email', 'class' => 'validate[required, custom[email]')); ?>
                        <?php if ($errors->has('reg_email')): ?>
                            <p class="commonColorRed"><?php echo $errors->first('reg_email'); ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <?php echo \Form::text('organization', '', array('placeholder' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.field.organization'), 'class' => 'validate[required, minSize[2]]')); ?>
                        <?php if ($errors->has('organization')): ?>
                            <p class="commonColorRed"><?php echo $errors->first('organization'); ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <?php echo \Form::text('phone', '', array('placeholder' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.field.phone'), 'class' => 'validate[required,, custom[phone]')); ?>
                        <?php if ($errors->has('phone')): ?>
                            <p class="commonColorRed"><?php echo $errors->first('phone'); ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <?php echo \Form::text('town', '', array('placeholder' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.field.town'), 'class' => 'validate[required,, custom[town]')); ?>
                        <?php if ($errors->has('town')): ?>
                            <p class="commonColorRed"><?php echo $errors->first('town'); ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <?php echo \Form::compositeSelect('country_id', $view_data['data_source']['country_id'], '', array('class' => 'form-control validate[required]')); ?>
                        <?php if ($errors->has('country_id')): ?>
                            <p class="commonColorRed"><?php echo $errors->first('country_id'); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="commonMarginTop20">
                        <?php echo \Form::submit(\Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.submit'), array('class' => 'registrationSubmitButton btn-processing btn btn-default', 'data-processing' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.processing'))); ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="separator">
                        <p class="change_link">Already a member?
                            <a href="#tologin" class="to_register"> <?php echo $login; ?> </a>
                        </p>
                        <div class="clearfix"></div>
                        <br/>
                        <div>
                            <p> © <?php echo date('Y'); ?> <?php echo \Config::get('product.name'); ?></p>
                        </div>
                    </div>
                    </form>
                <?php endif; ?>       
                <!-- form -->
            </section>
            <!-- content -->
        </div>
        <div id="forgot" class="animate form">
            <section class="login_content">
                <?php $forgotStatusCode = \Session::has('forgotStatusCode') ? \Session::get('forgotStatusCode') : 0; ?>

                <?php if ($forgotStatusCode == 1): ?>
                    <p><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.forgot.statusCode.1'); ?></p>
                <?php else: ?>

                <?php endif; ?>   

                <?php echo \Form::open(array('route' => 'userForgotPassword', 'id' => 'userPost')); ?>
                <h1><?php echo $forgot = \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.forgot.heading'); ?></h1>
                <?php if ($forgotStatusCode == 2): ?>
                    <p class="commonColorRed commonFontWeightBold"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.forgot.statusCode.2', array('register' => \HTML::link(\URL::route('userRegistration', array('register')), \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.register.submit')))); ?></p>
                <?php endif; ?>
                <div>
                    <?php echo \Form::text('sent_to', '', array('placeholder' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.field.email'), 'class' => 'validate[required,custom[email]]')); ?>
                    <?php if ($errors->has('send_to')): ?>
                        <p class="commonColorRed"><?php echo $errors->first('send_to'); ?></p>
                    <?php endif; ?>
                </div>
                <div>
                    <?php echo \Form::submit($forgot, array('class' => 'registrationSubmitButton btn-processing btn btn-default', 'data-processing' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.processing'))); ?>
                </div>
                <div class="clearfix"></div>
                <div class="separator">
                    <p class="change_link">Already a member?
                        <a href="#tologin" class="to_register"> <?php echo $login; ?> </a>
                    </p>
                    <div class="clearfix"></div>
                    <br/>
                    <div>
                        <p> © <?php echo date('Y'); ?> <?php echo \Config::get('product.name'); ?></p>
                    </div>
                </div>
                <?php echo \Form::close(); ?>
                <!-- form -->
            </section>
            <!-- content -->
        </div>
        <?php if ($view_data['registrationType'] == 'reset'): ?>
            <div id="reset" class="animate form">
                <section class="login_content">
                    <?php echo \Form::open(array('route' => 'userResetPassword', 'id' => 'userPost')); ?>
                    <?php echo \Form::hidden('reset_code', $view_data['input']['reset_code']); ?>
                    <?php echo \Form::hidden('send_to', $view_data['input']['email']); ?>
                    <?php echo \Form::hidden('form', 'reset'); ?>

                    <h1><?php echo $resetPassword = \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.reset.heading'); ?></h1>
                    <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.reset.help', array('passwordMinCharacters' => \Config::get($view_data['package'] . '::account.passwordMinCharacters'))); ?>
                    <div>
                        <?php echo \Form::text('password', '', array('placeholder' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.reset.field.enterPassword'), 'class' => 'validate[required,minSize[' . \Config::get('product.passwordMinCharacters') . ']]')); ?>
                        <?php if ($errors->has('password')): ?>
                            <p class="commonColorRed"><?php echo $errors->first('password'); ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <?php echo \Form::text('confirm_password', '', array('placeholder' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.reset.field.confirmPassword'), 'class' => 'validate[required,minSize[' . \Config::get('product.passwordMinCharacters') . ']]')); ?>
                        <?php if ($errors->has('confirm_password')): ?>
                            <p class="commonColorRed"><?php echo $errors->first('confirm_password'); ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <?php echo \Form::submit($resetPassword, array('class' => 'registrationSubmitButton btn-processing btn btn-default', 'data-processing' => \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.login.processing'))); ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="separator">
                        <p class="change_link">Already a member?
                            <a href="#tologin" class="to_register"> <?php echo $login; ?> </a>
                        </p>
                        <div class="clearfix"></div>
                        <br/>
                        <div>
                            <p> © <?php echo date('Y'); ?> <?php echo \Config::get('product.name'); ?></p>
                        </div>
                    </div>
                    <?php echo \Form::close(); ?>
                    <!-- form -->
                </section>
                <!-- content -->
            </div>
        <?php endif; ?>
    </div>
</div>