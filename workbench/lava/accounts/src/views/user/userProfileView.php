<div id="userProfileView" class="commonMaxWidth commonPositionCenter">
    <div id="profileCard" class="commonFloatLeft">
        <h1><i class="glyphicon glyphicon-user commonColorRed"></i><?php echo $view_data['user']['name']; ?></h1>
        <h4><i class="glyphicon glyphicon-envelope"></i> <?php echo $view_data['user']['email']; ?></h4>
    </div>
    <div class="commonClearBoth">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#profile" data-toggle="tab" ><?php echo \Lang::get($view_data['package'].'::'.$view_data['controller'].'.'.$view_data['page'].'.'.$view_data['view'].'.tab.profile.heading');?></a></li>
        <li><a href="#password" data-toggle="tab" ><?php echo \Lang::get($view_data['package'].'::'.$view_data['controller'].'.'.$view_data['page'].'.'.$view_data['view'].'.tab.changePassword.heading');?></a></li>
        <li><a href="#api" data-toggle="tab"><?php echo \Lang::get($view_data['package'].'::'.$view_data['controller'].'.'.$view_data['page'].'.'.$view_data['view'].'.tab.apiKeys.heading');?></a></li>
        <li><a href="#webhooks" data-toggle="tab"><?php echo \Lang::get($view_data['package'].'::'.$view_data['controller'].'.'.$view_data['page'].'.'.$view_data['view'].'.tab.webhooks.heading');?></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="profile">
             <div id="userProfilePersonal">
                    <div>
                        <?php echo \Form::open(array('route' => 'userUpdateUser', 'id' => 'userProfilePersonalForm', 'class' => 'userProfileForm form-horizontal','data-form'=>'Personal')); ?>
                        <?php echo \Form::hidden('form', 'personal', array('id' => 'idPersonalForm')); ?>
                        <div class="control-group">
                            <div class="controls">
                                <p id="userProfileError" class="text-error commonDisplayNone"></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo \Lang::get($view_data['package'].'::'.$view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.personal.field.firstName.name'); ?></label>
                            <div class="controls">
                                <?php echo Form::text('first_name', $view_data['user']['first_name'], array('id' => 'idFirstName', 'class' => 'validate[required]', 'placeholder' => \Lang::get($view_data['package'].'::'.$view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.personal.field.firstName.placeholder'))); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo \Lang::get($view_data['package'].'::'.$view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.personal.field.lastName.name'); ?></label>
                            <div class="controls">
                                <?php echo Form::text('last_name', $view_data['user']['last_name'], array('id' => 'idLastName', 'class' => 'validate[required]', 'placeholder' => \Lang::get($view_data['package'].'::'.$view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.personal.field.lastName.placeholder'))); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo \Lang::get($view_data['package'].'::'.$view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.personal.field.phoneNumber.name'); ?></label>
                            <div class="controls">
                                <?php echo Form::text('phone', $view_data['user']['phone'] , array('id' => 'idPhoneNumber', 'placeholder' => \Lang::get($view_data['package'].'::'.$view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.personal.field.phoneNumber.placeholder'))); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo \Lang::get($view_data['package'].'::'.$view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.personal.field.email.name'); ?></label>
                            <div class="controls">
                                <p id="userProfilePersonalEmail"><?php echo $view_data['user']['email']; ?></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <?php echo \Form::submit(\Lang::get($view_data['package'].'::'.$view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.personal.submit'), array('class' => 'btn-primary')); ?> <span id="userProfilePersonalSuccess" class="text-success commonDisplayNone"><?php echo \Lang::get($view_data['package'].'::'.$view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.personal.success'); ?></span>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
        </div>
        <div class="tab-pane" id="password">
             <div id="userProfilePassword">
                    <div>
                        <?php echo \Form::open(array('route' => 'userUpdateUser', 'id' => 'userProfilePasswordForm', 'class' => 'form-horizontal')); ?>
                        <?php echo \Form::hidden('form', 'password', array('id' => 'idPasswordForm')); ?>
                        <div class="control-group">
                            <div class="controls">
                                <p id="userPasswordError" class="text-error commonDisplayNone"></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo \Lang::get($view_data['package'].'::'.$view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.password.field.password.name'); ?></label>
                            <div class="controls">
                                <?php echo Form::password('password', array('id' => 'idPassword', 'class' => 'validate[required,minSize[6]]', 'placeholder' => \Lang::get($view_data['package'].'::'.$view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.password.field.password.placeholder'))); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo \Lang::get($view_data['package'].'::'.$view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.password.field.confirmPassword.name'); ?></label>
                            <div class="controls">
                                <?php echo \Form::password('confirm_password', array('id' => 'idConfirmPassword', 'class' => 'validate[required,equals[idPassword],minSize[6]]', 'placeholder' => \Lang::get($view_data['package'].'::'.$view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.password.field.confirmPassword.placeholder'))); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <?php echo \Form::submit(\Lang::get($view_data['package'].'::'.$view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.password.submit'), array('class' => 'btn-primary')); ?> <span id="userProfilePasswordSuccess" class="text-success commonDisplayNone"><?php echo \Lang::get($view_data['package'].'::'.$view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.password.success'); ?></span>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
        </div>
        <div class="tab-pane" id="api">
            <p></p>
            <p><span class="commonFontWeightBold">API Key:</span> <?php echo $view_data['user']['api_key'];?></p>
            <p><span class="commonFontWeightBold">API Secret:</span> <?php echo $view_data['user']['api_secret'];?></p>
            
        </div>
        <div class="tab-pane" id="webhooks">
            <div id="userProfileWebhook">
                    <div>
                        <?php echo \Form::open(array('route' => 'userUpdateUser', 'id' => 'userProfileWebhookForm', 'class' => 'userProfileForm form-horizontal','data-form'=>'Webhook')); ?>
                        <?php echo \Form::hidden('form', 'webhook', array('id' => 'idWebhookForm')); ?>
                        <div class="control-group">
                            <div class="controls">
                                <p id="userWebhookError" class="text-error commonDisplayNone"></p>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo \Lang::get($view_data['package'].'::'.$view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.webhook.field.callback.name'); ?></label>
                            <div class="controls">
                                <?php echo Form::text('callback',$view_data['user']['callback'], array('id' => 'idCallback', 'class' => 'validate[custom[url]]', 'placeholder' => \Lang::get($view_data['package'].'::'.$view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.webhook.field.callback.placeholder'))); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo \Lang::get($view_data['package'].'::'.$view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.webhook.field.pushback.name'); ?></label>
                            <div class="controls">
                                <?php echo \Form::text('pushback',$view_data['user']['pushback'], array('id' => 'idPushback', 'class' => 'validate[custom[url]]', 'placeholder' => \Lang::get($view_data['package'].'::'.$view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.webhook.field.pushback.placeholder'))); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <?php echo \Form::submit(\Lang::get($view_data['package'].'::'.$view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.webhook.submit'), array('class' => 'btn-primary')); ?> <span id="userProfileWebhookSuccess" class="text-success commonDisplayNone"><?php echo \Lang::get($view_data['package'].'::'.$view_data['controller'] . '.' . $view_data['page'] . '.' . $view_data['view'] . '.form.webhook.success'); ?></span>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
        </div>
      
    </div>
    </div>
</div>
<!--S# containerSideContent div-->
