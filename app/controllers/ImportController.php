<?php

/**
 * S# ImportController() class
 * @author Edwin Mugendi
 * 
 * Import controller is used to import information of a given model into the database
 * 
 */
class ImportController extends BaseController {

    public $controller = 'import';
    public $package = 'base';

    /**
     * S# postImport() function
     * 
     * Post import
     * 
     */
    public function postImport() {

        //Cache controller namespace
        $controller = \Util::buildNamespace(\Session::get('import_package'), \Session::get('import_controller'), 1);

        //Create a controller
        $this_controller = new $controller();

        //Cache model namespace
        $model = \Util::buildNamespace(\Session::get('import_package'), \Session::get('import_controller'), 2);

        //Create a model
        $this_model = new $model();
        $this->view_data['view_fields'] = $this_model->viewFields;

        $error_message = '';
        $record_validity = $rows_array = array();
        foreach ($this->input['rows_that_are_checked'] as $checked_key => $checked) {
            $record_validity[$checked_key] = 0;
            if ($checked) {
                foreach ($this_model->viewFields as $field_key => $field) {
                    if (array_key_exists($field_key, $this->input['clean_data_to_be_imported'])) {
                        $rows_array[$checked_key][$field_key] = $this->input['clean_data_to_be_imported'][$field_key][$checked_key];
                    }
                }//E# foreach statement
            }//E# if statement
        }//E# foreach statement

        foreach ($rows_array as $checked_key => $single_row) {
            $this_controller->input = array_merge($this->input, $single_row);

            //Get and set the model's create validation rules
            $this_controller->validationRules = $this_model->createRules;

            //Append custom validation rules
            $this_controller->appendCustomValidationRules();

            //Set owned by
            $this_controller->assignOwnedBy();

            //Validate row to be inserted
            $this_controller->validator = $this_controller->isInputValid();

            if ($this_controller->validator->fails()) {//Validation fails
                $error = $this_controller->formatErrors($this_controller->validator->messages()->all(':message,'));

                $error_message .= \Lang::get('common.importView.validation_error', array('number' => $checked_key + 1, 'message' => $error));

                $error_message .='<br>';

                $record_validity[$checked_key] = 0;
            } else {//Validation passes   
                $record_validity[$checked_key] = 1;
            }//E# if else statement
        }//E# foreach statement

        if ($this->input['force_import_valid_records']) {
            foreach ($rows_array as $checked_key => $single_row) {
                $this_controller->input = array_merge($this->input, $single_row);

                if ($record_validity[$checked_key]) {
                    $this_controller->postCreate();
                }//E# if statement
            }//E# foreach statement

            $count = 0;
            foreach ($record_validity as $checked_key => $valid) {
                if ($valid) {
                    $count++;
                }//E# if statement
            }//E# foreach statement

            if ($count) {
                //Delete file
                \File::delete(\Session::get('import_file_path'));

                //clean session
                \Session::forget('import_file_path');
                \Session::forget('import_package');
                \Session::forget('import_controller');
                \Session::forget('import_data');
                \Session::forget('import_header');

                return $this->notification = array(
                    'message' => \Lang::choice('common.importView.imported', $count, array('count' => $count)),
                    'type' => 'success'
                );
            } else {
                return $this->notification = array(
                    'message' => '<b>' . \Lang::get('common.importView.validation_error_heading') . '</b><br>' . $error_message,
                    'type' => 'error'
                );
            }//E# if else statement
        } else {
            if ($error_message) {
                return $this->notification = array(
                    'message' => '<b>' . \Lang::get('common.importView.validation_error_heading') . '</b><br>' . $error_message,
                    'type' => 'error'
                );
            } else {
                foreach ($rows_array as $checked_key => $single_row) {
                    $this_controller->input = array_merge($this->input, $single_row);

                    if ($record_validity[$checked_key]) {
                        $this_controller->postCreate();
                    }//E# if statement
                }//E# foreach statement

                $count = 0;
                foreach ($record_validity as $checked_key => $valid) {
                    if ($valid) {
                        $count++;
                    }//E# if statement
                }//E# foreach statement
                //Delete file
                \File::delete(\Session::get('import_file_path'));

                //clean session
                \Session::forget('import_file_path');
                \Session::forget('import_package');
                \Session::forget('import_controller');
                \Session::forget('import_data');
                \Session::forget('import_header');

                return $this->notification = array(
                    'message' => \Lang::choice('common.importView.imported', $count, array('count' => $count)),
                    'type' => 'success'
                );
            }//E# foreach statement
        }//E# if else statement
    }

//E# postImport() function

    /**
     * postUpload() function
     * 
     * Post upload data
     */
    public function postUpload() {

        if (\Input::hasFile('file') && array_key_exists('import_controller', $this->input)) {

            $file = \Input::file('file');

            $destination_path = public_path() . '/import/uploads/';

            if (in_array($file->getClientOriginalExtension(), array('csv', 'xls', 'xlsx'))) {
                $file_name = \Str::lower($this->org['name'] . '_' . $this->input['import_package'] . '_' . $this->input['import_controller'] . '_' . mt_rand(1, 10000)) . '.' . $file->getClientOriginalExtension();

                $file->move($destination_path, $file_name);

                $file_path = $destination_path . '/' . $file_name;
                chmod($file_path, 0777);
                $header = array();
                $excel = \Excel::selectSheets('Sheet1')->load($file_path, function($reader) {
                    
                });

                \Session::put('import_file_path', $file_path);
                \Session::put('import_package', $this->input['import_package']);
                \Session::put('import_controller', $this->input['import_controller']);
                \Session::put('import_data', $excel->toArray());
                \Session::put('import_header', array_keys($excel->first()->toArray()));

                $this->notification = array(
                    'message' => \Lang::get($this->package . '::' . $this->controller . '.view.finished_uploading'),
                    'type' => 'success'
                );
            } else {
                $this->notification = array(
                    'message' => \Lang::get('common.importView.wrong_file_format'),
                    'type' => 'error'
                );
            }//E# if else statement
            return \Response::json($this->notification);
        } else {

            $this->notification = array(
                'message' => \Lang::get('common.importView.wrong_file_format'),
                'type' => 'error'
            );
        }//E# if else statement

        return \Response::json($this->notification);
    }

//E# postUpload() function

    /**
     * S# getStep() function
     * 
     * Get step function
     * 
     */
    public function getStep() {
        //Prepare view data
        $this->view_data = $this->prepareViewData('import');

        //Get step data
        $this->getStepData($this->input['button_step']);

        //Set import sub view
        $this->view_data['stepView'] = \View::make('import.steps.step' . $this->input['button_step'] . 'View')
                ->with('view_data', $this->view_data)
                ->render();

        //dd($this->view_data['stepView']);
        //Build notification
        $this->notification = array(
            'view' => $this->view_data['stepView'],
        );

        return $this->notification;
    }

//E# getStep() function

    /**
     * S# getStepData() function
     * 
     * Get step data
     * 
     * @param step $int The step
     * 
     * 
     */
    private function getStepData($step) {
        //Cache controller namespace
        $controller = \Util::buildNamespace(\Session::get('import_package'), \Session::get('import_controller'), 1);

        //Create a controller
        $this_controller = new $controller();

        //Cache model namespace
        $model = \Util::buildNamespace(\Session::get('import_package'), \Session::get('import_controller'), 2);

        //Create a model
        $this_model = new $model();
        $this->view_data['view_fields'] = $this_model->viewFields;

        if ($step == 2) {
            $your_fields_select = array();
            $your_fields_select[''] = \Lang::get('common.importView.no_match');

            if (is_array(\Session::get('import_header'))) {
                foreach (\Session::get('import_header') as $single_header) {
                    $your_fields_select[$single_header] = \Str::title(str_replace('_', ' ', $single_header));
                }//E# foreach statement
            }//E# if statement

            $this->view_data['your_fields_select'] = $your_fields_select;
        } else if ($step == 3) {
            $data_to_import = array();

            foreach (\Session::get('import_data') as $single_import) {
                $record = array();
                foreach ($this->input['fields_mapping'] as $system_field => $your_field) {
                    $record[$system_field] = array_key_exists($your_field, $single_import) ? $single_import[$your_field] : '';
                }//E# foreach statement

                $data_to_import[] = $record;
            }//E# foreach statement

            $this->view_data['data_to_import'] = $data_to_import;
            $this->view_data['import_header'] = \Session::get('import_header');
            
            //Get this controllers data sources
            $this_controller->injectDataSources();

            $this->view_data['data_source'] = $this_controller->view_data['dataSource'];
        }//E# if else statement
    }

//E# getStepData() function
}

//E# ImportController
