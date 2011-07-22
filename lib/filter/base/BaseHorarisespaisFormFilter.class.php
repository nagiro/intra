<?php

/**
 * Horarisespais filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseHorarisespaisFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Material_idMaterial' => new sfWidgetFormPropelChoice(array('model' => 'Material', 'add_empty' => true)),
      'Espais_EspaiID'      => new sfWidgetFormPropelChoice(array('model' => 'Espais', 'add_empty' => true)),
      'Horaris_HorarisID'   => new sfWidgetFormPropelChoice(array('model' => 'Horaris', 'add_empty' => true)),
      'site_id'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'Material_idMaterial' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Material', 'column' => 'idMaterial')),
      'Espais_EspaiID'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Espais', 'column' => 'EspaiID')),
      'Horaris_HorarisID'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Horaris', 'column' => 'HorarisID')),
      'site_id'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('horarisespais_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Horarisespais';
  }

  public function getFields()
  {
    return array(
      'idHorarisEspais'     => 'Number',
      'Material_idMaterial' => 'ForeignKey',
      'Espais_EspaiID'      => 'ForeignKey',
      'Horaris_HorarisID'   => 'ForeignKey',
      'site_id'             => 'Number',
    );
  }
}
