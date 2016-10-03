/**
 * Document   : nakuru.js
 * Product      : ERP  
 * Created on : Jan 21, 2013, 11:48:05 AM
 * Author     : Edwin Mugendi
 * Description: JS for Nakuru theme of Backend bundle
 */

//Define map variables
var $infoWindow, $map, $marker, $geocoder, $latLng = null;

var $deletedRows = [];

/**
 * S# importOnViewChange() function
 * 
 * Action to take when view changes
 * 
 * @param {Object} $that that button
 * @param {array} $data Data
 * 
 * */
function importOnViewChange($that, $data) {
    $('#idImportContainer').html($data.view);

    //Remove indicators
    $('#idStep1Indicator,#idStep2Indicator,#idStep3Indicator').removeClass('complete disabled active');

    //Get current step
    var $currentStep = $('#idStepView').data('step');

    if (parseInt($currentStep) === 1) {//Step 1
        //Show hide buttons
        $('#idCancelButton').show();
        $('#idBackButton').hide();
        //Set step
        $('#idNextButton').data('step', 2);
        $('#idBackButton').data('step', 1);
        //Indicate
        $('#idStep1Indicator').addClass('active');
        $('#idStep2Indicator,#idStep3Indicator').addClass('disabled');
    } else if (parseInt($currentStep) === 2) {//Step 2
        //Show hide buttons
        $('#idBackButton').show();
        $('#idCancelButton').hide();

        //Set step
        $('#idNextButton').data('step', 3);
        $('#idBackButton').data('step', 1);

        //Indicate
        $('#idStep1Indicator').addClass('complete');
        $('#idStep2Indicator').addClass('active');
        $('#idStep3Indicator').addClass('disabled');

        //Change back text
        $('#idNextButton').text($('#idNextButton').data('next'));

    } else if (parseInt($currentStep) === 3) {//Step 3
        $that.text($('#idNextButton').data('import'));
        $('#idCancelButton').hide();

        //Set step
        $('#idNextButton').data('step', 3);
        $('#idBackButton').data('step', 2);

        //Indicate
        $('#idStep1Indicator,#idStep2Indicator,#idStep3Indicator').addClass('complete');
    }//E# if else statement
}//E# importOnViewChange() function

/**
 * S# importFunction
 * 
 * Import function
 * 
 * */
function importFunction() {
    //Select all recotds
    $('#idImportModal').on('click', '#idImportSelectAll', function () {
        $('.classImportSingleSelect').prop('checked', $(this).is(':checked'));
    });

    //When the radio button is seletect in step 3
    $('#idImportModal').on('change', '.classImportSingleSelect', function () {
        var $checked = true;
        $('.classImportSingleSelect').each(function () {
            if ($(this).is(':checked') === false) {
                $checked = false;
                return false;
            }//E# foreach statement
        });
        $('#idImportSelectAll').prop('checked', $checked);
    });

    //Show import modal
    $('#idImportButton').click(function () {
        var $modal = $('#idImportModal');
        $modal.modal('show');
    });

    //Delete an import row in step 3
    $('#idImportModal').on('click', '.classImportDeleteRow', function () {
        var $idToDelete = $(this).data('id');

        //Hide this row
        $('table#idTableRowsToImport').find('.classImportRow').each(function () {
            var $thisRow = $(this);
            var $rowId = $thisRow.data('id');
            if ($rowId == $idToDelete) {
                //Hide row
                $thisRow.slideUp('slow').remove();
            }//E# if statement
        });
        tableRowChanged('#idTableRowsToImport', '.classImportRowNumber');
    });

    //Buttons action
    $('#idImportModal').on('click', '#idNextButton,#idBackButton,#idImportValidOnesButton', function () {
        var $that = $(this);
        var $buttonStep = parseInt($that.data('step'));
        var $viewStep = parseInt($('#idStepView').data('step'));

        var $ajaxData = getImportData($buttonStep, $viewStep);

        if ((parseInt($ajaxData.view_step) === 1) && ($that.attr('id') === 'idNextButton') && !$('#idImportFile').val()) {
            $('#idImportError').html($('#idImportError').data('select-file'));
            return false;
        }//E# if statement

        //Remove error message
        $('#idImportError').empty();

        if ($that.attr('id') === 'idBackButton') {
            $('#idImportValidOnesButton').hide();
        }//E# if statement

        if ((parseInt($ajaxData.view_step) === 3) && (($that.attr('id') === 'idNextButton') || ($that.attr('id') === 'idImportValidOnesButton'))) {
            var $importData = {};
            var $checkedData = {};
            $('.classImportFields').each(function () {
                var $that = $(this);
                var $field = $that.val();
                $importData[$field] = $("[name='" + $field + "\\[\\]']")
                        .map(function () {
                            return $(this).val();
                        }).get();
            });

            $('.classImportSingleSelect').each(function ($index, $row) {
                $checkedData[$index] = $(this).is(':checked') ? 1 : 0;
            });

            $(this).is(':checked')
            var $ajaxOptions = new AjaxOptions('/import/import');
            $ajaxOptions.type = 'POST';
            $ajaxOptions.dataType = 'JSON';
            $ajaxOptions.data = {
                clean_data_to_be_imported: $importData, //Long fields name to prevent field name conflict
                rows_that_are_checked: $checkedData,
                force_import_valid_records: $that.attr('id') === 'idImportValidOnesButton' ? 1 : 0
            };
            $ajaxOptions.done = function ($data) {

                if ($data.type === 'success') {
                    showNotificationBar($data);
                    $('#idImportModal').modal('hide');
                } else if ($data.type === 'error') {
                    $('#idImportError').html($data.message);

                    $('#idImportValidOnesButton').show();

                }
            }//E# done function

            ajaxify($ajaxOptions);

        } else {
            var $ajaxOptions = new AjaxOptions('/import/get_step');
            $ajaxOptions.type = 'GET';
            $ajaxOptions.dataType = 'JSON';
            $ajaxOptions.data = $ajaxData;
            $ajaxOptions.done = function ($data) {
                importOnViewChange($that, $data)
            }//E# done function

            ajaxify($ajaxOptions);
        }//E# if else statement
    });

    //Upload file
    $('#idImportFile').change(function () {
        //Remove error message
        $('#idImportError').empty();

        var $data = new FormData();

        $data.append('file', $('#idImportFile')[0].files[0]);
        $data.append('import_controller', $('#idImportController').val());
        $data.append('import_package', $('#idImportPackage').val());

        console.log(inlineJs.baseUrl);
        $.ajax({
            type: 'POST',
            url: inlineJs.baseUrl + '/import/uploading',
            enctype: 'multipart/form-data',
            data: $data,
            success: function ($data) {
                if ($data.type === 'error') {
                    $('#idImportError').html($data.message)
                }//E# if else statement
            },
            cache: false,
            processData: false,
            contentType: false,
            always: function ($idUploadDataButton) {

            }
        });
    });
}//E# importFunction() function

/**
 * S# getImportData() function
 * 
 * Get import data
 * 
 * @param {str} $buttonStep Button Step
 * @param {str} $viewStep View step
 * 
 * 
 **/
function getImportData($buttonStep, $viewStep) {
    if ($buttonStep === 1) {//Upload
        return {
            button_step: $buttonStep,
            view_step: $viewStep
        }
    } else if ($buttonStep === 2) {//Map
        return {
            button_step: $buttonStep,
            view_step: $viewStep
        }
    } else if ($buttonStep === 3) {//Import
        var $systemYourFieldMap = {};
        $('tr.singleImportRow').each(function () {
            var $that = $(this);
            var $systemField = $that.find('td').first().data('system-field');
            $systemYourFieldMap[$systemField] = $that.find('select').val();
        });
        return {
            button_step: $buttonStep,
            view_step: $viewStep,
            fields_mapping: $systemYourFieldMap
        }
    }//E# if else statement
}//E# getImportData

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
            $address = 'UK';
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
    $('input#idLat').val($center.lat());
    $('input#idLng').val($center.lng());

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



/**
 * S# showNotifyBar() function
 * 
 * Show notify bar
 *@param {str} $message Message
 *@param {str} $type Type
 *
 **/
function showNotifyBar($message, $type) {
    $.notify({
        message: $message,
    }, {
        mouse_over: 'pause',
        type: $type,
        placement: {
            align: 'center'
        },
    });
}//E# showNotifyBar() function

function showNotificationBar($notificationData) {

    if ($notificationData.type == 'success') {
        showNotifyBar($notificationData.message, 'success');
    } else if ($notificationData.type == 'info') {
        showNotifyBar($notificationData.message, 'info');
    } else {
        showNotifyBar($notificationData.message, 'danger');
    }//E# if else statement
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
                                var $thisRow = $that.parents('tr')

                                $thisRow.slideUp('slow');

                                //Reset arrow
                                $thisRow.find('.previewLink').find('i').removeClass().addClass('icon-data-arrow-right');

                                //Hide hidden row
                                $('#hiddenRow-' + $jsonData[0].id).removeClass('previewShown').slideUp('slow');

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
    $('body').on('click', 'a#idUndoDelete', function ($event) {

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

            var $message;
            var $count = 0;
            $.each($jsonData, function (index, $response) {
                if (parseInt($response.code) === 200) {
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
function tableRowChanged($tableId, $rowClass) {
    $($tableId)
            .find($rowClass)
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

/**
 *S# loadSummaryData
 *
 * @param $startDate str start date
 * @param $endDate str end date
 **/

function loadGraphData($startDate, $endDate) {
    $('.spin').addClass('fa-spin');
    $.ajax({
        url: inlineJs.baseUrl + '/dashboard/get_graph',
        type: "GET",
        data: {
            start_date: $startDate,
            end_date: $endDate,
        },
        success: function ($data) {
            $('#idTransactionCount').html($data.transaction_count);
            $('#idTransactionTotal').html($data.transaction_total);
            $('#idNewCustomers').html($data.new_customers);
            $('#idTopCustomers').html($data.top_customers);

            drawGraph($data);
        }, complete: function ($data) {
            $('.spin').removeClass('fa-spin');
        },
        dataType: 'json'
    });
}//E# loadGraphData() function


function drawGraph($data) {
    console.log($data.graph_data);
    //define chart clolors ( you maybe add more colors if you want or flot will add it automatic )
    var chartColours = ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'];
    /*
     //generate random number for charts
     randNum = function () {
     return (Math.floor(Math.random() * (1 + 40 - 20))) + 20;
     }
     
     var d1 = [];
     //var d2 = [];
     
     //here we generate data for chart
     for (var i = 0; i < 30; i++) {
     d1.push([new Date(Date.today().add(i).days()).getTime(), randNum() + i + i + 10]);
     //    d2.push([new Date(Date.today().add(i).days()).getTime(), randNum()]);
     }
     console.log(d1);
     var chartMinDate = d1[0][0]; //first day
     var chartMaxDate = d1[20][0]; //last day
     */
    var tickSize = [1, "day"];
    var tformat = "%d/%m/%y";

    //graph options
    var options = {
        grid: {
            show: true,
            aboveData: true,
            color: "#3f3f3f",
            labelMargin: 10,
            axisMargin: 0,
            borderWidth: 0,
            borderColor: null,
            minBorderMargin: 5,
            clickable: true,
            hoverable: true,
            autoHighlight: true,
            mouseActiveRadius: 100
        },
        series: {
            lines: {
                show: true,
                fill: true,
                lineWidth: 2,
                steps: false
            },
            points: {
                show: true,
                radius: 4.5,
                symbol: "circle",
                lineWidth: 3.0
            }
        },
        legend: {
            position: "ne",
            margin: [0, 10],
            noColumns: 0,
            labelBoxBorderColor: null,
            labelFormatter: function (label, series) {
                // just add some space to labes
                return label + '&nbsp;&nbsp;';
            },
            width: 40,
            height: 1
        },
        colors: chartColours,
        shadowSize: 0,
        tooltip: true, //activate tooltip
        tooltipOpts: {
            content: "%s: %y.0",
            xDateFormat: "%d/%m",
            shifts: {
                x: -30,
                y: -50
            },
            defaultTheme: false
        },
        yaxis: {
            min: 0
        },
        xaxis: {
            mode: "time",
            minTickSize: tickSize,
            timeformat: tformat,
            min: $data.graph_min_date,
            max: $data.graph_max_date
        }
    };
    console.log($data.graph_min_date);
    console.log($data.graph_max_date);
    var plot = $.plot($("#placeholder33x"), [{
            label: "Revenue",
            data: $data.graph_data,
            lines: {
                fillColor: "rgba(150, 202, 89, 0.12)"
            }, //#96CA59 rgba(150, 202, 89, 0.42)
            points: {
                fillColor: "#fff"
            }
        }], options);

}
jQuery(document).ready(function ($) {
    importFunction();

    /*Initialize tooltip*/
    $('[data-toggle=tooltip]').tooltip({container: 'body'});

    /*Load Maps*/
    if (inlineJs.mappable && (parseInt(inlineJs.crudId) === 1 || parseInt(inlineJs.crudId) === 2)) {
        //Call injectGMaps on window load
        window.onload = injectGMaps;
    }//E# if statement

    /*
     //Stick footer to the bottom
     var docHeight = $(window).height();
     var footerHeight = $('#footer').outerHeight();
     var footerTop = $('#footer').position().top + footerHeight;
     
     if (footerTop < docHeight) {
     $('#footer').css('margin-top', (docHeight - footerTop) + 'px');
     }
     */
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

    if (inlineJs.page === 'surveysFormQuestionPage') {//Surveys Form Question Page
        var $idOptionModal = $('#idOptionModal');

        $('#idOptionModal').on('click', '#idOptionSave', function ($event) {
            var $titles = [];
            var $optionIds = [];
            $('.classOptionTitles').each(function () {
                $titles.push($(this).val());
            });

            $('.classOptionIds').each(function () {
                $optionIds.push($(this).val());
            });

            console.log($titles);

            var $ajaxOptions = new AjaxOptions('/surveys/save_option/question');
            $ajaxOptions.type = 'POST';
            $ajaxOptions.dataType = 'JSON';
            $ajaxOptions.data = {
                question_id: $('#idOptionQuestionId').val(),
                form_id: $('#idOptionFormId').val(),
                titles: $titles,
                option_ids: $optionIds
            };
            $ajaxOptions.done = function ($data) {
                $idOptionModal.modal('hide');
                showNotificationBar($data);
            }//E# done function

            ajaxify($ajaxOptions);
        });



        //Show add option modal
        $('.classAddOptions').click(function () {
            var $idQuestionId = $(this).data('question-id');
            $idOptionModal.modal('show');
            $idOptionModal.find('#idOptionQuestionId').val($idQuestionId);

            var $ajaxOptions = new AjaxOptions('/surveys/option/question');
            $ajaxOptions.type = 'GET';
            $ajaxOptions.dataType = 'JSON';
            $ajaxOptions.data = {
                question_id: $idQuestionId,
            };
            $ajaxOptions.done = function ($data) {
                $('#idOptionContainer').html($data.message);
            }//E# done function

            ajaxify($ajaxOptions);
        });

        //Add  row
        $('#idOptionModal').on('click', '#idAddOption', function ($event) {
            //Find first row
            var $clone = $('#idOptionHiddenTable').find('tr').first().clone();

            //Clear text
            //Inject it
            $('#tableOption').find('tbody').append($clone);
            //Table changed event
            tableRowChanged('#tableOption', '.optionNumber');
            //Prevent default
            $event.preventDefault();
        });

        //Delete row
        $('#idOptionModal').on('click', '.deleteOption', function ($event) {
            //Find row
            var $tr = $(this).closest('tr.rowOption');

            //Fade out and remove
            $tr.fadeOut(400, function () {
                //Remove tr
                $tr.remove();
                //Table changed event
                tableRowChanged('#tableOption', '.optionNumber');
            });
            //Prevent default
            $event.preventDefault();
        });

        //Add  row
        $('#questionView').on('click', '#idAddQuestion', function ($event) {
            //Find first row
            var $clone = $('#idHiddenTable').find('tr').first().clone();
            //Clear text
            //Inject it
            $('#tableQuestion').find('tbody').append($clone);
            //Table changed event
            tableRowChanged('#tableQuestion', '.questionNumber');
            //Prevent default
            $event.preventDefault();
        });

        //Delete row
        $('#tableQuestion').on('click', '.deleteQuestion', function ($event) {
            //Find row
            var $tr = $(this).closest('tr.rowQuestion');

            //Fade out and remove
            $tr.fadeOut(400, function () {
                //Remove tr
                $tr.remove();
                //Table changed event
                tableRowChanged('#tableQuestion', '.questionNumber');
            });
            //Prevent default
            $event.preventDefault();
        });

        //Validate form
        validateForm('form#idFormQuestionId');

    } else if (inlineJs.page === 'accountsDashboardDashboardPage') {//Accounts Dashboard Dashboard Page
        //Date range picker
        $('#daterange').daterangepicker({
            "opens": "left",
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(6, 'days'),
            endDate: moment()
        },
        function (start, end) {
            $('#daterange .text-date').text(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
        });

        //Register date range apply event
        $('#daterange').on('apply.daterangepicker', function (ev, picker) {
            var $startDate = picker.startDate.format('YYYY-MM-DD');
            var $endDate = picker.endDate.format('YYYY-MM-DD');

            //Load Graph Data
            loadGraphData($startDate, $endDate);
        });

        //Load Graph Data
        loadGraphData(inlineJs.start_date, inlineJs.end_date);

    } else if (inlineJs.page === 'accountsUserRegistrationPage') {//Accounts User Registration Page
        $('#idForgotPasswordAgain').click(function ($event) {
            location.reload(true);
            return false
            console.log($(this).data('link'));
            window.location.href = $(this).data('link');
            //    $event.preventDefault();
        });
    }//E# if else statement
});