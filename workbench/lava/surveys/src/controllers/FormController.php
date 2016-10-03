<?php

namespace Lava\Surveys;

use Carbon\Carbon;

/**
 * S# FormController() function
 * Form controller
 * @author Edwin Mugendi
 */
class FormController extends SurveysBaseController {

    //Controller
    public $controller = 'form';
    public $imageable = true;

    /**
     * S# postQuestion() function
     * 
     * Post question
     * 
     */
    public function postQuestion() {
        $parameters = array();

        $parameters['lazyLoad'] = array('questions');

        //Get form by id
        $controller_model = $this->getModelByField('id', $this->input['form_id'], $parameters);

        //Get old question ids
        $old_question_ids = $controller_model->questions->lists('id');

        $new_question_ids = $question_array = array();

        if (array_key_exists('titles', $this->input) && is_array($this->input['titles'])) {
            $index = $question_updated = 0;
            foreach ($this->input['titles'] as $single_title) {
                if ($index != 0) {
                    $question_array = array(
                        'organization_id' => $this->org['id'],
                        'user_id' => $this->user['id'],
                        'title' => $single_title,
                        'question_id' => $this->input['question_ids'][$index],
                        'name' => $this->input['names'][$index],
                        'type' => $this->input['types'][$index],
                        'error_message' => $this->input['error_messages'][$index],
                        'ip' => $this->input['ip'],
                        'agent' => $this->input['agent'],
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    );

                    if ($question_array['question_id']) {//Question exists
                        //Update question
                        $question_model = $this->callController(\Util::buildNamespace('surveys', 'question', 1), 'updateIfValid', array('id', $question_array['question_id'], $question_array));
                    } else {
                        //Create question
                        $question_model = $this->callController(\Util::buildNamespace('surveys', 'question', 1), 'createIfValid', array($question_array, true));

                        $controller_model->questions()->save($question_model);
                    }//E# if else statement

                    $new_question_ids[] = $question_model->id;
                    $question_updated++;
                }//E# if statement

                $index++;
            }//E# foreach statement
        }//E# if statement

        $delete_question_ids = array_diff($old_question_ids, $new_question_ids);

        if ($delete_question_ids) {
            //Set where clause
            $where_clause = array(
                array(
                    'where' => 'whereIn',
                    'column' => 'id',
                    'operand' => $delete_question_ids
                )
            );
            //Mass delete
            $question_model = $this->callController(\Util::buildNamespace('surveys', 'question', 1), 'massDelete', array($where_clause));
        }//E# if statements
        //Set notification
        $this->notification = array(
            'type' => 'success',
            'message' => \Lang::choice($this->package . '::question.notification.form_updated', $question_updated, array('count' => ($index - 1), 'updated' => $question_updated))
        );

        return \Redirect::route(camel_case($this->package . '_question_' . $this->controller), array($controller_model->id))->with('notification', $this->notification);
    }

    /**
     * S# getQuestion() function
     * 
     * @author Edwin Mugendi
     * 
     * Load question view
     */
    public function getQuestion($id) {

        $this->crudId = 2;

        $this->add_validation_assets = true;

        //Prepare view data
        $this->view_data = $this->prepareViewData('question');

        //Fields to select
        $fields = array('*');

        //Define parameters
        $parameters = array();

        $parameters['lazyLoad'] = array('questions');

        //Set where clause
        $where_clause = array(
            array(
                'where' => 'where',
                'column' => 'id',
                'operator' => '=',
                'operand' => (int) $id
            )
        );

        //Select this controller model
        $this->view_data['controller_model'] = $this->select($fields, $where_clause, 1, $parameters);

        //Get and set type options to data source
        $this->view_data['dataSource']['type'] = \Lang::get($this->package . '::question.data.type');

        //Inject data sources
        $this->injectDataSources();

        //Get question view    
        $this->getQuestionView();

        //Prepare fields for detailed view
        $this->beforeViewing($this->view_data['controller_model']);

        //Set layout's title
        $this->layout->title = \Lang::get($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['page'] . '.title', array('title' => $this->view_data['controller_model']['name'], 'id' => $this->view_data['controller_model']['id']));

        //Get and set layout's inline javascript
        $this->layout->inlineJs = $this->injectInlineJs($this->view_data);

        //Register css and js assets for this page
        $this->layout->assets = $this->registerAssets($this->view_data);

        //Set layout's top bar partial
        $this->layout->topBarPartial = $this->getTopBarPartialView();

        //Set list side bar
        //$this->view_data['sideBar'] = $this->getListSideBarPartialView();
        //Set layout's side bar partial
        $this->layout->sideBarPartial = $this->getSideBarPartialView();

        //Set layout's content view
        $this->view_data['contentView'] = \View::make($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['view'])
                ->with('view_data', $this->view_data);

        if (array_key_exists('echo', $this->input)) {
            return $this->view_data['contentView'];
        }//E# if statement
        //Set container view
        $this->layout->containerView = $this->getContainerViewPartialView();

        //Register templates
        $this->layout->containerView .= \View::make($this->view_data['package'] . '::' . $this->view_data['controller'] . '.optionModalView')
                ->with('view_data', $this->view_data);

        //Render page
        return $this->layout;
    }

//E# getQuestion() function

    /**
     * S# getQuestionView() function
     * 
     * Get bill view
     * 
     * @return view
     */
    private function getQuestionView() {
        //Return single bracket view
        $this->view_data['singleQuestion'] = '';
        $index = 1;
        if ($this->crudId == 2) {
            foreach ($this->view_data['controller_model']->questions as $single_question) {
                $this->view_data['single_index'] = $index;
                $this->view_data['single_question_id'] = $single_question->id;
                $this->view_data['single_title'] = $single_question->title;
                $this->view_data['single_name'] = $single_question->name;
                $this->view_data['single_type'] = $single_question->type;
                $this->view_data['single_error_message'] = $single_question->error_message;

                //Return single bracket view
                $this->view_data['singleQuestion'] .= \View::make($this->package . '::' . $this->controller . '.questionSingleView')
                        ->with('view_data', $this->view_data)
                        ->render();

                $index++;
            }
        }//E# if statements
        //Increment index
        $this->view_data['single_index'] = $index;

        unset($this->view_data['single_question_id']);
        unset($this->view_data['single_title']);
        unset($this->view_data['single_name']);
        unset($this->view_data['single_type']);
        unset($this->view_data['single_error_message']);

        //Return single bracket view
        $this->view_data['singleQuestion'] .= \View::make($this->package . '::' . $this->controller . '.questionSingleView')
                ->with('view_data', $this->view_data)
                ->render();
    }

//E# getQuestionView() function

    /**
     * S# afterCreating() function
     * @author Edwin Mugendi
     * Call this just after creating the model
     * Can be used to perform post create actions
     * @return 
     */
    public function afterCreating(&$controller_model) {

        //Save formula brackets
        $this->saveQuestions($controller_model, $this->crudId, $this->input);
    }

//E# afterCreating() function

    /**
     * S# afterUpdating() function
     * @author Edwin Mugendi
     * Call this just after creating the model
     * Can be used to perform post create actions
     * @return 
     */
    public function afterUpdating(&$controller_model) {
        //Save formula brackets
        $this->saveQuestions($controller_model, $this->crudId, $this->input);

        return;
    }

//E# afterUpdating() function

    /**
     * saveQuestions() function
     * Save formula brackets
     * @param int $controller_model Controller Model
     * @param int $crudId Crud Id
     * @param array $input Input
     */
    public function saveQuestions($controller_model, $crudId, $input) {
        $sync_array = array();

        if (array_key_exists('bill_ids', $input) && is_array($input['bill_ids'])) {
            $index = 0;
            foreach ($input['bill_ids'] as $single_bill_id) {
                if ($index != 0) {
                    //Penalty date
                    $penalty_date = $input['penalty_dates'][$index] ? Carbon::createFromFormat('d/m/Y', $input['penalty_dates'][$index])->format('Y-m-d') : '';

                    $sync_array[$single_bill_id] = array(
                        'value' => $input['amounts'][$index],
                        'commissionable' => $input['commissionables'][$index],
                        'penalty_date' => $penalty_date,
                        'penalty_amount' => $input['penalty_amounts'][$index],
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    );
                }//E# if statement

                $index++;
            }//E# foreach statement

            $controller_model->bills()->sync($sync_array);
        }//E# if statement
    }

//E# saveQuestions() function

    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {
        //Get and set workflow options to data source
        $this->view_data['dataSource']['workflow'] = \Lang::get($this->package . '::' . $this->controller . '.data.workflow');
    }

//E# injectDataSources() function
}

//E# FormController() function