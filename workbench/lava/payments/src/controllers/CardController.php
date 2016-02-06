<?php

namespace Lava\Payments;

/**
 * S# CardController() function
 * Card Controller
 * @author Edwin Mugendi
 */
class CardController extends PaymentsBaseController {

    //Controller
    public $controller = 'card';
    //Lazy load
    public $lazyLoad = array();
    //Owned by
    public $ownedBy = array('user');

    /**
     * S# getTestForm() function
     * @author Edwin Mugendi
     * Load the following pages
     * 1. Register page
     * 2. Login page
     * 3. Reset password page
     * 4. Forgot password page
     */
    public function getTestForm() {

        $this->crudId = 1;

        //Prepare view data
        $this->viewData = $this->prepareViewData('form');

        //Set layout's title
        $this->layout->title = \Lang::get($this->viewData['package'] . '::' . $this->viewData['controller'] . '.' . $this->viewData['page'] . '.title');

        //Get and set layout's inline javascript
        $this->layout->inlineJs = $this->injectInlineJs($this->viewData);

        //Register css and js assets for this page
        $this->layout->assets = $this->registerAssets($this->viewData);

        //Set layout's top bar partial
        $this->layout->topBarPartial = $this->getTopBarPartialView();

        //Load content view
        $this->viewData['sideBar'] = '';

        //Load content view
        $this->viewData['contentView'] = \View::make($this->viewData['package'] . '::' . $this->viewData['controller'] . '.' . $this->viewData['view'])
                ->with('viewData', $this->viewData);

        //Set container view
        $this->layout->containerView = $this->getContainerViewPartialView();

        //Render page
        return $this->layout;
    }

//E# getTestForm() function

    /**
     * S# shouldCreate() function
     * 
     * Should we create this model
     * 
     * @return boolean true if we should create, false otherwise
     */
    public function shouldCreate() {
        return false;
    }

//E# shouldCreate() function

    /**
     * S# afterCreating() function
     * @author Edwin Mugendi
     * Call this just after creating the model
     * Can be used to perform post create actions
     * @return 
     */
    public function afterCreating(&$controllerModel) {
        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {

            //Attach card to user
            $stripe_response = $this->callController(\Util::buildNamespace('payments', 'stripe', 1), 'createCard', array(\Auth::user()->stripe_id, $this->input['stripe_token']));

            if ($stripe_response['status']) {//Card created
                //Card details
                $card_array = array(
                    'user_id' => \Auth::user()->id,
                    'gateway' => 'stripe',
                    'token' => $stripe_response['response']->id,
                    'brand' => \Str::lower($stripe_response['response']->brand),
                    'last4' => $stripe_response['response']->last4,
                    'exp_month' => $stripe_response['response']->exp_month,
                    'exp_year' => $stripe_response['response']->exp_year,
                    'address_city' => (is_null($stripe_response['response']->address_city) == false) ? $stripe_response['response']->address_city : '',
                    'address_zip' => (is_null($stripe_response['response']->address_zip) == false) ? $stripe_response['response']->address_zip : '',
                    'address_country' => (is_null($stripe_response['response']->address_country) == false) ? $stripe_response['response']->address_country : '',
                    'address_line1' => (is_null($stripe_response['response']->address_line1) == false) ? $stripe_response['response']->address_line1 : '',
                    'status' => 1,
                    'created_by' => 1,
                    'updated_by' => 1
                );

                //Save model
                $card_model = $this->createIfValid($card_array, true);

                //Get success message
                $message = \Lang::get($this->package . '::' . $this->controller . '.notification.created');

                throw new \Api200Exception($card_model->toArray(), $message);
            } else {
                //Throw 500 Error
                throw new \Api500Exception($stripe_response['response']);
            }//E# if statement
        }//E# if statement
    }

//E# afterCreating() function

    /**
     * S# beforeDeleting() function
     * @author Edwin Mugendi
     * Call this just after deleting the model
     * 
     * @return; 
     */
    public function afterDeleting($controllerModel) {

        //Delete card on app55 and db
        $this->deleteApp55Card($controllerModel);
        return;
    }

//E# afterDeleting() function

    /**
     * S# deleteApp55Card() function
     * Delete card on app55 and database
     * 
     * @param id $app55UserId App55 user id
     * @param string $cardModel Card Model
     *
     */
    public function deleteApp55Card(&$cardModel) {

        //Build delete data
        $deleteData = array(
            'app55UserId' => $cardModel->app55_id,
            'token' => $cardModel->token
        );

        //Delete card on app55
        $deleteCardResponse = $this->callController(\Util::buildNamespace('payments', 'app55', 1), 'deleteCard', array($deleteData));

        if ($deleteCardResponse['status']) {//Card deleted on App55  
            //Fields to select
            $fields = array('id');

            //Set where clause
            $whereClause = array(
                array(
                    'where' => 'where',
                    'column' => 'id',
                    'operator' => '=',
                    'operand' => $cardModel->id
                )
            );

            //Set per page to parameters
            $parameters['withTrashed'] = true;

            //Select this users models
            $cardModel = $this->select($fields, $whereClause, 2, $parameters);

            if ($cardModel) {//Card founds
                foreach ($cardModel as $singleModel) {
                    $singleModel->forceDelete();
                }//E# foreach statement
            }//E# if statement
        }//E# if else statement
    }

//E# deleteApp55Card() function

    /**
     * S# prepareModelToReturn() function
     * Prepare model to relation
     * 
     * @param array $rawRelation Raw relation
     */
    public function prepareModelToReturn($rawRelation) {

        array_except($rawRelation, array('pivot'));

        return $rawRelation;
    }

//E# prepareModelToReturn() function

    /**
     * S# postSync() function
     * Sync cards on App55
     */
    public function postSync() {
        //Sync card on app55
        $this->callController(\Util::buildNamespace('payments', 'app55', 1), 'sync');
    }

//E# postSync() function

    /**
     * S# deleteCard() function
     * Delete card from db and app55
     * 
     * @param string $token Card token
     */
    public function deleteCard($token) {
        $cardModel = $this->getCardIfItExists($token);

        if ($cardModel) {//Card exists
            if ($cardModel->user && ($cardModel->user->id == $this->user['id'])) {//User owns this card
                //Build delete data
                $deleteData = array(
                    'app55UserId' => $cardModel->user->app55_id,
                    'token' => $token
                );
                //Delete card on app55
                $deleteCardResponse = $this->callController(\Util::buildNamespace('payments', 'app55', 1), 'deleteCard', array($deleteData));

                if ($deleteCardResponse['status']) {//Card deleted
                    //Delete card on our database
                    $cardModel->delete();

                    //Get success message
                    $message = \Lang::get($this->package . '::' . $this->controller . '.api.delete', array('field' => 'token', 'value' => $this->input['token']));

                    throw new \Api200Exception(array($this->input['token']), $message);
                } else {//Error occur
                    throw new \Api500Exception($deleteCardResponse['response']);
                }//E# if else statemetn
            } else {
                //Set notification
                $this->notification = array(
                    'field' => 'token',
                    'type' => 'Card',
                    'value' => $this->input['token'],
                );

                //Throw 403 error
                throw new \Api403Exception($this->notification);
            }
        } else {
            //Set notification
            $this->notification = array(
                'field' => 'token',
                'type' => 'Card',
                'value' => $this->input['token'],
            );

            //Throw 404 error
            throw new \Api404Exception($this->notification);
        }//E# if else statement
    }

//E# deleteCard() function

    /**
     * S# getCardIfItExists() function
     * Get card by token
     * 
     * @param string $token Card token
     * @return Model Card Model if exists or false
     */
    private function getCardIfItExists($token) {
        //Add token to inputs
        $this->input['token'] = $token;

        //Validation rules
        $this->validationRules = array(
            'token' => 'required'
        );
        //Validate inputs
        $this->isInputValid();

        //Parameters
        $parameters['lazyLoad'] = array('user');

        //Get card by token
        return $this->getModelByField('token', $this->input['token'], $parameters);
    }

//E# getCardIfItExists() function

    /**
     * S# getVerbativeCardUsed() function
     * @author Edwin Mugendi
     * Get the card used
     * 
     * @param string $token Card token
     * 
     * @return string verbative card
     */
    public function getVerbativeCardUsed($token) {
        $cardModel = $this->getModelByField('token', $token);

        if ($cardModel) {
            return $cardModel->brand . ' XXX ' . $cardModel->last4;
        } else {
            return '';
        }//E# if else statement
    }

//E# getVerbativeCardUsed() function

    /**
     * S# postDrop() function
     * 
     * Drop card
     */
    public function postDrop() {
        //Set validation rules
        $this->validationRules = array(
            'id' => 'required|integer|deleteCard'
        );
        //Validate inputs
        $this->isInputValid();
    }

//E# postDrop() function
}

//E# CardController() function