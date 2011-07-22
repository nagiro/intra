<?php

/**
 * Proveidors form base class.
 *
 * @method Proveidors getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseProveidorsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'ProveidorID' => new sfWidgetFormInputHidden(),
      'NIF'         => new sfWidgetFormInputText(),
      'Nom'         => new sfWidgetFormTextarea(),
      'Telefon'     => new sfWidgetFormInputText(),
      'CE'          => new sfWidgetFormInputText(),
      'CC'          => new sfWidgetFormInputText(),
      'CP'          => new sfWidgetFormInputText(),
      'Adreca'      => new sfWidgetFormTextarea(),
      'Alta'        => new sfWidgetFormDate(),
      'Ciutat'      => new sfWidgetFormTextarea(),
      'site_id'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'ProveidorID' => new sfValidatorChoice(array('choices' => array($this->getObject()->getProveidorid()), 'empty_value' => $this->getObject()->getProveidorid(), 'required' => false)),
      'NIF'         => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'Nom'         => new sfValidatorString(array('required' => false)),
      'Telefon'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'CE'          => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'CC'          => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'CP'          => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'Adreca'      => new sfValidatorString(array('required' => false)),
      'Alta'        => new sfValidatorDate(array('required' => false)),
      'Ciutat'      => new sfValidatorString(array('required' => false)),
      'site_id'     => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('proveidors[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Proveidors';
  }


}
