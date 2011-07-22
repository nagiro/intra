<?php

/**
 * HospiciEntitatElements form base class.
 *
 * @method HospiciEntitatElements getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseHospiciEntitatElementsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'element_id' => new sfWidgetFormInputHidden(),
      'tipus'      => new sfWidgetFormInputHidden(),
      'entitat_id' => new sfWidgetFormInputHidden(),
      'nivell'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'element_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getElementId()), 'empty_value' => $this->getObject()->getElementId(), 'required' => false)),
      'tipus'      => new sfValidatorChoice(array('choices' => array($this->getObject()->getTipus()), 'empty_value' => $this->getObject()->getTipus(), 'required' => false)),
      'entitat_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getEntitatId()), 'empty_value' => $this->getObject()->getEntitatId(), 'required' => false)),
      'nivell'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('hospici_entitat_elements[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciEntitatElements';
  }


}
