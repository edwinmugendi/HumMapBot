<?php

namespace Lava\Media;

use \Imagine\Imagick\Imagine;
use \Imagine\Image\Box;

/**
 * S# MediaController() Class
 * @author Edwin Mugendi
 * Media Controller
 */
class MediaController extends MediaBaseController {

    //Controller
    public $controller = 'media';

    /**
     * S# getDetailedPageView() function
     * @author Edwin Mugendi
     * Get media view for a detailed page
     * 
     * @param array $view_data media data array
     * 
     * @return view media view to upload media
     */
    public function getDetailedPageView($view_data) {

        //Add controller and package to $view_data
        $view_data['controller'] = $this->controller;
        $view_data['package'] = $this->package;
        $view_data['single_media_view'] = '';

        if (count($view_data['controller_model']['media'])) {
            foreach ($view_data['controller_model']['media'] as $single_model) {
                $single_model['thumbnail_url'] = $this->getThumbnailUrl($single_model);
                $view_data['single_model'] = $single_model;
                $view_data['single_media_view'] .= \View::make($this->package . '::' . $this->controller . '.detailedSinglePageView')
                        ->with('view_data', $view_data)
                        ->render();
            }//E# foreach statement
        }//E# if statement
        //Return media view to upload media
        return \View::make($this->package . '::' . $this->controller . '.detailedPageView')
                        ->with('view_data', $view_data)
                        ->render();
    }

//E# getDetailedPageView() function

    public function download() {

        //Get the validation rules
        $this->validationRules = array(
            'image' => 'required|exists:mda_media,name',
        );

        //Validate inputs
        $this->validator = $this->isInputValid();

        if ($this->validator->fails()) {
            
        } else {
            $media_model = $this->getModelByField('name', $this->input['image']);

            //Build upload path
            $uploadPath = public_path() . \Config::get($this->package . '::media.uploadPath');

            return \Response::download($uploadPath . '/' . $this->input['image'], $media_model['original_name']);
        }//E# if statment
    }

    /**
     * S# backup() function
     * @author Edwin Mugendi
     * Backup media
     *
     */
    public function backup() {

        //Build the model
        //Fields to select
        $fields = array('*');

        $whereClause = array(
            array(
                'where' => 'where',
                'column' => 'backed_up',
                'operator' => '=',
                'operand' => 0
            ),
            array(
                'where' => 'whereNotNull',
                'column' => 'media_type'
            )
        );

        //Build extra parameters
        $parameters['take'] = 5;

        //Select preuploaded media models
        $mediaModel = $this->select($fields, $whereClause, 2, $parameters);

        if ($mediaModel) {
            foreach ($mediaModel as $singleMedia) {
                
            }//E# foreach statement
        }//E# if statement
    }

//E# backup() function

    /**
     * S# getMediaView() function
     * @author Edwin Mugendi
     * Get media view to upload media
     * @param array $view_data media data array
     * @return view media view to upload media
     */
    public function getMediaView($view_data) {

        //Set refresh key to session
        $this->setRefreshKey($view_data['mediaController']);

        //Add controller and package to $view_data
        $view_data['controller'] = $this->controller;
        $view_data['package'] = $this->package;

        //Return media view to upload media
        return \View::make($this->package . '::' . $this->controller . '.mediaView')
                        ->with('view_data', $view_data)
                        ->render();
    }

//E# getMediaView() function
    /**
     * S# setRefreshKey() function
     * @author Edwin Mugendi
     * @param string $mediaController The controller
     * Set the refresh key in the session data
     */
    public function setRefreshKey($mediaController) {
        $refreshKey = $this->buildRefreshKey($mediaController);
        if (!\Session::get($refreshKey)) {
            \Session::put($refreshKey, \Str::random(10));
        }//E# if statement
    }

//E# setRefreshKey() function
    /**
     * S# buildRefreshKey() function
     * @author Edwin Mugendi
     * Build the controller specific refresh key
     * @param string $mediaController The controller
     * @return string The Controller specific refresh key
     */
    private function buildRefreshKey($mediaController) {
        return $mediaController . 'RefreshKey';
    }

//E# buildRefreshkey() function

    /**
     * S# getRefreshKey() function
     * @author Edwin Mugendi
     * Get the refresh key in the session data
     * @param string $mediaController The controller
     * @return string This controllers refresh key
     */
    public function getRefreshKey($mediaController) {
        $refreshKey = $this->buildRefreshKey($mediaController);
        return \Session::get($refreshKey);
    }

//E# getRefreshKey() function

    /**
     * S# clearRefreshKey() function
     * @author Edwin Mugendi
     * Clears the refresh key from the session data
     * @param string $mediaController The controller
     */
    public function clearRefreshKey($mediaController) {
        $refreshKey = $this->buildRefreshKey($mediaController);
        \Session::forget($refreshKey);
    }

//E# clearRefreshKey() function

    /**
     * S# upload() function
     * @author Edwin Mugendi
     * Upload a media.
     * 1. Generate it name, 
     * 2. Check if there exists another media with another name, if true, send name conflict notification,
     * 3. Generate name until there is no conflict,
     * 4. Upload the media
     * 5. Save the its media in the media model
     */
    public function upload() {
        //Get, prep and set GET data
        $this->input = \Input::all();

        //Get the validation rules
        $this->validationRules = array(
            'media_controller' => 'alpha_dash',
            'media_type' => 'alpha',
                //  'media' => 'mimes:jpeg,bmp,png,gif,pdf,doc,d'
        );

        //Validate inputs
        $this->isInputValid($this->input);

        //Get, prep and set POSTEd inputs
        $this->input['media_controller'] = \Str::lower(trim($this->input['media_controller']));
        $this->input['media_type'] = \Str::lower(trim($this->input['media_type']));

        //Build upload path
        $uploadPath = public_path() . \Config::get($this->package . '::media.uploadPath');

        //Cache media extension
        $mediaExtension = $this->input['media']->getClientOriginalExtension();

        $isNameAvailable = true;

        while ($isNameAvailable) {
            //Build media name
            $mediaName = \Str::random(\Config::get($this->package . '::media.mediaNameLength')) . '.' . $mediaExtension;

            //Cache absolute media path
            $abolutePath = $uploadPath . '/' . $mediaName;

            if (\File::exists($abolutePath)) {//Media file with this name already exists
                //Define Issue row
                $issueRow[] = array(
                    'notification_id' => 1021,
                    'issuer_id' => 1,
                    'issuee_id' => 1,
                    'controller' => $this->controller,
                    'description' => json_encode(array('name' => $mediaName)),
                    'priority' => 1,
                    'status' => 1,
                    'created_by' => 1, //USER_ID
                    'updated_by' => 1//USER_ID
                );

                //Create an issue
                //  $this->callController(\Util::buildNamespace('system','issue', 1), 'createIfValid', $issueRow);
            } else {
                $isNameAvailable = false;
            }//E# if else statement
        }//E# while statement
        //Hurrah! we have the media
        //NB: You can push to AWS, Google servers or to an external server here
        $this->input['media']->move($uploadPath, $mediaName);

        //Is uploaded document a file
        $is_image = in_array(strtolower($mediaExtension), array('jpeg', 'jpg', 'gif', 'png')) ? 1 : 0;

        if ($is_image) {
            //Create an Imagine Object
            $imagine = new Imagine();

            //Open this image for resizing and thumbnailing
            $imagine->open($abolutePath)
                    ->thumbnail(new Box(\Config::get($this->package . '::media.mainWidth'), \Config::get($this->package . '::media.mainHeight')))
                    ->save($abolutePath)
                    ->thumbnail(new Box(\Config::get($this->package . '::media.thumbnailWidth'), \Config::get($this->package . '::media.thumbnailHeight')))
                    ->save($uploadPath . '/thumbnails/' . $mediaName);
        }//E# if else statement
        //Define media row 
        $mediaRow[] = array(
            /* 2 New fields */
            'is_image' => $is_image,
            'original_name' => $this->input['media']->getClientOriginalName(),
            'controller_type' => $this->input['media_controller'],
            'type' => $this->input['media_type'],
            'name' => $mediaName,
            'extension' => $mediaExtension,
            'main_size' => \File::size($abolutePath),
            'thumbnail_size' => $is_image ? \File::size($uploadPath . '/thumbnails/' . $mediaName) : 0,
            'is_thumbnailed' => $is_image ? 1 : 0,
            'is_resized' => $is_image ? 1 : 0,
            'order' => 0,
            'refresh_key' => $this->getRefreshKey($this->input['media_controller']),
            'agent' => \Request::getClientIp(),
            'ip' => \Request::server('HTTP_USER_AGENT'),
            'status' => 1,
            'created_by' => $this->user['id'],
            'updated_by' => $this->user['id']
        );

        //Create a Media
        //NB: if you save the media and try to get the media values eg size, mime, Lavarel throughs a FileNotFoundException
        $mediaModel = $this->callController(\Util::buildNamespace('media', 'media', 1), 'createIfValid', $mediaRow);

        //Creating an uploaded photo info array
        $mediaInfo = $this->formatMediaResponse($mediaModel);

        //Set media info to notification
        $this->notification['files'][0] = $mediaInfo;

        //Return the notification as JSON
        return \Response::json($this->notification);
    }

//E# upload() function


    public function drop() {
        //Get the validation rules
        $this->validationRules = array(
            'media_id' => 'integer',
            'media_name' => array('regex:^[\w,\s-]+\.[A-Za-z]{3}$^'),
            'media_type' => 'alpha',
            'media_controller' => 'alpha'
        );

        //Validate inputs
        $this->isInputValid($this->input);

        //Find this media model by id
        $mediaModel = $this->find($this->input['media_id']);

        if ($mediaModel) {//Media model exists
            //Build media path
            $mediaPath = public_path() . \Config::get($this->package . '::media.uploadPath');
            //Build main path
            $mainPath = $mediaPath . '/' . $mediaModel->name;

            if (\File::exists($mainPath)) {//Media file exists
                //Hurrah!
                //Delete main media file
                \File::delete($mainPath);

                if ($mediaModel->is_image) {
                    //Build thumbnail path
                    $thumbnailPath = $mediaPath . '/thumbnails/' . $mediaModel->name;
                    //Delete thumbnail file
                    \File::delete($thumbnailPath);
                }//E# if statement
                //Delete media model
                $mediaModel->delete();

                $this->notification = array(
                    'type' => 'success',
                    'message' => \Lang::get($this->package . '::' . $this->controller . '.action.deleting', array('type' => \Lang::choice($this->package . '::' . $this->controller . '.type.' . $mediaModel->type, 1)))
                );
            } else {//Media file not found
                //Set replacement values
                $this->replacements['type'] = \Lang::choice($this->package . '::' . $this->controller . '.type.' . $mediaModel->type, 1);
                $this->replacements['id'] = 'name';
                $this->replacements['value'] = $mediaModel->name;

                //Throw a Not Found Exception
                throw new \Api404Exception($this->replacements);
            }//E# if else statement
        } else {//Media model does not exist
            //Set replacement values
            $this->replacements['type'] = \Lang::choice($this->package . '::' . $this->controller . '.type.' . $this->input['media_type'], 1);
            $this->replacements['id'] = 'id';
            $this->replacements['value'] = $this->input['media_id'];

            //Throw a Not Found Exception
            throw new \Api404Exception($this->replacements);
        }//E# if else statement
        //Return the notification as JSON
        return \Response::json($this->notification);
    }

//E# drop() function

    public function describe() {
        //Get the validation rules
        $this->validationRules = array(
            'media_id' => 'integer',
            'media_type' => 'alpha',
            'media_controller' => 'alpha'
        );

        //Validate inputs
        $this->isInputValid();

        //Find this media model by id
        $mediaModel = $this->find($this->input['media_id']);

        if ($mediaModel) {//Media model exists
            //Set fields to update
            $mediaModel->description = $this->input['media_description'];
            $mediaModel->updated_by = 1;
            //Hip Hip Hurrah!
            $mediaModel->save();

            $this->notification = array(
                'type' => 'success',
                'message' => \Lang::get($this->package . '::' . $this->controller . '.action.describing', array('type' => \Lang::choice($this->package . '::' . $this->controller . '.type.' . $mediaModel->type, 1)))
            );

            //Return the notification as JSON
            return \Response::json($this->notification);
        } else {//Media model does not exist
            //Set replacement values
            $this->replacements['type'] = \Lang::choice($this->package . '::' . $this->controller . '.type.' . $this->input['media_type'], 1);
            $this->replacements['id'] = 'id';
            $this->replacements['value'] = $this->input['media_id'];

            //Throw a Not Found Exception
            throw new \NotFoundException($this->replacements);
        }//E# if else statement
    }

//E# desribe() function

    public function order() {
        //Get the validation rules
        $this->validationRules = array(
            'media_id' => 'integer',
            'media_type' => 'alpha',
            'media_controller' => 'alpha',
                //TO DO: Validate array 'media_ids' => ''
        );

        //Validate inputs
        $this->isInputValid($this->input);

        //Define current order
        $order = 1;
        //Successful orders
        $ordered = 0;
        foreach ($this->input['media_ids'] as $mediaId) {//Loop through the media ids
            //Find this media model by id
            $mediaModel = $this->find($mediaId);

            if ($mediaModel) {//Media model exists
                //Set fields to update
                $mediaModel->order = $order;
                $mediaModel->updated_by = 1;
                //Hip Hip Hurrah!
                $mediaModel->save();
                //Increment ordered
                $ordered++;
            } else {//Media Model does not exist
                //Set replacement values
                $this->replacements['type'] = \Lang::choice($this->package . '::' . $this->controller . '.type.' . $this->input['media_type'], 1);
                $this->replacements['id'] = 'id';
                $this->replacements['value'] = $mediaId;

                //Throw a Not Found Exception
                throw new \NotFoundException($this->replacements);
            }//E# if else statement
            $order++;
        }//E# foreach statement

        $this->notification = array(
            'type' => 'success',
            'message' => \Lang::get($this->package . '::' . $this->controller . '.action.ordering', array(
                'ordered' => $ordered,
                'total' => count($this->input['media_ids']),
                'type' => \Str::lower(\Lang::choice($this->package . '::' . $this->controller . '.type.' . $mediaModel->type, $ordered))
            ))
        );

        //Return the notification as JSON
        return \Response::json($this->notification);
    }

//E# order() function

    /**
     * S# uploaded() function
     * @author Edwin Mugendi
     * Get either:
     * 1. Media already uploaded and in the database
     * 2. Medis already uploaded and not in the database but in the session
     */
    public function uploaded() {

        //Get the validation rules
        $this->validationRules = array(
            'id' => 'integer',
            'media_controller' => 'alpha'
        );

        //Validate inputs
        $this->isInputValid();

        //Build the model
        //Fields to select
        $fields = array('*');

        if ($this->input['id'] != -1) {
            $whereClause = array(
                array(
                    'where' => 'where',
                    'column' => 'controller_type',
                    'operator' => '=',
                    'operand' => $this->input['media_controller']
                ),
                array(
                    'where' => 'where',
                    'column' => 'mediable_id',
                    'operator' => '=',
                    'operand' => $this->input['id']
                )
            );
        }//E# if statement
        //Build where clause
        $whereClause[] = array(
            'where' => 'orWhere',
            'column' => 'refresh_key',
            'operator' => '=',
            'operand' => $this->getRefreshKey($this->input['media_controller'])
        );


        //Build extra parameters
        $parameters = array();
        $parameters['orderBy'][] = array('order' => 'asc');
        $parameters['convertTo'] = 'toArray';

        //Select preuploaded media models
        $mediaModel = $this->select($fields, $whereClause, 2, $parameters);

        $allMedia = array();
        if ($mediaModel) {//
            foreach ($mediaModel as $singleModel) {//Loop through the $media_model
                array_push($allMedia, $this->formatMediaResponse($singleModel));
            }//E# foreach statement
        }//E# if statement
        $this->notification['files'] = $allMedia;

        if (count($mediaModel) <= 0) {
            $this->notification['files'] = array();
        }//E# if statement
        //Return the notification array as JSON
        return \Response::json($this->notification);
    }

//E# get_uploaded() function
    /**
     * S# formatMediaResponse() function
     * @author Edwin Mugendi
     * Format the media response
     * @param Model $model A reference to the model
     * @return array The formatted response
     */
    public function formatMediaResponse($model) {

        $mediaInfo = array();

        $mediaInfo['media_id'] = $model['id'];
        $mediaInfo['media_name'] = $model['name'];
        $mediaInfo['media_description'] = $model['description'];
        $mediaInfo['url'] = '';
        $mediaInfo['delete_url'] = \URL::to('/') . '/media/drop';
        $mediaInfo['media_type'] = $model['type'];
        $mediaInfo['media_controller'] = $model['controller_type'];
        $mediaInfo['thumbnail_url'] = $this->getThumbnailUrl($model);

        return $mediaInfo;
    }

//E# formatMediaResponseResponse() function

    /**
     * S# getThumbnailUrl() function
     * 
     * Get thumbnail url
     * 
     * @param array $model Media Model
     * 
     * @return str Thumbnail URL
     */
    private function getThumbnailUrl($model) {
        if ($model['is_image']) {
            $thumbnail_url = \URL::to('/') . \Config::get($this->package . '::media.uploadPath') . '/thumbnails/' . $model['name'];
        } else {
            $url_part = \URL::to('/') . '/img/docs_icons/';
            if (\File::exists(public_path('/img/docs_icons/' . $model['extension'] . '.png'))) {
                $thumbnail_url = $url_part . $model['extension'] . '.png';
            } else {
                $thumbnail_url = $url_part . 'other.png';
            }//E# if else statement
        }//E# if else statement

        return $thumbnail_url;
    }

//E# getThumbnailUrl() function

    /**
     * S# relateToMedia() function
     * @author Edwin Mugendi
     * Relate this model to the pre uploaded media
     * @param Model $model A reference to the model
     * @param string $controller The controller 
     * */
    public function relateToMedia(&$model, $controller) {

        //Get refresh key from the session
        $refreshKey = $this->getRefreshKey($controller);

        //Fields to select
        $fields = array('id', 'refresh_key', 'name');

        //Build where clause
        $whereClause = array(
            array(
                'where' => 'where',
                'column' => 'refresh_key',
                'operator' => '=',
                'operand' => $refreshKey
            )
        );
        //Build extra parameters
        $parameters = array();
        $parameters['orderBy'][] = array('order' => 'asc');
        $parameters['orderBy'][] = array('id' => 'asc');
        //Select pre-uploaded media
        $mediaModel = $this->select($fields, $whereClause, 2, $parameters);

        if ($mediaModel) {//There exists a media model for this property
            foreach ($mediaModel as $singleModel) {//Loop through each model
                //Clear the refresh key
                $singleModel->refresh_key = '';
                //Relate this media to this property
                $model->media()->save($singleModel);
            }//E# foreach statement
        }//E# if statement
        //Clear the media refresh key
        $this->clearRefreshKey($controller);

        return '';
    }

//E# relateToMedia() function
}

//E# MediaController() Class