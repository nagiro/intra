<?php

/**
 * Registreentrada form base class.
 *
 * @method Registreentrada getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseRegistreentradaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'RegistreEntradaID' => new sfWidgetFormInputHidden(),
      'Projecte'          => new sfWidgetFormInputText(),
      'Dades'             => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'RegistreEntradaID' => new sfValidatorChoice(array('choices' => array($this->getObject()->getRegistreentradaid()), 'empty_value' => $this->getObject()->getRegistreentradaid(), 'required' => false)),
      'Projecte'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'Dades'             => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('registreentrada[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Registreentrada';
  }


}
