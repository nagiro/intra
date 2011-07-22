<?php

/**
 * Missatgesllistes form base class.
 *
 * @method Missatgesllistes getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseMissatgesllistesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idMissatgesLlistes' => new sfWidgetFormInputHidden(),
      'Llistes_idLlistes'  => new sfWidgetFormInputHidden(),
      'Enviat'             => new sfWidgetFormDate(),
      'site_id'            => new sfWidgetFormInputText(),
      'actiu'              => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idMissatgesLlistes' => new sfValidatorPropelChoice(array('model' => 'Missatgesmailing', 'column' => 'idMissatge', 'required' => false)),
      'Llistes_idLlistes'  => new sfValidatorPropelChoice(array('model' => 'Llistes', 'column' => 'idLlistes', 'required' => false)),
      'Enviat'             => new sfValidatorDate(array('required' => false)),
      'site_id'            => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'actiu'              => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('missatgesllistes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Missatgesllistes';
  }


}
