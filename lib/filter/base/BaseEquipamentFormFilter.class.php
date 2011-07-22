<?php

/**
 * Equipament filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseEquipamentFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Factures_FacturaID' => new sfWidgetFormPropelChoice(array('model' => 'Factures', 'add_empty' => true)),
      'Tipus'              => new sfWidgetFormFilterInput(),
      'DataCompra'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'Dades'              => new sfWidgetFormFilterInput(),
      'site_id'            => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'Factures_FacturaID' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Factures', 'column' => 'FacturaID')),
      'Tipus'              => new sfValidatorPass(array('required' => false)),
      'DataCompra'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'Dades'              => new sfValidatorPass(array('required' => false)),
      'site_id'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('equipament_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Equipament';
  }

  public function getFields()
  {
    return array(
      'EquipamentID'       => 'Number',
      'Factures_FacturaID' => 'ForeignKey',
      'Tipus'              => 'Text',
      'DataCompra'         => 'Date',
      'Dades'              => 'Text',
      'site_id'            => 'Number',
    );
  }
}
