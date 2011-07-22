<?php

/**
 * ArxiuDvd form base class.
 *
 * @method ArxiuDvd getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseArxiuDvdForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'tipus'        => new sfWidgetFormInputText(),
      'volum'        => new sfWidgetFormInputText(),
      'url'          => new sfWidgetFormTextarea(),
      'nom'          => new sfWidgetFormTextarea(),
      'data_creacio' => new sfWidgetFormDateTime(),
      'comentari'    => new sfWidgetFormTextarea(),
      'site_id'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'tipus'        => new sfValidatorString(array('max_length' => 30)),
      'volum'        => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'url'          => new sfValidatorString(array('required' => false)),
      'nom'          => new sfValidatorString(array('required' => false)),
      'data_creacio' => new sfValidatorDateTime(array('required' => false)),
      'comentari'    => new sfValidatorString(array('required' => false)),
      'site_id'      => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('arxiu_dvd[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ArxiuDvd';
  }


}
