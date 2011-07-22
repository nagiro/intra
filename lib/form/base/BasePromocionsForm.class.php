<?php

/**
 * Promocions form base class.
 *
 * @method Promocions getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePromocionsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'PromocioID' => new sfWidgetFormInputHidden(),
      'Nom'        => new sfWidgetFormTextarea(),
      'Ordre'      => new sfWidgetFormInputText(),
      'Extensio'   => new sfWidgetFormTextarea(),
      'isActiva'   => new sfWidgetFormInputText(),
      'isFixa'     => new sfWidgetFormInputText(),
      'URL'        => new sfWidgetFormTextarea(),
      'site_id'    => new sfWidgetFormInputText(),
      'actiu'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'PromocioID' => new sfValidatorChoice(array('choices' => array($this->getObject()->getPromocioid()), 'empty_value' => $this->getObject()->getPromocioid(), 'required' => false)),
      'Nom'        => new sfValidatorString(array('required' => false)),
      'Ordre'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'Extensio'   => new sfValidatorString(array('required' => false)),
      'isActiva'   => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'isFixa'     => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'URL'        => new sfValidatorString(),
      'site_id'    => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'actiu'      => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('promocions[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Promocions';
  }


}
