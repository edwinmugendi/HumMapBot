/**
 * Document   : nakuru.js
 * Product      : ERP  
 * Created on : Jan 21, 2013, 11:48:05 AM
 * Author     : Edwin Mugendi
 * Description: JS for Nakuru theme of Backend bundle
 */

//Define map variables
var $infoWindow, $map, $marker, $geocoder, $latLng = null;
//Cache notification
var $notification = $('#notification');

//Notification animation
var $notificationAnimation;

var $deletedRows = [];

/**
 *S# onDragStart() closure
 *@author Edwin Mugendi
 *@link Google Maps https://developers.google.com/maps/
 *Close map info window
 **/
var onDragStart = function () {//Close $infoWindow
    $infoWindow.close();
};//E# onDragStart() closure

/**
 *S# OnDragEnd() closure
 *@author Edwin Mugendi
 *@link Google Maps https://developers.google.com/maps/
 *Geocode to get latitude and longitude, set map and marker center and position respectively, set info window content and open it, set current latitude and longitude
 */
var onDragEnd = function (event) {
    $latLng = event.latLng;
    $geocoder.geocode({
        'latLng': $latLng
    }, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {//Geocoding succeeded
            $center = results[0].geometry.location;
            $address = results[0].formatted_address;
        } else {//Geocoding failed
            $center = new google.maps.LatLng(-0.023559, 37.90619300000003);
            $address = 'Kenya';
        }//E# if else statement
        //Set $map and $marker center and position respectively
        $map.setCenter($center);
        $marker.setPosition($center);
        $infoWindow.setContent($address);
        $infoWindow.open($map, $marker);

        //Set latitude and longitude values respectively
        $('input#idLat').val($center.lat());
        $('input#idLng').val($center.lng());
    });
};//E# onDragEnd() closure


/**
 * S# $centerMap() closure
 * @author Edwin Mugendi
 * Set the maps center and lat and long to the fields
 * @param {object} $center google maps center object
 */
$centerMap = function ($center) {
    //Set $map and $marker center and position respectively
    $map.setCenter($center);
    $marker.setPosition($center);
    //Set latitude and longitude values respectively
    $('input#idLatitude').val($center.lat());
    $('input#idLongitude').val($center.lng());

};//E# $centerMap() closure

/**
 *S# zoomTo() function
 *@author Edwin Mugendi
 *@link Google Maps https://developers.google.com/maps/
 *Zoom the map to a given address
 *@param string $address the address to zoom to
 *@param int $zoom the map zoom level
 */
function zoomTo($address, $zoom) {
    //Define $infoWindow & $geocoder
    $infoWindow = new google.maps.InfoWindow({});
    $geocoder = new google.maps.Geocoder();

    if ($address === undefined) {
        if (inlineJs.crudId == 1) {
            $address = 'Manchester City, UK'
        } else {
            $address = {
                lat: inlineJs.controller_model.lat,
                long: inlineJs.controller_model.lng
            }
        }
    }//E# if statement

    //$zoom is not set, Hence default to 7
    $zoom = ($zoom === undefined) ? 7 : $zoom;

    //Create a $map object
    $map = new google.maps.Map(document.getElementById('mapCanvas'), {
        zoom: $zoom,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    //Create $marker object
    $marker = new google.maps.Marker({
        title: 'Drag marker to exact location',
        map: $map,
        draggable: true
    });

    if ($address.hasOwnProperty('lat') && $address.hasOwnProperty('long')) {//$address is has lat and long co-ordinate (mostly updating property)
        $center = new google.maps.LatLng($address.lat, $address.long);
        $centerMap($center);

    } else {//$address is string
        //Geocode and zoom
        $geocoder.geocode({
            'address': $address
        }, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {//Geocoding succeeded
                $center = results[0].geometry.location;
            } else {//Geocoding failed
                $center = new google.maps.LatLng(-0.023559, 37.90619300000003);
            }//E# if else statement
            $centerMap($center);
        });//E# geocode() function

    }//E# if else statement

    //Listen to Click event
    google.maps.event.addListener($marker, 'click', onDragEnd);

    //Listen to DragEnd event
    google.maps.event.addListener($map, 'click', onDragEnd);

    //Listen to DragEnd event
    google.maps.event.addListener($marker, 'dragend', onDragEnd);

    //Listen to DragStart event
    google.maps.event.addListener($marker, 'dragstart', onDragStart);
}
;//E# zoomTo() function
/**
 *S# loadMap() function
 *@author Edwin Mugendi
 *@link Google Maps https://developers.google.com/maps/
 *Zoom the map to a given address
 *@param string $address the address to zoom to
 *@param int $zoom the map zoom level
 */
function loadMap($address, $zoom) {
    //Define $infoWindow & $geocoder
    $infoWindow = new google.maps.InfoWindow({});
    $geocoder = new google.maps.Geocoder();

    if ($address === undefined) {
        var $address = {
            lat: inlineJs.controllerModel.latitude,
            long: inlineJs.controllerModel.longitude,
        }
    }//E# if statement

    //$zoom is not set, Hence default to global zoom that is set on page load
    $zoom = ($zoom === undefined) ? inlineJs.zoom : $zoom;

    //Create a $map object
    $map = new google.maps.Map(document.getElementById('mapGala'), {
        zoom: $zoom,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    //Create $marker object
    $marker = new google.maps.Marker({
        map: $map,
        icon: inlineJs.baseUrl + '/media/homes/theme/mapIcon.png'
    });

    if ($address.hasOwnProperty('lat') && $address.hasOwnProperty('long')) {//$address is has lat and long co-ordinate (mostly updating property)
        $center = new google.maps.LatLng($address.lat, $address.long);
        $centerMap($center);

    } else {//$address is string
        //Geocode and zoom
        $geocoder.geocode({
            'address': $address
        }, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {//Geocoding succeeded
                $center = results[0].geometry.location;
            } else {//Geocoding failed
                $center = new google.maps.LatLng(-0.023559, 37.90619300000003);
            }//E# if else statement
            $centerMap($center);

        });//E# geocode() function

    }//E# if else statement
}//E# loadMap function

/**
 *S# injectGMaps() function
 *@author Edwin Mugendi
 *@link Google Maps https://developers.google.com/maps/
 *load Google Maps Library
 **/
function injectGMaps() {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = inlineJs.googleMaps;
    document.body.appendChild(script);
}//E# injectGMaps() function

/**
 *S# changeOrg
 *
 *Change organization
 *  */
function changeOrg() {
    $('.changeOrg').click(function ($event) {
        $event.preventDefault();
        console.log($(this).data('orgId'));
        $('#idChangeOrgId').val($(this).data('orgId'));

        $('#idChangeOrgForm').submit();
    });
}
function numberFormat($value) {
    return $value;
}
function labelFormatter(label, series) {
    return "<div style='text-align:center; padding:2px; color:white'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
}

function showPieChart($htmlId, $data) {
    $.plot($htmlId, $data, {
        series: {
            pie: {
                show: true,
                radius: 1,
                label: {
                    show: true,
                    radius: 1 / 2,
                    formatter: labelFormatter,
                    background: {
                        opacity: 0.5,
                        color: "#000"
                    }
                }
            }
        },
        legend: {
            show: false
        }
    });
}
// User define function
function Scroll() {
    var contentTop = [];
    var contentBottom = [];
    var winTop = $(window).scrollTop();
    var rangeTop = 200;
    var rangeBottom = 500;
    $('.navbar-collapse').find('.scroll a').each(function () {
        var $url = $(this).attr('href').split('#');
        var $href = '#' + $url[1];
        contentTop.push($($href).offset().top);
        contentBottom.push($($href).offset().top + $($href).height());
    })
    $.each(contentTop, function (i) {
        if (winTop > contentTop[i] - rangeTop) {
            $('.navbar-collapse li.scroll')
                    .removeClass('active')
                    .eq(i).addClass('active');
        }
    })

}

function hideNotificationBar() {
    $notification.parents('div.row').fadeOut(2000, function () {
        $(this).addClass('hidden');
        $notification.removeClass('alert-*').find('span#notificationMessage').html('')
    });
}
function registerNotificationAnimation() {
    //Clear notification animation
    clearTimeout($notificationAnimation);

    $notificationAnimation = setTimeout(function () {
        hideNotificationBar()
    }, 15000);
}
function showNotificationBar($notificationData) {
    if ($notificationData.type == 'success') {
        //Show success notification
        $notification
                .removeClass('alert-danger alert-info')
                .addClass('alert-success')
                .parents('div.row')
                .removeClass('hidden')
                .show();
        //Set message
        $notification.find('span').html($notificationData.message);
    } else if ($notificationData.type == 'info') {
        //Show success notification
        $notification
                .removeClass('alert-success alert-danger')
                .addClass('alert-info')
                .parents('div.row')
                .removeClass('hidden')
                .show();
        //Set message
        $notification.find('span').html($notificationData.message);
    } else {
        //Show danger notification
        $notification
                .removeClass('alert-success alert-info')
                .addClass('alert-danger')
                .parents('div.row')
                .removeClass('hidden')
                .show();
        //Set message
        $notification.find('span').html($notificationData.message);
    }
}
function leaveApplicationDuration($suffix) {
    $('#idDuration' + $suffix).change(function () {
        var $durationValue = parseInt($(this).val());
        if ($durationValue === 1) {//Full day
            hideShowField('#idAmPm' + $suffix + ',#idStartTime' + $suffix + ',#idEndTime' + $suffix + ',#idHours' + $suffix, 'hide');
        } else if ($durationValue === 2) {//Half day
            hideShowField('#idAmPm' + $suffix, 'show');
            hideShowField('#idStartTime' + $suffix + ',#idEndTime' + $suffix + ',#idHours' + $suffix, 'hide');
        } else if ($durationValue === 3) {//Special time
            hideShowField('#idAmPm' + $suffix, 'hide');
            hideShowField('#idStartTime' + $suffix + ',#idEndTime' + $suffix + ',#idHours' + $suffix, 'show');
            $('#idHours' + $suffix).prop('disabled', true);
        }//E# if else statement
    });
}
/**
 * S# leaveApplicationSpecialTime() function
 * Leave application special times
 * 
 * @param {str} $idFrom From id
 * @param {str} $idTo To id
 * @param {str} $idDifference Difference id
 * */
function leaveApplicationSpecialTime($idFrom, $idTo, $idDifference) {
    //Cache
    var $idFromTime = $($idFrom);
    var $idToTime = $($idTo);
    $($idFrom + ',' + $idTo).blur(function () {
        if ($idFromTime.val() && $idToTime.val()) {
            //Hide errors
            $idFromTime.parents('.commonFloatLeft').siblings('.commonColorRed').html('');
            $idToTime.parents('.commonFloatLeft').siblings('.commonColorRed').html('');

            //Create From and To moment
            var $from = moment($idFromTime.val(), 'HH:mm');
            var $to = moment($idToTime.val(), 'HH:mm');

            if ($from.isAfter($to)) {//From date should be after To date
                $idFromTime.parents('.commonFloatLeft').siblings('.commonColorRed').html('From time should after To to');
            } else {
                var $minutes = $to.diff($from, 'minutes');
                var $hours = ($minutes / 60).toFixed(2);
                $($idDifference).val($hours);
            }//E# if else statement
        }//E# if statement
    });
}//E# leaveApplicationSpecialTime() function

function leaveApplicationDateChanged() {
    //Cache
    var $idFromDate = $('#idFromDate');
    var $idToDate = $('#idToDate');

    $('#idFromDate,#idToDate').blur(function () {
        if ($idFromDate.val() && $idToDate.val()) {
            //Hide errors
            $idFromDate.parents('.commonFloatLeft').siblings('.commonColorRed').html('');
            $idToDate.parents('.commonFloatLeft').siblings('.commonColorRed').html('');

            var $from = moment($idFromDate.val(), inlineJs.date_format);
            var $to = moment($idToDate.val(), inlineJs.date_format);

            if ($from.isValid()) {
                if ($to.isValid()) {//To date is valid
                    if ($from.isAfter($to)) {//From date should be after To date
                        $idFromDate.parents('.commonFloatLeft').siblings('.commonColorRed').html('From date should after To date');
                    } else {
                        if ($from.isSame($to)) {//Same day
                            $('#idIsSameDay').val(1);
                            hideShowField('#idPartialDays,#idDuration2,#idAmPm2,#idStartTime2,#idEndTime2,#idHours2,#idDuration3,#idAmPm3,#idStartTime3,#idEndTime3,#idHours3', 'hide');
                            hideShowField('#idDuration', 'show');
                        } else {//Different dates
                            $('#idIsSameDay').val(0);
                            hideShowField('#idDuration,#idAmPm,#idStartTime,#idEndTime,#idHours', 'hide');
                            hideShowField('#idPartialDays', 'show');
                        }//E# if else statement
                    }//E# if else statement
                } else {//Invalid To date
                    $idToDate.parents('.commonFloatLeft').siblings('.commonColorRed').html('Invalid from date');
                }//E# if else statement
            } else {//Invalid From date
                $idFromDate.parents('.commonFloatLeft').siblings('.commonColorRed').html('Invalid from date');
            }//E# if else statement
        }//E# if statement
    });

}
/**
 * S# hideShowField() function
 * hide or show field
 * @param {str} $field Field
 * @param {str} $hideOrShow Hide or show
 * */
function hideShowField($field, $hideOrShow) {
    if ($hideOrShow == 'hide') {
        $($field)
                .prop('disabled', true)
                .siblings('span.input-group-addon')
                .parents('div.formCell')

                .fadeOut();
    } else {
        $($field)
                .prop('disabled', false)
                .siblings('span.input-group-addon')
                .parents('div.formCell')
                .removeClass('commonDisplayNoneImportant')
                .fadeIn();
    }//E# if else statement
}//E# hideShowField() function
/**
 * S# setDatePicker() function
 * @author Edwin Mugendi
 * @link Twitter bootstrap Date picker http://eonasdan.github.io/bootstrap-datetimepicker/
 * Attach the date picker to fields with a date class identifier
 * @param {string} $language the language code
 **/
function setDatePicker($language) {
    $('body').on('focus', 'input.datePicker', function () {
        $(this)
                .datetimepicker({
                    pickTime: false,
                    language: $language,
                    format: inlineJs.date_format
                });
    });
}//E# setDatePicker() function

/**
 * S# setTimePicker() function
 * @author Edwin Mugendi
 * @link Twitter bootstrap Time picker http://eonasdan.github.io/bootstrap-timetimepicker/
 * Attach the time picker to fields with a time class identifier
 * @param {string} $language the language code
 **/
function setTimePicker($language) {
    $('body').on('focus', 'input.timePicker', function () {
        $(this)
                .datetimepicker({
                    use24hours: true,
                    pickDate: false,
                    language: $language,
                    format: 'HH:mm'
                });
    });
}//E# setTimePicker() function

/**
 * S# registerSearchableSelect() function
 * @author Edwin Mugendi
 * @link https://github.com/ivaynberg/select2
 * Set html select searchable
 **/
function registerSearchableSelect() {

}//E# registerSearchableSelect() function

/**
 * S# showFieldWhenOtherFieldIs() function
 * @author Edwin Mugendi
 * Show this field when the other field is
 **/
function showFieldWhenOtherFieldChangesTo($idFieldToShow, $idOtherField, $value, $operator) {
    $('#' + $idOtherField).change(function () {
        //Cache field to show
        var $fieldToShow = $('#' + $idFieldToShow);

        var $bool = false;
        if ($operator == 'equal') {
            $bool = $(this).val() == $value;
        } else if ($operator == 'not_equal') {
            $bool = $(this).val() != $value;
        }

        showOrHideField($fieldToShow, $bool);

        //Size form
        sizeForm();

    });
}//E# showFieldWhenOtherFieldIs() function

/**
 * S# showOrHideField() function
 * Show or hide a given field
 * 
 * @param {htmlObject} $field Field
 * @param {boolean} $bool true show, false hide
 * */
function showOrHideField($field, $bool) {
    if ($bool) {//Show field
        $field
                .prop('disabled', false)
                .parents('div.formCell')
                .removeClass('commonDisplayNoneImportant');
    } else {//Hide field
        $field
                .prop('disabled', true)
                .parents('div.formCell')
                .addClass('commonDisplayNoneImportant');
    }//E# if else statement
}//showOrHideField() function
/**
 * S# camelize() prototype
 * @author Edwin Mugendi
 * @link Best Practice http://en.wikipedia.org/wiki/CamelCase
 * Camelize this string
 * @return {string} camelized string
 * */
String.prototype.camelize = function () {
    return this.replace(/(?:^|[-_])(\w)/g, function (_, c) {
        return c ? c.toUpperCase() : '';
    })
};//E# camelize() prototype


/**
 * S# sizeForm() function
 @author Edwin Mugendi
 * Size the form fields
 */
function sizeForm() {
    var $windowWidth = $(window).width();
    if ($windowWidth > 1000) {
        var $formContainer = $('div.shadowPortletContainer');
        var $formContainerWidth = $formContainer.width();

        var $formContainerPadding = parseInt($formContainer.css('padding'), 10);

        //TO-DO: REMOVE THE SPACE IN THE CHILD 
        var $appenderWidth = $formContainer.find('div.input-group').eq(0).find('span.input-group-addon').eq(0).outerWidth();

        $formContainer.find('div.formRow').each(function () {
            var $that = $(this);
            //Set the form row left margin
            $that.css('margin', ($formContainerPadding) + 'px 0');

            //Get number of fields
            var $fields = $that.children('div.formCell').length;

            $that.find('div.formCell').each(function () {
                var $that = $(this);

                //if (true) {
                //var $inputElement = $that.find('input[type=text],textarea,select');
                $that.width(function () {
                    return (($formContainerWidth / $fields) - ($formContainerPadding * 3) - ($appenderWidth * 1));
                }).css('margin-right', '10px');
            });
        }//E# each() function
        );
    }//E# if statement
}// E# sizeForm() function

function maxLengthIndicator() {
    /*S# Set remaining characters of property name and description*/
    $('input[maxlength],textarea[maxlength]').keyup(function () {
        //Cache $input
        $input = $(this);
        //Set remaining characters
        $container = $input.parent()
                .parent()
                .siblings('span.formCharacterRemainingContainer');
        $container
                .find('span.formCharactersRemainingNumber')
                .text($input.attr('maxlength') - $input.val().length);

        //Add red color and bold css to the remaining characters when more than 80% of the maxlength have been typed
        if ((($input.val().length * 100) / $input.attr('maxlength')) > 80) {
            $container.addClass('commonFontWeightBold commonColorRed');
        } else {//Remove red color and bold css to the remaining characters when less 80% of the maxlength have been typed
            $container.removeClass('commonFontWeightBold commonColorRed');
        }//E# if else statement
    }).keyup();
    /*E# Set remaining characters of property name and description*/

}//E# maxLengthIndicator() function


//Resive the form on window resize event
$(window).resize(function () {
    sizeForm();
});

function ajaxBeforeSending() {
    var $notificationData = {
        type: 'info',
        message: 'Processing...'
    }
    showNotificationBar($notificationData);
}
/**
 * S# AjaxOptions() function
 * @author Edwin Mugendi
 * Ajax options wrapper
 * @param {string} $url the url to be called
 */
function AjaxOptions($url) {
    this.url = inlineJs.baseUrl + $url;
    this.type = 'GET';
    this.dataType = 'JSON';
    this.async = false;
    this.data = {};
    this.beforeSend = function () {
    };
    //Register failed callback
    this.failed = function ($jqXHR) {
        //Get the json data from xhr
        var $jsonData = jQuery.parseJSON($jqXHR.responseText);
        //Show notification
        var $notificationData = {
            type: 'danger',
            message: $jsonData.error.message
        }
        showNotificationBar($notificationData);
    }//E# failed() function
}//E# AjaxOptions() function

/**
 * S# ajaxify() function
 * @author Edwin Mugendi
 * Make an ajax call
 * @param {json} $options ajax options
 */
function ajaxify($options) {
    $.ajax($options)
            .done($options.done)
            .fail($options.failed)
            .always($options.always);
}//E# ajaxify() function

/**
 * S#resetForm() function
 * Reset form when reset button is clicked
 * 
 * @param {string} $resetButton Reset button selector
 * 
 **/
function resetForm($resetButton) {
    $($resetButton).click(function ($event) {
        $(this).parents('form')[0].reset();
        $event.preventDefault();
    });
}
/**
 * S# validateForm() function
 * Validate form
 *  */
function validateForm($formController) {
    //Cache form
    var $theForm = $($formController);

    /*S# PLUGIN: Validation Engine*/
    $theForm.validationEngine({
        //UNCOMMENT scrollOffset: ($('div#topBar').height() * 2),
        autoPositionUpdate: true,
        onValidationComplete: function ($form, $status) {
            if ($status === true) {//Form is valid
                //Show processing text
                $theForm.find('.btn-processing')
                        .prop('disabled', true)
                        .html(function () {
                            return $(this).data('processing');
                        });

                $theForm[0].submit();
            }//E# if statement
        }//E# onValidationComplete() function
    });
    /*E# PLUGIN: Validation Engine*/

    /**Change form text*/
    $('#idPostButton').click(function () {
        var $that = $(this);
        //Crud id
        var $crudId = $that.data('crudid');

        if ($crudId === 3) {//View 
            //Enable fields and show 
            $($formController).find('input,select,textarea').each(function () {
                $(this).prop('disabled', false);

                $that.html($that.data('update'));
                $that.data('crudid', 2);
            });
        } else {//Validate and submit
            $($formController).validationEngine('validate');
        }//E# if else statement
    });
    /**Change form text*/

    //Attaching the input and textarea fields help attribute to the popover help
    $theForm.popover({
        selector: 'span.formHelp'
    }).on('mouseenter mouseleave', 'span.formHelp', function ($event) {
        $(this).popover('mouseenter' === $event.type ? 'show' : 'hide');
    });
    /*E# PLUGIN: TwitterBootstrap Help Popover */

}//E# validateForm function

/**
 *S# registerFormEvents() function
 *Register form validation
 **/
function registerFormEvents() {
    if (inlineJs.crudId == 1 || inlineJs.crudId == 2) {
        validateForm('form#' + inlineJs.controller + 'Post');

        //Size the forms
        sizeForm();

        //Max length indicator
        maxLengthIndicator();

        //Register searchable select
        registerSearchableSelect();

    }//E# if statement
    //Register Reset button
    resetForm('.resetButton');
}//E# registerFormEvents() function

/*
 *S# showNotification() function
 *@author Edwin Mugendi
 *Show notification
 *@link PNotify http://pinesframework.org/pnotify/
 *@param JSON notification details keys are:
 *@key string required $type the type, can be 'error', notice'', 'info' or 'success'
 *@key string required $message the message
 *@key string optional $title the title
 **/
function showNotification($notification) {
    $.pnotify({
        styling: 'bootstrap3',
        type: $notification.type,
        title: ($notification.title ? $notification.title : false),
        text: $notification.message,
        icon: ($notification.icon ? $notification.icon : true),
        animation: 'show',
        closer_hover: false,
        delay: 15000,
        addclass: 'stack-bottomright',
        stack: {
            'dir1': 'up',
            'dir2': 'left',
            'firstpos1': 25,
            'firstpos2': 25
        }
    });
}//E# showNotification() function

/**
 * S# hideNotification() function
 * @author Edwin Mugendi
 * Hide notifications
 * */
function hideNotification() {
    $.pnotify_remove_all();
}//E# hideNotification() function

String.prototype.capitalize = function () {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

/**
 * S# sprintf() prototype
 * @author Edwin Mugendi
 * Returns a formatted string
 * */
String.prototype.sprintf = function () {
    var $formatted = this;
    for (var i = 0; i < arguments.length; i++) {
        var $regexp = new RegExp(/:(\S+)/);
        $formatted = $formatted.replace($regexp, arguments[i]);
    }//E# for estatement
    return $formatted;
};//E# sprintf() prototype

/**
 * S# pageEntitlementGetMatchedEmployees() function
 * @author Edwin Mugendi
 * Get matched employees
 */
function pageEntitlementGetMatchedEmployees() {
    var $ajaxOptions = new AjaxOptions('/leave/count_employees/entitlement');
    $ajaxOptions.type = 'GET';
    $ajaxOptions.dataType = 'JSON';
    $ajaxOptions.data = {
        department_id: $('#idDepartmentId').val(),
        location_id: $('#idLocationId').val()
    };
    $ajaxOptions.done = function ($data) {
        $('#idMatchedEmployees').html($data.text);
    }//E# done function

    ajaxify($ajaxOptions);

}//E# pageEntitlementGetMatchedEmployees() function

/**
 * S# startsWith() function
 * Check if a string starts with
 * 
 * @return {boolean}
 * */
if (typeof String.prototype.startsWith != 'function') {
    String.prototype.startsWith = function (str) {
        return str.length > 0 && this.substring(0, str.length) === str;
    }
}//E# startsWith() function

/**
 * S# endsWith() function
 * Check if a string ends with
 * 
 * @return {boolean}
 * */

if (typeof String.prototype.endsWith != 'function') {
    String.prototype.endsWith = function (str) {
        return str.length > 0 && this.substring(this.length - str.length, this.length) === str;
    }
}//E# endsWith() function

/**
 *S# registerDeleteRow() function
 *Register Delete Row event
 *  */
function registerDeleteRow() {
    $('.deleteRow,#idDeleteRow').click(function ($event) {


        //Define source and confirm message
        var $source, $confirmMessage;
        //Define id to delete
        var $idToDelete = [];

        var $that = $(this);

        if (this.id === 'idDeleteRow') {
            //Set source
            $source = 'id';

            //Get the id to delete
            $('.rowToCheck:checked').each(function () {
                var $ids = this.value.split(',');
                for (var $index = 0; $index < $ids.length; $index++) {
                    $idToDelete.push($ids[$index]);
                }//E# for statement
            });

            //Set confirm message
            $confirmMessage = inlineJs.lang.actions.delete.confirmMany.toString().sprintf($idToDelete.length);

            //Hide view row
            $('.viewRow').each(function () {
                var $that = $(this);
                if ($that.is(':visible')) {
                    var $id = $that.data('id');
                    $('.singleRow[data-id=' + $id + ']').find('.previewLink').click();
                }//E# if statement
            });

        } else {

            //Set source
            $source = 'class';

            //Get ids and convert to string
            var $ids_str = '' + $that.data('ids');

            //Split the string by ,
            var $ids = $ids_str.split(',');

            for (var $index = 0; $index < $ids.length; $index++) {
                $idToDelete.push($ids[$index]);
            }//E# for statement

            //Set confirm messsage
            $confirmMessage = inlineJs.lang.actions.delete.confirm;

            //View row
            var $viewRow = $('.singleRow[data-id=' + $that.data('id') + ']');

            //Hide view data
            if ($viewRow.is(':visible')) {
                $viewRow.find('.previewLink').click();
            }//E# if statement

        }//E# if else statement

        var $bootBoxOptions = {
            message: $confirmMessage,
            buttons: {
                cancel: {
                    label: inlineJs.lang.actions.delete.cancel,
                    className: "btn"
                },
                confirm: {
                    label: inlineJs.lang.actions.delete.delete,
                    className: "btn-danger"
                }
            },
            callback: function ($yes) {
                if ($yes) {
                    //Setup ajax to delete
                    var $ajaxOptions = new AjaxOptions('/' + inlineJs.package + '/delete/' + inlineJs.controller);
                    $ajaxOptions.type = 'POST';
                    $ajaxOptions.dataType = 'JSON';
                    $ajaxOptions.data = {
                        source: 'ajax',
                        ids: $idToDelete
                    };
                    //Register done callback
                    $ajaxOptions.done = function ($jsonData) {
                        //Define variables
                        var $message, $error;
                        var $count = 0;
                        $deletedRows = [];

                        if ($source === 'id') {//id source
                            $.each($jsonData, function (index, $response) {
                                if ($response.code === 200) {//Success
                                    //Increment deleted
                                    $count++;

                                    //Push id to deleted row
                                    $deletedRows.push($response.id);

                                    //Hide this row
                                    $('table#idListTable').find('.singleRow').each(function () {
                                        var $thisRow = $(this);
                                        var $rowId = $thisRow.data('id');
                                        if ($rowId == $response.id) {
                                            //Hide row
                                            $thisRow.slideUp('slow');
                                            //Reset arrow
                                            $thisRow.find('.previewLink').find('i').removeClass().addClass('icon-data-arrow-right');
                                            //Hide hidden row
                                            $('#hiddenRow-' + $rowId).removeClass('previewShown').slideUp('slow');
                                        }//E# if statement
                                    });
                                } else if ($response.code === 403) {//Forbidden
                                    $error = $response.message;
                                }//E# if else statement
                            });

                            //Set message
                            $message = inlineJs.lang.actions.delete.deleteMany.toString().sprintf($count);
                        } else {
                            if ($jsonData[0].code === 200) {//Suucess
                                //Set count
                                $count = 1;

                                //Remove this row
                                $that.parents('tr').slideUp('slow');

                                //Push id to deleted row
                                $deletedRows.push($jsonData[0].id);
                            } else {//Other wise
                                //Set count
                                $count = 0;

                            }//E# if else statement

                            //Set message
                            $message = $jsonData[0].message;
                        }//E# if else statement

                        if ($count) {//At least on record deleted
                            //Append undo delete link to message
                            $message += ' <a href="#" id="idUndoDelete">' + inlineJs.lang.actions.undelete.undoDelete + '</a>';
                        }//E# if else statement

                        if ($error) {//Error message is set
                            $message += '<br>' + $error;
                        }//E# if else statement

                        var $notificationData = {
                            type: 'success',
                            message: $message
                        }
                        showNotificationBar($notificationData);

                    }//E# done() function

                    //Register always callback
                    $ajaxOptions.always = function ($jqXHR, $textStatus) {
                        registerNotificationAnimation();
                    }//E# always() function

                    //Delete
                    ajaxify($ajaxOptions);
                }//E# if statement
            },
        }//E# bootBoxOptions

        //Confirm delet
        bootbox.confirm($bootBoxOptions);

        //Prevent default event
        $event.preventDefault();
    });

}//E# registerDeleteRow() function

/**
 * S# registerUndoDelete() function
 * 
 * */
function registerUndoDelete() {

    //Add  row
    $notification.on('click', 'a#idUndoDelete', function ($event) {
        //Clear notification animation
        clearTimeout($notificationAnimation);

        //Prevent default
        $event.preventDefault();

        //Setup ajax to delete
        var $ajaxOptions = new AjaxOptions('/' + inlineJs.package + '/undelete/' + inlineJs.controller);
        $ajaxOptions.type = 'POST';
        $ajaxOptions.dataType = 'JSON';
        $ajaxOptions.data = {
            source: 'ajax',
            ids: $deletedRows
        };
        //Register done callback
        $ajaxOptions.done = function ($jsonData) {
            console.log($jsonData);

            var $message;
            var $count = 0;
            $.each($jsonData, function (index, $response) {
                if (parseInt($response.code) === 200) {
                    console.log("in 200");
                    $count++;

                    //Show row
                    $('table#idListTable').find('.singleRow').each(function () {
                        var $thisRow = $(this);
                        if (parseInt($thisRow.data('id')) === parseInt($response.id)) {
                            $thisRow.show('slow');
                        }//E# if else statement
                    });
                }//E# if statement
            });

            //Set message
            $message = inlineJs.lang.actions.undelete.undeleted.toString().sprintf($count);

            var $notificationData = {
                type: 'success',
                message: $message
            }
            showNotificationBar($notificationData);

        }//E# done() function

        //Register always callback
        $ajaxOptions.always = function ($jqXHR, $textStatus) {
            registerNotificationAnimation();
        }//E# alwats() function

        //Delete
        ajaxify($ajaxOptions);
    });
}//E# registerUndoDelete() function

/**
 *S# registerWorkflow() function
 *
 * Register approve or disapprove event
 * 
 **/
function registerWorkflow($htmlElement, $action) {
    $($htmlElement).click(function ($event) {

        //Clear notification animation
        clearTimeout($notificationAnimation);

        //Define source and confirm message
        var $source, $confirmMessage;

        //Define id to delete
        var $idToDelete = [];

        var $that = $(this);

        if ((this.id === 'idApproveRow') || (this.id === 'idDisapproveRow') ||
                (this.id === 'idPublishRow') || (this.id === 'idUnpublishRow') ||
                (this.id === 'idEmailRow')
                ) {
            //Set source
            $source = 'id';

            //Get the id to delete
            $(".rowToCheck:checked").each(function () {
                var $ids = this.value.split(',');
                for (var $index = 0; $index < $ids.length; $index++) {
                    $idToDelete.push($ids[$index]);
                }//E# for statement
            });
            //Set confirm message
            $confirmMessage = inlineJs['lang']['actions'][$action]['confirmMany'].toString().sprintf($idToDelete.length);

        } else {
            //Set source
            $source = 'class';

            //Get ids and convert to string
            var $ids_str = '' + $that.data('ids');
            //Split the string by ,
            var $ids = $ids_str.split(',');

            for (var $index = 0; $index < $ids.length; $index++) {
                $idToDelete.push($ids[$index]);
            }//E# for statement

            //Set confirm messsage
            $confirmMessage = inlineJs['lang']['actions'][$action]['confirm'];
        }//E# if else statement

        var $bootBoxOptions = {
            message: $confirmMessage,
            buttons: {
                cancel: {
                    label: inlineJs.lang.actions.delete.cancel,
                    className: "btn"
                },
                confirm: {
                    label: inlineJs['lang']['actions'][$action][$action],
                    className: "btn-danger"
                }
            },
            callback: function ($yes) {
                if ($yes) {
                    //Setup ajax to delete
                    var $ajaxOptions = new AjaxOptions('/' + inlineJs.package + '/workflow/' + inlineJs.controller);
                    $ajaxOptions.type = 'POST';
                    $ajaxOptions.dataType = 'JSON';
                    $ajaxOptions.data = {
                        source: 'ajax',
                        action: $action,
                        ids: $idToDelete
                    };
                    //Register Before Send
                    $ajaxOptions.beforeSend = ajaxBeforeSending();
                    //Register done callback
                    $ajaxOptions.done = function ($jsonData) {
                        var $message;
                        var $count = 0;
                        $.each($jsonData, function (index, $response) {
                            if (parseInt($response.code) === 200) {
                                //Increment acted on
                                $count++;
                                console.log($that.data('fieldClass'));
                                //Hide this row
                                $('table#idListTable').find('.' + $that.data('fieldClass')).each(function () {
                                    var $thisRow = $(this);
                                    if (parseInt($thisRow.data('id')) === parseInt($response.id)) {
                                        $thisRow.html($response.message);
                                    }//E# if statement
                                });
                            }//E# if statement
                        });

                        if ($source === 'id') {
                            //Set message
                            $message = inlineJs['lang']['actions'][$action][$action + 'Many'].toString().sprintf($count);
                        } else {
                            //Set message
                            $message = $jsonData[0].message;
                        }//E# if else statement

                        //Show notification
                        var $notificationData = {
                            type: 'success',
                            message: $message
                        }
                        showNotificationBar($notificationData);
                    }//E# done() function

                    //Register always callback
                    $ajaxOptions.always = function ($jqXHR, $textStatus) {
                        registerNotificationAnimation();
                    }//E# alwats() function

                    //Delete
                    ajaxify($ajaxOptions);
                }//E# if statement
            },
        }//E# bootBoxOptions

        //Confirm delet
        bootbox.confirm($bootBoxOptions);

        //Prevent default event
        $event.preventDefault();
    });

}//E# registerWorkflow() function


function registerViewPayroll() {
    $('.view-payroll').click(function ($event) {
        var $id = $(this).data('id');

        var $ajaxOptions = new AjaxOptions('/payroll/view/payroll');
        $ajaxOptions.type = 'GET';
        $ajaxOptions.dataType = 'HTML';
        $ajaxOptions.data = {
            id: $id
        };
        $ajaxOptions.beforeSend = ajaxBeforeSending();
        $ajaxOptions.done = function ($data) {
            hideNotificationBar();
            bootbox.alert($data);
        }//E# done function

        ajaxify($ajaxOptions);

        //Prevent default
        $event.preventDefault();
    });
}
/**
 * S# tableRowChanged() function
 * Table row changed
 **/
function tableRowChanged() {
    $('#tableBracket')
            .find('.bracketLevel')
            .each(function ($index, $cell) {
                $(this).html($index + 1);
            });
    return false;
}//E# tableRowChanged() function

/**
 * S# selectAllEmployees() function
 * Select all employees
 * */
function selectAllEmployees() {
    checkCheckboxes('#idSelectAll', '#idUserTable .userIdCheckBox');
}//E# selectAllEmployees() function

/*
 * S# checkCheckboxes() function
 * Check checkboxes
 *
 * @param str $eventListener
 * @param str $checkbox
 * @returns null
 */
function checkCheckboxes($eventListener, $checkbox) {
    $($eventListener).click(function () {
        if ($(this).prop('checked')) {//Checked
            $($checkbox).each(function () {
                $(this).prop('checked', true);
            });
        } else {//Unchecked
            $($checkbox).each(function () {
                $(this).prop('checked', false);
            });
        }//E# if else statement
    });
}//E# checkCheckboxes() function

/*
 * S# disableButtons() function
 * Disable buttons
 *
 * @param str $eventListener
 * @param str $idsToDisable
 * @returns null
 */
function disableButtons($eventListener, $idsToDisable) {
    $($eventListener).click(function () {
        if ($(this).prop('checked')) {//Checked
            $($idsToDisable).prop('disabled', false);
        } else {//Unchecked
            $($idsToDisable).prop('disabled', true);
        }//E# if else statement
    });
}//E# disableButtons() function

/*
 * //E# rowIsCheck() function
 * A row is checked so don't disable the buttons
 *    
 * @param {type} $eventListener
 * @param {type} $idsToDisable
 */
function rowIsCheck($eventListener, $idsToDisable) {
    $($eventListener).click(function () {
        if ($(this).prop('checked')) {//Checked
            $($idsToDisable).prop('disabled', false);
        } else {//Unchecked
            $($idsToDisable).prop('disabled', true);

            $($eventListener).each(function () {
                if ($(this).prop('checked')) {
                    $($idsToDisable).prop('disabled', false);
                }//E# if statement
            });
        }//E# if else statement
    });
}//E# rowIsCheck() function

/**
 * S# registerSearchSubmit() function
 * Register search submit buttone
 * */
function registerSearchSubmit() {
    $('.searchSubmit').click(function ($event) {
        $event.preventDefault();
        $(this).parents('tr').find('form').submit();
    });
}//E# registerSearchSubmit() function

/**
 * S# registerPreviewRow() function
 * Register preview row
 * */
function registerPreviewRow() {
    $('.previewLink').click(function ($event) {
        $event.preventDefault();
        var $that = $(this);
        if ($that.hasClass('previewShown')) {//Hide Preview Container
            $that.find('i').removeClass().addClass('icon-data-arrow-right');
            $that.removeClass('previewShown');
            $('#hiddenRow-' + $that.data('id')).hide();
        } else {//Show Preview Container
            $that.find('i').removeClass().addClass('icon-data-arrow-down');
            $that.addClass('previewShown');
            $('#hiddenRow-' + $that.data('id')).show();
        }//E# if else statement

    });
}//E# registerPreviewRow() function

/**
 *S# registerViewImage() function
 *Register view image
 * */
function registerViewImage() {
    $('.viewImage').click(function ($event) {
        $event.preventDefault();
        var $modal = $('#viewImageModal');
        $('#viewImageModalImage').attr('src', $(this).data('url'));
        $modal.modal('show');
    });
}//E# registerViewImage() function

function crmRegisterRelatedToLoader($controller, $relatedTo) {
    //Setup ajax to delete
    var $ajaxOptions = new AjaxOptions('/' + inlineJs.package + '/related/' + $controller + '/' + $relatedTo);
    $ajaxOptions.type = 'GET';
    $ajaxOptions.dataType = 'JSON';

    //Register done callback
    $ajaxOptions.done = function ($data) {
        //Set label text
        $('label#idRelatedIdLabel').text($data.field_name);

        var $idRelatedId = $('select#idRelatedId');

        //Remove all option;
        $idRelatedId
                .find('option')
                .remove();

        //Add all options
        $.each($data.select_array, function (key, value) {
            $idRelatedId
                    .prepend($('<option>', {value: key})
                            .text(value));
        });


    }//E# done() function

    //Register always callback
    $ajaxOptions.always = function ($jqXHR, $textStatus) {

    }//E# alwats() function

    //Delete
    ajaxify($ajaxOptions);
}

jQuery(document).ready(function ($) {
    /*Load Maps*/
    if (inlineJs.mappable) {

        //Call injectGMaps on window load
        window.onload = injectGMaps;
    }
    //Stick footer to the bottom
    var docHeight = $(window).height();
    var footerHeight = $('#footer').outerHeight();
    var footerTop = $('#footer').position().top + footerHeight;

    if (footerTop < docHeight) {
        $('#footer').css('margin-top', (docHeight - footerTop) + 'px');
    }

    //Add Hover effect to menus
    $('ul.nav li.dropdown').hover(function () {
        $(this).addClass('open').find('.dropdown-menu').stop(true, true).delay(0).fadeIn();
    }, function () {
        $(this).removeClass('open').find('.dropdown-menu').stop(true, true).delay(0).fadeOut();
    });

    //Change organization
    changeOrg();
    //Register date picker
    setDatePicker('en');
    //Register time picker
    setTimePicker('en');
    //Register form Event
    registerFormEvents();
    //Register delete row
    registerDeleteRow();
    //Register undo delete
    registerUndoDelete();
    //Check check boxes
    checkCheckboxes('#idCheckUnCheckRow', '.rowToCheck');
    //Disable buttons
    disableButtons('#idCheckUnCheckRow', '#idDeleteRow');
    //Row is checked
    rowIsCheck('.rowToCheck', '#idDeleteRow');
    //Register search submit
    registerSearchSubmit();
    //Register Preview Row
    registerPreviewRow();

    //Register view image
    registerViewImage();

    //Close notification
    $('#closeNotification').click(function () {
        hideNotificationBar();
    });
    if ($notification.length) {
        registerNotificationAnimation();
    }//E# if statement

    bootbox.setDefaults({
        /**
         * @optional String
         * @default: en
         * which locale settings to use to translate the three
         * standard button labels: OK, CONFIRM, CANCEL
         */
        locale: inlineJs.lang.current,
        /**
         * @optional Boolean
         * @default: true
         * whether the dialog should be shown immediately
         */
        show: true,
        /**
         * @optional Boolean
         * @default: true
         * whether the dialog should be have a backdrop or not
         */
        backdrop: true,
        /**
         * @optional Boolean
         * @default: true
         * show a close button
         */
        closeButton: true,
        /**
         * @optional Boolean
         * @default: true
         * animate the dialog in and out (not supported in < IE 10)
         */
        animate: true,
        /**
         * @optional String
         * @default: null
         * an additional class to apply to the dialog wrapper
         */
        className: "my-modal"

    });

    if (inlineJs.page === 'merchantsMerchantPostPage') {//Merchants Merchant Post Page
        if (inlineJs.crudId == 1) {
            $('#idCurrencyId option[value="76"]').prop('selected', true);
            $('#idCountryId option[value="GB"]').prop('selected', true);
            $('#idTimezoneId option[value="2"]').prop('selected', true);
            $('#idDateFormat option[value="dd/mm/yyyy"]').prop('selected', true);
        }//E# if else statement

    } else if (inlineJs.page === 'merchantsLocationPostPage') {//Merchants Location Post Page
        if (inlineJs.crudId == 1) {
            $('#idCurrencyId option[value="76"]').prop('selected', true);
            $('#idCountryId option[value="GB"]').prop('selected', true);
            $('#idTimezoneId option[value="2"]').prop('selected', true);
            $('#idDateFormat option[value="dd/mm/yyyy"]').prop('selected', true);
        }//E# if else statement

        $('#idPostalCode').blur(function () {
            console.log('asf');

            zoomTo($(this).val(), 15);
        });
    }//E# if else statement
});