<?php

namespace App\Lib;

/**
 * @author Faisal
 * @copyright
 */
class FmForm
{
    public $title = "";
    public $fields = array();
    public $elements = array();
    protected static $formWrap = true;
    public static $formName = 'form';
    public static $form = "";
    protected static $fieldsetElements = "";
    public $from = [];

    public function __construct($name = "", $action = "", $method = "post", $attr = array(), $multipart = false)
    {
        $this->from['name'] = $name;
        $this->from['action'] = $action;
        $this->from['method'] = $method;
        $this->from['attr'] = $attr;
        $this->from['multipart'] = $multipart;
    }

    public function title($title)
    {
        $this->from['title'] = $title;
    }

    public function setter($data)
    {
        $this->from['data'] = $data;
    }

    public function saveText($text)
    {
        $this->from['btn-text'] = $text;
    }

    public function jsValidation($mode = false)
    {
        $this->from['enabled'] = $mode;
    }

    public function getForm($print = false)
    {
        $fields = array();
        $fields = $this->fields;
        return view('admin.form')->with(['from' => $this->from])->with(compact('fields'));
    }

    /*
     *     "tooltip" => ['text', class] OR  "tooltip" =false, OR "tooltip" = Write tooltip text,
     *     "col" = "6" 1 to 12,
     *     "attr" = array of custom attributes
     * */
    public function add($element, $overRideElement = [])
    {
        $element = array_merge($element, $overRideElement);
        if (!empty($element)) {
            $element['label'] = isset($element['label']) ? $element['label'] : '';
            /* Tool Tip Settings */
            if (!array_key_exists('tooltip', $element)) {
                $element['tooltip_message'] = 'Please enter ' . strtolower($element['label'] . ".");
                $element['tooltip_class'] = 'tooltip-top-right';
                $element['tooltip'] = true;
            } else {
                if (is_array($element['tooltip'])) {
                    $element['tooltip_message'] = isset($element['tooltip'][0]) ? $element['tooltip'][0] : '';
                    $element['tooltip_class'] = isset($element['tooltip'][1]) ? $element['tooltip'][1] : 'tooltip-top-right';
                } else {
                    if (!isset($element['tooltip']) || $element['tooltip'] == false) {
                        $element['tooltip'] = false;
                    } else {
                        $element['tooltip_message'] = isset($element['tooltip']) && !empty($element['tooltip']) ? $element['tooltip'] : 'Please enter ' . strtolower($element['label'] . ".");
                        $element['tooltip_class'] = 'tooltip-top-right';
                    }
                }
            }

            /* Custom Attributes */
            if (!isset($element['attr']) || empty($element['attr'])) {
                $element['attr'] = array();
            }

            /* */
            if ($element['type'] != 'html') {
                $element['attr'] = array_merge($element['attr'],
                    ['placeholder' => $element['label'], 'id' => $element['name'], 'autocomplete' => 'off']);
            }

            //$element['attr'] = array_merge($element['attr'], ['placeholder' => $element['label'], 'id' => $element['name']]);
            array_push($this->fields, $element);
        }

        return $this;
    }
}
