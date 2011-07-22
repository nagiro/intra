<?php

/**
 * Material form.
 *
 * @package    intranet
 * @subpackage form
 * @author     Albert Johé i Martí
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class InformeActivitatsForm extends sfForm
{
	
  public function setup()
  {
  	$choices = array();
    $choices[''] = "No cercar cap cicle";
    $choices2 = CiclesPeer::getSelect($this->getOption('IDS'));    
    foreach($choices2 as $K=>$V) $choices[$K] = $V;
    unset($choices2);    
     
    
    $this->setWidgets(array(
      'idCicle'     => new sfWidgetFormChoice(array('choices'=>$choices)),                  
      'DataInici'   => new sfWidgetFormJQueryDate(array('format'=>'%day%/%month%/%year%'),array()),
      'DataFi'      => new sfWidgetFormJQueryDate(array('format'=>'%day%/%month%/%year%'),array()),      
    ));

    
    $this->setValidators(array(
      'idCicle'     => new sfValidatorPass(array('required'=>false)),                  
      'DataInici'   => new sfValidatorDate(array('required'=>false)),
      'DataFi'      => new sfValidatorDate(array('required'=>false)),      
    ));

    $this->widgetSchema->setLabels(array(
      'idCicle'     => 'Cicle: ',                  
      'DataInici'   => 'Data d\'inici: ',
      'DataFi'      => 'Data de fi: ',              
    ));
    
    $this->widgetSchema->setNameFormat('informe_activitats[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->widgetSchema->setFormFormatterName('Span');

  }

}
