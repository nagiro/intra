<?php

/**
 * Chat form base class.
 *
 * @method Chat getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseChatForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'from'    => new sfWidgetFormInputText(),
      'to'      => new sfWidgetFormInputText(),
      'message' => new sfWidgetFormTextarea(),
      'sent'    => new sfWidgetFormDateTime(),
      'recd'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'from'    => new sfValidatorString(array('max_length' => 255)),
      'to'      => new sfValidatorString(array('max_length' => 255)),
      'message' => new sfValidatorString(),
      'sent'    => new sfValidatorDateTime(),
      'recd'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));

    $this->widgetSchema->setNameFormat('chat[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Chat';
  }


}
