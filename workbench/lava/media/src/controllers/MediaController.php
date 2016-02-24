<?php

namespace Lava\Media;

use \Imagine\Imagick\Imagine;
use \Imagine\Image\Box;
use Carbon\Carbon;

/**
 * S# MediaController() Class
 * @author Edwin Mugendi
 * Media Controller
 */
class MediaController extends MediaBaseController {

    //Controller
    public $controller = 'media';

    /**
     * S# backup() function
     * @author Edwin Mugendi
     * 
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
                'where' => 'where',
                'column' => 'mediable_id',
                'operator' => '!=',
                'operand' => 0
            ),
            array(
                'where' => 'where',
                'column' => 'mediable_type',
                'operator' => '!=',
                'operand' => ''
            ),
        );
        $parameters['paginate'] = 100;

        //Select preuploaded media models
        $media_model = $this->select($fields, $whereClause, 2, $parameters);

        $client = new \Google_Client();

        // Replace this with your application name.
        $client->setApplicationName(\Config::get($this->package . '::thirdParty.google.application_name'));

        // This file location should point to the private key file.
        $key = file_get_contents(__DIR__ . '/key.p12');

        if ($media_model) {
            $media_count = count($media_model);
            $cred = new \Google_Auth_AssertionCredentials(
                    \Config::get($this->package . '::thirdParty.google.client_email'), //Client email
                    array('https://www.googleapis.com/auth/devstorage.full_control'), $key
            );

            $client->setAssertionCredentials($cred);

            $service = new \Google_Service_Storage($client);

            //Build upload path
            $upload_path = public_path() . \Config::get($this->package . '::media.uploadPath');

            //Storage Object
            $storage_object = new \Google_Service_Storage_StorageObject();

            $index = 0;
            $start_time = microtime(true);
            foreach ($media_model as $single_media) {

                //Main image
                $main_image_name = $single_media->name;

                //Thumbnail image
                $thumbnail_image = 'thumbnails/' . $single_media->name;

                if ($single_media->is_image && \File::exists($upload_path . '/' . $thumbnail_image)) {

                    //Upload thumbnail image //Change 3 places 
                    $storage_object->setName($thumbnail_image);

                    $google_response = $service->objects->insert(
                            \Config::get($this->package . '::thirdParty.google.bucket'), $storage_object, ['name' => $thumbnail_image,
                        'data' => file_get_contents($upload_path . '/' . $thumbnail_image),
                        'uploadType' => 'media'
                            ]
                    );
                    $single_media->google_thumbnail_id = $google_response->generation;
                }//E# if else statement

                if (\File::exists($upload_path . '/' . $main_image_name)) {//Main image exists
                    //Upload main image
                    $storage_object->setName($main_image_name);

                    $google_response = $service->objects->insert(
                            \Config::get($this->package . '::thirdParty.google.bucket'), $storage_object, ['name' => $main_image_name,
                        'data' => file_get_contents($upload_path . '/' . $main_image_name),
                        'uploadType' => 'media'
                            ]
                    );
                    $single_media->google_main_id = $google_response->generation;

                    $single_media->backed_up = 1;
                    $single_media->save();

                    echo 'Media ' . $single_media->name . ', Id ' . $single_media->id . ', Index ' . $index . ' of ' . $media_count . ', ' . number_format((100 - (($index / $media_count) * 100)), 2) . '% remaining' . "\n";
                }//E# if statement
                //Upload thumbnail
                $index++;
            }//E# foreach statement
            $time_elapsed_secs = microtime(true) - $start_time;

            echo 'Time: ' . ($time_elapsed_secs / 60) . ' minutes';
        }//E# if statement

        return "done";
    }

//E# backup() function

    /**
     * S# deleteDanglingMedia() function
     * 
     * Delete Dangling Media
     * 
     * 
     */
    public function deleteDanglingMedia() {
        //Now
        $now = new Carbon();

        $now->subDays(1);
        var_dump($now);

        //Fields to select
        $fields = array('*');

        $whereClause = array(
            array(
                'where' => 'where',
                'column' => 'mediable_id',
                'operator' => '=',
                'operand' => 0
            ),
            array(
                'where' => 'where',
                'column' => 'mediable_type',
                'operator' => '=',
                'operand' => ''
            ),
            array(
                'where' => 'where',
                'column' => 'created_at',
                'operator' => '<',
                'operand' => $now
            ),
        );

        //Select preuploaded media models
        $media_model = $this->select($fields, $whereClause, 2);

        echo 'Found ' . count($media_model) . ' dungling images';

        if ($media_model) {

            //Build media path
            $mediaPath = public_path() . \Config::get($this->package . '::media.uploadPath');

            foreach ($media_model as $single_media) {
                echo "deleted " . $single_media->name . "\n";
                //Build main path
                $main_path = $mediaPath . '/' . $single_media->name;

                //Build thumbnail path
                $thumbnail_path = $mediaPath . '/thumbnails/' . $single_media->name;

                if ($single_media['is_image'] && \File::exists($thumbnail_path)) {//Media file exists
                    //Delete thumbnail file
                    \File::delete($thumbnail_path);
                }//E# if statement

                if (\File::exists($main_path)) {//Media file exists
                    //Hurrah!
                    //Delete main media file
                    \File::delete($main_path);

                    //Delete media model
                    $single_media->delete();
                }//E# if statement
            }//E# foreach statement
        }//E# if statement
    }

//E# deleteDanglingMedia() function

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
            $upload_path = public_path() . \Config::get($this->package . '::media.uploadPath');

            return \Response::download($upload_path . '/' . $this->input['image'], $media_model['original_name']);
        }//E# if statment
    }

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
        $upload_path = public_path() . \Config::get($this->package . '::media.uploadPath');

        //Cache media extension
        $mediaExtension = $this->input['media']->getClientOriginalExtension();

        $isNameAvailable = true;

        while ($isNameAvailable) {
            //Build media name
            $mediaName = \Str::random(\Config::get($this->package . '::media.mediaNameLength')) . '.' . $mediaExtension;

            //Cache absolute media path
            $abolutePath = $upload_path . '/' . $mediaName;

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
        $this->input['media']->move($upload_path, $mediaName);

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
                    ->save($upload_path . '/thumbnails/' . $mediaName);
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
            'thumbnail_size' => $is_image ? \File::size($upload_path . '/thumbnails/' . $mediaName) : 0,
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
        $media_model = $this->callController(\Util::buildNamespace('media', 'media', 1), 'createIfValid', $mediaRow);

        //Creating an uploaded photo info array
        $mediaInfo = $this->formatMediaResponse($media_model);

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
        $media_model = $this->find($this->input['media_id']);

        if ($media_model) {//Media model exists
            //Build media path
            $mediaPath = public_path() . \Config::get($this->package . '::media.uploadPath');
            //Build main path
            $main_path = $mediaPath . '/' . $media_model->name;

            if (\File::exists($main_path)) {//Media file exists
                //Hurrah!
                //Delete main media file
                \File::delete($main_path);

                if ($media_model->is_image) {
                    //Build thumbnail path
                    $thumbnail_path = $mediaPath . '/thumbnails/' . $media_model->name;
                    //Delete thumbnail file
                    \File::delete($thumbnail_path);
                }//E# if statement
                //Delete media model
                $media_model->status = 2;

                $media_model->save();

                $this->notification = array(
                    'type' => 'success',
                    'message' => \Lang::get($this->package . '::' . $this->controller . '.action.deleting', array('type' => \Lang::choice($this->package . '::' . $this->controller . '.type.' . $media_model->type, 1)))
                );
            } else {//Media file not found
                //Set replacement values
                $this->replacements['type'] = \Lang::choice($this->package . '::' . $this->controller . '.type.' . $media_model->type, 1);
                $this->replacements['id'] = 'name';
                $this->replacements['value'] = $media_model->name;

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
        $media_model = $this->find($this->input['media_id']);

        if ($media_model) {//Media model exists
            //Set fields to update
            $media_model->description = $this->input['media_description'];
            $media_model->updated_by = 1;
            //Hip Hip Hurrah!
            $media_model->save();

            $this->notification = array(
                'type' => 'success',
                'message' => \Lang::get($this->package . '::' . $this->controller . '.action.describing', array('type' => \Lang::choice($this->package . '::' . $this->controller . '.type.' . $media_model->type, 1)))
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
            $media_model = $this->find($mediaId);

            if ($media_model) {//Media model exists
                //Set fields to update
                $media_model->order = $order;
                $media_model->updated_by = 1;
                //Hip Hip Hurrah!
                $media_model->save();
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
                'type' => \Str::lower(\Lang::choice($this->package . '::' . $this->controller . '.type.' . $media_model->type, $ordered))
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
                ),
                array(
                    'where' => 'where',
                    'column' => 'status',
                    'operator' => '=',
                    'operand' => 1
                ),
                array(
                    'where' => 'orWhere',
                    'column' => 'refresh_key',
                    'operator' => '=',
                    'operand' => $this->getRefreshKey($this->input['media_controller'])
                )
            );
        } else {
            $whereClause = array(
                array(
                    'where' => 'where',
                    'column' => 'status',
                    'operator' => '=',
                    'operand' => 1
                ),
                array(
                    'where' => 'where',
                    'column' => 'refresh_key',
                    'operator' => '=',
                    'operand' => $this->getRefreshKey($this->input['media_controller'])
                )
            );
        }//E# if statement
        /*
          //Build where clause
          $whereClause[] = array(
          'where' => 'where',
          'column' => 'status',
          'operator' => '=',
          'operand' => 1
          );

         */
        //Build extra parameters
        $parameters = array();
        $parameters['orderBy'][] = array('order' => 'asc');
        $parameters['convertTo'] = 'toArray';

        //Select preuploaded media models
        $media_model = $this->select($fields, $whereClause, 2, $parameters);

        $allMedia = array();
        if ($media_model) {//
            foreach ($media_model as $singleModel) {//Loop through the $media_model
                array_push($allMedia, $this->formatMediaResponse($singleModel));
            }//E# foreach statement
        }//E# if statement
        $this->notification['files'] = $allMedia;

        if (count($media_model) <= 0) {
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
        $media_model = $this->select($fields, $whereClause, 2, $parameters);

        if ($media_model) {//There exists a media model for this property
            foreach ($media_model as $singleModel) {//Loop through each model
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