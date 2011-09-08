<?php

/**
 * EntradesReserva form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 */
class EntradesReservaForm extends BaseEntradesReservaForm
{
        
  public function setup()
  {
    $this->setWidgets(array(
      'entrades_reserva_id' => new sfWidgetFormInputHidden(),
      'usuari_id'           => new sfWidgetFormInputHidden(),
      'activitats_id'       => new sfWidgetFormInputHidden(),
      'quantes'             => new sfWidgetFormInputText(),
      'data'                => new sfWidgetFormInputHidden(),
      'estat'               => new sfWidgetFormChoice(array('choices'=>array(EntradesReservaPeer::CONFIRMADA=>'Confirmada', EntradesReservaPeer::ANULADA=>'Anul·lada'))),
      'actiu'               => new sfWidgetFormInputHidden(),
      'site_id'             => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'entrades_reserva_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->getEntradesReservaId()), 'empty_value' => $this->getObject()->getEntradesReservaId(), 'required' => false)),
      'usuari_id'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'activitats_id'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'quantes'             => new sfValidatorInteger(array('min' => -32768, 'max' => 32767, 'required' => false)),
      'data'                => new sfValidatorDateTime(array('required' => false)),
      'estat'               => new sfValidatorPass(),
      'actiu'               => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'site_id'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('entrades_reserva[%s]');
    $this->widgetSchema->setFormFormatterName('Span');
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

  }

}
