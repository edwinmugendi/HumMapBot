<?php

use Bootstrapper\Form;
use Illuminate\Html\HtmlBuilder as Html;

class FormLibrary extends Form {

    /**
     * Get the ID attribute for a field name.
     *
     * @param  string  $name
     * @param  array   $attributes
     * @return string
     */
    protected function getIdAttributeCompositeSelect($name, $attributes) {
        if (array_key_exists('id', $attributes)) {
            return $attributes['id'];
        }
    }

//E# getIdAttributeCompositeSelect() function

    /**
     * Get the select option for the given value.
     *
     * @param  string  $display
     * @param  string  $value
     * @param  string  $selected
     * @return string
     */
    protected function getSelectOptionCompositeSelect($options, $value, $selected) {
        //if (is_array($options)){
        //	return $this->optionGroupCompositeSelect($options, $value, $selected);
        //}

        return $this->optionCompositeSelect($options, $value, $selected);
    }

    /**
     * Create an option group form element.
     *
     * @param  array   $list
     * @param  string  $label
     * @param  string  $selected
     * @return string
     */
    protected function optionGroupCompositeSelect($list, $label, $selected) {
        $html = array();

        foreach ($list as $value => $display) {
            $html[] = $this->optionCompositeSelect($display, $value, $selected);
        }

        return '<optgroup label="' . e($label) . '">' . implode('', $html) . '</optgroup>';
    }

    /**
     * Create a select element option.
     *
     * @param  mixed  $options array or string
     * @param  string  $value
     * @param  string  $selected
     * @return string
     */
    protected function optionCompositeSelect($options, $value, $selected) {

        $selected = $this->getSelectedValueCompositeSelect($value, $selected);
       
        if (is_array($options)) {//Array options
            if (isset($options['id'])) {//Id option exist
                $options['value'] = $options['id'];
                unset($options['id']);
            } else {//Id option does not exist
                $options['value'] = e($value);
            }//E# if else statement

            $options['selected'] = $selected;
            $display = $options['text'];
            $actualOptions = $options;
        } else {//Non array options
            $actualOptions = array('value' => e($value), 'selected' => $selected);
            $display = $options;
        }//E# if else statement

        $html = new Html();
        return '<option' . $html->attributes($actualOptions) . '>' . e($display) . '</option>';
    }

//E# optionCompositeSelect() function

    /**
     * Determine if the value is selected.
     *
     * @param  string  $value
     * @param  string  $selected
     * @return string
     */
    protected function getSelectedValueCompositeSelect($value, $selected) {
        if (is_array($selected)) {
          
            return in_array($value, $selected) ? 'selected' : null;
        }
        return ((string) $value == (string) $selected) ? 'selected' : null;
    }

//E# getSelectedValueCompositeSelect() function

    /**
     * Create a select box field.
     *
     * @param  string  $name
     * @param  array   $list
     * @param  string  $selected
     * @param  array   $options
     * @return string
     */
    public function compositeSelect($name, $optionsList = array(), $selected = null, $options = array()) {

        // When building a select box the "value" attribute is really the selected one
        // so we will use that when checking the model or session for a value which
        // should provide a convenient method of re-populating the forms on post.
        $selected = $this->getValueAttribute($name, $selected);

        $options['id'] = $this->getIdAttributeCompositeSelect($name, $options);

        $options['name'] = $name;

        // We will simply loop through the options and build an HTML value for each of
        // them until we have an array of HTML declarations. Then we will join them
        // all together into one single HTML element that can be put on the form.
        $html = array();
        //   dd($optionsList);
        foreach ($optionsList as $value => $singleOption) {//Loop through the options lists
            // var_dump($value);
            //dd($singleOption);
            if (is_array($singleOption) && array_key_exists('id', $singleOption)) {
                    $html[] = $this->getSelectOptionCompositeSelect($singleOption, $singleOption['id'], $selected);
                   
            } else {
                 
                $html[] = $this->getSelectOptionCompositeSelect($singleOption, $value, $selected);
            }//E# if else statement
        }//E# foreach statement
        // Once we have all of this HTML, we can join this into a single element after
        // formatting the attributes into an HTML "attributes" string, then we will
        // build out a final select statement, which will contain all the values.
        $htmlBuilder = new Html();

        $options = $htmlBuilder->attributes($options);

        $list = implode('', $html);

        return "<select{$options}>{$list}</select>";
    }//E# compositeSelect() function
}

//E# FormLibrary() class