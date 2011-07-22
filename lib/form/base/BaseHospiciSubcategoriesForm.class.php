<?php

/**
 * HospiciSubcategories form base class.
 *
 * @method HospiciSubcategories getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseHospiciSubcategoriesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'subcategoria_id' => new sfWidgetFormInputHidden(),
      'categoria_id'    => new sfWidgetFormInputText(),
      'nom'             => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'subcategoria_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getSubcategoriaId()), 'empty_value' => $this->getObject()->getSubcategoriaId(), 'required' => false)),
      'categoria_id'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'nom'             => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('hospici_subcategories[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HospiciSubcategories';
  }


}
