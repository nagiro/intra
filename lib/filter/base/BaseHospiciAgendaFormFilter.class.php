<?php

/**
 * HospiciAgenda filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseHospiciAgendaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'titol'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'text'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'data_inicial' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'data_final'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'lloc'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'hora_inicial' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'hora_final'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'link'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'ciutat'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'reserva'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'titol'        => new sfValidatorPass(array('required' => false)),
      'text'         => new sfValidatorPass(array('required' => false)),
      'data_inicial' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'data_final'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'lloc'         => new sfValidatorPass(array('required' => false)),
      'hora_inicial' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'hora_final'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'link'         => new sfValidatorPass(array('required' => false)),
      'ciutat'       => new sfValidatorPass(array('required' => false)),
      'reserva'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('hospici_agenda_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciAgenda';
  }

  public function getFields()
  {
    return array(
      'agenda_id'    => 'Number',
      'titol'        => 'Text',
      'text'         => 'Text',
      'data_inicial' => 'Date',
      'data_final'   => 'Date',
      'lloc'         => 'Text',
      'hora_inicial' => 'Date',
      'hora_final'   => 'Date',
      'link'         => 'Text',
      'ciutat'       => 'Text',
      'reserva'      => 'Number',
    );
  }
}
