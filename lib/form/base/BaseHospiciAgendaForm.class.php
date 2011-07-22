<?php

/**
 * HospiciAgenda form base class.
 *
 * @method HospiciAgenda getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseHospiciAgendaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'agenda_id'    => new sfWidgetFormInputHidden(),
      'titol'        => new sfWidgetFormTextarea(),
      'text'         => new sfWidgetFormTextarea(),
      'data_inicial' => new sfWidgetFormDate(),
      'data_final'   => new sfWidgetFormDate(),
      'lloc'         => new sfWidgetFormTextarea(),
      'hora_inicial' => new sfWidgetFormTime(),
      'hora_final'   => new sfWidgetFormTime(),
      'link'         => new sfWidgetFormTextarea(),
      'ciutat'       => new sfWidgetFormTextarea(),
      'reserva'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'agenda_id'    => new sfValidatorChoice(array('choices' => array($this->getObject()->getAgendaId()), 'empty_value' => $this->getObject()->getAgendaId(), 'required' => false)),
      'titol'        => new sfValidatorString(),
      'text'         => new sfValidatorString(),
      'data_inicial' => new sfValidatorDate(),
      'data_final'   => new sfValidatorDate(),
      'lloc'         => new sfValidatorString(),
      'hora_inicial' => new sfValidatorTime(),
      'hora_final'   => new sfValidatorTime(),
      'link'         => new sfValidatorString(),
      'ciutat'       => new sfValidatorString(),
      'reserva'      => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('hospici_agenda[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciAgenda';
  }


}
