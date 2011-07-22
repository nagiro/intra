<?php

/**
 * Cessio filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseCessioFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'site_id'                 => new sfWidgetFormFilterInput(),
      'usuari_id'               => new sfWidgetFormFilterInput(),
      'nom'                     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'dni'                     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'representant'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'motiu'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'condicions'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'material_no_inventariat' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'data_cessio'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'data_retorn'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'estat'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'retornat'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'estat_retornat'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'data_retornat'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'site_id'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'usuari_id'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'nom'                     => new sfValidatorPass(array('required' => false)),
      'dni'                     => new sfValidatorPass(array('required' => false)),
      'representant'            => new sfValidatorPass(array('required' => false)),
      'motiu'                   => new sfValidatorPass(array('required' => false)),
      'condicions'              => new sfValidatorPass(array('required' => false)),
      'material_no_inventariat' => new sfValidatorPass(array('required' => false)),
      'data_cessio'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'data_retorn'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'estat'                   => new sfValidatorPass(array('required' => false)),
      'retornat'                => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'estat_retornat'          => new sfValidatorPass(array('required' => false)),
      'data_retornat'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('cessio_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cessio';
  }

  public function getFields()
  {
    return array(
      'cessio_id'               => 'Number',
      'site_id'                 => 'Number',
      'usuari_id'               => 'Number',
      'nom'                     => 'Text',
      'dni'                     => 'Text',
      'representant'            => 'Text',
      'motiu'                   => 'Text',
      'condicions'              => 'Text',
      'material_no_inventariat' => 'Text',
      'data_cessio'             => 'Date',
      'data_retorn'             => 'Date',
      'estat'                   => 'Text',
      'retornat'                => 'Number',
      'estat_retornat'          => 'Text',
      'data_retornat'           => 'Date',
    );
  }
}
