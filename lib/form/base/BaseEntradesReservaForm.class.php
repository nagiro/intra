<?php

/**
 * EntradesReserva form base class.
 *
 * @method EntradesReserva getObject() Returns the current form's model object
 *
 * @package    intranet
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseEntradesReservaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'entrades_reserva_id' => new sfWidgetFormInputHidden(),
      'usuari_id'           => new sfWidgetFormInputText(),
      'activitats_id'       => new sfWidgetFormInputText(),
      'quantes'             => new sfWidgetFormInputText(),
      'data'                => new sfWidgetFormDateTime(),
      'estat'               => new sfWidgetFormInputText(),
      'actiu'               => new sfWidgetFormInputText(),
      'site_id'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'entrades_reserva_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getEntradesReservaId()), 'empty_value' => $this->getObject()->getEntradesReservaId(), 'required' => false)),
      'usuari_id'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'activitats_id'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'quantes'             => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'data'                => new sfValidatorDateTime(array('required' => false)),
      'estat'               => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'actiu'               => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'site_id'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('entrades_reserva[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'EntradesReserva';
  }


}
