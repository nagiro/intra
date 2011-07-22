<?php

/**
 * Esborrats form base class.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseEsborratsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'EsborratID' => new sfWidgetFormInputHidden(),
      'Taula'      => new sfWidgetFormTextarea(),
      'Dades'      => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'EsborratID' => new sfValidatorPropelChoice(array('model' => 'Esborrats', 'column' => 'EsborratID', 'required' => false)),
      'Taula'      => new sfValidatorString(array('required' => false)),
      'Dades'      => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('esborrats[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Esborrats';
  }


}
