<?php

/**
 * Options form base class.
 *
 * @method Options getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseOptionsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'option_id' => new sfWidgetFormInputHidden(),
      'site_id'   => new sfWidgetFormInputHidden(),
      'valor'     => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'option_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getOptionId()), 'empty_value' => $this->getObject()->getOptionId(), 'required' => false)),
      'site_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->getSiteId()), 'empty_value' => $this->getObject()->getSiteId(), 'required' => false)),
      'valor'     => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('options[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Options';
  }


}
