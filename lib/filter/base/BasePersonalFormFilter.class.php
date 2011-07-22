<?php

/**
 * Personal filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BasePersonalFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idUsuari'       => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'idData'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'tipus'          => new sfWidgetFormFilterInput(),
      'text'           => new sfWidgetFormFilterInput(),
      'data_revisio'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'data_alta'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'data_baixa'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'usuariUpdateId' => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'site_id'        => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'idUsuari'       => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Usuaris', 'column' => 'UsuariID')),
      'idData'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'tipus'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'text'           => new sfValidatorPass(array('required' => false)),
      'data_revisio'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'data_alta'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'data_baixa'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'usuariUpdateId' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Usuaris', 'column' => 'UsuariID')),
      'site_id'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('personal_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Personal';
  }

  public function getFields()
  {
    return array(
      'idPersonal'     => 'Number',
      'idUsuari'       => 'ForeignKey',
      'idData'         => 'Date',
      'tipus'          => 'Number',
      'text'           => 'Text',
      'data_revisio'   => 'Date',
      'data_alta'      => 'Date',
      'data_baixa'     => 'Date',
      'usuariUpdateId' => 'ForeignKey',
      'site_id'        => 'Number',
    );
  }
}
