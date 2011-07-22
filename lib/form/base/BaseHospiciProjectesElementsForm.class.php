<?php

/**
 * HospiciProjectesElements form base class.
 *
 * @method HospiciProjectesElements getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseHospiciProjectesElementsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'element_id'  => new sfWidgetFormInputHidden(),
      'tipus'       => new sfWidgetFormInputHidden(),
      'projecte_id' => new sfWidgetFormInputHidden(),
      'nivell'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'element_id'  => new sfValidatorChoice(array('choices' => array($this->getObject()->getElementId()), 'empty_value' => $this->getObject()->getElementId(), 'required' => false)),
      'tipus'       => new sfValidatorChoice(array('choices' => array($this->getObject()->getTipus()), 'empty_value' => $this->getObject()->getTipus(), 'required' => false)),
      'projecte_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getProjecteId()), 'empty_value' => $this->getObject()->getProjecteId(), 'required' => false)),
      'nivell'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('hospici_projectes_elements[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciProjectesElements';
  }


}
