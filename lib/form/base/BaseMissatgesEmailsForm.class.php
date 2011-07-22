<?php

/**
 * MissatgesEmails form base class.
 *
 * @method MissatgesEmails getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseMissatgesEmailsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idLlista' => new sfWidgetFormInputHidden(),
      'email'    => new sfWidgetFormInputHidden(),
      'site_id'  => new sfWidgetFormInputText(),
      'actiu'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idLlista' => new sfValidatorPropelChoice(array('model' => 'Llistes', 'column' => 'idLlistes', 'required' => false)),
      'email'    => new sfValidatorChoice(array('choices' => array($this->getObject()->getEmail()), 'empty_value' => $this->getObject()->getEmail(), 'required' => false)),
      'site_id'  => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'    => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('missatges_emails[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'MissatgesEmails';
  }


}
