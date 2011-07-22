<?php

/**
 * HospiciSubcategoriesElements filter form base class.
 *
 * @package    intranet
 * @subpackage filter
 * @author     Albert Johé i Martí
 */
abstract class BaseHospiciSubcategoriesElementsFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('hospici_subcategories_elements_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciSubcategoriesElements';
  }

  public function getFields()
  {
    return array(
      'element_id'      => 'Number',
      'subcategoria_id' => 'Number',
      'tipus'           => 'Text',
    );
  }
}
