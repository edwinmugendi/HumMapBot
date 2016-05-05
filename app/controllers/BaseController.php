<?php

use Carbon\Carbon;

/**
 * S# BaseController() Class
 * @author Edwin Mugendi
 * Base Controller
 */
class BaseController extends Controller {

    //Bundle
    public $layout = 'layouts.master';
    //Subdomain
    public $subdomain;
    //Theme
    public $theme = 'nakuru';
    //Lazy load
    public $lazyLoad = array();
    //Validation rules
    protected $validationRules = array();
    //Add validation 
    protected $add_validation_assets = false;
    //Assets
    public $assets = array();
    //Inline Js
    public $inlineJs = '';
    //Notification
    public $notification;
    //User
    public $user, $currentUser, $merchant;
    //Inputs
    public $input = array();
    //Searchable fields
    public $searchableFields;
    //User Searchable relations
    public $userSearchableRelations;
    //Imageable
    public $imageable = false;
    //Mappable
    public $mappable = false;
    //Owned by
    public $ownedBy = array();
    //CrudId
    protected $crudId = -1; //Create = 1, Update = 2, Read = 3, Delete = 4
    //Disable fields
    public $disableFields = false;
    //Soft delete
    public $softDelete = true;

    public function __construct() {
        //Current user
        $this->user = $this->sessionedUser();

        //Get POSTed data
        $this->input = \Input::get();

        //Current merchant
        $this->merchant = $this->sessionedMerchant();

        //Cache ip
        $this->input['ip'] = \Request::getClientIp();
        $this->input['agent'] = \Request::server('HTTP_USER_AGENT');

        //Prep controller
        $this->controller = camel_case($this->controller);
    }

//E# __construct() function

    /**
     * S# appGetCustomMerchantHtmlSelect() function
     * 
     * Get merchant html select based on their role
     * 
     */
    public function appGetCustomMerchantHtmlSelect() {
        if ($this->user['role_id'] == 1) {//Admin
            //Fields to select
            $fields = array('*');
            //Where clause
            $where_clause = array();

            $parameters['scope'] = array('statusOne');

            //Order by
            $parameters['orderBy'][] = array('name' => 'asc');

            //Select models
            $model = $this->callController(\Util::buildNamespace('merchants', 'merchant', 1), 'select', array($fields, $where_clause, 2, $parameters));

            return $this->buildHtmlSelectArray($model, 'id', 'name', \Lang::get('common.select'), '-', array());
        } else if ($this->user['role_id'] == 2) {//Merchant
            return array('' => \Lang::get('common.select'), $this->merchant['id'] => $this->merchant['name']);
        } else {
            return array();
        }//E# if else statement
    }

//E# appGetCustomMerchantHtmlSelect() function

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
     * S# massUpdate() function
     * @author Edwin Mugendi
     * Mass update
     */
    public function massUpdate($where_clause, $dataToUpdate) {

        //Build model namespace
        $modelName = \Util::buildNamespace($this->package, $this->controller, 2);

        //Create a model object
        $model = new $modelName();

        $this->buildWhereClause($model, $where_clause);

        $model->update($dataToUpdate);
    }

//E# massUpdate() function

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
     * S# getMerchantsModels() function
     * 
     * Get merchantanization's models
     * 
     * @param int $merchantId Merchant id
     * @param array $where_clause Where clause
     * @param array $parameters Parameters
     * 
     * @return array Merchant's model
     */
    public function getMerchantsModels($merchantId, $where_clause = array(), $parameters = array()) {
        //Fields to select
        $fields = array('*');

        //Build where clause
        $where_clause[] = array(
            'where' => 'where',
            'column' => 'merchant_id',
            'operator' => '=',
            'operand' => $merchantId
        );

        //Set scope
        $parameters['scope'] = array('statusOne');

        //Select models
        return $this->select($fields, $where_clause, 2, $parameters);
    }

//E# getMerchantsModels() function

    /**
     * S# getMerchantsHtmlSelect() function
     * 
     * Get merchantanizations html select
     * 
     * @param int $merchantId Merchant id
     * @param string $fieldId Field to be the id
     * @param mixed $fieldName Fields to the text
     * @param str $firstLabel First Label
     * @param str $separator field name separator
     * @param array $optionAttributes Fields to add as option attributes
     * @param array $specific_where_clause Specific where clause
     * 
     * 
     */
    public function getMerchantsHtmlSelect($merchantId, $fieldId, $fieldName, $firstLabel = null, $separator = '-', $optionAttributes = null, $specific_where_clause = null) {
        //Fields to select
        $fields = array('*');

        $where_clause = array();

        if ($this->user['role_id'] == 2) {
            //Build where clause
            $where_clause = array(
                array(
                    'where' => 'where',
                    'column' => 'merchant_id',
                    'operator' => '=',
                    'operand' => $merchantId
                )
            );
        }//E# if statement

        if ($specific_where_clause) {
            $where_clause = array_merge($where_clause, $specific_where_clause);
        }//E# if statement
        //Set scope
        $parameters['scope'] = array('statusOne');

        if (is_array($fieldName)) {
            $order_field = $fieldName[0];
        } else {
            $order_field = $fieldName;
        }//E# if else statement
        //Order by
        $parameters['orderBy'][] = array($order_field => 'asc');

        //Select models
        $model = $this->select($fields, $where_clause, 2, $parameters);

        return $this->buildHtmlSelectArray($model, $fieldId, $fieldName, $firstLabel, $separator, $optionAttributes);
    }

//E# getMerchantsHtmlSelect() function

    /**
     * S# buildHtmlSelectArray() function
     * 
     * Get html select data
     * 
     * 
     * @param array $dataArray Data model
     * @param string $fieldId Field to be the id
     * @param mixed $fieldName Fields to the text
     * @param str $firstLable First Label
     * @param str $separator field name separator
     * @param array $optionAttributes Fields to add as option attributes
     * 
     */
    public function buildHtmlSelectArray($dataArray, $fieldId, $fieldName, $firstLabel, $separator, $optionAttributes) {
        $selectData = array();

        if ($firstLabel) {
            $selectData[''] = $firstLabel;
        }//E# if statement

        if ($dataArray) {
            foreach ($dataArray as $singleData) {
                if (is_array($fieldName)) {
                    $selectName = '';
                    $selectNameArray = array();
                    foreach ($fieldName as $singleField) {

                        $selectNameArray[] = $singleData[$singleField];
                    }//E# foreach statement

                    $selectName = implode($separator, $selectNameArray);
                } else {
                    $selectName = $singleData[$fieldName];
                }

                if ($optionAttributes) {
                    //Attributes
                    $attributes = array_only($singleData->toArray(), $optionAttributes);
                    $attributes['text'] = $selectName;
                    $attributes['id'] = $singleData[$fieldId];

                    $selectData[] = $attributes;
                } else {
                    $selectData[$singleData[$fieldId]] = $selectName;
                }//E# if else statement
            }//E# foreach statement
        }//E# statement
        return $selectData;
    }

//E# buildHtmlSelectArray() function

    /**
     * S# updatePivotTable() function
     * @author Edwin Mugendi
     * Update a users pivot table
     * @param Model $controller_model The parent model
     * @param string $relation The relation
     * @param int $relationId The relation's model id 
     * @return none
     */
    public function updatePivotTable(&$controller_model, $relation, $relationId, $dataToUpdate) {
        $controller_model->$relation()->updateExistingPivot($relationId, $dataToUpdate, false);
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
     * S# sessionedMerchant() function
     * @author Edwin Mugendi
     * 
     * Get logged in user's merchant
     * 
     * @return array The logged in user's merchant
     */
    protected function sessionedMerchant() {
        return \Session::get('merchant');
    }

//E# sessionedMerchant() function

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
        $controller_model = $this->getModelByField($this->input['field'], $this->input['value']);

        if ($controller_model) {//Model exists
            if ($controller_model->user_owns) {//User owns this model
                //Get success message
                $message = \Lang::get($this->package . '::' . $this->controller . '.api.getSingle', array('field' => $this->input['field'], 'value' => $this->input['value']));

                throw new \Api200Exception($this->prepareModelToReturn($controller_model->toArray()), $message);
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
        $controller_model = $this->getModelByField($this->input['field'], $this->input['value']);

        if ($controller_model) {//Model exists
            if ($this->subdomain == 'api') {//From API
                //Get success message
                $message = \Lang::get($this->package . '::' . $this->controller . '.api.getSingle', array('field' => $this->input['field'], 'value' => $this->input['value']));

                //Throw 200 Exception
                throw new Api200Exception($this->prepareModelToReturn($controller_model->toArray()), $message);
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
        $where_clause = array(
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
        $controller_model = $this->select($fields, $where_clause, 2, $parameters);

        if ($this->subdomain == 'api') {//From API
            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.api.getAll');

            //Define relation array
            $relationArray = array();

            foreach ($controller_model as $singleRelation) {//Loop through the relations
                $relationArray[] = $this->prepareModelToReturn($singleRelation->toArray());
            }//E# foreach statement
            //Build notification
            $this->notification = array(
                'list' => $relationArray,
                'pagination' => array(
                    'page' => $controller_model->getCurrentPage(),
                    'last_page' => $controller_model->getLastPage(),
                    'per_page' => $controller_model->getPerPage(),
                    'total' => $controller_model->getTotal(),
                    'from' => $controller_model->getFrom(),
                    'to' => $controller_model->getTo(),
                    'count' => $controller_model->count()
                )
            );

            throw new \Api200Exception($this->notification, $message);
        }//E# if else statement
    }

//E# getAllModelBelongingToUser() function

    public function getModelFilteredByPivot($findId, $relation, $whereField, $whereValue) {

        return $this->find($findId)->$relation()->wherePivot($whereField, '=', $whereValue)->get();

        //  return Lava\Accounts\UserModel::find($this->user['id'])->vehicles()->wherePivot($this->controller . '_id', '=', $controller_model->id)->get();
    }

    /**
     * S# getDateFormat() function
     * 
     * Get data format
     * 
     * @return str date format
     */
    public function getDateFormat() {
        if (\Auth::check() && $this->merchant['date_format']) {
            $date_format = \Str::upper($this->merchant['date_format']);
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
        foreach ($this->view_data['controller_model'] as $singleController) {//Loop via the controller
            //Prepare fields for list view
            $this->beforeViewing($singleController);

            if ($this->imageable) {//Imageable
                if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {//API
                    $media = array();
                    $single_media_array = array();
                    foreach ($singleController['media'] as $single_media) {
                        $upload_path = \Config::get('media::media.uploadPath');
                        $single_media_array['is_image'] = $single_media['is_image'];
                        $single_media_array['main_url'] = asset($upload_path . '/' . $single_media['name']);
                        if ($single_media['is_image']) {
                            $single_media_array['thumbnail_url'] = asset($upload_path . '/thumbnails' . $single_media['name']);
                        }//E# if statement
                        $media[] = $single_media_array;
                    }//E# foreach statement

                    unset($singleController['media']);

                    $singleController['images'] = $media;
                } else {//E# if else statement
                    $singleController['main_url'] = $singleController['thumbnail_url'] = '';
                    $singleController['image_count'] = count($singleController['media']);
                    if ($singleController['image_count']) {
                        //Get and set media view to data source
                        $media_response = $this->callController(\Util::buildNamespace('media', 'media', 1), 'formatMediaResponse', array($singleController['media'][0]));

                        $singleController['main_url'] = $singleController['thumbnail_url'] = $media_response['thumbnail_url'];

                        if ($singleController['media'][0]['is_image']) {
                            //Main Url
                            $singleController['main_url'] = $this->view_data['uploadPath'] . '/' . $singleController['media'][0]['name'];
                        }//E# if  statement
                    }//E# if statement
                }//E# if statement
            }//E# if statement
            //Set the single controller to view data
            $this->view_data['singleModel'] = $singleController;

            //Set user controller to the view data
            $controllerList .= \View::make($this->package . '::' . $this->controller . '.' . $this->controller . 'ListSingleView')
                            ->with('view_data', $this->view_data)->render();
        }//E#  foreach statement

        return $controllerList;
    }

//E# buildSingleList() function

    /**
     * S# getDetailed() function
     * @author Edwin Mugendi
     * Load controller's detailed page
     * 
     * @param int $id Controller id
     * 
     * @return View Detailed view
     */
    public function getDetailed($id) {
        //Set crudId
        $this->crudId = 4;

        //Prepare view data
        $this->view_data = $this->prepareViewData('detailed');

        //Fields to select
        $fields = array('*');

        //Define parameters
        $parameters = array();

        $parameters['lazyLoad'] = $this->lazyLoad;

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

        //Inject data sources
        $this->injectDataSources();

        //Prepare fields for detailed view
        $this->beforeViewing($this->view_data['controller_model']);

        //Get this controller's model
        $modelObject = $this->getModelObject();

        $title_array = array();
        foreach ($modelObject->viewFields as $key => $single_field) {
            if (array_key_exists(3, $single_field) && $single_field[3]) {
                if ($single_field[1] == 'select') {
                    $field = $key . '_text';
                    $title_array[] = $this->view_data['controller_model'][$field];
                } else {
                    $title_array[] = $this->view_data['controller_model'][$key];
                }//E# if else statement
            }//E# if statement
        }//E# foreach statement

        $title = implode(' ', $title_array);

        //Set view fields to view data
        $this->view_data['viewFields'] = $modelObject->viewFields;

        if ($this->imageable) {//Is imageable
            //Set the media description to media view data
            $this->view_data['media'] = \Lang::get($this->package . '::' . $this->controller . '.' . camel_case($this->view_data['controller'] . '_post_page') . '.' . $this->controller . 'PostView.form.media');

            //Set media controller to media view data
            $this->view_data['mediaController'] = $this->controller;

            //Get and set media view to data source
            $this->view_data['dataSource']['mediaView'] = $this->callController(\Util::buildNamespace('media', 'media', 1), 'getDetailedPageView', array($this->view_data));
        }//E# if else statement
        //Set layout's title
        $this->layout->title = $this->view_data['title'] = \Lang::get($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['page'] . '.title', array('title' => $title, 'id' => $this->view_data['controller_model']['id']));

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

        if (array_key_exists('export', $this->input) && in_array($this->input['export'], array('pdf', 'print'))) {
            return $this->exportToPdf();
        }//E# if statement

        if (array_key_exists('echo', $this->input)) {
            return $this->view_data['contentView'];
        }//E# if statement
        //Set container view
        $this->layout->containerView = $this->getContainerViewPartialView();

        //Register templates
        $this->layout->containerView .= $this->registerDetailedTemplates();

        //Render page
        return $this->layout;
    }

//E# getDetailed() function

    /**
     * S# registerDetailedTemplates() method
     * @author Edwin Mugendi
     * 
     * Register detailed templates
     * 
     * @return return template
     */
    public function registerDetailedTemplates() {
        
    }

//E# registerDetailedTemplates() function

    /**
     * S# getPost() function
     * Post a new or update contorller
     * @author Edwin Mugendi
     * 
     * @param string $crudAction "new" if we are organizationing a new organization or "update" if we are editing an already existing organization
     * @return page load the create or update page
     */
    public function getPost($id = null, $detailed = null) {

        //Prepare $this->view_data
        $this->view_data = $this->prepareViewData('post');

        //Define organization and datasource array
        $controller_model = $locations = $inlineJsData = $registerAssetsData = array();
        //TODO: Check if the logged in user organization id is the same as this id

        if ($id) {//Update Controller
            //Set crud id
            $this->view_data['crudId'] = $this->crudId = 2;

            //Fields to select
            $fields = array('*');

            //Build where clause
            $where_clause = array(
                array(
                    'where' => 'where',
                    'column' => 'id',
                    'operator' => '=',
                    'operand' => $id
                )
            );

            //Build extra parameters
            $parameters = array();

            $parameters['convertTo'] = 'toArray';

            $parameters['lazyLoad'] = $this->lazyLoad;

            //Select this controller
            $controller_model = $this->select($fields, $where_clause, 1, $parameters);

            if ($this->controller == 'user') {

                \Session::put('currentUser', $controller_model);

                //Set current user
                $this->view_data['currentUser'] = $controller_model;
            }//E# if statement
        } else {//New controller
            //Set crud id
            $this->view_data['crudId'] = $this->crudId = 1;

            $controller_model['id'] = -1;
            $controller_model['lat'] = -1;
            $controller_model['lng'] = -1;
        }//E# if else statement
        //TODO: Set the organization id from the session
        $controller_model['merchant_id'] = $this->merchant['id'];

        //Set organization to inline js data
        $this->view_data['controller_model'] = $controller_model;

        //Inject data sources
        $this->injectDataSources();

        if ($this->imageable) {//Is imageable
            //Set the media description to media view data
            $this->view_data['media'] = \Lang::get($this->package . '::' . $this->controller . '.' . $this->view_data['page'] . '.' . $this->controller . 'PostView.form.media');

            //Set media controller to media view data
            $this->view_data['mediaController'] = $this->controller;

            //Get and set media view to data source
            $this->view_data['dataSource']['mediaView'] = $this->callController(\Util::buildNamespace('media', 'media', 1), 'getMediaView', array($this->view_data));
        }//E# if else statement

        if ($this->mappable) {//Is mappable
            //Get and set map view to data source
            $this->view_data['dataSource']['mapView'] = $this->callController(\Util::buildNamespace('locations', 'location', 1), 'getMapView', array($controller_model['lat'], $controller_model['lng']));
        }//E# if else statement
        //Set locations to inline js data
        //Get and set organization organization form to view data
        $form = \Lang::get($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['page'] . '.' . $this->view_data['controller'] . 'PostView.form.' . camel_case($this->view_data['controller'] . '_' . $this->view_data['action']));

        //Set layout's title
        $this->layout->title = \Lang::get($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['page'] . '.actionTitle.' . $this->view_data['crudId']);

        //Get and set layout's inline javascript
        $this->layout->inlineJs = $this->injectInlineJs($this->view_data);

        //Register css and js assets for this page
        $this->layout->assets = $this->registerAssets($this->view_data);

        //Set layout's top bar partial
        $this->layout->topBarPartial = $this->getTopBarPartialView();

        //Set side bar
        //$this->view_data['sideBar'] = $this->getPostSideBarPartialView();
        //Set layout's side bar partial
        $this->layout->sideBarPartial = $this->getSideBarPartialView();

        //Add form to view data
        $this->view_data['form'] = \View::make('form.formBuilder')
                ->with('form', $form)
                ->with('crudId', $this->view_data['crudId'])
                ->with('model', $this->view_data['controller_model'])
                ->with('disableFields', $this->disableFields)
                ->with('dataSource', $this->view_data['dataSource'])
                ->with('date_format', $this->convertDateFormat($this->getDateFormat()))
                ->with('Carbon', $this->view_data['Carbon']);

        if (array_key_exists('echo', $this->input)) {
            return $this->view_data['form'];
        }//E# if statement
        //Load content view
        $this->view_data['contentView'] = \View::make($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['view'])
                ->with('view_data', $this->view_data);

        //Set container view
        $this->layout->containerView = $this->getContainerViewPartialView();

        //Register templates
        $this->layout->containerView .= $this->registerPostTemplates();

        //Render page
        return $this->layout;
    }

//E# getPost() function

    /**
     * S# registerPostTemplates() method
     * @author Edwin Mugendi
     * 
     * Register location picker component templates
     * 
     * @param array $this->view_data View data
     * 
     * @return return template
     */
    public function registerPostTemplates() {
        
    }

//E# registerPostTemplates() function

    /**
     * S# exportToCsv() function
     * Export to CSV
     * 
     * @return CSV download or text to show on browser
     */
    public function exportToCsv() {
        return \Excel::create($this->merchant['name'] . '-' . $this->layout->title, function($excel) {

                    // Set the title
                    $excel->setTitle($this->merchant['name'] . '-' . $this->layout->title);
                    $excel->setCreator($this->user['first_name'] . ' ' . $this->user['last_name']);
                    $excel->setCompany($this->merchant['name']);

                    // Call them separately
                    $excel->setDescription($this->layout->title);

                    if (is_array($this->view_data['controller_model'])) {
                        $data_array = $this->view_data['controller_model'];
                    } else {
                        $data_array = $this->view_data['controller_model']->toArray();
                        $data_array = $data_array['data'];
                    }//E# if else statement

                    $excel->sheet('Sheet 1', function($sheet) use($data_array) {

                        $sheet->fromArray($data_array);
                    });
                })->export($this->input['export']);
    }

//E# exportToCsv() function

    /**
     * S# exportToPdf() function
     * Export to PDF
     * 
     * @return PDF download or text to show on browser
     */
    public function exportToPdf() {
        //Set title to view data
        $this->view_data['title'] = $this->layout->title;

        //Get Pdf content
        $pdf_content = \View::make('reports.pdfView')
                ->with('view_data', $this->view_data);

        //Download or show
        $download_or_show = $this->input['export'] == 'pdf' ? 'download' : 'show';

        //Set orientation
        $orientation = \Lang::has($this->package . '::' . $this->controller . '.pdf') ? \Lang::get($this->package . '::' . $this->controller . '.pdf') : 'portrait';

        if ($orientation == 'portrait' && $this->imageable) {
            $orientation = 'landscape';
        }//E# if statement
        //Return PDF
        $this->pdf($pdf_content, $orientation, 'A4', $download_or_show, $this->merchant['name'] . '-' . $this->layout->title);
    }

//E# exportToPdf() function

    /**
     * S# pdf() function
     * @param str $content Content
     * @param str $orientation Pdf orientation
     * @param str $size Page size
     * @param str $download_or_show_or_output Download or show output
     * @param str $name name to be used to save the pdf (Optional)
     * 
     * @return OBJECT PDF
     */
    public function pdf($content, $orientation, $size, $download_or_show_or_output, $name = null) {
        $pdf = new \Thujohn\Pdf\Pdf();
        //Return PDF
        return ($name) ? $pdf->load($content, $size, $orientation)->$download_or_show_or_output($name) : \PDF::load($content, $size, $orientation)->$download_or_show_or_output();
    }

    //E# pdf() function

    /**
     * S# getList() function
     * @author Edwin Mugendi
     * Load controller's list page
     */
    public function getList() {

        //Set crudId
        $this->crudId = 3;


        //Prepare view data
        $this->view_data = $this->prepareViewData('list');

        //Set layout's title
        $this->layout->title = \Lang::get($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['page'] . '.title');

        //Order
        $this->view_data['dataSource']['per_page'] = \BaseArrayDataModel::getPerPageSelectOptions($this->package, $this->controller);

        //Order
        $this->view_data['dataSource']['order'] = \BaseArrayDataModel::getOrderSelectOptions($this->package, $this->controller);

        //Define parameters
        $this->view_data['paginationAppends'] = $where_clause = $parameters = array();


        //Inject Data Sources
        $this->injectDataSources();

        //Inject View data
        $this->injectViewData();

        //Cache model namespace
        $model = \Util::buildNamespace($this->package, $this->controller, 2);

        //Create a model
        $view_data['model'] = new $model;

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
        $this->view_data['paginationAppends']['per_page'] = $parameters['paginate'] = $per_page;

        //Set export
        if (array_key_exists('export', $this->input) && in_array($this->input['export'], array('pdf', 'print', 'csv', 'xls'))) {
            $this->view_data['export'] = $this->input['export'];
            //Override per page
            $this->view_data['paginationAppends']['per_page'] = $parameters['paginate'] = 1000;
        }//if else statement

        if (array_key_exists('sort', $this->input) && property_exists($view_data['model'], 'viewFields') && array_key_exists($this->input['sort'], $view_data['model']->viewFields)) {//Sort field
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
        $this->buildSearchWhereClause($fields, $where_clause, $parameters, $view_data['model']);

        //Build where clause based on role
        $this->roleBasedWhereClause($fields, $where_clause, $parameters);

        //Set owned by where clause
        $this->setOwnedBy($where_clause);

        //Set scope
        $parameters['scope'] = array('statusOne');

        //Call controller specific where clause
        $this->controllerSpecificWhereClause($fields, $where_clause, $parameters);

        //Select this users
        $this->view_data['controller_model'] = $this->select($fields, $where_clause, 2, $parameters);

        //Prepare controller model
        $this->prepareControllerModel();

        //Build the user list and set to view data
        $this->view_data['controllerList'] = $this->buildSingleList($this->view_data);

        //return $this->view_data['controller_model'][0];
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


        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {

            //Prepare controller model
            $this->prepareControllerModel();

            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.notification.list');

            throw new \Api200Exception($this->view_data['controller_model']->toArray(), $message);
        }//E# if statement
        //Load content view
        $this->view_data['contentView'] = \View::make($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['view'])
                ->with('view_data', $this->view_data);

        if (array_key_exists('export', $this->input) && in_array($this->input['export'], array('csv', 'xls'))) {
            return $this->exportToCsv();
        }//E# if statement

        if (array_key_exists('export', $this->input) && in_array($this->input['export'], array('pdf', 'print'))) {
            return $this->exportToPdf();
        }//E# if statement

        if (array_key_exists('echo', $this->input)) {
            return $this->view_data['contentView'];
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
     * @param array $where_clause Where clause
     * @param model $model Model
     * 
     * @param Model $model Model
     */
    public function buildSearchWhereClause(&$fields, &$where_clause, &$parameters, &$model) {

        if (property_exists($model, 'viewFields')) {//Search fields exist
            foreach ($this->input as $key => $value) {//Loop via the inputs
                if (array_key_exists($key, $model->viewFields)) {
                    if ($value) {

                        //Append to pagination
                        $this->view_data['paginationAppends'][$key] = $value;

                        if ($model->viewFields[$key][2] == 'like') {
                            $value = '%' . $value . '%';
                        }//E# if statement
                        //Append where clause
                        $where_clause[] = array(
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
     * @param array $where_clause Where clause
     * @param array $parameters Parameters
     */
    public function roleBasedWhereClause($fields, &$where_clause, &$parameters) {
        
    }

//E# roleBasedWhereClause() function

    /**
     * S#setOwnedBy() function
     * 
     * Set owned by where clause to get only models owned by the respective model
     * 
     * @param type $where_clause
     */
    public function setOwnedBy(&$where_clause) {

        if ($this->ownedBy) {//Owned by is set
            foreach ($this->ownedBy as $singleOwnedBy) {
                //Owned by current user
                if ($singleOwnedBy == 'user') {
                    $where_clause[] = array(
                        'where' => 'where',
                        'column' => 'user_id',
                        'operator' => '=',
                        'operand' => $this->user['id']
                    );
                }//E# if statement
                //Owned by current merchant
                if ($singleOwnedBy == 'merchant') {
                    $where_clause[] = array(
                        'where' => 'where',
                        'column' => 'merchant_id',
                        'operator' => '=',
                        'operand' => $this->merchant['id']
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
     * @param array $where_clause Where clause
     * @param array $parameters Parameters
     */
    public function controllerSpecificWhereClause(&$fields, &$where_clause, &$parameters) {
        
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

        //Set mappable
        $js['mappable'] = $this->mappable;

        //Set base url
        $js['baseUrl'] = \URL::to('/');

        //Set logged
        $js['logged'] = \Auth::check() ? 1 : 0;

        //Set current language
        $js['lang']['current'] = \Config::get('app.locale');

        //Set property
        $js['controller_model'] = array_key_exists('controller_model', $parameters) ? $parameters['controller_model'] : false;

        if ($parameters['page'] == $this->controller . 'ListPage' || $parameters['page'] == $this->controller . 'DetailedPage') {
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

        if ($this->mappable && (($parameters['page'] == $this->controller . 'PostPage') || ($parameters['page'] == $this->controller . 'DetailedPage'))) {//Load map picker component
            //Set google maps link
            $js['googleMaps'] = "https://maps.googleapis.com/maps/api/js?key=" . \Config::get('thirdParty.google.api_key') . "&callback=zoomTo&language=" . \Config::get('app.locale');
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
    public function registerAssets($parameters = array()) {
        //Register global css assets
        $this->assets['css'][] = \HTML::style('bootstrap/css/bootstrap.min.css');
        $this->assets['css'][] = \HTML::style('bootstrap/css/font-awesome.min.css');
        $this->assets['css'][] = \HTML::style('bootstrap/css/icons.css');

        //Custom Design
        $this->assets['css'][] = \HTML::style('css/gentallela/animate.min.css');
        $this->assets['css'][] = \HTML::style('css/gentallela/custom.css');
        $this->assets['css'][] = \HTML::style('css/gentallela/jquery-jvectormap-2.0.3.css');
        $this->assets['css'][] = \HTML::style('css/gentallela/icheck/flat/green.css');
        $this->assets['css'][] = \HTML::style('css/gentallela/floatexamples.css');

        $this->assets['js'][] = \HTML::script('js/gentallela/nprogress.js');

        //Register global js assets
        $this->assets['js'][] = \HTML::script('bootstrap/js/bootstrap.min.js');

        //Date Picker js
        // $this->assets['js'][] = \HTML::script('js/datePicker/moment.min.js');
        $this->assets['js'][] = \HTML::script('js/datePicker/bootstrap-datetimepicker-and-moment.min.js');

        //Gentallela
        //Gauge
        //$this->assets['js'][] = \HTML::script('js/gentallela/gauge/gauge.min.js');
        //$this->assets['js'][] = \HTML::script('js/gentallela/gauge/gauge_demo.js');
        //Chart js
        $this->assets['js'][] = \HTML::script('js/gentallela/chartjs/chart.min.js');

        //Bootstrap progress
        $this->assets['js'][] = \HTML::script('js/gentallela/progressbar/bootstrap-progressbar.min.js');
        $this->assets['js'][] = \HTML::script('js/gentallela/nicescroll/jquery.nicescroll.min.js');

        //Custom 
        /* E# Gentallela */

        //Notification Js
        $this->assets['js'][] = \HTML::script('js/pnotify/jquery.pnotify.min.js');

        //Dialog Box Js
        $this->assets['js'][] = \HTML::script('js/bootbox/bootbox.min.js');

        if ($parameters['page'] == ($this->controller . 'PostPage') || $this->add_validation_assets) {//Load Location picker component
            //Validation Engine js
            $this->assets['js'][] = \HTML::script('js/validationEngine/languages/jquery.validationEngine-' . \Config::get('app.locale') . '.js');
            $this->assets['js'][] = \HTML::script('js/validationEngine/jquery.validationEngine.js');
        }//E# if else statement

        if ($this->imageable && $parameters['page'] == ($this->controller . 'PostPage')) {//Load Media picker component
            //LinkedIn Frontend Templating js
            $this->assets['js'][] = \HTML::script('js/linkedInDust/dust-full-2.0.0.min.js');

            //Sortable js
            $this->assets['js'][] = \HTML::script('js/sortable/jquery.sortable.min.js');

            //Image upload js
            $this->assets['js'][] = \HTML::script('js/fileupload/vendor/jquery.ui.widget.js');
            $this->assets['js'][] = \HTML::script('js/fileupload/load-image.min.js');
            $this->assets['js'][] = \HTML::script('js/fileupload/canvas-to-blob.min.js');
            $this->assets['js'][] = \HTML::script('js/fileupload/jquery.iframe-transport.js');
            $this->assets['js'][] = \HTML::script('js/fileupload/jquery.fileupload.js');
            $this->assets['js'][] = \HTML::script('js/fileupload/jquery.fileupload-process.js');
            $this->assets['js'][] = \HTML::script('js/fileupload/jquery.fileupload-image.js');
            $this->assets['js'][] = \HTML::script('js/fileupload/jquery.fileupload-validate.js');
            $this->assets['js'][] = \HTML::script('js/fileupload/jquery.fileupload-ui.js');
            $this->assets['js'][] = \HTML::script('js/fileupload/main.js');
        }//E# if statement
        // dd($parameters['page']);
        //Switch through the pages
        switch ($parameters['page']) {
            case 'organizationPostPage': {//Organization Post page
                    //Validation Engine js
                    $this->assets['js'][] = \HTML::script('js/validationEngine/languages/jquery.validationEngine-' . \Config::get('app.locale') . '.js');
                    $this->assets['js'][] = \HTML::script('js/validationEngine/jquery.validationEngine.js');
                    break;
                }//E# case
            case 'aboutHomePage': {//About home page
                    //Galleria js
                    $this->assets['js'][] = \HTML::script('js/galleria/galleria-1.2.9.min.js');
                    break;
                }//E# case
            case 'dashboardDashboardPage': {//User Dashboard Page
                    //Charting Flot plugin
                    $this->assets['js'][] = \HTML::script('js/flot/jquery.flot.min.js');
                    $this->assets['js'][] = \HTML::script('js/flot/jquery.flot.pie.min.js');
                    $this->assets['js'][] = \HTML::script('js/flot/jquery.flot.time.min.js');
                    $this->assets['js'][] = \HTML::script('js/flot/jquery.flot.spline.js');
                    $this->assets['js'][] = \HTML::script('js/flot/jquery.flot.stack.js');
                    $this->assets['js'][] = \HTML::script('js/flot/jquery.flot.resize.js');
                    $this->assets['js'][] = \HTML::script('js/flot/jquery.flot.date.js');
                    $this->assets['js'][] = \HTML::script('js/flot/jquery.flot.orderBars.js');

                    //Date picker
                    $this->assets['js'][] = \HTML::script('js/datePicker/daterangepicker.js');

                    break;
                }//E# case
            case 'applicationPostPage': {//Organization Post page
                    //Moment Js
                    $this->assets['js'][] = \HTML::script('js/moment/moment.min.js');
                    break;
                }//E# case

            default:
                break;
        }//E# switch statement

        $this->assets['js'][] = \HTML::script('js/gentallela/custom.js');

        //Register css assets
        $this->assets['css'][] = \HTML::style('css/themes/' . $this->theme . '/' . $this->theme . '.css?time=' . time());

        //Register js assets
        $this->assets['js'][] = \HTML::script('js/themes/' . $this->theme . '/' . $this->theme . '.js?time=' . time());

        return $this->assets;
    }

//E# registerAssets() method

    /**
     * S# getSideBarPartialView() method
     * @author Edwin Mugendi
     * Return side bar partial view for each page
     * @return view the side bar partial view
     */
    public function getSideBarPartialView() {
        //Get and return the global side bar partial
        return \View::make('partials.sideBar')
                        ->with('view_data', $this->view_data);
    }

//E# getSideBarPartialView() method

    /**
     * S# getTopBarPartialView() method
     * @author Edwin Mugendi
     * Return top bar partial view for each page
     * @return view the top bar partial view
     */
    public function getTopBarPartialView() {
        //Get and return the global top bar partial
        return \View::make('partials.topBar')
                        ->with('view_data', $this->view_data);
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
                        ->with('view_data', $this->view_data);
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
                        ->with('view_data', $this->view_data);
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
                        ->with('view_data', $this->view_data);
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
                        ->with('view_data', $this->view_data);
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
        $this->view_data['dataSource'] = array();

        //Set package to view data
        $this->view_data['package'] = $this->package;

        //Set controller to view data
        $this->view_data['controller'] = $this->controller;

        //Set carbon to view data
        $this->view_data['Carbon'] = new Carbon;

        //Set action to view data
        $this->view_data['action'] = $action;

        //Set theme to view data
        $this->view_data['theme'] = $this->theme;

        //Set logged in to view data
        $this->layout->logged = $this->view_data['logged'] = \Auth::check();

        //Set logged in user to view data
        $this->view_data['user'] = $this->user;

        //Set current user to view data
        //$this->view_data['currentUser'] = $this->currentUser;
        //Set current user to view data
        $this->view_data['merchant'] = $this->merchant;

        //dd($this->view_data['merchant']);
        //Set input data to view data
        $this->view_data['input'] = $this->input;

        //Set disable Fields to view data
        $this->view_data['disableFields'] = $this->disableFields;

        //Set segment to view data
        $this->view_data['segments'] = \Request::segments();

        //Set environment to view data
        $this->view_data['env'] = App::environment();

        //Set date_format to view data
        $this->view_data['date_format'] = $this->convertDateFormat($this->getDateFormat());

        //Set imageable to view data
        $this->view_data['imageable'] = $this->imageable;

        if ($this->imageable) {
            //Set uploadpath to view data
            $this->view_data['uploadPath'] = \URL::to('/') . \Config::get('media::media.uploadPath');
        }//E# if statement
        //Set view to view data
        $this->view_data['view'] = camel_case($this->controller . '_' . $action . '_view');

        //Set page to view data
        $this->view_data['page'] = camel_case($this->controller . '_' . $action . '_page');

        //Set layout's footer bar partial
        $this->layout->footerBarPartial = $this->getFooterBarPartialView($this->view_data);

        //Return prepared view data
        return $this->view_data;
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
        $where_clause = array(
            array(
                'where' => 'where',
                'column' => $field,
                'operator' => '=',
                'operand' => $value
            )
        );
        //Select model by field
        return $this->select($fields, $where_clause, 1, $parameters);
    }

    public function delete($where_clause) {
        //Cache model namespace
        $model = \Util::buildNamespace($this->package, $this->controller, 2);

        //Create a model
        $deleteModel = new $model();

        //Build where clause
        $this->buildWhereClause($deleteModel, $where_clause);

        return $deleteModel->delete();
    }

//E# delete() function
    public function select($fields, $where_clause, $oneOrAll, $parameters = array()) {

        //Cache model namespace
        $model = \Util::buildNamespace($this->package, $this->controller, 2);

        //Create a model
        $selectModel = new $model();

        //Build where clause
        $this->buildWhereClause($selectModel, $where_clause);

        if (array_key_exists('distinct', $parameters)) {//Distinct
            $selectModel = $selectModel->distinct($parameters['distinct']);
        }//E# if statement

        if (array_key_exists('withTrashed', $parameters)) {//Load Trashed models
            $selectModel = $selectModel->withTrashed();
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

        if (array_key_exists('count', $parameters)) {//Count models and return
            return $selectModel->count();
        }//E# if statement

        if (array_key_exists('countField', $parameters)) {//Count models and return
            return $selectModel->count($parameters['countField']);
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
    private function buildWhereClause(&$model, &$where_clause) {
        foreach ($where_clause as $singleWhereClause) {//Loop through the where clause
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

        //Append custom validation rules
        $this->appendCustomValidationRules();

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
                $controller_model = $this->createIfValid($this->input, true);

                //Just after creating the model
                $this->afterCreating($controller_model);
            } else {
                //Create controller model
                $controller_model = $this->afterCreating($this->input);
            }//E# if else statement

            if ($this->imageable) {//Imageable
                $this->callController(\Util::buildNamespace('media', 'media', 1), 'relateToMedia', array(&$controller_model, $this->controller));
            }//E# if statement
            //Redirect to list
            return $this->createRedirect($controller_model);
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
    public function afterCreating(&$controller_model) {
        return;
    }

//E# afterCreating() function

    /**
     * S# createRedirect() function
     * @author Edwin Mugendi
     * Redirect after creating the model
     * 
     * @param Model $controller_model Controller model
     * 
     * @return \Redirect if source is web redirect to controller list page
     * @return \API200Exception if source is "api" throw Success Exception 
     */
    public function createRedirect($controller_model) {

        //Get success message
        $message = \Lang::get($this->package . '::' . $this->controller . '.notification.created');

        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {//From API
            throw new \Api200Exception(array_only($controller_model->toArray(), array('id')), $message);
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
     * S# appendCustomValidationRules() function
     * 
     * Append custom validation rules.
     * 
     * This mainly happens when we need to access the id of object. Eg when updating an object with unique validation rule in it
     * 
     * Make sure you have if else for create and update
     * if($this->crudId == 2){}
     */
    public function appendCustomValidationRules() {

        return;
    }

//E# appendCustomValidationRules() function

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

        //Append custom validation rules
        $this->appendCustomValidationRules();

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
            $controller_model = $this->updateIfValid('id', $this->input['id'], $this->input, true);


            if ($controller_model) {//Model updated
                //Just after updating the model
                $this->afterUpdating($controller_model);

                if ($this->imageable) {//Imageable
                    $this->callController(\Util::buildNamespace('media', 'media', 1), 'relateToMedia', array(&$controller_model, $this->controller));
                }//E# if statement
                //Redirect to list
                return $this->updateRedirect($controller_model);
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
    public function afterUpdating(&$controller_model) {
        return;
    }

//E# afterUpdating() function

    /**
     * S# updateRedirect() function
     * @author Edwin Mugendi
     * Redirect after updating the model
     * 
     * @param Model $controller_model Controller model
     * 
     * @return \Redirect if source is web redirect to controller list page
     * @return \API200Exception if source is "api" throw Success Exception 
     */
    public function updateRedirect($controller_model) {

        //Get success message
        $message = \Lang::get($this->package . '::' . $this->controller . '.notification.updated');

        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {//From API
            throw new \Api200Exception($controller_model->toArray(), $message);
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
     * 
     * Delete model associated with this controller
     *  
     */
    public function postDelete() {
        //TODO: Check if user owns this model or 
        //TODO: Is owned by his organization
        //Get this controller's model
        $modelObject = $this->getModelObject();

        foreach ($this->input['ids'] as $id) {
            $response = array();

            //Validate model is owned by a user
            //$this->validateModelIsUserOwned($modelObject);
            //Set scope
            $parameters['scope'] = array('statusOne');

            //Get model by field
            $controller_model = $this->getModelByField('id', $id, $parameters);

            if ($controller_model) {//Model exists
                if ($this->beforeDeleting($controller_model, $response)) {
                    if ($this->softDelete) {//Soft delete
                        $controller_model->status = 2;
                        $controller_model->save();
                    } else {//Actual delete
                        $controller_model->delete();
                    }//E# if else statement
                    //Set reponse for this model
                    $response = array(
                        'id' => $id,
                        'code' => 200,
                        'message' => \Lang::get($this->package . '::' . $this->controller . '.notification.deleted', array('field' => 'id', 'value' => $controller_model->id))
                    );
                }//E# if statement
                //After delete callback
                $this->afterDeleting($controller_model);

                //Delete Redirect
                //return $this->deleteRedirect($controller_model);
            } else {
                //Set notification
                $parameters = array(
                    'field' => 'id',
                    'type' => Str::title($this->controller),
                    'value' => $id,
                );

                //Set reponse for this model
                $response = array(
                    'id' => $id,
                    'code' => 404,
                    'message' => \Lang::get('httpStatus.system_code.904.developer_message', $parameters)
                );
            }//E# if else statement

            $this->notification[] = $response;
        }//E# foreach statement

        return $this->notification;
    }

//E# postDelete() function

    /**
     * S# postUndelete() function
     * Un delete
     */
    public function postUndelete() {
        //Get this controller's model
        $modelObject = $this->getModelObject();

        foreach ($this->input['ids'] as $id) {
            $response = array();

            //Validate model is owned by a user
            //$this->validateModelIsUserOwned($modelObject);
            //Set scope
            $parameters['scope'] = array('statusTwo');

            //Get model by field
            $controller_model = $this->getModelByField('id', $id, $parameters);

            if ($controller_model) {//Model exists
                if ($this->softDelete) {//Un delete
                    $controller_model->status = 1;
                    $controller_model->save();

                    //Set reponse for this model
                    $response = array(
                        'id' => $id,
                        'code' => 200,
                        'message' => \Lang::get($this->package . '::' . $this->controller . '.notification.deleted', array('field' => 'id', 'value' => $controller_model->id))
                    );
                }//E# if else statement
            } else {
                //Set notification
                $parameters = array(
                    'field' => 'id',
                    'type' => Str::title($this->controller),
                    'value' => $id,
                );

                //Set reponse for this model
                $response = array(
                    'id' => $id,
                    'code' => 404,
                    'message' => \Lang::get('httpStatus.systemCode.904.developerMessage', $parameters)
                );
            }//E# if else statement

            $this->notification[] = $response;
        }//E# foreach statement

        return $this->notification;
    }

    /**
     * S# beforeDeleting() function
     * @author Edwin Mugendi
     * Call this just before deleting the model
     * 
     * @param Model $controller_model Controller Model
     * 
     * @return boolean true to go aheading with deleting, false not to delete 
     */
    public function beforeDeleting($controller_model) {

        return true;
    }

//E# beforeDeleting() function

    /**
     * S# beforeDeleting() function
     * @author Edwin Mugendi
     * Call this just after deleting the model
     *
     * @param Model $controller_model Controller Model
     * 
     * @return; 
     */
    public function afterDeleting($controller_model) {
        return;
    }

//E# afterDeleting() function

    /**
     * S# deleteRedirect() function
     * @author Edwin Mugendi
     * Redirect after deleting the model
     * 
     * @param Model $controller_model Controller model
     * 
     * @return \Redirect if source is web redirect to controller list page
     * @return \API200Exception if source is "api" throw Success Exception 
     */
    public function deleteRedirect($controller_model) {
        if ($this->subdomain == 'api') {//From API
            //Get success message
            $message = \Lang::get($this->package . '::' . $this->controller . '.api.delete', array('field' => 'id', 'value' => $controller_model->id));

            throw new \Api200Exception(array_only($controller_model->toArray(), array('id')), $message);
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
                    $this->input['user_id'] = $this->user['id'];
                }//E# if statement
                //Owned by current merchant
                if ($singleOwnedBy == 'merchant') {
                    $this->input['merchant_id'] = $this->merchant['id'];
                }//E# if statement
            }//E# foreach statement
        }//E# if statement
    }

//E# assignOwnedBy() function
}

//E# BaseController() method