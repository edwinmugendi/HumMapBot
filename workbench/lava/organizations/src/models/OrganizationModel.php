<?php

namespace Lava\Organizations;

/**
 * S# OrganizationModel() Class
 * @author Edwin Mugendi
 * Organization Model
 */
class OrganizationModel extends \BaseModel {

    //Table
    protected $table = 'org_organizations';
    //View fields
    public $viewFields = array(
        'id' => array(1, 'text', '='),
        'name' => array(1, 'text', 'like', 1),
        'workflow' => array(1, 'select', '='),
        'reg_no' => array(1, 'text', 'like'),
        'tax_id' => array(1, 'text', 'like'),
        'phone' => array(1, 'text', 'like'),
        'email' => array(1, 'text', 'like'),
        'country_id' => array(0, 'select', '='),
        'province' => array(0, 'text', 'like'),
        'city' => array(0, 'text', 'like'),
        'street' => array(0, 'text', 'like'),
        'postal_code' => array(0, 'text', 'like'),
        'timezone_id' => array(0, 'select', '='),
        'currency_id' => array(0, 'select', '='),
        'date_format' => array(0, 'select', '='),
        'website' => array(0, 'text', 'like'),
        'facebook' => array(0, 'text', 'like'),
        'twitter' => array(0, 'text', 'like'),
        'bank_name' => array(0, 'text', 'like'),
        'bank_sort_code' => array(0, 'text', 'like'),
        'bank_account_name' => array(0, 'text', 'like'),
        'bank_account_number' => array(0, 'text', 'like'),
        'bank_postal_code' => array(0, 'text', 'like'),
    );
    //Fillable fields
    protected $fillable = array(
        'id',
        'name',
        'workflow',
        'reg_no',
        'tax_id',
        'phone',
        'email',
        'currency_id',
        'timezone_id',
        'date_format',
        'country_id',
        'province',
        'city',
        'street',
        'postal_code',
        'website',
        'facebook',
        'twitter',
        'bank_name',
        'bank_sort_code',
        'bank_account_name',
        'bank_account_number',
        'bank_postal_code',
        'agent',
        'ip',
        'status',
        'created_by',
        'updated_by'
    );
    //Appends fields
    protected $appends = array(
        'country_id_text',
        'workflow_text',
        'currency_id_text',
        'timezone_id_text'
    );
    //Hidden fields
    protected $hidden = array();
    //Create validation rules
    public $createRules = array(
        'name' => 'required',
        'workflow' => 'required',
    );
    //Create validation rules
    public $updateRules = array(
        'name' => 'required',
        'workflow' => 'required',
    );

    /**
     * S# currency() function
     * Set one to one relationship to Currency Model
     */
    public function currency() {
        return $this->belongsTo(\Util::buildNamespace('locations', 'currency', 2), 'currency_id');
    }

//E# currency() function

    /**
     * S# getCurrencyIdTextAttribute() function
     * Get Currency Text
     */
    public function getCurrencyIdTextAttribute() {
        //Get currency model
        $currency_model = $this->currency()->first();
        //Return name
        return $currency_model ? $currency_model->name : '';
    }

//E# getCurrencyIdTextAttribute() function

    /**
     * S# timezone() function
     * Set one to one relationship to Timezone Model
     */
    public function timezone() {
        return $this->belongsTo(\Util::buildNamespace('locations', 'timezone', 2), 'timezone_id');
    }

//E# timezone() function

    /**
     * S# getTimezoneIdTextAttribute() function
     * Get Timezone Text
     */
    public function getTimezoneIdTextAttribute() {
        //Get timezone model
        $timezone_model = $this->timezone()->first();
        //Return name
        return $timezone_model ? $timezone_model->name : '';
    }

//E# getTimezoneIdTextAttribute() function

    /**
     * S# locations() function
     * Set one to many relationship to Location Model
     */
    public function locations() {
        return $this->hasMany(\Util::buildNamespace('merchants', 'location', 2), 'location_id');
    }

//E# locations() function

    /**
     * S# products() function
     * Set one to many relationship to Product Model
     */
    public function products() {
        return $this->hasMany(\Util::buildNamespace('merchants', 'product', 2), 'product_id');
    }

//E# products() function

    /**
     * S# getWorkflowTextAttribute() function
     * Get Workflow Text
     */
    public function getWorkflowTextAttribute() {
        $label = '';
        if ($this->attributes['workflow'] == 1) {
            $label = 'label label-success';
        } else if ($this->attributes['workflow'] == 2) {
            $label = 'label label-warning';
        } else if ($this->attributes['workflow'] == 3) {
            $label = 'label label-danger';
        }//E# if else statement

        return \Lang::has('merchants::merchant.data.workflow.' . $this->attributes['workflow']) ? '<span class="' . $label . '">' . \Lang::get('merchants::merchant.data.workflow.' . $this->attributes['workflow']) . '</span>' : '';
    }

//E# getWorkflowTextAttribute() function

    /**
     * S# getDateFormatTextAttribute() function
     * Get DateFormat Text
     */
    public function getDateFormatTextAttribute() {
        return \Lang::has('merchants::merchant.data.date_format.' . $this->attributes['date_format']) ? \Lang::get('merchants::merchant.data.date_format.' . $this->attributes['date_format']) : '';
    }

//E# getDateFormatTextAttribute() function

    /**
     * S# country() function
     * Set one to one relationship to Country Model
     */
    public function country() {
        return $this->belongsTo(\Util::buildNamespace('locations', 'country', 2), 'country_id');
    }

//E# country() function

    /**
     * S# getCountryIdTextAttribute() function
     * Get Country Text
     */
    public function getCountryIdTextAttribute() {

        //Get country model
        $country_model = $this->country()->first();

        //Return name
        return $country_model ? $country_model->name : '';
    }

//E# getCountryIdTextAttribute() function
}

//E# OrganizationModel() Class