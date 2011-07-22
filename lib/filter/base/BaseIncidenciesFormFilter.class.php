<?php

/**
 * Incidencies filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseIncidenciesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'quiinforma'    => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'quiresol'      => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'titol'         => new sfWidgetFormFilterInput(),
      'descripcio'    => new sfWidgetFormFilterInput(),
      'estat'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'dataalta'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'dataresolucio' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'site_id'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'quiinforma'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Usuaris', 'column' => 'UsuariID')),
      'quiresol'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Usuaris', 'column' => 'UsuariID')),
      'titol'         => new sfValidatorPass(array('required' => false)),
      'descripcio'    => new sfValidatorPass(array('required' => false)),
      'estat'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'dataalta'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'dataresolucio' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'site_id'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('incidencies_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Incidencies';
  }

  public function getFields()
  {
    return array(
      'idIncidencia'  => 'Number',
      'quiinforma'    => 'ForeignKey',
      'quiresol'      => 'ForeignKey',
      'titol'         => 'Text',
      'descripcio'    => 'Text',
      'estat'         => 'Number',
      'dataalta'      => 'Date',
      'dataresolucio' => 'Date',
      'site_id'       => 'Number',
    );
  }
}
