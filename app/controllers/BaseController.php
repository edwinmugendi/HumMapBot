<?php

use Carbon\Carbon;

/**
 * S# BaseController() Class
 * @author Edwin Mugendi
 * Base Controller
 */
class BaseController extends Controller {

    //Bundle
    protected $layout = 'layouts.master';
    //Subdomain
    public $subdomain;
    //Theme
    public $theme = 'nakuru';
    //Lazy load
    public $lazyLoad = array();
    //Validation rules
    protected $validationRules = array();
    //Assets
    public $assets = array();
    //Inline Js
    public $inlineJs = '';
    //Notification
    public $notification;
    //User
    public $user, $currentUser, $org;
    //Inputs
    public $input = array();
    //Searchable fields
    public $searchableFields;
    //User Searchable relations
    public $userSearchableRelations;
    //Imageable
    public $imageable;
    //Owned by
    public $ownedBy = array();
    //CrudId
    protected $crudId = -1; //Create = 1, Update = 2, Read = 3, Delete = 4

    public function __construct() {

        $this->user = $this->sessionedUser();

        //Get POSTed data
        $this->input = \Input::get();

        //Cache ip
        $this->input['ip'] = \Request::getClientIp();
        $this->input['agent'] = \Request::server('HTTP_USER_AGENT');
    }

//E# __construct() function

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout() {
        if (!is_null($this->layout)) {
            $this->layout = \View::make($this->layout);
        }
    }

//E# setupLayout() function

    /**
     * S# generateUniqueField () function
     * Generate unique field
     * 
     * @param string $field Model field
     * @param int $length Length
     * @param string $case Upper or lower case
     * @return string Field value
     */
    public function generateUniqueField($field, $length, $case = 'lower') {
        //Start with not unique
        $notUnique = true;
        while ($notUnique) {//While till you get the field value is unique
            //Generate value
            $value = \Str::$case(\Str::random($length));

            //Get model by field
            $model = $this->getModelByField($field, $value);

            if (!$model) {//Field Unique
                break;
            }//E# if statement        
        }//E# while statement

        return $value;
    }

//E# generateUniqueField() function

    /**
     * S# updatePivotTable() function
     * @author Edwin Mugendi
     * Update a users pivot table
     * @param Model $controllerModel The parent model
     * @param string $relation The relation
     * @param int $relationId The relation's model id 
     * @return none
     */
    public function updatePivotTable(&$controllerModel, $relation, $relationId, $dataToUpdate) {
        $controllerModel->$relation()->updateExistingPivot($relationId, $dataToUpdate, false);
    }

//E# updatePivotTable() function

    /**
     * S# sessionedUser() function
     * @author Edwin Mugendi
     * Get logged in user
     * @return array The logged in user
     */
    protected function sessionedUser() {
        return \Session::get('user');
    }

//E# sessionedUser() function

    /**
     * S# getManyModelBelongingToUser() function
     * @author Edwin Mugendi
     * Get model belonging to the logged in user filtered by field
     * 
     * @param string $field Field
     * @param mixed $value Value
     * 
     * @return Exception \API200Exption
     * @return Exception API400Exception
     * @return Exception API403Exception
     */
    public function getManyModelBelongingToUser($field, $value) {

        //Get this controller's model
        $modelObject = $this->getModelObject();

        //Add field and value to input
        $this->addFieldValueToInput($field, $value);

        //Get and set the model's update validation rules
        $this->validationRules = $modelObject->selectRules;

        //Validate row to be inserted
        $this->isInputValid();

        //Get model by field
        $controllerModel = $this->getModelByField($this->input['field'], $this->input['value']);

        if ($controllerModel) {//Model exists
            if ($controllerModel->user_owns) {//User owns this model
                //Get success message
                $message = \Lang::get($this->package . '::' . $this->controller . '.api.getSingle', array('field' => $this->input['field'], 'value' => $this->input['value']));

                throw new \Api200Exception($this->prepareModelToReturn($controllerModel->toArray()), $message);
            } else {//User does not own this model
                //Set notification
                $this->notification = array(
                    'field' => $this->input['field'],
                    'type' => Str::title($this->controller),
                    'value' => $this->input['value'],
                );

                //Throw 403 error
                throw new \Api403Exception($this->notification);
            }
        } else {//Model not found
            //Set notification
            $this->notification = array(
                'field' => $this->input['field'],
                'type' => Str::title($this->controller),
                'value' => $this->input['value'],
            );

            //Throw 404 error
            throw new \Api404Exception($this->notification);
        }//E# if else statement
    }

//E# getManyModelBelongingToUser() function

    /**
     * S# getAllManyModelBelongingToUser() function
     * @author Edwin Mugendi
     * Get all model belonging to the loggged in user

     * 
     * @return Exception \API200Exption
     * @return Exception \API400Exception
     */
    public function getAllManyModelBelongingToUser() {

        //Build relation
        $relation = $this->controller . 's';

        //Lazy load to load
        $parameters['lazyLoad'] = array($relation);

        //Get user by id
        $userModel = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('id', $this->user['id'], $parameters));

        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {//From API
            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.api.getAll');
            //Define relation array
            $relationArray = array();
            foreach ($userModel->$relation->toArray() as $singleRelation) {//Loop through the relations
                if ($this->isModelViewable($singleRelation)) {
                    $relationArray[] = $this->prepareModelToReturn($singleRelation);
                }//E# if statement
            }//E# foreach statement
            //Throw 200 Exception
            throw new \Api200Exception($relationArray, $message);
        }//E# if else statement
    }

//E# getAllManyModelBelongingToUser() function

    /**
     * S# prepareModelToReturn() function
     * Prepare model to return
     * 
     * @param array $rawRelation Raw relation
     */
    public function prepareModelToReturn($rawRelation) {
        return array_except($rawRelation, array('pivot'));
    }

//E# prepareModelToReturn() function

    /**
     * S# isModelViewable() function
     * Is model viewable
     * 
     * @param array $model Model
     */
    public function isModelViewable($model) {
        return true;
    }

//E# isModelViewable() function

    /**
     * S# getModelBelongingToUser() function
     * @author Edwin Mugendi
     * Get model belonging to the logged in user filtered by field
     * 
     * @param string $field Field
     * @param mixed $value Value
     * 
     * @return Exception \API200Exption
     * @return Exception \API400Exception
     */
    public function getModelBelongingToUser($field, $value) {

        //Get this controller's model
        $modelObject = $this->getModelObject();

        //Add field and value to input
        $this->addFieldValueToInput($field, $value);

        //Get and set the model's select validation rules
        $this->validationRules = $modelObject->selectRules;

        //Validate model is owned by a user
        $this->validateModelIsUserOwned($modelObject);

        //dd($this->validationRules);
        //Validate row to be inserted
        $this->isInputValid();

        //Get model by field
        $controllerModel = $this->getModelByField($this->input['field'], $this->input['value']);

        if ($controllerModel) {//Model exists
            if ($this->subdomain == 'api') {//From API
                //Get success message
                $message = \Lang::get($this->package . '::' . $this->controller . '.api.getSingle', array('field' => $this->input['field'], 'value' => $this->input['value']));

                //Throw 200 Exception
                throw new Api200Exception($this->prepareModelToReturn($controllerModel->toArray()), $message);
            }//E# if else statement
        } else {
            //Set notification
            $this->notification = array(
                'field' => $this->input['field'],
                'type' => Str::title($this->controller),
                'value' => $this->input['value'],
            );

            //Throw 404 error
            throw new \Api404Exception($this->notification);
        }//E# if statement
    }

//E# getModelBelongingToUser() function

    /**
     * S# getAllModelBelongingToUser() function
     * @author Edwin Mugendi
     * Get all model belonging to the loggged in user

     * 
     * @return Exception \API200Exption
     * @return Exception \API400Exception
     */
    public function getAllModelBelongingToUser() {

        //Get this controller's model
        $modelObject = $this->getModelObject();

        //Get and set the model's select validation rules
        $this->validationRules = $modelObject->selectAllRules;

        //Validate row to be inserted
        $this->isInputValid();

        //Get user by token
        $userModel = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('token', $this->input['token']));

        //Fields to select
        $fields = array('*');

        //Set where clause
        $whereClause = array(
            array(
                'where' => 'where',
                'column' => 'user_id',
                'operator' => '=',
                'operand' => $userModel->id
            )
        );

        //Set per page to parameters
        $parameters['paginate'] = isset($this->input['take']) ? (int) $this->input['take'] : 30;

        //Order by id in descending order
        $parameters['orderBy'][] = array('id' => 'desc');

        //Select this users models
        $controllerModel = $this->select($fields, $whereClause, 2, $parameters);

        if ($this->subdomain == 'api') {//From API
            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.api.getAll');

            //Define relation array
            $relationArray = array();

            foreach ($controllerModel as $singleRelation) {//Loop through the relations
                $relationArray[] = $this->prepareModelToReturn($singleRelation->toArray());
            }//E# foreach statement
            //Build notification
            $this->notification = array(
                'list' => $relationArray,
                'pagination' => array(
                    'page' => $controllerModel->getCurrentPage(),
                    'last_page' => $controllerModel->getLastPage(),
                    'per_page' => $controllerModel->getPerPage(),
                    'total' => $controllerModel->getTotal(),
                    'from' => $controllerModel->getFrom(),
                    'to' => $controllerModel->getTo(),
                    'count' => $controllerModel->count()
                )
            );

            throw new \Api200Exception($this->notification, $message);
        }//E# if else statement
    }

//E# getAllModelBelongingToUser() function

    public function getModelFilteredByPivot($findId, $relation, $whereField, $whereValue) {

        return $this->find($findId)->$relation()->wherePivot($whereField, '=', $whereValue)->get();

        //  return Lava\Accounts\UserModel::find($this->user['id'])->vehicles()->wherePivot($this->controller . '_id', '=', $controllerModel->id)->get();
    }

    /**
     * S# getDateFormat() function
     * 
     * Get data format
     * 
     * @return str date format
     */
    public function getDateFormat() {
        if (\Auth::check() && $this->org['date_format']) {
            $date_format = \Str::upper($this->org['date_format']);
        } else {
            $date_format = 'DD/MM/YYYY';
        }//E# if else statement

        return $date_format;
    }

//E# getDateFormat() function

    /**
     * S# convertDateFormat() function
     * 
     * Convert system date format to a format compatible with the date plugin
     * 
     * @return str Date plugin
     * 
     */
    public function convertDateFormat($date_format) {
        return str_replace('YYYY', 'Y', str_replace('DD', 'd', str_replace('MM', 'm', $date_format)));
    }

//E# convertDateFormat() function

    /**
     * S# formatDates() function
     * 
     * Format submitted input dates to mysql dates
     */
    public function formatDates($fields) {

        $date_format = $this->getDateFormat();

        $new_format = $this->convertDateFormat($date_format);

        foreach ($fields as $single_field) {
            if (array_key_exists($single_field, $this->input) && $this->input[$single_field]) {
                $this->input[$single_field] = Carbon::createFromFormat($new_format, $this->input[$single_field])->format('Y-m-d');
            }//E# if statement
        }//E# foreach statement
    }

//E# formatDates() function

    /**
     * S# beforeViewing() function
     * Prepare fields for list view
     */
    public function beforeViewing(&$singleModel) {
        return;
    }

//E# beforeViewing() function

    /**
     * S# buidSingleList() function
     * Build a single list of controller
     * @return string Single list
     */
    public function buildSingleList() {

        $controllerList = '';
        foreach ($this->viewData['controllerModel'] as $singleController) {//Loop via the controller
            //Prepare fields for list view
            $this->beforeViewing($singleController);

            //Set the single controller to view data
            $this->viewData['singleModel'] = $singleController;

            //Set user controller to the view data
            $controllerList .= \View::make($this->package . '::' . $this->controller . '.' . $this->controller . 'ListSingleView')
                            ->with('viewData', $this->viewData)->render();
        }//E#  foreach statement

        return $controllerList;
    }

//E# buildSingleList() function

    /**
     * S# getList() function
     * @author Edwin Mugendi
     * Load controller's list page
     */
    public function getList() {

        //Set crudId
        $this->crudId = 3;

        //Prepare view data
        $this->viewData = $this->prepareViewData('list');

        //Set layout's title
        $this->layout->title = \Lang::get($this->viewData['package'] . '::' . $this->viewData['controller'] . '.' . $this->viewData['page'] . '.title');

        //Order
        $this->viewData['dataSource']['per_page'] = \BaseArrayDataModel::getPerPageSelectOptions($this->package, $this->controller);

        //Order
        $this->viewData['dataSource']['order'] = \BaseArrayDataModel::getOrderSelectOptions($this->package, $this->controller);

        //Define parameters
        $this->viewData['paginationAppends'] = $whereClause = $parameters = array();

        //Inject Data Sources
        $this->injectDataSources();

        //Inject View data
        $this->injectViewData();

        //Cache model namespace
        $model = \Util::buildNamespace($this->package, $this->controller, 2);

        //Create a model
        $viewData['model'] = new $model;

        //Fields to select
        $fields = array('*');

        //Set per page
        if (array_key_exists('per_page', $this->input)) {
            $per_page = (int) $this->input['per_page'];
            $perPageMax = \Config::get('product.perPageMax');

            if ($per_page > $perPageMax) {
                $per_page = $perPageMax;
            }//E# if statement
        } else {
            $per_page = \Config::get('product.perPageMin');
        }//if else statement
        //Set per page to parameters
        $this->viewData['paginationAppends']['per_page'] = $parameters['paginate'] = $per_page;

        //Set export
        if (array_key_exists('export', $this->input) && in_array($this->input['export'], array('pdf', 'print', 'csv', 'xls'))) {
            $this->viewData['export'] = $this->input['export'];
            //Override per page
            $this->viewData['paginationAppends']['per_page'] = $parameters['paginate'] = 1000;
        }//if else statement

        if (array_key_exists('sort', $this->input) && property_exists($viewData['model'], 'viewFields') && array_key_exists($this->input['sort'], $viewData['model']->viewFields)) {//Sort field
            if (array_key_exists('order', $this->input)) {//Order exists
                if (\Str::lower($this->input['order']) == 'desc') {//Desc
                    //Order by field in acsending order
                    $parameters['orderBy'][] = array($this->input['sort'] => 'desc');
                } else {
                    //Order by field in acsending order
                    $parameters['orderBy'][] = array($this->input['sort'] => 'asc');
                }//E# if else statement
            } else {
                //Order by field in acsending order
                $parameters['orderBy'][] = array($this->input['sort'] => 'asc');
            }//E# if else statement
        } else {
            //Order by id in descending order
            $parameters['orderBy'][] = array('id' => 'desc');
        }//E# if else statement
        //Set lazy load parameters
        $parameters['lazyLoad'] = $this->lazyLoad;

        //Search
        $this->buildSearchWhereClause($fields, $whereClause, $parameters, $viewData['model']);

        //Build where clause based on role
        $this->roleBasedWhereClause($fields, $whereClause, $parameters);

        //Set owned by where clause
        $this->setOwnedBy($whereClause);

        //Set scope
        $parameters['scope'] = array('statusOne');

        //Call controller specific where clause
        $this->controllerSpecificWhereClause($fields, $whereClause, $parameters);

        //Select this users
        $this->viewData['controllerModel'] = $this->select($fields, $whereClause, 2, $parameters);

        //Prepare controller model
        $this->prepareControllerModel();

        //Build the user list and set to view data
        $this->viewData['controllerList'] = $this->buildSingleList($this->viewData);

        //return $this->viewData['controllerModel'][0];
        //Get and set layout's inline javascript
        $this->layout->inlineJs = $this->injectInlineJs($this->viewData);

        //Register css and js assets for this page
        $this->layout->assets = $this->registerAssets($this->viewData);

        //Set layout's top bar partial
        $this->layout->topBarPartial = $this->getTopBarPartialView();

        //Set list side bar
        $this->viewData['sideBar'] = $this->getListSideBarPartialView();

        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {

            //Prepare controller model
            $this->prepareControllerModel();

            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.notification.list');

            throw new \Api200Exception($this->viewData['controllerModel']->toArray(), $message);
        }//E# if statement
        //Load content view
        $this->viewData['contentView'] = \View::make($this->viewData['package'] . '::' . $this->viewData['controller'] . '.' . $this->viewData['view'])
                ->with('viewData', $this->viewData);

        if (array_key_exists('export', $this->input) && in_array($this->input['export'], array('csv', 'xls'))) {
            return $this->exportToCsv();
        }//E# if statement

        if (array_key_exists('export', $this->input) && in_array($this->input['export'], array('pdf', 'print'))) {
            return $this->exportToPdf();
        }//E# if statement

        if (array_key_exists('echo', $this->input)) {
            return $this->viewData['contentView'];
        }//E# if statement
        //Set container view
        $this->layout->containerView = $this->getContainerViewPartialView();

        //Register templates
        $this->layout->containerView .= $this->registerListTemplates();

        //Render page
        return $this->layout;
    }

//E# getList() function

    /**
     * S# registerListTemplates() method
     * @author Edwin Mugendi
     * 
     * Register list templates
     * 
     * @return return template
     */
    public function registerListTemplates() {
        
    }

//E# registerListTemplates() function

    /**
     * S# injectDataSources() function
     * Inject data sources
     * @param array $dataSources Data sources array
     * 
     */
    public function injectDataSources() {
        
    }

//E# injectDataSources() function

    /**
     * S# injectViewData() function
     * Inject view data
     * 
     */
    public function injectViewData() {
        
    }

//E# injectViewData() function

    /**
     * S# buildSearchWhereClause() function
     * @author Edwin Mugendi
     * Build search where clause
     * 
     * @param array $fields Fields
     * @param array $parameters Parameters
     * @param array $whereClause Where clause
     * @param model $model Model
     * 
     * @param Model $model Model
     */
    public function buildSearchWhereClause(&$fields, &$whereClause, &$parameters, &$model) {

        if (property_exists($model, 'viewFields')) {//Search fields exist
            foreach ($this->input as $key => $value) {//Loop via the inputs
                if (array_key_exists($key, $model->viewFields)) {
                    if ($value) {

                        //Append to pagination
                        $this->viewData['paginationAppends'][$key] = $value;

                        if ($model->viewFields[$key][2] == 'like') {
                            $value = '%' . $value . '%';
                        }//E# if statement
                        //Append where clause
                        $whereClause[] = array(
                            'where' => 'where',
                            'column' => $key,
                            'operator' => $model->viewFields[$key][2],
                            'operand' => $value
                        );
                    }
                }//E# if statement
            }//E# foreach statement
        }//E# if statement
    }

//E# buildSearchWhereClause() function

    /**
     * S# roleBasedWhereClause() function
     * @author Edwin Mugendi
     * Build where clause based on role
     * 
     * @param array $fields Fields
     * @param array $parameters Parameters
     * @param array $whereClause Where clause
     */
    public function roleBasedWhereClause($fields, &$parameters, &$whereClause) {
        
    }

//E# roleBasedWhereClause() function

    /**
     * S#setOwnedBy() function
     * 
     * Set owned by where clause to get only models owned by the respective model
     * 
     * @param type $whereClause
     */
    public function setOwnedBy(&$whereClause) {

        if ($this->ownedBy) {//Owned by is set
            foreach ($this->ownedBy as $singleOwnedBy) {
                //Owned by current user
                if ($singleOwnedBy == 'user') {
                    $whereClause[] = array(
                        'where' => 'where',
                        'column' => 'user_id',
                        'operator' => '=',
                        'operand' => $this->user['id']
                    );
                }//E# if statement
                //Owned by current organization
                if ($singleOwnedBy == 'organization') {
                    $whereClause[] = array(
                        'where' => 'where',
                        'column' => 'organization_id',
                        'operator' => '=',
                        'operand' => $this->org['id']
                    );
                }//E# if statement
            }//E# foreach statement
        }//E# if statement
    }

//E# setOwnedBy() function

    /**
     * S# controllerSpecificWhereClause() function
     * @author Edwin Mugendi
     * 
     * Set controller specific where clause
     * @param array $fields Fields
     * @param array $whereClause Where clause
     * @param array $parameters Parameters
     */
    public function controllerSpecificWhereClause(&$fields, &$whereClause, &$parameters) {
        
    }

//E# controllerSpecificWhereClause() function

    /**
     * S# prepareControllerModel() function
     * Prepare Controller Model
     * 
     */
    public function prepareControllerModel() {
        
    }

//E# prepareControllerModel() function

    /**
     * S# validateInput() function
     * @author Edwin Mugendi
     * Validate create input
     * @param array $input the data to be validated
     * @param boolean $source flag on whether to return the validator () or throw the exception
     * API = 1, Web = 2
     * @return Object the validation object after validation
     */
    public function isInputValid() {
        //Validate this input
        $validation = \Validator::make($this->input, $this->validationRules);

        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json') && $validation->fails()) {//Validation failed
            //Throw a Validation Exception
            throw new Api400Exception($validation, $this->validationRules);
        }//E# if statement

        return $validation;
    }

//E# isInputValid() function

    /**
     * S# callController() method
     * @author Edwin Mugendi
     * Call another controller
     * @param string $controller controller namespace
     * @param string $action controller's function to call
     * @param array $parameters the function's parameters
     * @return object the original property of the Responce
     */
    public function callController($controller, $action, $parameters = array()) {
        $app = app();
        $controller = $app->make($controller);

        return $controller->callAction($action, $parameters);
    }

//E# callController() method

    /**
     * S# getLanguageString() method
     * @::or Edwin Mugendi
     * Return a language line
     * @param string $line the language line
     * @param array $replacements replancement array
     * @return string the language line
     */
    public function getLanguageString($line, $replacements = array()) {
        return \Lang::get($this->controller . '.' . $line, $replacements);
    }

//E# getLanguageString() function
    /**
     * S# injectInlineJs() method
     * @author Edwin Mugendi
     * Return inline javascript function for each page
     * @param string $page the current page
     * @param array $parameters the parameters
     * @return string inline Javascript
     */
    public function injectInlineJs($parameters = array()) {
        //Define js array to be returned
        $js = array();

        //Set date format
        //Set login redirect
        $js['loginRedirect'] = \Request::path();

        //Set current page
        $js['page'] = camel_case($this->package . '_' . $parameters['page']);

        //Set date format
        $js['date_format'] = $this->getDateFormat();
        
        //Set crud id
        $js['crudId'] = $this->crudId;

        //Set package
        $js['package'] = $this->package;

        //Set controller
        $js['controller'] = $this->controller;

        //Set base url
        $js['baseUrl'] = \URL::to('/');

        //Set logged
        $js['logged'] = \Auth::check() ? 1 : 0;

        //Set current language
        $js['lang']['current'] = \Config::get('app.locale');

        //Set property
        $js['controllerModel'] = array_key_exists('controllerModel', $parameters) ? $parameters['controllerModel'] : false;

        if ($parameters['page'] == $this->controller . 'ListPage') {
            $js['lang']['actions'] = \Lang::get($this->package . '::' . $this->controller . '.view.actions');

            $js['imageable'] = 1;
        }//E# if statement

        if ($this->imageable && ($parameters['page'] == $this->controller . 'PostPage')) {//Load Media picker component
            //Media
            $js['maxNumberOfFiles'] = $parameters['media']['count'];

            $js['lang']['media']['maxFilesExceeded'] = $this->callController(\Util::buildNamespace('media', 'media', 1), 'getLanguageString', array('inlineJs.error.fileupload.description.maxFilesExceeded'));
            $js['lang']['media']['fileNotAllowed'] = $this->callController(\Util::buildNamespace('media', 'media', 1), 'getLanguageString', array('inlineJs.error.fileupload.description.fileNotAllowed'));
            $js['lang']['media']['fileTooBig'] = $this->callController(\Util::buildNamespace('media', 'media', 1), 'getLanguageString', array('inlineJs.error.fileupload.description.fileTooBig'));
            $js['lang']['media']['fileTooSmall'] = $this->callController(\Util::buildNamespace('media', 'media', 1), 'getLanguageString', array('inlineJs.error.fileupload.description.fileTooSmall'));
        }//E# if statement
        //Inject controller specific js
        $this->injectControllerSpecificJs($js);

        //Append inline javascript to inline Js
        $this->inlineJs .= '<script type="text/javascript">';
        $this->inlineJs .= "var inlineJs = " . json_encode($js) . ";";
        $this->inlineJs .= '</script>';

        //Return inline javascript
        return $this->inlineJs;
    }

//E# injectInlineJs() method

    /**
     * S# injectControllerSpecificJs() method
     * @author Edwin Mugendi
     * Inject controller specific js
     * @param string $js javascript
     */
    public function injectControllerSpecificJs(&$js) {
        
    }

//E# injectControllerSpecificJs() method

    /**
     * S# registerComponents() method
     * @author Edwin Mugendi
     * Register location picker component templates
     * @param array $inlineJsData The inline js data
     * @return return template
     */
    public function registerComponents($inlineJsData) {
        
    }

//E# registerComponents() function

    /**
     * S# registerAssets() method
     * @author Edwin Mugendi
     * Register CSS and JS assets
     * @param string $page the current page
     * @return array assets array
     */
    public function registerAssets($page, $parameters = array()) {
        //Register global css assets
        $this->assets['css'][] = \HTML::style('bootstrap/css/bootstrap.min.css');
        $this->assets['css'][] = \HTML::style('bootstrap/css/bootstrap-theme.min.css');

        //Register global js assets
        $this->assets['js'][] = \HTML::script('bootstrap/js/bootstrap.min.js');

        //Switch through the pages
        switch ($page) {
            case 'docDocPage': {//Docs Page
                    //Validation Engine js
                    $this->assets['js'][] = \HTML::script('js/validationEngine/languages/jquery.validationEngine-' . \Config::get('app.locale') . '.js');
                    $this->assets['js'][] = \HTML::script('js/validationEngine/jquery.validationEngine.js');

                    break;
                }//E# case

            default:
                break;
        }//E# switch statement
        //Register css assets
        $this->assets['css'][] = \HTML::style('css/themes/' . $this->theme . '/' . $this->theme . '.css');

        //Register js assets
        $this->assets['js'][] = \HTML::script('js/themes/' . $this->theme . '/' . $this->theme . '.js?time=' . time());

        return $this->assets;
    }

//E# registerAssets() method

    /**
     * S# getTopBarPartialView() method
     * @author Edwin Mugendi
     * Return top bar partial view for each page
     * @return view the top bar partial view
     */
    public function getTopBarPartialView() {
        //Get and return the global top bar partial
        return \View::make('partials.topBar')
                        ->with('viewData', $this->viewData);
    }

//E# getTopBarPartialView() method

    /**
     * S# getPostSideBarPartialView() method
     * @author Edwin Mugendi
     * Return side bar partial view for each page
     * @return view the side bar partial view
     */
    public function getPostSideBarPartialView() {
        //Get and return the global side bar partial
        return \View::make('partials.sideBar')
                        ->with('viewData', $this->viewData);
    }

//E# getPostSideBarPartialView() method

    /**
     * S# getListSideBarPartialView() method
     * @author Edwin Mugendi
     * Return side bar partial view for each page
     * @return view the side bar partial view
     */
    public function getListSideBarPartialView() {
        //Get and return the global side bar partial
        return \View::make('partials.sideBar')
                        ->with('viewData', $this->viewData);
    }

//E# getListSideBarPartialView() method

    /**
     * S# getContainerViewPartialView() method
     * @author Edwin Mugendi
     * Return container view partial view for each page
     * @return view the container view partial view
     */
    public function getContainerViewPartialView() {
        //Get and return the global side bar partial
        return \View::make('partials.containerView')
                        ->with('viewData', $this->viewData);
    }

//E# getContainerViewPartialView() method

    /**
     * S# getFooterBarPartialView() method
     * @author Edwin Mugendi
     * Return footer bar partial view for each page
     * @return view the footer bar partial view
     */
    public function getFooterBarPartialView() {
        //Get and return the global footer bar partial
        return \View::make('partials.footerBar')
                        ->with('viewData', $this->viewData);
    }

//E# getFooterBarPartialView() method

    /**
     * S# getCrudActionCode() method
      @author Edwin Mugendi
     * Return the integer or string crud action code
     * @param mixed $crudAction the string or integer crud action code
     * @param string $type the type to be returned integer or string
     * @return mixed the integer or string crud action code
     */
    public function getCrudActionCode($crudAction, $type) {
        switch ($type) {//Switch between $type
            case 'integer':
                if ($crudAction == 'create') {//Creating a new property
                    return 1;
                } else if ($crudAction == 'update') {//Updating an already existing property
                    return 2;
                }//E# if else statement
                break;
            case 'string':
                if ($crudAction == 1) {//Creating a new property
                    return 'create';
                } else if ($crudAction == 2) {//Updating an already existing property
                    return 'update';
                }//E# if else statement
                break;
            default:
                break;
        }//E# switch statement
    }

//E# getCrudActionCode() method

    /**
     * S# prepareViewData() method
      @author Edwin Mugendi
     * Prepare common view data
     * @param string $action the action being performed
     * @return array view data
     */
    public function prepareViewData($action) {
        //Set meta description
        $this->layout->meta_description = \Config::get('product.meta.description');

        //Set meta keywords
        $this->layout->meta_keywords = \Config::get('product.meta.keywords');

        //Set data source to view data
        $this->viewData['dataSource'] = array();

        //Set package to view data
        $this->viewData['package'] = $this->package;

        //Set controller to view data
        $this->viewData['controller'] = $this->controller;

        //Set carbon to view data
        $this->viewData['Carbon'] = new Carbon;

        //Set action to view data
        $this->viewData['action'] = $action;

        //Set theme to view data
        $this->viewData['theme'] = $this->theme;

        //Set logged in to view data
        $this->layout->logged = $this->viewData['logged'] = \Auth::check();

        //Set logged in user to view data
        $this->viewData['user'] = $this->user;

        //Set current user to view data
        //$this->viewData['currentUser'] = $this->currentUser;
        //Set current user to view data
        // $this->viewData['org'] = $this->org;
        //Set input data to view data
        $this->viewData['input'] = $this->input;

        //Set disable Fields to view data
        //$this->viewData['disableFields'] = $this->disableFields;
        //Set segment to view data
        $this->viewData['segments'] = \Request::segments();

        //Set environment to view data
        $this->viewData['env'] = App::environment();

        //Set date_format to view data
        $this->viewData['date_format'] = $this->convertDateFormat($this->getDateFormat());

        //Set imageable to view data
        $this->viewData['imageable'] = $this->imageable;

        if ($this->imageable) {
            //Set uploadpath to view data
            $this->viewData['uploadPath'] = \URL::to('/') . \Config::get('media::media.uploadPath');
        }//E# if statement
        //Set view to view data
        $this->viewData['view'] = camel_case($this->controller . '_' . $action . '_view');

        //Set page to view data
        $this->viewData['page'] = camel_case($this->controller . '_' . $action . '_page');

        //Set layout's footer bar partial
        $this->layout->footerBarPartial = $this->getFooterBarPartialView($this->viewData);

        //Return prepared view data
        return $this->viewData;
    }

//E# prepareViewData() method

    /**
     * S# getModelByField() function
     * @author Edwin Mugendi
     */
    public function getModelByField($field, $value, $parameters = array()) {
        //Fields to select
        $fields = array('*');

        //Build where clause
        $whereClause = array(
            array(
                'where' => 'where',
                'column' => $field,
                'operator' => '=',
                'operand' => $value
            )
        );
        //Select model by field
        return $this->select($fields, $whereClause, 1, $parameters);
    }

    public function delete($whereClause) {
        //Cache model namespace
        $model = \Util::buildNamespace($this->package, $this->controller, 2);

        //Create a model
        $deleteModel = new $model();

        //Build where clause
        $this->buildWhereClause($deleteModel, $whereClause);

        return $deleteModel->delete();
    }

//E# delete() function
    public function select($fields, $whereClause, $oneOrAll, $parameters = array()) {

        //Cache model namespace
        $model = \Util::buildNamespace($this->package, $this->controller, 2);

        //Create a model
        $selectModel = new $model();

        //Build where clause
        $this->buildWhereClause($selectModel, $whereClause);

        if (array_key_exists('withTrashed', $parameters)) {//Load Trashed models
            $selectModel = $selectModel->withTrashed();
        }//E# if statement

        if (array_key_exists('count', $parameters)) {//Count models and return
            return $selectModel->count();
        }//E# if statement

        if (array_key_exists('aggregate', $parameters)) {//Count models and return
            return $selectModel->$parameters['aggregate']['function']($parameters['aggregate']['field']);
        }//E# if statement

        if (array_key_exists('groupBy', $parameters)) {//Group by
            $selectModel->groupBy($parameters['groupBy']);
        }//E# if statement

        if (array_key_exists('orderBy', $parameters)) {//Order model
            //dd($parameters);
            $this->buildOrderBy($selectModel, $parameters['orderBy']);
        }//E# if statement

        if (array_key_exists('orderByRaw', $parameters)) {//Order model by raw sql
            $this->buildOrderByRaw($selectModel, $parameters['orderByRaw']);
        }//E# if statement

        if (array_key_exists('lazyLoad', $parameters)) {//Lazy load other models
            $lazyLoad = $this->buildLazyLoad($parameters['lazyLoad']);
            // dd($lazyLoad);
            $selectModel->with($lazyLoad)->get();
        }//E# if statement

        if (array_key_exists('scope', $parameters)) {//Load Scope
            $lazyLoad = $this->buildScope($selectModel, $parameters['scope']);
        }//E# if statement

        if (array_key_exists('paginate', $parameters)) {//Paginate
            //Select fields
            $selectModel->select($fields);

            //Return here because paginator object cannot be converted to array or json
            return $selectModel->paginate($parameters['paginate']);
        } else {

            //Get all or first model
            $selectModel = ($oneOrAll == 2) ? $selectModel->get($fields) : $selectModel->first($fields);
            if (array_key_exists('convertTo', $parameters) && $oneOrAll == 2) {//Convert this model to array or json   
                $selectModel = $selectModel->$parameters['convertTo']();
            }//E# if statement
            //Return selected model
            return count($selectModel) ? $selectModel : array();
        }//E# if else statement
    }

//E# select() method

    /**
     * S# buildLazyLoad() method
     * @author Edwin Mugendi
     * Build lazy load relationships
     * @param array $modelsToLoad the models to be loaded
     * @param model the model with lazy load added to it 
     */
    private function buildLazyLoad($modelsToLoad) {

        $lazyLoad = array();
        foreach ($modelsToLoad as $modelKey => $singleModelParameters) {
            if (is_array($singleModelParameters)) {//Model is array
                $lazyLoadkey = key($singleModelParameters);
                $parameters = current($singleModelParameters);

                $lazyLoad[$lazyLoadkey] = function($query) use($parameters) {
                    if (array_key_exists('orderBy', $parameters)) {
                        foreach ($parameters['orderBy'] as $singleOrder) {//Loop through the order by array
                            $query->orderBy(key($singleOrder), current($singleOrder));
                        }//E# foreach statement
                    }//E# if statement
                };
            } else {
                $lazyLoad[] = $singleModelParameters;
            }//E# if else statemetn
        }//E# foreach statement

        return $lazyLoad;
    }

//E# buildLazyLoad() function

    /**
     * S# buildWhereClause() method
     * @author Edwin Mugendi
     * Build the where clause in to the model
     * @param model $model the model
     * @param array $where_array the where clause
     * @param model the model with where clause added to it 
     */
    private function buildWhereClause(&$model, &$whereClause) {
        foreach ($whereClause as $singleWhereClause) {//Loop through the where clause
            //($singleWhereClause);
            if ($singleWhereClause['where'] == 'where') {//Where clause
                $model = $model->where($singleWhereClause['column'], $singleWhereClause['operator'], $singleWhereClause['operand']);
            } else if ($singleWhereClause['where'] == 'orWhere') {//Where clause
                $model = $model->orWhere($singleWhereClause['column'], $singleWhereClause['operator'], $singleWhereClause['operand']);
            } else if ($singleWhereClause['where'] == 'whereBetween') {//whereBetween clause
                $model = $model->whereBetween($singleWhereClause['column'], $singleWhereClause['operand']);
            } else if ($singleWhereClause['where'] == 'whereIn') {//whereIn clause
                $model = $model->whereIn($singleWhereClause['column'], $singleWhereClause['operand']);
            } else if ($singleWhereClause['where'] == 'whereNotIn') {//whereNotIn clause
                $model = $model->whereNotIn($singleWhereClause['column'], $singleWhereClause['operand']);
            } else if ($singleWhereClause['where'] == 'whereNull') {//whereNull clause
                $model = $model->whereNull($singleWhereClause['column']);
            } else if ($singleWhereClause['where'] == 'whereNotNull') {//whereNotNull clause
                $model = $model->whereNotNull($singleWhereClause['column']);
            }//E# if else statement
        }//E# foreach statement
    }

//E# buildWhereClause() method

    /**
     * S# buildScope() method
     * @author Edwin Mugendi
     * Set scopes
     * @param array $scope Scopes
     * @param model an ordered model 
     */
    private function buildScope(&$model, $scope) {
        foreach ($scope as $singleScope) {//Loop through the scopes by array
            $model = $model->$singleScope();
        }//E# foreach statement
    }

//E# buildScope() method
    /**
     * S# buildOrderBy() method
     * @author Edwin Mugendi
     * Build the order the model will be selected
     * @param array $orderBy the order
     * @param model an ordered model 
     */
    private function buildOrderBy(&$model, $orderBy) {
        foreach ($orderBy as $singleOrder) {//Loop through the order by array
            $model = $model->orderBy(key($singleOrder), current($singleOrder));
        }//E# foreach statement
    }

//E# buildOrderBy() method

    /**
     * S# buildOrderByRaw() method
     * @author Edwin Mugendi
     * Build the order the model will be selected using raw sql
     * @param array $orderByRaw the order
     * @param model an ordered model 
     */
    private function buildOrderByRaw(&$model, $orderByRaw) {
        foreach ($orderByRaw as $singleOrder) {//Loop through the order by array
            $model = $model->orderByRaw(\DB::raw($singleOrder));
        }//E# foreach statement
    }

//E# buildOrderByRaw() method

    public function find($id) {
        //Cache model namespace
        $model = \Util::buildNamespace($this->package, $this->controller, 2);

        //Return this model
        return $model::find($id);
    }

//E# find() function

    /**
     * S# createIfValid() function
     * @author Edwin Mugendi
     * Create a model iff array is valid
     * @param array $row the data to be inserted
     * @throws Api400Exception
     * @return mixed 
     * 1. {oject} the create object
     */
    public function createIfValid($row, $valid = false) {
        //Build model namespace
        $modelName = \Util::buildNamespace($this->package, $this->controller, 2);

        //Create a model object
        $model = new $modelName();

        if ($valid == false) {//Row is already valid, hence skip validation
            //Get and set the model's create validation rules
            $this->validationRules = $model->createRules;

            //Validate row to be inserted
            $this->isInputValid();
        }//E# if statement
        //Hip Hip Hurrah!
        //Create model
        $createdModel = $model::create($row);

        if ($createdModel === FALSE) {//Creating model failed
            //Send SMS: Database error
        }//E# if statement
        //Return created model
        return $createdModel;
    }

//E# createIfValid() function

    /**
     * S# updateIfValid() function
     * @author Edwin Mugendi
     * Update a model iff array is valid
     * @param int $id primary key
     * @param array $row the data to be updated
     * @throws Api400Exception
     * @return mixed 
     * 1. {oject} the updated object
     */
    public function updateIfValid($field, $value, $row, $valid = false) {

        //Build model namespace
        $modelName = \Util::buildNamespace($this->package, $this->controller, 2);

        //Create a model object
        $model = new $modelName();

        if ($valid == false) {//Row is valid, skip validation
            //Get and set the model's update validation rules
            $this->validationRules = $model->updateRules;

            //Validate row to be inserted
            $this->isInputValid($row);
        }//E# if statement
        //Hip Hip Hurrah!
        $updatedModel = $this->getModelByField($field, $value);

        if ($updatedModel) {//Updating model failed
            $updatedModel->fill($row);
            $updatedModel->save();

            //Return updated model
            return $updatedModel;
        }//E# if statement

        return '';
    }

//E# updateIfValid() function

    /**
     * S# getModelObject() function
     * Get model object associated with this controller that has no data for the purpose of validation
     * 
     * @return Object Model Object
     */
    private function getModelObject() {
        //Build model namespace
        $modelName = \Util::buildNamespace($this->package, $this->controller, 2);

        //Create a model class
        $modelObject = new $modelName();

        //Return this controller's model object
        return $modelObject;
    }

//E# getModelObject() function

    /**
     * S# postCreate() function
     * Create model associated with this controller
     * 
     * @return function createRedirect
     */
    public function postCreate() {
        //Set the crud id
        $this->crudId = 1;

        //Get this controller's model
        $modelObject = $this->getModelObject();

        //Get and set the model's create validation rules
        $this->validationRules = $modelObject->createRules;

        //Set owned by
        $this->assignOwnedBy();

        //Validate row to be inserted
        $this->validator = $this->isInputValid();

        if ($this->validator->fails()) {//Validation fails
            //Validation error redirect
            return $this->createValidationFailed();
        } else {//Validation passes
            //Just before creating the model
            $this->beforeCreating();

            if (array_key_exists('dateFields', $modelObject)) {
                $this->formatDates($modelObject->dateFields);
            }//E# if statement
            //Should we create this model
            $should_create = $this->shouldCreate();

            if ($should_create) {
                //Create controller model
                $controllerModel = $this->createIfValid($this->input, true);

                //Just after creating the model
                $this->afterCreating($controllerModel);
            } else {
                //Create controller model
                $controllerModel = $this->afterCreating($this->input);
            }//E# if else statement

            if ($this->imageable) {//Imageable
                $this->callController(\Util::buildNamespace('media', 'media', 1), 'relateToMedia', array(&$controllerModel, $this->controller));
            }//E# if statement
            //Redirect to list
            return $this->createRedirect($controllerModel);
        }//E# if else statement
    }

//E# postCreate() function

    /**
     * S# shouldCreate() function
     * 
     * Should we create this model
     * 
     * @return boolean true if we should create, false otherwise
     */
    public function shouldCreate() {
        return true;
    }

//E# shouldCreate() function

    /**
     * S# beforeCreating() function
     * @author Edwin Mugendi
     * Call this just before creating the model
     * Can be used to prepare the inputs
     * @return 
     */
    public function beforeCreating() {
        $this->input['status'] = 1;
        $this->input['created_by'] = $this->user['id'] ? $this->user['id'] : 1;
        $this->input['updated_by'] = $this->user['id'] ? $this->user['id'] : 1;
        return;
    }

//E# beforeCreating() function

    /**
     * S# afterCreating() function
     * @author Edwin Mugendi
     * Call this just after creating the model
     * Can be used to perform post create actions
     * @return 
     */
    public function afterCreating(&$controllerModel) {
        return;
    }

//E# afterCreating() function

    /**
     * S# createRedirect() function
     * @author Edwin Mugendi
     * Redirect after creating the model
     * 
     * @param Model $controllerModel Controller model
     * 
     * @return \Redirect if source is web redirect to controller list page
     * @return \API200Exception if source is "api" throw Success Exception 
     */
    public function createRedirect($controllerModel) {

        //Get success message
        $message = \Lang::get($this->package . '::' . $this->controller . '.notification.created');

        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {//From API
            throw new \Api200Exception(array_only($controllerModel->toArray(), array('id')), $message);
        }//E# if else statement
        //Set notification
        $this->notification = array(
            'type' => 'success',
            'message' => $message
        );

        return \Redirect::route(camel_case($this->package . '_list_' . $this->controller))->with('notification', $this->notification);
    }

//E# createRedirect() function

    /**
     * S# postUpdate() function
     * @author Edwin Mugendi
     * Update model associated with this controller
     * 
     * @param string $field Field
     * @param string $value Value
     * 
     * @return function updateRedirect
     */
    public function postUpdate() {
        //Set the crud id
        $this->crudId = 2;

        //Get this controller's model
        $modelObject = $this->getModelObject();

        //Get and set the model's update validation rules
        $this->validationRules = $modelObject->updateRules;

        //Validate model is owned by a user
        $this->validateModelIsUserOwned($modelObject);

        //Validate row to be updated
        $this->validator = $this->isInputValid();

        if ($this->validator->fails()) {//Validation fails
            //Validation error redirect
            return $this->updateValidationFailed();
        } else {//Validation passes
            //Just before updating the model
            $this->beforeUpdating();

            if (array_key_exists('dateFields', $modelObject)) {
                $this->formatDates($modelObject->dateFields);
            }


            //Update controller model
            $controllerModel = $this->updateIfValid('id', $this->input['id'], $this->input, true);


            if ($controllerModel) {//Model updated
                //Just after updating the model
                $this->afterUpdating($controllerModel);

                if ($this->imageable) {//Imageable
                    $this->callController(\Util::buildNamespace('media', 'media', 1), 'relateToMedia', array(&$controllerModel, $this->controller));
                }//E# if statement
                //Redirect to list
                return $this->updateRedirect($controllerModel);
            }//E# if statement
        }//E# if else statement
    }

//E# postUpdate() function

    /**
     * S# updateValidationFailed() function
     * @author Edwin Mugendi
     * Redirect to the initial post page after failed validation
     * @return \Redirect redirect to post page
     */
    public function updateValidationFailed() {

        //Build parameters to redirect to
        //Redirect to this route with old inputs and errors
        return \Redirect::route(camel_case($this->package . '_post_' . $this->controller), array($this->input['id']))
                        ->withInput()
                        ->withErrors($this->validator);
    }

//E# updateValidationFailed() function

    /**
     * S# beforeUpdating() function
     * @author Edwin Mugendi
     * Call this just before updating the model
     * Can be used to prepare the inputs
     * @return 
     */
    public function beforeUpdating() {
        $this->input['created_by'] = $this->user['id'] ? $this->user['id'] : 1;
        $this->input['updated_by'] = $this->user['id'] ? $this->user['id'] : 1;
        return;
    }

//E# beforeUpdating() function

    /**
     * S# afterUpdating() function
     * @author Edwin Mugendi
     * Call this just after creating the model
     * Can be used to perform post create actions
     * @return 
     */
    public function afterUpdating(&$controllerModel) {
        return;
    }

//E# afterUpdating() function

    /**
     * S# updateRedirect() function
     * @author Edwin Mugendi
     * Redirect after updating the model
     * 
     * @param Model $controllerModel Controller model
     * 
     * @return \Redirect if source is web redirect to controller list page
     * @return \API200Exception if source is "api" throw Success Exception 
     */
    public function updateRedirect($controllerModel) {

        //Get success message
        $message = \Lang::get($this->package . '::' . $this->controller . '.notification.updated');

        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {//From API
            throw new \Api200Exception($controllerModel->toArray(), $message);
        }//E# if else statement
        //Set notification
        $this->notification = array(
            'type' => 'success',
            'message' => $message
        );

        return \Redirect::route(camel_case($this->package . '_list_' . $this->controller))->with('notification', $this->notification);
    }

//E# updateRedirect() function

    /**
     * S# validateModelIsUserOwned() function
     * Append rule to value field that this model should be owned by the this user
     * 
     * @param string $model Model
     */
    private function validateModelIsUserOwned($model) {
        //  if ($model->userOwned) {
        //      $this->validationRules['value'] .= ',user_id,' . $this->user['id'];
        //  }//E# if statement
    }

//E# validateModelIsUserOwned() function

    /**
     * S# postDelete() function
     * Delete model associated with this controller
     * 
     * @param string $field Field
     * @param string $value Value
     * 
     * @return function deleteRedirect
     */
    public function postDelete($field, $value) {
        //Get this controller's model
        $modelObject = $this->getModelObject();

        //Add field and value to input
        $this->addFieldValueToInput($field, $value);

        //Get and set the model's delete validation rules
        $this->validationRules = $modelObject->deleteRules;

        //Validate model is owned by a user
        $this->validateModelIsUserOwned($modelObject);

        //Validate row to be deleted
        $validation = $this->isInputValid();

        //Get model by field
        $controllerModel = $this->getModelByField($field, $value);

        if ($controllerModel) {//Model exists
            if ($this->beforeDeleting($controllerModel)) {
                $controllerModel->delete();
            }//E# if statement
            //After delete callback
            $this->afterDeleting($controllerModel);

            //Delete Redirect
            return $this->deleteRedirect($controllerModel);
        } else {
            //Set notification
            $this->notification = array(
                'field' => $this->input['field'],
                'type' => Str::title($this->controller),
                'value' => $this->input['value'],
            );

            //Throw 404 error
            throw new \Api404Exception($this->notification);
        }//E# if else statement
    }

//E# postDelete() function

    /**
     * S# beforeDeleting() function
     * @author Edwin Mugendi
     * Call this just before deleting the model
     * 
     * @param Model $controllerModel Controller Model
     * 
     * @return boolean true to go aheading with deleting, false not to delete 
     */
    public function beforeDeleting($controllerModel) {

        return true;
    }

//E# beforeDeleting() function

    /**
     * S# beforeDeleting() function
     * @author Edwin Mugendi
     * Call this just after deleting the model
     *
     * @param Model $controllerModel Controller Model
     * 
     * @return; 
     */
    public function afterDeleting($controllerModel) {
        return;
    }

//E# afterDeleting() function

    /**
     * S# deleteRedirect() function
     * @author Edwin Mugendi
     * Redirect after deleting the model
     * 
     * @param Model $controllerModel Controller model
     * 
     * @return \Redirect if source is web redirect to controller list page
     * @return \API200Exception if source is "api" throw Success Exception 
     */
    public function deleteRedirect($controllerModel) {
        if ($this->subdomain == 'api') {//From API
            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.api.delete', array('field' => 'id', 'value' => $controllerModel->id));

            throw new \Api200Exception(array_only($controllerModel->toArray(), array('id')), $message);
        }//E# if else statement

        return \Redirect::route($this->controller . 'List');
    }

//E# deleteRedirect() function

    /**
     * S# createValidationFailed() function
     * @author Edwin Mugendi
     * Redirect to the initial post page after failed validation
     * @return \Redirect redirect to post page
     */
    public function createValidationFailed() {

        //Build parameters to redirect to
        //Redirect to this route with old inputs and errors
        return \Redirect::route(camel_case($this->package . '_post_' . $this->controller))
                        ->withInput()
                        ->withErrors($this->validator);
    }

//E# createValidationFailed() function

    /**
     * S# assignOwnedBy() function
     * Assign Owned By field
     */
    public function assignOwnedBy() {
        if ($this->ownedBy) {//Owned by is set
            foreach ($this->ownedBy as $singleOwnedBy) {
                //Owned by current user
                if ($singleOwnedBy == 'user') {
                    $this->input['user_id'] = $this->currentUser['id'];
                }//E# if statement
                //Owned by current organization
                if ($singleOwnedBy == 'organization') {
                    $this->input['organization_id'] = $this->org['id'];
                }//E# if statement
            }//E# foreach statement
        }//E# if statement
    }

//E# assignOwnedBy() function
}

//E# BaseController() method