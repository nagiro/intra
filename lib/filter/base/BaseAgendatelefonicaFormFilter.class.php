<?php

/**
 * Agendatelefonica filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseAgendatelefonicaFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Nom'                => new sfWidgetFormFilterInput(),
      'NIF'                => new sfWidgetFormFilterInput(),
      'DataAlta'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'Notes'              => new sfWidgetFormFilterInput(),
      'Tags'               => new sfWidgetFormFilterInput(),
      'Entitat'            => new sfWidgetFormFilterInput(),
      'site_id'            => new sfWidgetFormFilterInput(),
      'actiu'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'Nom'                => new sfValidatorPass(array('required' => false)),
      'NIF'                => new sfValidatorPass(array('required' => false)),
      'DataAlta'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'Notes'              => new sfValidatorPass(array('required' => false)),
      'Tags'               => new sfValidatorPass(array('required' => false)),
      'Entitat'            => new sfValidatorPass(array('required' => false)),
      'site_id'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'actiu'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('agendatelefonica_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Agendatelefonica';
  }

  public function getFields()
  {
    return array(
      'AgendaTelefonicaID' => 'Number',
      'Nom'                => 'Text',
      'NIF'                => 'Text',
      'DataAlta'           => 'Date',
      'Notes'              => 'Text',
      'Tags'               => 'Text',
      'Entitat'            => 'Text',
      'site_id'            => 'Number',
      'actiu'              => 'Number',
    );
  }
}
