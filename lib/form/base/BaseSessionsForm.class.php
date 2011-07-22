<?php

/**
 * Sessions form base class.
 *
 * @method Sessions getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseSessionsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'sess_id'   => new sfWidgetFormInputText(),
      'sess_data' => new sfWidgetFormTextarea(),
      'sess_time' => new sfWidgetFormInputText(),
      'id'        => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'sess_id'   => new sfValidatorString(array('max_length' => 64)),
      'sess_data' => new sfValidatorString(),
      'sess_time' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sessions[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Sessions';
  }


}
