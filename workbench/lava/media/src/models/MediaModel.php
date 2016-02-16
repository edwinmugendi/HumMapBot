<?php

namespace Lava\Media;

/**
 * S# MediaModel() Class
 * @author Edwin Mugendi
 * Media Model
 */
class MediaModel extends \BaseModel {

    //Table
    protected $table = 'mda_media';
    //Fillable fields
    protected $fillable = array(
        'is_image',
        'original_name',
        'mediable_id',
        'mediable_type',
        'controller_type',
        'type',
        'name',
        'extension',
        'main_size',
        'thumbnail_size',
        'description',
        'is_thumbnailed',
        'is_resized',
        'order',
        'refresh_key',
        'agent',
        'ip',
        'status',
        'created_by',
        'updated_by'
    );
    //Create validation rules
    public $createRules = array(
        'mediable_id' => 'integer',
        'mediable_type' => 'alpha_dash',
        'controller_type' => 'alpha_dash',
        'type' => 'alpha_dash',
        'name' => array('regex:^[\w,\s-]+\.[A-Za-z]{3}$^'),
        'extension' => 'alpha_dash',
        'main_size' => 'integer',
        'thumbnail_size' => 'integer',
        'description' => 'alpha_dash',
        'is_thumbnail_created' => 'integer',
        'is_resized' => 'integer',
        'order' => 'integer',
        'refresh_key' => 'alpha_dash',
        'status' => 'required|integer',
        'created_by' => 'required|integer',
        'updated_by' => 'required|integer'
    );

    public function mediable() {
        return $this->morphTo();
    }

}

//E# MediaModel() Class