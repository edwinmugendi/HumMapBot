<?php

namespace Lava\Surveys;

use Carbon\Carbon;

/**
 * S# QuestionController() function
 * Question controller
 * @author Edwin Mugendi
 */
class QuestionController extends SurveysBaseController {

    //Controller
    public $controller = 'question';

    /**
     * S# postSaveOption() function
     * 
     * Save question options
     * 
     */
    public function postSaveOption() {

        $parameters = array();

        $parameters['lazyLoad'] = array('options');

        //Get form by id
        $controller_model = $this->getModelByField('id', $this->input['question_id'], $parameters);

        //Get old option ids
        $old_option_ids = $controller_model->options->lists('id');

        $new_option_ids = $option_array = array();

        if (array_key_exists('titles', $this->input) && is_array($this->input['titles'])) {
            $index = $option_updated = 0;
            foreach ($this->input['titles'] as $single_title) {
                if ($index != 0) {
                    $option_array = array(
                        'organization_id' => $this->org['id'],
                        'user_id' => $this->user['id'],
                        'title' => $single_title,
                        'form_id' => $this->input['form_id'],
                        'question_id' => $this->input['question_id'],
                        'option_id' => $this->input['option_ids'][$index],
                        'ip' => $this->input['ip'],
                        'agent' => $this->input['agent'],
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    );

                    if ($option_array['option_id']) {//Option exists
                        //Update option
                        $option_model = $this->callController(\Util::buildNamespace('surveys', 'option', 1), 'updateIfValid', array('id', $option_array['option_id'], $option_array));
                    } else {
                        //Create option
                        $option_model = $this->callController(\Util::buildNamespace('surveys', 'option', 1), 'createIfValid', array($option_array, true));

                        $controller_model->options()->save($option_model);
                    }//E# if else statement

                    $new_option_ids[] = $option_model->id;
                    $option_updated++;
                }//E# if statement

                $index++;
            }//E# foreach statement
        }//E# if statement

        $delete_option_ids = array_diff($old_option_ids, $new_option_ids);

        if ($delete_option_ids) {
            //Set where clause
            $where_clause = array(
                array(
                    'where' => 'whereIn',
                    'column' => 'id',
                    'operand' => $delete_option_ids
                )
            );
            //Mass delete
            $option_model = $this->callController(\Util::buildNamespace('surveys', 'option', 1), 'massDelete', array($where_clause));
        }//E# if statements
        //Set notification
        $this->notification = array(
            'type' => 'success',
            'message' => \Lang::choice($this->package . '::option.notification.option_updated', $option_updated, array('count' => ($index - 1), 'updated' => $option_updated))
        );

        return $this->notification;
    }

//E# postSaveOption() function
    
    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {
        //Get and set type options to data source
        $this->view_data['dataSource']['type'] = \Lang::get($this->package . '::' . $this->controller . '.data.type');
    }

//E# injectDataSources() function

    /**
     * S# getOptionView() function
     * 
     * Get option view
     * 
     * @return view
     */
    public function getOptionView() {
        $this->view_data = $this->prepareViewData('option');

        $parameters = array();

        $parameters['lazyLoad'] = array('options');

        //Get question model by id
        $this->view_data['controller_model'] = $this->getModelByField('id', $this->input['question_id'], $parameters);

        //Return single option view
        $this->view_data['singleOption'] = '';
        $index = 1;
        foreach ($this->view_data['controller_model']->options as $single_option) {
            $this->view_data['single_index'] = $index;
            $this->view_data['single_option_id'] = $single_option->id;
            $this->view_data['single_title'] = $single_option->title;

            //Return single bracket view
            $this->view_data['singleOption'] .= \View::make($this->package . '::' . $this->controller . '.optionSingleView')
                    ->with('view_data', $this->view_data)
                    ->render();


            $index++;
        }//E# foreach statement
        //Increment index
        $this->view_data['single_index'] = $index;

        unset($this->view_data['single_option_id']);
        unset($this->view_data['single_title']);

        //Return single option view
        $this->view_data['singleOption'] .= \View::make($this->package . '::' . $this->controller . '.optionSingleView')
                ->with('view_data', $this->view_data)
                ->render();

        //Return option view
        $this->view_data['optionView'] = \View::make($this->package . '::' . $this->controller . '.questionOptionView')
                ->with('view_data', $this->view_data)
                ->render();

        return array(
            'type' => 'success',
            'message' => $this->view_data['optionView']
        );
    }

//E# getOptionView() function
}

//E# QuestionController() function