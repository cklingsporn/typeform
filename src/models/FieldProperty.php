<?php

namespace WATR\Models;

use WATR\Models\Choice;
use WATR\Models\Field;
use Symfony\Component\VarDumper\VarDumper;

/**
 * FieldProperty Model
 */
class FieldProperty
{
    /**
     * @var boolean randomize
     */
    public $randomize;
    
    /**
     * @var boolean multiple selection
     */
    public $allow_multiple_selection;
    
    /**
     * @var boolean alphabetical_order
     */
    public $alphabetical_order;

    /**
     * @var boolean other choice
     */
    public $allow_other_choice;

    /**
     * @var boolean vertical alignment
     */
    public $vertical_alignment;

    /**
     * @var int steps
     */
    public $steps;

    /**
     * @var boolean start interval
     */
    public $start_at_one;

    /**
     * @var Choice[]
     */
    public $choices = [];

    /**
     * @var Field[]
     */
    public $fields = [];
    
    /**
     * @var string
     */
    public $description = '';
    
    /**
     * @var string[]
     */
    public $activeVariables = [];

    
    public function toArray()
    {
        $output = [];
        /*
         * Grab a list of vars from activeVariables (set by Field class)
         * Put them into the output
         * If its an object with toArray then we will use that
         * if its an array of things then we will go look at those
         */
        foreach ($this->getActiveVariables() as $activeVariable) {
            if (is_string($this->$activeVariable) ) {
                $output[$activeVariable] = $this->$activeVariable;
            } elseif (method_exists($this->$activeVariable, 'toArray')) {
                $output[$activeVariable] =  $this->$activeVariable->toArray();
            } elseif (is_array($this->$activeVariable)) {
                foreach ($this->$activeVariable as $activeVariableElement) {
                    if (is_string($activeVariableElement)) {
                        $output[$activeVariable][] = $activeVariableElement;
                    } elseif (method_exists($activeVariableElement, 'toArray')) {
                        $output[$activeVariable][] = $activeVariableElement->toArray();
                    } else {
                        $output[$activeVariable][] = $this->$activeVariable;
                    }
                }
            }
        }
        
        
        //$output['randomize'] = $this->randomize;
        //$output['allow_multiple_selection'] = $this->allow_multiple_selection;
        //$output['allow_other_choice'] = $this->allow_other_choice;
        //$output['vertical_alignment'] = $this->vertical_alignment;
        //$output['steps'] = $this->steps;
        //$output['start_at_one'] = $this->start_at_one;
        //$output['choices'] = $this->choices;
        //$output['fields'] = $this->fields;
//         $output['description'] = $this->description;
        
        return $output;
    }
    
    /**
     * constructor
     */
    public function __construct($object = null, bool $group = false)
    {
        if ($object == null) {
            return;
        }
        
        if(isset($object->randomize))
        {
            $this->randomize = $object->randomize;
        }
        if(isset($object->allow_multiple_selection))
        {
            $this->allow_multiple_selection = $object->allow_multiple_selection;
        }
        if(isset($object->allow_other_choice))
        {
            $this->allow_other_choice = $object->allow_other_choice;
        }
        if(isset($object->vertical_alignment))
        {
            $this->vertical_alignment = $object->vertical_alignment;
        }
        if(isset($object->steps))
        {
            $this->steps = $object->steps;
        }
        if(isset($object->start_at_one))
        {
            $this->start_at_one = $object->start_at_one;
        }

        if(isset($object->choices))
        {
            foreach($object->choices as $choice)
            {
                array_push($this->choices, new Choice($choice));
            }
        }

        if(isset($object->fields) && $group)
        {
            foreach($object->fields as $field)
            {
                array_push($this->fields, new Field($field));
            }
        }
    }
    
    public function setActivePropertyFields($type)
    {
        $activeFields  = [];
        
        switch ($type) {
            case "multiple_choice":
                $activeFields =  ['description','randomize', 'allow_multiple_selection','allow_other_choice','vertical_alignment','choices'];
                break;
            case 'dropdown':
                $activeFields =  ['alphabetical_order', 'choices','description'];
                break;
            case 'short_text':
            case 'long_text':
                $activeFields =  ['description'];
                break;
        }
        
        $this->setActiveVariables($activeFields);
    }
    /**
     * @return boolean
     */
    public function isRandomize()
    {
        return $this->randomize;
    }

    /**
     * @param boolean $randomize
     */
    public function setRandomize($randomize)
    {
        $this->randomize = $randomize;
    }

    /**
     * @return boolean
     */
    public function isAllow_multiple_selection()
    {
        return $this->allow_multiple_selection;
    }

    /**
     * @param boolean $allow_multiple_selection
     */
    public function setAllow_multiple_selection($allow_multiple_selection)
    {
        $this->allow_multiple_selection = $allow_multiple_selection;
    }

    /**
     * @return boolean
     */
    public function isAllow_other_choice()
    {
        return $this->allow_other_choice;
    }

    /**
     * @param boolean $allow_other_choice
     */
    public function setAllow_other_choice($allow_other_choice)
    {
        $this->allow_other_choice = $allow_other_choice;
    }

    /**
     * @return boolean
     */
    public function isVertical_alignment()
    {
        return $this->vertical_alignment;
    }

    /**
     * @param boolean $vertical_alignment
     */
    public function setVertical_alignment($vertical_alignment)
    {
        $this->vertical_alignment = $vertical_alignment;
    }

    /**
     * @return number
     */
    public function getSteps()
    {
        return $this->steps;
    }

    /**
     * @param number $steps
     */
    public function setSteps($steps)
    {
        $this->steps = $steps;
    }

    /**
     * @return boolean
     */
    public function isStart_at_one()
    {
        return $this->start_at_one;
    }

    /**
     * @param boolean $start_at_one
     */
    public function setStart_at_one($start_at_one)
    {
        $this->start_at_one = $start_at_one;
    }

    /**
     * @return multitype:\WATR\Models\Choice 
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * @param multitype:\WATR\Models\Choice  $choices
     */
    public function setChoices($choices)
    {
        $this->choices = $choices;
    }

    /**
     * @return multitype:\WATR\Models\Field 
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param multitype:\WATR\Models\Field  $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return multitype:string 
     */
    public function getActiveVariables()
    {
        return $this->activeVariables;
    }

    /**
     * @param multitype:string  $activeVariables
     */
    public function setActiveVariables($activeVariables)
    {
        $this->activeVariables = $activeVariables;
    }
    /**
     * @return boolean
     */
    public function isAlphabetical_order()
    {
        return $this->alphabetical_order;
    }

    /**
     * @param boolean $alphabetical_order
     */
    public function setAlphabetical_order($alphabetical_order)
    {
        $this->alphabetical_order = $alphabetical_order;
    }


    
}
