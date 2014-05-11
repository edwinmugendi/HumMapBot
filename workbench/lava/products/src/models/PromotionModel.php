<?php

namespace Lava\Products;

/**
 * S# PromotionModel() Class
 * @author Edwin Mugendi
 * Promotion Model
 */
class PromotionModel extends \Eloquent {

    //Table
    protected $table = 'pdt_promotions';
    //Fillable fields
    protected $fillable = array(
        'status',
        'created_by',
        'updated_by'
    );
    //Appends fields
    protected $appends = array(
        'claimed'
    );
    protected $hidden = array(
        'status',
        'created_by',
        'updated_by',
        'deleted_at'
    );
    //Create validation rules
    public $createRules = array(
        'status' => 'required|integer',
        'created_by' => 'required|integer',
        'updated_by' => 'required|integer',
    );

    /**
     * S# getClaimedAttribute() function
     * Has the customer claimed this promotion
     */
    public function getClaimedAttribute() {

        return $this->belongsToMany(\Util::buildNamespace('accounts', 'user', 2), 'pdt_users_promotions', 'promotion_id','user_id')
                        ->withPivot('redeemed')
                        ->whereUserId(\Auth::user()->id)
                        ->first();
    }

//E# getClaimedAttribute() function

    /**
     * S# users() function
     * Set many to many relationship to User Model
     */
    public function users() {
        return $this->belongsToMany(\Util::buildNamespace('accounts', 'user', 2), 'pdt_users_promotions', 'promotion_id','user_id');
    }

//E# users() function
}

//E# PromotionModel() Class