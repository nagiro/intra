<?php

/**
 * Multimedia form base class.
 *
 * @method Multimedia getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseMultimediaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'multimedia_id' => new sfWidgetFormInputHidden(),
      'taula'         => new sfWidgetFormInputText(),
      'url'           => new sfWidgetFormTextarea(),
      'site_id'       => new sfWidgetFormInputText(),
      'actiu'         => new sfWidgetFormInputText(),
      'id_extern'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'multimedia_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getMultimediaId()), 'empty_value' => $this->getObject()->getMultimediaId(), 'required' => false)),
      'taula'         => new sfValidatorString(array('max_length' => 20)),
      'url'           => new sfValidatorString(),
      'site_id'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'actiu'         => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'id_extern'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
    ));

    $this->widgetSchema->setNameFormat('multimedia[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Multimedia';
  }


}
