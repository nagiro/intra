<?php

/**
 * MissatgesUsuaris form base class.
 *
 * @method MissatgesUsuaris getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseMissatgesUsuarisForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idLlista' => new sfWidgetFormInputHidden(),
      'email'    => new sfWidgetFormInputHidden(),
      'data'     => new sfWidgetFormDateTime(),
      'site_id'  => new sfWidgetFormInputText(),
      'actiu'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idLlista' => new sfValidatorPropelChoice(array('model' => 'Llistes', 'column' => 'idLlistes', 'required' => false)),
      'email'    => new sfValidatorChoice(array('choices' => array($this->getObject()->getEmail()), 'empty_value' => $this->getObject()->getEmail(), 'required' => false)),
      'data'     => new sfValidatorDateTime(array('required' => false)),
      'site_id'  => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'    => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('missatges_usuaris[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'MissatgesUsuaris';
  }


}
