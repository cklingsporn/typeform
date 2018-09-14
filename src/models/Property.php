<?php

namespace WATR\Models;

/**
 * Property model
 */
class Property
{
    /**
     * @var boolean share icons
     */
    public $share_icons;

    /**
     * @var boolean show button
     */
    public $show_button;

    /**
     * @var string button text
     */
    public $button_text;

    /**
     * constructor
     */
    public function __construct($object = null)
    {
        if ($object == null) {
            return;
        }
        
        $this->share_icons = isset($object->share_icons) ? $object->share_icons: null;
        $this->show_button = $object->show_button;
        $this->button_text = isset($object->button_text) ? $object->button_text : null;
    }
    
    public function toArray()
    {
        $output = [];
        $output['share_icons'] = $this->share_icons;
        $output['show_button'] = $this->show_button;
        $output['button_text'] = $this->button_text;
        
        return $output;
    }
}
