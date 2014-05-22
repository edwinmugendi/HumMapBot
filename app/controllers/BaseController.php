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
    public $user;
    //Inputs
    public $input = array();
    //Searchable fields
    public $searchableFields;
    //User Searchable relations
    public $userSearchableRelations;

    public function __construct() {

        $this->user = $this->sessionedUser();
        $this->subdomain = \Session::get('subdomain');
        //Get POSTed data
        $this->input = \Input::get();

        //Cache ip
        $this->input['ipAddress'] = \Request::getClientIp();
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


    public function getAllUsersModelWithMany() {
        //Lazy load to load
        $parameters['lazyLoad'] = $this->userSearchableRelations;

        //Get user by token
        $userModel = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('token', $this->input['token'], $parameters));

        $pluralController = $this->controller . 's';

        if ($this->subdomain == 'api') {//From API
            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.api.getAll');

            throw new Api200Exception($userModel->$pluralController->toArray(), $message);
        }//E# if else statement
    }

    public function getSelect() {
        //Get this controller's model
        $modelObject = $this->getModelObject();

        //Get and set the model's create validation rules
        $this->validationRules = $modelObject->selectRules;

        //Validate row to be inserted
        $validation = $this->isInputValid();
    }

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

                throw new \Api200Exception($this->prepareRelation($controllerModel->toArray()), $message);
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

        if ($this->subdomain == 'api') {//From API
            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.api.getAll');
            //Define relation array
            $relationArray = array();
            foreach ($userModel->$relation->toArray() as $singleRelation) {//Loop through the relations
                $relationArray[] = $this->prepareRelation($singleRelation);
            }//E# foreach statement
            //Throw 200 Exception
            throw new \Api200Exception($relationArray, $message);
        }//E# if else statement
    }

//E# getAllManyModelBelongingToUser() function

    /**
     * S# prepareRelation() function
     * Prepare relation
     * 
     * @param array $rawRelation Raw relation
     */
    public function prepareRelation($rawRelation) {
        return array_except($rawRelation, array('pivot'));
    }

//E# prepareRelation() function

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
                throw new Api200Exception($this->prepareRelation($controllerModel->toArray()), $message);
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
        //Relation
        $relation = $this->controller . 's';

        //Lazy load to load
        $parameters['lazyLoad'] = array($relation);

        //Get user by token
        $userModel = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('token', $this->input['token'], $parameters));

        if ($this->subdomain == 'api') {//From API
            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.api.getAll');

            //Define relation array
            $relationArray = array();
            foreach ($userModel->$relation->toArray() as $singleRelation) {//Loop through the relations
                $relationArray[] = $this->prepareRelation($singleRelation);
            }//E# foreach statement
            throw new \Api200Exception($relationArray, $message);
        }//E# if else statement
    }

//E# getAllModelBelongingToUser() function

    public function getModelFilteredByPivot($findId, $relation, $whereField, $whereValue) {

        return $this->find($findId)->$relation()->wherePivot($whereField, '=', $whereValue)->get();

        //  return Lava\Accounts\UserModel::find($this->user['id'])->vehicles()->wherePivot($this->controller . '_id', '=', $controllerModel->id)->get();
    }

    /**
     * S# buidSingleList() function
     * Build a single list of controller
     * @param array $viewData View Data
     * @return string Single list
     */
    public function buildSingleList($viewData) {

        $controllerList = '';
        foreach ($viewData['controllerModel'] as $singleController) {//Loop via the controller
            //Set the single controller to view data
            $viewData['singleController'] = $singleController;

            //Set user controller to the view data
            $controllerList .= \View::make($this->controller . '.' . $this->controller . 'ListSingleView')
                            ->with('viewData', $viewData)->render();
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

        //Prepare view data
        $viewData = $this->prepareViewData('list');

        //Fields to select
        $fields = array('*');

        //Define parameters
        $parameters = array();

        //Set per page to parameters
        $parameters['paginate'] = 10;

        //Order by id in descending order
        $parameters['orderBy'][] = array('id' => 'desc');

        //Set lazy load parameters
        $parameters['lazyLoad'] = $this->lazyLoad;

        //Select this users
        $viewData['controllerModel'] = $this->select($fields, array(), 2, $parameters);

        //Build the user list and set to view data
        $viewData['controllerList'] = $this->buildSingleList($viewData);

        //Set layout's title
        $this->layout->title = \Lang::get($viewData['controller'] . '.' . $viewData['page'] . '.title');

        //Get and set layout's inline javascript
        $this->layout->inlineJs = $this->injectInlineJs($viewData['page']);

        //Register css and js assets for this page
        $this->layout->assets = $this->registerAssets($viewData['page']);

        //Set top bar box to view data
        $viewData['topBarBox'] = 'search';

        //Set layout's top bar partial
        $this->layout->topBarPartial = $this->getTopBarPartialView($viewData);

        //Set layout's side bar partial
        $this->layout->sideBarPartial = $this->getSideBarPartialView($viewData);

        //Set layout's content view
        $this->layout->contentView = \View::make($viewData['controller'] . '.' . $viewData['view'])
                ->with('viewData', $viewData);

        //Render page
        return $this->layout;
    }

//E# getList() function

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

        if (($this->subdomain == 'api') && $validation->fails()) {//Validation failed
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
    public function injectInlineJs($page, $parameters = array()) {
        //Define js array to be returned
        $js = array();

        //Set login redirect
        $js['loginRedirect'] = \Request::path();

        //Set current page
        $js['page'] = $page;

        //Set base url
        $js['baseUrl'] = \URL::to('/');

        //Set logged
        $js['logged'] = \Auth::check() ? 1 : 0;

        //Set current language
        $js['lang']['current'] = \Config::get('app.locale');

        //Switch through the pages
        switch ($page) {
            case 'transactionDetailedPage': {//Transaction Detailed Page
                    $js['iframe'] = $parameters['transactionModel']['iframe'];
                    $js['callback'] = $parameters['callback'];
                    break;
                }//E# case
            default:
                break;
        }//E# switch statement
        //Append inline javascript to inline Js
        $this->inlineJs .= '<script type="text/javascript">';
        $this->inlineJs .= "var inlineJs = " . json_encode($js) . ";";
        $this->inlineJs .= '</script>';

        //Return inline javascript
        return $this->inlineJs;
    }

//E# injectInlineJs() method

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
     * @param array $viewData top bar partial view data
     * @return view the top bar partial view
     */
    public function getTopBarPartialView($viewData) {
        //Get and return the global top bar partial
        return \View::make('partials.topBar')
                        ->with('viewData', $viewData);
    }

//E# getTopBarPartialView() method

    /**
     * S# getSideBarPartialView() method
     * @author Edwin Mugendi
     * Return side bar partial view for each page
     * @param array $viewData side bar partial view data
     * @return view the side bar partial view
     */
    public function getSideBarPartialView($viewData) {
        //Get and return the global side bar partial
        return \View::make('partials.sideBar')
                        ->with('viewData', $viewData);
    }

//E# getSideBarPartialView() method

    /**
     * S# getFooterBarPartialView() method
     * @author Edwin Mugendi
     * Return footer bar partial view for each page
     * @param array $viewData footer bar partial view data
     * @return view the footer bar partial view
     */
    public function getFooterBarPartialView($viewData) {
        //Get and return the global footer bar partial
        return \View::make('partials.footerBar')
                        ->with('viewData', $viewData);
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

        //Set package to view data
        $viewData['package'] = $this->package;

        //Set controller to view data
        $viewData['controller'] = $this->controller;

        //Set carbon to view data
        $viewData['Carbon'] = new Carbon;

        //Set action to view data
        $viewData['action'] = $action;

        //Set theme to view data
        $viewData['theme'] = $this->theme;

        //Set logged in to view data
        $viewData['logged'] = \Auth::check();

        //Set logged in to view data
        $viewData['user'] = $this->user;

        //Set input data to view data
        $viewData['input'] = $this->input;

        //Set first segment to view data
        $viewData['firstSegment'] = \Request::segment(1);

        //Set view to view data
        $viewData['view'] = camel_case($this->controller . '_' . $action . '_view');

        //Set page to view data
        $viewData['page'] = camel_case($this->controller . '_' . $action . '_page');

        //Set layout's footer bar partial
        $this->layout->footerBarPartial = $this->getFooterBarPartialView($viewData);

        //Return prepared view data
        return $viewData;
    }

//E# prepareViewData() method

    public function get() {
        //Get and set inputs
        $inputs = \Input::get();

        //Parameters
        $whereClause = $parameters = array();

        foreach ($inputs as $key => $value) {
            switch ($key) {
                case 'fields':
                    $fields = explode(',', $value);
                    break;
                case 'sort':
                    $operator = substr($value, 0, 1);
                    if ($operator == '-') {//Sort in descending order
                        $parameters['orderBy'][] = array(substr($value, 1) => 'desc');
                    } else if ($operator == '+') {//Sort in ascending order
                        $parameters['orderBy'][] = array(substr($value, 1) => 'desc');
                    }//E# if else statement 

                    break;
                case 'limit':
                    $parameters['limit'] = $value;

                    if (array_key_exists('offset', $inputs)) {
                        $parameters['offset'] = $value;
                    }//E# if statement

                    break;

                default:
                    $valueParts = explode('_', $value);

                    if (\Str::lower($valueParts[0]) == 'where') {
                        $whereClause[] = array(
                            'where' => 'where',
                            'column' => $key,
                            'operator' => $valueParts[0],
                            'operand' => $valueParts[1]
                        );
                    }//E# if else statement

                    break;
            }
        }//E# foreach statement

        if (!isset($fields)) {//Check if fields is set
            $fields = array('*');
        }//E# if statement


        return $this->select($fields, $whereClause, 2);

        return $fields;
    }

//E# get() function
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

        if (array_key_exists('count', $parameters)) {////Count models and return
            return $selectModel->count();
        }//E# if statement

        if (array_key_exists('orderBy', $parameters)) {//Order model
            $this->buildOrder($selectModel, $parameters['orderBy']);
        }//E# if statement


        if (array_key_exists('lazyLoad', $parameters)) {//Lazy load other models
            $lazyLoad = $this->buildLazyLoad($parameters['lazyLoad']);
            // dd($lazyLoad);
            $selectModel->with($lazyLoad)->get();
        }//E# if statement

        if (array_key_exists('paginate', $parameters)) {//Paginate
            //Return here because paginator object cannot be converted to array or json
            return $selectModel->paginate($parameters['paginate']);
        } else {
            //Get all or first model
            $selectModel = ($oneOrAll == 2) ? $selectModel->get($fields) : $selectModel->first($fields);
            if (array_key_exists('convertTo', $parameters) && $oneOrAll == 2) {//Convert this model to array or json   
                $selectModel = $selectModel->$parameters['convertTo']();
            }//E# if statement
            //Return selected model
            return count($selectModel) ? $selectModel : '';
        }//E# if else statement
    }

//E# post_select() method

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
     * S# buildOrder() method
     * @author Edwin Mugendi
     * Build the order the model will be selected
     * @param model $model the model
     * @param array $orderBy the order
     * @param model an ordered model 
     */
    private function buildOrder(&$model, $orderBy) {
        foreach ($orderBy as $singleOrder) {//Loop through the order by array
            $model = $model->orderBy(key($singleOrder), current($singleOrder));
        }//E# foreach statement
    }

//E# buildOrder() method

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
    public function updateIfValid($id, $row, $valid = false) {

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
        $updatedModel = $model->find($id);

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
        //Get this controller's model
        $modelObject = $this->getModelObject();

        //Get and set the model's create validation rules
        $this->validationRules = $modelObject->createRules;

        //Validate row to be inserted
        $validation = $this->isInputValid();

        if ($validation->fails()) {//Validation fails
            //Validation error redirect
            return $this->failedValidationRedirect($validation, 1);
        } else {//Validation passes
            //Just before creating the model
            $this->beforeCreating();

            //Create controller model
            $controllerModel = $this->createIfValid($this->input, true);

            //Just after creating the model
            $this->afterCreating($controllerModel);

            //Redirect to list
            return $this->createRedirect($controllerModel);
        }//E# if else statement
    }

//E# postCreate() function

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
        if ($this->subdomain == 'api') {//From API
            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.api.create', array('field' => 'id', 'value' => $controllerModel->id));

            throw new \Api200Exception(array_only($controllerModel->toArray(), array('id')), $message);
        }//E# if else statement

        return \Redirect::route($this->controller . 'List');
    }

//E# createRedirect() function

    /**
     * S# postCreate() function
     * @author Edwin Mugendi
     * Update model associated with this controller
     * 
     * @param string $field Field
     * @param string $value Value
     * 
     * @return function updateRedirect
     */
    public function postUpdate($field, $value) {

        //Get this controller's model
        $modelObject = $this->getModelObject();

        //Add field and value to input
        $this->addFieldValueToInput($field, $value);

        //Get and set the model's update validation rules
        $this->validationRules = $modelObject->updateRules;

        //Validate model is owned by a user
        $this->validateModelIsUserOwned($modelObject);

        //Validate row to be updated
        $validation = $this->isInputValid();

        if ($validation->fails()) {//Validation fails
            //Validation error redirect
            return $this->failedValidationRedirect($validation, 2, $this->input['id']);
        } else {//Validation passes
            //Just before updating the model
            $this->beforeUpdating();

            //Update controller model
            $controllerModel = $this->updateIfValid($value, $this->input, true);

            if ($controllerModel) {//Model updated
                //Just after updating the model
                $this->afterUpdating($controllerModel);

                //Redirect to list
                return $this->updateRedirect($controllerModel);
            }//E# if statement
        }//E# if else statement
    }

//E# postUpdate() function

    /**
     * S# beforeUpdating() function
     * @author Edwin Mugendi
     * Call this just before updating the model
     * Can be used to prepare the inputs
     * @return 
     */
    public function beforeUpdating() {
        $this->input['status'] = 1;
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

        if ($this->subdomain == 'api') {//From API
            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.api.update', array('field' => 'id', 'value' => $controllerModel->id));

            throw new \Api200Exception(array_only($controllerModel->toArray(), array('id')), $message);
        }//E# if else statement

        return \Redirect::route($this->controller . 'List');
    }

//E# updateRedirect() function

    /**
     * S# addFieldValueToInput() function
     * Add field and value to input
     * 
     * @param string $field Field
     * @param string $value Value
     */
    private function addFieldValueToInput($field, $value) {
        //Add field and value to inputs
        $this->input['field'] = $field;
        $this->input['value'] = $value;
    }

//E# addFieldValueToInput() function

    /**
     * S# validateModelIsUserOwned() function
     * Append rule to value field that this model should be owned by the this user
     * 
     * @param string $model Model
     */
    private function validateModelIsUserOwned($model) {
        if ($model->userOwned) {
            $this->validationRules['value'] .= ',user_id,' . $this->user['id'];
        }//E# if statement
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
     * S# failedValidationRedirect() function
     * @author Edwin Mugendi
     * Redirect to the initial post page after failed validation
     * @param Object $validation Validation object
     * @param int $crudAction Integer crud action
     * @param int $controllerId The controller id
     * @return \Redirect redirect to post page
     */
    public function failedValidationRedirect($validation, $crudAction, $controllerId = null) {

        if ($crudAction == 1) {//Create action
            //Build parameters to redirect to
            $parameters = array(
                'new'
            );
        } else {//Update Action
            //Build parameters to redirect to
            $parameters = array(
                'update',
                $controllerId
            );
        }//E# if else statement
        //Redirect to this route with old inputs and errors
        return \Redirect::route($this->controller . 'Post', $parameters)
                        ->withInput()
                        ->withErrors($validation);
    }

//E# failedValidationRedirect() function
}

//E# BaseController() method