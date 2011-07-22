<?php

/**
 * Cessiomaterial form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CessiomaterialForm extends sfFormPropel
{
	
  public function setup()
  {
    $this->setWidgets(array(
      'idCessioMaterial'    => new sfWidgetFormInputHidden(),
      'Material_idMaterial' => new sfWidgetFormChoice(array('choices'=>MaterialgenericPeer::selectMaterial())),
      'Cedita'              => new sfWidgetFormJQueryAutocompleter(array('url'=>$this->getOption('url')),array('width'=>'400px')),      
      'Estat'               => new sfWidgetFormTextarea(array(),array('style'=>'width:300px')),
      'DataCessio'          => new sfWidgetFormJQueryDate(array('format'=>'%day%/%month%/%year%'),array()),    
      'DataRetorn'          => new sfWidgetFormJQueryDate(array('format'=>'%day%/%month%/%year%'),array()),
      'Retornat'            => new sfWidgetFormInputHidden(array(),array()),
      'EstatRetornat'		=> new sfWidgetFormInputHidden(array(),array()),
      'DataRetornat'		=> new sfWidgetFormInputHidden(array(),array()),        
    ));

    $this->setValidators(array(
      'idCessioMaterial'    => new sfValidatorPropelChoice(array('model' => 'Cessiomaterial', 'column' => 'idCessioMaterial', 'required' => false)),
      'Material_idMaterial' => new sfValidatorPropelChoice(array('model' => 'Material', 'column' => 'idMaterial')),
      'Cedita'              => new sfValidatorString(array('required'=>true)),
      'DataCessio'          => new sfValidatorDate(array('required' => false)),
      'DataRetorn'          => new sfValidatorDate(array('required' => false)),
      'Estat'               => new sfValidatorString(array('required' => false)),
      'Retornat'            => new sfValidatorBoolean(array('required' => false)),
      'EstatRetornat'       => new sfValidatorString(array('required' => false)),
      'DataRetornat'		=> new sfValidatorDate(array('required'=>false)),    
    ));

    $this->widgetSchema->setLabels(array(      
      'Material_idMaterial' => 'Material: ',
      'Cedita'              => 'Cedit a:', 
      'DataCessio'          => 'Data de cessiÃ³: ',
      'DataRetorn'          => 'Data de retorn: ',
      'Estat'               => 'Observacions: ',      
    ));           
    
    $this->widgetSchema->setNameFormat('cessiomaterial[%s]');
    $this->widgetSchema->setFormFormatterName('Span');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
   
  }

  public function getModelName()
  {
    return 'Cessiomaterial';
  }

}
