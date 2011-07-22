<?php

/**
 * Material filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseMaterialFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'MaterialGeneric_idMaterialGeneric' => new sfWidgetFormPropelChoice(array('model' => 'Materialgeneric', 'add_empty' => true)),
      'Nom'                               => new sfWidgetFormFilterInput(),
      'Descripcio'                        => new sfWidgetFormFilterInput(),
      'Responsable'                       => new sfWidgetFormFilterInput(),
      'Ubicacio'                          => new sfWidgetFormFilterInput(),
      'DataCompra'                        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'Identificador'                     => new sfWidgetFormFilterInput(),
      'NumSerie'                          => new sfWidgetFormFilterInput(),
      'DataGarantia'                      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'DataRevisio'                       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'Cedit'                             => new sfWidgetFormFilterInput(),
      'DataCessio'                        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'DataRetorn'                        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'NumFactura'                        => new sfWidgetFormFilterInput(),
      'Preu'                              => new sfWidgetFormFilterInput(),
      'NotesManteniment'                  => new sfWidgetFormFilterInput(),
      'DataBaixa'                         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'DataReparacio'                     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'Disponible'                        => new sfWidgetFormFilterInput(),
      'AltaRegistre'                      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'isTransferible'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'isAdministratiu'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'site_id'                           => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'MaterialGeneric_idMaterialGeneric' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Materialgeneric', 'column' => 'idMaterialGeneric')),
      'Nom'                               => new sfValidatorPass(array('required' => false)),
      'Descripcio'                        => new sfValidatorPass(array('required' => false)),
      'Responsable'                       => new sfValidatorPass(array('required' => false)),
      'Ubicacio'                          => new sfValidatorPass(array('required' => false)),
      'DataCompra'                        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'Identificador'                     => new sfValidatorPass(array('required' => false)),
      'NumSerie'                          => new sfValidatorPass(array('required' => false)),
      'DataGarantia'                      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'DataRevisio'                       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'Cedit'                             => new sfValidatorPass(array('required' => false)),
      'DataCessio'                        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'DataRetorn'                        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'NumFactura'                        => new sfValidatorPass(array('required' => false)),
      'Preu'                              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'NotesManteniment'                  => new sfValidatorPass(array('required' => false)),
      'DataBaixa'                         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'DataReparacio'                     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'Disponible'                        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'AltaRegistre'                      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'isTransferible'                    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'isAdministratiu'                   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'site_id'                           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('material_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Material';
  }

  public function getFields()
  {
    return array(
      'idMaterial'                        => 'Number',
      'MaterialGeneric_idMaterialGeneric' => 'ForeignKey',
      'Nom'                               => 'Text',
      'Descripcio'                        => 'Text',
      'Responsable'                       => 'Text',
      'Ubicacio'                          => 'Text',
      'DataCompra'                        => 'Date',
      'Identificador'                     => 'Text',
      'NumSerie'                          => 'Text',
      'DataGarantia'                      => 'Date',
      'DataRevisio'                       => 'Date',
      'Cedit'                             => 'Text',
      'DataCessio'                        => 'Date',
      'DataRetorn'                        => 'Date',
      'NumFactura'                        => 'Text',
      'Preu'                              => 'Number',
      'NotesManteniment'                  => 'Text',
      'DataBaixa'                         => 'Date',
      'DataReparacio'                     => 'Date',
      'Disponible'                        => 'Number',
      'AltaRegistre'                      => 'Date',
      'isTransferible'                    => 'Number',
      'isAdministratiu'                   => 'Number',
      'site_id'                           => 'Number',
    );
  }
}
