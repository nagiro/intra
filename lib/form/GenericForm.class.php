<?php

/**
 * Activitats form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class GenericForm extends BaseForm
{
 
  public function setup(){

  }
  
  public function setConstruct($NameFormat = "", $widgets = array(), $validators = array(), $labels = array())
  {
  	  	   
  	 $this->setWidgets($widgets);
  	 $this->setValidators($validators);
  	 $this->widgetSchema->setLabels($labels);
  	
  	 $this->widgetSchema->setNameFormat($NameFormat.'[%s]');
  	 $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  	   	 
  }  

}
