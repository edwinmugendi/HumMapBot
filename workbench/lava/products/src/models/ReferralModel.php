<?php

namespace Lava\Products;

/**
 * S# ReferralModel() Class
 * @author Edwin Mugendi
 * Referral Model
 */
class ReferralModel extends \BaseModel {

    //Table
    protected $table = 'pdt_referrals';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '=', 0),
        'referrer_id' => array(1, 'select', '=', 0),
        'referee_id' => array(1, 'select', '=', 0),
        'referral_code' => array(1, 'text', '=', 1),
        'workflow' => array(1, 'select', '=', 0),
        'promotion_id' => array(1, 'select', '=', 0),
        'transaction_id' => array(1, 'text', '=', 0),
    );
    //Fillable fields
    protected $fillable = array(
        'id',
        'referral_code',
        'referee_id',
        'referrer_id',
        'workflow',
        'promotion_id',
        'transaction_id',
        'agent',
        'ip',
        'status',
        'created_by',
        'updated_by',
    );
    //Appends fields
    protected $appends = array(
        'promotion_id_text',
    );
    protected $hidden = array(
    );
    //Create validation rules
    public $createRules = array(
        'referrer_id' => 'required',
        'referee_id' => 'required',
        'referral_code' => 'required',
    );
    //Update validation rules
    public $updateRules = array(
        'referrer_id' => 'required',
        'referee_id' => 'required',
        'referral_code' => 'required',
    );

    /**
     * S# getWorkflowTextAttribute() function
     * Get Workflow Text
     */
    public function getWorkflowTextAttribute() {
        return \Lang::has('products::referral.data.workflow.' . $this->attributes['workflow']) ? \Lang::get('products::referral.data.workflow.' . $this->attributes['workflow']) : '';
    }

//E# getWorkflowTextAttribute() function

    /**
     * S# referrer() function
     * Set one to one relationship to Referrer Model
     */
    public function referrer() {
        return $this->belongsTo(\Util::buildNamespace('accounts', 'user', 2), 'referrer_id');
    }

//E# referrer() function

    /**
     * S# getReferrerIdTextAttribute() function
     * 
     * Get Referrer Text
     */
    public function getReferrerIdTextAttribute() {

        //Get referrer model
        $referrer_model = $this->referrer()->first();

        //Return name
        return $referrer_model ? $referrer_model->first_name . ' ' . $referrer_model->last_name : '';
    }

//E# getReferrerIdTextAttribute() function

    /**
     * S# referee() function
     * Set one to one relationship to Referee Model
     */
    public function referee() {
        return $this->belongsTo(\Util::buildNamespace('accounts', 'user', 2), 'referee_id');
    }

//E# referee() function

    /**
     * S# getRefereeIdTextAttribute() function
     * 
     * Get Referee Text
     */
    public function getRefereeIdTextAttribute() {

        //Get referee model
        $referee_model = $this->referee()->first();

        //Return name
        return $referee_model ? $referee_model->first_name . ' ' . $referee_model->last_name : '';
    }

//E# getRefereeIdTextAttribute() function

    /**
     * S# promotion() function
     * Set one to one relationship to Promotion Model
     */
    public function promotion() {
        return $this->belongsTo(\Util::buildNamespace('products', 'promotion', 2), 'promotion_id');
    }

//E# promotion() function

    /**
     * S# getPromotionIdTextAttribute() function
     * 
     * Get Promotion Text
     */
    public function getPromotionIdTextAttribute() {

        //Get promotion model
        $promotion_model = $this->promotion()->first();

        //Return name
        return $promotion_model ? $promotion_model->code : '';
    }

//E# getPromotionIdTextAttribute() function
}

//E# ReferralModel() Class