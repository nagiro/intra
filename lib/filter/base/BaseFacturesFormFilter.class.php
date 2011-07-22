<?php

/**
 * Factures filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseFacturesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Proveidors_ProveidorID' => new sfWidgetFormPropelChoice(array('model' => 'Proveidors', 'add_empty' => true)),
      'Conceptes_ConcepteID'   => new sfWidgetFormPropelChoice(array('model' => 'Conceptes', 'add_empty' => true)),
      'DataFactura'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'Quantitat'              => new sfWidgetFormFilterInput(),
      'NumFactura'             => new sfWidgetFormFilterInput(),
      'DataPagament'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'ModalitatPagament'      => new sfWidgetFormFilterInput(),
      'SubConcepte'            => new sfWidgetFormFilterInput(),
      'TipusComptable'         => new sfWidgetFormFilterInput(),
      'Text'                   => new sfWidgetFormFilterInput(),
      'ValidaUsuari'           => new sfWidgetFormPropelChoice(array('model' => 'Usuaris', 'add_empty' => true)),
      'ValidatData'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'site_id'                => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'Proveidors_ProveidorID' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Proveidors', 'column' => 'ProveidorID')),
      'Conceptes_ConcepteID'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Conceptes', 'column' => 'ConcepteID')),
      'DataFactura'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'Quantitat'              => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'NumFactura'             => new sfValidatorPass(array('required' => false)),
      'DataPagament'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'ModalitatPagament'      => new sfValidatorPass(array('required' => false)),
      'SubConcepte'            => new sfValidatorPass(array('required' => false)),
      'TipusComptable'         => new sfValidatorPass(array('required' => false)),
      'Text'                   => new sfValidatorPass(array('required' => false)),
      'ValidaUsuari'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Usuaris', 'column' => 'UsuariID')),
      'ValidatData'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'site_id'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('factures_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Factures';
  }

  public function getFields()
  {
    return array(
      'FacturaID'              => 'Number',
      'Proveidors_ProveidorID' => 'ForeignKey',
      'Conceptes_ConcepteID'   => 'ForeignKey',
      'DataFactura'            => 'Date',
      'Quantitat'              => 'Number',
      'NumFactura'             => 'Text',
      'DataPagament'           => 'Date',
      'ModalitatPagament'      => 'Text',
      'SubConcepte'            => 'Text',
      'TipusComptable'         => 'Text',
      'Text'                   => 'Text',
      'ValidaUsuari'           => 'ForeignKey',
      'ValidatData'            => 'Date',
      'site_id'                => 'Number',
    );
  }
}
