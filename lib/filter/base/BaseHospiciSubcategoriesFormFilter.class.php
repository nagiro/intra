<?php

/**
 * HospiciSubcategories filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseHospiciSubcategoriesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'categoria_id'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nom'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'categoria_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'nom'             => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('hospici_subcategories_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciSubcategories';
  }

  public function getFields()
  {
    return array(
      'subcategoria_id' => 'Number',
      'categoria_id'    => 'Number',
      'nom'             => 'Text',
    );
  }
}
