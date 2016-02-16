<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Media Language Lines
      |--------------------------------------------------------------------------
     */
    'view' => array(
        'attached_documents' => 'Attached documents',
        'documents' => '{1} :count document | [2,Inf] :count documents',
        'view_image' => 'View image',
        'download_image' => 'Download image',
        'original_image' => 'Original image',
        'image' => 'Image'
    ),
    'action' => array(
        'creating' => 'Creating :type',
        'deleting' => ':type deleted',
        'describing' => ':type described',
        'ordering' => ':ordered of :total :type ordered',
        'updating' => 'Updating media',
        'updating' => 'Selecting media',
        'validating' => 'Validating media inputs'
    ),
    'model' => 'Media',
    'type' => array(
        'photo' => '{1}Photo|[2,Inf] Photos',
        'image' => '{1}Image|[2,Inf] Images',
        'video' => 'Video',
        'document' => 'Document'
    ),
    'mediaView' => array(
        'errorMedia' => "Oops, Sapama encountered a problem uploading your :type. Please try again.",
        'addMedia' => 'Add :type',
        'mainMedia' => 'Main :type',
        'setAsMainMedia' => 'Set as main :type',
        'deleteMedia' => 'Delete :type',
        'describeMedia' => 'Describe :type',
        'remainingMedia' => ':type remaining'
    ),
    'detailedPageView' => array(
        'file_name' => 'File name',
        'attached_by' => 'Attached by',
        'modified_at' => 'Modified at',
        'size' => 'Size',
    ),
    'success' => array(
        'description' => array(
            'deleted' => ':type deleted sucessfully.',
            'described' => ':type described successfully.'
        )
    ),
    'issues' => array(
        1021 => 'There was another name as \":name\" that was generated. Increase the length of the media generation string in the media config',
        'error' => array(
            19601 => array(
                'http_code' => 404,
                'developer_message' => ':controller model with id: :id not found in the :controller table.',
                'user_message' => ':controller not in our database. Sapama Customer Care is on this case. Sorry for any inconvinience.',
                'more_info' => ''
            ),
            'description' => array(
                'not_found_in_model' => 'Oops! :type not found in database. Sapama is on this case. Code 404.',
                'not_found_in_disk' => 'Oops! :type not found on disk. Sapama is on this case. Code 404.',
                'not_found_in_model_disk' => 'Oops! :type neither on disk or database. Sapama is on this case. Code 404.',
            )
        ),
    ),
    'inlineJs' => array(
        'error' => array(
            'fileupload' => array(
                'description' => array(
                    'maxFilesExceeded' => 'Oops, You have exceed the maximum number of files you can upload. Please contact Sapama Customer Care to increase your threshold. Thank you',
                    'fileNotAllowed' => 'Oops, Sapama does not allow that type of file to be uploaded. Please contact Sapama Customer Care to include that file type for you. Thank you',
                    'fileTooBig' => 'Oops, the file you tried to upload is too big. Ensure it does not exceed the maximum allowed size. Thanks you.',
                    'fileTooSmall' => 'Oops, the file you tried to upload is too small. Ensure it is not below the minimum allowed size. Thanks you.'
                )
            )
        )
    )
);
