<?php

/**
 * Cessiomaterial form base class.
 *
 * @method Cessiomaterial getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseCessiomaterialForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idCessioMaterial'    => new sfWidgetFormInputHidden(),
      'Material_idMaterial' => new sfWidgetFormPropelChoice(array('model' => 'Material', 'add_empty' => false)),
      'cessio_id'           => new sfWidgetFormPropelChoice(array('model' => 'Cessio', 'add_empty' => false)),
      'site_id'             => new sfWidgetFormInputText(),
      'actiu'               => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idCessioMaterial'    => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdcessiomaterial()), 'empty_value' => $this->getObject()->getIdcessiomaterial(), 'required' => false)),
      'Material_idMaterial' => new sfValidatorPropelChoice(array('model' => 'Material', 'column' => 'idMaterial')),
      'cessio_id'           => new sfValidatorPropelChoice(array('model' => 'Cessio', 'column' => 'cessio_id')),
      'site_id'             => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'               => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('cessiomaterial[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Cessiomaterial';
  }


}
