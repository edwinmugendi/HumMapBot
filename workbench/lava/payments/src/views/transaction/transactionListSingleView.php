<tr class="singleRow" data-id="<?php echo $view_data['singleModel']['id']; ?>">
    <?php if (!array_key_exists('export', $view_data)): ?>    <td><?php echo \Form::checkbox('checked[]', $view_data['singleModel']['id'], false, array('class' => 'rowToCheck')); ?></td>
    <td>
        <a class="previewLink" href="#" data-id="<?php echo $view_data['singleModel']['id']; ?>"><i class="icon-data-arrow-right"></i></a>
    </td>
    <?php endif; ?>
    <?php if ((!array_key_exists('export', $view_data)) || ((array_key_exists('export', $view_data) && in_array($view_data['export'],array('pdf','print')))) ): ?>                  
        <?php endif; ?>
                         
                                        <td><?php echo $view_data['singleModel']['id']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['user_id_text']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['loan_id_text']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['phone']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['type_text']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['transaction_date']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['amount']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['currency']; ?></td>
                                                                                    <td><?php echo $view_data['singleModel']['gateway_text']; ?></td>
                                                                                                                <?php if (!array_key_exists('export', $view_data)): ?>    <td>
        <a href="<?php echo \URL::route(camel_case($view_data['package'] . '_detailed_' . $view_data['controller']), array($view_data['singleModel']['id'])); ?>" title="<?php echo \Lang::get('common.view.actions.detailed.detailed'); ?>" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> <?php echo \Lang::get('common.view.actions.detailed.view'); ?></a>
    </td>
    <?php endif; ?></tr>
<?php if (!array_key_exists('export', $view_data)): ?>
<tr id="hiddenRow-<?php echo $view_data['singleModel']['id']; ?>" data-id="<?php echo $view_data['singleModel']['id']; ?>" class="viewRow commonDisplayNone">
    <td></td>
    <td></td>
    <td colspan="100%">
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.id') .': '.$view_data['singleModel']['id']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.user_id') .': '.$view_data['singleModel']['user_id_text']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.loan_id') .': '.$view_data['singleModel']['loan_id_text']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.phone') .': '.$view_data['singleModel']['phone']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.type') .': '.$view_data['singleModel']['type_text']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.transaction_date') .': '.$view_data['singleModel']['transaction_date']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.amount') .': '.$view_data['singleModel']['amount']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.currency') .': '.$view_data['singleModel']['currency']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.description') .': '.$view_data['singleModel']['description']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.gateway') .': '.$view_data['singleModel']['gateway_text']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.gateway_tran_id') .': '.$view_data['singleModel']['gateway_tran_id']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.gateway_code') .': '.$view_data['singleModel']['gateway_code']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.user_smsed') .': '.$view_data['singleModel']['user_smsed_text']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.user_emailed') .': '.$view_data['singleModel']['user_emailed_text']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.user_pushed') .': '.$view_data['singleModel']['user_pushed_text']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.officer_smsed') .': '.$view_data['singleModel']['officer_smsed_text']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.officer_emailed') .': '.$view_data['singleModel']['officer_emailed_text']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.merchant_id') .': '.$view_data['singleModel']['merchant_id_text']; ?> </div>
                
    </td>
</tr>
<?php endif; ?>