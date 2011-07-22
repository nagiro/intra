<?php

/**
 * HospiciEntitats form base class.
 *
 * @method HospiciEntitats getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseHospiciEntitatsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'entitat_id' => new sfWidgetFormInputHidden(),
      'nom'        => new sfWidgetFormTextarea(),
      'descripcio' => new sfWidgetFormTextarea(),
      'habilitat'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'entitat_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getEntitatId()), 'empty_value' => $this->getObject()->getEntitatId(), 'required' => false)),
      'nom'        => new sfValidatorString(),
      'descripcio' => new sfValidatorString(),
      'habilitat'  => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('hospici_entitats[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciEntitats';
  }


}
