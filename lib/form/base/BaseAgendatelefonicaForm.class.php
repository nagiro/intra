<?php

/**
 * Agendatelefonica form base class.
 *
 * @method Agendatelefonica getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAgendatelefonicaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'AgendaTelefonicaID' => new sfWidgetFormInputHidden(),
      'Nom'                => new sfWidgetFormInputText(),
      'NIF'                => new sfWidgetFormInputText(),
      'DataAlta'           => new sfWidgetFormDate(),
      'Notes'              => new sfWidgetFormTextarea(),
      'Tags'               => new sfWidgetFormInputText(),
      'Entitat'            => new sfWidgetFormInputText(),
      'site_id'            => new sfWidgetFormInputText(),
      'actiu'              => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'AgendaTelefonicaID' => new sfValidatorChoice(array('choices' => array($this->getObject()->getAgendatelefonicaid()), 'empty_value' => $this->getObject()->getAgendatelefonicaid(), 'required' => false)),
      'Nom'                => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'NIF'                => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'DataAlta'           => new sfValidatorDate(array('required' => false)),
      'Notes'              => new sfValidatorString(array('required' => false)),
      'Tags'               => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'Entitat'            => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'site_id'            => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'              => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('agendatelefonica[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Agendatelefonica';
  }


}
