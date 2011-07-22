<?php

/**
 * Options form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 */
class OptionsForm extends BaseOptionsForm
{

  public function setup()
  {
    
    $IDS = $this->getOption('IDS');
    $OPTIONS = OptionsPeer::getOptionsArray($IDS,true);
    
    if($this->getOption('NEW')) $this->setWidget('option_id',new sfWidgetFormInput(array(),array('style'=>'width:400px;')));
    else $this->setWidget('option_id',new sfWidgetFormChoice( array('choices'=>$OPTIONS) , array() ));
    $this->setWidget('site_id',new sfWidgetFormInputHidden());    
    $this->setWidget('valor', new sfWidgetFormTextarea(array(),array('style'=>'width:500px; height:200px;')));
    
    $this->setValidators(array(
      'option_id' => new sfValidatorString(array('required' => true)),
      'site_id'   => new sfValidatorInteger(array('max'=>$IDS,'min'=>$IDS,'required' => true)),
      'valor'     => new sfValidatorString(),
    ));

    $this->widgetSchema->setLabels(array('option_id'=>"Nom ",'valor'=>'Valor '));

    $this->widgetSchema->setNameFormat('options[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);    
        
  }

  public function getModelName()
  {
    return 'Options';
  }

}
