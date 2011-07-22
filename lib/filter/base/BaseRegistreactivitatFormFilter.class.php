<?php

/**
 * Registreactivitat filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseRegistreactivitatFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Timestamp' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'Accio'     => new sfWidgetFormFilterInput(),
      'Dades'     => new sfWidgetFormFilterInput(),
      'idUsuari'  => new sfWidgetFormFilterInput(),
      'Taula'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'Timestamp' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'Accio'     => new sfValidatorPass(array('required' => false)),
      'Dades'     => new sfValidatorPass(array('required' => false)),
      'idUsuari'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'Taula'     => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('registreactivitat_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Registreactivitat';
  }

  public function getFields()
  {
    return array(
      'LogID'     => 'Number',
      'Timestamp' => 'Date',
      'Accio'     => 'Text',
      'Dades'     => 'Text',
      'idUsuari'  => 'Number',
      'Taula'     => 'Text',
    );
  }
}
