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

    /**
     * S# beforeViewing() function
     * Prepare fields for list view
     */
    public function beforeViewing(&$singleModel) {
    
    }

//E# beforeViewing() function

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

        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {//From API
            if (array_key_exists('id', $this->input)) {

                //Get model by id
                $card_model = $this->getModelByField('id', $this->input['id']);

                //dd($card_model->count());
                if ($card_model && ($card_model->status == 1) && ($card_model->user_id == $this->user['id'])) {
                    $message = \Lang::get($this->package . '::' . $this->controller . '.notification.list');

                    $card_array = $card_model->toArray();

                    unset($card_array['user']);

                    //Throw Card not found error
                    throw new \Api200Exception($card_array, $message);
                } else {
                    //Set notification
                    $this->notification = array(
                        'field' => 'card_id',
                        'type' => 'Card',
                        'value' => $this->input['id'],
                    );

                    //Throw Card not found error
                    throw new \Api404Exception($this->notification);
                }//E# if else statement
            }//E# if statement
        }//E# if statement
    }

//E# controllerSpecificWhereClause() function
}

//E# CardController() function