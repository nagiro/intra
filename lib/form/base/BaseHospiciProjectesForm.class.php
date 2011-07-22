<?php

/**
 * HospiciProjectes form base class.
 *
 * @method HospiciProjectes getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseHospiciProjectesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'projecte_id' => new sfWidgetFormInputHidden(),
      'nom'         => new sfWidgetFormTextarea(),
      'descripcio'  => new sfWidgetFormTextarea(),
      'habilitat'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'projecte_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getProjecteId()), 'empty_value' => $this->getObject()->getProjecteId(), 'required' => false)),
      'nom'         => new sfValidatorString(),
      'descripcio'  => new sfValidatorString(),
      'habilitat'   => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('hospici_projectes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciProjectes';
  }


}
