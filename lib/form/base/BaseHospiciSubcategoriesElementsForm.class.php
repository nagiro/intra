<?php

/**
 * HospiciSubcategoriesElements form base class.
 *
 * @method HospiciSubcategoriesElements getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseHospiciSubcategoriesElementsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'element_id'      => new sfWidgetFormInputHidden(),
      'subcategoria_id' => new sfWidgetFormInputHidden(),
      'tipus'           => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'element_id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->getElementId()), 'empty_value' => $this->getObject()->getElementId(), 'required' => false)),
      'subcategoria_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getSubcategoriaId()), 'empty_value' => $this->getObject()->getSubcategoriaId(), 'required' => false)),
      'tipus'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getTipus()), 'empty_value' => $this->getObject()->getTipus(), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('hospici_subcategories_elements[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciSubcategoriesElements';
  }


}
