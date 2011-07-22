<?php

/**
 * Agendatelefonicadades form base class.
 *
 * @method Agendatelefonicadades getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAgendatelefonicadadesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'AgendaTelefonicaDadesID'             => new sfWidgetFormInputHidden(),
      'AgendaTelefonica_AgendaTelefonicaID' => new sfWidgetFormPropelChoice(array('model' => 'Agendatelefonica', 'add_empty' => false)),
      'Tipus'                               => new sfWidgetFormTextarea(),
      'Dada'                                => new sfWidgetFormTextarea(),
      'Notes'                               => new sfWidgetFormTextarea(),
      'site_id'                             => new sfWidgetFormInputText(),
      'actiu'                               => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'AgendaTelefonicaDadesID'             => new sfValidatorChoice(array('choices' => array($this->getObject()->getAgendatelefonicadadesid()), 'empty_value' => $this->getObject()->getAgendatelefonicadadesid(), 'required' => false)),
      'AgendaTelefonica_AgendaTelefonicaID' => new sfValidatorPropelChoice(array('model' => 'Agendatelefonica', 'column' => 'AgendaTelefonicaID')),
      'Tipus'                               => new sfValidatorString(array('required' => false)),
      'Dada'                                => new sfValidatorString(array('required' => false)),
      'Notes'                               => new sfValidatorString(array('required' => false)),
      'site_id'                             => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'                               => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('agendatelefonicadades[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Agendatelefonicadades';
  }


}
