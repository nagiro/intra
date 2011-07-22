<?php

/**
 * Horaris filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseHorarisFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Activitats_ActivitatID' => new sfWidgetFormPropelChoice(array('model' => 'Activitats', 'add_empty' => true)),
      'Dia'                    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'HoraInici'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'HoraFi'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'HoraPre'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'HoraPost'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'Avis'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'Espectadors'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'Places'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'Titol'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'Preu'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'PreuR'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'Estat'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'Responsable'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'site_id'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'Activitats_ActivitatID' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Activitats', 'column' => 'ActivitatID')),
      'Dia'                    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'HoraInici'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'HoraFi'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'HoraPre'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'HoraPost'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'Avis'                   => new sfValidatorPass(array('required' => false)),
      'Espectadors'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'Places'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'Titol'                  => new sfValidatorPass(array('required' => false)),
      'Preu'                   => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'PreuR'                  => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'Estat'                  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'Responsable'            => new sfValidatorPass(array('required' => false)),
      'site_id'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('horaris_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Horaris';
  }

  public function getFields()
  {
    return array(
      'HorarisID'              => 'Number',
      'Activitats_ActivitatID' => 'ForeignKey',
      'Dia'                    => 'Date',
      'HoraInici'              => 'Date',
      'HoraFi'                 => 'Date',
      'HoraPre'                => 'Date',
      'HoraPost'               => 'Date',
      'Avis'                   => 'Text',
      'Espectadors'            => 'Number',
      'Places'                 => 'Number',
      'Titol'                  => 'Text',
      'Preu'                   => 'Number',
      'PreuR'                  => 'Number',
      'Estat'                  => 'Number',
      'Responsable'            => 'Text',
      'site_id'                => 'Number',
    );
  }
}
