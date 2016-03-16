<?php
//Set form action
$form['attributes']['route'] = $form['attributes']['route'][$crudId];
?>
<?php if ($errors->all()): ?>
    <div class="row">
        <div class="col-sm-7 col-sm-offset-3">
            <?php foreach ($errors->all() as $message): ?>
                <p class="text-danger"><?php echo $message ?></p>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
<?php echo \Form::open($form['attributes']); ?>
<div class="row">
    <div class="col-md-12">
        <?php foreach ($form['portlets'] as $singlePortlet): ?>
            <!--S# portlet div-->
            <a id="<?php echo camel_case($singlePortlet['id']); ?>"></a>
            <div id="<?php echo camel_case($singlePortlet['id'] . '_portlet'); ?>" class="row">
                <!--S# shadow portlet div-->
                <div class="col-md-12">
                    <h3><?php echo $singlePortlet['title']; ?> &nbsp;<span class="add-on formHelp" data-html="true" data-trigger="hover" data-title="<?php echo $singlePortlet['title']; ?>" data-content="<?php echo $singlePortlet['help']; ?>"><i class="icon-data-help"></i></span></h3>
                    <div class="shadowPortlet commonBorderRadius commonBorderColor row">
                        <!--S# shadow portlet heading div-->
                        <div class="shadowPortletHeading">
                            <h4><?php echo $singlePortlet['heading']; ?></h4>
                            <?php if ($singlePortlet['stared'] == 1): ?>
                                <p>    
                                    <span class="commonColorRed">
                                        <i class="icon-data-star"></i> <?php echo $form['stars']['required']['description']; ?>
                                    </span> 
                                    <span class="commonColor">
                                        <i class="icon-data-star"></i> <?php echo $form['stars']['optional']['description']; ?>
                                    </span>
                                </p>
                            <?php endif; ?>
                        </div>
                        <!--E# shadow portlet heading div-->
                        <!--S# shadow portlet container div-->
                        <div class="shadowPortletContainer commonBorderRadius commonBorderColor">
                            <?php foreach ($singlePortlet['rows'] as $singleRow): ?>
                                <!--S# form row div-->    
                                <div class="formRow commonClearBoth row">
                                    <?php foreach ($singleRow['fields'] as $singleField): ?>
                                        <?php
                                        if (array_key_exists('dataSource', $singleField)) {
                                            echo $dataSource[$singleField['dataSource']];
                                            break;
                                        }//E# if statement

                                        $fieldsCount = count($singleRow['fields']);
                                        $span = \Util::calculateSpan($fieldsCount);

                                        //Build the HTML name
                                        //$attributeHtmlName = $form['assignTo'] . '[' . $singleField['htmlName'] . ']';
                                        $attributeHtmlName = $singleField['htmlName'];

                                        // echo $model[$singleField['htmlName']];
                                        //Set the field value  
                                        // echo $model[$singleField['htmlName']];
                                        //Set the field value  
                                        if (\Input::old($singleField['htmlName'])) {
                                            $value_from = 'old';
                                            $value = \Input::old($singleField['htmlName']);
                                        } else {
                                            $value_from = 'model';
                                            $value = array_key_exists($singleField['htmlName'], $model) ? $model[$singleField['htmlName']] : '';
                                        }//E# if else statement
                                        //Build the field's attributes
                                        $attributes = array();
                                        if ($disableFields) {
                                            $attributes['disabled'] = 'disabled';
                                            if ($crudId == 2) {
                                                $crudId = 3;
                                            }
                                        }//E# if statement

                                        if ($singleField['type'] !== 'link' && $singleField['type'] !== 'hidden' && $singleField['type'] !== 'checkbox' && $singleField['type'] !== 'file') {
                                            //Field Prepend 
                                            $prepend = '<i class=\'icon-data-' . $singleField['prepend'] . ' commonColor\' title=\'' . \HTML::entities($singleField['name']) . '\'></i>';
                                            $attributes['placeholder'] = $singleField['placeholder'];
                                        }//E# if statement

                                        $attributes['id'] = camel_case('id_' . $singleField['htmlName']);

                                        $attributes['label_id'] = camel_case('id_' . $singleField['htmlName'] . '_label');

                                        if ($singleField['type'] == 'hidden') {

                                            echo \Form::hidden($attributeHtmlName, $value, $attributes);
                                            continue;
                                        }//E# if statement

                                        $attributes['class'] = '';
                                        if (array_key_exists('class', $singleField)) {
                                            $attributes['class'].= $singleField['class'];
                                        }//E# if statement

                                        if (isset($types)) {
                                            if (array_search($singleField['htmlName'], $form['hide'][$types]['htmlNames']) !== FALSE) {
                                                $singleField['displayed'] = 0;
                                            }//E# if statement
                                        }//E# if statement

                                        if ($singleField['displayed'] == 0 || $singleField['disabled'] == 1) {
                                            $attributes['disabled'] = 'disabled';
                                        }//E# if statement
                                        //Build Validation Engine class rules
                                        $validationEngineRules = '';
                                        $rulesCount = count($singleField['validator']);

                                        if ($rulesCount > 0) {
                                            $validationEngineRules = 'validate[';
                                            $rulesCounter = 0;
                                            foreach ($singleField['validator'] as $rule => $ruleValues) {
                                                if ($rule == 'required') {
                                                    $validationEngineRules .='required';
                                                } elseif ($rule == 'maxLength') {
                                                    $validationEngineRules .='maxSize[' . $ruleValues . ']';
                                                    $attributes['maxlength'] = $ruleValues;
                                                } elseif ($rule == 'minLength') {
                                                    $validationEngineRules .='minSize[' . $ruleValues . ']';
                                                    $attributes['minlength'] = $ruleValues;
                                                } elseif ($rule == 'condRequired') {
                                                    $validationEngineRules .='condRequired[' . implode(',', $ruleValues) . ']';
                                                } elseif ($rule == 'url') {
                                                    $validationEngineRules .='custom[url]';
                                                } elseif ($rule == 'integer') {
                                                    $validationEngineRules .='custom[integer]';
                                                } elseif ($rule == 'number') {
                                                    $validationEngineRules .='custom[number]';
                                                } elseif ($rule == 'email') {
                                                    $validationEngineRules .='custom[email]';
                                                } elseif ($rule == 'equals') {
                                                    $validationEngineRules .='equals[id' . studly_case($ruleValues) . ']';
                                                } elseif ($rule == 'ajax') {
                                                    $validationEngineRules .='ajax[' . $ruleValues . ']';
                                                }//E# if else statement
                                                if ($rulesCounter < ($rulesCount - 1)) {
                                                    $validationEngineRules .=',';
                                                }//E# if statement
                                                $rulesCounter++;
                                            }//E# foreach statement
                                            $attributes['class'] .= ' ' . $validationEngineRules .=']';
                                        }//E# if statement
                                        ?>
                                        <div class="formCell col-md-<?php echo $span . ' ' . (($singleField['displayed'] == 0) ? 'commonDisplayNoneImportant' : ''); ?>">                
                                            <div class="commonClearBoth">
                                        <?php if ($singleField['type'] !== 'link'): ?>
                                                    <div class="commonDisplayInlineImportant commonClearBoth">    
                                                        <span class="commonFloatLeft">
                                                    <?php
                                                    if (array_key_exists('required', $singleField['validator'])) {
                                                        $star = "<i class='icon-data-star commonColorRed'></i>";

                                                        $append = '<i class=\'icon-data-warning commonColorRed\' title=\'' . \HTML::entities($form['stars']['required']['fieldText']) . '\'></i>';
                                                    } else {
                                                        $star = "<i class='icon-data-star commonColor'></i>";
                                                        $append = '<i class=\'icon-data-warning commonColor\' title=\'' . \HTML::entities($form['stars']['optional']['fieldText']) . '\'></i>';
                                                    }//E# if else statement
                                                    ?>
                                                            <?php echo $star; ?>
                                                            <?php echo \Form::label($singleField['name'], $singleField['name'], array('id' => $attributes['label_id'], 'class' => 'commonFontWeightBold')); ?>
                                                            <span class="icon-data-help formHelp commonDisplayInlineImportant" data-html="true" data-trigger="hover" data-title="<?php echo $star . ' ' . $singleField['name']; ?>" data-content="<?php echo sprintf($singleField['help'], $star); ?>"></span>
                                                        </span>

                <?php if (array_key_exists('maxlength', $singleField['validator'])): ?>
                                                            <span class="formCharacterRemainingContainer commonFloatRight">
                                                                <span class="formCharactersRemainingNumber commonDisplayInlineImportant"><?php echo $singleField['validator']['maxlength']['length']; ?></span>
                                                            <?php echo \Str::lower($form['components']['characterReminder']['text']); ?>
                                                            </span>
                                                            <?php endif; ?>
                                                    </div>
                                                    <?php endif; ?>
                                                <div class="commonFloatLeft commonClearBoth">    
                                                <?php if ($singleField['type'] == 'text' || $singleField['type'] == 'textarea'): ?>   
                                                    <?php
                                                    if (array_key_exists('class', $singleField) && $singleField['class'] == 'datePicker') {
                                                        if ($value && $value_from == 'model') {
                                                            $value = ($value == '0000-00-00') ? '' : $Carbon::createFromFormat('Y-m-d', $value)->format($date_format);
                                                        }//E# if statement
                                                    }//E# if statement
                                                    ?>

                                                        <?php echo \InputGroup::withContents(\Form::$singleField['type']($attributeHtmlName, $value, $attributes))->append($append); ?>
                                                    <?php endif; ?>
                                                    <?php if ($singleField['type'] == 'password'): ?>

                                                        <?php echo \InputGroup::withContents(\Form::$singleField['type']($attributeHtmlName, $value, $attributes))->append($append); ?>
                                                    <?php endif; ?>
                                                    <?php if ($singleField['type'] == 'checkbox'): ?>
                                                        <?php echo \Form::hidden($attributeHtmlName, 0); ?>
                                                        <?php
                                                        $checked = (boolean) $value;

                                                        if ($checked == false) {
                                                            $checked = (boolean) $singleField['checked'];
                                                        }
                                                        ?>
                                                        <?php echo \Form::checkbox($attributeHtmlName, 1, $checked, $attributes); ?>&nbsp;<label for="<?php echo $attributes['id']; ?>" id="<?php echo $attributes['label_id']; ?>"><?php echo $singleField['name']; ?></label>
                                                    <?php endif; ?>
                                                    <?php if ($singleField['type'] == 'file'): ?>
                                                        <?php
                                                        $attributes['class'] .= ' form-control';
                                                        $attributes['accept'] = ' ' . $singleField['accept'];
                                                        ?>

                                                        <?php echo \Form::file($attributeHtmlName, $attributes); ?>
                                                    <?php endif; ?>

                                                    <?php if ($singleField['type'] == 'select'): ?>
                                                        <?php $attributes['class'] .= ' form-control'; ?>
                                                        <?php echo \InputGroup::withContents(\Form::compositeSelect($attributeHtmlName, $dataSource[$singleField['htmlName']], $value, $attributes))->append($append); ?>
                                                    <?php endif; ?>

                                                    <?php if ($singleField['type'] == 'link'): ?>

                                                        <?php echo \Html::link('', $singleField['name'], $attributes); ?>
                                                    <?php endif; ?>
                                                </div>
                                                <p class="commonColorRed commonClearBoth">
                                                    <?php echo $errors->first($singleField['htmlName']); ?>
                                                </p>
                                            </div>
                                        </div>
        <?php endforeach; ?>
                                </div>
                                <!--E# form row div-->    
                                <?php endforeach; ?>
                            <!--E# shadow portlet container div-->
                        </div>
                    </div>
                </div>
            </div>
            <!--E# portlet div-->
<?php endforeach; ?>
        <div class="formRow row">
            <div class="formCell col-md-12">
        <?php
        if ($disableFields) {
            $attributes['disabled'] = 'disabled';
        }//E# if statement
        ?>
                <?php echo \Form::button($form['submitText'][$crudId], array('id' => 'idPostButton', 'class' => 'btn-processing btn-primary btn-lg', 'data-processing' => $form['submitText']['processing'], 'data-save' => $form['submitText'][1], 'data-update' => $form['submitText'][2], 'data-edit' => $form['submitText'][3], 'data-crudId' => $crudId)); ?>
            </div>
        </div>
    </div>
</div>
<?php echo \Form::close(); ?>