<?php

/**
 * Nivells form base class.
 *
 * @method Nivells getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseNivellsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idNivells' => new sfWidgetFormInputHidden(),
      'Nom'       => new sfWidgetFormTextarea(),
      'site_id'   => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idNivells' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdnivells()), 'empty_value' => $this->getObject()->getIdnivells(), 'required' => false)),
      'Nom'       => new sfValidatorString(array('required' => false)),
      'site_id'   => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('nivells[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Nivells';
  }


}
