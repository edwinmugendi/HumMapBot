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
                                                                        <td><?php echo $view_data['singleModel']['plan_id_text']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['currency_text']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['principal']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['interest']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['workflow_text']; ?></td>
                                 
                                        <td><?php echo $view_data['singleModel']['balance']; ?></td>
                                                                        <td><?php echo $view_data['singleModel']['on_schedule_text']; ?></td>
                                                                                                                                        <?php if (!array_key_exists('export', $view_data)): ?>    <td>
        <a href="<?php echo \URL::route(camel_case($view_data['package'] . '_detailed_' . $view_data['controller']), array($view_data['singleModel']['id'])); ?>" title="<?php echo \Lang::get('common.view.actions.detailed.detailed'); ?>" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> <?php echo \Lang::get('common.view.actions.detailed.view'); ?></a>
        <a href="<?php echo \URL::route(camel_case($view_data['package'] . '_post_' . $view_data['controller']), array($view_data['singleModel']['id'])); ?>" title="<?php echo \Lang::get('common.view.actions.edit.edit'); ?>"  class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> <?php echo \Lang::get('common.view.actions.edit.edit'); ?></a>
        <a href="#" data-id="<?php echo $view_data['singleModel']['id']; ?>"  data-ids="<?php echo $view_data['singleModel']['id']; ?>" class="deleteRow btn btn-danger btn-xs" title="<?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.actions.delete.delete'); ?>"><i class="fa fa-trash-o"></i> <?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.actions.delete.delete'); ?></a>
    </td>
    <?php endif; ?></tr>
<?php if (!array_key_exists('export', $view_data)): ?>
<tr id="hiddenRow-<?php echo $view_data['singleModel']['id']; ?>" data-id="<?php echo $view_data['singleModel']['id']; ?>" class="viewRow commonDisplayNone">
    <td></td>
    <td></td>
    <td colspan="100%">
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.id') .': '.$view_data['singleModel']['id']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.user_id') .': '.$view_data['singleModel']['user_id_text']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.plan_id') .': '.$view_data['singleModel']['plan_id_text']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.currency') .': '.$view_data['singleModel']['currency_text']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.principal') .': '.$view_data['singleModel']['principal']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.interest') .': '.$view_data['singleModel']['interest']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.workflow') .': '.$view_data['singleModel']['workflow_text']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.balance') .': '.$view_data['singleModel']['balance']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.on_schedule') .': '.$view_data['singleModel']['on_schedule_text']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.disbursement_date') .': '.$view_data['singleModel']['disbursement_date']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.due_date') .': '.$view_data['singleModel']['due_date']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.instalment') .': '.$view_data['singleModel']['instalment']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.instalments') .': '.$view_data['singleModel']['instalments']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.interest_rate') .': '.$view_data['singleModel']['interest_rate']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.period') .': '.$view_data['singleModel']['period']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.period_cycle') .': '.$view_data['singleModel']['period_cycle_text']; ?> </div>
                     
                                        <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.pay_every') .': '.$view_data['singleModel']['pay_every']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.cycle') .': '.$view_data['singleModel']['cycle_text']; ?> </div>
                                                            <div class="commonClearBoth commonFloatLeft"><?php echo \Lang::get($view_data['package'] . '::' . $view_data['controller'] . '.view.field.officer_id') .': '.$view_data['singleModel']['officer_id_text']; ?> </div>
                
    </td>
</tr>
<?php endif; ?>