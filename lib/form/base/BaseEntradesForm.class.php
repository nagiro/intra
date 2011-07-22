<?php

/**
 * Entrades form base class.
 *
 * @method Entrades getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseEntradesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'idEntrada'  => new sfWidgetFormInputHidden(),
      'titol'      => new sfWidgetFormInputText(),
      'subtitol'   => new sfWidgetFormInputText(),
      'data'       => new sfWidgetFormInputText(),
      'lloc'       => new sfWidgetFormInputText(),
      'preu'       => new sfWidgetFormInputText(),
      'venudes'    => new sfWidgetFormInputText(),
      'recaptat'   => new sfWidgetFormInputText(),
      'localitats' => new sfWidgetFormInputText(),
      'site_id'    => new sfWidgetFormInputText(),
      'actiu'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'idEntrada'  => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdentrada()), 'empty_value' => $this->getObject()->getIdentrada(), 'required' => false)),
      'titol'      => new sfValidatorString(array('max_length' => 50)),
      'subtitol'   => new sfValidatorString(array('max_length' => 50)),
      'data'       => new sfValidatorString(array('max_length' => 50)),
      'lloc'       => new sfValidatorString(array('max_length' => 50)),
      'preu'       => new sfValidatorString(array('max_length' => 50)),
      'venudes'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'recaptat'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'localitats' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'site_id'    => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'actiu'      => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
    ));

    $this->widgetSchema->setNameFormat('entrades[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Entrades';
  }


}
