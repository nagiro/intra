<?php

/**
 * Formularis form base class.
 *
 * @method Formularis getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseFormularisForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idFormularis' => new sfWidgetFormInputHidden(),
      'nom'          => new sfWidgetFormInputText(),
      'descripcio'   => new sfWidgetFormTextarea(),
      'formulari'    => new sfWidgetFormTextarea(),
      'site_id'      => new sfWidgetFormInputText(),
      'actiu'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idFormularis' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdformularis()), 'empty_value' => $this->getObject()->getIdformularis(), 'required' => false)),
      'nom'          => new sfValidatorString(array('max_length' => 200)),
      'descripcio'   => new sfValidatorString(),
      'formulari'    => new sfValidatorString(),
      'site_id'      => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'actiu'        => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('formularis[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Formularis';
  }


}
