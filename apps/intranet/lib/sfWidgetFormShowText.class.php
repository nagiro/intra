<?php

/**
 * sfWidgetFormShowText represents a show only text.
 *
 * @package    symfony
 * @subpackage widget
 * @author     Albert Johé <albert.johe@gmail.com> 
 */
class sfWidgetFormShowText extends sfWidgetForm
{

  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    $this->addOption('text');
    $this->addOption('type');
        
  }


  /**
   * @param  string $name        The element name
   * @param  string $value       The value selected in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $VAL = '----';
    
    if($this->getOption('type') == 'date') $VAL = $value;
    else $VAL = $value;
    
    if(empty($value)) return '----';
    else return $VAL;    
  }

}
