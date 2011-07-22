<?php

/**
 * Missatgesmailing form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class MissatgesmailingForm extends BaseMissatgesmailingForm
{
	
  public function setup()
  {
            
    $this->setWidgets(array(
      'idMissatge' => new sfWidgetFormInputHidden(),
      'titol'      => new sfWidgetFormInputText(array(),array('style'=>'width:400px;')),
      'text'       => new sfWidgetFormTextareaTinyMCE(array(),array()),        
      'data_alta'  => new sfWidgetFormInputHidden(),
    ));
    
    $this->setValidators(array(
      'idMissatge' => new sfValidatorPropelChoice(array('model' => 'Missatgesmailing', 'column' => 'idMissatge', 'required' => false)),
      'titol'      => new sfValidatorString(),
      'text'       => new sfValidatorString(),
      'data_alta'  => new sfValidatorDate(),
    ));
        
    $this->widgetSchema->setNameFormat('missatgesmailing[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);    
    
  }

  public function getModelName()
  {
    return 'Missatgesmailing';
  }
	
}
