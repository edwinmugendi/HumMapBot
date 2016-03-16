<?php

namespace Lava\Products;

use Carbon\Carbon;

/**
 * S# ReferralsController() function
 * Referral controller
 * @author Edwin Mugendi
 */
class ReferralController extends ProductsBaseController {

    //Controller
    public $controller = 'referral';

    /**
     * S# awardReferral() function
     * 
     * Check if user should 
     */
    public function awardReferral(/* $transaction_id, $user_model */) {
        $transaction_id = 1;
        $user_id = 38;

        $user_model = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('id', 38));
        
        //Fields
        $fields = array('*');

        //Where clause
        $where_clause = array(
            array(
                'where' => 'where',
                'column' => 'referee_id',
                'operator' => '=',
                'operand' => $user_model->id
            ),
            array(
                'where' => 'where',
                'column' => 'workflow',
                'operator' => '=',
                'operand' => 1
            ),
        );

        $parameters['scope'] = array('statusOne');

        $referral_model = $this->select($fields, $where_clause, 1, $parameters);
        
        
        if ($referral_model) {
            //Fields
            $fields = array('*');

            //Where clause
            $where_clause = array(
                array(
                    'where' => 'where',
                    'column' => 'user_id',
                    'operator' => '=',
                    'operand' => $user_model->id
                ),
            );
            $parameters['count'] = 1;
            $transaction_count = $this->callController(\Util::buildNamespace('payments', 'transaction', 1), 'select', array($fields, $where_clause, 2, $parameters));

            //dd($transaction_count);
            if ($transaction_count == 1) {
                //Get promtion model
                $promotion_model = $this->callController(\Util::buildNamespace('products', 'promotion', 1), 'getModelByField', array('id', 2));

                //Claim referral Promotion
                $promotion_model->users()->attach($referral_model->referrer_id, array(
                    'ip' => $this->input['ip'],
                    'agent' => $this->input['agent'],
                    'status' => 1,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                        )
                );

                $referral_model->transaction_id = $transaction_id;
                $referral_model->workflow = 2;

                $referrer_model = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getModelByField', array('id', $referral_model->referrer_id));

                //Notify referrer
                $this->notifyUser('notifyReferrer', $referral_model, $promotion_model, $referrer_model, $referrer_model, $user_model);

                //Notify referee
                $this->notifyUser('notifyReferee', $referral_model, $promotion_model, $user_model, $referrer_model, $user_model);

                $referral_model->save();
            }//E# if else statement
        }//E# if statement

        return 1;
    }

//E# awardReferral() function

    /**
     * S# notifyUser() function
     * Notify user of a successful transaction
     * 
     * @param string $card_or_stamps_or_promotion Card or loyalty stamps
     * @param model $transaction_model Transaction model
     * @param model $product_model Product model
     * @param model $user_model User model
     * @param model $vehicle_model Vehicle model
     * 
     */
    public function notifyUser($template, &$referral_model, $promotion_model, $user_model, $referrer_model, $referee_model) {
        if ($template == 'notifyReferrer') {
            $smsed_field = 'referrer_smsed';
            $pushed_field = 'referrer_pushed';
            $emailed_field = 'referrer_emailed';
        } else {
            $smsed_field = 'referee_smsed';
            $pushed_field = 'referee_pushed';
            $emailed_field = 'referee_emailed';
        }//E# if else statement
        //Message parameters
        $parameters = array(
            'currency' => '£',
            'amount' => $promotion_model->value,
            'referee' => $referrer_model->first_name . ' ' . $referrer_model->last_name,
            'referrer' => $referee_model->first_name . ' ' . $referee_model->last_name,
            'code' => $referee_model->referral_code
        );

        if ($user_model->device_token && $user_model->os) {//Push
            //Set os to parameters
            $parameters['os'] = $user_model->os;

            //Converse
            $sent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('push', null, null, $user_model->id, $user_model->device_token, $template, \Config::get('app.locale'), $parameters));

            $referral_model->$pushed_field = 1;
        }//E# if statement

        if ($user_model->phone) {//SMS
            //Converse
            $sent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('sms', null, null, $user_model->id, array($user_model->phone), $template, \Config::get('app.locale'), $parameters));

            $referral_model->$smsed_field = 1;
        }//E# if statement


        if ($user_model->email) {//Email
            $recipient['to'] = $user_model->email;

            //Converse
            $sent = $this->callController(\Util::buildNamespace('messages', 'message', 1), 'converse', array('email', null, null, $user_model->id, $recipient, $template, \Config::get('app.locale'), $parameters));

            $referral_model->$emailed_field = 1;
        }//E# if statement
    }

//E# notifyUser() function

    /**
     * S# postReferredBy() function
     * I was referred by
     * 
     */
    public function postReferredBy() {

        //Define validation rules
        $this->validationRules = array(
            'referral_code' => 'required|isReferralCodeValid'
        );
        //Validate merchant
        $this->isInputValid();
    }

//E# postReferredBy() function

    /**
     * S# injectDataSources() function
     * @author Edwin Mugendi
     * Inject data source. This are mainly select
     * 
     * @param array $dataSource Data source
     */
    public function injectDataSources() {
        //Get this organization user id
        $this->view_data['dataSource']['referrer_id'] = $this->view_data['dataSource']['referee_id'] = $this->callController(\Util::buildNamespace('accounts', 'user', 1), 'getMerchantsHtmlSelect', array($this->merchant['id'], 'id', array('first_name', 'last_name'), \Lang::get('common.select')));

        //Get this organization promotion id
        $this->view_data['dataSource']['promotion_id'] = $this->callController(\Util::buildNamespace('products', 'promotion', 1), 'getMerchantsHtmlSelect', array($this->merchant['id'], 'id', array('code'), \Lang::get('common.select')));

        //Get and set workflow options to data source
        $this->view_data['dataSource']['workflow'] = \Lang::get($this->package . '::' . $this->controller . '.data.workflow');
    }

//E# injectDataSources() function
}

//E# ReferralController() function