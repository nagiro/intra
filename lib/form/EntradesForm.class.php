<?php

/**
 * Entrades form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 */
class EntradesForm extends sfFormPropel
{

  public function setup()
  {
    $this->setWidgets(array(
      'idEntrada' => new sfWidgetFormInputHidden(),
      'titol'     => new sfWidgetFormInputText(array(),array('style'=>'width:400px;')),
      'subtitol'  => new sfWidgetFormInputText(array(),array('style'=>'width:400px;')),
      'data'      => new sfWidgetFormInputText(array(),array('style'=>'width:400px;')),
      'lloc'      => new sfWidgetFormInputText(array(),array('style'=>'width:400px;')),
      'preu'      => new sfWidgetFormInputText(array(),array('style'=>'width:400px;')),
      'venudes'   => new sfWidgetFormInputText(array(),array('style'=>'width:100px;')),
      'recaptat'  => new sfWidgetFormInputText(array(),array('style'=>'width:100px;')),
      'localitats'=> new sfWidgetFormInputText(array(),array('style'=>'width:100px;')),
    ));

    $this->setValidators(array(
      'idEntrada' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdentrada()), 'empty_value' => $this->getObject()->getIdentrada(), 'required' => false)),
      'titol'     => new sfValidatorString(array('max_length' => 50)),
      'subtitol'  => new sfValidatorString(array('max_length' => 50)),
      'data'      => new sfValidatorString(array('max_length' => 50)),
      'lloc'      => new sfValidatorString(array('max_length' => 50)),
      'preu'      => new sfValidatorString(array('max_length' => 50)),
      'venudes'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'recaptat'  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'localitats'=> new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),      
    ));

    $this->widgetSchema->setLabels(array(      
      'titol'     => 'TÃ­tol',
      'subtitol'  => 'SubtÃ­tol',
      'data'      => 'Data',
      'lloc'      => 'Lloc',
      'preu'      => 'Preu',
      'venudes'   => 'Venudes',
      'recaptat'  => 'Recaptat',
      'localitats'=> 'Localitats',
    ));
    
    
    $this->widgetSchema->setNameFormat('entrades[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->widgetSchema->setFormFormatterName('Span');
    
  }

  public function getModelName()
  {
    return 'Entrades';
  }
	
	
}
