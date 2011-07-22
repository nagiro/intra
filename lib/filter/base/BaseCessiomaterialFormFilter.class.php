<?php

/**
 * Cessiomaterial filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseCessiomaterialFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Material_idMaterial' => new sfWidgetFormPropelChoice(array('model' => 'Material', 'add_empty' => true)),
      'cessio_id'           => new sfWidgetFormPropelChoice(array('model' => 'Cessio', 'add_empty' => true)),
      'site_id'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'Material_idMaterial' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Material', 'column' => 'idMaterial')),
      'cessio_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Cessio', 'column' => 'cessio_id')),
      'site_id'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('cessiomaterial_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cessiomaterial';
  }

  public function getFields()
  {
    return array(
      'idCessioMaterial'    => 'Number',
      'Material_idMaterial' => 'ForeignKey',
      'cessio_id'           => 'ForeignKey',
      'site_id'             => 'Number',
    );
  }
}
