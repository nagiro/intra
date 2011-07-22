<?php

/**
 * Registreactivitat form base class.
 *
 * @method Registreactivitat getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseRegistreactivitatForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'LogID'     => new sfWidgetFormInputHidden(),
      'Timestamp' => new sfWidgetFormDateTime(),
      'Accio'     => new sfWidgetFormTextarea(),
      'Dades'     => new sfWidgetFormTextarea(),
      'idUsuari'  => new sfWidgetFormInputText(),
      'Taula'     => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'LogID'     => new sfValidatorChoice(array('choices' => array($this->getObject()->getLogid()), 'empty_value' => $this->getObject()->getLogid(), 'required' => false)),
      'Timestamp' => new sfValidatorDateTime(array('required' => false)),
      'Accio'     => new sfValidatorString(array('required' => false)),
      'Dades'     => new sfValidatorString(array('required' => false)),
      'idUsuari'  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'Taula'     => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('registreactivitat[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Registreactivitat';
  }


}
