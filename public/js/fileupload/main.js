/*
 * jQuery File Upload Plugin JS Example 7.0
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/*jslint nomen: true, unparam: true, regexp: true */
/*global $, window, document */
var $count = 0;
//Compile and load templates
dust.loadSource(dust.compile($('#templateDownload').html(), 'templateDownload'));
dust.loadSource(dust.compile($('#templateUpload').html(), 'templateUpload'));

$(function () {
    'use strict';
    //Cache the media preview container
    var $mediaPreviewContainer = $('ul#mediaPreviewContainer');

    // Initialize the jQuery File Upload widget:
    $('#mediaUpload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: inlineJs.baseUrl + '/media/upload',
        sequentialUploads: true,
        autoUpload: true,
        prependFiles: false,
        maxNumberOfFiles: isNaN(parseInt(inlineJs.maxNumberOfFiles)) ? undefined : parseInt(inlineJs.maxNumberOfFiles),
        previewMaxWidth: 150,
        previewMaxHeight: 120,
        /*acceptFileTypes: /^image\/(gif|jpeg|png)$/,*/
        mediaPreviewContainer: $mediaPreviewContainer,
        mediaRemaining: $('span#mediaRemaining'),
        mediaButton: $('span#mediaButton'),
        uploadTemplateId: null,
        downloadTemplateId: null,
        formData: {
            media_controller: $('input#mediaController').val(),
            media_type: $('input#mediaType').val()
        },
        uploadTemplate: function (o) {
            var rows = $();
            $.each(o.files, function (index, file) {
                var row = '';
                dust.render('templateUpload', file, function (err, $html) {
                    row = $html;
                });

                rows = rows.add(row);
            });
            return rows;
        },
        downloadTemplate: function (o) {
            var rows = $();
            $.each(o.files, function (index, file) {
                var row = '';
                dust.render('templateDownload', file, function (err, $html) {
                    row = $html;
                });
                rows = rows.add(row);
            });
            return rows;
        },
        // The add callback is invoked as soon as files are added to the fileupload
        // widget (via file input selection, drag & drop or add API call).
        // See the basic file upload widget for more information:
        // See the basic file upload widget for more information:
        add: function (e, data) {
            var $this = $(this),
                    that = $this.data('blueimp-fileupload') ||
                    $this.data('fileupload'),
                    options = that.options,
                    files = data.files;
            //Clean the fields
            options.clean();
            data.process(function () {
                return $this.fileupload('process', data);
            }).always(function () {
                data.context = that._renderUpload(files).data('data', data);
                that._renderPreviews(data);
                options.filesContainer[
                        options.prependFiles ? 'prepend' : 'append'
                ](data.context);
                that._forceReflow(data.context);
                that._transition(data.context).done(
                        function () {
                            if ((that._trigger('added', e, data) !== false) &&
                                    (options.autoUpload || data.autoUpload) &&
                                    data.autoUpload !== false && !data.files.error) {
                                data.submit();
                            }
                        }
                );
            });
        },
        clean: function () {
            $('ul#mediaPreviewContainer').find('li').each(function () {
                if ($(this).find('span.cancel').length) {
                    $(this).remove();
                }//E# if statement
            });
        },
        // Callback for successful uploads:
        done: function (e, data) {
            var that = $(this).data('blueimp-fileupload') ||
                    $(this).data('fileupload'),
                    getFilesFromResponse = data.getFilesFromResponse ||
                    that.options.getFilesFromResponse,
                    files = getFilesFromResponse(data),
                    template,
                    deferred;
            if (data.context) {
                data.context.each(function (index) {
                    var file = files[index] ||
                            {error: 'Empty file upload result'};
                    deferred = that._addFinishedDeferreds();

                    that._transition($(this)).done(
                            function () {
                                var node = $(this);
                                template = that._renderDownload([file])
                                        .replaceAll(node);
                                that._forceReflow(template);
                                that._transition(template).done(
                                        function () {
                                            data.context = $(this);
                                            that._trigger('completed', e, data);
                                            that._trigger('finished', e, data);
                                            deferred.resolve();
                                        }
                                );
                            }
                    );
                });
            } else {
                template = that._renderDownload(files)[
                        that.options.prependFiles ? 'prependTo' : 'appendTo'
                ](that.options.filesContainer);
                that._forceReflow(template);
                deferred = that._addFinishedDeferreds();
                that._transition(template).done(
                        function () {
                            data.context = $(this);
                            that._trigger('completed', e, data);
                            that._trigger('finished', e, data);
                            deferred.resolve();
                        }
                );
            }

            that.options.mediaRemaining.html(that.options.maxNumberOfFiles - that.options.getNumberOfFiles());

            if (that.options.maxNumberOfFiles <= that.options.getNumberOfFiles()) {
                that.options.mediaButton.fadeOut(function () {
                    $(this).find('input[type=file]').prop('disabled', true);
                });
            }//E# if statement
        },
        // Callback for file deletion:
        destroy: function (e, data) {
            var that = $(this).data('blueimp-fileupload') ||
                    $(this).data('fileupload');
            //Clean
            that.options.clean();
            if (data.url) {
                $.ajax({
                    url: data.url,
                    type: 'DELETE',
                    dataType: data.dataType,
                    data: {
                        media_id: data.mediaId,
                        media_name: data.mediaName,
                        media_type: data.mediaType,
                        media_controller: data.mediaController
                    }
                }).done(function ($resultJSON) {
                    console.log($resultJSON);
                    that._transition(data.context).done(
                            function () {
                                that.options.mediaPreviewContainer.find('li').each(function () {
                                    if ($(this).find('.delete').data('mediaName') === data.mediaName) {
                                        $(this).remove();
                                    }//E# if statement
                                });
                                that._trigger('destroyed', e, data);
                            }
                    );

                    that.options.mediaRemaining.html(that.options.maxNumberOfFiles - that.options.getNumberOfFiles());

                    if (that.options.maxNumberOfFiles > that.options.getNumberOfFiles()) {
                        that.options.mediaButton.fadeIn(function () {
                            $(this).find('input[type=file]').prop('disabled', false);
                        });
                    }//E# if statement

                    //Show notification
                    showNotificationBar($resultJSON);

                }).fail(function ($jqXHR) {
                    showNotificationBar(jQuery.parseJSON($jqXHR.responseText));
                }).always(function () {

                });

            }
        },
        // Callback for file deletion:
    }).bind('fileuploadcompleted', function (e, data) {
        /*S# PLUGIN JQUERY SORTABLE*/
        $mediaPreviewContainer.unbind('sortupdate').sortable('destroy').sortable({
            items: ':not(.disabled)'
        }).bind('sortupdate', function (event, ui) {
            //Define $mediaIdArray
            var $mediaIdArray = new Array();

            //Get media id's and append to $mediaIdArray
            $mediaPreviewContainer.find('li').each(function () {
                $mediaIdArray.push($(this).find('i.delete').data('media-id'));
            });
            //console.log($mediaIdArray);
            $.ajax({
                url: inlineJs.baseUrl + '/media/order',
                type: 'PUT',
                dataType: 'JSON',
                data: {
                    media_type: $('input#mediaType').val(),
                    media_controller: $('input#mediaController').val(),
                    media_ids: $mediaIdArray
                }
            }).done(function ($resultJSON) {
                
                showNotificationBar($resultJSON);
            }).fail(function ($jqXHR) {
                showNotificationBar(jQuery.parseJSON($jqXHR.responseText));
            }).always(function () {

            });

        });
        /*S# PLUGIN JQUERY SORTABLE*/
    });
    $mediaPreviewContainer.on('click', '.cancel', function () {
        var $images = 0;
        $('ul#mediaPreviewContainer').find('li').each(function () {
            if ($(this).find('span.delete').length) {
                $images++;
            }//E# if statement
        });
        $('span#mediaRemaining').html(inlineJs.maxNumberOfFiles - $images);

        $(this).parent().remove();

    });
    $mediaPreviewContainer.on('blur', '.describeMedia', function () {
        var $describeMedia = $(this);
        if ($describeMedia.val() !== '') {//Description is not empty
            $.ajax({
                url: inlineJs.baseUrl + '/media/describe',
                type: 'PUT',
                dataType: 'json',
                data: {
                    media_id: $describeMedia.data('media-id'),
                    media_type: $describeMedia.data('media-type'),
                    media_description: $describeMedia.val()
                }
            }).done(function ($jsonResult) {
                //Show the notification
                showNotificationBar($jsonResult);
            }).fail(function ($jqXHR) {
                showNotificationBar(jQuery.parseJSON($jqXHR.responseText));
            }).always(function () {

            });
        }//E# if statement
    });

    $('#mediaUpload').each(function () {
        var that = this;
        //console.log(inlineJs.controller.id);
        var $url = inlineJs.baseUrl + '/media/uploaded';
        // Load existing files:    
        $.ajax({
            url: $url,
            type: 'GET',
            dataType: 'JSON',
            data: {
                id: inlineJs.controller_model.id,
                media_controller: $('input#mediaController').val()
            }
        }).done(function (data) {
            //console.log(result);
            if (!data.notification_type) {//Not a notification
                if (data && data.files.length) {
                    //console.log(data.files);
                    //$('span#post-photos-remaining').html(packageAllowedPhotos - data.files.length);
                    $(that).fileupload('option', 'done')
                            .call(that, null, {
                                result: data
                            });
                }
            }
        }).fail(function ($jqXHR) {
            showNotificationBar(jQuery.parseJSON($jqXHR.responseText));
        }).always(function () {

        });
    });

});
