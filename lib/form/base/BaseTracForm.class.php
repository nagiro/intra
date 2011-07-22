<?php

/**
 * Trac form base class.
 *
 * @method Trac getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTracForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idTrac'         => new sfWidgetFormInputHidden(),
      'title'          => new sfWidgetFormTextarea(),
      'description'    => new sfWidgetFormTextarea(),
      'type'           => new sfWidgetFormInputText(),
      'solved_version' => new sfWidgetFormInputText(),
      'importancy'     => new sfWidgetFormInputText(),
      'usuari_id'      => new sfWidgetFormInputText(),
      'site_id'        => new sfWidgetFormInputText(),
      'actiu'          => new sfWidgetFormInputText(),
      'date'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'idTrac'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdtrac()), 'empty_value' => $this->getObject()->getIdtrac(), 'required' => false)),
      'title'          => new sfValidatorString(),
      'description'    => new sfValidatorString(),
      'type'           => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'solved_version' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'importancy'     => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'usuari_id'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'site_id'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'actiu'          => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'date'           => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('trac[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Trac';
  }


}
