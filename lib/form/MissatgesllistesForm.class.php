<?php

/**
 * Missatgesllistes form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class MissatgesllistesForm extends sfFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idMissatgesLlistes' => new sfWidgetFormInputHidden(),
      'Llistes_idLlistes'  => new sfWidgetFormChoice(array('choices'=>LlistesPeer::select($this->getOption('IDS')))),
      'Enviat'			   => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'idMissatgesLlistes' => new sfValidatorPropelChoice(array('model' => 'Missatgesllistes', 'column' => 'idMissatgesLlistes', 'required' => false)),
      'Llistes_idLlistes'  => new sfValidatorPropelChoice(array('model' => 'Llistes', 'column' => 'idLlistes')),
      'Enviat'			   => new sfValidatorDate(),          
    ));

    $this->widgetSchema->setNameFormat('missatgesllistes[%s]');
    
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
  }

  public function getModelName()
  {
    return 'Missatgesllistes';
  }

}
