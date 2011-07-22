<?php

class sfWidgetFormSelectManyMy extends sfWidgetFormSelectCheckbox
{

  protected function configure($options = array(), $attributes = array())
  {
  	parent::configure($options, $attributes);  
  }

  protected function formatChoices($name, $value, $choices, $attributes)
  {
    $inputs = array();
    
    if(!is_array($value) && !empty($value)) $value = explode('@',$value);
    elseif(is_array($value)) $value = $value;
    else $value = array();
    
    foreach ($choices as $key => $option)
    {
      $baseAttributes = array(
        'name'  => $name,
        'type'  => 'checkbox',
        'value' => self::escapeOnce($key),
        'id'    => $id = $this->generateId($name, self::escapeOnce($key)),
      );
            
      if ((is_array($value) && in_array($key, $value)) || $key == $value)
      {
        $baseAttributes['checked'] = 'checked';
      }

      $inputs[] = array(
        'input' => $this->renderTag('input', array_merge($baseAttributes, $attributes)),
        'label' => $this->renderContentTag('label', $option, array('for' => $id)),
      );
    }

    return call_user_func($this->getOption('formatter'), $this, $inputs);
  }
  
}
