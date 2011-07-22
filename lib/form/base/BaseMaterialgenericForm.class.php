<?php

/**
 * Materialgeneric form base class.
 *
 * @method Materialgeneric getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseMaterialgenericForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idMaterialGeneric' => new sfWidgetFormInputHidden(),
      'Nom'               => new sfWidgetFormTextarea(),
      'site_id'           => new sfWidgetFormInputText(),
      'actiu'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idMaterialGeneric' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdmaterialgeneric()), 'empty_value' => $this->getObject()->getIdmaterialgeneric(), 'required' => false)),
      'Nom'               => new sfValidatorString(array('required' => false)),
      'site_id'           => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'             => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('materialgeneric[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Materialgeneric';
  }


}
