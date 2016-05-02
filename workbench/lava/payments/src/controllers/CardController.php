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

    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {

        //Get this organization user id
        $this->view_data['dataSource']['user_id'] = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getMerchantsHtmlSelect', array($this->merchant['id'], 'id', array('first_name', 'last_name'), \Lang::get('common.select')));

        //Get and set type options to data source
        $this->view_data['dataSource']['type'] = \Lang::get($this->package . '::' . $this->controller . '.data.type');
    }

//E# injectDataSources() function

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
        $this->view_data = $this->prepareViewData('form');

        //Set layout's title
        $this->layout->title = \Lang::get($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['page'] . '.title');

        //Get and set layout's inline javascript
        $this->layout->inlineJs = $this->injectInlineJs($this->view_data);

        //Register css and js assets for this page
        $this->layout->assets = $this->registerAssets($this->view_data);

        //Set layout's top bar partial
        $this->layout->topBarPartial = $this->getTopBarPartialView();
        
        //Set layout's top bar partial
        $this->layout->sideBarPartial = $this->getSideBarPartialView();

        //Load content view
        $this->view_data['contentView'] = \View::make($this->view_data['package'] . '::' . $this->view_data['controller'] . '.' . $this->view_data['view'])
                ->with('view_data', $this->view_data);

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
    public function afterCreating(&$controller_model) {
        if (array_key_exists('format', $this->input) && ($this->input['format'] == 'json')) {

            //Attach card to user
            $stripe_response = $this->callController(\Util::buildNamespace('payments', 'stripe', 1), 'createCard', array(\Auth::user()->stripe_id, $this->input['stripe_token']));

            if ($stripe_response['status']) {//Card created
                //Card details
                $card_array = array(
                    'user_id' => \Auth::user()->id,
                    'gateway' => 'stripe',
                    'card_token' => $stripe_response['response']->id,
                    'brand' => \Str::lower($stripe_response['response']->brand),
                    'last4' => $stripe_response['response']->last4,
                    'exp_month' => $stripe_response['response']->exp_month,
                    'exp_year' => $stripe_response['response']->exp_year,
                    'address_city' => (is_null($stripe_response['response']->address_city) == false) ? $stripe_response['response']->address_city : '',
                    'address_zip' => (is_null($stripe_response['response']->address_zip) == false) ? $stripe_response['response']->address_zip : '',
                    'address_country' => (is_null($stripe_response['response']->address_country) == false) ? $stripe_response['response']->address_country : '',
                    'address_line1' => (is_null($stripe_response['response']->address_line1) == false) ? $stripe_response['response']->address_line1 : '',
                    'ip' => $this->input['ip'],
                    'agent' => $this->input['agent'],
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
     * @param string $card_token Card token
     * 
     * @return string verbative card
     */
    public function getVerbativeCardUsed($card_token) {
        //Get card by token
        $card_model = $this->getModelByField('card_token', $card_token);

        if ($card_model) {
            return $card_model->brand . ' XXX ' . $card_model->last4;
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
     * S# controllerSpecificWhereClause() function
     * @author Edwin Mugendi
     * 
     * Set controller specific where clause
     * @param array $fields Fields
     * @param array $where_clause Where clause
     * @param array $parameters Parameters
     */
    public function controllerSpecificWhereClause(&$fields, &$where_clause, &$parameters) {

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
            } else {
                $where_clause[] = array(
                    'where' => 'where',
                    'column' => 'user_id',
                    'operator' => '=',
                    'operand' => $this->user['id']
                );
            }//E# if statement
        } else {
            if ($this->user['role_id'] == 2) {//Merchant
                //Transaction fields
                $transaction_fields = array('card_token');

                //Transaction where clause
                $transaction_where_clause = array(
                    array(
                        'where' => 'where',
                        'column' => 'merchant_id',
                        'operator' => '=',
                        'operand' => $this->user['merchant_id']
                    )
                );

                //Get transactions
                $transaction_model = $this->callController(\Util::buildNamespace('payments', 'transaction', 1), 'select', array($transaction_fields, $transaction_where_clause, 2));

                if ($transaction_model) {
                    $card_tokens = array_unique($transaction_model->lists('card_token'));
                } else {
                    $card_tokens = array(0);
                }//E# if else statement

                $where_clause[] = array(
                    'where' => 'whereIn',
                    'column' => 'card_token',
                    'operand' => $card_tokens
                );
            }//E# if statement
        }//E# if else statement
    }

//E# controllerSpecificWhereClause() function
}

//E# CardController() function