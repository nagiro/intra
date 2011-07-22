<?php

/**
 * EspaisExterns form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 */
class EspaisExternsForm extends BaseEspaisExternsForm
{
    
  public function setup()
  {
    $this->setWidgets(array(
      'idEspaiextern' => new sfWidgetFormInputHidden(),
      'Poble'         => new sfWidgetFormChoice(array('choices'=>PoblacionsPeer::select())),
      'Nom'           => new sfWidgetFormInput(array(),array('style'=>'width:400px;')),
      'Adreca'        => new sfWidgetFormInput(array(),array('style'=>'width:400px;')),
      'Contacte'      => new sfWidgetFormInput(array(),array('style'=>'width:400px;')),
    ));

    $this->setValidators(array(
      'idEspaiextern' => new sfValidatorChoice(array('choices' => array($this->getObject()->getIdespaiextern()), 'empty_value' => $this->getObject()->getIdespaiextern(), 'required' => false)),
      'Poble'         => new sfValidatorPropelChoice(array('model' => 'Poblacions', 'column' => 'idPoblacio')),
      'Nom'           => new sfValidatorString(),
      'Adreca'        => new sfValidatorString(),
      'Contacte'      => new sfValidatorString(array('required'=>false)),
    ));

    $this->widgetSchema->setNameFormat('espais_externs[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    
    $this->widgetSchema->setFormFormatterName('Span');
    
    $this->widgetSchema->setLabels(array(      
      'Poble'         => 'PoblaciÃ³: ',
      'Nom'           => 'Entitat: ',
      'Adreca'        => 'AdreÃ§a: ',
      'Contacte'      => 'Contacte: ',        
    ));
        
  }

  public function getModelName()
  {
    return 'EspaisExterns';
  }
  
}
