<?php

/**
 * Llistes form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class LlistesForm extends sfFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idLlistes' => new sfWidgetFormInputHidden(),
      'Nom'       => new sfWidgetFormInputText(array(),array('style'=>'width:400px')),
      'isActiva'  => new sfWidgetFormChoice(array('choices'=>array(true=>'SÃ­',false=>'No'))),
    ));

    $this->setValidators(array(
      'idLlistes' => new sfValidatorPropelChoice(array('model' => 'Llistes', 'column' => 'idLlistes', 'required' => false)),
      'Nom'       => new sfValidatorString(),
      'isActiva'  => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('llistes[%s]');

    $this->widgetSchema->setLabels(array(      
      'Nom'       => 'Nom: ',
      'isActiva'  => 'EstÃ  activa? ',       
    ));
    
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Llistes';
  }
  
  
}
